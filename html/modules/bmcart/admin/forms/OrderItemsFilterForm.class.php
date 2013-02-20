<?php
/**
 * @package bmcart
 * @version $Id: OrderFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractFilterForm.class.php";

define('ORDER_SORT_KEY_ORDERID', 1);
define('ORDER_SORT_KEY_DEFAULT', ORDER_SORT_KEY_ORDERID);

class bmcart_OrderItemsFilterForm extends bmcart_AbstractFilterForm
{
	var $mSortKeys = array(
		ORDER_SORT_KEY_DEFAULT => 'order_id',
		ORDER_SORT_KEY_ORDERID => 'order_id',
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

		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
