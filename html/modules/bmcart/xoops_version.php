<?php
/*
 * B.M.Cart - Cart Module on XOOPS Cube v2.2 / PHP5.3 or later
 * Copyright (c) Bluemoon inc. 2013 All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
if (!isset($root)) {
	$root = XCube_Root::getSingleton();
}
$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;
$modversion["name"] = _MI_BMCART_TITLE;
$modversion["dirname"] = basename(dirname(__FILE__));
$modversion['hasMain'] = 1;
$modversion['version'] = 0.1;
$modversion['image'] = 'images/bmcart.png';
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['sub'][] = array('name' => _MI_BMCART_CATEGORY_LIST, 'url' => 'index.php');
$modversion['sub'][] = array('name' => _MI_BMCART_ITEM_LIST, 'url' => 'itemList/index');
$modversion['sub'][] = array('name' => _MI_BMCART_CART_LIST, 'url' => 'cartList/index');
$modversion['sub'][] = array('name' => _MI_BMCART_ORDER_LIST, 'url' => 'orderList/index');

// Search
$modversion['hasSearch'] = 1 ;
$modversion['search']['file'] = 'search.php' ;
$modversion['search']['func'] = 'bmcart_global_search' ;

/*
 * View
 */
// for shopping
$modversion['templates'][] = array('file' => "categoryList.html");
$modversion['templates'][] = array('file' => "itemList.html");
$modversion['templates'][] = array('file' => "itemDetail.html");
$modversion['templates'][] = array('file' => "cartList.html");
$modversion['templates'][] = array('file' => "checkout.html");
$modversion['templates'][] = array('file' => "editAddress.html");
$modversion['templates'][] = array('file' => "orderList.html");
$modversion['templates'][] = array('file' => "orderItems.html");

/*
 * Model
 */
$modversion['cube_style'] = true;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_category';
$modversion['tables'][] = '{prefix}_{dirname}_item';
$modversion['tables'][] = '{prefix}_{dirname}_cart';
$modversion['tables'][] = '{prefix}_{dirname}_order';
$modversion['tables'][] = '{prefix}_{dirname}_orderItems';
$modversion['tables'][] = '{prefix}_{dirname}_itemImages';
$modversion['tables'][] = '{prefix}_{dirname}_checkedItems';
/*
 * Config
 */

/*
 * Block
 */
$modversion['blocks'][1] = array(
	'file' => "bmcart_category.php",
	'name' => _MI_BMCART_BLOCK_CATEGORY,
	'description' => _MI_BMCART_BLOCK_CATEGORY_DESC,
	'show_func' => "b_bmcart_category_show",
	'template' => 'bmcart_block_category.html',
	'visible_any' => true,
	'show_all_module' => false
);
$modversion['blocks'][2] = array(
	'file' => "bmcart_newitem.php",
	'name' => _MI_BMCART_BLOCK_NEWITEM,
	'description' => _MI_BMCART_BLOCK_NEWITEM_DESC,
	'show_func' => "b_bmcart_newitem_show",
	'template' => 'bmcart_block_newitem.html',
	'visible_any' => true,
	'show_all_module' => false
);
$modversion['blocks'][3] = array(
	'file' => "bmcart_checkedItems.php",
	'name' => _MI_BMCART_BLOCK_checkedItems,
	'description' => _MI_BMCART_BLOCK_checkedItems_DESC,
	'show_func' => "b_bmcart_checkedItems_show",
	'template' => 'bmcart_block_checkedItems.html',
	'visible_any' => true,
	'show_all_module' => false
);
// Config
$modversion['hasconfig'] = 1;
$modversion['config'][]=array(
	'name' => 'sales_tax',
	'title' => '_MI_BMCART_SALES_TAX',
	'description' => '_MI_BMCART_SALES_TAX_DESC',
	'formtype' => 'text',
	'valuetype' => 'float',
	'default' => 5
);