<?php

# $Id: cancel.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

	//session_register('form_id');
	//session_register('form_realm');
	if(ini_get('register_globals')) {
		$_SESSION['form_id']    = &$form_id;
		$_SESSION['form_realm'] = &$form_realm;
	}

	if(empty($_SESSION['form_id'])) {
		// no form INSERTed yet, so just go back to management interface
		$_SESSION['form_id']    = '';
		$_SESSION['form_realm'] = '';
		include($fmxStatus->esp_where('index'));
		return;
	}

	$sql = "SELECT status FROM ".TABLE_FORM." WHERE	id='".$_SESSION['form_id']."'";
	$result = $xoopsDB->query($sql);
	if($xoopsDB->getRowsNum($result) < 1) {
		$_SESSION['form_id']    = '';
		$_SESSION['form_realm'] = '';
		include($fmxStatus->esp_where('index'));
		return;
	}
	list($status) = $xoopsDB->fetchRow($result);
	
	$status |= STATUS_DELETED;
	$sql = "UPDATE ".TABLE_FORM." SET status='${status}' WHERE id='".$_SESSION['form_id']."'";
	$xoopsDB->query($sql);
	$_SESSION['form_id']    = '';
	$_SESSION['form_realm'] = '';
	include($fmxStatus->esp_where('index'));
	return;
?>
