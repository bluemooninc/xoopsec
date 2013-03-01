<?php
/*
 * B.M.Cart - Cart Module on XOOPS Cube v2.2
 * Copyright (c) Bluemoon inc. All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
// TODO : array_flatten move to more abstruct class
function _array_flatten($array)
{
	$result = array();
	// Callback with closure is PHP5.3 or later
	array_walk_recursive($array, function ($v) use (&$result) {
		$result[] = $v;
	});
	return $result;
}

function b_bmcart_newitem_show()
{
	// For Category Selector
	$category_id = isset($_SESSION['bmcart']['category_id']) ? $_SESSION['bmcart']['category_id'] : NULL;
	$cArray = array();
	if ($category_id) {
		$catHandler =& xoops_getModuleHandler('category', 'bmcart');
		$catArray = $catHandler->getAllChildren($category_id);
		$catArray[] = $category_id;
		$cArray = _array_flatten($catArray);
	}
	$itemHandler = xoops_getmodulehandler("item", "bmcart");
	$imageHandler = xoops_getmodulehandler("itemImages", "bmcart");
	$criteria = new CriteriaCompo();
	if (count($cArray) > 0) {
		$criteria->add(new Criteria('category_id', $cArray, "IN"));
	}
	$criteria->addsort('last_update', 'desc');
	$objects = $itemHandler->getObjects($criteria, 0, 10);
	$mListData = array();
	$i=0;
	foreach ($objects as $object) {
		if ($i>=8){
			break;
		}
		$item_id = $object->getVar('item_id');
		$itemObject = $itemHandler->get($item_id);
		if ($itemObject){
			$imageCriteria = new Criteria('item_id', $item_id);
			$imageObjects = $imageHandler->getObjects($imageCriteria);
			$images = array();
			foreach ($imageObjects as $imageObject) {
				$images[] = $imageObject->getVar("image_filename");
			}
			$myRow = array(
				"item_id" => $object->getVar("item_id"),
				"item_name" => $itemObject->getVar("item_name"),
				"images" => $images
			);
			$blockNumber = 'block' . intval($i/4);
			$mListData[$blockNumber][] = $myRow;
			$i++;
		}
	}
	$block = array();
	$block['newItemsList'] = $mListData;
	return $block;
}
