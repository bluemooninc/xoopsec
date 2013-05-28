<?php

# $Id: export.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

if(!empty($_POST['sid']))
	$sid = intval($_POST['sid']);
elseif(!empty($_GET['sid']))
	$sid = intval($_GET['sid']);
else
	$sid = '';
$bg = '';

?>
<h2><?php echo(_MB_Export_Data); ?></h2>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
<table border="0" align="center" cellspacing="0" cellpadding="4" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" width="95%">
<?php

/* If the Form ID is not given, then build
 * a menu of available forms to chose from.
 */
if(!$sid) {
?>
	<tr bgcolor="#dddddd">
		<th align="left"><?php echo(_MB_ID); ?></th>
		<th align="left"><?php echo(_MB_Name); ?></th>
		<th align="left"><?php echo(_MB_Title); ?></th>
		<th align="left"><?php echo(_MB_Owner); ?></th>
		<th align="left"><?php echo(_MB_Group); ?></th>
		<th align="left"><?php echo(_MB_Status); ?></th>
		<th align="left" colspan="2"><?php echo(_MB_Format); ?></td>
	</tr>
<?php
	/* load names and titles of all forms available to
	 * _this_ user */
	$statusok = (STATUS_ACTIVE | STATUS_DONE & ~STATUS_DELETED);
	if($xoopsUser->isAdmin()) {
		$sql = "SELECT id,name,title,status,owner,realm FROM ".TABLE_FORM."
		WHERE (status & $statusok) ORDER BY id DESC";
	} else {
		$realms = array_to_insql(
			array_intersect(
				$editForm->accessLevel['pall'],
				$editForm->accessLevel['pdata']));
		$sql = "SELECT id,name,title,status,owner,realm
			FROM ".TABLE_FORM." WHERE (status & $statusok) AND (owner = '".
			$xoopsUser->uid() ."' || realm $realms) ORDER BY id DESC";
	}
	$result = $xoopsDB->query($sql);

	while(list($sid,$name,$title,$status,$owner,$realm) = $xoopsDB->fetchRow($result)) {
		$stat = _MB_Editing;

		if($status & STATUS_DELETED) {
			$stat = _MB_Archived;
			continue;
		} elseif($status & STATUS_DONE) {
			$stat = _MB_Ended;
		} elseif($status & STATUS_ACTIVE) {
			$stat = _MB_Active;
		} elseif($status & STATUS_TEST) {
			$stat = _MB_Testing;
		}

		if($bg != $FMXCONFIG['bgalt_color1'])
			$bg = $FMXCONFIG['bgalt_color1'];
		else
			$bg = $FMXCONFIG['bgalt_color2'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td><?php echo($sid); ?></td>
		<td><?php echo($name); ?></td>
		<td><?php echo($title); ?></td>
		<td><?php echo($owner); ?></td>
		<td><?php echo($realm); ?></td>
		<td><?php echo($stat); ?></td>
		<td><?php
			echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=export&type=csv&sid=$sid\">" . _MB_CSV . "</a>"); ?>
			(<?php
			echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=download&type=csv&sid=$sid\">" . _MB_download . '</a>'); ?>)
			<!--</td><td>-->
			&nbsp;
			<!-- <?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=export&type=dbf&sid=$sid\">" . _MB_DBF . "</a>"); ?>  -->
			<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=download&type=html&sid=$sid\">" . _MB_HTML . "</a>"); ?>
		</td>
	</tr>
<?php
	}
?>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
<?php
	return;
	}

	/* sid supplied ... continue */
	$sql = "SELECT name FROM ".TABLE_FORM." WHERE id = $sid";
	list($name) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	

	/* check ACLs for permissions */
	$srealm = $formTable->ownerGroup;
	if(isset($_GET['test'])) {
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
		echo("<p><b>". _MB_Testing_Form ."</b> (". _MB_SID ." = $sid)</p>\n");
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
		$file = $editForm->accessLevel['home'] . "/$name.dbf";
		if(extension_loaded('dbase')) {
			$ret = form_export_dbf($sid, $file);
		} else {
			$ret = 0;
			echo("<tr><td>" . $formRender->mkerror(_MB_The_PHP_dBase) . "</td></tr>");
		}
	} else {
		$csv_charset = $GLOBALS['FMXCONFIG']['csv_charset'];
		$file = $editForm->accessLevel['home'] . "/$name.csv";
		$ret = form_export_csv($sid, $file,$csv_charset);
	}

	echo("<tr><td>");
	if(isset($_GET['test'])) {
		echo("<p><b>". _MB_Testing_Form ."</b> (". _MB_SID ." = $sid)</p>\n");
	}
	if($ret) {
		echo(_MB_Form_exported_as . " <tt>$file</tt>");
	} else {
		echo($formRender->mkwarn(_MB_Error_exporting_form_as . " <tt>$file</tt>"));
	}
	echo("</td></tr></table>\n");
	echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n");

?>
