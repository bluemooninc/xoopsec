<?php
// $Id: header.php,v 1.10 2010-10-10 05:00:57 nobu Exp $

include '../../mainfile.php';
if (!defined("_MD_ORDER_DATE")) {
    if (class_exists("XCube_Root")) {	// for XCL with altsys resources
	$root =& XCube_Root::getSingleton();
	
	$root->mLanguageManager->_loadLanguage($xoopsModule->getVar('dirname'), 'common');
    } else {
	$modres = (dirname(__FILE__)."/language/");
	$lang = $xoopsConfig['language'];
	if (file_exists("$modres/$lang/common.php")) include_once "$modres/$lang/common.php";
	else include_once "$modres/english/common.php";
    }
}
include 'const.php';
include 'functions.php';
?>