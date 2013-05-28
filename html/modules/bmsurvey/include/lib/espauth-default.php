<?php
// $Id: espauth-default.php,v0.82 2007/12/04 12:43:03 yoshis Exp $
//  ------------------------------------------------------------------------ //
//                      bmsurvey - Bluemoon Multi-Form                     //
//                   Copyright (c) 2005 - 2007 Bluemoon inc.                 //
//                       <http://www.bluemooninc.biz/>                       //
//              Original source by : phpESP V1.6.1 James Flemer              //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
//  phpESP Default Authentication Library
//  By: Romans Jasins <roma@latnet.lv>
//      James Flemer <jflemer@alum.rpi.edu>

/* {{{ proto bool form_auth(int form_id, string uid, string password)
   Returns true if the supplied uid/password is allowed
   access to the form. */
function form_auth($sid, $uid, $password) {
	// Default to _unauthorized_
	$auth = false;

	if (isset($GLOBALS['_GET']['auth_options']) || isset($GLOBALS['_POST']['auth_options'])) {
		$GLOBALS['errmsg'] = $formRender->mkerror(_MB_Error_processing_form_Security_violation);
		return(false);
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
	//
	// Till for XOOPS by Yoshi.Sakai 2007/12/03
	//
	global $xoopsUser;
	$uid = $xoopsUser->uid();
	$groups = $xoopsUser->getGroups();
	//if (!empty($uid) && !empty($password)) {
	if (!empty($uid)) {
		// Formulate the query check whether user is authorized
		/* $sql = "SELECT a.maxlogin, a.realm, a.resume, a.navigate
			FROM ".TABLE_ACCESS." a, ".TABLE_RESPONDENT." r
			WHERE a.form_id = '$sid' AND
				r.uid = '$uid' AND
				r.password = PASSWORD('$password') AND
				r.realm = a.realm AND
				r.disabled = 'N' AND
				(r.expiration = '0' OR r.expiration > NOW())";
		*/
		$sql = "SELECT a.maxlogin, a.realm, a.resume, a.navigate
			FROM ".TABLE_ACCESS." a WHERE a.form_id = '$sid'";
		// Execute the query and put results in $usrres
		$usrres = $xoopsDB->query( $sql );
		if(!$usrres) {
			$GLOBALS['errmsg'] = $formRender->mkerror(_('Unable to execute query respondents.' ));
			return(false);
		}

		if ($xoopsDB->getRowsNum( $usrres ) > 0) {
			// A matching row was found - the user is authorized.
			/*
			$auth = true;
			list($maxlogin, $arealm, $aresume, $anavigate) = $xoopsDB->fetchRow($usrres);
			
			$GLOBALS['auth_options'] = array('resume' => $aresume, 'navigate' => $anavigate);
			*/
			while(list($maxlogin, $arealm, $aresume, $anavigate) = $xoopsDB->fetchRow($usrres)){
				if (in_array($arealm,$groups)){
					$auth = true;
					$GLOBALS['auth_options'] = array('resume' => $aresume, 'navigate' => $anavigate);
					break;
				}
			}
			
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
		list($auth) = $xoopsDB->fetchRow($xoopsDB->query( $sql ));
		
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

	$auth = false; // default to unauthorized
	$editForm->accessLevel = array();

	if (!empty($uid) && !empty($password)) {
		// Formulate the query check whether user is authorized
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
	global $xoopsDB;

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
	echo($formRender->mkerror(_MB_This_account_does_not_have_permission .' '. $description .'.'));
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


/* {{{ proto int auth_get_rid (int form_id, string uid, int response_id)
   Returns the RID to use for this user. */
function auth_get_rid($sid, $uid, $rid = 0) {
	$rid = intval($rid);
	if (isset($rid) && $rid != 0) {
		// check for valid rid
		$sql = "SELECT (r.uid = '$uid' && r.complete = 'N') AS valid FROM ".TABLE_RESPONSE." r WHERE r.id = '$rid' AND r.form_id = '$sid'";
		$res = $xoopsDB->query($sql);
		$valid = false;
		if ($res && $xoopsDB->getRowsNum($res) > 0 )
			$valid = true;
		if ($res)
			
		return ($valid) ? $rid : '';
	} elseif ($fmxStatus->auth_get_option('resume')) {
		// find latest in progress rid
		$sql = "SELECT r.id FROM ".TABLE_RESPONSE." r WHERE r.form_id = '$sid' AND r.complete = 'N' AND r.uid = '$uid' ORDER BY submitted DESC LIMIT 1";
		$res = $xoopsDB->query($sql);
		if ($res && $xoopsDB->getRowsNum($res) > 0)
			$rid = $xoopsDB->fetchRow($res);
		if ($res)
			
		return ($rid != 0) ? $rid : '';
	} else {
		return '';
	}
}
/* }}} */

?>
