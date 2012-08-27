<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

/**
 * Facade pour les produits
 */
class myshop_shelf
{
	private $handlers;

	function __construct()
	{
		$this->initHandlers();
	}

	/**
	 * Chargement des handlers
	 */
	private function initHandlers()
	{
		$this->handlers = myshop_handler::getInstance();
	}

	/**
	 * Retourne le nombre de produits d'un certain type
	 *
	 * @param string $type	Le type de produits dont on veut récupérer le nombre
	 */
	function getProductsCount($type = 'recent', $category = 0, $excluded = 0)
	{
		switch(strtolower($type)) {
			case 'recent':
				return $this->handlers->h_myshop_products->getRecentProductsCount($category, $excluded);
				break;
		}
		return 0;
	}

	/**
	 * Supprime un produit (et tout ce qui lui est relatif)
	 * @param myshop_products $product
	 */
	function deleteProduct(myshop_products $product)
	{
		global $xoopsModule;
		$id = $product->getVar('product_id');

		// On commence par supprimer les commentaires
		$mid = $xoopsModule->getVar('mid');
		xoops_comment_delete($mid, $id);

		// Puis les votes
		$this->handlers->h_myshop_votedata->deleteProductRatings($id);

		// Puis les produits relatifs
		$this->handlers->h_myshop_related->deleteProductRelatedProducts($id);

		// Les images (la grande et la miniature)
		$product->deletePictures();

		// Le fichier attaché
		$product->deleteAttachment();

		// Les fichiers attachés
		$this->handlers->h_myshop_files->deleteProductFiles($id);

		// Suppression dans les paniers enregistrés
		$this->handlers->h_myshop_persistent_cart->deleteProductForAllCarts($id);

		// Et le produit en lui même, à la fin
		return $this->handlers->h_myshop_products->delete($product, true);
	}


	/**
	 * Cherche et retourne la liste de produits relatifs à une liste de produits
	 *
	 * @param array $productsIds	La liste des produits dont on cherche les produits relatifs
	 * @return array	Clé = ID Produit, valeurs (deuxième dimension) = liste des produits relatifs
	 */
	private function getRelatedProductsFromProductsIds($productsIds)
	{
		$relatedProducts = $relatedProductsIds = array();
		if(is_array($productsIds) && count($productsIds) > 0) {
			$relatedProductsIds = $this->handlers->h_myshop_related->getRelatedProductsFromProductsIds($productsIds);
			if(count($relatedProductsIds) > 0) {
				$tmp = array();
				foreach($relatedProductsIds as $relatedProductId) {
					$tmp[] = $relatedProductId->getVar('related_product_related');
				}
				$tmp = array_unique($tmp);
				sort($tmp);
				if(count($tmp) > 0) {
					$tempRelatedProducts = $this->handlers->h_myshop_products->getProductsFromIDs($tmp);
					foreach($relatedProductsIds as $relatedProductId) {
						if(isset($tempRelatedProducts[$relatedProductId->getVar('related_product_related')])) {
							$relatedProducts[$relatedProductId->getVar('related_product_id')][] = $tempRelatedProducts[$relatedProductId->getVar('related_product_related')];
						}
					}
				}
			}
		}
		return $relatedProducts;
	}


