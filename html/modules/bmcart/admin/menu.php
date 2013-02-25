<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

$adminmenu[]=array(
	'title' => _MI_BMCART_CATEGORY_LIST,
	'link' => "admin/index.php?action=categoryList",
	'keywords' => _MI_BMCART_KEYWORD_CATEGORY_LIST,
	'show' => true
);

$adminmenu[]=array(
	'title' => _MI_BMCART_ITEM_LIST,
	'link' => "admin/index.php?action=itemList",
	'keywords' => _MI_BMCART_KEYWORD_ITEM_LIST,
	'show' => true
);
$adminmenu[]=array(
	'title' => _MI_BMCART_SKU_LIST,
	'link' => "admin/index.php?action=skuList",
	'keywords' => _MI_BMCART_KEYWORD_SKU_LIST,
	'show' => true
);

$adminmenu[]=array(
	'title' => _MI_BMCART_IMAGE_LIST,
	'link' => "admin/index.php?action=imageList",
	'keywords' => _MI_BMCART_KEYWORD_IMAGE_LIST,
	'show' => true
);

$adminmenu[]=array(
	'title' => _MI_BMCART_ORDER_LIST,
	'keywords' => _MI_BMCART_KEYWORD_ORDER_LIST,
	'link' => "admin/index.php?action=orderList",
	'show' => true
);

