<?php
/**
 * @package bmcart
 * @version $Id: SkuFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractFilterForm.class.php";

define('SKU_SORT_KEY_SKU_ID'      , 1);
define('SKU_SORT_KEY_ITEM_ID'       , 2);
define('SKU_SORT_KEY_SKU_NAME', 3);

define('SKU_SORT_KEY_DEFAULT', SKU_SORT_KEY_SKU_ID);

class bmcart_SkuFilterForm extends bmcart_AbstractFilterForm
{
	var $mSortKeys = array(
		SKU_SORT_KEY_DEFAULT        => 'sku_id',
		SKU_SORT_KEY_SKU_ID       => 'sku_id',
		SKU_SORT_KEY_ITEM_ID        => 'item_id',
	);

	function getDefaultSortKey()
	{
		return SKU_SORT_KEY_DEFAULT;
	}
	
	function fetch()
	{
		parent::fetch();
	
		if (isset($_REQUEST['sku_id'])) {
			$this->mNavi->addExtra('sku_id', xoops_getrequest('sku_id'));
			$this->_mCriteria->add(new Criteria('item_id', xoops_getrequest('sku_id')));
		}

		if (isset($_REQUEST['item_id'])) {
			$this->mNavi->addExtra('item_id', xoops_getrequest('item_id'));
			$this->_mCriteria->add(new Criteria('item_id', xoops_getrequest('item_id')));
		}
	
		if (isset($_REQUEST['sku_name'])) {
			$this->mNavi->addExtra('sku_name', xoops_getrequest('sku_name'));
			$this->_mCriteria->add(new Criteria('sku_name', xoops_getrequest('sku_name')));
		}

		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
