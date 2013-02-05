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
require_once XOOPS_MODULE_PATH . "/bmcsv/admin/class/ImportCsv.php";

class bmcsv_ImportAction extends Bmcsv_AbstractListAction
{
	protected $mTableName;

	function &_getHandler()
	{
	}

	function _getBaseUrl()
	{
		return "./index.php?action=Import";
	}

	function executeViewIndex(&$controller, &$render)
	{
		$render->setAttribute('table_name', $this->mTableName );
		$render->setAttribute('moduleName', xoops_getrequest("moduleName") );
		$render->setAttribute('tableName', xoops_getrequest("tableName") );
		$render->setTemplateName("csv_import.html");
	}
	
	function getDefaultView()
	{
		$this->mTableName = xoops_getrequest("moduleName") ."_". xoops_getrequest("tableName");
		if (isset($_SESSION['import_csv_upload_data'])){
			unset($_SESSION['import_csv_upload_data']);
		}
		return BMCSV_FRAME_VIEW_INDEX;
	}

	/// equals to getDefaultView()
	function execute(&$controller, &$xoopsUser)
	{
		return $this->getDefaultView();
	}


}

