<?php
/**
 * @package bmcart
 * @version $Id: ItemDeleteAction.class.php,v 1.2 2007/08/24 14:17:42 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractDeleteAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/ItemAdminDeleteForm.class.php";

class bmcart_ItemDeleteAction extends bmcart_AbstractDeleteAction
{
	function _getId()
	{
		return xoops_getrequest('item_id');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('item');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new bmcart_ItemAdminDeleteForm();
		$this->mActionForm->prepare();
	}
	
	function _doExecute()
	{
		$handler =& xoops_getmodulehandler('item');
		$item =& $handler->get($this->mObject->get('item_id'));
				
		if (!$handler->delete($item)) {
			return BMCART_FRAME_VIEW_ERROR;
		}
		
		return BMCART_FRAME_VIEW_SUCCESS;
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("item_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=ItemList");
	}

	function executeViewError(&$controller,  &$render)
	{
		$controller->executeRedirect("./index.php?action=ItemList", 1, _MD_BMCART_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=ItemList");
	}
}