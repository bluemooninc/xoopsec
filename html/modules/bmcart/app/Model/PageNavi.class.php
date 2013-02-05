<?php
/* $Id: $ */

if (!defined('XOOPS_ROOT_PATH')) exit();
require_once XOOPS_ROOT_PATH.'/core/XCube_PageNavigator.class.php';

/**
 * PageNavi
 */
class Bmcart_PageNavi{
	// object
	protected $mCriteria = null;
	protected $mHandler = null;
	protected $mNavi = null;
	
	// set variable
	protected $mPagenum = 10;
	protected $mUrl = 'bmcart.php';
	protected $mTotal = 0;

	/**
	 * constructor
	 */  
	public function __construct( $handler=null, $criteria=null ) {
		$this->mUrl = _MY_MODULE_URL . 'index.php';

		$this->mHandler = $handler;

		$this->mCriteria = new CriteriaCompo();
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
		$this->mCriteria->setStart( $this->getStart() );
		$this->mCriteria->setLimit( $this->getPerpage() );
		return $this->mCriteria;
	}

	/**
	 * get Start
	 *
	 * @param none
	 * @return int Start
	 */		
	 public function getStart() {
		return $this->mNavi->getStart();
	}

	/**
	 * get Perpage
	 *
	 * @param none
	 * @return int Perpage
	 */		
	 public function getPerpage() {
		return $this->mNavi->getPerpage();
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
		$this->mNavi = new XCube_PageNavigator($this->mUrl);
		$this->mNavi->mGetTotalItems->add(array($this, 'getTotalItems'));
		$this->mNavi->setPerpage($this->mPagenum);
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