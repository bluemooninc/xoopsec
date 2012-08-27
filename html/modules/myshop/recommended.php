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
 *  Recommended Products
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_recommended.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once MYSHOP_PATH.'class/registryfile.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

// Initialize
$tbl_products = $tbl_categories = $tbl_stores = $tbl_users = $tbl_tmp_user  = $tbl_tmp_categ = $tbl_tmp_lang = $tbl_tmp_vat = $tbl_vat = array();
$tbl_products_id = $tbl_auteurs = $tbl_infos_auteurs = $tbl_tmp_auteurs = array();
$tbl_tmp_related = $tbl_related = $tbl_info_related_products = array();
$tbl_related_products = array();
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$limit = myshop_utils::getModuleOption('perpage');
$baseurl = MYSHOP_URL.basename(__FILE__);					// script URL
$myshop_Currency = & myshop_Currency::getInstance();

$registry = new myshop_registryfile();

// VAT
$vatArray = array();
$vatArray = $h_myshop_vat->getAllVats();

// Template options
$xoopsTpl->assign('nostock_msg', myshop_utils::getModuleOption('nostock_msg'));
$xoopsTpl->assign('mod_pref', $mod_pref);
$xoopsTpl->assign('welcome_msg', nl2br($registry->getfile(MYSHOP_TEXTFILE3)));

// Total products in DB
$itemsCount = $h_myshop_products->getRecommendedCount();
if($itemsCount > $limit) {
	$pagenav = new XoopsPageNav( $itemsCount, $limit, $start);
	$xoopsTpl->assign('pagenav', $pagenav->renderNav());
}

if($limit > 0) {
	// Recent products
	$myshop_shelf_parameters->resetDefaultValues()->setProductsType('recommended')->setStart($start)->setLimit($limit)->setSort('product_recommended')->setOrder('DESC')->setCategory(0)->setWithXoopsUser(true)->setWithRelatedProducts(true);
	$products = $myshop_shelf->getProducts($myshop_shelf_parameters);
	if(isset($products['lastTitle'])) {
		$lastTitle = strip_tags($products['lastTitle']);
		unset($products['lastTitle']);
	}
	$xoopsTpl->assign('products', $products);
}
$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_RECOMMENDED)));

myshop_utils::setCSS();
myshop_utils::setMetas(_MYSHOP_RECOMMENDED.' - '.myshop_utils::getModuleName(), myshop_utils::getModuleName());
require_once(XOOPS_ROOT_PATH . '/footer.php');
?>