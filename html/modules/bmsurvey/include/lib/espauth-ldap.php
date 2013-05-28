<?php

# $Id: espauth-ldap.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

//  phpESP LDAP Authentication Library
//  By: Christopher Zorn <zorncj@musc.edu>
//      James Flemer <jflemer@alum.rpi.edu>

	$_ext = 'ldap.so';
	if (substr(PHP_OS, 0, 3) == 'WIN') {
		$_ext = 'php_ldap.dll';
	}
	if (!extension_loaded('ldap') && !ini_get('safe_mode')
		&& ini_get('enable_dl') && !@dl($_ext)) {
		echo "<b>FATAL: Unable to load the PHP ldap extension ($_ext). Aborting.</b>";
		exit;
	}
	unset($_ext);

/* {{{ proto bool form_auth(int form_id, string uid, string password)
   Returns true if the supplied uid/password is allowed
   access to the form. */
function form_auth($sid, $uid, $password) {
	// Default to _unauthorized_
	$auth = false;
	if (isset($GLOBALS['_GET']['auth_options']) || isset($GLOBALS['_POST']['auth_options'])) {
		$GLOBALS['errmsg'] = $formRender->mkerror(_MB_Error_processing_form_Security_violation);
		return(FALSE);
	}
   
	$GLOBALS['auth_options'] = array();

    // make sure database is opened
//    esp_init_db();

	// Formulate the query and check whether form requires authentication
	$sql = "SELECT realm FROM ".TABLE_FORM." WHERE id = '$sid' AND public = 'N'";

	// Execute the query and put results in $accres
	$accres = $xoopsDB->query( $sql );
	if(!$accres) {
		$GLOBALS['errmsg'] = $formRender->mkerror(_MB_Unable_to_execute_access);
		return(false);
	}

	// Get number of rows in $accres.
	if($xoopsDB->getRowsNum($accres) < 1) {
		// no matching rows ... no authorization required
		
		return(true);
	}

	list($realm) = $xoopsDB->fetchRow($accres);
	

	// A matching row was found - the form requires authentication.
	if (!empty($uid) && !empty($password)) {
		// Formulate the query check whether user is authorized
		$sql = "SELECT a.maxlogin, a.realm, a.resume, a.navigate
			FROM ".TABLE_ACCESS." a, ".TABLE_RESPONDENT." r
			WHERE a.form_id = '$sid' AND
				r.uid = '$uid' AND
				r.password = PASSWORD('$password') AND
				r.realm = a.realm AND
				r.disabled = 'N' AND
				(r.expiration = '0' OR r.expiration > NOW())";

		// Execute the query and put results in $usrres
		$usrres = $xoopsDB->query( $sql );
		if(!$usrres) {
			$GLOBALS['errmsg'] = $formRender->mkerror(_('Unable to execute query respondents.' ));
			return(false);
		}

		if ($xoopsDB->getRowsNum( $usrres ) > 0) {
			// A matching row was found - the user is authorized.
			$auth = true;
			list($maxlogin, $arealm, $aresume, $anavigate) = $xoopsDB->fetchRow($usrres);
			
			$GLOBALS['auth_options'] = array('resume' => $aresume, 'navigate' => $anavigate);
		}
	}

	// no matching authorization ... send a 401
	if ( ! $auth ) {
		header( "WWW-Authenticate: Basic realm=\"$realm\"" );
		header( 'HTTP/1.0 401 '. _MB_Unauthorized);
		$GLOBALS['errmsg'] = $formRender->mkerror(_MB_Incorrect_User_ID_or_Password);
		return(false);
	}

	if ( $maxlogin > 0 ) {
		// see if user is over the MAX # of responses
		$sql = "SELECT COUNT(*) < '$maxlogin' FROM ".TABLE_RESPONSE." WHERE form_id = '${sid}' AND complete = 'Y' AND uid = '$uid'";
		$numres = $xoopsDB->query( $sql );
		list($auth) = $xoopsDB->fetchRow($numres);
		
	}
	if( !$auth ) {
		header( "WWW-Authenticate: Basic realm=\"$realm\"" );
		header( 'HTTP/1.0 401 '. _MB_Unauthorized);
		$GLOBALS['errmsg'] = $formRender->mkerror(_MB_Your_account_has_been_disabled);
		return(false);
	}
	return(true);
}
/* }}} */

/* {{{ proto bool manage_auth(string uid, string password)
   Returns true if the supplied uid/password is allowed
   access to the management interface. This sets/clears
   access control related session variables. */
