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
		$root->mDelegateManager->add("Module.Legacy.ModuleUpdate.Success", 'bulletin_message_append_onupdate');
		$msgs = array();
	} else {
		if (!is_array($msgs)) $msgs = array();
	}
	$db =& Database::getInstance();
	// 0.11 -> 0.12
	$check_sql = "SELECT barcode FROM " . $db->prefix($myDirName . "_item");
	if (!$db->query($check_sql)) {
		$sql = "ALTER TABLE " . $db->prefix($myDirName . "_item") . "  ADD `barcode` VARCHAR( 13 ) NULL AFTER `item_desc`";
		$db->queryF($sql);
	}
	// 0.14 -> 0.15
	$tblName = $db->prefix($myDirName . "_order");
	if (checkDataLength($db,$tblName,"phone") < 14){
		$sql = "ALTER TABLE " . $tblName . " CHANGE `phone` `phone` VARCHAR( 14 )";
		$db->queryF($sql);
	}
	// 0.15 -> 0.16
	$tblName = $db->prefix($myDirName . "_itemSku");
	$check_sql = "SHOW TABLES LIKE '" . $tblName ."'";
	list($result) = $db->fetchRow($db->query($check_sql));
	if (empty($result)) {
		$sql = "CREATE TABLE ".$tblName ." (
			`sku_id` int(8) unsigned NOT NULL auto_increment,
			`item_id` int(8) unsigned NOT NULL,
			`sku_name` varchar(255) NOT NULL,
			`sku_stock` int(1) unsigned NOT NULL,
			PRIMARY KEY  (`sku_id`),
			KEY item_id (`item_id`)
		) ENGINE = MYISAM;";
		$db->queryF($sql);
	}
	$tblName = $db->prefix($myDirName . "_orderItems");
	$check_sql = "SELECT sku_id FROM " . $tblName;
	if (!$db->query($check_sql)) {
		$sql = "ALTER TABLE " . $tblName . " ADD `sku_id` int(8) unsigned AFTER `item_id`";
		$db->queryF($sql);
	}
	$tblName = $db->prefix($myDirName . "_cart");
	$check_sql = "SELECT sku_id FROM " . $tblName;
	if (!$db->query($check_sql)) {
		$sql = "ALTER TABLE " . $tblName . " ADD `sku_id` int(8) unsigned AFTER `item_id`";
		$db->queryF($sql);
	}
	// 0.23 -> 0.24
	$tblName = $db->prefix($myDirName . "_itemImages");
	$check_sql = "SELECT youtube_id FROM " . $tblName;
	if (!$db->query($check_sql)) {
		$sql = "ALTER TABLE " . $tblName . " ADD `youtube_id` VARCHAR(11) NULL DEFAULT NULL AFTER `image_filename`";
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


