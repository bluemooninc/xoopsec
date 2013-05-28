<?php

# $Id: groups.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>
// <jflemer@acm.rpi.edu>

	/* load only accounts available to _this_ user */
	if($editForm->accessLevel['superuser'] != 'Y' &&
			!$formTable->auth_no_access(_MB_to_access_this_form)) {
		return;
	}
	
	$errstr = '';
	if(!empty($_POST['r']) && !empty($_POST['t'])) {
		$sql = "INSERT INTO ".TABLE_REALM." (name, title)
		VALUES ('". addslashes($_POST['r']) ."', '".
		addslashes($_POST['t']) ."')";
		if(!$xoopsDB->query($sql))
			$errstr = _MB_Error_adding_group . ' (' . $xoopsDB->error() .')';
	}
	if(!empty($_GET['del'])) {
		if($_GET['del'] == 'superuser') {
			$errstr = _MB_Error_deleting_group;
		} else {
			$sql = "SELECT count(d.uid) FROM ".TABLE_DESIGNER." d WHERE d.realm='". addslashes($_GET['del']) ."'";
			list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
			
			if ($count > 0) {
				$errstr = _MB_Group_is_not_empty;
			} else {
				$sql = "DELETE FROM ".TABLE_REALM." WHERE name='". addslashes($_GET['del']) ."'";
				if(!$xoopsDB->query($sql))
					$errstr = _MB_Error_deleting_group;
			}
		}
	}

	$sql = "SELECT r.name, r.title, count(d.uid) FROM ".TABLE_REALM." r LEFT JOIN ".TABLE_DESIGNER." d ON r.name=d.realm GROUP BY r.name ORDER BY r.name";
	$sql2 = "SELECT count(d.uid) FROM ".TABLE_REALM." r LEFT JOIN ".TABLE_RESPONDENT." d ON r.name=d.realm GROUP BY r.name ORDER BY r.name";
	$result = $xoopsDB->query($sql);
	while ( $arr[] = $xoopsDB->fetchArray($xoopsDB->query($sql2)));
	
	$i = 0;
	$bg = $FMXCONFIG['bgalt_color2'];
?>
<h2><?php echo(_MB_Manage_Groups); ?></h2>
<?php if(!empty($errstr)) echo('<p>'. $formRender->mkerror($errstr) ."</p>\n"); ?>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
<input type="hidden" name="where" value="groups">
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" width="95%">
	<tr bgcolor="<?php echo($bg); ?>">
		<th align="left"><?php echo(_MB_Group); ?></th>
		<th align="left"><?php echo(_MB_Description); ?></th>
		<th align="left"><?php echo(_MB_Members); ?></th>
		<td>&nbsp;</td>
	</tr>
<?php
	while(list($realm, $title, $count) = $xoopsDB->fetchRow($result)) {
		$count += $arr[$i++];

		if ($bg == $FMXCONFIG['bgalt_color1'])
			$bg =& $FMXCONFIG['bgalt_color2'];
		else
			$bg =& $FMXCONFIG['bgalt_color1'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td><?php echo($realm);  ?></td>
		<td><?php echo($title);  ?></td>
		<td><?php echo($count);  ?></td>
		<td><?php echo ($count ?
			"&nbsp;" :
			"<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=groups&del=$realm\">". _MB_Delete ."</a>"); ?></td>
	</tr>
<?php
	}
	
	
	
	if ($bg == $FMXCONFIG['bgalt_color1'])
		$bg =& $FMXCONFIG['bgalt_color2'];
	else
		$bg =& $FMXCONFIG['bgalt_color1'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td><input type="text" size="16" maxlength="16" name="r"></td>
		<td><input type="text" size="32" maxlength="64" name="t"></td>
		<td>&nbsp;</td>
		<td><input type="submit" name="add" value="<?php echo(_MB_Add); ?>"></td>
	</tr>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
