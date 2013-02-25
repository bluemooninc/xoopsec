<?php
/**
 * @package user
 * @version $Id: UserAdminDeleteForm.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

class bmcart_ImageAdminDeleteForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.user.ImageAdminDeleteForm.TOKEN" . $this->get('image_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['image_id'] =new XCube_IntProperty('image_id');
		$this->mFormProperties['item_id'] =new XCube_IntProperty('item_id');
		$this->mFormProperties['image_filename'] = new XCube_StringProperty('image_filename');
		//
		// Set field properties
		//
		$this->mFieldProperties['image_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['image_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['image_id']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _MD_BMCART_ITEMID);
	}

	function load(&$obj)
	{
		$this->set('image_id', $obj->get('image_id'));
		$this->set('item_id', $obj->get('item_id'));
		$this->set('image_filename', $obj->get('image_filename'));
	}

	function update(&$obj)
	{
		$obj->setVar('image_id', $this->get('image_id'));
	}
}

?>
