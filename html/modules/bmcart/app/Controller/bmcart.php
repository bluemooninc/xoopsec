<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2012/12/28
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */
require_once _MY_MODULE_PATH . 'app/Model/Category.php';
require_once _MY_MODULE_PATH . 'app/Model/PageNavi.class.php';
require_once _MY_MODULE_PATH . 'app/View/view.php';

class Controller_bmcart extends AbstractAction {
	protected $mHandler;
	protected $mPrimaryKey = 'category_id';
	protected $mListData;
	protected $msg;
	/**
	 * constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->mHandler = Model_Category::forge();
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


	public function action_index(){
		$this->template = 'categoryList.html';
		$parentObjects = $this->mHandler->getParentCategory();
		$mArray=array();
		foreach($parentObjects as $parentObject){
			$category_id = $parentObject->getVar('category_id');
			$children = $this->mHandler->getAllChildren($category_id);
			$mArray[$category_id] = array(
				'category_name'=>$this->mHandler->getName($category_id),
				'children'=>$this->_array_flatten($children)
			);

		}
		$this->mListData = $mArray;
	}
	public function action_view(){
		$view = new View($this->root);
		$view->setTemplate($this->template);
		$view->set('ListData', $this->mListData);
		$view->set('ticket_hidden',$this->mTicketHidden);
		if (is_object($this->mPagenavi)) {
			$view->set('pageNavi', $this->mPagenavi->getNavi());
		}
	}
}