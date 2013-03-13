<?php
/* $Id: $ */

if (!defined('XOOPS_ROOT_PATH')) exit();
require_once XOOPS_ROOT_PATH.'/core/XCube_PageNavigator.class.php';

/**
 * PageNavi
 */
class Model_PageNavi extends XCube_PageNavigator{
	// object
	protected $mCriteria = null;
	protected $mHandler = null;
	protected $mNavi = null;
	
	// set variable
	protected $mPagenum = 10;
	protected $mTotal = 0;

	/**
	 * constructor
	 */  
	public function __construct( ) {
		$this->mCriteria = new CriteriaCompo();
		$this->mNavi = new XCube_PageNavigator($this->mUrl);
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
			$instance = new Model_PageNavi();
		}
		return $instance;
	}
	public function setHandler(&$handler){
		$this->mHandler = $handler;
	}
	/**
	 * set Pagenum
	 *
	 * @param int $num
	 * @return none
	 */	  
	public function setPagenum($num) {
		$this->mPagenum = $num;
	}

	/**
	 * set Url
	 *
	 * @param string $url
	 * @return none
	 */	  
	public function setUrl($url) {
		$this->mUrl = $url;
	}

	/**
	 * get PageNavigator
	 *
	 * @param none
	 * @return object PageNavigator
	 */	  
	public function &getNavi() {
		$this->fetch();
		return $this->mNavi;
	}
	
	/**
	 * add Sort
	 *
	 * @param string $sort
	 * @param string $order 
	 * @return none
	 */	   
	public function addSort($sort, $order = 'ASC') {
		$this->mCriteria->setSort($sort, $order);
	}

	/**
	 * add Criteria
	 *
	 * @param object $criteria
	 * @return none
	 */	 
	public function addCriteria(&$criteria,$operator="=") {
		$this->mCriteria->add($criteria,$operator);
	}

	/**
	 * get Criteria
	 *
	 * @param none
	 * @return object Criteria
	 */		
	 public function getCriteria() {
		return $this->mCriteria;
	}

	/**
	 * fetch
	 *
	 * @param none
	 * @return none
	 */	    
	public function fetch() {
		if ( is_object($this->mHandler) ) {
			$this->setTotal( $this->mHandler->getCount($this->mCriteria) );
		}
		$this->mNavi->mGetTotalItems->add(array($this, 'getTotalItems'));
		$this->mNavi->fetch();
	}

	/**
	 * set Total 
	 *
	 * @param int $total
	 * @return none
	 */	  
	public function setTotal($total) {
		 $this->mTotal = $total; 
	}

	/**
	 * get Total Items
	 *
	 * @param int $total ( refference )
	 * @return none
	 */	  
	public function getTotalItems(&$total) {
		 $total = $this->mTotal;
	}
}
?>