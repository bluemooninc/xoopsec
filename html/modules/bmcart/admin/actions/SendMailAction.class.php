<?php
/**
 * Created by JetBrains PhpStorm.
 * Transit: bluemooninc
 * Date: 2012/12/08
 * Time: 10:20
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/OrderAdminTransitForm.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/app/Model/MailBuilder.php";
require_once XOOPS_MODULE_PATH . "/bmcart/app/Model/Order.php";


class bmcart_SendMailAction extends bmcart_AbstractEditAction
{
	function _getId()
	{
		return xoops_getrequest('order_id');
	}
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('order');
		return $handler;
	}
	function _setupActionForm()
	{
		$this->mActionForm = new bmcart_OrderAdminTransitForm();
		$this->mActionForm->prepare();
	}

	function _doExecute()
	{
		$modelOrder = Model_Order::forge();
		$order_id = $this->mObject->get('order_id');
		$orderObject = $modelOrder->get($order_id);
		$uid = $orderObject->getVar('uid');
		$mListData = $modelOrder->getOrderItems($order_id);
		// TODO: Paypal and other needs make options in the future
		if ($orderObject != null) {
			$userHandler = xoops_gethandler('user');
			$userObject = $userHandler->get($uid);
			$mail = new Model_Mail();
			$result = $mail->sendMail("ShippingNow.tpl",$orderObject,$mListData,_AD_BMCART_SHIPPING_MAIL,$userObject);
		}else{
			$result = false;
		}
		if (!$result) {
			return BMCART_FRAME_VIEW_ERROR;
		}else{
			$orderObject->set('notify_date',time());
			$modelOrder->insert($orderObject);
			return BMCART_FRAME_VIEW_SUCCESS;
		}
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("shipping_mail.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=OrderList");
	}

	function executeViewError(&$controller,  &$render)
	{
		$controller->executeRedirect("./index.php?action=OrderList", 3, _MD_BMCART_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=OrderList");
	}
}