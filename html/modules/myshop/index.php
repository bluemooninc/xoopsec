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
 * Inde page with last products
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_index.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once MYSHOP_PATH.'class/registryfile.php';

// Initialize
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$limit = myshop_utils::getModuleOption('newproducts');		// Max number to display
$baseurl = MYSHOP_URL.basename(__FILE__);					// Script URL
$registry = new myshop_registryfile();
$lastTitle = "";

// Template options
$xoopsTpl->assign('nostock_msg', myshop_utils::getModuleOption('nostock_msg'));
$xoopsTpl->assign('mod_pref', $mod_pref);	// Pr�f�rences du module
$xoopsTpl->assign('welcome_msg', nl2br($registry->getfile(MYSHOP_TEXTFILE1)));


// VAT
$vatArray = $h_myshop_vat->getAllVats();

// Products
$xoopsTpl->assign('total_products_count', sprintf(_MYSHOP_THEREARE, $h_myshop_products->getTotalPublishedProductsCount()));

if($limit > 0) {
	$itemsCount = $h_myshop_products->getRecentProductsCount();
	if($itemsCount > $limit) {
		require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
		$pagenav = new XoopsPageNav( $itemsCount, $limit, $start);
		$xoopsTpl->assign('pagenav', $pagenav->renderNav());
	}

	$myshop_shelf_parameters->resetDefaultValues()->setProductsType('recent')->setStart($start)->setLimit($limit)->setSort('product_submitted DESC, product_title')->setWithXoopsUser(true)->setWithRelatedProducts(true);
	$products = $myshop_shelf->getProducts($myshop_shelf_parameters);

	if(isset($products['lastTitle'])) {
		$lastTitle = strip_tags($products['lastTitle']);
		unset($products['lastTitle']);
	}
	$xoopsTpl->assign('products', $products);
}

// Parent category
$count = 1;
$categories = $h_myshop_cat->getMotherCategories();
foreach($categories as $category) {
	$tmp = $category->toArray();
	$tmp['count'] = $count;
	$xoopsTpl->append('categories', $tmp);
	$count++;
}

myshop_utils::setCSS();
myshop_utils::setMetas($lastTitle.' - '.myshop_utils::getModuleName(), myshop_utils::getModuleName());
require_once(XOOPS_ROOT_PATH . '/footer.php');
