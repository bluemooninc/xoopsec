<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

function myshop_com_update($product_id, $total_num)
{
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	global $h_myshop_products;
	if(!is_object($h_myshop_products)) {
		$handlers = myshop_handler::getInstance();
		$h_myshop_products = $handlers->myshop_products;

	}
	$h_myshop_products->updateCommentsCount($product_id, $total_num);
}

function myshop_com_approve(&$comment)
{
	// notification mail here
}
?>