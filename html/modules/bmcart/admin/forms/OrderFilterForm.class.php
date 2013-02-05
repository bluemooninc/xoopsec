<?php
/**
 * @package bmcart
 * @version $Id: OrderFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractFilterForm.class.php";

define('ORDER_SORT_KEY_ORDERID', 1);
define('ORDER_SORT_KEY_NAME', 2);
define('ORDER_SORT_KEY_DESCRIPTION', 3);
define('ORDER_SORT_KEY_ORDER_TYPE', 4);
define('ORDER_SORT_KEY_MAXVALUE', 4);

define('ORDER_SORT_KEY_DEFAULT', ORDER_SORT_KEY_ORDERID);

class bmcart_OrderFilterForm extends bmcart_AbstractFilterForm
{
	var $mSortKeys = array(
		ORDER_SORT_KEY_DEFAULT => 'order_id',
		ORDER_SORT_KEY_ORDERID => 'order_id',
		ORDER_SORT_KEY_CATEGORY => 'category_id',
		ORDER_SORT_KEY_NAME => 'order_name',
		ORDER_SORT_KEY_DESCRIPTION => 'order_desc',
		ORDER_SORT_KEY_ORDER_TYPE => 'status'
	);

	function getDefaultSortKey()
	{
		return ORDER_SORT_KEY_DEFAULT;
	}
	
	function fetch()
	{
		parent::fetch();
	
		if (isset($_REQUEST['order_id'])) {
			$this->mNavi->addExtra('order_id', xoops_getrequest('order_id'));
			$this->_mCriteria->add(new Criteria('order_id', xoops_getrequest('order_id')));
		}

		if (isset($_REQUEST['category_id'])) {
			$this->mNavi->addExtra('category_id', xoops_getrequest('category_id'));
			$this->_mCriteria->add(new Criteria('category_id', xoops_getrequest('category_id')));
		}
	
		if (isset($_REQUEST['order_name'])) {
			$this->mNavi->addExtra('order_name', xoops_getrequest('order_name'));
			$this->_mCriteria->add(new Criteria('order_name', xoops_getrequest('order_name')));
		}
	
		if (isset($_REQUEST['status'])) {
			$this->mNavi->addExtra('status', xoops_getrequest('status'));
			$this->_mCriteria->add(new Criteria('group_type', xoops_getrequest('group_type')));
		}
		
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
