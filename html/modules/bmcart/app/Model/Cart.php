<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2012/12/31
 * Time: 10:31
 * To change this template use File | Settings | File Templates.
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class Model_Cart extends AbstractModel {
	protected $myHandler;
	protected $myObjects;
	protected $shipping_fee=0;
	protected $sub_total=0;
	protected $total_amount=0;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->_module_names = $this->getModuleNames();
		$this->myHandler =& xoops_getModuleHandler('cart');
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
			$instance = new Model_Cart();
		}
		return $instance;
	}
	private function &_getFromSession(){
		if(isset($_SESSION['cartObjects'])){
			$objects = $_SESSION['cartObjects'];
			$myObjects = array();
			foreach($objects as $object){
				$myObjects[] = unserialize($object);
			}
			return $myObjects;
		}
	}
	private function _update($uid){
		foreach($this->myObjects as $object){
			$object->set('uid',$uid);
			$this->myHandler->insert($object);
		}
	}
	private function _getMyCartItems()
	{
		$root = XCube_Root::getSingleton();
		if($root->mContext->mXoopsUser){
			$this->myObjects = $this->_getFromSession();
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('uid', Legacy_Utils::getUid()));
			$criteria->addSort('last_update', 'DESC');
			$this->_update(Legacy_Utils::getUid());
			$this->myHandler = xoops_getModuleHandler('cart');
			//$this->myObjects = array_merge($this->myHandler->getObjects($criteria),$this->_getFromSession());
			$this->myObjects = $this->myHandler->getObjects($criteria);
			$_SESSION['cartObjects'] = array();
		}else{
			$this->myObjects = $this->_getFromSession();
		}
	}

	public function &getCartList()
	{
		$this->_getMyCartItems();
		$itemHandler = xoops_getmodulehandler('item');
		$mListData = array();
		foreach ($this->myObjects as $object) {
			$itemObject = $itemHandler->get($object->getVar('item_id'));
			$amount = $itemObject->getVar('price') * $object->getVar('qty');
			$mListData[$object->getVar('cart_id')] = array(
				'cart_id' => $object->getVar('cart_id'),
				'item_id' => $itemObject->getVar('item_id'),
				'item_name' => $itemObject->getVar('item_name'),
				'price' => $itemObject->getVar('price'),
				'qty' => $object->getVar('qty'),
				'amount' => $amount
			);
			if ($this->shipping_fee < $itemObject->getVar('shipping_fee')) {
				$this->shipping_fee = $itemObject->getVar('shipping_fee');
			}
			$this->sub_total += $amount;
		}
		$this->total_amount = $this->sub_total + $this->shipping_fee;
		return $mListData;
	}
	public function &isSubTotal(){
		return $this->sub_total;
	}
	public function &isTotalAmount(){
		return $this->total_amount;
	}
	public function &isShippingFee(){
		return $this->shipping_fee;
	}
	public function update()
	{
		$this->_getMyCartItems();
		$root = XCube_Root::getSingleton();
		if (!$root->mContext->mXoopsUser) $_SESSION['cartObjects']=array();
		foreach ($this->myObjects as $object){
			$cart_id = $object->getVar('cart_id');
			if (isset($_POST['qty_'.$cart_id])){
				$qty = intval(xoops_getrequest('qty_'.$cart_id));
				$object->set('qty',$qty);
				$object->set('last_update',time());
				if($root->mContext->mXoopsUser){
					$this->myHandler->insert($object);
				} else{
					$_SESSION['cartObjects'][]=serialize($object);
				}
			}
		}
	}
	public function clearMyCart(){
		$this->myHandler->deleteAll(new Criteria('uid', Legacy_Utils::getUid()));
	}
}