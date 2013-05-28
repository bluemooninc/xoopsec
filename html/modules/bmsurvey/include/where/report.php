<?php

# $Id: report.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

	// see if a form has been selected
	if(!empty($_GET['sid'])) {
		$sid = intval($_GET['sid']);
		if(empty($_GET['details']))
			$_GET['details'] = 1; // by default, show details in report

		/* check ACL to see if user is allowed to view
		 * _this_ form */
		$srealm = $formTable->ownerGroup;
		if($editForm->accessLevel['superuser'] != 'Y' &&
				!$formTable->auth_is_owner($sid, $xoopsUser->uid()) &&
				!in_array($srealm, array_intersect(
						$editForm->accessLevel['pdesign'],
						$editForm->accessLevel['pall'])) &&
				!$formTable->auth_no_access(_MB_to_access_this_form)) {
			return;
		}
?>
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" width="95%">
<tr><td>
<?php
		$ret = form_report($sid, $_GET['details']);
		if($ret != '')
			echo($formRender->mkerror($ret));
?>
</td></tr>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=report\">" . _MB_Go_back_to_Report_Menu . "</a>\n"); ?><br>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
<?php
		return;
	}

// No FormId specified, so build a table of
// forms to choose from ...

	$statusbad = (STATUS_DELETED);
	if($xoopsUser->isAdmin()) {
		$sql = "SELECT id,name,title,owner,realm FROM ".TABLE_FORM."
			WHERE NOT (status & $statusbad)
			ORDER BY id DESC";
	} else {
		$realms = array_to_insql(
			array_intersect(
				$editForm->accessLevel['pall'],
				$editForm->accessLevel['pdesign']));
		$sql = "SELECT id,name,title,owner,realm FROM ".TABLE_FORM." WHERE (owner='".
			$xoopsUser->uid() ."' ||
			realm $realms)
			AND NOT (status & $statusbad)
			ORDER BY id DESC";
	}
	$result = $xoopsDB->query($sql);

?>
<h2><?php echo(_MB_View_Form_Report); ?></h2>
<?php echo(_MB_Pick_Form_to_View); ?>
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" width="95%">
	<tr bgcolor="#dddddd">
		<th align="left"><?php echo(_MB_ID); ?></th>
		<th align="left"><?php echo(_MB_Name); ?></th>
		<th align="left"><?php echo(_MB_Title); ?></th>
		<th align="left"><?php echo(_MB_Owner); ?></th>
		<th align="left"><?php echo(_MB_Group); ?></th>
	</tr>
<?php
    $bg = '';
	while(list($sid, $name, $title, $owner, $realm) = $xoopsDB->fetchRow($result)) {
		if($bg != $FMXCONFIG['bgalt_color1'])
			$bg = $FMXCONFIG['bgalt_color1'];
		else
			$bg = $FMXCONFIG['bgalt_color2'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td><?php echo($sid); ?></td>
		<td><a href="<?php echo("". $GLOBALS['FMXCONFIG']['manage'] ."?where=report&sid=${sid}"); ?>">
			<?php echo($name); ?></a>
		</td>
		<td><?php echo($title); ?></td>
		<td><?php echo($owner); ?></td>
		<td><?php echo($realm); ?></td>
	</tr>
<?php
	}
?>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
