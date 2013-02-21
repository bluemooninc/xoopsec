<?php
/*
 * B.M.Cart - Cart Module on XOOPS Cube v2.2
 * Copyright (c) Bluemoon inc. All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
include_once dirname(dirname(__FILE__)) . "/class/bmcart_session.php";

function b_bmcart_bookmarkItems_show()
{
	$uid = Legacy_Utils::getUid();
	if (!$uid || $uid == 0) return NULL;
	$mydirname = basename(dirname(dirname(__FILE__)));
	$handler =& xoops_gethandler('notification');
	$itemHandler = xoops_getmodulehandler("item", "bmcart");
	$imageHandler = xoops_getmodulehandler("itemImages", "bmcart");
	$mHandler =& xoops_gethandler('module');
	$xoopsModule = $mHandler->getByDirname($mydirname);
	$block = $mListData = array();
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('not_modid', $xoopsModule->getVar('mid')));
	$criteria->add(new Criteria('not_event', 'bookmark'));
	$criteria->add(new Criteria('not_uid', $uid));
	$objects = $handler->getObjects($criteria);
	if ($objects) {
		$i = 0;
		foreach ($objects as $object) {
			$item_id = $object->getVar('not_itemid');
			$itemObject = $itemHandler->get($item_id);
			if ($itemObject) {
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
				$blockNumber = 'block' . intval($i / 4);
				$mListData[$blockNumber][] = $myRow;
				$i++;
			}
		}
	}
	$block['bookmarkItemsList'] = $mListData;
	return $block;
}
