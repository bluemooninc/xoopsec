<?php
# $Id: finish.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $
// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

	$editForm->editInfo['new_form'] = false;
	$form_name = "";
    $sql = "SELECT name FROM ".TABLE_FORM." WHERE id = '". $editForm->editInfo['form_id']. "'";
    if ($result = $xoopsDB->query($sql)) {
	    if ($xoopsDB->getRowsNum($result) > 0)
		    list($form_name) = $xoopsDB->fetchRow($result);
		
	}
	$finish = array(
		"form_id" => $editForm->editInfo['form_id'],
		'handler' => $FMXCONFIG['handler'],
		'autopub_url' => $FMXCONFIG['autopub_url'],
		'form_name' => $form_name,
		'manage' => $GLOBALS['FMXCONFIG']['manage']
	);
	$editForm->editInfo['form_id'] = NULL;
	$xoopsTpl->assign('finish',$finish);
?>