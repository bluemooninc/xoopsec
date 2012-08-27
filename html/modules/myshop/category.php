<?php

/**
 * Categories
 * Pattern :
 * if parent category or no category,
 * display 4 blocks, otherwise display products of category
 */
require 'header.php';
$cat_cid = isset($_GET['cat_cid']) ? intval($_GET['cat_cid']) : 0;
$GLOBALS['current_category'] = $cat_cid;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$category = null;
if($cat_cid > 0) {
	$category = $h_myshop_cat->get($cat_cid);
	if(!is_object($category)) {
		myshop_utils::redirect(_MYSHOP_ERROR8, 'index.php', 5);
	}
}
// Display blocks
$xoopsOption['template_main'] = 'myshop_category.html';
require_once XOOPS_ROOT_PATH . '/header.php';
$vatArray = $tbl_categories  = array();
$limit = myshop_utils::getModuleOption('perpage');

// VAT
$vatArray = $h_myshop_vat->getAllVats();

// Ccategories
$categories = $h_myshop_cat->getAllCategories();

// Template options
$xoopsTpl->assign('mod_pref', $mod_pref);

require_once MYSHOP_PATH.'class/tree.php';
$tbl_tmp = array();
$mytree = new Myshop_XoopsObjectTree($categories, 'cat_cid', 'cat_pid');

// Parent category or no category specified

