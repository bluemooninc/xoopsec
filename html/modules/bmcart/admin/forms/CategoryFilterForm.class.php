<?php
/**
 * @package bmcart
 * @version $Id: CategoryFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractFilterForm.class.php";

define('CATEGORY_SORT_KEY_CATEGORYID', 1);
define('CATEGORY_SORT_KEY_NAME', 2);
define('CATEGORY_SORT_KEY_DESCRIPTION', 3);
define('CATEGORY_SORT_KEY_CATEGORY_TYPE', 4);
define('CATEGORY_SORT_KEY_MAXVALUE', 4);

define('CATEGORY_SORT_KEY_DEFAULT', CATEGORY_SORT_KEY_CATEGORYID);

class bmcart_CategoryFilterForm extends bmcart_AbstractFilterForm
{
	var $mSortKeys = array(
		CATEGORY_SORT_KEY_DEFAULT => 'category_id',
		CATEGORY_SORT_KEY_CATEGORYID => 'category_id',
		CATEGORY_SORT_KEY_NAME => 'category_name',
		CATEGORY_SORT_KEY_PARENT => 'parent_id',
	);

	function getDefaultSortKey()
	{
		return CATEGORY_SORT_KEY_DEFAULT;
	}
	
	function fetch()
	{
		parent::fetch();
	
		if (isset($_REQUEST['category_id'])) {
			$this->mNavi->addExtra('category_id', xoops_getrequest('category_id'));
			$this->_mCriteria->add(new Criteria('category_id', xoops_getrequest('category_id')));
		}
	
		if (isset($_REQUEST['category_name'])) {
			$this->mNavi->addExtra('category_name', xoops_getrequest('category_name'));
			$this->_mCriteria->add(new Criteria('category_name', xoops_getrequest('category_name')));
		}

		if (isset($_REQUEST['parent_id'])) {
			$this->mNavi->addExtra('parent_id', xoops_getrequest('parent_id'));
			$this->_mCriteria->add(new Criteria('parent_id', xoops_getrequest('parent_id')));
		}
		
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
