<?php
/*
 * B.M.facebook - facebook Module on XOOPS Cube v2.2 / PHP5.3 or later
 * Copyright (c) Bluemoon inc. 2013 All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
if (!isset($root)) {
	$root = XCube_Root::getSingleton();
}
$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;
$modversion["name"] = _MI_BM_FACEBOOK;
$modversion["dirname"] = basename(dirname(__FILE__));
$modversion['hasMain'] = 0;
$modversion['version'] = 0.01;
$modversion['image'] = 'images/bmfacebook.png';
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['cube_style'] = true;

// Module Config
$modversion['hasconfig'] = 1;
$modversion['config'][]=array(
	'name' => 'appId',
	'title' => _MI_BMFACEBOOK_APP_ID,
	'description' => '_MI_BMFACEBOOK_APP_ID_DESC',
	'formtype' => 'text',
	'valuetype' => 'string',
	'default' => ''
);
$modversion['config'][]=array(
	'name' => 'secret',
	'title' => _MI_BMFACEBOOK_SECRET,
	'description' => '_MI_BMFACEBOOK_SECRET_DESC',
	'formtype' => 'text',
	'valuetype' => 'string',
	'default' => ''
);
$modversion['config'][]=array (
	'name' => 'defaultGroup',
	'title' => _MI_BMFACEBOOK_DEFAULT_GROUP,
	'description' => '_MI_BMFACEBOOK_DEFAULT_GROUP_DESC',
	"formtype"=>"group",
	"valuetype"=>"int",
	"default" => XOOPS_GROUP_USERS
);
/*
 * View Section
 */
$modversion['templates'][] = array('file' => "login.html");

/*
 * Model section
 */

/*
 * Config section
 */

// Search

// Comments

// Block

