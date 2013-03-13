<?php
/*
 *  Copyright (c) : Y.Sakai @ Bluemoon inc. All left reserved.
 *  Licence : GPL V3
 */
include_once dirname(__FILE__)."/class/BmCart_Search.class.php";

eval('
function bmcart_global_search( $keywords , $andor , $limit , $offset , $uid )
{
	return bmcart_global_search_base( "bmcart" , $keywords , $andor , $limit , $offset ) ;
}
');

if (!function_exists('bmcart_global_search_base')) {

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
		$bms = new BmCart_Search();
		if (isset($uid) && $uid>0){
			$bms->searchByUid($uid);
			return $bms->getSearchResults();
		}else{
			return $bms->bmcart_itemSearch($keywords, $andor);
		}
	}

}
