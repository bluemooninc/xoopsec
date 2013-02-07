<?php
/* $Id: $ */

if (!defined('XOOPS_ROOT_PATH')) exit();

/**
 * Utility
 */
class Model_Category
{
	protected $_category_types = array();
	protected $_category_names = array();
	protected $myHandler;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->_module_names = $this->getModuleNames();
		$this->myHandler =& xoops_getModuleHandler('category');
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
			$instance = new Model_Category();
		}
		return $instance;
	}

	public function getName($id)
	{
		$obj = $this->myHandler->get($id);
		$ret = isset($obj) ? $obj->getVar("category_name") : NULL;
		return $ret;
	}

	public function getParentCategory(){
		$this->myHandler =& xoops_getModuleHandler('category');
		$criteria = new Criteria('parent_id',0);
		return $this->myHandler->getObjects($criteria);
	}
	public function getCategory($limit=0, $offset=0, $whereArray=null)
	{
		$this->myHandler =& xoops_getModuleHandler('category');
		$this->_category_names = $this->myHandler->getCategory($limit, $offset, $whereArray,
			array(
				array("name" => "name", "sort" => "ASC")
			)
		);
		return $this->_category_names;
	}
	public function getCategoryTree($category_id=0)
	{
		return $this->myHandler->getAllChildren($category_id);
	}

	private function _array_flatten($array)
	{
		$result = array();
		// Callback with closure is PHP5.3 or later
		array_walk_recursive($array, function ($v) use (&$result) {
			$result[] = $v;
		});
		return $result;
	}

	public function getAllChildren($category_id=0)
	{
		$this->myHandler =& xoops_getModuleHandler('category');
		$catArray = $this->myHandler->getAllChildren($category_id);
		$ret = array();
		$cArray = $this->_array_flatten($catArray);
		foreach($cArray as $category_id){
			$object = $this->myHandler->get($category_id);
			if ($object){
				$ret[$category_id] = $object->getVar('category_name');
			}
		}
		return $ret;
	}
	public function getFindInSet($limit, $offset, $whereArray, $orderArray)
	{
		$this->myHandler =& xoops_getModuleHandler('category');
		$this->_category_names = $this->myHandler->FindInSet($limit, $offset, $whereArray, $orderArray);
		return $this->_category_names;
	}

	/**
	 * get XoopsCategory Count
	 * @param none
	 * @return int Count
	 */
	public function getXoopsCategoryCount()
	{
		$category_handler =& xoops_gethandler('category');
		$objs = $category_handler->getObjects();

		return count($objs);
	}

	public function update($field_name, $value, $whereArray = NULL)
	{
		$criteria = new CriteriaCompo();
		if ($whereArray) {
			$criteria->add(new Criteria($whereArray['key'], $whereArray['val'], $whereArray['operator']));
		}
		$category_handler = xoops_gethandler('category');
		$objects = $category_handler->getObjects($criteria);
		foreach ($objects as $obj) {
			$obj->set($field_name, $value);
		}
		$ret = $category_handler->insert($obj, true);
		return $ret;
	}

	/**
	 * get CategoryNames
	 * @param none
	 * @return array ( key: category_id, value: name )
	 */
	public function getCategoryNames()
	{
		return $this->_category_names;
	}


	/**
	 * get CategoryName By category_id
	 * @param int $id
	 * @return string category_name
	 */
	public function getCategoryName($id)
	{
		$id = intval($id);
		if (isset($this->_category_names[$id])) {
			return $this->_category_names[$id]['name'];
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

	public function getModuleName($modname)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('isactive', '1', '='));
		$criteria->add(new Criteria('name', $modname, '='));
		$module_handler =& xoops_gethandler('module');
		$objs = $module_handler->getObjects($criteria, 1);
		foreach ($objs as $obj) {
			$ret = $obj->getVar('name');
		}
		return $ret;
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