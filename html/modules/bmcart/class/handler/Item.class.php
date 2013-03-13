<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
/*
 * {Dirname}_{Filename} : Naming convention for Model
 */
class bmcart_itemObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
	    $this->initVar('category_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('item_name', XOBJ_DTYPE_STRING, '', true, 255);
	    $this->initVar('item_desc', XOBJ_DTYPE_TEXT, '', true);
	    $this->initVar('barcode', XOBJ_DTYPE_STRING, null, true, 13);
        $this->initVar('price', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('shipping_fee', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('stock_qty', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('last_update', XOBJ_DTYPE_INT, 0);
	    $this->initVar('publish_date', XOBJ_DTYPE_INT, 0);
        $this->initVar('expire_date', XOBJ_DTYPE_INT, 0);
    }
}

class bmcart_itemHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'bmcart_item';
    public $mPrimary = 'item_id';
    public $mClass = 'bmcart_itemObject';
    public $id;

    public function __construct(&$db)
    {
        parent::XoopsObjectGenericHandler($db);
    }
	public function &getItemByCategory(&$criteria,$limit,$start){
		$objects = $this->getObjects($criteria,$limit,$start);
		$ret = array();
		foreach( $objects as $object ){
			$myRow = array();
			foreach($object->mVars as $key=>$val){
				$myRow[$key] = $val['value'];
			}
			$ret[] = $myRow;
		}
		return $ret;
	}
	public function &getItemOptions($limit=10,$start=0){
		$criteria = null;
		$itemList = $this->getItemByCategory($criteria,$limit,$start);
		$ret = array(0=>null);
		foreach($itemList as $item){
			$ret[$item['item_id']] = $item['item_name'];
		}
		return $ret;
	}
}
