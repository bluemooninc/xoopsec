<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
/*
 * {Dirname}_{Filename} : Naming convention for Model
 */
class bmcart_categoryObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('category_id', XOBJ_DTYPE_INT, 0);
	    $this->initVar('category_name', XOBJ_DTYPE_STRING, '', true, 255);
	    $this->initVar('parent_id', XOBJ_DTYPE_INT, 0);
    }
}

class bmcart_categoryHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'bmcart_category';
    public $mPrimary = 'category_id';
    public $mClass = 'bmcart_categoryObject';
	private $catArray;
    public $id;

    public function __construct(&$db)
    {
        parent::XoopsObjectGenericHandler($db);
    }
	public function &getCategory(){
		$sql = "select * from " . $this->mTable . " ORDER BY category_name";
		$result = $this->db->query($sql);
		$ret = array();
		while( $myrow = $this->db->fetchArray($result) ){
			$ret[] = $myrow;
		}
		return $ret;
	}
	public function &getCategoryOptions(){
		$objects = $this->getCategory();
		$ret = array(0=>null);
		foreach($objects as $obj){
			$ret[$obj['category_id']] = $obj['category_name'];
		}
		return $ret;
	}
	public function &getCategoryTree(){
		$objects = $this->getCategory();
		$ret = array();
		foreach($objects as $obj){
			if (intval($obj['parent_id'])>0){
				$ret[$obj['parent_id']]['sub_category'][$obj['category_id']] = $obj;
			} else {
				$ret[$obj['category_id']]= $obj;
			}
		}
		return $ret;
	}
	private function getCategoryChild($category_id){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parent_id', $category_id));
		$objects = $this->getObjects($criteria);
		$ret=array();
		foreach($objects as $object){
			$ret[] = $object->getVar('category_id');
		}
		return $ret;
	}

	/**
	 * @param $category_id
	 * @return array
	 */
	public function getAllChildren($category_id){
		$ret = $this->getCategoryChild($category_id);
		$this->catArray[]=$ret;
		foreach($ret as $catId){
			$this->getAllChildren($catId);
		}
		return $this->catArray;
	}

	public function &makeBreadcrumbs($category_id){
		$ret = array($category_id);
		while($category_id!=0){
			$myObject = $this->get($category_id);
			$ret[] = array(
				'category_id'=>$myObject->getVar('category_id'),
				'category_name'=>$myObject->getVar('category_name')
			);
			$category_id = $myObject->getVar('parent_id');
		}
		$ret = array_reverse($ret);
		return $ret;
	}
}
