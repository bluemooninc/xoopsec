
<?php

# $Id: admrespondent.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>
// <jflemer@acm.rpi.edu>

	$bg1 =& $FMXCONFIG['bgalt_color1'];
	$bg2 =& $FMXCONFIG['bgalt_color2'];

	$errstr = '';
	$u = '';
	$r = '';

	/* abort */
	if(isset($_POST['cancel'])) {
		unset($_POST['submit']);
		unset($_POST['delete']);
		include($fmxStatus->esp_where('respondents'));
		return;
	}

	/* delete user */
	if(isset($_POST['delete'])) {
		unset($_POST['submit']);
		$u = addslashes($_POST['u']);
		$r = addslashes($_POST['r']);
		/* check acl */
		if($xoopsUser->isAdmin() ||
			in_array($r, $editForm->accessLevel['pgroup']) ||
			$formTable->auth_no_access(_('to access this group'))) {
			$sql = "DELETE FROM ".TABLE_RESPONDENT." WHERE uid='$u' AND realm='$r'";
			if(!$xoopsDB->query($sql) || $xoopsDB->getAffectedRows() < 1) {
				/* unsucessfull -- abort */
				$errstr .= $formRender->mkerror(_MB_Cannot_delete_account .' ('.
					$xoopsDB->error() .')');
			}
		}
		if(empty($errstr)) {
			include($fmxStatus->esp_where('respondents'));
			return;
		}
	}

	/* submitted */
	if(isset($_POST['submit'])) {
		$u         = addslashes($_POST['u']);
		$r         = addslashes($_POST['r']);
		$password  = addslashes($_POST['password']);
		$fname     = addslashes($_POST['fname']);
		$lname     = addslashes($_POST['lname']);
		$email     = addslashes($_POST['email']);
		$disabled  = addslashes($_POST['disabled']);

		if(!empty($_POST['ex_year']) ||
				!empty($_POST['ex_month']) ||
				!empty($_POST['ex_day'])) {
			if(empty($_POST['ex_day'])) {
				$ex_day = 1;
			} else {
				$ex_day = intval($_POST['ex_day']);
			}
			if(empty($_POST['ex_month'])) {
				$ex_month = 1;
			} else {
				$ex_month = intval($_POST['ex_month']);
			}
			if(empty($_POST['ex_year'])) {
				$now = getdate(time());
				$ex_year = $now['year'];
			} else {
				$ex_year = intval($_POST['ex_year']);
				if($ex_year < 2000)
					$ex_year += 2000;
			}

			$expiration = sprintf("%04d%02d%02d%06d",
				$ex_year,$ex_month,$ex_day,0);
		} else {
			$expiration = "0";
			$ex_year    = '';
			$ex_month   = '';
			$ex_day     = '';
		}

		if($r == 'superuser' && $editForm->accessLevel['superuser'] != 'Y')
			$r = '';

		/* new user */
		$sql = "SELECT * FROM ".TABLE_RESPONDENT." WHERE uid='$u' AND realm='$r'";
		$result = $xoopsDB->query($sql);
		if($xoopsDB->getRowsNum($result) < 1) {
			if(empty($u) || empty($r) || empty($password)) {
				$errstr .= $formRender->mkerror(_MB_uid_are_required);
			} else {
				$sql = "INSERT INTO ".TABLE_RESPONDENT.
					" (uid,realm,password) VALUES ('$u','$r',PASSWORD('$password'))";
				if(!$xoopsDB->query($sql)) {
					$u = '';
					$r = '';
					$errstr .= $formRender->mkerror(_MB_Error_adding_account .' ('.
						$xoopsDB->error() .')');
				}
			}
		}
		

		/* change user data */
		if(!empty($u) && !empty($r)) {
			if(empty($disabled))
				$disabled = 'N';
			if (!empty($password))
				$password = "password=PASSWORD('$password'),";
			$sql = "UPDATE ".TABLE_RESPONDENT." SET
				$password
				fname='$fname',
				lname='$lname',
				email='$email',
				disabled='$disabled',
				changed=now(),
				expiration='$expiration'
			WHERE uid='$u' AND realm='$r'";
			if(!$xoopsDB->query($sql)) {
				/* unsucessfull -- abort */
				$errstr .= $formRender->mkerror(_MB_Cannot_change_account_data .' ('.
					$xoopsDB->error() .')');
			}
		}

		if(empty($errstr)) {
			include($fmxStatus->esp_where('respondents'));
			return;
		}
	} else if(isset($_GET['u']) && isset($_GET['r'])) {
		$u = addslashes($_GET['u']);
		$r = addslashes($_GET['r']);
	} else {
		$u = '';
		$r = '';
		$expiration = '';
		$disabled = 'N';
	}

	/* load ACL */
	if(!empty($u) && !empty($r)) {
		$sql = "SELECT * FROM ".TABLE_RESPONDENT." WHERE uid='$u' AND realm='$r'";
		$result = $xoopsDB->query($sql);
		if($arr = $xoopsDB->fetchArray($result)) {
			foreach(array(
				'uid', 'fname', 'lname', 'email',
				'realm', 'disabled', 'expiration') as $col)
				{ $$col = $arr[$col]; }
			$u =& $uid;
			$r =& $realm;
			if(intval($expiration) > 0) {
				$ex_year  = substr($expiration,0,4);
				$ex_month = substr($expiration,4,2);
				$ex_day   = substr($expiration,6,2);
			} else {
				$ex_year  = '';
				$ex_month = '';
				$ex_day   = '';
			}
		} else {
			$errstr .= $formRender->mkerror(_MB_Account_not_found .' ('.
				$xoopsDB->error() .')');
		}
	}

