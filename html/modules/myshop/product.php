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
 * Show Product
 */
require 'header.php';
require_once XOOPS_ROOT_PATH . '/class/tree.php';

$product_id = 0;

// Start check
// Product number
if(isset($_GET['product_id'])) {
	$product_id = intval($_GET['product_id']);
} else {
	myshop_utils::redirect(_MYSHOP_ERROR1, 'index.php', 5);
}
// Product
$product = null;
$product = $h_myshop_products->get($product_id);
if(!is_object($product)) {
	myshop_utils::redirect(_MYSHOP_ERROR1, 'index.php', 5);
}

// VAT
$vatArray = array();
$vatArray = $h_myshop_vat->getAllVats();

// Produit on-line
if($product->getVar('product_online') == 0) {
	myshop_utils::redirect(_MYSHOP_ERROR2, 'index.php', 5);
}

// Product is Published
if(myshop_utils::getModuleOption('show_unpublished') == 0 && $product->getVar('product_submitted') > time()) {
	myshop_utils::redirect(_MYSHOP_ERROR3, 'index.php', 5);
}

// Show product if empty stock
if(myshop_utils::getModuleOption('nostock_display') == 0 && $product->getVar('product_stock') == 0) {
	if(xoops_trim(myshop_utils::getModuleOption('nostock_display')) != '') {
		myshop_utils::redirect(myshop_utils::getModuleOption('nostock_display'), 'index.php', 5);
	}
}
// End Tests
$title = strip_tags($product->getVar('product_title')).' - '.myshop_utils::getModuleName();

if(!isset($_GET['op'])) {
	$xoopsOption['template_main'] = 'myshop_product.html';
	$GLOBALS['current_category'] = $product->getVar('product_cid');
	require_once XOOPS_ROOT_PATH . '/header.php';
} elseif(isset($_GET['op']) && $_GET['op'] == 'print') {	// Page to Print
	$GLOBALS['current_category'] = 0;
	$xoopsConfig['sitename'] = $title;
	xoops_header(false);
	// Include stylesheet
	$url = MYSHOP_URL.'include/myshop.css';
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" />";
	echo "</head><body>";
	if(!isset($xoopsTpl)) {
		require_once XOOPS_ROOT_PATH . '/class/template.php';
		$xoopsTpl = new XoopsTpl();
	}
}

if(isset($_GET['stock']) && $_GET['stock'] == 'add' && myshop_utils::isMemberOfGroup(myshop_utils::getModuleOption('grp_qty'))) {
	$h_myshop_products->increaseStock($product);
}

if(isset($_GET['stock']) && $_GET['stock'] == 'substract' && myshop_utils::isMemberOfGroup(myshop_utils::getModuleOption('grp_qty'))) {
	$h_myshop_products->decreaseStock($product);
	$h_myshop_products->verifyLowStock($product);
}

$currentUser = myshop_utils::getCurrentUserID();

$baseurl = MYSHOP_URL.basename(__FILE__).'?product_id='.$product->getVar('product_id');

