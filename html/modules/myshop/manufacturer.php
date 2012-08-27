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
 * manufacturer
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_manufacturer.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

// Test
if(isset($_GET['manu_id'])) {
	$manu_id = intval($_GET['manu_id']);
} else {
	myshop_utils::redirect(_MYSHOP_ERROR7, 'index.php', 5);
}
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$manufacturer = null;
$manufacturer = $h_myshop_manufacturer->get($manu_id);
if(!is_object($manufacturer)) {
	myshop_utils::redirect(_MYSHOP_ERROR7, 'index.php', 5);
}

$xoopsTpl->assign('mod_pref', $mod_pref);
$xoopsTpl->assign('manufacturer', $manufacturer->toArray());
$limit = myshop_utils::getModuleOption('perpage');

// VAT
$vatArray = array();
$vatArray = $h_myshop_vat->getAllVats();

// Search all manufacturer products
$itemsCount = $h_myshop_manufacturer->getManufacturerProductsCount($manu_id);
if($itemsCount > $limit) {
	$pagenav = new XoopsPageNav( $itemsCount, $limit, $start, 'start', 'manu_id='.$manu_id);
	$xoopsTpl->assign('pagenav', $pagenav->renderNav());
}

$products = array();
$products = $h_myshop_manufacturer->getManufacturerProducts($manu_id, $start, $limit);
if(count($products) > 0) {
	$tmp = $categories = array();
	foreach($products as $product) {
		$tmp[] = $product->getVar('product_cid');
	}
	$tmp = array_unique($tmp);
	sort($tmp);
	if(count($tmp) > 0) {
		$categories = $h_myshop_cat->getCategoriesFromIds($tmp);
	}
	$cpt = 1;
	foreach($products as $product) {
		$productForTemplate = array();
		$productForTemplate = $product->toArray();
		$productForTemplate['count'] = $cpt;
		$productForTemplate['product_category'] = isset($categories[$product->getVar('product_cid')]) ? $categories[$product->getVar('product_cid')]->toArray() : null;
		$xoopsTpl->append('products', $productForTemplate);
		$cpt++;
	}
}

myshop_utils::setCSS();
if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php')) {
	require_once  MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
} else {
	require_once  MYSHOP_PATH.'language/english/modinfo.php';
}

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$breadcrumb = array(MYSHOP_URL.'whoswho.php' => _MYSHOP_MANUFACTURERS,
					MYSHOP_URL.basename(__FILE__) => $manufacturer->getVar('manu_name').' '.$manufacturer->getVar('manu_commercialname'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb($breadcrumb));

$title = $manufacturer->getVar('manu_name').' '.$manufacturer->getVar('manu_commercialname').' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title, myshop_utils::createMetaKeywords($manufacturer->getVar('manu_name').' '.$manufacturer->getVar('manu_commercialname').' '.$manufacturer->getVar('manu_bio')) );
require_once XOOPS_ROOT_PATH . '/footer.php';
?>