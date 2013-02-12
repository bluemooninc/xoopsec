<?php
/*
* GMO-PG - Payment Module as XOOPS Cube Module
* Copyright (c) Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
* GPL V3 licence
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
if ( !isset($root) ) {
	$root = XCube_Root::getSingleton();
}
//$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;
$modversion["name"] =  _MI_GMOPGX_TITLE;
$modversion["dirname"] = basename(dirname(__FILE__));
$modversion['hasMain'] = 1;
$modversion['version'] = 0.04;
$modversion['hasAdmin'] = 1;
$modversion['image'] = "gmopg.png";
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modDir = $modversion["dirname"];
$modversion['sub'][] = array('name' => _MI_GMOPGX_MEMBER_SAVE, 'url' => 'memberSave');
$modversion['sub'][] = array('name' => _MI_GMOPGX_SAVE_CARD  , 'url' => 'saveCard');
$modversion['sub'][] = array('name' => _MI_GMOPGX_SEARCH_CARD, 'url' => 'searchCard');
/*
$modversion['sub'][] = array('name' => _MI_GMOPGX_ENTRY_TRAN , 'url' => 'entryTran');
$modversion['sub'][] = array('name' => _MI_GMOPGX_EXEC_TRAN  , 'url' => 'execTran');
*/
/*
 * View
 */
// for payment controller
$modversion['templates'][] = array( 'file' => "index_index.html" );
$modversion['templates'][] = array( 'file' => "payment_detail.html" );
$modversion['templates'][] = array( 'file' => "payment_edit.html" );
// for memberSave controller
$modversion['templates'][] = array( 'file' => "memberSave_index.html" );
$modversion['templates'][] = array( 'file' => "memberSave_submit.html" );
// for saveCard controller
$modversion['templates'][] = array( 'file' => "saveCard_index.html" );
$modversion['templates'][] = array( 'file' => "saveCard_submit.html" );
// for entryTran controller
$modversion['templates'][] = array( 'file' => "entryTran_index.html" );
$modversion['templates'][] = array( 'file' => "entryTran_submit.html" );
// for execTran controller
$modversion['templates'][] = array( 'file' => "execTran_index.html" );
$modversion['templates'][] = array( 'file' => "execTran_submit.html" );
// for searchCard controller
$modversion['templates'][] = array( 'file' => "searchCard_index.html" );
$modversion['templates'][] = array( 'file' => "searchCard_submit.html" );
/*
 * Model
 */
$modversion['cube_style'] = true;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_payment';
/*
 * Config
 */
// Config Settings
$modversion['config'][1] = array(
    'name' => 'PGCARD_SITE_ID',
    'title' => _MI_GMOPG_SITE_ID,
    'description' => 'PGCARD_SITE_ID',
    'formtype' => 'text',
    'valuetype' => 'text',
    'default' => ''
);
$modversion['config'][2] = array(
    'name' => 'PGCARD_SITE_PASS',
    'title' => _MI_GMOPG_SITE_PASS,
    'description' => 'PGCARD_SITE_PASS',
    'formtype' => 'password',
    'valuetype' => 'text',
    'default' => ''
);
$modversion['config'][3] = array(
	'name' => 'PGCARD_SHOP_ID',
	'title' => _MI_GMOPG_SHOP_ID,
	'description' => 'PGCARD_SHOP_ID',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => ''
);
$modversion['config'][4] = array(
	'name' => 'PGCARD_SHOP_PASS',
	'title' => _MI_GMOPG_SHOP_PASS,
	'description' => 'PGCARD_SHOP_PASS',
	'formtype' => 'password',
	'valuetype' => 'text',
	'default' => ''
);
$modversion['config'][5] = array(
	'name' => 'PGCARD_RETURN_URL',
	'title' => _MI_GMOPG_RETURN_URL,
	'description' => _MI_GMOPG_RETURN_URL_DESC,
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => 'bmcart/checkout'
);