// Options for template
$xoopsTpl->assign('baseurl', $baseurl);
$xoopsTpl->assign('nostock_msg', myshop_utils::getModuleOption('nostock_msg'));
$xoopsTpl->assign('mod_pref', $mod_pref);
$xoopsTpl->assign('icones', $icones);
$xoopsTpl->assign('canRateProducts', myshop_utils::getModuleOption('rateproducts'));
$xoopsTpl->assign('mail_link', 'mailto:?subject='.sprintf(_MYSHOP_INTARTICLE,$xoopsConfig['sitename']).'&amp;body='.sprintf(_MYSHOP_INTARTFOUND, $xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/myshop/product.php?product_id='.$product_id);
$xoopsTpl->assign('canChangeQuantity', myshop_utils::isMemberOfGroup(myshop_utils::getModuleOption('grp_qty')));	// Group with permissions to change product quantity
$xoopsTpl->assign('ProductStockQuantity', sprintf(_MYSHOP_QUANTITY_STOCK,$product->getVar('product_stock')));

// Search Category of Product
$tbl_tmp = $tbl_categories = $tbl_ancestors = array();
$tbl_categories = $h_myshop_cat->getAllCategories();
$product_category = null;
$product_category = isset($tbl_categories[$product->getVar('product_cid')]) ? $tbl_categories[$product->getVar('product_cid')] : null;
if(!is_object($product_category)) {
	myshop_utils::redirect(_MYSHOP_ERROR4, 'index.php', 5);
}

// store
$product_store = null;
$product_store = $h_myshop_stores->get($product->getVar('product_store_id'));
if(!is_object($product_store)) {
	myshop_utils::redirect(_MYSHOP_ERROR5, 'index.php', 5);
}

// Load VAT
$tblVat = array();
$tblVat = $h_myshop_vat->getAllVats();

// Search VAT
$product_vat = null;
if(isset($tblVat[$product->getVar('product_vat_id')])) {
	$product_vat = $tblVat[$product->getVar('product_vat_id')];
}
if(!is_object($product_vat)) {
	myshop_utils::redirect(_MYSHOP_ERROR6, 'index.php', 5);
}

// Search product user submitter
$product_user = null;
$user_handler = $member_handler =& xoops_gethandler('user');
$product_user = $user_handler->get($product->getVar('product_submitter'), true);
$xoopsTpl->assign('product_submitter', $product_user);

// Product manufacturer
$tbl_auteurs = $tbl_translators = $tbl_tmp = $tbl_tmp2 = $tbl_join1 = $tbl_join2 = array();
$criteria = new Criteria('pm_product_id', $product->getVar('product_id'), '=');
$tbl_tmp = $h_myshop_productsmanu->getObjects($criteria, true);
foreach($tbl_tmp as $id => $item) {
	$tbl_tmp2[] = $item->getVar('pm_manu_id');
}
if(count($tbl_tmp2) > 0 ) {
	$tbl_product_manufacturers = array();
	$tbl_auteurs = $h_myshop_manufacturer->getObjects(new Criteria('manu_id', '('.implode(',', $tbl_tmp2).')', 'IN'), true);
	foreach($tbl_auteurs as $item) {
			$xoopsTpl->append('product_manufacturers', $item->toArray());
			$tbl_join1[] = "<a href='".$item->getLink()."' title='".myshop_utils::makeHrefTitle($item->getVar('manu_commercialname').' '.$item->getVar('manu_name'))."'>".$item->getVar('manu_commercialname').' '.$item->getVar('manu_name')."</a>";
	}
}
if(count($tbl_join1) > 0) {
	$xoopsTpl->assign('product_joined_manufacturers', implode(', ', $tbl_join1));
}
if(count($tbl_join2) > 0) {
	$xoopsTpl->assign('product_joined_stores', implode(', ', $tbl_join2));
}

// Related products
$tbl_tmp = $tbl_tmp2 = array();
$criteria = new Criteria('related_product_id', $product->getVar('product_id'), '=');
$tbl_tmp = $h_myshop_related->getObjects($criteria);
if(count($tbl_tmp) > 0 ) {
	foreach($tbl_tmp as $item) {
		$tbl_tmp2[] = $item->getVar('related_product_related');
	}
	$tbl_related_products = array();
	$tbl_related_products = $h_myshop_products->getObjects(new Criteria('product_id', '('.implode(',', $tbl_tmp2).')', 'IN'), true);
	if(count($tbl_related_products) > 0) {
		$cpt = 1;
		foreach($tbl_related_products as $item) {
			$tbl_tmp = $item->toArray();
			$tbl_tmp['count'] = $cpt;
			$tbl_tmp['product_category'] = isset($tbl_categories[$item->getVar('product_cid')]) ? $tbl_categories[$item->getVar('product_cid')]->toArray() : null;
			$xoopsTpl->append('product_related_products', $tbl_tmp);
			$cpt++;
		}
	}
}

// Product related files
$attachedFiles = $mp3AttachedFilesList = $attachedFilesForTemplate = array();
$mp3AttachedFiles = '';
$attachedFilesCount = $h_myshop_files->getProductFilesCount($product->getVar('product_id'));
if($attachedFilesCount > 0) {
	$attachedFiles = $h_myshop_files->getProductFiles($product->getVar('product_id'));
	foreach($attachedFiles as $attachedFile) {	// search files
		if($attachedFile->isMP3()) {
			$mp3AttachedFilesList[] = $attachedFile->getURL();
		}
		$attachedFilesForTemplate[] = $attachedFile->toArray();
	}
	if(count($mp3AttachedFilesList) > 0) {	// load swfobject
		$urlJS = '<script type="text/javascript" src="'. MYSHOP_URL.'js/swfobject.js'.'"></script>';
		$xoopsTpl->assign('xoops_module_header', $urlJS);
		$mp3AttachedFiles = $h_myshop_files->getHtmlCodeForDewplayer($mp3AttachedFilesList);
	}
}


// product info
$tbl_tmp = array();
$tbl_tmp = $product->toArray();
// product files
$tbl_tmp['attached_mp3_count'] = count($mp3AttachedFilesList);
$tbl_tmp['attached_non_mp3_count'] = count($attachedFilesForTemplate) - count($mp3AttachedFilesList);
$tbl_tmp['attached_mp3_html_code'] = $mp3AttachedFiles;
$tbl_tmp['attached_files'] = $attachedFilesForTemplate;

$tbl_tmp['product_category'] = $product_category->toArray();
$tbl_tmp['product_store'] = $product_store->toArray();
if(xoops_trim($product_user->getVar('name')) != '') {
	$name = $product_user->getVar('name');
} else {
	$name = $product_user->getVar('uname');
}
$tbl_tmp['product_submiter_name'] = $name;
$linkeduser = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$product_user->getVar('uid').'">'. $name.'</a>';
$tbl_tmp['product_submiter_link'] = $name;
$tbl_tmp['product_vat_rate'] = $product_vat->toArray();

$tbl_tmp['product_rating_formated'] = number_format($product->getVar('product_rating'), 2);
if ($product->getVar('product_votes') == 1) {
	$tbl_tmp['product_votes_count'] = _MYSHOP_ONEVOTE;
} else {
	$tbl_tmp['product_votes_count'] = sprintf(_MYSHOP_NUMVOTES,$product->getVar('product_votes'));
}
$xoopsTpl->assign('product', $tbl_tmp);

// Breadcrumb
$tbl_tmp = array();
$mytree = new XoopsObjectTree($tbl_categories, 'cat_cid', 'cat_pid');
$tbl_ancestors = $mytree->getAllParent($product->getVar('product_cid'));
$tbl_ancestors = array_reverse($tbl_ancestors);
$tbl_tmp[] = "<a href='".MYSHOP_URL."index.php' title='".myshop_utils::makeHrefTitle(myshop_utils::getModuleName())."'>".myshop_utils::getModuleName()."</a>";
foreach($tbl_ancestors as $item) {
	$tbl_tmp[] = "<a href='".$item->getLink()."' title='".myshop_utils::makeHrefTitle($item->getVar('cat_title'))."'>".$item->getVar('cat_title')."</a>";

}
// Add current category
$tbl_tmp[] = "<a href='".$product_category->getLink()."' title='".myshop_utils::makeHrefTitle($product_category->getVar('cat_title'))."'>".$product_category->getVar('cat_title')."</a>";
$tbl_tmp[] = $product->getVar('product_title');
$breadcrumb = implode(' &raquo; ', $tbl_tmp);
$xoopsTpl->assign('breadcrumb', $breadcrumb);

// count views
if($product->getVar('product_submitter') != $currentUser) {
	$h_myshop_products->addCounter($product_id);
}

// products, next and previous
if(myshop_utils::getModuleOption('showprevnextlink') == 1) {
	$xoopsTpl->assign('showprevnextlink', true);
	// Actual and next product
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('product_online', 1, '='));
	if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
		$criteria->add(new Criteria('product_submitted', time(), '<='));
	}
	if(myshop_utils::getModuleOption('nostock_display') == 0) {	
		$criteria->add(new Criteria('product_stock', 0, '>'));
	}
	$criteria->add(new Criteria('product_id', $product->getVar('product_id'),'>'));
	$criteria->setOrder('DESC');
	$criteria->setSort('product_submitted');
	$criteria->setLimit(1);
	$tbl = array();
	$tbl = $h_myshop_products->getObjects($criteria);
	if(count($tbl) == 1 ) {
		$tmpProduct = null;
		$tmpProduct = $tbl[0];
	   	$xoopsTpl->assign('next_product_id',$tmpProduct->getVar('product_id'));
   		$xoopsTpl->assign('next_product_title',$tmpProduct->getVar('product_title'));
		$xoopsTpl->assign('next_product_url_rewrited', $tmpProduct->getLink());
		$xoopsTpl->assign('next_product_href_title', myshop_utils::makeHrefTitle($tmpProduct->getVar('product_title')));
	} else {
		$xoopsTpl->assign('next_product_id', 0);
	}

	// Previous product
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('product_online', 1, '='));
	if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
		$criteria->add(new Criteria('product_submitted', time(), '<='));
	}
	if(myshop_utils::getModuleOption('nostock_display') == 0) {	
		$criteria->add(new Criteria('product_stock', 0, '>'));
	}
	$criteria->add(new Criteria('product_id', $product->getVar('product_id'),'<'));
	$criteria->setOrder('DESC');
	$criteria->setSort('product_submitted');
	$criteria->setLimit(1);
	$tbl = array();
	$tbl = $h_myshop_products->getObjects($criteria);
	if(count($tbl) == 1 ) {
		$tmpProduct = null;
		$tmpProduct = $tbl[0];
	   	$xoopsTpl->assign('previous_product_id',$tmpProduct->getVar('product_id'));
   		$xoopsTpl->assign('previous_product_title',$tmpProduct->getVar('product_title'));
		$xoopsTpl->assign('previous_product_url_rewrited', $tmpProduct->getLink());
		$xoopsTpl->assign('previous_product_href_title', myshop_utils::makeHrefTitle($tmpProduct->getVar('product_title')));
	} else {
		$xoopsTpl->assign('previous_product_id', 0);
	}
} else {
	$xoopsTpl->assign('showprevnextlink', false);
}
// x recent products of all categories
$count = myshop_utils::getModuleOption('summarylast');
$xoopsTpl->assign('summarylast', $count);
if($count > 0) {
	$tblTmp = array();
	$tblTmp = $h_myshop_products->getRecentProducts(0 , $count, 0, 'product_submitted DESC, product_title', '', $product_id);
	foreach($tblTmp as $item) {
		$datas = array('last_categs_product_title' => $item->getVar('product_title'),
						'last_categs_product_url_rewrited' => $item->getLink(),
						'last_categs_product_href_title' => myshop_utils::makeHrefTitle($item->getVar('product_title')));
		$xoopsTpl->append('product_all_categs', $datas);
	}
	unset($tblTmp);
}

