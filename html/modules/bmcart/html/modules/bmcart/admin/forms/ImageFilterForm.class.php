<?php
/**
 * @package bmcart
 * @version $Id: ImageFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractFilterForm.class.php";

define('IMAGE_SORT_KEY_IMAGEID', 1);
define('IMAGE_SORT_KEY_NAME', 2);
define('IMAGE_SORT_KEY_DESCRIPTION', 3);
define('IMAGE_SORT_KEY_IMAGE_TYPE', 4);
define('IMAGE_SORT_KEY_MAXVALUE', 4);

define('IMAGE_SORT_KEY_DEFAULT', IMAGE_SORT_KEY_IMAGEID);

class bmcart_ImageFilterForm extends bmcart_AbstractFilterForm
{
	var $mSortKeys = array(
		IMAGE_SORT_KEY_DEFAULT => 'image_id',
		IMAGE_SORT_KEY_IMAGEID => 'item_id',
		IMAGE_SORT_KEY_CATEGORY => 'category_id',
		IMAGE_SORT_KEY_NAME => 'item_name',
		IMAGE_SORT_KEY_DESCRIPTION => 'item_desc',
		IMAGE_SORT_KEY_IMAGE_TYPE => 'status'
	);

	function getDefaultSortKey()
	{
		return IMAGE_SORT_KEY_DEFAULT;
	}
	
	function fetch()
	{
		parent::fetch();
	
		if (isset($_REQUEST['item_id'])) {
			$this->mNavi->addExtra('item_id', xoops_getrequest('item_id'));
			$this->_mCriteria->add(new Criteria('item_id', xoops_getrequest('item_id')));
		}

		if (isset($_REQUEST['category_id'])) {
			$this->mNavi->addExtra('category_id', xoops_getrequest('category_id'));
			$this->_mCriteria->add(new Criteria('category_id', xoops_getrequest('category_id')));
		}
	
		if (isset($_REQUEST['item_name'])) {
			$this->mNavi->addExtra('item_name', xoops_getrequest('item_name'));
			$this->_mCriteria->add(new Criteria('item_name', xoops_getrequest('item_name')));
		}
	
		if (isset($_REQUEST['status'])) {
			$this->mNavi->addExtra('status', xoops_getrequest('status'));
			$this->_mCriteria->add(new Criteria('group_type', xoops_getrequest('group_type')));
		}
		
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
