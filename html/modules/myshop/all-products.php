<?php

/**
 * All Products
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_allproducts.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$categories = $vatArray = array();

// VAT
$vatArray = $h_myshop_vat->getAllVats();
// Module preferences
$xoopsTpl->assign('mod_pref', $mod_pref);

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$limit = myshop_utils::getModuleOption('perpage');

// Products
$itemsCount = $myshop_shelf->getProductsCount('recent');
if($itemsCount > $limit) {
	$pagenav = new XoopsPageNav( $itemsCount, $limit, $start, 'start');
	$xoopsTpl->assign('pagenav', $pagenav->renderNav());
}

$products = array();
$myshop_shelf_parameters->resetDefaultValues()->setProductsType('recent')->setStart($start)->setLimit($limit)->setSort('product_submitted DESC, product_title');
$products = $myshop_shelf->getProducts($myshop_shelf_parameters);
if(isset($products['lastTitle'])) {
	$lastTitle = strip_tags($products['lastTitle']);
	unset($products['lastTitle']);
}
$xoopsTpl->assign('products', $products);

$xoopsTpl->assign('pdf_catalog', myshop_utils::getModuleOption('pdf_catalog'));

//myshop_utils::setCSS();
$url = MYSHOP_URL.'include/myshop.css';
$url2 = MYSHOP_URL.'js/extjs/resources/css/ext-all.css';
$url4 = MYSHOP_URL.'js/extjs/adapter/ext/ext-base.js';
$url5 = MYSHOP_URL.'js/extjs/ext-all.js';

$header  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" />";
$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url2\" />";
$header .= "<script type=\"text/javascript\" src=\"$url4\"></script>";
$header .= "<script type=\"text/javascript\" src=\"$url5\"></script>";
				$header .= '<script type="text/javascript" src="'.XOOPS_URL.'/common/fckeditor/fckeditor.js"></script>
		<script type="text/javascript">
		<!--
			function fckeditor_exec() {
				var oFCKeditor = new FCKeditor( "'.$editor_configs['name'].'" , "100%" , "500" , "Default" );		
				oFCKeditor.BasePath = "'.XOOPS_URL.'/common/fckeditor/";
				oFCKeditor.ReplaceTextarea();
			}
		// -->
		</script>';
$xoopsTpl->assign("xoops_module_header", $header);

if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php')) {
	require_once  MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
} else {
	require_once  MYSHOP_PATH.'language/english/modinfo.php';
}

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MI_MYSHOP_SMNAME6)));

$title = _MI_MYSHOP_SMNAME6.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
require_once(XOOPS_ROOT_PATH . '/footer.php');
?>