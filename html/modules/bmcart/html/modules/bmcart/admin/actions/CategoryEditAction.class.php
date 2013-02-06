<?php
/**
 * @package bmcart
 * @version $Id: CategoryEditAction.class.php,v 1.1 2007/05/15 02:34:41 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/CategoryAdminEditForm.class.php";

class bmcart_CategoryEditAction extends bmcart_AbstractEditAction
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
		$this->mActionForm =new bmcart_CategoryAdminEditForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("category_edit.html");
		$render->setAttribute("actionForm", $this->mActionForm);
		$categoryHandler = $this->_getHandler();
		$render->setAttribute("categoryOptions", $categoryHandler->getCategoryOptions());
	}

	function executeViewSuccess(&$controller, &$render)
	{
		$controller->executeForward("index.php?action=CategoryList");
	}

	function executeViewError(&$controller, &$render)
	{
		$controller->executeRedirect("index.php?action=CategoryList", 5, _MD_BMCART_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$render)
	{
		$controller->executeForward("index.php?action=CategoryList");
	}
}
