<?php

/**
 * Categories map
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_map.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once MYSHOP_PATH.'class/tree.php';

$xoopsTpl->assign('mod_pref', $mod_pref);
$categories = array();
$categories = $h_myshop_cat->getAllCategories();
$mytree = new Myshop_XoopsObjectTree($categories, 'cat_cid', 'cat_pid');
$tree = $mytree->makeTreeAsArray('cat_title', '-');
foreach($tree as $key => $value) {
	if(isset($categories[$key])) {
		$category = $categories[$key];
		$xoopsTpl->append('categories', array('cat_url_rewrited' => $category->getLink(), 'cat_href_title' => $category->getHrefTitle(), 'cat_title' => $value));
	}
}

myshop_utils::setCSS();
if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php')) {
	require_once MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
} else {
	require_once MYSHOP_PATH.'language/english/modinfo.php';
}

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MI_MYSHOP_SMNAME4)));

$title = _MI_MYSHOP_SMNAME4.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
require_once XOOPS_ROOT_PATH . '/footer.php';
?>