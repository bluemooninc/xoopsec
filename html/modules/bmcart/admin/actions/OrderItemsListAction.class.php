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
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/OrderItemsFilterForm.class.php";

class bmcart_OrderItemsListAction extends bmcart_AbstractListAction
{
	function &_getHandler()
	{
		$handler =& xoops_getModuleHandler('orderItems');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =new bmcart_OrderItemsFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=OrderItemsList";
	}
	private  function &_getItemObjects(&$orderItems){
		$handler =& xoops_getModuleHandler('item');
		$itemObjects = array();
		foreach($orderItems as $orderItem){
			$itemObject = $handler->get($orderItem->getVar('item_id'));
			$itemObjects[$orderItem->getVar('item_id')] = $itemObject->getVar('item_name');
		}
		return $itemObjects;
	}

	function executeViewIndex(&$controller, &$render)
	{
		$render->setTemplateName("orderItems_list.html");
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("itemObjects",$this->_getItemObjects($this->mObjects));
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
	}
}