?>
<h2><?php echo(_MB_Respondent_Account_Administration); ?></h2>
<?php if(!empty($errstr)) echo("<p>$errstr</p>\n"); ?>
<input type="hidden" name="where" value="admrespondent">
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>">
	<tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_uid ."</th>\n");
	if(empty($u))
		$u = mktext('u', 16, 16, $GLOBALS);
	else
		$u = mkhidden('u', $GLOBALS) . "<tt>$u</tt>";
	echo("<td bgcolor=\"$bg1\">$u</td>\n");
?>
	</tr><tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_Password ."</th>\n");
	echo("<td bgcolor=\"$bg1\">". mkpass('password') ."</td>\n");
?>
	</tr><tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_Group ."</th>\n");
	if(empty($r)) {
		$r = '<select name="r"><option></option>';
		$groups = array();
		if($xoopsUser->isAdmin()) {
			$sql = "SELECT name FROM ".TABLE_REALM."";
			$result = $xoopsDB->query($sql);
			while( list($g) = $xoopsDB->fetchRow($result) ) {
				array_push($groups, $g);
			}
			
		} else {
			$groups =& $editForm->accessLevel['pgroup'];
		}
		foreach($groups as $g) {
			$r .= "<option value=\"$g\">$g</option>";
		}
		$r .= '</select>';
	} else {
		$r = mkhidden('r', $GLOBALS) . "<tt>$r</tt>";
	}
	echo("<td bgcolor=\"$bg1\"><tt>$r</tt></td>\n");
?>
	</tr><tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_First_Name ."</th>\n");
	echo("<td bgcolor=\"$bg1\">". mktext('fname', 16, 16, $GLOBALS) ."</td>\n");
?>
	</tr><tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_Last_Name ."</th>\n");
	echo("<td bgcolor=\"$bg1\">". mktext('lname', 24, 24, $GLOBALS) ."</td>\n");
?>
	</tr><tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_Email ."</th>\n");
	echo("<td bgcolor=\"$bg1\">". mktext('email', 24, 64, $GLOBALS) ."</td>\n");
?>
	</tr><tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_Expiration ."</th>\n");
	echo("<td bgcolor=\"$bg1\">".
		mktext('ex_year', 4, 0, $GLOBALS) .' '.
		mktext('ex_month', 2, 0, $GLOBALS) .' '.
		mktext('ex_day', 2, 0, $GLOBALS) .' ('.
			_MB_year .' '.
			_MB_month .' '.
			_MB_day. ")</td>\n");
?>
	</tr><tr>
<?php
	echo("<th bgcolor=\"$bg2\" align=\"right\">". _MB_Disabled ."</th>\n");
	echo("<td bgcolor=\"$bg1\">". mkselect('disabled',array('Y' => _MB_Yes, 'N' => _MB_No), $GLOBALS) ."</td>\n");
?>
	</tr><tr>
		<th colspan="2" bgcolor="<?php echo($bg2); ?>">
			<input type="submit" name="submit" value="<?php echo(_MB_Update); ?>">&nbsp;
			<input type="submit" name="cancel" value="<?php echo(_MB_Cancel); ?>">&nbsp;
			<input type="submit" name="delete" value="<?php echo(_MB_Delete); ?>">
		</th>
	</tr>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
