<?php
/**
 * Created by JetBrains PhpStorm.
 * Copyright(c): Bluemoon inc.
 * Author : Yoshi Sakai
 * Date: 2013/01/28
 * Time: 13:14
 * To change this template use File | Settings | File Templates.
 */
class importCsv
{
	protected $mObjects = array();
	protected $mKey;

	function importCsv($mKey)
	{
		$this->mKey = $mKey;
	}

	/**
	 *  CSVエスケープ処理を行う
	 *
	 * @access public
	 * @param  string  $csv        エスケープ対象の文字列(CSVの各要素)
	 * @param  bool    $escape_nl  改行文字(\r/\n)のエスケープフラグ
	 * @return string  CSVエスケープされた文字列
	 */
	function escapeCSV($csv, $escape_nl = false)
	{
		if (preg_match('/[,"\r\n]/', $csv)) {
			if ($escape_nl) {
				$csv = preg_replace('/\r/', "\\r", $csv);
				$csv = preg_replace('/\n/', "\\n", $csv);
			}
			$csv = preg_replace('/"/', "\"\"", $csv);
			$csv = "\"$csv\"";
		}

		return $csv;
	}

	// }}}

	/**
	 * @param $fp
	 * @param $csv_encoding
	 * @return string
	 */
	public function loadCSV(&$fp, $csv_encoding)
	{
		$csvLine = "";
		while (!feof($fp)) {
			$_line = rtrim(fgets($fp));
			if ($csv_encoding) {
				mb_convert_variables(_CHARSET, $csv_encoding, $_line);
			}
			$csvLine .= $_line;
			$cnt = substr_count($csvLine, '"');
			if ($cnt % 2 == 0) break;
		}
		return $csvLine;
	}

	/**
	 *  CSV形式の文字列を配列に分割する
	 *
	 * @access public
	 * @param  string  $csv        CSV形式の文字列(1行分)
	 * @param  string  $delimiter  フィールドの区切り文字
	 * @return mixed   (array):分割結果 Error:エラー(行継続)
	 */
	static function _explodeCsv($csv)
	{
		$delimiter = ",";
		$space_list = '';
		foreach (array(" ", "\t", "\r", "\n") as $c) {
			if ($c != $delimiter) {
				$space_list .= $c;
			}
		}
		$line_end = "";
		if (preg_match("/([$space_list]+)\$/sS", $csv, $match)) {
			$line_end = $match[1];
		}
		$csv = substr($csv, 0, strlen($csv) - strlen($line_end));
		$csv .= ' ';

		$field = '';
		$retval = array();

		$index = 0;
		$csv_len = strlen($csv);
		do {
			// 1. skip leading spaces
			if (preg_match("/^([$space_list]+)/sS", substr($csv, $index), $match)) {
				$index += strlen($match[1]);
			}
			if ($index >= $csv_len) {
				break;
			}

			// 2. read field
			if ($csv[$index] == '"') {
				// 2A. handle quote delimited field
				$index++;
				while ($index < $csv_len) {
					$checkChar = isset($csv[$index]) ? $csv[$index] : null;
					if ($checkChar == '"') {
						// handle double quote
						if ($csv[$index + 1] == '"') {
							$field .= $csv[$index];
							$index += 2;
						} else {
							// must be end of string
							while ($checkChar != $delimiter && $index < $csv_len) {
								$index++;
								$checkChar = isset($csv[$index]) ? $csv[$index] : null;
							}
							if ($checkChar == $delimiter) {
								$index++;
							}
							break;
						}
					} else {
						// normal character
						if (preg_match("/^([^\"]*)/S", substr($csv, $index), $match)) {
							$field .= $match[1];
							$index += strlen($match[1]);
						}
						if ($index == $csv_len) {
							$field = substr($field, 0, strlen($field) - 1);
							$field .= $line_end;
							// request one more line
							// return 'CSV Split Error (line continue)';
						}
					}
				}
			} else {
				// 2B. handle non-quoted field
				if (preg_match("/^([^$delimiter]*)/S", substr($csv, $index), $match)) {
					$field .= $match[1];
					$index += strlen($match[1]);
				}
				// remove trailing spaces
				$field = preg_replace("/[$space_list]+\$/S", '', $field);
				if (isset($csv[$index])){
					if ($csv[$index] == $delimiter) {
						$index++;
					}
				}
			}
			$retval[] = $field;
			$field = '';
		} while ($index < $csv_len);
		return $retval;

	}
	public function getPrimaryKeyPosition($primaryKey, &$import_key){
		// Get Primary Key                                               ]
		for ($i = 0; $i < count($import_key); $i++) {
			if ($import_key[$i]==$primaryKey){
				return $i;
			}
		}
	}
	/**
	 * @param $_line
	 * @return array|null
	 */
	public function &loadOneLineToArray($_line, $iPrimary, &$import_key, &$mHandler)
	{
		if (!$_line) return null;
		$_data = $this->_explodeCsv($_line);
		$import_data = array(
			'error' => false,
			'primaryId' => 0,
			'mCreate' => false,
			'mUpdate'=>false,
			'value' => array()
		);
		if (count($_data) != count($import_key)) {
			$import_data['error'] = true;
		}
		$import_data['primaryId'] = $_data[$iPrimary];
		$object = $mHandler->get($import_data['primaryId']);
		for ($i = 0; $i < count($import_key); $i++) {
			$csv_value = isset($_data[$i]) ? $_data[$i] : null;
			$key = $import_key[$i];
			if (in_array($key, $this->mKey)) {
				$dbValue = $object ? $object->get($key) : null;
				$mUpdate = ($dbValue <> $csv_value) ? true : false;
				$import_data['mUpdate'] = ($import_data['mUpdate'] | $mUpdate) ? true : false;
				$import_data['value'][] = array('field' => $key, 'var' => $csv_value, 'update' => $mUpdate);
			}
		}
		if ( !$object && $import_data['value']){
			$import_data['mUpdate'] = false;
			$import_data['mCreate'] = true;
		}
		return $import_data;
	}

	public function mysql_get_prim_key($table){
		$root = XCube_Root::getSingleton();
		$db = $root->mController->getDB();
		$sql = "SHOW INDEX FROM " . $db->prefix($table) . " WHERE Key_name = 'PRIMARY'";
		$gp = $db->queryF($sql);
		$cgp = mysql_num_rows($gp);
		if($cgp > 0){
			$agp = mysql_fetch_array($gp);
			return($agp['Column_name']);
		}else{
			return(false);
		}
	}

	public function &mObjects()
	{
		return $this->mObjects;
	}
}