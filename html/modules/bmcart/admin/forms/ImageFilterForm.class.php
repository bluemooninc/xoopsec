<?php
/**
 * @package bmcart
 * @version $Id: ImageFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcart/class/AbstractFilterForm.class.php";

define('IMAGE_SORT_KEY_IMAGE_ID'      , 1);
define('IMAGE_SORT_KEY_ITEM_ID'       , 2);
define('IMAGE_SORT_KEY_IMAGE_FILENAME', 3);

define('IMAGE_SORT_KEY_DEFAULT', IMAGE_SORT_KEY_IMAGE_ID);

class bmcart_ImageFilterForm extends bmcart_AbstractFilterForm
{
	var $mSortKeys = array(
		IMAGE_SORT_KEY_DEFAULT        => 'image_id',
		IMAGE_SORT_KEY_IMAGE_ID       => 'image_id',
		IMAGE_SORT_KEY_ITEM_ID        => 'item_id',
		IMAGE_SORT_KEY_IMAGE_FILENAME => 'image_filename'
	);

	function getDefaultSortKey()
	{
		return IMAGE_SORT_KEY_DEFAULT;
	}
	
	function fetch()
	{
		parent::fetch();
	
		if (isset($_REQUEST['image_id'])) {
			$this->mNavi->addExtra('image_id', xoops_getrequest('image_id'));
			$this->_mCriteria->add(new Criteria('item_id', xoops_getrequest('image_id')));
		}

		if (isset($_REQUEST['item_id'])) {
			$this->mNavi->addExtra('item_id', xoops_getrequest('item_id'));
			$this->_mCriteria->add(new Criteria('item_id', xoops_getrequest('item_id')));
		}
	
		if (isset($_REQUEST['image_filename'])) {
			$this->mNavi->addExtra('image_filename', xoops_getrequest('image_filename'));
			$this->_mCriteria->add(new Criteria('image_filename', xoops_getrequest('image_filename')));
		}

		
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
