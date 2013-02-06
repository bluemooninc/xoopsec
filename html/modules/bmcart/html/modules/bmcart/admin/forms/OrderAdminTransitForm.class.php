<?php
/**
 * @package user
 * @version $Id: UserAdminTransitForm.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

class bmcart_OrderAdminTransitForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.user.OrderAdminTransitForm.TOKEN" . $this->get('order_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['order_id'] =new XCube_IntProperty('order_id');

		//
		// Set field properties
		//
		$this->mFieldProperties['order_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['order_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['order_id']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _MD_BMCART_ITEMID);
	}

	function load(&$obj)
	{
		$this->set('order_id', $obj->get('order_id'));
	}

	function update(&$obj)
	{
		$obj->setVar('order_id', $this->get('order_id'));
	}
}
