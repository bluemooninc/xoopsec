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

class bmcsv_ImportDoAction extends bmcsv_ImportAction
{
	var $mkey = array();
	var $mObjects = array();
	var $csvFName = null;
	protected $root;

	public function __construct()
	{
		$this->root = XCube_Root::getSingleton();
	}


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
		/// back
		if (isset($_POST['back'])) {
			return $this->getDefaultView();
		}
		$this->csvFName = xoops_getrequest("uploaded_filename");
		return BMCSV_FRAME_VIEW_SUCCESS;
//		return $this->getDefaultView();
	}

	private function arrayToDb(&$mHandler, &$import_key, &$data)
	{
		if ( $data['mUpdate'] || $data['mCreate']) {
			if ($data['mUpdate']) {
				$object = $mHandler->get($data['primaryId']);
			} elseif ($data['mCreate']) {
				$object = $mHandler->create();
			}
			if ($object){
				foreach ($import_key as $i => $key) {
					$value = $data['value'][$i]['var'];
					$field = $data['value'][$i]['field'];
					if (is_null($value) || is_null($field)) continue;
					$object->setVar($key, $value);
				}
				return $mHandler->insert($object);
			}
		}
		return false;
	}


	/**
	 * @param $render
	 * @throws RuntimeException
	 */
	function executeViewSuccess(&$controller,&$render)
	{
		$render->setTemplateName("data_upload_done.html");
		// csv data
		$csvFName = xoops_getrequest('uploaded_filename');

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
				$csvData = $iCsv->loadOneLineToArray($_line, $iPrimary, $this->mKey, $this->mHandler);
				$this->arrayToDb( $this->mHandler, $this->mKey, $csvData );
			}
			$lineCount++;
		}
		fclose($fp);
		unset($this->csvFName);
		//$controller->executeRedirect("./index.php?action=DefinitionsList", 1, _AD_BMCSV_DATA_UPLOAD_DONE);
	}
}