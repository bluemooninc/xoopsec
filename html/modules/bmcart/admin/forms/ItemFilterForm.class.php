<?php
/**
 * @package bmcart
 * @version $Id: ItemFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractFilterForm.class.php";

define('ITEM_SORT_KEY_UPDATE'  , 1);
define('ITEM_SORT_KEY_CATEGORY', 2);
define('ITEM_SORT_KEY_NAME'    , 3);
define('ITEM_SORT_KEY_PRICE'   , 4);
define('ITEM_SORT_KEY_SHIPPING', 5);
define('ITEM_SORT_KEY_STOCK'   , 6);
define('ITEM_SORT_KEY_DEFAULT' , ITEM_SORT_KEY_UPDATE);

class bmcart_ItemFilterForm extends bmcart_AbstractFilterForm
{
	var $mSortKeys = array(
		ITEM_SORT_KEY_DEFAULT  => 'last_update',
		ITEM_SORT_KEY_UPDATE   => 'last_update',
		ITEM_SORT_KEY_CATEGORY => 'category_id',
		ITEM_SORT_KEY_NAME     => 'item_name',
		ITEM_SORT_KEY_PRICE    => 'price',
		ITEM_SORT_KEY_SHIPPING => 'shipping_fee',
		ITEM_SORT_KEY_STOCK    => 'stock_qty'
	);
	var $mKeyword = "";

	function getDefaultSortKey()
	{
		return -ITEM_SORT_KEY_DEFAULT;
	}
	
	function fetch()
	{
		parent::fetch();

		$root =& XCube_Root::getSingleton();
		$search = $root->mContext->mRequest->getRequest('search');

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

		if (!empty($search)) {
			$this->mKeyword = $search;
			$this->mNavi->addExtra('search', $this->mKeyword);
			$this->_mCriteria->add(new Criteria('item_name', '%' . $this->mKeyword . '%', 'LIKE'));
		}

		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
