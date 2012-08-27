<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_related extends Myshop_Object
{
	function myshop_related()
	{
		$this->initVar('related_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('related_product_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('related_product_related',XOBJ_DTYPE_INT,null,false);
	}
}


class MyshopMyshop_relatedHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//							Table				Classe					 Id
		parent::__construct($db, 'myshop_related', 'myshop_related', 'related_id');
	}

	/**
	 * Supprime les produits relatifs rattach�s � un produit
	 *
	 * @param integer $related_product_id	L'identifiant du produit pour lequel il faut faire la suppression
	 */
	function deleteProductRelatedProducts($related_product_id)
	{
		$criteria = new Criteria('related_product_id', $related_product_id, '=');
		$this->deleteAll($criteria);
	}

	/**
	 * Retourne la liste des produits relatifs d'une liste de produits
	 *
	 * @param array $ids	Les ID des produits dont on recherche les produits relatifs
	 * @return array	Objets de type myshop_related
	 */
	function getRelatedProductsFromProductsIds($ids)
	{
		$ret = array();
		if(is_array($ids)) {
			$criteria = new Criteria('related_product_id', '('.implode(',', $ids).')', 'IN');
			$ret = $this->getObjects($criteria, true, true, '*', false);
		}
		return $ret;
	}
}
?>