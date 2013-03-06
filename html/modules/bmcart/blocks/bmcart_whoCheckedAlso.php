<?php
/*
 * B.M.Cart - Cart Module on XOOPS Cube v2.2
 * Copyright (c) Bluemoon inc. All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
include_once dirname(dirname(__FILE__))."/class/bmcart_session.php";

function b_bmcart_whoCheckedAlso_show()
{
	$item_id = xoops_getrequest('item_id');
	if (empty($item_id)) return null;
	// For Category Selector
	$handler = xoops_getmodulehandler("checkedItems", "bmcart");
	$itemHandler = xoops_getmodulehandler("item", "bmcart");
	$imageHandler = xoops_getmodulehandler("itemImages", "bmcart");
	$itemIds = $handler->getWhoCheckedAlso($item_id);
	$mListData = array();
	$i=0;
	foreach ($itemIds as $item_id) {
		$itemObject = $itemHandler->get($item_id);
		if ($itemObject){
			$imageCriteria = new Criteria('item_id', $item_id);
			$imageObjects = $imageHandler->getObjects($imageCriteria);
			$images = array();
			foreach ($imageObjects as $imageObject) {
				$images[] = $imageObject->getVar("image_filename");
			}
			$myRow = array(
				"item_id" => $item_id,
				"item_name" => $itemObject->getVar("item_name"),
				"images" => $images
			);
			$blockNumber = 'block' . intval($i/4);
			$mListData[$blockNumber][] = $myRow;
			$i++;
		}
	}
	$block = array();
	$block['checkedItemsList'] = $mListData;
	return $block;
}
