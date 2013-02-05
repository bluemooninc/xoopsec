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

require_once dirname(__FILE__) . "/ImportAction.class.php";
require_once XOOPS_MODULE_PATH . "/bmcsv/admin/class/ImportCsv.php";

class bmcsv_ImportConfAction extends bmcsv_ImportAction
{
	protected $mKey = array();
	protected $mModuleName;
	protected $mTableName;
	protected $mHandler;
	protected $mPrimaryKey;

	function &_getHandler()
	{
		$this->mModuleName = xoops_getrequest("moduleName");
		$this->mTableName = xoops_getrequest("tableName");
		$this->mHandler = xoops_getmodulehandler($this->mTableName,$this->mModuleName);
		return $this->mHandler;
	}

	function execute()
	{
		$this->_getHandler();
		$acceptMime = array(
			'text/x-comma-separated-values',
			'text/comma-separated-values',
			'application/octet-stream',
			'application/vnd.ms-excel',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'application/x-csv'
		);

		/// csv file check
		if (isset($_FILES['bmcsv_csv_file'])){
			$ret = true;
			if (!in_array($_FILES['bmcsv_csv_file']['type'],$acceptMime)) $ret = false;
			if ($_FILES['bmcsv_csv_file']['error'] != 0) $ret = false;
			if ($ret) return BMCSV_FRAME_VIEW_SUCCESS;
		}
		return $this->getDefaultView();
	}


	function executeViewSuccess(&$controller,&$render)
	{
		// success
		$render->setTemplateName("csv_import_conf.html");

		// csv data
		$csvData = array();
		$csvFName = XOOPS_TRUST_PATH . "/cache/".time().".csv";
		@move_uploaded_file( $_FILES['bmcsv_csv_file']['tmp_name'], $csvFName );

		// Get table keys
		$object = $this->mHandler->create();
		$this->mKey = array_keys($object->gets());

		// Set key to restore
		if (function_exists('mb_detect_encoding')){
			$csv_encoding = "SJIS-WIN";
		}else{
			$csv_encoding = '';
		}
		ini_set('auto_detect_line_endings', 1);
		$lineCount=0;
		$fp = fopen($csvFName, 'r');
		$iCsv = new importCsv($this->mKey);
		$this->mPrimaryKey = $iCsv->mysql_get_prim_key($this->mModuleName."_".$this->mTableName);
		$iPrimary = $iCsv->getPrimaryKeyPosition( $this->mPrimaryKey, $this->mKey);
		while (!feof($fp)) {
			$_line = $iCsv->loadCSV($fp, $csv_encoding);
			if ($lineCount > 0 && $_line) {
				$csvData[] = $iCsv->loadOneLineToArray($_line, $iPrimary, $this->mKey, $this->mHandler);
			} else {
				$csvHeader = explode(",",preg_replace("/\"/","",trim($_line)));
				if( count(array_intersect($csvHeader,$this->mKey)) != count($this->mKey) ){
					break;
				}
			}
			$lineCount++;
		}
		fclose($fp);
		$render->setAttribute('import_fields', $this->mKey);
		$render->setAttribute('csv_data', $csvData, $iCsv->mObjects() );
		$render->setAttribute('lineCount', $lineCount-1 );
		$render->setAttribute('uploaded_filename', $csvFName);
		$render->setAttribute('moduleName',$this->mModuleName );
		$render->setAttribute('tableName', $this->mTableName );
	}
}
