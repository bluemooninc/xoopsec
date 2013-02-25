<?php
/**
 * @package bmcart
 * @version $Id: ImageDeleteAction.class.php,v 1.2 2007/08/24 14:17:42 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractDeleteAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcart/admin/forms/ImageAdminDeleteForm.class.php";

class bmcart_ImageDeleteAction extends bmcart_AbstractDeleteAction
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
		$this->mActionForm =new bmcart_ImageAdminDeleteForm();
		$this->mActionForm->prepare();
	}
	
	function _doExecute()
	{
		$handler =& xoops_getmodulehandler('itemImages');
		$item =& $handler->get($this->mObject->get('image_id'));
		$original_filename = XOOPS_ROOT_PATH."/uploads/".$item->getVar('image_filename');
		$mid_filename = XOOPS_ROOT_PATH."/uploads/m_".$item->getVar('image_filename');
		$small_filename = XOOPS_ROOT_PATH."/uploads/s_".$item->getVar('image_filename');

		if (file_exists($original_filename)){
			unlink($original_filename);
		}
		if (file_exists($mid_filename)){
			unlink($mid_filename);
		}
		if (file_exists($small_filename)){
			unlink($small_filename);
		}

		if (!$handler->delete($item)) {
			return BMCART_FRAME_VIEW_ERROR;
		}
		
		return BMCART_FRAME_VIEW_SUCCESS;
	}

	function executeViewInput(&$controller, &$render)
	{
		$render->setTemplateName("image_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=ImageList&item_id=".xoops_getrequest('item_id'));
	}

	function executeViewError(&$controller,  &$render)
	{
		$controller->executeRedirect("./index.php?action=ImageList&item_id=".xoops_getrequest('item_id'), 1, _MD_BMCART_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller,  &$render)
	{
		$controller->executeForward("./index.php?action=ImageList&item_id=".xoops_getrequest('item_id'));
	}
}