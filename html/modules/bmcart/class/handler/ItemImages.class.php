<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/01/14
 * Time: 17:41
 * To change this template use File | Settings | File Templates.
 */
class bmcart_itemImagesObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('image_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('item_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('image_filename', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('weight', XOBJ_DTYPE_INT, 0, true);
	}
}

class bmcart_itemImagesHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmcart_itemImages';
	public $mPrimary = 'image_id';
	public $mClass = 'bmcart_itemImagesObject';
	public $id;

	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
	public function &getImages($item_id){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_id', $item_id));
		$criteria->addsort('weight','asc');
		return $this->getObjects($criteria);
	}
}