// x recent products of this category
$count = myshop_utils::getModuleOption('summarycategory');
$xoopsTpl->assign('summarycategory', $count);
if($count > 0) {
	$tblTmp = array();
	$tblTmp = $h_myshop_products->getRecentProducts(0 , $count, $product->getVar('product_cid'), 'product_submitted DESC, product_title', '', $product_id);
	foreach($tblTmp as $item) {
		$datas = array('last_categ_product_title' => $item->getVar('product_title'),
						'last_categ_product_url_rewrited' => $item->getLink(),
						'last_categ_product_href_title' => myshop_utils::makeHrefTitle($item->getVar('product_title')));
		$xoopsTpl->append('product_current_categ', $datas);
	}
	unset($tblTmp);
}

// Related product
$count = myshop_utils::getModuleOption('better_together');
$xoopsTpl->assign('better_together', $count);
if($count > 0) {
	$productWith = 0;
	// Most selled product
$productWith = $h_myshop_caddy->getBestWith($product->getVar('product_id'));
	if($productWith > 0) {
		$tmpProduct = null;
		$tmpProduct = $h_myshop_products->get($productWith);
		if(is_object($tmpProduct)) {
			$tmp = array();
			$tmp = $tmpProduct->toArray();
			$tmp['product_price_ttc'] = myshop_utils::getTTC($tmpProduct->getVar('product_price'), $tblVat[$tmpProduct->getVar('product_vat_id')]->getVar('vat_rate') );
			$tmp['product_discount_price_ttc'] = myshop_utils::getTTC($tmpProduct->getVar('product_discount_price'), $tblVat[$tmpProduct->getVar('product_vat_id')]->getVar('vat_rate') );
			$xoopsTpl->assign('bestwith', $tmp);
		}
	}
}

