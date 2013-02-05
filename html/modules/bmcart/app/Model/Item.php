<?php
/* $Id: $ */

if (!defined('XOOPS_ROOT_PATH')) exit();
include_once dirname(dirname(dirname(__FILE__)))."/class/bmcart_session.php";

/**
 * Utility
 */
class Model_Item extends AbstractModel {
	protected $_item_types = array();
	protected $_item_names = array();
	protected $myHandler;
	protected $message;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->_module_names = $this->getModuleNames();
		$this->myHandler =& xoops_getModuleHandler('item');
	}

	/**
	 * get Instance
	 * @param none
	 * @return object Instance
	 */
	public function &forge()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new Model_Item();
		}
		return $instance;
	}

	public function getName($id)
	{
		$obj = $this->myHandler->get($id);
		$ret = isset($obj) ? $obj->getVar("item_name") : NULL;
		return $ret;
	}
	private function _getTopImage($item_id){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_id',$item_id));
		$criteria->addsort('weight','ASC');
		$item_handler = xoops_getmodulehandler('itemImages');
		$objects = $item_handler->getObjects($criteria,0,1);
		if ($objects){
			return $objects[0]->getVar('image_filename');
		}
		return null;
	}

	public function &getCategoryArray($category_id)
	{
		$cArray = array();
		if ($category_id>0){
			$catHandler =& xoops_getModuleHandler('category');
			$catArray = $catHandler->getAllChildren($category_id);
			$catArray[] = $category_id;
			$cArray = $this->array_flatten($catArray);
		}
		return $cArray;
	}
	public function &getItemList(&$criteria,$sortName="last_update",$sortOrder="desc")
	{

		$this->myHandler =& xoops_getModuleHandler('item');
		$items = $this->myHandler->getItemByCategory($criteria,$sortName,$sortOrder);
		$i=0;
		foreach($items as $item){
			$items[$i]['image_filename'] = $this->_getTopImage($item['item_id']);
			$i++;
		}
		return $items;
	}

	public function &getItemDetail($item_id)
	{
		$this->myHandler =& xoops_getModuleHandler('item');
		$object = $this->myHandler->get($item_id);
		$checkedHandler =& xoops_getModuleHandler('checkedItems');
		$uid = Legacy_Utils::getUid();
		$checkedObject = $checkedHandler->get(array($uid,$item_id));
		if (!$checkedObject){
			$checkedObject = $checkedHandler->create();
			$checkedObject->set('uid',$uid);
			$checkedObject->set('item_id',$object->getVar('item_id'));
			$checkedObject->set('category_id',$object->getVar('category_id'));
		}
		$checkedObject->set('last_update',time());
		if($uid){
			$checkedHandler->insert($checkedObject,true);
		} else {
			$bmcart_session = new bmcart_session();
			$bmcart_session->insert('checkedItems','item_id',$checkedObject);
		}

		$ret=array();
		foreach($object->mVars as $key=>$val){
			$ret[$key]=$object->getVar($key);
		}
		return $ret;
	}

	public function getFindInSet($limit, $offset, $whereArray, $orderArray)
	{
		$this->myHandler =& xoops_getModuleHandler('item');
		$this->_item_names = $this->myHandler->FindInSet($limit, $offset, $whereArray, $orderArray);
		return $this->_item_names;
	}

	/**
	 * get Item Count
	 * @param none
	 * @return int Count
	 */
	public function getCount(&$criteria)
	{
		$objs = $this->myHandler->getObjects($criteria);
		return count($objs);
	}

	public function getMessage(){
		return $this->message;
	}
	/**
	 * Check Stock before accept order
	 * @param $ListData
	 * @return bool
	 */
	public function checkStock($ListData){
		$itemHandler = xoops_getModuleHandler('item');
		foreach ($ListData as $myRow) {
			$itemObject = $itemHandler->get($myRow['item_id']);
			if ($itemObject){
				$stock = $itemObject->getVar('stock_qty');
			}else{
				$stock = 0;
			}
			if ( $stock==0 ){
				$this->message = sprintf(_MD_BMCART_MESSAGE_NO_STOCK,$itemObject->getVar('item_name'));
				return false;
			}elseif ($stock < $myRow['qty'] ){
				$this->message = sprintf(_MD_BMCART_MESSAGE_LESS_STOCK,$itemObject->getVar('item_name'),$stock);
				return false;
			}
		}
		return true;
	}

	public function update($field_name, $value, $whereArray = NULL)
	{
		$criteria = new CriteriaCompo();
		if ($whereArray) {
			$criteria->add(new Criteria($whereArray['key'], $whereArray['val'], $whereArray['operator']));
		}
		$item_handler = xoops_gethandler('item');
		$objects = $item_handler->getObjects($criteria);
		foreach ($objects as $obj) {
			$obj->set($field_name, $value);
		}
		$ret = $item_handler->insert($obj, true);
		return $ret;
	}

	/**
	 * get ItemNames
	 * @param none
	 * @return array ( key: item_id, value: name )
	 */
	public function getItemNames()
	{
		return $this->_item_names;
	}


	/**
	 * get ItemName By item_id
	 * @param int $id
	 * @return string item_name
	 */
	public function getItemName($id)
	{
		$id = intval($id);
		if (isset($this->_item_names[$id])) {
			return $this->_item_names[$id]['name'];
		}
		return FALSE;
	}

	/**
	 * get My ModuleId
	 * @param none
	 * @return int module_id
	 */
	public function getMyModuleDirName()
	{
		global $xoopsModule;
		if (is_object($xoopsModule)) {
			return $xoopsModule->getVar('dirname');
		}
		return FALSE;
	}


	/**
	 * is XoopsAdmin
	 * @param none
	 * @return boolean XoopsAdmin
	 */
	public function isXoopsAdmin()
	{
		global $xoopsUser;
		if (is_object($xoopsUser)) {
			return $xoopsUser->isAdmin();
		}
		return FALSE;
	}

//-----------------
// protected
//-----------------
	protected function getModuleNames($isactive = FALSE)
	{
		$criteria = new CriteriaCompo();
		if ($isactive) {
			$criteria->add(new Criteria('isactive', '1', '='));
		}
		$module_handler =& xoops_gethandler('module');
		$objs = $module_handler->getObjects($criteria);
		$ret = array();
		foreach ($objs as $obj) {
			$ret[$obj->getVar('mid')] = $obj->getVar('name');
		}
		return $ret;
	}

}

?>