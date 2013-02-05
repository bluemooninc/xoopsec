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
require_once XOOPS_MODULE_PATH . "/bmcsv/class/AbstractExportAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcsv/admin/forms/TableAdminExportForm.class.php";

class bmcsv_TableExportAction extends bmcsv_AbstractExportAction{


	function executeViewSuccess(&$controller, &$render)
	{
		$this->executeDownload();
		$controller->executeForward("index.php");
	}

	function executeViewError(&$controller, &$render)
	{
		$controller->executeRedirect("index.php?action=CategoryList", 5, _MD_BMCSV_ERROR_DBUPDATE_FAILED);
	}

	function executeViewCancel(&$controller, &$render)
	{
		$controller->executeForward("index.php?action=CategoryList");
	}
}