// Product vote
if(myshop_utils::getModuleOption('rateproducts') == 1 ) {
	$canRate = true;
	if ($currentUser != 0) {
		$canRate = $h_myshop_votedata->hasUserAlreadyVoted($currentUser, $product->getVar('product_id'));
	} else {
		$canRate = $h_myshop_votedata->hasAnonymousAlreadyVoted('', $product->getVar('product_id'));
	}
	$xoopsTpl->assign('userCanRate', $canRate);
}

// Meta et CSS
myshop_utils::setCSS();
if(myshop_utils::getModuleOption('manual_meta')) {
	$pageTitle = xoops_trim($product->getVar('product_metatitle')) == '' ? $title : $product->getVar('product_metatitle');
	$metaDescription = xoops_trim($product->getVar('product_metadescription')) != '' ? $product->getVar('product_metadescription') : $title;
	$metaKeywords = xoops_trim($product->getVar('product_metakeywords')) != '' ? $product->getVar('product_metakeywords') : myshop_utils::createMetaKeywords($product->getVar('product_title').' '.$product->getVar('product_summary').' '.$product->getVar('product_description'));
	myshop_utils::setMetas($pageTitle, $metaDescription, $metaKeywords);
} else {
	myshop_utils::setMetas($title, $title, myshop_utils::createMetaKeywords($product->getVar('product_title').' '.$product->getVar('product_summary').' '.$product->getVar('product_description')));
}

if(!isset($_GET['op'])) {
	require_once XOOPS_ROOT_PATH . '/include/comment_view.php';
	require_once XOOPS_ROOT_PATH . '/footer.php';
} elseif(isset($_GET['op']) && $_GET['op'] == 'print') {
	$xoopsTpl->display('db:myshop_product.html');
	xoops_footer();
}
?>