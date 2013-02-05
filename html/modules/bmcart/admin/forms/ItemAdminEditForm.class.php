<?php
/**
 * @package user
 * @version $Id: ItemAdminEditForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class bmcart_ItemAdminEditForm extends XCube_ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = false;
	var $mFormFile = null;

	function getTokenName()
	{
		return "module.bmcart.ItemAdminEditForm.TOKEN" . $this->get('item_id');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['item_id'] =new XCube_IntProperty('item_id');
		$this->mFormProperties['category_id'] =new XCube_IntProperty('category_id');
		$this->mFormProperties['item_name'] =new XCube_StringProperty('item_name');
		$this->mFormProperties['item_desc'] =new XCube_TextProperty('item_detail');
		$this->mFormProperties['price'] =new XCube_IntProperty('price');
		$this->mFormProperties['shipping_fee'] =new XCube_IntProperty('shipping_fee');
		$this->mFormProperties['stock_qty'] =new XCube_IntProperty('stock_qty');

		//
		// Set field properties
		//
		$this->mFieldProperties['item_id'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['item_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['item_id']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _MD_BMCART_ITEMID);
	
		$this->mFieldProperties['item_name'] =new XCube_FieldProperty($this);
		$this->mFieldProperties['item_name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['item_name']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _AD_BMCART_ITEM_NAME, '255');
		$this->mFieldProperties['item_name']->addMessage('maxlength', _MD_BMCART_ERROR_MAXLENGTH, _AD_BMCART_ITEM_NAME, '255');
		$this->mFieldProperties['item_name']->addVar('maxlength', '255');

	}

	function load(&$obj)
	{
		$this->set('item_id', $obj->get('item_id'));
		$this->set('category_id', $obj->get('category_id'));
		$this->set('item_name', $obj->get('item_name'));
		$this->set('item_desc', $obj->get('item_desc'));
		$this->set('price', $obj->get('price'));
		$this->set('shipping_fee', $obj->get('shipping_fee'));
		$this->set('stock_qty', $obj->get('stock_qty'));
	}

	function update(&$obj)
	{
		$obj->set('item_id', $this->get('item_id'));
		$obj->set('category_id', $this->get('category_id'));
		$obj->set('item_name', $this->get('item_name'));
		$obj->set('item_desc', $this->get('item_desc'));
		$obj->set('price', intval($this->get('price')));
		$obj->set('shipping_fee', intval($this->get('shipping_fee')));
		$obj->set('stock_qty', intval($this->get('stock_qty')));
		$obj->set('last_update', time());
	}
}

?>
