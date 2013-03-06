<?php
/*
 * B.M.Yahoo - Yahoo Login Module on XOOPS Cube v2.2 / PHP5.3 or later
 * Copyright (c) Bluemoon inc. 2013 All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
if (!isset($root)) {
	$root = XCube_Root::getSingleton();
}
$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;
$modversion["name"] = _MI_BMYAHOO;
$modversion["dirname"] = basename(dirname(__FILE__));
$modversion['hasMain'] = 0;
$modversion['version'] = 0.01;
$modversion['image'] = 'images/bmyahoo.png';
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['cube_style'] = true;
$modversion['onUpdate'] = 'sql/onupdate.php';

// Module Config
$modversion['hasconfig'] = 1;
$modversion['config'][]=array(
	'name' => 'appId',
	'title' => _MI_BMYAHOO_APP_ID,
	'description' => '_MI_BMYAHOO_APP_ID_DESC',
	'formtype' => 'text',
	'valuetype' => 'string',
	'default' => ''
);
$modversion['config'][]=array(
	'name' => 'secret',
	'title' => _MI_BMYAHOO_SECRET,
	'description' => '_MI_BMYAHOO_SECRET_DESC',
	'formtype' => 'text',
	'valuetype' => 'string',
	'default' => ''
);
$modversion['config'][]=array (
	'name' => 'defaultGroup',
	'title' => _MI_BMYAHOO_DEFAULT_GROUP,
	'description' => '_MI_BMYAHOO_DEFAULT_GROUP_DESC',
	"formtype"=>"group",
	"valuetype"=>"int",
	"default" => XOOPS_GROUP_USERS
);
/*
 * View Section
 */
$modversion['templates'][] = array('file' => "yahoo_login.html");

/*
 * Model section
 */

/*
 * Config section
 */

// Search

// Comments

// Block

