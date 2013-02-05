<?php
/**
 * Created by JetBrains PhpStorm.
 * Order: bluemooninc
 * Date: 2012/12/08
 * Time: 10:20
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/OrderFilterForm.class.php";

class bmcart_OrderListAction extends bmcart_AbstractListAction
{
	function &_getHandler()
	{
		$handler =& xoops_getModuleHandler('order');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =new bmcart_OrderFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=OrderList";
	}

	function executeViewIndex(&$controller, &$render)
	{
		$render->setTemplateName("order_list.html");
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
	}
}