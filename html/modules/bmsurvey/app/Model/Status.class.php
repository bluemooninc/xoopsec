<?php
// # $Id: bmsurveyStatus.class.php,v 1.0 2011/12/06 12:44:03 yoshis Exp $
// 2005/08/10 12:14:03 yoshis started
include_once('ResponseSaver.class.php');

class bmsurveyStatus extends responseSaver{
	var $status;
	var $statusTitle;
	var $formManager;
	var $is_mod_admin;
	var $request_uri;
	var $submit_jumpuri;

	function bmsurveyStatus($status=1) {
		global $xoopsUser,$xoopsModuleConfig,$xoopsModule;

		$this->request_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$this->setSubmitJumpUri();
		$this->status = $status;
		$this->set_statusTitle($status);
		$this->formManager = false;
		$this->is_mod_admin = false;
		if (is_object($xoopsUser) ){
			if ( isset($xoopsModuleConfig['MANAGERS']) ){
			    //if (is_object($xoopsMSModule) && $xoopsMSModule->getVar('isactive')){
			        $groups = $xoopsUser->getGroups();
		    	    if (array_intersect($xoopsModuleConfig['MANAGERS'], $groups)){
						$this->formManager = true;
		    	    }
		    	//}
		    }
		    // Check if the user as admin right to the module
			if ( $xoopsUser->isAdmin($xoopsModule->mid()) ) {
			    $this->is_mod_admin = true;
			}
		}
	}
	function doWhere($where,$sid,$op=''){
		global $xoopsUser;
		switch ($where){
			case 'purge':
				$sids = array($sid);
				if($xoopsUser->isAdmin()) {
					$this->form_purge($sids);
				}else{
					$this->form_purge($sids, $xoopsUser->uid() );
				}
				break;
			case 'status':
				$this->changeStatus($sid,$op);
				break;
		}
	}

