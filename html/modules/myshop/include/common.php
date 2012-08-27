<?php

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

if( !defined("MYSHOP_DIRNAME") ) {
	define("MYSHOP_DIRNAME", 'myshop');
	define("MYSHOP_URL", XOOPS_URL.'/modules/'.MYSHOP_DIRNAME.'/');
	define("MYSHOP_PATH", XOOPS_ROOT_PATH.'/modules/'.MYSHOP_DIRNAME.DIRECTORY_SEPARATOR);
	define("MYSHOP_IMAGES_URL", MYSHOP_URL.'images/');

	define("MYSHOP_ADMIN_URL", XOOPS_URL.'/modules/'.MYSHOP_DIRNAME.'/admin/');
	define("MYSHOP_ADMIN_PATH", XOOPS_ROOT_PATH.'/modules/'.MYSHOP_DIRNAME.'/admin/');

	define("MYSHOP_TEXTFILE1", 'myshop_index.txt');
	define("MYSHOP_TEXTFILE2", 'myshop_cgv.txt');
	define("MYSHOP_TEXTFILE3", 'myshop_recomm.txt');
	define("MYSHOP_TEXTFILE4", 'myshop_offlinepayment.txt');
	define("MYSHOP_TEXTFILE5", 'myshop_restrictorders.txt');
	define("MYSHOP_CACHE_PATH", XOOPS_UPLOAD_PATH.DIRECTORY_SEPARATOR.MYSHOP_DIRNAME.DIRECTORY_SEPARATOR);
}

require_once MYSHOP_PATH.'class/myshop_handlers.php';
require_once MYSHOP_PATH.'class/myshop_currency.php';
require_once MYSHOP_PATH.'class/myshop_utils.php';
require_once MYSHOP_PATH.'class/myshop_shelf.php';
require_once MYSHOP_PATH.'class/myshop_shelf_parameters.php';
require_once MYSHOP_PATH.'class/PEAR.php';
require_once MYSHOP_PATH.'class/myshop_reductions.php';

require MYSHOP_PATH.'config.php';

$myshop_handlers = myshop_handler::getInstance();

$myts = &MyTextSanitizer::getInstance();

// handlers
$h_myshop_manufacturer = $myshop_handlers->h_myshop_manufacturer;
$h_myshop_products = $myshop_handlers->h_myshop_products;
$h_myshop_productsmanu = $myshop_handlers->h_myshop_productsmanu;
$h_myshop_caddy = $myshop_handlers->h_myshop_caddy;
$h_myshop_cat = $myshop_handlers->h_myshop_cat;
$h_myshop_commands = $myshop_handlers->h_myshop_commands;
$h_myshop_related = $myshop_handlers->h_myshop_related;
$h_myshop_vat = $myshop_handlers->h_myshop_vat;
$h_myshop_votedata = $myshop_handlers->h_myshop_votedata;
$h_myshop_discounts =  $myshop_handlers->h_myshop_discounts;
$h_myshop_stores =  $myshop_handlers->h_myshop_stores;
$h_myshop_files =  $myshop_handlers->h_myshop_files;
$h_myshop_persistent_cart =  $myshop_handlers->h_myshop_persistent_cart;

$myshop_shelf = new myshop_shelf();	// Front
$myshop_shelf_parameters = new myshop_shelf_parameters();

// Images
if( !defined("_MYSHOP_EDIT")) {
	global $xoopsConfig;
	if (file_exists(MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/main.php')) {
		include MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/main.php';
	} else {
		include MYSHOP_PATH.'language/english/main.php';
	}
}
$icones = array(
	'edit' => "<img src='". MYSHOP_IMAGES_URL ."edit.png' alt='" . _MYSHOP_EDIT . "' align='middle' />",
	'delete' => "<img src='". MYSHOP_IMAGES_URL ."delete.png' alt='" . _MYSHOP_DELETE . "' align='middle' />",
	'online' => "<img src='". MYSHOP_IMAGES_URL ."online.png' alt='" . _MYSHOP_ONLINE . "' align='middle' />",
	'offline' => "<img src='". MYSHOP_IMAGES_URL ."offline.png' alt='" . _MYSHOP_OFFLINE . "' align='middle' />",
	'ok' => "<img src='". MYSHOP_IMAGES_URL ."ok.png' alt='" . _MYSHOP_VALIDATE_COMMAND . "' align='middle' />",
	'copy' => "<img src='". MYSHOP_IMAGES_URL ."duplicate.png' alt='" . _MYSHOP_DUPLICATE_PRODUCT . "' align='middle' />",
	'details' => "<img src='". MYSHOP_IMAGES_URL ."details.png' alt='"._MYSHOP_DETAILS."' align='middle' />"
);

// settings
$mod_pref = array(
	'money_short' => myshop_utils::getModuleOption('money_short'),
	'money_full' => myshop_utils::getModuleOption('money_full'),
	'url_rewriting' => myshop_utils::getModuleOption('urlrewriting'),
	'tooltip' => myshop_utils::getModuleOption('infotips'),
	'advertisement' => myshop_utils::getModuleOption('advertisement'),
	'rss' => myshop_utils::getModuleOption('use_rss'),
	'nostock_msg' => myshop_utils::getModuleOption('nostock_msg'),
	'use_price' => myshop_utils::getModuleOption('use_price'),
	'restrict_orders' => myshop_utils::getModuleOption('restrict_orders'),
	'isAdmin' => myshop_utils::isAdmin()
);
?>