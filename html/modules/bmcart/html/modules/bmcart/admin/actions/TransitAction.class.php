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

class bmcart_TransitAction extends bmcart_AbstractEditAction
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
		$root = XCube_Root::getSingleton();
		$handler =& xoops_getmodulehandler('order');
		$order =& $handler->get($this->mObject->get('order_id'));
		// TODO: Paypal and other needs make options in the future
		$creditService = $root->mServiceManager->getService('gmoPayment');
		if ($creditService != null) {
			$orderId = $order->getVar('card_order_id');
			$uid = $order->getVar('uid');
			$client = $root->mServiceManager->createClient($creditService);
			$result = $client->call('execTranByModule',array('orderId'=>$orderId,'uid'=>$uid));
		}

		if (!$result) {
			return BMCART_FRAME_VIEW_ERROR;
		}
		$order->set('paid_date',time());
		$handler->insert($order);
		return BMCART_FRAME_VIEW_SUCCESS;
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("order_transit.html");
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