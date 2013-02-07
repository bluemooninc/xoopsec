<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/ImageFilterForm.class.php";

class bmcart_ImageListAction extends bmcart_AbstractListAction
{
	protected $item_id;
	protected $itemObject;

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('itemImages');
		return $handler;
	}

	function &_getFilterForm()
	{
		$root =& XCube_Root::getSingleton();
		$this->item_id = $root->mContext->mRequest->getRequest('item_id');
		$itemHandler =& xoops_getmodulehandler('item');
		$this->itemObject = $itemHandler->get($this->item_id);
		$filter =new bmcart_ImageFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=ImageList";
	}

	function executeViewIndex(&$controller, &$render)
	{
		$render->setTemplateName("image_list.html");
		$render->setAttribute("item_id", $this->item_id);
		$render->setAttribute("itemObject", $this->itemObject);
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
		$categoryHandler = xoops_getmodulehandler('category');
		$render->setAttribute("categoryList", $categoryHandler->getCategoryOptions());
	}
}

