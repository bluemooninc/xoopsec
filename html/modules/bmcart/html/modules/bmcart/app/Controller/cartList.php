<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2012/12/31
 * Time: 10:29
 * To change this template use File | Settings | File Templates.
 */
require_once _MY_MODULE_PATH . 'app/Model/Item.php';
require_once _MY_MODULE_PATH . 'app/Model/Cart.php';
require_once _MY_MODULE_PATH . 'app/Model/PageNavi.class.php';
require_once _MY_MODULE_PATH . 'app/View/view.php';
class Controller_CartList extends AbstractAction {
	protected $mListData;
	public function __construct(){
		parent::__construct();
		$this->mHandler = Model_Cart::forge();
	}
	public function action_index(){
		$this->mListData = $this->mHandler->getCartList();
		$itemHandler = Model_Item::forge();
		if (!$itemHandler->checkStock($this->mListData)){
			$this->message = $itemHandler->getMessage();
		}
		$this->template = 'cartList.html';
	}
	public function action_removeItem(){
		if (isset($this->mParams[0])) $cart_id = intval($this->mParams[0]);
		$cartHandler = xoops_getmodulehandler('cart');
		if ($object = $cartHandler->get($cart_id)){
			if ( $object->getVar('uid')==Legacy_Utils::getUid() ){
				$cartHandler->delete($object,true);
			}
		}
		$this->action_index();
	}
	public function action_update(){
		$this->mHandler->update();
		if (isset($_POST['checkout'])){
			$this->executeRedirect("../checkout", 3, 'Checkout');
		}
		$this->action_index();
	}
	public function action_view(){
		$view = new View($this->root);
		$view->setTemplate($this->template);
		$view->set('Message', $this->message);
		$view->set('ticket_hidden',$this->mTicketHidden);
		$view->set('ListData', $this->mListData);
		$view->set('shipping_fee', $this->mHandler->isShippingFee() );
		$view->set('total_amount', $this->mHandler->isTotalAmount() );
		if (is_object($this->mPagenavi)) {
			$view->set('pageNavi', $this->mPagenavi->getNavi());
		}
	}
}