<?php
$mydirname = basename(dirname(dirname(__FILE__)));
eval(' function xoops_module_update_' . $mydirname . '( $module ) { return bmcart_onupdate_base( $module ,"' . $mydirname . '" ) ; } ');

/**
 * @param $db
 * @param $tblname
 * @param $dataname
 * @return int|null
 */
function checkDataLength(&$db,$tblName,$dataName){
	$sql = "SELECT * from " . $tblName;
	$res_result = $db->query($sql);
	for( $i = 0; $i < mysql_num_fields( $res_result ); $i ++ ){
		if (mysql_field_name( $res_result, $i )==$dataName){
			return mysql_field_len( $res_result, $i );
		}
	}
	return NULL;
}

function bmcart_onupdate_base($module, $myDirName)
{
	global $msgs;

	// for Cube 2.1
	if (defined('XOOPS_CUBE_LEGACY')) {
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add("Module.Legacy.ModuleUpdate.Success", 'bmyahoo_message_append_onupdate');
		$msgs = array();
	} else {
		if (!is_array($msgs)) $msgs = array();
	}
	$db =& Database::getInstance();
	// 0.11 -> 0.12
	$tblName = $db->prefix("users");
	$check_sql = "SELECT user_yconnect FROM " . $tblName;
	if (!$db->query($check_sql)) {
		$sql = "ALTER TABLE " . $tblName . "  ADD `user_yconnect` varchar(26) AFTER `user_msnm`";
		$db->queryF($sql);
	}
	return TRUE;
}

function bmcart_message_append_onupdate(&$module_obj, &$log)
{
	if (is_array(@$GLOBALS['msgs'])) {
		foreach ($GLOBALS['msgs'] as $message) {
			$log->add(strip_tags($message));
		}
	}
}


