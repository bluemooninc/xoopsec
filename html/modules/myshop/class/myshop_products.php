<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_products extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('product_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_cid',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_title',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_store_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_sku',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_extraid',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_width',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_length',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_unitmeasure1',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_url',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_image_url',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_thumb_url',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_submitter',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_online',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_date',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_submitted',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_hits',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_rating',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_votes',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_comments',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_price',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_shipping_price',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_discount_price',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_stock',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_alert_stock',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_summary',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('product_description',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('product_attachment',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_weight',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_unitmeasure2',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_vat_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_download_url',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_recommended',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_metakeywords',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_metadescription',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_metatitle',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('product_delivery_time',XOBJ_DTYPE_INT,null,false);
		$this->initVar('product_ecotaxe',XOBJ_DTYPE_TXTBOX,null,false);
		// Allow html
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}

	/**
	 * Return Product Image URL
	 * @return string	URL
	 */
	function getPictureUrl()
	{
		if(xoops_trim($this->getVar('product_image_url')) != '') {
			return MYSHOP_PICTURES_URL.'/'.$this->getVar('product_image_url');
		} else {
			return '';
		}
	}

	/**
	 * Return Product Image Path
	 * @return string	Path
	 */
	function getPicturePath()
	{
		if(xoops_trim($this->getVar('product_image_url')) != '') {
			return MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_image_url');
		} else {
			return '';
		}
	}

	/**
	 * Return Product Thumbail URL
	 * @return string	URL
	 */
	function getThumbUrl()
	{
		if(xoops_trim($this->getVar('product_thumb_url')) != '') {
			return MYSHOP_PICTURES_URL.'/'.$this->getVar('product_thumb_url');
		} else {
			return '';
		}
	}

	/**
	 * Return Product Thumbnail Path
	 * @return string	Path
	 */
	function getThumbPath()
	{
		if(xoops_trim($this->getVar('product_thumb_url')) != '') {
			return MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_thumb_url');
		} else {
			return '';
		}
	}


	/**
	 * Display Product Image
	 *
	 * @return boolean
	 */
	function pictureExists()
	{
		$return = false;
		if(xoops_trim($this->getVar('product_image_url')) != '' && file_exists(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_image_url'))) {
			$return = true;
		}
		return $return;
	}

	/**
	 * Display Product Thumbail
	 *
	 * @return boolean
	 */
	function thumbExists()
	{
		$return = false;
		if(xoops_trim($this->getVar('product_thumb_url')) != '' && file_exists(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_thumb_url'))) {
			$return = true;
		}
		return $return;
	}

	/**
	 * Delete Product Image
	 * @return void
	 */
	function deletePicture()
	{
		if($this->pictureExists()) {
			@unlink(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_image_url'));
		}
		$this->setVar('product_image_url', '');
	}

	/**
	 * Display product attached file
	 * @return boolean
	 */
	function attachmentExists()
	{
		$return = false;
		if(xoops_trim($this->getVar('product_attachment')) != '' && file_exists(MYSHOP_ATTACHED_FILES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_attachment'))) {
			$return = true;
		}
		return $return;
	}

	/**
	 * Delete attached file
	 * @return void
	 */
	function deleteAttachment()
	{
		if($this->attachmentExists()) {
			@unlink(MYSHOP_ATTACHED_FILES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_attachment'));
		}
		$this->setVar('product_attachment', '');
	}


	/**
	 * Delete Product Thumbnail
	 * @return void
	 */
	function deleteThumb()
	{
		if($this->thumbExists()) {
			@unlink(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('product_thumb_url'));
		}
		$this->setVar('product_thumb_url', '');
	}

	/**
	 * Delete Images
	 * @return void
	 */
	function deletePictures()
	{
		$this->deletePicture();
		$this->deleteThumb();
	}

	/**
	 * Return product price with Discount
	 * @return floatval	Amount ALL FEE with Discount
	 */
	function getDiscountTTC()
	{
		$vat = null;
		global $vatArray, $h_myshop_vat;
		if(is_array($vatArray)) {
			if(isset($vatArray[$this->getVar('product_vat_id')])) {
				$vat = $vatArray[$this->getVar('product_vat_id')];
			}
		} else {
			$tblVATs = array();
			$tblVATs = $h_myshop_vat->getObjects(new Criteria('vat_id', $this->getVar('product_vat_id'), '='));
			if(count($tblVATs) > 0) {
				$vat = $tblVATs[0];
			}
		}
		if(is_object($vat)) {
			return (floatval($this->getVar('product_discount_price', 'e')) * floatval($vat->getVar('vat_rate', 'e')) / 100) + floatval($this->getVar('product_discount_price', 'e'));
		} else {
			return floatval($this->getVar('product_discount_price'));
		}
	}

	/**
	 * Return product amount ALL FEE
	 * @return floatval	Amount ALL FEE
	 */
	function getTTC()
	{
		$vat = null;
		global $vatArray, $h_myshop_vat;
		if(!is_object($h_myshop_vat)) {
			$handlers = myshop_handler::getInstance();
			$h_myshop_vat = $handlers->h_myshop_vat;
		}
		if(is_array($vatArray)) {
			if(isset($vatArray[$this->getVar('product_vat_id')])) {
				$vat = $vatArray[$this->getVar('product_vat_id')];
			}
		} else {
			$tblVATs = array();
			$tblVATs = $h_myshop_vat->getObjects(new Criteria('vat_id', $this->getVar('product_vat_id'), '='));
			if(count($tblVATs) > 0) {
				$vat = $tblVATs[0];
			}
		}
		if(is_object($vat)) {
			return (floatval($this->getVar('product_price', 'e')) * floatval($vat->getVar('vat_rate', 'e')) / 100) + floatval($this->getVar('product_price', 'e'));
		} else {
			return floatval($this->getVar('product_price'));
		}
	}

	/**
	 * Display if Product is recommended
	 * @return boolean
	 */
	function isRecommended($withDescription = false)
	{
		if($this->getVar('product_recommended') != '0000-00-00') {
			return $withDescription ? _YES : true;
		} else {
			return $withDescription ? _NO : false;
		}
	}

	/**
	 * Change Product status to recommended
	 * @return void
	 */
	function setRecommended()
	{
		$this->setVar('product_recommended', date("Y-m-d"));
	}

	/**
	 * Remove Product value recommended
	 * @return void
	 */
	function unsetRecommended()
	{
		$this->setVar('product_recommended', '0000-00-00');
	}

	/**
	 * Returne recommended image
	 * @return string
	 */
	function recommendedPicture()
	{
		if($this->isRecommended()) {
			return "<img src=\"".MYSHOP_IMAGES_URL."star_on.png\" alt=\""._MYSHOP_IS_RECOMMENDED."\" />&nbsp;";
		} else {
			return "<img src=\"".MYSHOP_IMAGES_URL."blank.gif\" alt=\"\" />";
		}
	}

	/**
	 * Return product link with or without URL Rewriting
	 * @return string
	 */
	function getLink($product_id = 0, $product_title = '')
	{
		$url = '';
		if($product_id == 0 && $product_title == '') {
			 $product_id = $this->getVar('product_id');
			 $product_title = $this->getVar('product_title');
		}
		if(myshop_utils::getModuleOption('urlrewriting') == 1) {	// URL rewriting
			$url = MYSHOP_URL.'product-'.$product_id.myshop_utils::makeSeoUrl($product_title).'.html';
		} else {	// No URL rewriting
			$url = MYSHOP_URL.'product.php?product_id='.$product_id;
		}
		return $url;

	}

	/**
	 * Return products data to show
	 *
	 * @param string $format
	 * @return array
	 */
	function toArray($format = 's')
    {
		$ret = array();
		$ret = parent::toArray($format);
		$myshop_Currency = myshop_Currency::getInstance();

		$ret['product_price_formated'] = $myshop_Currency->amountForDisplay($this->getVar('product_price'));
		$ret['product_shipping_price_formated'] = $myshop_Currency->amountForDisplay($this->getVar('product_shipping_price'));
		$ret['product_discount_price_formated'] = $myshop_Currency->amountForDisplay($this->getVar('product_discount_price'));
		$ret['product_price_ttc'] = $myshop_Currency->amountForDisplay($this->getTTC());
		$ret['product_ecotaxe_formated'] = $myshop_Currency->amountForDisplay($this->getVar('product_ecotaxe'));

		if( intval($this->getVar('product_discount_price')) != 0 ) {
			$ret['product_discount_price_ttc'] = $myshop_Currency->amountForDisplay($this->getDiscountTTC());
		} else {
			$ret['product_discount_price_ttc'] = '';
		}
		$ret['product_tooltip'] = myshop_utils::makeInfotips($this->getVar('product_description'));
		$ret['product_url_rewrited'] = $this->getLink();
		$ret['product_href_title'] = myshop_utils::makeHrefTitle($this->getVar('product_title'));
		$ret['product_recommended'] = $this->isRecommended();
		$ret['product_recommended_picture'] = $this->recommendedPicture();

		$ret['product_image_full_url'] = $this->getPictureUrl();
		$ret['product_thumb_full_url'] = $this->getThumbUrl();
		$ret['product_image_full_path'] = $this->getPicturePath();
		$ret['product_thumb_full_path'] = $this->getThumbPath();

		$ret['product_shorten_summary'] = myshop_utils::truncate_tagsafe($this->getVar('product_summary'), MYSHOP_SUMMARY_MAXLENGTH);
		$ret['product_shorten_description'] = myshop_utils::truncate_tagsafe($this->getVar('product_description'), MYSHOP_SUMMARY_MAXLENGTH);
		return $ret;
    }

}


class MyshopMyshop_productsHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//							Table				Classe			 	Id			Libell�
		parent::__construct($db, 'myshop_products', 'myshop_products', 'product_id', 'product_title');
	}


	/**
	 * Return most viewed products
	 *
	 * @param integer $start
	 * @param integer $limit
	 * @param integer $category
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	function getMostViewedProducts($start = 0, $limit = 0, $category = 0, $sort = 'product_hits', $order = 'DESC')
	{
		$tbl_datas = array();
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category != 0) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}
		$criteria->add(new Criteria('product_hits', 0, '>'));

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$tbl_datas = $this->getObjects($criteria, true);
		return $tbl_datas;
	}

	/**
	 * Return most popular products
	 *
	 * @param integer $start
	 * @param integer $limit
	 * @param integer $category
	 * @return array
	 */
	function getBestRatedProducts($start=0, $limit=0, $category=0, $sort = 'product_rating', $order = 'DESC')
	{
		$tbl_datas = array();
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		$criteria->add(new Criteria('product_rating', 0, '>'));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category != 0) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$tbl_datas = $this->getObjects($criteria, true);
		return $tbl_datas;
	}

	/**
	 * Return Products Most Voted 
	 *
	 * @param integer $start
	 * @param integer $limit
	 * @param integer $category
	 * @return array
	 */
	function getRecentRecommended($start=0, $limit=0, $category=0, $sort = 'product_recommended', $order = 'DESC')
	{
		$tbl_datas = array();
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		$criteria->add(new Criteria('product_recommended', '0000-00-00', '<>'));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category != 0) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$tbl_datas = $this->getObjects($criteria, true);
		return $tbl_datas;
	}

	/**
	 * Return last recommended products in a category
	 *
	 * @return integer Le nombre total de produits recommand�s
	 */
	function getRecommendedCount()
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		$criteria->add(new Criteria('product_recommended', '0000-00-00', '<>'));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		return $this->getCount($criteria);
	}


	/**
	 * Return last products of all categories or specific category
	 *
	 * @param integer $start	
	 * @param integer $limit	
	 * @param mixed $category 
	 * @param string $sort		
	 * @param string $order		
	 * @param integer $excluded	
	 * @param boolean $thisMonthOnly	
	 * @return array
	 */
	function getRecentProducts($start=0 , $limit=0, $category=0, $sort='product_submitted DESC, product_title', $order = '', $excluded = 0, $thisMonthOnly = false)
	{
		$tbl_datas = array();
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category > 0 ) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}
		if($excluded > 0) {
			$criteria->add(new Criteria('product_id', $excluded, '<>'));
		}

		if($thisMonthOnly) {
			$criteria->add(myshop_utils::getThisMonthCriteria());
		}

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		if(xoops_trim($order) != '') {
			$criteria->setOrder($order);
		}
		$tbl_datas = $this->getObjects($criteria, true);
		return $tbl_datas;
	}

	/**
	 * Total of recent products
	 *
	 * @param mixed $category	Array ou Integer
	 * @param integer	$excludedProduct	
	 * @return integer
	 */
	function getRecentProductsCount($category=0, $excludedProduct = 0)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category > 0 ) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}
		if($excludedProduct > 0) {
			$criteria->add(new Criteria('product_id', $excludedProduct, '<>'));
		}
		return $this->getCount($criteria);
	}


	/**
	 * Liste of products that match criterea to use in newsletter
	 *
	 * @param integer $startingDate		
	 * @param integer $endingDate		
	 * @param mixed $category			
	 * @param integer $start			
	 * @param integer $limit			
	 * @return array	
	 */
	function getProductsForNewsletter($startingDate, $endingDate, $category = 0, $start = 0, $limit = 0)
	{
		$tblDatas = array();
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		$criteria->add(new Criteria('product_submitted', $startingDate, '>='));
		$criteria->add(new Criteria('product_submitted', $endingDate, '<='));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category > 0 ) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort('product_title');
		$tblDatas = $this->getObjects($criteria, true);
		return $tblDatas;
	}


	/**
	 * Return total of published products
	 *
	 * @param intefer $product_cid 
	 * @return integer
	 */
	function getTotalPublishedProductsCount($product_cid = 0)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if($product_cid > 0) {
			$criteria->add(new Criteria('product_cid', intval($product_cid), '='));
		}
		return $this->getCount($criteria);
	}

	/**
	 * id and title of products
	 *
	 * @param object $criteria	
	 * @return array
	 */
	function getIdTitle($criteria)
	{
        global $myts;
        $ret = array();
        $sql = 'SELECT product_id, product_title FROM '.$this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
        	$ret[$myrow['product_id']] = $myts->htmlSpecialChars($myrow['product_title']);
        }
        return $ret;
	}


	/**
	 * update product views
	 *
	 * @param integer $product_id 
	 * @return boolean result
	 */
	function addCounter($product_id) {
		$sql = 'UPDATE '.$this->table.' SET product_hits = product_hits + 1 WHERE product_id= '.intval($product_id);
		return $this->db->queryF($sql);
	}


	/**
	 * update product votes
	 *
	 * @param integer $product_id 
	 * @param float $rating 
	 * @param integer $votes
	 * @return boolean result
	 */
	function updateRating($product_id, $rating, $votes)
	{
		$sql = 'UPDATE '.$this->table.' SET product_rating = '.intval($rating).', product_votes = '.intval($votes).' WHERE product_id = '.intval($product_id);
		return $this->db->queryF($sql);
	}

	/**
	 * update product comments
	 *
	 * @param integer $product_id
	 * @param integer $commentsCount
	 */
	function updateCommentsCount($product_id, $commentsCount)
	{
		$product = null;
		$product = $this->get($product_id);
		if(is_object($product)) {
			$criteria = new Criteria('product_id', $product_id, '=');
			$this->updateAll('product_comments', $commentsCount, $criteria, true);
		}
	}

	/**
	 * Random products
	 *
	 * @param integer $start		
	 * @param integer $limit		
	 * @param integer $category 
	 * @param string $sort	
	 * @param string $order	
	 * @param boolean $thisMonthOnly	
	 * @return array )
	 */
	function getRandomProducts($start=0, $limit=0, $category=0, $sort = 'RAND()', $order = 'ASC', $thisMonthOnly = false)
	{
		$tbl_datas = array();
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	// Don't show products not published
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	// only products in stock
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category != 0) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}

		if($thisMonthOnly) {
			$criteria->add(myshop_utils::getThisMonthCriteria());
		}

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$tbl_datas = $this->getObjects($criteria, true);
		return $tbl_datas;
	}


	/**
	 * Promotional Products 
	 *
	 * @param integer $start		Start data
	 * @param integer $limit		Maximum saves to send
	 * @param integer $category     category
	 * @return array                Products as objects
	 */
	function getPromotionalProducts($start=0, $limit=0, $category=0, $sort = 'product_title', $order = 'DESC')
	{
		$tbl_datas = array();
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_online', 1, '='));
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	// Don't show products not published
			$criteria->add(new Criteria('product_submitted', time(), '<='));
		}
		if(myshop_utils::getModuleOption('nostock_display') == 0) {	// only products in stock
			$criteria->add(new Criteria('product_stock', 0, '>'));
		}
		if(is_array($category)) {
			$criteria->add(new Criteria('product_cid', '('.implode(',',$category).')', 'IN'));
		} elseif($category != 0) {
			$criteria->add(new Criteria('product_cid', intval($category), '='));
		}
		$criteria->add(new Criteria('product_discount_price', 0, '>'));
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$tbl_datas = $this->getObjects($criteria, true);
		return $tbl_datas;
	}


	/**
	 * Return Low Stock
	 *
	 * @param integer $start		
	 * @param integer $limit		
	 * @return array 
	 */
	function getLowStocks($start=0, $limit=0)
	{
		$ret = array();
		$sql = 'SELECT * FROM '.$this->table.' WHERE product_online = 1';
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	// Don't show products not published
			$sql .= ' AND product_submitted <= '.time();
		}
		$sql .= ' AND product_stock <= product_alert_stock ';
		$sql .= ' AND product_alert_stock > 0';
		$sql .= ' ORDER BY product_stock';
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }

        $ret = $this->convertResultSet($result, true, true);
        return $ret;
	}

	/**
	 * Return Products with low and equal quantity to stock alert
	 *
	 * @return integer
	 */
	function getLowStocksCount()
	{
		$ret = array();
		$sql = 'SELECT Count(*) as cpt FROM '.$this->table.' WHERE product_online = 1';
		if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
			$sql .= ' AND product_submitted <= '.time();
		}
		$sql .= ' AND product_stock <= product_alert_stock ';
		$sql .= ' AND product_alert_stock > 0';
        $result = $this->db->query($sql);
        if (!$result) {
            return $ret;
        }
        $count = 0;
        list($count) = $this->db->fetchRow($result);
        return $count;
	}

	/**
	 * Increase Stock
	 *
	 * @param object $product 
	 * @param $quantity $quantity
	 */
	function increaseStock($product, $quantity = 1)
	{
		$product->setVar('product_stock', $product->getVar('product_stock') + $quantity);
		$this->insert($product, true);
		return true;
	}

	/**
	 * Decrease Stock
	 *
	 * @param object $product 
	 * @param $quantity $quantity 
	 */
	function decreaseStock(&$product, $quantity = 1)
	{
		if($product->getVar('product_stock') - $quantity > 0) {
			$product->setVar('product_stock', $product->getVar('product_stock') - $quantity);
			$this->insert($product, true);
		} else {
			$product->setVar('product_stock', 0);
		}
		return true;
	}


	/**
	 * Display Product Stock Alert
	 *
	 * @param object $products
	 * @return boolean
	 */
	function isAlertStockReached(&$product)
	{
		if($product->getVar('product_stock') < $product->getVar('product_alert_stock')) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check Stock Alert and email information
	 *
	 * @param object $product 
	 * @return boolean
	 */
	function verifyLowStock(&$product)
	{
		if($this->isAlertStockReached($product)) {
			$msg = array();
			$msg['PRODUCT_NAME'] = $product->getVar('product_title');
			$msg['ACTUAL_QUANTITY'] = $product->getVar('product_stock');
			$msg['ALERT_QUANTITY'] = $product->getVar('product_alert_stock');
			$msg['PUBLIC_URL'] = $product->getLink();
			$msg['ADMIN_URL'] = MYSHOP_URL.'admin/index.php?op=editproduct&id='.$product->getVar('product_id');
			myshop_utils::sendEmailFromTpl('shop_lowstock.tpl', myshop_utils::getEmailsFromGroup(myshop_utils::getModuleOption('stock_alert_email')), _MYSHOP_STOCK_ALERT, $msg);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Return oldest and most recent product date
	 *
	 * @param integer $minDate
	 * @param integer $maxDate
	 * @return boolean
	 */
	function getMinMaxPublishedDate(&$minDate, &$maxDate)
	{
		$sql = 'SELECT Min(product_submitted) AS minDate, Max(product_submitted) as maxDate FROM '.$this->table.' WHERE product_online = 1 ';
        $result = $this->db->query($sql);
        if (!$result) {
            return false;
        }
        $myrow = $this->db->fetchArray($result);
        $minDate = $myrow['minDate'];
        $maxDate = $myrow['maxDate'];
		return true;
	}

	/**
	 * Retourne des produits en fonction de leur IDs tout en tenant compte du fait qu'ils sont en ligne et pay�s !
	 *
	 * @param array $ids	Les identifiants des produits
	 * @param boolean	$showAll	Afficher les produits m�me s'ils ne sont plus en stock ?
	 * @return array	Tableau d'objets de type myshop_products
	 */
	function getProductsFromIDs($ids, $showAll = false)
	{
		$ret = array();
		if(is_array($ids)) {
			$criteria = new CriteriaCompo();
			if(myshop_utils::getModuleOption('show_unpublished') == 0) {	// Ne pas afficher les produits qui ne sont pas publi�s
				$criteria->add(new Criteria('product_submitted', time(), '<='));
			}
			if(myshop_utils::getModuleOption('nostock_display') == 0 && !$showAll) {	// Se limiter aux seuls produits encore en stock
				$criteria->add(new Criteria('product_stock', 0, '>'));
			}
			$criteria->add(new Criteria('product_id', '('.implode(',', $ids).')', 'IN'));
			$ret = $this->getObjects($criteria, true, true, '*', false);
		}
		return $ret;
	}


	/**
	 * Retourne le nombre de produits d'une ou de plusieurs cat�gories
	 *
	 * @param mixed $cat_cid	Soit un ID de cat�gorie unique soit un tableau d'ID de cat�gories
	 * @return integer	Le nombre de produits associ�s � cette cat�gorie
	 */
	function getCategoryProductsCount($cat_cid)
	{
		if(is_array($cat_cid)) {
			$lst_ids = implode(',', $cat_cid);
			$criteria = new Criteria('product_cid', '('.$lst_ids.')', 'IN');
		} else {
			$criteria = new Criteria('product_cid', $cat_cid, '=');
		}
		return $this->getCount($criteria);
	}

	/**
	 * Retourne le nombre de produits associ�s � un vendeur
	 *
	 * @param integer	$product_store_id	L'ID du vendeur
	 * @return integer	Le nombre de produits
	 */
	function getStoreProductsCount($product_store_id)
	{
		$criteria = new Criteria('product_store_id', $product_store_id, '=');
		return $this->getCount($criteria);
	}

	/**
	 * Retourne le nombre de produits associ�s � une TVA
	 *
	 * @param integer $product_vat_id	L'identifiant de la TVA
	 * @return integer	Le nombre de produits
	 */
	function getVatProductsCount($product_vat_id)
	{
		$criteria = new Criteria('product_vat_id', $product_vat_id, '=');
		return $this->getCount($criteria);
	}

	function getProductSelector($label, $showAll = true, $sort = 'product_title', $order = 'ASC')
	{
		include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_id', 0, '<>'));
		if(!$showAll) {
			if(myshop_utils::getModuleOption('show_unpublished') == 0) {	// Ne pas afficher les produits qui ne sont pas publi�s
				$criteria->add(new Criteria('product_submitted', time(), '<='));
			}
			if(myshop_utils::getModuleOption('nostock_display') == 0 ) {	// Se limiter aux seuls produits encore en stock
				$criteria->add(new Criteria('product_stock', 0, '>'));
			}
		}
		$start = isset($_GET['startProduct']) ? intval($_GET['startProduct']) : 0;
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$itemsCount = $this->getCount($criteria);
		if($itemsCount > MYSHOP_MAX_PRODUCTS) {
			include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
			$pagenav = new XoopsPageNav( $itemsCount, MYSHOP_MAX_PRODUCTS, $start, 'startProduct');
		}
		$productTray = new XoopsFormElementTray($label, '<br />');
		$products = $this->getObjects($criteria);
		foreach($products as $product) {
			$relatedProducts_d[$oneitem->getVar('product_id')] = xoops_trim($oneitem->getVar('product_title'));
		}


		$user_select_nav = new XoopsFormLabel('', $nav->renderNav(4));
		$criteria->setStart($start);
		$criteria->setLimit(MYSHOP_MAX_PRODUCTS);
	}

}
?>