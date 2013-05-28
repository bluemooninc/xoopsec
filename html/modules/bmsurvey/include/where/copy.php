<?php

# $Id: copy.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

require_once("./include/function/form_copy.php");

$sid = 0;
if(isset($_POST['sid'])) $sid = intval($_POST['sid']);
elseif(isset($_GET['sid'])) $sid = intval($_GET['sid']);

	/* if form has been selected ... */
	if($sid) {
		
		$srealm = $formTable->ownerGroup;
		/* check ACL to see if user is allowed to copy
		 * _this_ form */
		if($editForm->accessLevel['superuser'] != 'Y' &&
		!$formTable->auth_is_owner($sid, $xoopsUser->uid()) &&
				!in_array($srealm, $xoopsUser->getGroups()) &&
				!$formTable->auth_no_access('to access this form')) {
					return;
		}

		/* copy the form */
		if(!form_copy($sid)) {
			echo($formRender->mkerror(_MB_Error_copying_form ." (". $xoopsDB->error() .")") . "<br>\n");
			echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n");
			return;
		}
?>
<script language="JavaScript"><!--
window.location="<?php echo($GLOBALS['FMXCONFIG']['manage'] ."?where=manage"); ?>"
//-->
</script>
<?php
		echo("<noscript><a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a></noscript>\n");
		return;
	}

	/* load names and titles of all forms available to
	 * _this_ user */
	if($xoopsUser->isAdmin()) {
		$sql = "SELECT id,name,title,status,owner,realm FROM ".TABLE_FORM." ORDER BY id DESC";
	} else {
		$realms = array_to_insql(
			array_intersect(
				$editForm->accessLevel['pall'],
				array_merge(
					$editForm->accessLevel['pall'],
					$editForm->accessLevel['pdesign'])));
		$sql = "SELECT id,name,title,status,owner,realm FROM ".TABLE_FORM.
			" WHERE NOT (status & ". STATUS_DELETED .") AND (owner = '".
			$xoopsUser->uid() ."' || realm $realms) ORDER BY id DESC";
	}
	$result = $xoopsDB->query($sql);
	$bg = '';
?>
