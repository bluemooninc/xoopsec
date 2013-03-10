<?php
/**
 * Created by JetBrains PhpStorm.
 * Copyright(c): Bluemoon inc.
 * Author : Yoshi Sakai
 * Date: 2013/03/07
 * Time: 9:55
 * To change this template use File | Settings | File Templates.
 */

if (!function_exists('json_decode')) {
	throw new Exception('Controller_JsonApi needs the JSON PHP extension.');
}
class Controller_JsonApi extends AbstractAction {
	protected $linkUrl = '<script type="text/javascript"><!--
amazon_ad_tag = "bluemoon0b2c-22"; amazon_ad_width = "728"; amazon_ad_height = "90";//--></script>
<script type="text/javascript" src="http://www.assoc-amazon.jp/s/ads.js"></script>';
	private function _output( &$response = null) {
		header("Content-Type: application/json; charset=utf-8");
		exit(json_encode( $response ));
	}
	private function _setLinkUrl($url=""){
		$this->linkUrl = $url;
	}
	public function action_getMyApp(){
		$jsonStrings = base64_decode( $this->mParams[0] );
		$jsonObject = json_decode($jsonStrings,true);
		if (array_key_exists('app_userName',$jsonObject) && array_key_exists('app_orderId',$jsonObject)){
			$uname = $jsonObject['app_userName'];
			$order_id = intval($jsonObject['app_orderId']);
			$criteria = new Criteria("uname",$uname);
			$userHandler = xoops_getmodulehandler('users','user');
			$objects = $userHandler->getObjects($criteria);
			if ($objects){
				$orderHandler = xoops_getmodulehandler('order','bmcart');
				$orderObject = $orderHandler->get($order_id);
				if ($objects[0]->getVar('uid') == $orderObject->getVar('uid')){
					$this->_setLinkUrl();
				}
			}
		}
		$jsonObject['linkUrl'] = $this->linkUrl;
		$this->_output( $jsonObject );
	}
}