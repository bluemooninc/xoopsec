<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/01/14
 * Time: 17:41
 * To change this template use File | Settings | File Templates.
 */
class bmcart_itemSkuObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('sku_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('item_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('sku_name', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('sku_stock', XOBJ_DTYPE_INT, 0, true);
	}
}

class bmcart_itemSkuHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmcart_itemSku';
	public $mPrimary = 'sku_id';
	public $mClass = 'bmcart_itemSkuObject';
	public $id;

	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
	public function &getSku($item_id){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_id', $item_id));
		$criteria->addsort('sku_name','asc');
		return $this->getObjects($criteria);
	}
}
