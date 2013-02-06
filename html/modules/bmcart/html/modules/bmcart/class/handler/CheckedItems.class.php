<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
/*
 * {Dirname}_{Filename} : Naming convention for Model
 */
class bmcart_checkedItemsObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('item_id', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('category_id', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('last_update', XOBJ_DTYPE_INT, 0);
    }
}

class bmcart_checkedItemsHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'bmcart_checkedItems';
    public $mPrimary = 'uid,item_id';
    public $mClass = 'bmcart_checkedItemsObject';
    public $id;

    public function __construct(&$db)
    {
        parent::XoopsObjectGenericHandler($db);
    }
}
