<?php
/**
 * @package user
 * @version $Id: TableAdminExportForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class bmcart_TableAdminExportForm extends XCube_ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = false;
	var $mFormFile = null;

	function getTokenName()
	{
		return "module.bmcart.TableAdminExportForm.TOKEN" . $this->get('category_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['category_id'] =new XCube_IntProperty('category_id');
		$this->mFormProperties['category_name'] =new XCube_StringProperty('category_name');
		$this->mFormProperties['parent_id'] =new XCube_IntProperty('parent_id');

		//
		// Set field properties
		//

		$this->mFieldProperties['category_name'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['category_name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['category_name']->addMessage('required', _MD_BMCSV_ERROR_REQUIRED, _AD_BMCSV_ITEM_NAME, '255');
		$this->mFieldProperties['category_name']->addMessage('maxlength', _MD_BMCSV_ERROR_MAXLENGTH, _AD_BMCSV_ITEM_NAME, '255');
		$this->mFieldProperties['category_name']->addVar('maxlength', '255');

	}

	function load(&$obj)
	{
		$this->set('category_id', $obj->get('category_id'));
		$this->set('category_name', $obj->get('category_name'));
		$this->set('parent_id', $obj->get('parent_id'));
	}

	function update(&$obj)
	{
		$obj->set('category_id', $this->get('category_id'));
		$obj->set('category_name', $this->get('category_name'));
		$obj->set('parent_id', $this->get('parent_id'));
	}

}

?>
