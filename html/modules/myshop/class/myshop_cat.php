<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_cat extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('cat_cid',XOBJ_DTYPE_INT,null,false);
		$this->initVar('cat_pid',XOBJ_DTYPE_INT,null,false);
		$this->initVar('cat_title',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('cat_imgurl',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('cat_description',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('cat_advertisement',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('cat_metakeywords',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('cat_metadescription',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('cat_metatitle',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('cat_footer',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}

	/**
	 * Return Category URL
	 * @return string  URL
	 */
	function getPictureUrl()
	{
		return MYSHOP_PICTURES_URL.'/'.$this->getVar('cat_imgurl');
	}

	/**
	 * Return category image path
	 * @return string	path
	 */
	function getPicturePath()
	{
		return MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('cat_imgurl');
	}

	/**
	 * Display if category image exists
	 *
	 * @return boolean
	 */
	function pictureExists()
	{
		$return = false;
		if(xoops_trim($this->getVar('cat_imgurl')) != '' && file_exists(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('cat_imgurl'))) {
			$return = true;
		}
		return $return;
	}

	/**
	 * Delete image associated to category
	 * @return void
	 */
	function deletePicture()
	{
		if($this->pictureExists()) {
			@unlink(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('cat_imgurl'));
		}
		$this->setVar('cat_imgurl', '');
	}

	/**
	 * Return URL to access category  according to module preferences
	 *
	 * @return string	URL
	 */
	function getLink()
	{
		$url = '';
		if(myshop_utils::getModuleOption('urlrewriting') == 1) {	// URL rewriting
			$url = MYSHOP_URL.'category-'.$this->getVar('cat_cid').myshop_utils::makeSeoUrl($this->getVar('cat_title')).'.html';
		} else {
			$url = MYSHOP_URL.'category.php?cat_cid='.$this->getVar('cat_cid');
		}
		return $url;
	}

	/**
	 * Renturn tag <a> 
	 *
	 * @return string
	 */
	function getHrefTitle()
	{
		return myshop_utils::makeHrefTitle($this->getVar('cat_title'));
	}


	/**
	 * Return data formated to display
	 *
	 * @param unknown_type $format
	 * @return unknown
	 */
	function toArray($format = 's')
    {
		$ret = array();
		$ret = parent::toArray($format);
		$ret['cat_full_imgurl'] = $this->getPictureUrl();
		$ret['cat_href_title'] = $this->getHrefTitle();
		$ret['cat_url_rewrited'] = $this->getLink();
		return $ret;
    }
}


class MyshopMyshop_catHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//						Table				Classe		 Id		  Label
		parent::__construct($db, 'myshop_cat', 'myshop_cat', 'cat_cid', 'cat_title');
	}

	/**
	 * Return all categories
	 *
	 * @param integer $start
	 * @param integer $limit
	 * @param string $sort
	 * @param string $order
	 * @param boolean $idaskey
	 * @return array
	 */
	function getAllCategories($start = 0, $limit = 0, $sort = 'cat_title', $order='ASC', $idaskey = true)
	{
		$critere = new Criteria('cat_cid', 0 ,'<>');
		$critere->setLimit($limit);
		$critere->setStart($start);
		$critere->setSort($sort);
		$critere->setOrder($order);
		$tbl_categs = array();
		$tbl_categs = $this->getObjects($critere, $idaskey);
		return $tbl_categs;
	}

	/**
	 * Delete category and related content
	 *
	 * @param myshop_cat $category
	 * @return boolean	Result
	 */
	function deleteCategory(myshop_cat $category)
	{
		global $xoopsModule;
		$category->deletePicture();
		xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'new_category', $category->getVar('cat_cid'));
		return $this->delete($category, true);
	}

	/**
	 * Return number of products from one or several categories
	 *
	 * @param integer	$cat_cid
	 * @param boolean	$withNested
	 * @return integer
	 */
	function getCategoryProductsCount($cat_cid, $withNested = true)
	{
		global $h_myshop_products;
		$childsIDs = array();
		$childsIDs[] = $cat_cid;

		if($withNested) {	// Search sub-categories
			$items = $childs = array();
			include_once XOOPS_ROOT_PATH . '/class/tree.php';
			$items = $this->getAllCategories();
			$mytree = new XoopsObjectTree($items, 'cat_cid', 'cat_pid');
			$childs = $mytree->getAllChild($cat_cid);
			if(count($childs) > 0) {
				foreach ($childs as $onechild) {
					$childsIDs[] = $onechild->getVar('cat_cid');
				}
			}
		}
		return $h_myshop_products->getCategoryProductsCount($childsIDs);
	}

	/**
	 * Return categories by ID
	 *
	 * @param array $ids
	 * @return array	Objects type myshop_cat
	 */
	function getCategoriesFromIds($ids)
	{
		$ret = array();
		if(is_array($ids) && count($ids) > 0) {
			$criteria = new Criteria('cat_cid', '('.implode(',', $ids).')', 'IN');
			$ret = $this->getObjects($criteria, true, true, '*', false);
		}
		return $ret;
	}

	/**
	 * Return list of parent categories
	 *
	 * @return array	Objects type myshop_cat
	 */
	function getMotherCategories()
	{
		$ret = array();
		$criteria = new Criteria('cat_pid', 0, '=');
		$criteria->setSort('cat_title');
		$ret = $this->getObjects($criteria);
		return $ret;
	}
}
?>