<?php
/**
 * Copyright(c): Bluemoon inc. 2013
 * Author: Y.SAKAI
 * Licence : GPL Ver.3
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2012/12/31
 * Time: 10:31
 * To change this template use File | Settings | File Templates.
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class Model_Checkout
{
	protected $myHandler;
	protected $myObjects;
	protected $message;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->_module_names = $this->getModuleNames();
		$this->myHandler = xoops_getModuleHandler('order');
	}

	/**
	 * get Instance
	 * @param none
	 * @return object Instance
	 */
	public function &forge()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new Model_Checkout();
		}
		return $instance;
	}

	protected function getModuleNames($isactive = FALSE)
	{
		$criteria = new CriteriaCompo();
		if ($isactive) {
			$criteria->add(new Criteria('isactive', '1', '='));
		}
		$module_handler =& xoops_gethandler('module');
		$objs = $module_handler->getObjects($criteria);
		$ret = array();
		foreach ($objs as $obj) {
			$ret[$obj->getVar('mid')] = $obj->getVar('name');
		}
		return $ret;
	}

	/**
	 * @param null $order_id
	 */
	private function _getMyOrder($order_id = null)
	{
		$criteria = new CriteriaCompo();
		if (!is_null($order_id)) {
			// get fixed order
			$criteria->add(new Criteria('order_id', $order_id));
		} else {
			// get current order
			$criteria->add(new Criteria('order_date', null));
		}
		$criteria->add(new Criteria('uid', Legacy_Utils::getUid()));
		$this->myObjects = $this->myHandler->getObjects($criteria);
	}

	private function &_getMyLastOrder()
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('uid', Legacy_Utils::getUid()));
		$criteria->addSort('order_date', 'DESC');
		return $this->myHandler->getObjects($criteria);
	}

	public function checkCurrentOrder($orderObject){
		$checkArray = array(
			'first_name'=>_MD_BMCART_FIRSTNAME,
			'last_name'=>_MD_BMCART_LASTNAME,
			'zip_code'=>_MD_BMCART_ZIP_CODE,
			'state'=>_MD_BMCART_STATE,
			'address'=>_MD_BMCART_ADDRESS,
			'phone'=>_MD_BMCART_PHONE
		);
		foreach($checkArray as $key=>$val){
			if (!$orderObject->getVar($key)){
				$this->message = $val . _MD_BMCART_CHECK_YOUR_ADDRESS."(1)" ;
				return false;
			}else{
				if ($key=="zip_code"){
					if (!preg_match("/^\d{3}-\d{4}$/",$orderObject->getVar($key))){
						$this->message = $val . _MD_BMCART_CHECK_YOUR_ADDRESS."(2)" ;
						return false;
					}
				}elseif($key=="phone"){
					if (!preg_match("/^0\d{1,4}-\d{1,4}-\d{4}$/", $orderObject->getVar($key))){
						$this->message = $val . _MD_BMCART_CHECK_YOUR_ADDRESS."(3)" ;
						return false;
					}
				}

			}
		}
		return true;
	}

	public function getCurrentOrder()
	{
		$this->_getMyOrder();
		if (count($this->myObjects) > 0) {
			return $this->myObjects[0];
		} else {
			$newObject = $this->myHandler->create();
			$objects = $this->_getMyLastOrder();
			if (count($objects) > 0) {
				$newObject->set('first_name', $objects[0]->getVar('first_name'));
				$newObject->set('last_name', $objects[0]->getVar('last_name'));
				$newObject->set('zip_code', $objects[0]->getVar('zip_code'));
				$newObject->set('state', $objects[0]->getVar('state'));
				$newObject->set('address', $objects[0]->getVar('address'));
				$newObject->set('address2', $objects[0]->getVar('address2'));
				$newObject->set('phone', $objects[0]->getVar('phone'));
				$newObject->set('sub_total', $objects[0]->getVar('sub_total'));
				$newObject->set('tax', $objects[0]->getVar('tax'));
				$newObject->set('shipping_fee', $objects[0]->getVar('shipping_fee'));
				$newObject->set('amount', $objects[0]->getVar('amount'));
			}
			$this->myHandler->insert($newObject, true);
			return $newObject;
		}
		return null;
	}

	public function addNewAddress()
	{
		$object = $this->myHandler->create();
		$this->myHandler->insert($object, true);
	}

	public function update()
	{
		$this->_getMyOrder();
		if ($this->myObjects) {
			$object = $this->myObjects[0];
			$object->set('first_name', xoops_getrequest('first_name'));
			$object->set('last_name', xoops_getrequest('last_name'));
			$object->set('phone', xoops_getrequest('phone'));
			$object->set('zip_code', xoops_getrequest('zip_code'));
			$object->set('state', trim(xoops_getrequest('state')));
			$object->set('address', xoops_getrequest('address'));
			$object->set('address2', xoops_getrequest('address2'));
			$this->myHandler->insert($object);
		}
	}

	public function setOrderStatus($order_id,$payment_type, $cardOrderId = null,$subTotal,$tax,$shipping_fee,$amount)
	{
		$this->_getMyOrder($order_id);
		$ret = false;
		if ($this->myObjects) {
			$object = $this->myObjects[0];
			$object->set('payment_type', $payment_type);
			$object->set('card_order_id', $cardOrderId);
			$object->set('sub_total', $subTotal);
			$object->set('tax', $tax);
			$object->set('shipping_fee', $shipping_fee);
			$object->set('amount', $amount);
			$object->set('order_date', time());
			$this->myHandler->insert($object);
			$ret = true;
		}
		return $ret;
	}
	public function &myObject(){
		return $this->myObjects[0];
	}
	public function getMessage(){
		return $this->message;
	}

	/**
	 * @param $ListData
	 * @param $order_id
	 */
	public function moveCartToOrder($ListData, $order_id){
		$itemHandler = xoops_getModuleHandler('item');
		$skuHandler = xoops_getModuleHandler('itemSku');
		$orderItemHandler = xoops_getModuleHandler('orderItems');
		foreach ($ListData as $orderObject) {
			$itemObject = $itemHandler->get($orderObject['item_id']);
			$skuObject = $skuHandler->get($orderObject['sku_id']);
			// Check Stock 1st
			if($skuObject){
				$stock = $skuObject->getVar('sku_stock');
			}else{
				$stock = $itemObject->getVar('stock_qty');
			}
			if ( $stock>0 && $stock >= $orderObject['qty'] ){
				$itemHandler->insert($itemObject);
				$addObject = $orderItemHandler->create();
				$addObject->set('order_id', $order_id);
				$addObject->set('item_id', $orderObject['item_id']);
				$addObject->set('sku_id', $orderObject['sku_id']);
				$addObject->set('price', $orderObject['price']);
				$addObject->set('qty', $orderObject['qty']);
				$result = $orderItemHandler->insert($addObject);
				if ($result){
					$newStock = $stock -  $orderObject['qty'];
					if($skuObject){
						$skuObject->set('sku_stock',$newStock);
						$skuHandler->insert($skuObject);
					}else{
						$itemObject->set('stock_qty',$newStock);
						$itemHandler->insert($itemObject);
					}
				}
			}
		}
	}

	public function &getStateOptions(){
		$stateArray = explode(",",_MD_BMCART_STATE_OPTIONS);
		$ret=array();
		foreach($stateArray as $state){
			$ret[$state]=$state;
		}
		return $ret;
	}
}