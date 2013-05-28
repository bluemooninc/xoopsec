<?php

# $Id: access.php,v 0.82 2007/12/03 14:38:03 yoshis Exp $

//include_once(ESP_BASE . '/admin/include/lib/groupaccess.php');

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

	if (!empty($_POST['sid']))
		$sid = intval($_POST['sid']);
	elseif (!empty($_GET['sid']))
		$sid = intval($_GET['sid']);
	else
		$sid = '';

	$errstr = "";
	$bg = '';

	if ($sid) {
		if($xoopsUser->isAdmin()) {
			$sql = "SELECT s.name, s.title, s.owner, s.realm, s.public
				FROM ".TABLE_FORM." s WHERE s.id = '$sid'";
			$sql1 = "SELECT a.realm, a.maxlogin, a.resume, a.navigate FROM ".TABLE_ACCESS." a
				WHERE a.form_id = '$sid' ORDER BY a.realm";
		} else {
			$realms = array_to_insql(
				array_intersect(
					$editForm->accessLevel['pall'],
					array_merge(
						$editForm->accessLevel['pall'],
						$editForm->accessLevel['pdesign'])));
			$sql = "SELECT s.name, s.title, s.owner, s.realm, s.public
				FROM ".TABLE_FORM." s WHERE s.id = '$sid' AND NOT (status & " .STATUS_DELETED. ") AND (s.owner = '".
				$xoopsUser->uid() ."' || s.realm $realms)";
			$sql1 = "SELECT a.realm, a.maxlogin, a.resume, a.navigate FROM ".TABLE_ACCESS." a, "
				.TABLE_FORM." s WHERE a.form_id = '$sid' AND s.id=a.form_id AND (s.owner = '".
				$xoopsUser->uid() ."' || s.realm $realms) ORDER BY a.realm";
		}
		$result = $xoopsDB->query($sql);
		if ($xoopsDB->getRowsNum($result) < 1) {
			$sid = 0;
		}
	}
	if ($sid) {
		list($name,$title,$owner,$realm,$public) = $xoopsDB->fetchRow($result);
		

		if (!empty($_POST['op']))
			$op = $_POST['op'];
		elseif (!empty($_GET['op']))
			$op = $_GET['op'];
		else
			$op = '';

		if (!empty($_POST['realm']))
			$arealm = addslashes($_POST['realm']);
		elseif (!empty($_GET['realm']))
			$arealm = addslashes($_GET['realm']);

		if (isset($_POST['resume']))
			$resume = 'Y';
		else
			$resume = 'N';
		
		if (isset($_POST['navigate']))
			$navigate = 'Y';
		else
			$navigate = 'N';
		
		if (!empty($_POST['max']))
			$max = intval($_POST['max']);
		elseif (!empty($_GET['max']))
			$max = intval($_GET['max']);
		else
			$max = 0;

		if ($op == 'a') {
			if (empty($_POST['realm'])) {
				$errstr = $formRender->mkerror(_MB_Please_select_a_group);
			} else {
				$sql = "INSERT INTO ".TABLE_ACCESS." (form_id, realm, maxlogin, resume, navigate)
					VALUES ('$sid', '$arealm', '$max', '$resume', '$navigate')";
				$xoopsDB->query($sql);
			}
		} elseif ($op == 'r') {
			$sql = "DELETE FROM ".TABLE_ACCESS." WHERE form_id = '$sid' AND realm = '$arealm'";
			echo $sql;
			$xoopsDB->query($sql);
		} elseif ($op == 'v') {
			$sql = "UPDATE ".TABLE_FORM." SET public = 'N' WHERE id = '$sid'";
			$xoopsDB->query($sql);
			$sid = 0;
		} elseif ($op == 'p') {
			$sql = "UPDATE ".TABLE_FORM." SET public = 'Y' WHERE id = '$sid'";
			$xoopsDB->query($sql);
			$sid = 0;
		}
	}
	if ($sid) {
		if ($public == 'N')
			$public = _MB_Private;
		else
			$public = _MB_Public;

		$r = '<select name="realm"><option></option>';
		$groups = array();
		if($xoopsUser->isAdmin()) {
			/*
			$sql = "SELECT name FROM ".TABLE_REALM."";
			$result = $xoopsDB->query($sql);
			while( list($g) = $xoopsDB->fetchRow($result) ) {
				array_push($groups, $g);
			}
			
			*/
			$member_handler =& xoops_gethandler('member');
			$groups = $member_handler->getGroupList(); 
		} else {
			$groups =& $editForm->accessLevel['pgroup'];
		}
		$i = 0;
		foreach($groups as $g) {
			$i++;
			$r .= "<option value=\"$i\">$g</option>";
		}
		$r .= '</select>';
	}
?>