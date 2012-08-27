<?php
include '../../../include/cp_header.php';

$modbase = dirname(dirname(__FILE__));
if (!defined("_MD_ORDER_DATE")) {
    if (class_exists("XCube_Root")) {
	$root =& XCube_Root::getSingleton();
	
	$root->mLanguageManager->_loadLanguage($xoopsModule->getVar('dirname'), 'common');
    } else {
	$modres = $modbase."/language";
	$lang = $xoopsConfig['language'];
	if (file_exists("$modres/$lang/common.php")) include_once "$modres/$lang/common.php";
	else include_once "$modres/english/common.php";
    }
}
include "$modbase/const.php";
include "$modbase/functions.php";
?>