<?php

# $Id: account_upload.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

// account_upload written by Matthew Gregg
// <greggmc@musc.edu>
// Upload Bulk Respondents from Tab Delimited text file.

/* {{{ proto array parse_file_tab(string group, array file)
	Parse uploaded tab delimited text file
	into an array.
	*/
function parse_file_tab($group, $file) {
	$tab_array = array();
	foreach($file as $row) {
		array_push($tab_array, explode("\t", rtrim($row)));
	}
	return $tab_array;

}

function parse_file_csv(){}

function parse_file_xml(){}

/* {{{ proto bool account_upload(array* exceptions, string upload_type,
	string account_type, array group_acl, file upload_file)
	exceptions array is populated with failed SQL inserts.
	Returns a true on success, else returns false.
	*/
function account_upload(&$exceptions, $upload_type, $account_type, $group_acl, $upload_file) {


	$error = 0;
	$bool_validate = array('Y', 'N');

	switch($upload_type) {
		case 'tab':
			$arr = parse_file_tab($group_acl, $upload_file);
			break;
		case 'csv':
			$arr = parse_file_csv();
			break;
		case 'xml':
			$arr = parse_file_xml();
			break;
		default:
			$error=1;
			break;
		}

	switch($account_type) {
		case 'respondents':
			array_push($exceptions, array("uid", "Password", "Group", "First Name",
				"Last Name", "Email", "Disabled", "Expir.", "Error"));

			foreach($arr as $row) {
				/* check for data in required fields */
				if($row[0]) {
					$uid = addslashes($row[0]);
				}
				else {
					$error=1;
					break;
				}
				if($row[1]) {
					$password = addslashes($row[1]);
				}
				else {
					$error=1;
					break;
				}
				if($row[2]) {
					$realm = addslashes($row[2]);
					if(isset($row[3]))
						$fname = addslashes($row[3]);
					else
						$fname = '';
					if(isset($row[4]))
						$lname = addslashes($row[4]);
					else
						$lname = '';
					if(isset($row[5]))
						$email = addslashes($row[5]);
					else
						$email = '';
					if(isset($row[6]))
						$expir = addslashes($row[6]);
					else
						$expir = '';
					if(isset($row[7]))
						$disabled = addslashes($row[7]);
					else
						$disabled = '';
					/* validate email address.  */
					if(!eregi( "^[a-z0-9]+([_\\.-][a-z0-9]+)*@" .
						"([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $email)) {
						array_push($exceptions, array("$uid", "$password",
							"$realm", "$fname", "$lname", "$email",
							"$expir", "$disabled",  "Invalid Email Addr."));
						continue;
					}

					if($expir) {
						$year = substr($expir, 0, 4);
						$month = substr($expir, 4, 2);
						$day = substr($expir, 6, 2);
						if(!checkdate($month, $day, $year)) {
							array_push($exceptions, array("$uid", "$password",
								"$realm", "$fname", "$lname", "$email",
								"$expir", "$disabled",  "Invalid Expir. Date"));
							continue;
						}
					}
					else
						$expir = "0";
;
					if(!in_array($disabled, $bool_validate))
						$disabled = 'N';
					/* Make sure user is authorized to upload this realm */
					if(!in_array($realm, $group_acl)) {
						array_push($exceptions, array("$uid", "$password",
							"$realm", "$fname", "$lname", "$email", "$expir",
							 "$disabled", "Invalid Group"));
						continue;
					}
				}
				else {
					$error=1;
					break;
				}
				$sql = "INSERT INTO ".TABLE_RESPONDENT." ";
				$sql .= "(uid, password, realm, fname, lname, ";
				$sql .= "email, expiration, disabled) ";
				$sql .= "VALUES ('$uid', PASSWORD('$password'), ";
				$sql .= "'$realm', '$fname', '$lname', '$email', ";
				$sql .= "'$expir', '$disabled')";
				if(!$xoopsDB->query($sql)) {
					/* insert failed -- stuff record into failed array */
					array_push($exceptions, array("$uid", "$password",
						"$realm", "$fname", "$lname", "$email", "$expir",
						 "$disabled", $xoopsDB->error()));
		}
			}
			break;
		case 'designers':
			array_push($exceptions, array("uid", "Password", "Group", "First Name",
						"Last Name", "Email", "PDesign", "PStatus", "PData",
						"PAll", "PGroup", "PUser", "Expir", "Disabled", "Error"));

			foreach($arr as $row) {
				/* check for data in required fields */
				if($row[0]) {
					$uid = addslashes($row[0]);
				}
				else {
					$error=1;
					break;
				}
				if($row[1]) {
					$password = addslashes($row[1]);
				}
				else {
					$error=1;
					break;
				}
				if($row[2]) {
					$realm = addslashes($row[2]);
					if(isset($row[3]))
						$fname = addslashes($row[3]);
					else
						$fname = '';
					if(isset($row[4]))
						$lname = addslashes($row[4]);
					else
						$lnam = '';
					if(isset($row[5]))
						$email = addslashes($row[5]);
					else
						$email = '';
					if(isset($row[6]))
						$pdesign = addslashes($row[6]);
					else
						$pdesign = '';
					if(isset($row[7]))
						$pstatus = addslashes($row[7]);
					else
						$pstatus = '';
					if(isset($row[8]))
						$pdata = addslashes($row[8]);
					else
						$pdata = '';
					if(isset($row[9]))
						$pall = addslashes($row[9]);
					else
						$pall = '';
					if(isset($row[10]))
						$pgroup = addslashes($row[10]);
					else
						$pgroup = '';
					if(isset($row[11]))
						$puser = addslashes($row[11]);
					else
						$puser = '';
					if(isset($row[12]))
						$expir = addslashes($row[12]);
					else
						$expir = '';
					if(isset($row[13]))
						$disabled = addslashes($row[13]);
					else
						$disabled = '';
					if(!eregi( "^[a-z0-9]+([_\\.-][a-z0-9]+)*@" .
						"([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $email)) {
						array_push($exceptions, array("$uid", "$password",
							"$realm", "$fname", "$lname", "$email", "$pdesign",
							"$pstatus", "$pdata", "$pall", "$pgroup", "$puser",
							"$expir", "$disabled",  "Invalid Email Addr."));
						continue;
					}
					if(!in_array($pdesign, $bool_validate))
						$pdesign = 'Y';
					if(!in_array($pstatus, $bool_validate))
						$pstatus = 'N';
					if(!in_array($pdata, $bool_validate))
						$pdata = 'N';
					if(!in_array($pall, $bool_validate))
						$pall = 'N';
					if(!in_array($pgroup, $bool_validate))
						$pgroup = 'N';
					if(!in_array($puser, $bool_validate))
						$puser = 'N';
					if($expir) {
						$year = substr($expir, 0, 4);
						$month = substr($expir, 4, 2);
						$day = substr($expir, 6, 2);
						if(!checkdate($month, $day, $year)) {
							array_push($exceptions, array("$uid", "$password",
								"$realm", "$fname", "$lname", "$email", "$pdesign",
								"$pstatus", "$pdata", "$pall", "$pgroup", "$puser",
								"$expir", "$disabled",  "Invalid Expir. Date"));
							continue;
						}
					}
					else
						$expir = "0";
					if(!in_array($disabled, $bool_validate))
						$disabled = 'N';
					/* Make sure user is authorized to upload this realm */
					if(!in_array($realm, $group_acl)) {
						array_push($exceptions, array("$uid", "$password",
							"$realm", "$fname", "$lname", "$email", "$pdesign",
							"$pstatus", "$pdata", "$pall", "$pgroup", "$puser",
							"$expir", "$disabled",  "Invalid Group"));
						continue;
					}
				}
				$sql = "INSERT INTO ".TABLE_DESIGNER." ";
				$sql .= "(uid, password, realm, fname, lname, ";
				$sql .= "email, pdesign, pstatus, pdata, pall, pgroup,";
				$sql .= "puser, expiration, disabled) ";
				$sql .= "VALUES ('$uid', PASSWORD('$password'), ";
				$sql .= "'$realm', '$fname', '$lname', '$email', ";
				$sql .= "'$pdesign', '$pstatus', '$pdata', '$pall', ";
				$sql .= "'$pgroup', '$puser', '$expir', '$disabled')";
				if(!$xoopsDB->query($sql)) {
					/* insert failed -- stuff record into failed array */
					array_push($exceptions, array("$uid", "$password",
						"$realm", "$fname", "$lname", "$email", "$pdesign",
						"$pstatus", "$pdata", "$pall", "$pgroup", "$puser",
						"$expir", "$disabled",  $xoopsDB->error()));
				}
			}
			break;

	}
	if(count($exceptions) > 1 or $error)
		return 0;
	else
		return 1;
}
?>