	function esp_where($where = 'manage'){
    	return(XOOPS_ROOT_PATH.'/modules/bmsurvey/include/where/'.$where.".php");
	}
	function ControlByFormAdmin(){
		global $xoopsUser,$xoopsModuleConfig;

		if ( $xoopsUser->isAdmin() || $this->is_mod_admin==TRUE ) return TRUE;
		if ( $this->formManager==TRUE && $xoopsModuleConfig['PSTATUS']==1 ) return TRUE;
		return FALSE;
	}
	// For Xoops
	//   $owner = Suevey owner xoops user id
	//   $realm = Permitted xoops group id at form edit
	//   $checkstatus = Check permission of status change by module admin
	function xoopsGroupStatus($owner,$realm,$checkstatus=0){
		global $xoopsUser,$xoopsModuleConfig;

		if ( $xoopsUser->isAdmin() || $owner == $xoopsUser->uid() ) return TRUE;
		$myGroups = $xoopsUser->getGroups();
		$GulHandler = xoops_getmodulehandler('groups_users_link','user');
		$realm = $GulHandler->isGroupsOfUser( $owner );
		$sameGroups = array_intersect($realm, $myGroups);
	    if ($sameGroups){
	    	//if (!$checkstatus || ( $checkstatus && $xoopsModuleConfig['PSTATUS'])){
				return TRUE;
	    	//}
	    }
		return FALSE;
	}
	function set_statusTitle($status){
		switch ($status){
			case 0: $this->statusTitle = _MB_Editing; break;
			case 1: $this->statusTitle = _MB_Active; break;
			case 2: $this->statusTitle = _MB_Ended; break;
			case 4: $this->statusTitle = _MB_Archived; break;
			case 8: $this->statusTitle = _MB_Testing; break;
		}
	}
	function op2statusNumber($op) {
		$statusNumber = 1;
		switch ($op){
			case 'c': break;
			case 't': $statusNumber = 8; break;	// Test
			case 'm': break;
			case 'a': $statusNumber = 1; break;	// Public
			case 'e': $statusNumber = 2; break;	// Stop
			case 'd': $statusNumber = 4; break;	// Delete
			case 'r': break;
			case 'v': break;
			case 'p': break;
		}
		return $statusNumber;
	}
	/*
	** Purge Form
	** proto void form_purge(array form_ids)
	** Purges all traces of form(s) from the database.
	** Returns void.
	*/
	function form_purge($sids,$uid=null) {
		global $xoopsDB;
		if(is_int($sids)) {
			$sidstr = '='.$sids;
		} else if (is_string($sids)) {
			$sids = split(" ",$sids);
		}
		if(is_array($sids)) {
			$sidstr = $this->array_to_insql($sids);
		}
		if ($uid){
			$sql = "SELECT COUNT(*) FROM ".TABLE_FORM." WHERE id ${sidstr} AND owner=$uid";
			if ( ! $xoopsDB->query($sql) ) {
				return false;
			}
		}

		// make a list of question IDs
		$sql = "SELECT id FROM ".TABLE_QUESTION." WHERE form_id ${sidstr}";
		$result = $xoopsDB->query($sql);
		$qids = array();
		while(list($qid) = $xoopsDB->fetchRow($result)) {
			array_push($qids, $qid);
		}

		$qidstr = $this->array_to_insql($qids);

		// work from the bottom up...
		// start with the form results
		$tables = array('response_bool','response_date','response_multiple','response_other','response_rank','response_single','response_text');
		foreach($tables as $table) {
			$sql = "DELETE FROM ${table} WHERE question_id ${qidstr}";
			$result = $xoopsDB->queryF($sql);
		}

		// then responses
		$sql = "DELETE FROM ".TABLE_RESPONSE." WHERE form_id ${sidstr}";
		$xoopsDB->queryF($sql);

		// then question choices
		$sql = "DELETE FROM ".TABLE_QUESTION_CHOICE." WHERE question_id ${qidstr}";
		$xoopsDB->queryF($sql);

		// then questions
		$sql = "DELETE FROM ".TABLE_QUESTION." WHERE form_id ${sidstr}";
		$xoopsDB->queryF($sql);

		// and finally the form(s)
		$sql = "DELETE FROM ".TABLE_FORM." WHERE id ${sidstr}";
		$xoopsDB->queryF($sql);

		return;
	}
	function ChangeStatus($sid,$op){
		global $xoopsDB,$xoopsUser;
		$bg = '';

		/* operation selected ... */
		$sql = "SELECT status,owner,realm,response_id FROM ".TABLE_FORM." WHERE id='${sid}'";
		$result = $xoopsDB->query($sql);
		if((list($old_status, $owner, $realm,$response_id) = $xoopsDB->fetchRow($result))) {
			$access = false;
			$err = false;
			$status = $old_status;
			// trying to perform some operation
			switch(strtolower($op)) {
				case 'c':	// Clear
					/* only _superuser_s can do this */
					if($xoopsUser->isAdmin()) {
						$access = true;
					} else {
						$access = false;
					}
					$status = 0;
					break;
				case 't':	// test
					/* only the owner or a group editor+design */
					$access = $this->xoopsGroupStatus($owner,$realm);
					$status = STATUS_TEST;	//$old_status | STATUS_TEST;
					if($old_status & ( STATUS_DELETED | STATUS_ACTIVE ) )	//STATUS_STOP |
						$err = true;
					break;
				case 'm':	// Edit
					/* only the owner or a group editor+design */
					$access = $this->xoopsGroupStatus($owner,$realm);
					$status = 0;	//$old_status & ~STATUS_TEST;
					if($old_status & ( STATUS_DELETED | STATUS_STOP | STATUS_ACTIVE ) )
						$err = true;
					else
						$this->response_delete_all($sid,$response_id);
					break;
				case 'a':	// activate
					/* only the owner+stauts or a group editor+status */
					$access = $this->xoopsGroupStatus($owner,$realm,1);
					$status = STATUS_ACTIVE;	//$old_status | STATUS_ACTIVE;
					if($old_status & ( STATUS_DELETED | STATUS_STOP ) )
						$err = true;
					else{
			            $sumitCount = new submitCount(XOOPS_ROOT_PATH.'/uploads');	// 2010.05.25 yoshis
    			        if ($sumitCount) $sumitCount->countClear($name);			// 2010.05.25 yoshis
						$this->response_delete_all($sid,$response_id);
					}
					break;
				case 'e':	// End
					/* only the owner+stauts or a group editor+status */
					$access = $this->xoopsGroupStatus($owner,$realm,1);
					$status = STATUS_STOP;	//$old_status | STATUS_STOP;
					//if($old_status & STATUS_DELETED ) $err = true;
					if($old_status & STATUS_TEST )
						$this->response_delete_all($sid,$response_id);
					break;
				case 'd':	// Delete
					/* only the owner+stauts or a group editor+status */
					$access = $this->xoopsGroupStatus($owner,$realm,1);
					$status = STATUS_DELETED;	//$old_status | STATUS_DELETED;
					break;
				case 'r':	// Re Activate
					/* only the owner+stauts or a group editor+status */
					$access = $this->xoopsGroupStatus($owner,$realm,1);
					$status = STATUS_ACTIVE;	//$old_status | STATUS_ACTIVE;
					if(!$old_status & ( STATUS_DONE ) )
						$err = true;
					break;
			}
			/* superuser overrides all */
			$access = $this->ControlByFormAdmin();
			if( $xoopsUser->isAdmin() || $owner=$xoopsUser->uid() ) $access = true;
			$sql = "UPDATE ".TABLE_FORM." SET status='${status}' WHERE id='${sid}'";
			if( $access ) {	//|| auth_no_access(_MB_to_access_this_form)
				if(!$err) {
					$xoopsDB->queryF($sql);
				} else {
					$GLOBALS['errmsg'] = _MB_Can_not_set_form_status;
					$GLOBALS['errmsg'] .= _MB_Status .': '. $old_status;
				}
			}else{
				$GLOBALS['errmsg'] = _MB_This_account_does_not_have_permission;
				$GLOBALS['errmsg'] .= _MB_Status .': '. $this->statusTitle;
			}
		}
	}

