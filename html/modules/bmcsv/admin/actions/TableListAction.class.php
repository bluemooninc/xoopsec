<?php
/**
 * Created by JetBrains PhpStorm.
 * Copyright(c): Bluemoon inc.
 * Author : Yoshi Sakai
 * Date: 2013/01/28
 * Time: 13:14
 * To change this template use File | Settings | File Templates.
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmcsv/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcsv/admin/forms/TableFilterForm.class.php";

class bmcsv_TableListAction extends bmcsv_AbstractListAction
{
	function &_getHandler()	{
		return xoops_getHandler('module');
	}
 	function exist_getmodulehandler($name,$module_dir){
		 if (file_exists($hnd_file = XOOPS_ROOT_PATH . '/modules/'.$module_dir.'/class/handler/' . ($ucname = ucfirst($name)) . '.class.php')) {
			 return true;
		 }
		 elseif ( file_exists( $hnd_file = XOOPS_ROOT_PATH . '/modules/'.$module_dir.'/class/'.$name.'.php' ) ) {
			 return true;
		 }
		 return false;
	 }
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
		$moduleHandler =& xoops_gethandler('module');
		$criteria = new Criteria('isactive', 1);
		$moduleObjects =& $moduleHandler->getObjects($criteria);
		foreach ($moduleObjects as $moduleObject) {
			$mod_dir = $moduleObject->get('dirname');
			$mod_object = $moduleHandler->getByDirname($mod_dir);
			$mod_tables = $mod_object->getInfo('tables');
			if ($mod_tables && is_array($mod_tables)) {
				foreach($mod_tables as $table){
					$table = preg_replace("/^{prefix}_{dirname}_/i","",$table);
					if ( $this->exist_getmodulehandler($table,$mod_dir) ){
						$this->mod_list[$mod_dir][]=array(
							'dir' => $mod_dir,
							'name' => $table
						);
					}
				}
			}
		}
		return BMCSV_FRAME_VIEW_INDEX;
	}
	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
		$filter =new bmcsv_TableFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=TableList";
	}

	function executeViewIndex(&$controller, &$render)
	{
		$render->setTemplateName("table_list.html");
		$render->setAttribute("mod_list", $this->mod_list);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
	}
}

