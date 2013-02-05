<?php
/**
 * @package bmcart
 * @version $Id: CategoryDeleteAction.class.php,v 1.2 2007/08/24 14:17:42 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractDeleteAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/CategoryAdminDeleteForm.class.php";

class bmcart_CategoryDeleteAction extends bmcart_AbstractDeleteAction
{
	function _getId()
	{
		return xoops_getrequest('category_id');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('category');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =new bmcart_CategoryAdminDeleteForm();
		$this->mActionForm->prepare();
	}
	
	function _doExecute()
	{
		$handler =& xoops_getmodulehandler('category');
		$category =& $handler->get($this->mObject->get('category_id'));
				
		if (!$handler->delete($category)) {
			return BMCART_FRAME_VIEW_ERROR;
		}
		
		return BMCART_FRAME_VIEW_SUCCESS;
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("category_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=CategoryList");
	}

	function executeViewError(&$controller,  &$render)
	{
		$controller->executeRedirect("./index.php?action=CategoryList", 1, _MD_BMCART_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=CategoryList");
	}
}