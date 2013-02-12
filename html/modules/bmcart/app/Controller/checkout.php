<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2012/12/31
 * Time: 22:24
 * To change this template use File | Settings | File Templates.
 */
require_once _MY_MODULE_PATH . 'app/Model/Item.php';
require_once _MY_MODULE_PATH . 'app/Model/Cart.php';
require_once _MY_MODULE_PATH . 'app/Model/Checkout.php';
require_once _MY_MODULE_PATH . 'app/Model/MailBuilder.php';
require_once _MY_MODULE_PATH . 'app/Model/PageNavi.class.php';
require_once _MY_MODULE_PATH . 'app/View/view.php';

class Controller_Checkout extends AbstractAction {
	protected $myObject;
	protected $cartHandler;
	protected $cardList;
	protected $message;
	protected $stateOptions;

	public function __construct(){
		parent::__construct();
		$this->mHandler = Model_Checkout::forge();
		$this->cartHandler = Model_Cart::forge();
	}
	public function action_view(){
		$view = new View($this->root);
		if(isset($this->myObject)){
			$view->set('CurrentOrder', $this->myObject);
		}
		$view->set('stateOptions',$this->stateOptions);
		$view->set('Message', $this->message);
		$view->set('CardList', $this->cardList);
		$view->set('ListData', $this->mListData);
		$view->set('shipping_fee', $this->cartHandler->isShippingFee() );
		$view->set('total_amount', $this->cartHandler->isTotalAmount() );
		$view->set('ticket_hidden',$this->mTicketHidden);
		if (is_object($this->mPagenavi)) {
			$view->set('pageNavi', $this->mPagenavi->getNavi());
		}
		$view->setTemplate($this->template);
	}
	public function action_index(){
		$root = XCube_Root::getSingleton();
		if(!$root->mContext->mXoopsUser){
			redirect_header(XOOPS_URL."/user.php",3,_MD_BMCART_NEED_LOGIN);
		}
		$this->mListData = $this->cartHandler->getCartList();

		$itemHandler = Model_Item::forge();
		if (!$itemHandler->checkStock($this->mListData)){
			$this->message = $itemHandler->getMessage() . _MD_BMCART_NO_STOCK;
		}
		$this->myObject = $this->mHandler->getCurrentOrder();
		$creditService = $this->root->mServiceManager->getService('gmoPayment');
		if ($creditService != null) {
			$client = $this->root->mServiceManager->createClient($creditService);
			$this->cardList = $client->call('getRegisteredCardList',null);
		}
		$this->template = 'checkout.html';
	}
	public function action_editAddress(){
		$this->myObject = $this->mHandler->getCurrentOrder();
		$this->template = 'editAddress.html';
		$this->stateOptions = $this->mHandler->getStateOptions();
	}
	public function action_addNewAddress(){
		$this->mHandler->addNewAddress();
		$this->action_editAddress();
	}
	public function action_updateAddress(){
		$this->mHandler->update();
		$this->action_index();
	}
	public function action_selectPayment(){
		$this->myObject = $this->mHandler->getCurrentOrder();
		$this->template = 'selectPayment.html';
	}

	/**
	 * Credit Card API
	 *
	 * TODO: Paypal and other transit in the future
	 * @param $cardOrderId
	 * @param $amount
	 * @param $tax
	 * @param $cardSeq
	 * @return bool
	 */
	private function _payByCreditCard ($cardOrderId,$amount,$tax,$cardSeq){
		$ret = false;
		$params = array('order_id' => $cardOrderId,'cardSeq'=>$cardSeq,'amount'=>$amount,'tax'=>$tax);
		$creditService = $this->root->mServiceManager->getService('gmoPayment');
		if ($creditService != null) {
			$client = $this->root->mServiceManager->createClient($creditService);
			$ret = $client->call('entryTransit',$params);
		}
		return $ret;
	}

	/**
	 * Check out method
	 */
	public function action_orderFixed(){
		global $xoopsModuleConfig;
		$this->myObject = $this->mHandler->getCurrentOrder();
		if (!$this->mHandler->checkCurrentOrder($this->myObject)){
			redirect_header( "index", 3, $this->mHandler->getMessage());
		}
		$order_id = intval(xoops_getrequest("order_id"));
		$cardOrderId = null;
		$payment_type = intval(xoops_getrequest("payment_type"));
		$cardSeq = intval(xoops_getrequest("CardSeq"));
		$this->mListData = $this->cartHandler->getCartList();
		$shipping_fee = $this->cartHandler->isShippingFee();
		$amount = $this->cartHandler->isTotalAmount();
		$sub_total = $this->cartHandler->isSubTotal();
		$tax  = intval($sub_total * ($xoopsModuleConfig['sales_tax']/100));

		$ret = false;
		$itemHandler = Model_Item::forge();
		if (!$itemHandler->checkStock($this->mListData)){
			redirect_header( XOOPS_URL."/modules/bmcart/cartList", 3, $this->mHandler->getMessage()._MD_BMCART_NO_STOCK);
		}
		switch($payment_type){
			case 1: // Wire transfer
                $ret = true;
				break;
			case 2: // Pay by Card
				$cardOrderId = sprintf("%s%08d",date("ym"),$order_id);
				$ret = $this->_payByCreditCard($cardOrderId,$amount,$tax,$cardSeq);
				break;
		}
		if( $ret==true ){
			$this->mHandler->moveCartToOrder($this->mListData,$order_id);
			$this->cartHandler->clearMyCart();
			$this->mHandler->setOrderStatus($order_id,$payment_type,$cardOrderId,$sub_total,$tax,$shipping_fee,$amount);
			$orderObject = $this->mHandler->myObject();
			$mail = new Model_Mail();
			$mail->sendMail("ThankYouForOrder.tpl",$orderObject,$this->mListData,_MD_BMCART_ORDER_MAIL);
			$this->executeRedirect(XOOPS_URL."/modules/bmcart/orderList/index", 5, 'Done');
		}
	}
}