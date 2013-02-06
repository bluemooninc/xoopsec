<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
/*
 * {Dirname}_{Filename} : Naming convention for Model
 */
class bmcart_orderItemsObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('orderItem_id', XOBJ_DTYPE_INT, 0);
	    $this->initVar('order_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('price', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('shipping_fee', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('qty', XOBJ_DTYPE_INT, 0, true);
    }
}

class bmcart_orderItemsHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'bmcart_orderItems';
    public $mPrimary = 'orderItem_id';
    public $mClass = 'bmcart_orderItemsObject';
    public $id;

    public function __construct(&$db)
    {
        parent::XoopsObjectGenericHandler($db);
    }
	public function getByOrderId($orderId){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('orderId', $orderId));
		$this->myObjects = parent::getObjects($criteria);
		return $this->myObjects;
	}
}
