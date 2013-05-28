<?php

# $Id: download.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Download patch submitted by Matthew Gregg <greggmc@musc.edu>
// 2003/01/30 Modified by James Flemer <jflemer@alum.rpi.edu>
// 2005/05/22 XOOPS version by Yoshi Sakai <webmaster@bluemooninc.biz>

if(
	(!defined('XOOPS_ROOT_PATH')) || 
	(!is_object($xoopsUser)) || 
	(!$xoopsUser->isAdmin()) ){
		return;
		die("Permissions Denied.");
}
require_once("./include/function/form_export_csv.php");

	$sid = -1;
	if (!empty($_GET['sid']))
		$sid = intval($_GET['sid']);
	else if(!empty($_POST['sid']))
		$sid = intval($_POST['sid']);

	$sql = "SELECT name FROM ".TABLE_FORM." WHERE id = $sid";
	$result = $xoopsDB->query($sql);
	if ($xoopsDB->getRowsNum($result) < 1) {
		echo $formRender->mkerror(_MB_Invalid_form_ID);
		return;
	}
	list($name) = $xoopsDB->fetchRow($result);
	

	/* check ACLs for permissions */
	$srealm = $formTable->ownerGroup;
	if (isset($_GET['test'])) {
		/* check ACL to see if user is allowed to test
		 * _this_ form */
		if($editForm->accessLevel['superuser'] != 'Y' &&
				!$formTable->auth_is_owner($sid, $xoopsUser->uid()) &&
				!in_array($srealm, array_intersect(
						$editForm->accessLevel['pdesign'],
						$editForm->accessLevel['pall'])) &&
				!$formTable->auth_no_access(_MB_to_access_this_form)) {
			return;
		}
	} else {
		/* check ACL to see if user is allowed to export
		 * _this_ form */
		if($editForm->accessLevel['superuser'] != 'Y' &&
				!$formTable->auth_is_owner($sid, $xoopsUser->uid()) &&
				!in_array($srealm, array_intersect(
						$editForm->accessLevel['pdata'],
						$editForm->accessLevel['pall'])) &&
				!$formTable->auth_no_access(_MB_to_access_this_form)) {
			return;
		}
	}

	$type = isset($_GET['type']) ? $_GET['type'] : 'csv';
	
	// Try DBF first, default to CSV
	if($type == 'dbf') {
		$file = "$name.dbf";
		if(extension_loaded('dbase')) {
			echo $formRender->mkerror(_MB_DBF_download_not_yet);
		} else {
			echo $formRender->mkerror(_MB_The_PHP_dBase);
		}
		return;
	}
	if($type == 'html') {
		header("Content-Disposition: attachment; filename=$name.html");
		echo("<html>\n");
		$ret = form_results($sid);
		echo("</html>\n");
		return;
	}
	// CSV
	$csv_charset = $GLOBALS['FMXCONFIG']['csv_charset'];
	//$data = form_generate_csv($sid,$csv_charset);
	header("Pragma: private");
	header("Cache-Control: public");
	header("Content-Transfer-Encoding: ".$csv_charset);
	header("Content-Disposition: attachment; filename=$name.csv");
	header("Content-Type: text/comma-separated-values");
	$output = form_generate_csv($sid,$csv_charset);
	foreach ($output as $row ) {
		echo(join(',', $row) . "\n");
	}
	return;
?>
