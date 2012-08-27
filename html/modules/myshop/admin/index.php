<?php

require_once '../../../include/cp_header.php';
require_once '../include/common.php';

require_once MYSHOP_PATH.'admin/functions.php';
require_once XOOPS_ROOT_PATH . '/class/tree.php';
require_once XOOPS_ROOT_PATH . '/class/uploader.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once MYSHOP_PATH.'class/tree.php';

$op = 'dashboard';
if (isset($_POST['op'])) {
	$op = $_POST['op'];
} elseif ( isset($_GET['op'])) {
   	$op = $_GET['op'];
}

$action = 'default';
if (isset($_POST['action'])) {
	$action = $_POST['action'];
} elseif ( isset($_GET['action'])) {
   	$action = $_GET['action'];
}

$limit = myshop_utils::getModuleOption('items_count');
$baseurl = MYSHOP_URL.'admin/'.basename(__FILE__);
$conf_msg = myshop_utils::javascriptLinkConfirm(_AM_MYSHOP_CONF_DELITEM);
$myshop_Currency = & myshop_Currency::getInstance();
$manual_meta = myshop_utils::getModuleOption('manual_meta');

global $xoopsConfig;
if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php')) {
	require_once MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
} else {
	require_once MYSHOP_PATH.'language/english/modinfo.php';
}

if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/main.php')) {
	require_once MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/main.php';
} else {
	require_once MYSHOP_PATH.'language/english/main.php';
}

if(!is_dir(MYSHOP_CACHE_PATH)) {
	mkdir(MYSHOP_CACHE_PATH, 0777);
	file_put_contents(MYSHOP_CACHE_PATH.'/index.html', '<script>history.go(-1);</script>');
}

$destname = '';
define("MYSHOP_ADMIN", true);

$controler = MYSHOP_ADMIN_PATH.'actions/'.$op.'.php';
if(file_exists($controler)) {
	require $controler;
}


// Main

switch ($op) {

	case 'maintain':

    	xoops_cp_header();
    	myshop_adminMenu();
    	require_once '../xoops_version.php';
    	$tables = array();
		foreach ($modversion['tables'] as $table) {
			$tables[] = $xoopsDB->prefix($table);
		}
		if(count($tables) > 0) {
			$list = implode(',', $tables);
			$xoopsDB->queryF('CHECK TABLE '.$list);
			$xoopsDB->queryF('ANALYZE TABLE '.$list);
			$xoopsDB->queryF('OPTIMIZE TABLE '.$list);
		}
		myshop_utils::updateCache();
		$h_myshop_products->forceCacheClean();
		myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl, 2);
    	break;
}
xoops_cp_footer();
?>