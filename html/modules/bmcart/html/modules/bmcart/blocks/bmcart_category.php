<?php
/*
 * B.M.Cart - Cart Module on XOOPS Cube v2.2
 * Copyright (c) Bluemoon inc. All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */

function b_bmcart_category_show()
{
	$category_id = isset($_SESSION['bmcart']['category_id']) ? $_SESSION['bmcart']['category_id'] : 0;
	$handler = xoops_getmodulehandler("category", "bmcart");
	$myObject = $handler->get($category_id);
	if ($myObject) {
		$mListData = array(
			"parent_id" => $myObject->getVar("parent_id"),
			"category_id" => $myObject->getVar("category_id"),
			"category_name" => $myObject->getVar("category_name")
		);
	} else {
		$mListData = array(
			"parent_id" => 0,
			"category_id" => 0,
			"category_name" => "Top"
		);

	}
	$criteria = new Criteria('parent_id', $category_id);
	$objects = $handler->getObjects($criteria);
	foreach ($objects as $object) {
		$mListData['child'][] = array(
			"parent_id" => $object->getVar("parent_id"),
			"category_id" => $object->getVar("category_id"),
			"category_name" => $object->getVar("category_name")
		);
	}
	$block = array();
	$block['categoryList'] = $mListData;
	return $block;
}
