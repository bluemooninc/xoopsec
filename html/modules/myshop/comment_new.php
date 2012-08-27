<?php

require '../../mainfile.php';
require 'header.php';
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	$product = null;
	$product = $h_myshop_products->get($com_itemid);
	if(is_object($product)) {
    	$com_replytitle = $product->getVar('product_title');
    	require XOOPS_ROOT_PATH . '/include/comment_new.php';
	} else {
		exit();
	}
}
?>