function manage_auth($uid, $password) {
	// see if session is expired, or has been logged out
	if(isset($editForm->accessLevel) &&
	   isset($editForm->accessLevel['expired'])) {
		if($editForm->accessLevel['expired']-- > 0) {
			$uid = ''; $password = '';
		}
	}

	// see if ACL is cached
	if (!empty($uid) &&
			!empty($password) &&
			isset($editForm->accessLevel) &&
			isset($editForm->accessLevel['uid']) &&
			isset($editForm->accessLevel['password']) &&
			$editForm->accessLevel['uid'] == $uid) {
		$sql = "SELECT PASSWORD('$password') = '". $editForm->accessLevel['password'] ."'";
		list($auth) = $xoopsDB->fetchRow($xoopsDB->query($sql));
		
		if($auth)
			return(true);
	}

	$auth_ldap_accept = $auth = false; // default to unauthorized
	$editForm->accessLevel = array();

	if (!empty($uid) && !empty($password)) {
		// Formulate the query check whether user is authorized
		// This only gives authorization for use of the form.
		// Information is entered into the database after authorization.

		// Add configuration for ldap server and other things

		$tmp_ldap_filter = $GLOBALS['FMXCONFIG']['ldap_filter'] .$uid;

		$ds = ldap_connect($GLOBALS['FMXCONFIG']['ldap_server'],
				$GLOBALS['FMXCONFIG']['ldap_port']);

		if ($ds) {
			$search_result = @ldap_search($ds, $GLOBALS['FMXCONFIG']['ldap_dn'], $tmp_ldap_filter);
			if (@ldap_count_entries($ds,$search_result)==1) {
				$user_info = ldap_get_entries($ds, $search_result);
				// Bind with uid and password
				$auth_bind = @ldap_bind($ds, $user_info[0]['dn'], $password);
				if ($auth_bind) {
					$auth_ldap_accept = true;
				}
			}
		}
		ldap_close($ds);

		$sql = "SELECT * FROM ".TABLE_DESIGNER." WHERE
			uid = '$uid' AND
			password = PASSWORD('$password') AND
			disabled = 'N' AND
			(expiration = '0' OR expiration > NOW())";

		// Execute the query and put results in $accres
		$accres = $xoopsDB->query( $sql );
		if(!$accres) {
			header( 'HTTP/1.0 503 '. _MB_Service_Unavailable);
			echo('<html><head><title>'. _MB_Service_Unavailable .
				'</title></head><body><h1>HTTP 503 '.
				_MB_Service_Unavailable .'</h1>'.
				$formRender->mkerror(_MB_Unable_to_load_ACL .' ('. $xoopsDB->error() .')') .
				'</body></html>');
			return(false);
		}

		// Get number of rows in $accres.
		if ($xoopsDB->getRowsNum( $accres ) > 0) {
			// A matching row was found - the user is authorized.
			$auth = true;
		} else if ($auth_ldap_accept) {
			$sql = "SELECT * FROM ".TABLE_DESIGNER." WHERE
					uid = '$uid' AND
					disabled = 'N' AND
					(expiration = '0' OR expiration > NOW())";

 		    // Execute the query and put results in $accres
		    $accres = $xoopsDB->query($sql);
			if ($xoopsDB->getRowsNum($accres) < 1) {
				// Create the group
				$user_sql = "INSERT INTO ".TABLE_REALM." (name, title) VALUES ('$uid','$uid')";
                $xoopsDB->query($user_sql);

				$user_sql = "INSERT INTO ".TABLE_DESIGNER."
							(uid,password,auth,realm,fname,
							pdesign,pstatus,pdata,pall,
							pgroup,puser,disabled)
							VALUES ('$uid',PASSWORD('$password'),
									'BASIC','$uid','$uid',
									'Y','Y','Y','Y','N','N','N')";
			} else {
				$user_sql = "UPDATE ".TABLE_DESIGNER." SET password = PASSWORD('$password') WHERE uid = '$uid'";
			}
			if ($xoopsDB->query($user_sql)) {
				$auth = true;
			}
		}
	}

	// no matching authorization ... send a 401
	if ( ! $auth ) {
		header( 'WWW-Authenticate: Basic realm="'. _MB_Management_Interface .'"' );
		header( 'HTTP/1.0 401 '. _MB_Unauthorized);
		echo("<html>\n<head><title>401 ". _MB_Unauthorized ."</title></head>\n".
			"<body><h1>401 ". _MB_Unauthorized ."</h1>\n".
			$formRender->mkerror(_MB_Incorrect_User_ID_or_Password) .
			"</body>\n</html>\n");
		exit;
		return(false);
	}

	// All tests passed ... create ACL array,
	// and stick it in the session
	$acl = array(
		'uid'  => $uid,
		'superuser' => 'N',
		'home' => '/tmp'
	);
	$fields = array('pdesign', 'pstatus', 'pdata', 'pall', 'pgroup', 'puser');
	foreach($fields as $f) {
		$$f = array();
	}
	while( $arr = $xoopsDB->fetchArray($accres) ) {
		if($arr['realm'] == 'superuser')
			$acl['superuser'] = 'Y';
		foreach($fields as $f) {
			if($arr[$f] == 'Y')
				array_push($$f, $arr['realm']);
		}
	}
	

	foreach($fields as $f) {
		$acl[$f] =& $$f;
	}

	$editForm->accessLevel =& $acl;

	// if one were to want login accounting (logs) this
	// would be the ideal place to do so...

	return(true);
}
/* }}} */

