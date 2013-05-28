<?php

# $Id: passwd.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>
// <jflemer@acm.rpi.edu>

	/* ACL: everyone is allowed to change her own password */
?>
<h2><?php echo(_MB_Change_Password); ?></h2>
<?php
	if(isset($_POST['newpass1']) &&
		$_POST['newpass1'] == $_POST['newpass2'] &&
		!empty($_POST['newpass1'])) {
		if(auth_change_manager_passwd(
				$xoopsUser->uid(),
				addslashes($_POST['oldpass']),
				addslashes($_POST['newpass1']))) {
			echo(_MB_Your_password_has_been_successfully_changed."<br>\n");
			echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n");
			return;
		} else {
			echo($formRender->mkerror(_MB_Password_not_set));
		}
	} else if(isset($_POST['newpass1'])) {
		echo($formRender->mkerror(_MB_New_passwords_do_not_match_or_are_blank));
	}
?>
<input type="hidden" name="where" value="passwd">
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>">
<tr>
	<th align="right" bgcolor="<?php echo($FMXCONFIG['bgalt_color2']); ?>">
	<?php echo(_MB_uid); ?></th>
	<td bgcolor="<?php echo($FMXCONFIG['bgalt_color1']); ?>">
	<?php echo('<tt>'. $xoopsUser->uid() .'</tt>'); ?></td>
</tr><tr>
	<th align="right" bgcolor="<?php echo($FMXCONFIG['bgalt_color2']); ?>">
	<?php echo(_MB_Old_Password); ?></th>
	<td bgcolor="<?php echo($FMXCONFIG['bgalt_color1']); ?>">
	<?php echo(mkpass('oldpass')); ?></td>
</tr><tr>
	<th align="right" bgcolor="<?php echo($FMXCONFIG['bgalt_color2']); ?>">
	<?php echo(_MB_New_Password); ?></th>
	<td bgcolor="<?php echo($FMXCONFIG['bgalt_color1']); ?>">
	<?php echo(mkpass('newpass1')); ?></td>
</tr><tr>
	<th align="right" bgcolor="<?php echo($FMXCONFIG['bgalt_color2']); ?>">
	<?php echo(_MB_Confirm_New_Password); ?></th>
	<td bgcolor="<?php echo($FMXCONFIG['bgalt_color1']); ?>">
	<?php echo(mkpass('newpass2')); ?></td>
</tr><tr>
	<th colspan="2" bgcolor="<?php echo($FMXCONFIG['bgalt_color2']); ?>">
	<input type="submit" value="<?php echo(_MB_Change_Password); ?>">
	</th>
</tr>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>