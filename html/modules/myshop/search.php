<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

/**
 * Search products
 */
require 'header.php';
require_once MYSHOP_PATH.'class/tree.php';
$GLOBALS['current_category'] = -1;		// Block categories
$xoopsOption['template_main'] = 'myshop_search.html';
require_once XOOPS_ROOT_PATH . '/header.php';

$limit = myshop_utils::getModuleOption('newproducts');
$categories = $manufacturers = $stores = array();
$baseurl = MYSHOP_URL.basename(__FILE__);

$xoopsTpl->assign('mod_pref', $mod_pref);

// TODO: Add pagination

$categories = $h_myshop_cat->getAllCategories();
$stores = $h_myshop_stores->getAllStores();
$manufacturers = $h_myshop_manufacturer->getItems(0, 0, 'manu_name', 'ASC', false);


if((isset($_POST['op']) && $_POST['op'] == 'go') || isset($_GET['start'])) {
	$xoopsTpl->assign('search_results', true);
	$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
	$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_SEARCHRESULTS)));
	myshop_utils::setMetas(myshop_utils::getModuleName().' - '._MYSHOP_SEARCHRESULTS, myshop_utils::getModuleName().' - '._MYSHOP_SEARCHRESULTS);

	$sql = 'SELECT b.product_id, b.product_title, b.product_submitted, b.product_submitter FROM '.$xoopsDB->prefix('myshop_products').' b, '.$xoopsDB->prefix('myshop_productsmanu').' a WHERE (b.product_id = a.pm_product_id AND b.product_online = 1 ';
	if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
		$sql .= ' AND b.product_submitted <= '.time();
	}
	if(myshop_utils::getModuleOption('nostock_display') == 0) {	
		$sql .= ' AND b.product_stock > 0';
	}
	$sql .= ') ';
	// Search Category
	if(isset($_POST['product_category'])) {
		$cat_cid = intval($_POST['product_category']);
		if($cat_cid > 0 ) {
			$sql .= 'AND b.product_cid = '.$cat_cid;
		}
	}

	// Search texte
	if(xoops_trim($_POST['product_text']) != '') {
		$temp_queries = $queries = array();
		$temp_queries = preg_split('/[\s,]+/', $_POST['product_text']);
        foreach ($temp_queries as $q) {
            $q = trim($q);
			$queries[] = $myts->addSlashes($q);
        }
        if( count($queries) > 0 ) {
			$tmpObject = new myshop_products();
			$datas = $tmpObject->getVars();
			$tblFields = array();
			$cnt = 0;
			foreach($datas as $key => $value) {
				if($value['data_type'] == XOBJ_DTYPE_TXTBOX || $value['data_type'] == XOBJ_DTYPE_TXTAREA) {
					if($cnt == 0) {
						$tblFields[] = 'b.'.$key;
					} else {
						$tblFields[] = ' OR b.'.$key;
					}
					$cnt++;
				}
			}
			$count = count($queries);
			$cnt = 0;
			$sql .= ' AND ';
			$searchType = intval($_POST['search_type']);
			$andor  = ' OR ';
			foreach($queries as $oneQuery) {
				$sql .= '(';
				switch($searchType) {
					case 0:		// Start with
						$cond = " LIKE '".$oneQuery."%' ";
						break;
					case 1:		// End with
						$cond = " LIKE '%".$oneQuery."' ";
						break;
					case 2:		// Match
						$cond = " = '".$oneQuery."' ";
						break;
					case 3:		// Content
						$cond = " LIKE '%".$oneQuery."%' ";
						break;
				}
				$sql .= implode($cond, $tblFields).$cond.')';
				$cnt++;
				if($cnt != $count) {
					$sql .= ' '.$andor.' ';
				}
			}
			
        }
	} else {
		$sql .= ' AND ';
	}

	$reqSupp = 0;
	$sql2 = '';
	// Search Manufacturers
	if(isset($_POST['product_manufacturers'])) {
		$searchManufacturers = true;
		$auteurs = null;
		$auteurs = $_POST['product_manufacturers'];
		if(is_array($auteurs) && intval($auteurs[0]) == 0) {
			$auteurs = array_shift($auteurs);
		}
		if(is_array($auteurs) && count($auteurs) > 0) {
			array_walk($auteurs, 'intval');
			$sql2 .= ' (a.pm_manu_id IN ( '.implode(',', $auteurs).'))';
			$reqSupp++;
		} else {
			$auteur = intval($auteurs);
			if($auteur > 0) {
				$sql2 .= ' AND (a.pm_manu_id = '.$auteurs.')';
				$reqSupp++;
			}
		}
	} else {
		$searchManufacturers = false;
	}

	switch ($reqSupp) {
		case 1:
			$sql .= $sql2;
			break;

		case 2:
			$sql .= ' AND ('.$sql2.')';
			break;
	}

	// Search stores
	if(isset($_POST['product_stores'])) {
		$stores = intval($_POST['product_stores']);
		if( $stores > 0 ) {
			$sql .= ' AND product_store_id = '.$stores;
		}
	}
	$sql .= ' GROUP BY b.product_id ORDER BY product_submitted DESC';
	$result = $xoopsDB->query($sql);
	$ret = array();
	$tempProduct = $h_myshop_products->create(true);
 	while ($myrow = $xoopsDB->fetchArray($result)) {
		$ret = array();
		$ret['link'] = $tempProduct->getLink($myrow['product_id'], $myrow['product_title']);
		$ret['title'] = $myts->htmlSpecialChars($myrow['product_title']);
		$ret['href_title'] = myshop_utils::makeHrefTitle($myts->htmlSpecialChars($myrow['product_title']));
		$ret['time'] = $myrow['product_submitted'];
		$ret['uid'] = $myrow['product_submitter'];
		$xoopsTpl->append('products', $ret);
	}
	unset($tempProduct);
} else {
	$xoopsTpl->assign('search_results', false);
	$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
	$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_SEARCHFOR)));
	myshop_utils::setMetas(myshop_utils::getModuleName().' - '._MYSHOP_SEARCHFOR, myshop_utils::getModuleName().' - '._MYSHOP_SEARCHFOR);
}

require_once MYSHOP_PATH.'include/product_search_form.php';
$sform = myshop_utils::formMarkRequiredFields($sform);
$xoopsTpl->assign('search_form',$sform->render());

myshop_utils::setCSS();

require_once XOOPS_ROOT_PATH . '/footer.php';
?>