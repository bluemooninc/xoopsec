<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcsv/class/AbstractFilterForm.class.php";

define('CATEGORY_SORT_KEY_NAME', 1);

class bmcsv_TableFilterForm extends bmcsv_AbstractFilterForm
{

	function getDefaultSortKey()
	{
	}
	
	function fetch()
	{
		parent::fetch();

		if (isset($_REQUEST['Table_name'])) {
			$this->mNavi->addExtra('Table_name', xoops_getrequest('Table_name'));
			$this->_mCriteria->add(new Criteria('Table_name', xoops_getrequest('Table_name')));
		}

		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
