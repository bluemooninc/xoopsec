<?php

eval('
function bmcart_global_search( $keywords , $andor , $limit , $offset , $uid )
{
	return bmcart_global_search_base( "bmcart" , $keywords , $andor , $limit , $offset ) ;
}
');


if (!function_exists('bmcart_global_search_base')) {
	/**
	 * JAN/EAN/UPC/ISBN barcode search
	 *
	 * @param $criteria
	 * @param $keyword
	 */
	function bmcart_make_seqrch_sql(&$criteria,$keyword){
		if ( preg_match("/[0-9]{10,13}/", $keyword )) {
			$criteria->add(new Criteria('barcode', $keyword . '%', 'LIKE'));
		} else {
			$criteria->add(new Criteria('item_name', '%' . $keyword . '%', 'LIKE'));
		}
	}

	/**
	 * title keyword and barcode search
	 *
	 * @param $keywords
	 * @param $andor
	 * @return array
	 */
	function &bmcart_itemSearch($keywords, $andor){
		$criteria = new CriteriaCompo();
		// where by keywords
		if (is_array($keywords) && count($keywords) > 0) {
			switch (strtolower($andor)) {
				case "and" :
					foreach ($keywords as $keyword) {
						bmcart_make_seqrch_sql($criteria,$keyword);
					}
					break;
				case "or" :
					foreach ($keywords as $keyword) {
						bmcart_make_seqrch_sql($criteria,$keyword);
					}
					break;
				default :
					bmcart_make_seqrch_sql($criteria,$keywords[0]);
					break;
			}
		}
		$handler = xoops_getmodulehandler('item', 'bmcart');
		$objects = $handler->getobjects($criteria);
		$ret = array();
		foreach ($objects as $object) {
			$imageHandler = xoops_getmodulehandler('itemImages', 'bmcart');
			$criteria = new Criteria('item_id', $object->getVar('item_id'));
			$imageObjects = $imageHandler->getobjects($criteria);
			$imageLink = "";
			if ($imageObjects) {
				$imageLink = "s_" . $imageObjects[0]->getVar('image_filename');
			}
			$title = sprintf("%s (&yen;%s-)", $object->getVar('item_name'), number_format($object->getVar('price')));
			$ret[] = array(
				'image' => $imageLink,
				'link' => 'itemList/itemDetail/' . $object->getVar('item_id'),
				'title' => $title,
				'time' => $object->getVar('last_update')
			);
		}
		return $ret;
	}
	/**
	 * Get small image
	 *
	 * @param $item_id
	 * @param $imageHandler
	 * @return string
	 */
	function bmcart_getItemImage($item_id,&$imageHandler){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_id', $item_id));
		$criteria->addsort('weight','ASC');
		$imageObjects = $imageHandler->getobjects($criteria);
		if ($imageObjects) {
			return "s_" . $imageObjects[0]->getVar('image_filename');
		}
	}
	/**
	 * For order items using account information
	 *
	 * @param $uid
	 * @return array
	 */
	function &bmcart_orderSearch($uid){
		$criteria = new CriteriaCompo();
		$handler = xoops_getmodulehandler('order', 'bmcart');
		$criteria->add(new Criteria('uid',$uid));
		$criteria->addsort('order_date','DESC');
		$objects = $handler->getobjects($criteria);
		$itemHandler = xoops_getmodulehandler('item', 'bmcart');
		$orderItemsHandler = xoops_getmodulehandler('OrderItems', 'bmcart');
		$imageHandler = xoops_getmodulehandler('itemImages', 'bmcart');
		$ret = array();
		foreach ($objects as $object) {
			$criteria = new Criteria('order_id', $object->getVar('order_id'));
			$orderItemsObjects = $orderItemsHandler->getobjects($criteria);
			foreach($orderItemsObjects as $orderItemObject){
				$item_id = $orderItemObject->getVar('item_id');
				$imageLink = bmcart_getItemImage($item_id,$imageHandler);
				$itemObject = $itemHandler->get($item_id);
				$item_name = $itemObject ? $itemObject->getVar('item_name') : NULL;
				$ret[] = array(
					'image' => $imageLink,
					'link' => 'itemList/itemDetail/' . $orderItemObject->getVar('item_id'),
					'title' => $item_name,
					'time' => $object->getVar('order_date')
				);
			}
		}
		return $ret;
	}

	/**
	 * Search general
	 *
	 * @param $mydirname
	 * @param $keywords
	 * @param $andor
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	function bmcart_global_search_base($mydirname, $keywords, $andor, $limit, $offset)
	{
		$root =& XCube_Root::getSingleton();
		$uid = $root->mContext->mRequest->getRequest('uid');
		if (isset($uid) && $uid>0){
			return bmcart_orderSearch($uid);
		}else{
			return bmcart_itemSearch($keywords, $andor);
		}
	}

}


?>