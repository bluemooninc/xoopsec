<?php
/**
 * @package user
 * @version $Id: SkuAdminEditForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class bmcart_SkuAdminEditForm extends XCube_ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = false;
	var $mFormFile = null;

	function getTokenName()
	{
		return "module.bmcart.SkuAdminEditForm.TOKEN" . $this->get('sku_id');
	}

	/**
	 * For displaying the confirm-page, don't show CSRF error.
	 * Always return null.
	 */
	function getTokenErrorMessage()
	{
		return null;
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['sku_id'] = new XCube_IntProperty('sku_id');
		$this->mFormProperties['item_id'] = new XCube_IntProperty('item_id');
		$this->mFormProperties['sku_name'] = new XCube_StringProperty('sku_name');
		$this->mFormProperties['sku_stock'] = new XCube_IntProperty('sku_stock');
		//
		// Set field properties
		//
		$this->mFieldProperties['item_id'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['item_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['item_id']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _MD_BMCART_ITEMID);

	}

	function load(&$obj)
	{
		$this->set('sku_id', $obj->get('sku_id'));
		if (xoops_getrequest('item_id') && !$obj->get('item_id')){
			$this->set('item_id', xoops_getrequest('item_id'));
		}else{
			$this->set('item_id', $obj->get('item_id'));
		}
		$this->set('sku_name', $obj->get('sku_name'));
		$this->set('sku_stock', $obj->get('sku_stock'));
	}

	function update(&$obj)
	{
		$obj->set('sku_id', $this->get('sku_id'));
		$obj->set('item_id', $this->get('item_id'));
		$obj->set('sku_name', $this->get('sku_name'));
		$obj->set('sku_stock', $this->get('sku_stock'));
	}




}

?>
