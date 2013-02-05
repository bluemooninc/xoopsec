<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class bmcsv_AbstractExportAction extends bmcsv_Action
{
	var $mObject = null;
	var $mObjectHandler = null;
	var $mActionForm = null;
	var $mConfig;
	protected $mParameter = null;
	protected $textBuffer = null;

	/**
	 * @access protected
	 */
	function _setupObject()
	{
		$this->mParameter['tableName'] = xoops_getrequest("tableName");
		$this->mParameter['moduleName'] = xoops_getrequest("moduleName");
		$this->mObjectHandler = xoops_getmodulehandler(
			$this->mParameter['tableName'], $this->mParameter['moduleName']
		);
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->mConfig = $moduleConfig;
		$this->_setupObject();
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		if (!$this->mObjectHandler) {
			return BMCSV_FRAME_VIEW_ERROR;
		}
		return $this->_doExecute($this->mObject) ? BMCSV_FRAME_VIEW_SUCCESS
		                                         : BMCSV_FRAME_VIEW_ERROR;
	}

	/**
	 * @access protected
	 */
	function _doExecute()
	{
		$this->_setCsvHeader();
		$objects = $this->mObjectHandler->getObjects();
		$this->_setCsvBody($objects);
		if ($this->textBuffer){
			return true;
		}else{
			return false;
		}
	}

	private function _setCsvHeader(){
		$object = $this->mObjectHandler->create();
		$field_line = "";
		foreach($object->gets() as $key=>$value){
			if ($field_line) $field_line .= ",";
			$field_line .= '"' . $key . '"';
		}
		$field_line .= "\n";
		$this->textBuffer =  $field_line;
	}

	private function _setExportData($value){
		if (preg_match('/[,"\r\n]/', $value)) {
			$value = preg_replace('/"/', "\"\"", $value);
		}
		$value = "\"$value\"";
		return $value;
	}

	private function _setCsvBody(&$objects){
		foreach ($objects as $object) {
			$field_line = "";
			foreach($object->gets() as $key=>$value){
				if ($field_line) $field_line .= ",";
				$field_line .= $this->_setExportData($value);
			}
			$this->textBuffer .= $field_line . "\n";
		}
	}

	public function executeDownload()
	{
		$filename = $this->mParameter['moduleName'] ."_". $this->mParameter['tableName'] . ".csv";
		// for Windows in japanese
		if (strncasecmp($GLOBALS['xoopsConfig']['language'], 'ja', 2) === 0) {
			mb_convert_variables('SJIS', _CHARSET, $this->textBuffer);
		}
		if (preg_match('/firefox/i', xoops_getenv('HTTP_USER_AGENT'))) {
			header("Content-Type: application/x-csv");
		} else {
			header("Pragma: public");
			header("Content-Type: application/octet-stream");
		}
		header("Content-Disposition: attachment ; filename=\"{$filename}\"");
		while (ob_get_level() > 0) {
			ob_end_clean();
		}
		exit($this->textBuffer);
	}

}

?>
