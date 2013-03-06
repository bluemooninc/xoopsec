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
	public function &getWhoCheckedAlso($checked_id){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria("item_id",$checked_id));
		$criteria->addsort("last_update","DESC");
		$objects = $this->getObjects($criteria);
		$uids = array();
		foreach($objects as $object){
			$uids[] = $object->getVar('uid');
		}
		$uidstr = implode(",",$uids);
		$sql = "select item_id,count(uid) as checked from " . $this->mTable
			. " WHERE uid in (". $uidstr.") "
			. " GROUP BY item_id ORDER BY checked DESC";
		$result = $this->db->query($sql,false,0,10);
		$ret = array();
		while( list($item_id,$checked) = $this->db->fetchRow($result) ){
			$ret[] = $item_id;
		}
		return $ret;
	}
}
