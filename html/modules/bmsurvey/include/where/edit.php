
<?php

# $Id: edit.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

    $bg = '';

	/* load names and titles of all forms available to
	 * _this_ user */
	if($xoopsUser->isAdmin()) {
		$sql = 'SELECT s.id, s.name, s.title, s.owner, s.realm
		FROM '.TABLE_FORM.' s ORDER BY s.id DESC';
		//FROM '.TABLE_FORM.' s WHERE s.status = 0 ORDER BY s.id DESC';
	} else {
		$realms = $xoopsModuleConfig['PSTATUS'] ? array_to_insql(
			array_intersect(
				$editForm->accessLevel['pall'],
				array_merge(
					$editForm->accessLevel['pall'],
					$editForm->accessLevel['pdesign']))) : NULL;
		$sql = "SELECT s.id, s.name, s.title, s.owner, s.realm FROM "
			.TABLE_FORM." s WHERE (s.owner ='".$xoopsUser->uid()."'";
		$sql .= is_null($realms) ? "" : " || s.realm $realms";
		$sql .= ") ORDER BY s.id DESC";
	}
	$result = $xoopsDB->query($sql);

?>
<h2><?php echo(_MB_Edit_a_Form); ?></h2>
<?php echo(_MB_Pick_Form_to_Edit); ?>
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" width="95%">
	<tr bgcolor="#dddddd">
		<th align="left"><?php echo(_MB_ID); ?></th>
		<th align="left"><?php echo(_MB_Name); ?></th>
		<th align="left"><?php echo(_MB_Title); ?></th>
		<th align="left"><?php echo(_MB_Owner); ?></th>
		<th align="left"><?php echo(_MB_Group); ?></th>
	</tr>
<?php
	while(list($sid,$name,$title,$owner,$realm) = $xoopsDB->fetchRow($result)) {
		if($bg != $FMXCONFIG['bgalt_color1'])
			$bg = $FMXCONFIG['bgalt_color1'];
		else
			$bg = $FMXCONFIG['bgalt_color2'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td><?php echo($sid); ?></td>
		<td>
			<a href="<?php echo($GLOBALS['FMXCONFIG']['manage'] ."?where=tab&newid=${sid}"); ?>"><?php echo($name); ?></a>
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