<?php
/**
 * @package bmcart
 * @version $Id: ImageEditAction.class.php,v 1.1 2007/05/15 02:34:41 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/ImageAdminEditForm.class.php";

class bmcart_ImageEditAction extends bmcart_AbstractEditAction
{
	function _getId()
	{
		return xoops_getrequest('image_id');
	}
	
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('itemImages');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new bmcart_ImageAdminEditForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("image_edit.html");
		$render->setAttribute("actionForm", $this->mActionForm);
		$itemHandler = xoops_getmodulehandler('item');
		$render->setAttribute("itemOptions", $itemHandler->getItemOptions());
	}

	function executeViewSuccess(&$controller, &$render)
	{
		$controller->executeForward("index.php?action=ImageList&item_id=".xoops_getrequest('item_id'));
	}

	function executeViewError(&$controller, &$render)
	{
		$controller->executeRedirect("index.php?action=ImageList", 5, _MD_BMCART_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$render)
	{
		$controller->executeForward("index.php?action=ImageList");
	}
}
