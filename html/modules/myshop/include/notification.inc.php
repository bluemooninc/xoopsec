<?php

function myshop_notify_iteminfo($category, $item_id)
{
	global $xoopsModule, $xoopsModuleConfig;
	$item_id = intval($item_id);

	if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != 'myshop') {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname('myshop');
		$config_handler =& xoops_gethandler('config');
		$config =& $config_handler->getConfigsByCat(0,$module->getVar('mid'));
	} else {
		$module =& $xoopsModule;
		// TODO: Jamais utilisé !!!
		$config =& $xoopsModuleConfig;
	}

	if ($category == 'global') {
		$item['name'] = '';
		$item['url'] = '';
		return $item;
	}

	if ($category == 'new_category') {
		include MYSHOP_PATH.'include/common.php';
		$category = null;
		$category = $h_myshop_cat->get($item_id);
		if(is_object($category)) {
			$item['name'] = $category->getVar('cat_title');
			$item['url'] = MYSHOP_URL.'category.php?cat_cid=' . $item_id;
		}
		return $item;
	}

	if ($category == 'new_product') {
		include MYSHOP_PATH.'include/common.php';
		$product = null;
		$product = $h_myshop_products->get($item_id);
		if(is_object($product)) {
			$item['name'] = $product->getVar('product_title');
			$item['url'] = MYSHOP_URL.'product.php?product_id=' . $item_id;
		}
		return $item;
	}
}
?>