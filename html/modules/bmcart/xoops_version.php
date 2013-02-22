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
$mydirpath = basename(dirname(dirname(__FILE__)));
$mydirname = basename(dirname(__FILE__));

$modversion["name"] = _MI_BMCART_TITLE;
$modversion["dirname"] = $mydirname;
$modversion['hasMain'] = 1;
$modversion['version'] = 0.15;
$modversion['image'] = 'images/bmcart.png';
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['sub'][] = array('name' => _MI_BMCART_CATEGORY_LIST, 'url' => 'index.php');
$modversion['sub'][] = array('name' => _MI_BMCART_ITEM_LIST, 'url' => 'itemList/index');
$modversion['sub'][] = array('name' => _MI_BMCART_CART_LIST, 'url' => 'cartList/index');
$modversion['sub'][] = array('name' => _MI_BMCART_ORDER_LIST, 'url' => 'orderList/index');
$modversion['onUpdate'] = 'sql/onupdate.php';

/*
 * View section
 */
$modversion['templates'][] = array('file' => "categoryList.html");
$modversion['templates'][] = array('file' => "itemList.html");
$modversion['templates'][] = array('file' => "itemDetail.html");
$modversion['templates'][] = array('file' => "cartList.html");
$modversion['templates'][] = array('file' => "checkout.html");
$modversion['templates'][] = array('file' => "editAddress.html");
$modversion['templates'][] = array('file' => "orderList.html");
$modversion['templates'][] = array('file' => "orderItems.html");
$modversion['templates'][] = array('file' => "notification_update.html");

/*
 * Model section
 */
$modversion['cube_style'] = TRUE;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_category';
$modversion['tables'][] = '{prefix}_{dirname}_item';
$modversion['tables'][] = '{prefix}_{dirname}_cart';
$modversion['tables'][] = '{prefix}_{dirname}_order';
$modversion['tables'][] = '{prefix}_{dirname}_orderItems';
$modversion['tables'][] = '{prefix}_{dirname}_itemImages';
$modversion['tables'][] = '{prefix}_{dirname}_itemSKU';
$modversion['tables'][] = '{prefix}_{dirname}_checkedItems';

/*
 * Config section
 */

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'search.php';
$modversion['search']['func'] = 'bmcart_global_search';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'itemList.php';
$modversion['comments']['itemName'] = 'item_id';
$modversion['comments']['extraParams'] = array('page');
$modversion['comments']['callbackFile'] = 'comment_functions.php'; // Comments callback functions
$modversion['comments']['callback']['approve'] = 'bmcart_com_approve';
$modversion['comments']['callback']['update'] = 'bmcart_com_update';

// Block
$modversion['blocks'][1] = array(
	'file' => "bmcart_category.php",
	'name' => _MI_BMCART_BLOCK_CATEGORY,
	'description' => _MI_BMCART_BLOCK_CATEGORY_DESC,
	'show_func' => "b_bmcart_category_show",
	'template' => 'bmcart_block_category.html',
	'visible_any' => TRUE,
	'show_all_module' => FALSE
);
$modversion['blocks'][2] = array(
	'file' => "bmcart_newitem.php",
	'name' => _MI_BMCART_BLOCK_NEWITEM,
	'description' => _MI_BMCART_BLOCK_NEWITEM_DESC,
	'show_func' => "b_bmcart_newitem_show",
	'template' => 'bmcart_block_newitem.html',
	'visible_any' => TRUE,
	'show_all_module' => FALSE
);
$modversion['blocks'][3] = array(
	'file' => "bmcart_checkedItems.php",
	'name' => _MI_BMCART_BLOCK_checkedItems,
	'description' => _MI_BMCART_BLOCK_checkedItems_DESC,
	'show_func' => "b_bmcart_checkedItems_show",
	'template' => 'bmcart_block_checkedItems.html',
	'visible_any' => TRUE,
	'show_all_module' => FALSE
);
$modversion['blocks'][4] = array(
	'file' => "bmcart_bookmarkItems.php",
	'name' => _MI_BMCART_BLOCK_BOOKMARKITEMS,
	'description' => _MI_BMCART_BLOCK_BOOKMARKITEMS_DESC,
	'show_func' => "b_bmcart_bookmarkItems_show",
	'template' => 'bmcart_block_bookmarkItems.html',
	'visible_any' => TRUE,
	'show_all_module' => FALSE
);

// Module Config
$modversion['hasconfig'] = 1;
$modversion['config'][] = array(
	'name' => 'sales_tax',
	'title' => _MI_BMCART_SALES_TAX,
	'description' => '_MI_BMCART_SALES_TAX_DESC',
	'formtype' => 'text',
	'valuetype' => 'float',
	'default' => 5
);
$modversion['config'][] = array(
	'name' => 'free_shipping',
	'title' => _MI_BMCART_FREE_SHIPPING,
	'description' => '_MI_BMCART_FREE_SHIPPING_DESC',
	'formtype' => 'text',
	'valuetype' => 'float',
	'default' => 0
);
$modversion['config'][] = array(
	'name' => 'cash_on_delivery',
	'title' => _MI_BMCART_CASHON_DELIVERY,
	'description' => '_MI_BMCART_CASHON_DELIVERY_DESC',
	'formtype' => 'text',
	'valuetype' => 'string',
	'default' => "10000>300,30000>400,100000>600,300000>1000"
);

// Notification

$constpref = '_MI_' . strtoupper($mydirname);

$modversion['hasNotification'] = 1;
$modversion['notification'] = array(
	'lookup_file' => 'notification.php' ,
	'lookup_func' => "{$mydirname}_notify_iteminfo" ,
	'category' => array(
		array(
			'name' => 'global' ,
			'title' => constant($constpref . '_GLOBAL_NOTIFY'),
			'description' => constant($constpref . '_GLOBAL_NOTIFYDSC'),
			'subscribe_from' => 'index.php' ,
		) ,
		array(
			'name' => 'item' ,
			'title' => constant($constpref.'_ITEM_NOTIFY'),
			'description' => constant($constpref.'_ITEM_NOTIFYDSC'),
			'subscribe_from' => 'index.php' ,
			'item_name' => 'item_id' ,
			'allow_bookmark' => 1
		)
	) ,
	'event' => array(
		array(
			'name' => 'order_submit',
			'category' => 'global',
			'admin_only' => 1,
			'title' => constant($constpref . '_GLOBAL_ORDER_SUBMIT_NOTIFY'),
			'caption' => constant($constpref . '_GLOBAL_ORDER_SUBMIT_NOTIFYCAP'),
			'description' => constant($constpref . '_GLOBAL_ORDER_SUBMIT_NOTIFYDSC'),
			'mail_template' => 'global_order_submit_notify',
			'mail_subject' => constant($constpref . '_GLOBAL_ORDER_SUBMIT_NOTIFYSBJ')
		) ,
		array(
			'name' => 'comment' ,
			'category' => 'item' ,
			'title' => constant($constpref . '_NOTIFY5_TITLE'),
			'caption' => constant($constpref . '_NOTIFY5_CAPTION'),
			'description' => constant($constpref . '_NOTIFY5_DESC'),
			'mail_template' => 'item_comment',
			'mail_subject' => constant($constpref . '_NOTIFY5_SUBJECT')
		)
	)
) ;
