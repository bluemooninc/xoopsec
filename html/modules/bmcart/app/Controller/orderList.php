<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2012/12/31
 * Time: 10:29
 * To change this template use File | Settings | File Templates.
 */
require_once _MY_MODULE_PATH . 'app/Model/Order.php';
require_once _MY_MODULE_PATH . 'app/Model/Item.php';
require_once _MY_MODULE_PATH . 'app/Model/PageNavi.class.php';
require_once _MY_MODULE_PATH . 'app/View/view.php';
class Controller_OrderList extends AbstractAction {
	protected $mListData;
	protected $mListItems;
	protected $itemNames;
	protected $itemImages;
	public function __construct(){
		parent::__construct();
		$this->mHandler = Model_Order::forge();
	}
	public function action_index(){
		$this->mListData = $this->mHandler->getOrderList();
		$this->mHandler->HandlerInjection('itemImages');

		foreach($this->mListData as $object){
			$order_id = $object->getVar('order_id');
			$this->mListItems[$order_id] = $this->mHandler->getOrderItems($order_id);
		}
		$this->template = 'orderList.html';
	}
	public function action_orderDetail(){
		if (isset($this->mParams[0])) $order_id = intval($this->mParams[0]);
		$this->mListData = $this->mHandler->getOrderItems($order_id);
		$this->template = 'orderItems.html';
	}
	public function action_view(){
		$view = new View($this->root);
		$view->setTemplate($this->template);
		$view->set('ticket_hidden',$this->mTicketHidden);
		$view->set('ListData', $this->mListData);
		$view->set('ListItems', $this->mListItems);
		$view->set('itemNames', $this->itemNames);
		$view->set('shipping_fee', $this->mHandler->isShippingFee() );
		$view->set('total_amount', $this->mHandler->isTotalAmount() );
		if (is_object($this->mPagenavi)) {
			$view->set('pageNavi', $this->mPagenavi->getNavi());
		}
	}
}