if( (is_object($category) && $category->getVar('cat_pid') == 0) || $cat_cid == 0 ) {	// Display 4 blocks
	$xoopsTpl->assign('case', 1);

	$tblChildsO = $tblChilds = array();
	$tblChilds[] = $cat_cid;
	if($cat_cid > 0) {
		$tblChildsO = $mytree->getAllChild($cat_cid);
		foreach($tblChildsO as $item) {
			$tblChilds[] = $item->getVar('cat_cid');
		}
	}

	if(is_object($category)) {	// Speficic category
		$xoopsTpl->assign('category', $category->toArray());
		$title = _MYSHOP_CATEGORYC.' '.$category->getVar('cat_title').' - '.myshop_utils::getModuleName();
		if(!myshop_utils::getModuleOption('manual_meta')) {
			myshop_utils::setMetas($title, $title);
		} else {
			$pageTitle = xoops_trim($category->getVar('cat_metatitle')) == '' ? $title : $category->getVar('cat_metatitle');
			$metaDescription = xoops_trim($category->getVar('cat_metadescription')) != '' ? $category->getVar('cat_metadescription') : $title;
			$metaKeywords = xoops_trim($category->getVar('cat_metakeywords'));
			myshop_utils::setMetas($pageTitle, $metaDescription, $metaKeywords);
		}
		$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => $category->getVar('cat_title'))));
		if(MYSHOP_SHOW_SUB_CATEGORIES) {
			$count = 1;
			$firstChilds = array();
			$firstChilds = $mytree->getFirstChild($category->getVar('cat_cid'));
			foreach($firstChilds as $children) {
				$tmpCategory = array();
				$tmpCategory = $children->toArray();
				$tmpCategory['count'] = $count;
				$xoopsTpl->append('subCategories', $tmpCategory);
				$count++;
			}
		}
	} else {	// Categories Page
		$title = _MYSHOP_CATEGORIES.' - '.myshop_utils::getModuleName();
		myshop_utils::setMetas($title, $title);
		$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_CATEGORIES)));
		if(MYSHOP_SHOW_MAIN_CATEGORIES) {
			$count = 1;
			$motherCategories = $h_myshop_cat->getMotherCategories();
			foreach($motherCategories as $mothercategory) {
				$tmpCategory = array();
				$tmpCategory = $mothercategory->toArray();
				$tmpCategory['count'] = $count;
				$xoopsTpl->append('motherCategories', $tmpCategory);
				$count++;
			}
		}
	}

	// Categories Settings
	$chunk1 = myshop_utils::getModuleOption('chunk1');		// Products most recent
	$chunk2 = myshop_utils::getModuleOption('chunk2');		// Products most bought
	$chunk3 = myshop_utils::getModuleOption('chunk3');		// Products most viewed
	$chunk4 = myshop_utils::getModuleOption('chunk4');		// Products most voted

	if( $chunk1 > 0 ) {		// Products most recent from this category or all categories
		$products = array();
		$myshop_shelf_parameters->resetDefaultValues()->setProductsType('recent')->setCategory($tblChilds)->setStart($start)->setLimit($limit)->setSort('product_submitted DESC, product_title');
		$products = $myshop_shelf->getProducts($myshop_shelf_parameters);
		if(count($products) > 0) {
			$xoopsTpl->assign('chunk'.$chunk1.'Title', _MYSHOP_MOST_RECENT);
			if(isset($products['lastTitle'])) {
				unset($products['lastTitle']);
			}
			$xoopsTpl->assign('chunk'.$chunk1, $products);
		}
	}

	if( $chunk2 > 0 ) {		// Products most bought from this category or all categories
		$products = array();
		$myshop_shelf_parameters->resetDefaultValues()->setProductsType('mostsold')->setStart($start)->setLimit($limit)->setSort('product_submitted DESC, product_title')->setCategory($tblChilds);
		$products = $myshop_shelf->getProducts($myshop_shelf_parameters);
		if(count($products) > 0) {
			$xoopsTpl->assign('chunk'.$chunk2.'Title', _MYSHOP_MOST_SOLD);
			if(isset($products['lastTitle'])) {
				unset($products['lastTitle']);
			}
			$xoopsTpl->assign('chunk'.$chunk2, $products);
		}
	}

	if( $chunk3 > 0 ) {		// Products most viewed
		$products = array();
		$myshop_shelf_parameters->resetDefaultValues()->setProductsType('mostviewed')->setStart($start)->setLimit($limit)->setSort('product_hits')->setOrder('DESC')->setCategory($tblChilds);
		$products = $myshop_shelf->getProducts($myshop_shelf_parameters);
		if(count($products) > 0) {
			$xoopsTpl->assign('chunk'.$chunk3.'Title', _MYSHOP_MOST_VIEWED);
			if(isset($products['lastTitle'])) {
				unset($products['lastTitle']);
			}
			$xoopsTpl->assign('chunk'.$chunk3, $products);
		}
	}

	if( $chunk4 > 0 ) {		// Produts most voted
		$products = array();
		$myshop_shelf_parameters->resetDefaultValues()->setProductsType('bestrated')->setStart($start)->setLimit($limit)->setSort('product_rating')->setOrder('DESC')->setCategory($tblChilds);
		$products = $myshop_shelf->getProducts($myshop_shelf_parameters);
		if(count($products) > 0) {
			$xoopsTpl->assign('chunk'.$chunk4.'Title', _MYSHOP_MOST_RATED);
			if(isset($products['lastTitle'])) {
				unset($products['lastTitle']);
			}
			$xoopsTpl->assign('chunk'.$chunk4, $products);
		}
	}
} else {	
	// Display products of category
	$xoopsTpl->assign('case', 2);
	$xoopsTpl->assign('category', $category->toArray());
	if(MYSHOP_SHOW_SUB_CATEGORIES) {
		$count = 1;
		$firstChilds = array();
		$firstChilds = $mytree->getFirstChild($category->getVar('cat_cid'));
		foreach($firstChilds as $children) {
			$tmpCategory = array();
			$tmpCategory = $children->toArray();
			$tmpCategory['count'] = $count;
			$xoopsTpl->append('subCategories', $tmpCategory);
			$count++;
		}
	}

	// Search number of products on this category
	$productsCount = $h_myshop_products->getTotalPublishedProductsCount($cat_cid);
	$limit = myshop_utils::getModuleOption('perpage');
	if ( $productsCount > $limit ) {
		require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
		$catLink = $category->getLink();
		$pagenav = new XoopsPageNav( $productsCount, $limit, $start, 'start', 'cat_cid='.$cat_cid);
		$xoopsTpl->assign('pagenav', $pagenav->renderNav());
	} else {
		$xoopsTpl->assign('pagenav', '');
	}

	// Breadcrumb
	$ancestors = $mytree->getAllParent($cat_cid);
	$ancestors = array_reverse($ancestors);
	$tbl_tmp[] = "<a href='".MYSHOP_URL."index.php' title='".myshop_utils::makeHrefTitle(myshop_utils::getModuleName())."'>".myshop_utils::getModuleName().'</a>';
	foreach($ancestors as $item) {
		$tbl_tmp[] = "<a href='".$item->getLink()."' title='".myshop_utils::makeHrefTitle($item->getVar('cat_title'))."'>".$item->getVar('cat_title').'</a>';
	}
	// Add current category
	$tbl_tmp[] = "<a href='".$category->getLink()."' title='".myshop_utils::makeHrefTitle($category->getVar('cat_title'))."'>".$category->getVar('cat_title').'</a>';
	$breadcrumb = implode(' &raquo; ', $tbl_tmp);
	$xoopsTpl->assign('breadcrumb', $breadcrumb);

	// Meta
	$title = strip_tags($breadcrumb);
	if(!myshop_utils::getModuleOption('manual_meta')) {
		myshop_utils::setMetas($title, $title, str_replace('&raquo;', ',', $title));
	} else {
		$pageTitle = xoops_trim($category->getVar('cat_metatitle')) == '' ? $title : $category->getVar('cat_metatitle');
		$metaDescription = xoops_trim($category->getVar('cat_metadescription')) != '' ? $category->getVar('cat_metadescription') : $title;
		$metaKeywords = xoops_trim($category->getVar('cat_metakeywords'));
		myshop_utils::setMetas($pageTitle, $metaDescription, $metaKeywords);
	}

	// Products Data
	$products = array();
	$myshop_shelf_parameters->resetDefaultValues()->setProductsType('recent')->setCategory($cat_cid)->setStart($start)->setLimit($limit)->setSort('product_submitted DESC, product_title');
	$products = $myshop_shelf->getProducts($myshop_shelf_parameters);

	if(count($products) > 0) {
		if(isset($products['lastTitle'])) {
			unset($products['lastTitle']);
		}
		$xoopsTpl->assign('products', $products);
	}
}

myshop_utils::setCSS();
require_once(XOOPS_ROOT_PATH . '/footer.php');
?>