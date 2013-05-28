<?php
/*
 * Chech Permission for link_url in message in box
 * copyright(c) bluemoon inc. GPL V3
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
class bmsurvey_permissionControll extends XCube_ActionFilter{
	private $groupLinkHandler;
	private $groupHandler;

	function postFilter(){
		global $xoopsUser,$xoopsModule;
		$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
		$module_handler = xoops_gethandler( 'module' );
		$module = $module_handler->getByDirname($mydirname);
		if(!isset($xoopsModule)) return null;
		if($xoopsModule->getVar('mid') != $module->mid()) return null;
		$this->groupLinkHandler = xoops_getmodulehandler('groups_users_link', 'user');
		$this->groupHandler = xoops_getmodulehandler('groups', 'user');
		$xoopsUserGroups = $this->getUserGroups($xoopsUser->uid());
		// Thru the permission check for admin.
		if(in_array('Admin', $xoopsUserGroups)) return null;
		$purl= parse_url($_SERVER['REQUEST_URI']);
		$prg = basename($purl['path']);
		if ($prg!="webform.php") {
			/*
			$redirect_flag = false;
			if (in_array('User',$xoopsUserGroups)) $redirect_flag = true;
			if (in_array('Anonymouse',$xoopsUserGroups)) $redirect_flag = true;
			if (in_array('Employee',$xoopsUserGroups)) $redirect_flag = true;
			if (in_array('General',$xoopsUserGroups)) $redirect_flag = true;
			if (in_array('Partner',$xoopsUserGroups) && count($xoopsUserGroups) == 1) $redirect_flag = true;
			if ($redirect_flag) header('Location:'.XOOPS_URL);*/
			return null;
		} else {
			// Check right URI for read contents
			parse_str($_SERVER['QUERY_STRING'], $urlQuery);
			//var_dump($urlQuery);die;
			$name = isset($urlQuery['name']) ? htmlspecialchars($urlQuery['name'],ENT_QUOTES,_CHARSET) : 0;
			// is the uid owner check
			if ($this->checkPermission($name)) return null;
			if ($name){
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('uid', $xoopsUser->uid()));
				$criteria->add(new Criteria('link_url', "%name={$name}%", 'like'));
				if(!$this->checkInbox($criteria, 'name')){
					// Check user group
					if(!$this->checkGroup($formUid, $xoopsUserGroups)){
						$msg = sprintf("No Permission. uid(%d)url=%s",$xoopsUser->uid(), $_SERVER["REQUEST_URI"]);
						redirect_header(XOOPS_URL,30,$msg);
					}
				}
			}
		}
	}
	private function checkGroup($targetUid, $xoopsUserGroups){
		global $xoopsUser;
		$ret = false;
		$groupFlg = false;
		$segmentFlg = false;
		$partnerFlg = false;
		$notAllowedGroups = array('Partner', 'User', 'Employee', 'General');
		if($targetUid != $xoopsUser->uid()){
			$targetUserGroups = $this->getUserGroups($targetUid);
			// Check user group
			foreach($targetUserGroups as $groupId => $groupType){
				if(!in_array($groupType, $notAllowedGroups)){
					if(strlen(trim($groupType)) > 0){
						if(in_array($groupType, $xoopsUserGroups)){
							$groupFlg = true;
						}
					}else{
						if(array_key_exists($groupId, $xoopsUserGroups)){
							$segmentFlg = true;
						}
					}
				}
				if($groupType == 'Partner'){
					$partnerFlg = true;
				}
			}
			if($partnerFlg && $segmentFlg){
				$ret = true;
			}elseif(!$partnerFlg && $groupFlg && $segmentFlg){
				$ret = true;
			}
		}else{
			$ret = true;
		}
		return $ret;
	}
	private function checkInbox($criteria, $colName){
		global $xoopsUser;
		$ret = false;
		$messageHandler = xoops_getmodulehandler('inbox', 'message');
		$msgArr = $messageHandler->getObjects($criteria);
		// Check inbox
		if(is_array($msgArr) && count($msgArr) > 0){
			foreach($msgArr as $msgObj){
				$linkURL = $msgObj->get('link_url');
				$linkURL = substr($linkURL, strpos($linkURL, '?') + 1);
				parse_str($linkURL, $jumpQuery);
				if(isset($jumpQuery[$colName])){
					$ret = true;
					break;
				}
			}
		}
		return $ret;
	}
	private function getUserGroups($uid){
		$ret = array();
		$groupArr = $this->groupLinkHandler->getObjects(new Criteria('uid', $uid));
		if(is_array($groupArr)){
			foreach($groupArr as $groupObj){
				$groupId = $groupObj->getVar('groupid');
				$ret[$groupId] = $this->getMasterGroupType($groupId);
			}
		}
		return $ret;
	}
	private function getMasterGroupType($groupId){
		$groupObj = $this->groupHandler->get($groupId);
		return is_object($groupObj)?$groupObj->getVar('group_type'):'';
	}
	private function checkPermission($name){
		global $xoopsUser;
		$ret = false;
		$formHandler = xoops_getmodulehandler('form');
		$msgArr = $formHandler->getByName($name);
		// Check inbox
		if(is_array($msgArr) && count($msgArr) > 0){
			$member_handler = xoops_gethandler('member');
			$groups =& $member_handler->getGroupsByUser($xoopsUser->getVar('uid'),true);
			$groupIds = array();
	  		foreach ($groups as $group){
	  			$groupIds[] = $group->getVar('groupid');
	  		}
			foreach($msgArr as $msgObj){
				// status is public
				/*if($msgObj['status']=="1"){
					$ret = true;
					break;
				}*/
				// form owener
				if($msgObj['owner']==$xoopsUser->uid()){
					$ret = true;
					break;
				}
				// form Groups
				if( in_array($msgObj['realm'], $groupIds) ){
					$ret = true;
					break;
				}
			}
		}
		return $ret;
	}

}
?>