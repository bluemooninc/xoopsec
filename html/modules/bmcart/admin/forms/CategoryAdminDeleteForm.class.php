<?php
/**
 * @package user
 * @version $Id: UserAdminDeleteForm.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

class bmcart_CategoryAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.user.CategoryAdminDeleteForm.TOKEN" . $this->get('category_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['category_id'] =new XCube_IntProperty('category_id');

		//
		// Set field properties
		//
		$this->mFieldProperties['category_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['category_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['category_id']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _MD_BMCART_ITEMID);
	}

	function load(&$obj)
	{
		$this->set('category_id', $obj->get('category_id'));
	}

	function update(&$obj)
	{
		$obj->setVar('category_id', $this->get('category_id'));
	}
}

?>
