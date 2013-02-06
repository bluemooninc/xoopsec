<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/CategoryFilterForm.class.php";

class bmcart_CategoryListAction extends bmcart_AbstractListAction
{
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('category');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =new bmcart_CategoryFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=CategoryList";
	}

	function executeViewIndex(&$controller, &$render)
	{
		$render->setTemplateName("category_list.html");
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
	}
}

