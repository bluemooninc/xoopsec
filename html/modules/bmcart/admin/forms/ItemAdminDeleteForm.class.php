<?php
/**
 * @package user
 * @version $Id: UserAdminDeleteForm.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

class bmcart_ItemAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.user.ItemAdminDeleteForm.TOKEN" . $this->get('item_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['item_id'] =new XCube_IntProperty('item_id');

		//
		// Set field properties
		//
		$this->mFieldProperties['item_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['item_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['item_id']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _MD_BMCART_ITEMID);
	}

	function load(&$obj)
	{
		$this->set('item_id', $obj->get('item_id'));
	}

	function update(&$obj)
	{
		$obj->setVar('item_id', $this->get('item_id'));
	}
}

?>
