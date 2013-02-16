<?php
$mydirname = basename(dirname(dirname(__FILE__)));
eval(' function xoops_module_update_' . $mydirname . '( $module ) { return bmcart_onupdate_base( $module ,"' . $mydirname . '" ) ; } ');

function bmcart_onupdate_base($module, $mydirname)
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
	$check_sql = "SELECT barcode FROM " . $db->prefix($mydirname . "_item");
	if (!$db->query($check_sql)) {
		$sql = "ALTER TABLE " . $db->prefix($mydirname . "_item") . "  ADD `barcode` VARCHAR( 13 ) NULL AFTER `item_desc`";
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