/* {{{ proto void manage_logout()
   Clears the current ACL, and will cause HTTP-Auth
   to be redisplayed. This is not fool proof; common browsers
   will continue to retry cached uid & password for
   HTTP-Auth. So if the browser is not closed after logout,
   it still may be possible to get back in w/o knowing a
   valid uid & password. */
function manage_logout() {
	// clear existing ACL, and set the expired flag
	//session_unset();
	$acl = array('expired' => 2);
	//session_register('acl');
	$editForm->accessLevel = array('expired' => 2);
}
/* }}} */

/* {{{ proto boolean auth_is_owner(int formId, string user)
   Returns true if user owns the form. */
function auth_is_owner($sid, $user) {
	$val = false;
	$sql = "SELECT s.owner = '$user' FROM ".TABLE_FORM." s WHERE s.id='$sid'";
	$result = $xoopsDB->query($sql);
	if(!(list($val) = $xoopsDB->fetchRow($result)))
		$val = false;
	
	return $val;
}
/* }}} */

/* {{{ proto string auth_get_form_realm(int formId)
   Returns the realm of the form. */
function auth_get_form_realm($sid) {
	$val = '';
	$sql = "SELECT s.realm FROM ".TABLE_FORM." s WHERE s.id='$sid'";
	$result = $xoopsDB->query($sql);
	list($val) = $xoopsDB->fetchRow($result);
	
	return $val;
}
/* }}} */

/* {{{ proto boolean $formTable->auth_no_access(string description)
   Handle a user trying to access an unauthorised area.
   Returns true if user should be allowed to continue.
   Returns false (or exits) if access should be denied. */
function auth_no_access($description) {
	echo($formRender->mkerror(_MB_This_account_does_not_have_permission . " " . $description));
	echo("\n<br>\n");
	echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n");
	return false;
}
/* }}} */

/* {{{ proto boolean auth_change_manager_passwd(string user, string old, string new)
   Change a managers password. If old password does not match
   or if there is an error, return false. Return true if
   password changed. */
function auth_change_manager_passwd($user,$old,$new) {
	$sql = "UPDATE ".TABLE_DESIGNER." SET password=PASSWORD('$new')
		WHERE uid='$user' AND password=PASSWORD('$old')";
	return($xoopsDB->query($sql) && $xoopsDB->getAffectedRows() > 0);
}
/* }}} */

/* {{{ proto boolean $fmxStatus->auth_get_option(string option)
   Returns the value of the given option. Valid options include:
   { resume, navigate } */
function auth_get_option($opt) {
	return (isset($GLOBALS['auth_options'][$opt]) && $GLOBALS['auth_options'][$opt] == 'Y');
}
/* }}} */

/* {{{ proto int auth_get_rid (int form_id, string uid, int response_id)
   Returns the RID to use for this user. */
function auth_get_rid($sid, $uid, $rid = 0) {
	$rid = intval($rid);
	if (isset($rid) && $rid != 0) {
		// check for valid rid
		$sql = "SELECT (r.uid = '$uid' && r.complete = 'N') AS valid
			FROM ".TABLE_RESPONSE." r
			WHERE r.id = '$rid' AND
			r.form_id = '$sid'";
		$res = $xoopsDB->query($sql);
		$valid = FALSE;
		if ($res && $xoopsDB->getRowsNum($res) > 0)
			$valid = TRUE;
		if ($res)
			
		return ($valid) ? $rid : '';
	} elseif ($fmxStatus->auth_get_option('resume')) {
		// find latest in progress rid
		$sql = "SELECT r.id FROM ".TABLE_RESPONSE." r
			WHERE r.form_id = '$sid' AND
			r.complete = 'N' AND
			r.uid = '$uid'
			ORDER BY submitted DESC
			LIMIT 1";
		$res = $xoopsDB->query($sql);
		if ($res && $xoopsDB->getRowsNum($res) > 0)
			list($rid) = $xoopsDB->fetchRow($res);
		if ($res)
			
		return ($rid != 0) ? $rid : '';
	} else {
		return '';
	}
}
/* }}} */

?>
