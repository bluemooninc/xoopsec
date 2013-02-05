<?php
/*
 * B.M.Cart - Cart Module on XOOPS Cube v2.2
 * Copyright (c) Bluemoon inc. All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
include_once dirname(dirname(__FILE__))."/class/bmcart_session.php";

function b_bmcart_checkedItems_show()
{
	// For Category Selector
	$handler = xoops_getmodulehandler("checkedItems", "bmcart");
	$itemHandler = xoops_getmodulehandler("item", "bmcart");
	$imageHandler = xoops_getmodulehandler("itemImages", "bmcart");
	$criteria = new CriteriaCompo();
	$uid = Legacy_Utils::getUid();
	$bmcart_session = new bmcart_session();
	if ($uid){
		if ($SessionObjects = $bmcart_session->getObjects('checkedItems')){
			$bmcart_session->setCheckedItems($SessionObjects,$uid);
			$bmcart_session->clearSession('checkedItems');
		}
		$criteria->add(new Criteria('uid',$uid));
		$criteria->addsort('last_update', 'desc');
		$objects = $handler->getObjects($criteria, 0, 10);
	}else{
		$objects = $bmcart_session->getObjects('checkedItems');
	}
	$mListData = array();
	$i=0;
	foreach ($objects as $object) {
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
	//adump($mListData);die;
	$block = array();
	$block['checkedItemsList'] = $mListData;
	return $block;
}