	/**
	 * Retourne une liste de produits
	 *
	 * @param myshop_shelf_parameters $parameters	Les paramètres de filtrage
	 * @return array	Tableau prêt à être utilisé dans les templates
	 */
	public function getProducts(myshop_shelf_parameters $parameters)
	{
		global $vatArray;
		$parametersValues = $parameters->getParameters();
		$productType = $parametersValues['productsType'];
		$start = $parametersValues['start'];
		$limit = $parametersValues['limit'];
		$category = $parametersValues['category'];
		$sort = $parametersValues['sort'];
		$order = $parametersValues['order'];
		$excluded = $parametersValues['excluded'];
		$withXoopsUser = $parametersValues['withXoopsUser'];
		$withRelatedProducts = $parametersValues['withRelatedProducts'];
		$withQuantity = $parametersValues['withQuantity'];
		$thisMonthOnly = $parametersValues['thisMonthOnly'];

		$ret = $xoopsUsersIDs = $users = $relatedProducts = $productsManufacturers = $manufacturersPerProduct = $products = $productsIds = $categoriesIds = $storesIds = $manufacturersIds = $manufacturers = $categories = $stores = array();
		// On commence par récupérer la liste des produits
		switch(strtolower($productType)) {
			case 'recent':
				$products = $this->handlers->h_myshop_products->getRecentProducts($start, $limit, $category, $sort, $order, $excluded, $thisMonthOnly);
				break;

			case 'mostsold':
				$tempProductsIds = $this->handlers->h_myshop_caddy->getMostSoldProducts($start, $limit, $category, $withQuantity);
				$products = $this->handlers->h_myshop_products->getProductsFromIDs(array_keys($tempProductsIds));
				break;

			case 'mostviewed':
				$products = $this->handlers->h_myshop_products->getMostViewedProducts($start, $limit, $category, $sort, $order);
				break;

			case 'bestrated':
				$products = $this->handlers->h_myshop_products->getBestRatedProducts($start, $limit, $category, $sort, $order);
				break;

			case 'recommended':
				$products = $this->handlers->h_myshop_products->getRecentRecommended($start, $limit, $category, $sort, $order);
				break;

			case 'promotional':
				$products = $this->handlers->h_myshop_products->getPromotionalProducts($start, $limit, $category, $sort, $order);
				break;

			case 'random':
				$products = $this->handlers->h_myshop_products->getRandomProducts($start, $limit, $category, $sort, $order, $thisMonthOnly);
		}

		if(count($products) > 0) {
			$productsIds = array_keys($products);
		} else {
			return $ret;
		}

		// Recherche des Id des catégories et des vendeurs
		foreach($products as $product) {
			$categoriesIds[] = $product->getVar('product_cid');
			$storesIds[] = $product->getVar('product_store_id');
			if($withXoopsUser) {
				$xoopsUsersIDs[] = $product->getVar('product_submitter');
			}
		}

		$productsManufacturers = $this->handlers->h_myshop_productsmanu->getFromProductsIds($productsIds);
		// Regroupement des fabricants par produit
		foreach($productsManufacturers as $item) {
			$manufacturersIds[] = $item->getVar('pm_manu_id');
			$manufacturersPerProduct[$item->getVar('pm_product_id')][] = $item;
		}
		// On récupère la liste des personnes qui ont soumis les produits
		if($withXoopsUser) {
			$users = myshop_utils::getUsersFromIds($xoopsUsersIDs);
		}

		// Il faut récupérer la liste des produits relatifs
		if($withRelatedProducts) {
			$relatedProducts = $this->getRelatedProductsFromProductsIds($productsIds);
		}

		$categoriesIds = array_unique($categoriesIds);
		sort($categoriesIds);

		$storesIds = array_unique($storesIds);
		sort($storesIds);

		$manufacturersIds = array_unique($manufacturersIds);
		sort($manufacturersIds);

		// Récupération des fabricants, des vendeurs et des catégories
		if(count($manufacturersIds) > 0) {
			$manufacturers = $this->handlers->h_myshop_manufacturer->getManufacturersFromIds($manufacturersIds);
		}
		if(count($categoriesIds) > 0) {
			$categories = $this->handlers->h_myshop_cat->getCategoriesFromIds($categoriesIds);
		}
		if(count($storesIds) > 0) {
			$stores = $this->handlers->h_myshop_stores->getStoresFromIds($storesIds);
		}

		$count = 1;
		$lastTitle = '';
		foreach($products as $product) {
			$tmp = array();
			$tmp = $product->toArray();
			$lastTitle = $product->getVar('product_title');
			// Store
			if(isset($stores[$product->getVar('product_store_id')])) {
				$tmp['product_store'] = $stores[$product->getVar('product_store_id')]->toArray();
			}
			// Category
			if(isset($categories[$product->getVar('product_cid')])) {
				$tmp['product_category'] = $categories[$product->getVar('product_cid')]->toArray();
			}
			// Related products
			if($withRelatedProducts) {
				if(isset($relatedProducts[$product->getVar('product_id')])) {
					$productsRelatedToThisOne = $relatedProducts[$product->getVar('product_id')];
					foreach($productsRelatedToThisOne as $oneRelatedProdut) {
						$tmp['product_related_products'][] = $oneRelatedProdut->toArray();
					}
				}
			}
			// Les fabricants du produit
			if(isset($manufacturersPerProduct[$product->getVar('product_cid')])) {
				$productManufacturers = $manufacturersPerProduct[$product->getVar('product_cid')];
				$tmpManufacturersList = array();
				foreach($productManufacturers as $productManufacturer) {
					if(isset($manufacturers[$productManufacturer->getVar('pm_manu_id')])) {
						$manufacturer = $manufacturers[$productManufacturer->getVar('pm_manu_id')];
						$tmp['product_manufacturers'][] = $manufacturer->toArray();
						$tmpManufacturersList[] = $manufacturer->getVar('manu_commercialname').' '.$manufacturer->getVar('manu_name');
					}
				}
				if(count($tmpManufacturersList) > 0) {
					$tmp['product_joined_manufacturers'] = implode(MYSHOP_STRING_TO_JOIN_MANUFACTURERS, $tmpManufacturersList);
				}
			}

			// L'utilisateur Xoops (éventuellement)
			if($withXoopsUser && isset($users[$product->getVar('product_submitter')])) {
				$thisUser = $users[$product->getVar('product_submitter')];
				if(xoops_trim($thisUser->getVar('name')) != '') {
					$name = $thisUser->getVar('name');
				} else {
					$name = $thisUser->getVar('uname');
				}
				$tmp['product_submiter_name'] = $name;
				$userLink = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$thisUser->getVar('uid').'">'. $name.'</a>';
				$tmp['product_submiter_link'] = $userLink;
			}
			$tmp['product_count'] = $count;	// Compteur pour les templates (pour gérer les colonnes)
			$ret[] = $tmp;
			$count++;
		}
		$ret['lastTitle'] = $lastTitle;
		return $ret;
	}
}
?>