	/* {{{ proto void response_delete_all(int form_id)
	   Deletes all responses from form. */
	function response_delete_all($sid,$response_id=0) {
		global $xoopsDB;
		$sec = $this->form_get_sections($sid);
		$qids = array();
		foreach ($sec as $s)
			$qids = array_merge($qids, $s);
		$qids =$this->array_to_insql($qids);

		$addWhere = "";
		if ( $response_id>0 ) $addWhere = "response_id!=$response_id AND ";
		/* delete values */
		foreach (array('bool', 'single', 'multiple', 'rank', 'text', 'other', 'date') as $tbl) {
			$sql = "DELETE FROM ".TABLE_RESPONSE."_$tbl WHERE $addWhere question_id $qids";
			$res = $xoopsDB->queryF($sql);
		}
		/* ensure responses from testing status are also deleted */
		if ( $response_id>0 ) $addWhere = "id!=$response_id AND ";
		$sql = "DELETE FROM ".TABLE_RESPONSE." WHERE $addWhere form_id=${sid}";
		$xoopsDB->queryF($sql);
	}
	/* }}} */
	// redirect to thank you page for form ID 'sid'
	// exits PHP!
	function goto_thankyou($sid,$redirect) {
		global $xoopsDB;
	    $sql = "SELECT thanks_page,thank_head,thank_body FROM ".TABLE_FORM." WHERE id='${sid}'";
	    $result = $xoopsDB->query($sql);
	    list($thank_url,$thank_head,$thank_body) = $xoopsDB->fetchRow($result);

	    if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $thank_url)) {
	    	$redirect = $thank_url;
	    }
	    if(!empty($redirect)) {
	    	$redirect = htmlspecialchars_decode($redirect);
	        if(!headers_sent()) {
	            header("Location: $redirect");
	            exit;
	        }
			redirect_header($redirect.'/',3,"Thank You for completing this form.");
	        exit;
	    }
	    if(empty($thank_body) && empty($thank_head)) {
	        $thank_head = _MD_BMSURVEY_THANKS_ENTRY;
	    }
		return $thank_head."<p>".$thank_body;
	}

	function goto_saved($url) {
		redirect_header($url.'/',3,_MB_Your_progress_has_been_saved);
	    return;
	}
	/* {{{ proto boolean $fmxStatus->auth_get_option(string option)
	   Returns the value of the given option. Valid options include:
	   { resume, navigate } */
	function auth_get_option($opt) {
		return (isset($GLOBALS['auth_options'][$opt]) && $GLOBALS['auth_options'][$opt] == 'Y');
	}
	/*
	 * [XOOPS_URL] will change XOOPS_URL
	 * [REQUEST_URI (GET parameter name)] will change GET parameter value
	 * ex         > [XOOPS_URL]/modules/pico/?id=[REQUEST_URI pico_id]
	 * REQUEST URI> = http://yourdomain/123.html?pico_id=123
	 * return     > [XOOPS_URL]/modules/pico/?id=123
	 */
	function setSubmitJumpUri() {
		global $xoopsModuleConfig;

		$juri = preg_replace("/\[XOOPS_URL\]/i",XOOPS_URL,$xoopsModuleConfig['SUBMIT_JUMPURI']);

		$pattern = '/\[REQUEST_URI (.*?)\]/es';
		$ret = preg_match($pattern,$juri,$matches);
		if ($ret){
			$parse_url = parse_url($this->request_uri);
			if (isset($parse_url['query'])){
				$param = explode("&",$parse_url['query']);
				$pattern = '/'.$matches[1].'=(.*)/';
				foreach($param as $p){
					$ret = preg_match($pattern,$p,$pmatch);
					if ($ret) break;
				}
				if (isset($pmatch[1])){
					$pattern = '/\[REQUEST_URI ' . $matches[1] . '\]/';
					$args = $pmatch[1];
					$juri = preg_replace($pattern,$args,$juri);
					$this->submit_jumpuri = $juri;
					return $this->submit_jumpuri;
				}
			}
		}
		return NULL;
	}
	function submit_jumpuri(){
		return $this->submit_jumpuri;
	}
}
