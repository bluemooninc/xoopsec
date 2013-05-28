<?php

# $Id: respondents.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>
// <jflemer@acm.rpi.edu>

	$sql = "SELECT uid, fname, lname, realm, disabled, expiration FROM ".TABLE_RESPONDENT;

	/* load only accounts available to _this_ user */
	if($editForm->accessLevel['superuser'] != 'Y') {
		$realms = array_to_insql(
			array_intersect(
				$editForm->accessLevel['pall'],
				$editForm->accessLevel['puser']));
		$sql .= " WHERE realm $realms";
	}

	$sql .= ' ORDER BY ';
	$base = $GLOBALS['FMXCONFIG']['manage'] .'?where=respondents';
	if(!isset($_GET['u'])) $_GET['u'] = '';
	if(!isset($_GET['g'])) $_GET['g'] = '';
	if(!isset($_GET['f'])) $_GET['f'] = '';
	if(!isset($_GET['l'])) $_GET['l'] = '';
	if(!isset($_GET['s'])) $_GET['s'] = '';

	if($_GET['u'] == 'd') {
		$us = 'uid DESC';
		$u = 'a';
	} else {
		$_GET['u'] = 'a';
		$us = 'uid ASC';
		$u = 'd';
	}
	if($_GET['g'] == 'd') {
		$gs = 'realm DESC';
		$g = 'a';
	} else {
		$_GET['g'] = 'a';
		$gs = 'realm ASC';
		$g = 'd';
	}
	if($_GET['f'] == 'd' || $_GET['l'] == 'd') {
		$ls = 'lname DESC';
		$l = 'a';
		$fs = 'fname DESC';
		$f = 'a';
	} else {
		$_GET['l'] = 'a';
		$ls = 'lname ASC';
		$l = 'd';
		$_GET['f'] = 'a';
		$fs = 'fname ASC';
		$f = 'd';
	}
	if($_GET['s'] == 'g') {
		$sql .= "$gs, $us";
		$u = "&s=u&g=" . $_GET['g'] ."&u=". $_GET['u'];
		$g = "&s=g&g=$g&u=". $_GET['u'];
		$f = "&s=f";
		$l = "&s=l";
	} elseif($_GET['s'] == 'f' || $_GET['s'] == 'l') {
		$sql .= "$fs, $ls";
		$f = "&s=f&f=$f";
		$l = "&s=l&l=$l";
		$u = "&s=u";
		$g = "&s=g";
	} else {
		$sql .= "$us, $gs";
		$u = "&s=u&g=" . $_GET['g'] ."&u=$u";
		$g = "&s=g&g=" . $_GET['g'] ."&u=". $_GET['u'];
		$f = "&s=f";
		$l = "&s=l";
	}
	$result = $xoopsDB->query($sql);
	
	$bg = $FMXCONFIG['bgalt_color2'];
?>
<h2><?php echo(_MB_Manage_Respondent_Accounts); ?></h2>
<p><?php echo(_MB_Click_on_a_uid_to_edit); ?></p>
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" width="95%">
	<tr bgcolor="<?php echo($bg); ?>">
		<th align="left"><a href="<?php echo($base . $u); ?>"><?php echo(_MB_uid); ?></a></th>
		<th align="left"><a href="<?php echo($base . $f); ?>"><?php echo(_MB_First_Name); ?></a></th>
		<th align="left"><a href="<?php echo($base . $l); ?>"><?php echo(_MB_Last_Name); ?></a></th>
		<th align="left"><a href="<?php echo($base . $g); ?>"><?php echo(_MB_Group); ?></a></th>
		<th align="left">&nbsp;</th>
	</tr>
<?php
	while(list($u, $fname, $lname, $r, $d, $e) = $xoopsDB->fetchRow($result)) {
		if($d == 'N')
			$d = '&nbsp;';
		else
			$d = '('. _MB_disabled .')';
		
		if (empty($fname)) $fname = '&nbsp;';
		if (empty($lname)) $lname = '&nbsp;';

		if ($bg == $FMXCONFIG['bgalt_color1'])
			$bg =& $FMXCONFIG['bgalt_color2'];
		else
			$bg =& $FMXCONFIG['bgalt_color1'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td>
			<a href="<?php echo($GLOBALS['FMXCONFIG']['manage'] ."?where=admrespondent&u=$u&r=$r"); ?>"><?php echo($u); ?></a>
		</td>
		<td><?php echo($fname); ?></td>
		<td><?php echo($lname); ?></td>
		<td><?php echo($r); ?></td>
		<td><?php echo($d); ?></td>
	</tr>
<?php
	}
	if ($bg == $FMXCONFIG['bgalt_color1'])
		$bg =& $FMXCONFIG['bgalt_color2'];
	else
		$bg =& $FMXCONFIG['bgalt_color1'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<th colspan="5" align="center">
			<table border="0" cellpadding="4">
				<tr>
					<th>
					<a href="<?php echo($GLOBALS['FMXCONFIG']['manage'] ."?where=admrespondent"); ?>">
						<?php echo(_MB_Add_a_new_Respondent); ?>
					</a>
					</th>
					<th>
					<a href="<?php echo($GLOBALS['FMXCONFIG']['manage'] ."?where=upload&account_type=respondents"); ?>">
						<?php echo(_MB_Bulk_Upload_Respondents); ?>
					</a>
					</th>
				</tr>
			</table>
		</th>
	</tr>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
