<?php
// $Id: FormTable.class.php,v0.83 2008/01/08 18:38:03 yoshis Exp $
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
class FormTable {
	protected $myDirName = "bmsurvey";
	protected $publicShowToList = 0;
	protected $lastFormId =0;
	protected $total = 0;
	protected $start = 0;
	protected $perpage = 10;
	protected $sortname = '';
	protected $sortorder = '';
	protected $sortorderStr = array('ASC'=>'DESC','DESC'=>'ASC');
	protected $status = '1';
	protected $stat_flag;
	protected $stat_desc;
	protected $userGroups;
	protected $ownerGroup;
	protected $ownerUid;
	protected $is_admin;
	protected $copybyGroup=FALSE;
	protected $editbyGroup=FALSE;
	protected $viewbyGroup=FALSE;
	protected $formInfo;
	protected $message;
	protected $root;
	protected static $groups;
	/**
	 * constructor
	 */
	function FormTable($sid=0, $formName=''){
		global $xoopsUser,$xoopsModule,$xoopsModuleConfig;

		$this->root = XCube_Root::getSingleton();
		$this->publicShowToList = $xoopsModuleConfig['SHOW_PUBLIC_TO_OTHERGROUP'];

		$this->is_admin =FALSE;
		$this->userGroups = array();
		if ($xoopsUser){
			$this->userGroups = $xoopsUser->getGroups();
			if ( is_object($xoopsModule)  ) {
				$this->is_admin = $xoopsUser->isAdmin( $xoopsModule->mid() );
			}
		}
		if ($sid){
			$this->formInfo = $this->get_formInfoById($sid);
			$this->ownerGroup = $this->formInfo['realm'];
		}elseif ($formName){
			$this->formInfo = $this->get_formInfoByName($formName);
		}
	}
	public function &getFormInfo($param=NULL){
		if ($param)
			return $this->formInfo[$param];
		else
			return $this->formInfo;
	}
	function editbyGroup(){
		return $this->editbyGroup;
	}
	function copybyGroup($uid){
		global $xoopsUser,$xoopsModuleConfig;

		$this->copybyGroup = FALSE;
		if ($xoopsUser->isadmin()){
			$this->copybyGroup = TRUE;
		}else{
			$grobal_group = explode("|",$xoopsModuleConfig['GROBAL_GROUP']);
			$User = new xoopsUser($uid);
			$formOwnerGroups = $User->getGroups();
			$yourGroups = $xoopsUser->getGroups();
			$this->copybyGroup = FALSE;
			foreach($yourGroups as $you){
				/* except grobal group */
				if (!in_array($you,$grobal_group)){
					if (in_array($you, $formOwnerGroups)){
						$this->copybyGroup = TRUE;
						break;
					}
				}
			}
		}
		return $this->copybyGroup;
	}
	function viewbyGroup(){
		return $this->viewbyGroup;
	}
	function uid(){
		return $this->formInfo['owner'];
	}
	function isOwnerGroup(){
		global $xoopsUser;
		$groups = $xoopsUser->getGroups();
		return in_array($this->ownerGroup,$groups);
	}
	function get_formInfo($sql){
		global $xoopsDB;
		$result = $xoopsDB->query($sql);
		$row = $xoopsDB->fetchArray($result);
		$row['uid'] = $row['owner'];
		if (isset($row['last_update'])){
			$row['last_update_s'] = formatTimestamp($row['last_update'], 's');
			$row['last_update_m'] = formatTimestamp($row['last_update'], 'm');
			$row['last_update_l'] = formatTimestamp($row['last_update'], 'l');
		}
		if (isset($row['published'])){
			$row['published_s'] = formatTimestamp($row['published'], 's');
			$row['published_m'] = formatTimestamp($row['published'], 'm');
			$row['published_l'] = formatTimestamp($row['published'], 'l');
		}
		if (isset($row['expired'])){
			$row['expired_s'] = formatTimestamp($row['expired'], 's');
			$row['expired_m'] = formatTimestamp($row['expired'], 'm');
			$row['expired_l'] = formatTimestamp($row['expired'], 'l');
		}
		if(isset($row['status'])) $this->get_status($row['status']);
		$row['status'] = $this->stat_flag;
		$row['status_desc'] = $this->stat_desc;
		if(isset($row['realm']) && isset($row['owner'])){
			$this->ownerGroup = $row['realm'];
			$this->ownerUid = $row['owner'];
			$this->set_manageFlag($row['owner'],$row['realm']);
		}
		$row['editbyGroup'] = $this->editbyGroup;
		$row['viewbyGroup'] = $this->viewbyGroup;
		return $row;
	}
	function get_formInfoById($sid){
		global $xoopsDB;
		$sql = "SELECT *, UNIX_TIMESTAMP(changed) AS last_update FROM ".TABLE_FORM." WHERE id='".$sid."'";
		$row = $this->get_formInfo($sql);
		// Extra info for edit
		$userHander = new XoopsUserHandler($xoopsDB);
		$row['uname'] = ($tUser = $userHander->get($row['owner'])) ? $tUser->uname() : '';
		$row['resp'] = $this->get_responseCount($row['id']);
		return $row;
	}
	function get_formInfoByName($formName){
		$sql = "SELECT *, UNIX_TIMESTAMP(changed) AS last_update FROM ".TABLE_FORM." WHERE name='".$formName."'";
		$row = $this->get_formInfo($sql);
		return $row;
	}
	function set_response_id($rid,$sid){
		global $xoopsDB;
		$sql = "UPDATE ".TABLE_FORM." SET response_id = '${rid}' WHERE id='${sid}'";
		$result = $xoopsDB->query($sql);
		if ($result) $this->message = _MD_DEFAULTRESULTDONE;
	}
	function get_responseCount($sid){
		global $xoopsDB;
		$sql = "SELECT count(*) FROM ".TABLE_RESPONSE." WHERE complete='Y' AND form_id='".$sid."'";
		$result = $xoopsDB->query($sql);
		list($cnt) = $xoopsDB->fetchrow($result);
		return $cnt;
	}
	function set_manageFlag($owner,$ownerGp){
		global $xoopsUser;
		$realm = $xoopsUser->getGroups();

		$this->editbyGroup = FALSE;
		$this->viewbyGroup = FALSE;
		if ( $this->is_admin ){
			$this->editbyGroup = TRUE;
			$this->viewbyGroup = TRUE;
		}
		if($xoopsUser){
			if ( $owner == $xoopsUser->uid()){
				$this->editbyGroup = TRUE;
				$this->viewbyGroup = TRUE;
			}elseif ($this->_checkMyGroup($realm)){
				$this->editbyGroup = TRUE;
				$this->viewbyGroup = TRUE;
			}
		}
	}
	/* {{{ proto boolean auth_is_owner(int formId, string user)
	   Returns true if user owns the form. */
	function auth_is_owner($sid, $user) {
		global $xoopsDB;
		$val = FALSE;
		$sql = "SELECT s.owner = '$user' FROM ".TABLE_FORM." s WHERE s.id='$sid'";
		$result = $xoopsDB->query($sql);
		if(!(list($val) = $xoopsDB->fetchRow($result)))
			$val = FALSE;

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

	/* {{{ proto boolean auth_no_access(string description)
	   Handle a user trying to access an unauthorised area.
	   Returns true if user should be allowed to continue.
	   Returns false (or exits) if access should be denied. */
	function auth_no_access($description) {
		//echo($formRender->mkerror(_MB_This_account_does_not_have_permission .' '. $description .'.'));
		echo("permission error\n<br>\n");
		echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n");
		return FALSE;
	}
	/* }}} */
	function log($str){
		//if( $FMXCONFIG['log_output'] == 1 ){
			$log = './log/form.log';
			$fp = fopen($log, 'a');
			fwrite($fp, $str."\n");
			fclose($fp);
		//}
	}

	function getDateFromHttpParams(){

		$param = isset($_POST['param']) ? ($_POST['param']) : 0;
		if($param == 0){
			$param = isset($_GET['param']) ? ($_GET['param']) : 0;
		}
		/* It doesn't work with php4isapi.dll.
		if($param == 0){
			$tmp = explode('/', $_SERVER['REQUEST_URI']);
			$param = ($tmp[count($tmp)-1]);
		}*/
		$param = trim($param);

		if($param == 0){
			return FALSE;
		}
		$result = array();
		$result['params'] = $param;
		//print("$param");
		if(preg_match("/^([0-9]+)-([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})-([a-zA-Z0-9]*)/", $param, $m)){
			$result['uid'] = FormTable::checkUid($m[1]);
			$result['year'] = FormTable::checkYear($m[2]);
			$result['month'] = FormTable::checkMonth($m[3]);
			$result['date'] = FormTable::checkDate($m[2], $m[3], $m[4]);
			$result['hours']=$m[5];
			$result['minutes']=$m[6];
			$result['seconds']=$m[7];
			$result['command'] = trim($m[8]);		// enc type for MT user
		}else if(preg_match("/^([0-9]+)-([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", $param, $m)){
			$result['uid'] = FormTable::checkUid($m[1]);
			$result['year'] = FormTable::checkYear($m[2]);
			$result['month'] = FormTable::checkMonth($m[3]);
			$result['date'] = FormTable::checkDate($m[2], $m[3], $m[4]);
			//print("$m[5]:$m[6]:$m[7]");
			$result['hours']=$m[5];
			$result['minutes']=$m[6];
			$result['seconds']=$m[7];
		}else if(preg_match("/^([0-9]+)-([0-9]{4})([0-9]{2})/", $param, $m)){
			$result['uid'] = FormTable::checkUid($m[1]);
			$result['year'] = FormTable::checkYear($m[2]);
			$result['month'] = FormTable::checkMonth($m[3]);
		}else if(preg_match("/^([0-9]+)/", $param, $m)){
			$result['uid'] = FormTable::checkUid($m[1]);
		}else{

			redirect_header(XOOPS_URL.'/',1,_MD_POPNUPBLOG_INVALID_DATE.'(INVALID PARAM)');
			exit();
		}
		return $result;
	}

	function getApplicationNum(){
		global $xoopsDB;
		if(!$dbResult = $xoopsDB->query('select count(*) num from '.POPNUPBLOG_TABLE_APPL)){
			return 0;
		}
		if(list($num) = $xoopsDB->fetchRow($dbResult)){
			return $num;
		}
		return 0;
	}

	function weformUpdatesPing($rss, $url, $form_name = NULL, $title = NULL, $excerpt = NULL){
		$ping = new bmsurveyPing2($rss, $url, $form_name, $title, $excerpt);
		$ping->send();
		/* debug log
		ob_start();
		print_r($ping);
		$log = ob_get_contents();
		ob_end_clean();
		FormTable::log($log);
		*/
	}

	function newApplication($in_title, $in_permission){
		global $xoopsUser, $xoopsDB;
		$title = "";
		$permission = -1;
		if(!empty($in_title)){
			$title = FormTable::convert2sqlString($in_title);
		}
		if( ($in_permission == 0) || ($in_permission == 1) || ($in_permission == 2) || ($in_permission == 3)){
			$permission = intval($in_permission);
		}

		if($permission < 0){
			return _MD_POPNUPBLOG_ERR_INVALID_PERMISSION;
		}
		if(!$result = $xoopsDB->query('select uid from '.POPNUPBLOG_TABLE_APPL.' where uid = '.$xoopsUser->uid())){
			return "select error";
		}
		if(list($tmpUid) = $xoopsDB->fetchRow($result)){
			return _MD_POPNUPBLOG_ERR_APPLICATION_ALREADY_APPLIED;
		}
		if(!$result = $xoopsDB->query('select uid from '.POPNUPBLOG_TABLE_INFO.' where uid = '.$xoopsUser->uid())){
			return "select error";
		}
		if(list($tmpUid) = $xoopsDB->fetchRow($result)){
			return _MD_POPNUPBLOG_ERR_ALREADY_WRITABLE;
		}
		$sql = sprintf("insert into %s (uid, title, permission, create_date) values(%u, '%s', %u, CURRENT_TIMESTAMP())",
			POPNUPBLOG_TABLE_APPL, $xoopsUser->uid(), $title, $permission);
		if(!$result = $xoopsDB->query($sql)){
			return "insert error";
		}

		return "";
	}

	function getXoopsModuleConfig($key){
		global $xoopsDB;
		$mid = -1;

		$sql = "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname = '{$this->myDirName}'";
		if (!$result = $xoopsDB->query($sql)) {
			return FALSE;
		}
		$numrows = $xoopsDB->getRowsNum($result);
		if ($numrows == 1) {
			list($l_mid) = $xoopsDB->fetchRow($result);
			$mid = $l_mid;
		}else{
			return FALSE;
		}
		$sql = "select conf_value from ".$xoopsDB->prefix('config')." where conf_modid = ".$mid." and conf_name = '".trim($key)."'";
		if (!$result = $xoopsDB->query($sql)) {
			return FALSE;
		}
		$numrows = $xoopsDB->getRowsNum($result);
		if ($numrows == 1) {
			list($value) = $xoopsDB->fetchRow($result);
			//return intval($value);
			return $value;
		}else{
			return FALSE;
		}
	}
	//
	function get_status($status){
		if($status & STATUS_DELETED) {
			$this->stat_flag = STATUS_DELETED;
			//$this->stat_desc = _MB_Archived;
		} elseif($status & STATUS_STOP) {
			$this->stat_flag = STATUS_STOP;
			//$this->stat_desc = _MB_Ended;
		} elseif($status & STATUS_ACTIVE) {
			$this->stat_flag = STATUS_ACTIVE;
			//$this->stat_desc = _MB_Active;
		} elseif($status & STATUS_TEST) {
			$this->stat_flag = STATUS_TEST;
			//$this->stat_desc = _MB_Testing;
		} else {
			$this->stat_flag = 0;
			//$this->stat_desc = _MB_Editing;
		}
		return $this->stat_flag;
	}
	//Page Navi
	function setPageStart($start){
		$this->start = $start;
	}
	function sortNavi(){
		$endNumber = $this->perpage < $this->total ? $this->perpage : $this->total;
		return array(
			'sortname'=>$this->sortname,
			'sortorder'=>$this->sortorder,
			'status'=>$this->status,
			'start'=>$this->start + 1,
			'end'=>$endNumber,
			'perpage'=>$this->perpage,
			'total'=>$this->total
		);
	}
	function pageNavi($offset){
		include XOOPS_ROOT_PATH . '/class/pagenav.php';
		$optparam = $this->sortname ? 'sortby='.$this->sortname : "";
		$optparam .= $this->sortorder ? '&order='.$this->sortorder : "";
		$nav = new XoopsPageNav($this->total,$this->perpage,$this->start,"start", $optparam );
		return $nav->renderNav($offset);
	}
	private function _checkMyGroup(&$realm){
		global $xoopsUser;
		$myGroups = $xoopsUser->getGroups();
		$sameGroups = array_intersect($realm, $myGroups);
		if ($sameGroups) return TRUE;
	}
	private function _isGroupsOfUser( &$gulHandler, $uid ){
		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('uid', $uid));
		$objs = $gulHandler->getObjects($criteria);
		return (count($objs) > 0 && is_object($objs[0]));
	}
	/**
	 * get form list for index.php, manage.php
	 *
	 * @param null $formId
	 * @param bool $limit
	 * @param string $sortby
	 * @param string $order
	 * @param int $status
	 * @param int $uid
	 * @return array
	 */
	function get_form_list($formId = NULL, $limit = TRUE, $sortby = 'changed', $order = 'DESC', $status = 1, $uid = 0){
		global $xoopsUser, $xoopsDB;
		$this->perpage =  $this->root->mContext->mModuleConfig['BLOCKLIST'];
		$this->sortname = in_array($sortby,array('changed','owner','title','name','status')) ? $sortby : "changed" ;
		$this->sortorder = preg_match("/DESC|ASC/i",$order) ? $order : "ASC";
		$this->status = $status;

		/** @protected XoopsUser $xoopsUser */
		$uid = ($xoopsUser) ? $xoopsUser->uid() : 0;
		$userIds = $this->_getSameGroupUserIds($xoopsUser);

		$criteria = new CriteriaCompo();
		if (strlen($status)>1){
			$criteria->add(new Criteria('status', $status, 'IN'));
		}else{
			$criteria->add(new Criteria('status', intval($status), '='));
		}
		if ( is_object($xoopsUser) === FALSE or !$xoopsUser->isadmin()){
			$criteria->add(new Criteria('owner', implode(',', $userIds), 'IN'));
			//$criteria->add(new Criteria('status', 1, '='));
		}
		//
		// Get Recordcount for page switching
		//
		$formHandler = xoops_getmodulehandler('form');
		$this->total = $formHandler->getCount($criteria);
		if (!empty($formId)) {
			if( $this->sortorder == "DESC" ) {
				$operator_for_position = '>' ;
			} else {
				$operator_for_position = '<' ;
			}
			$criteria->add(new Criteria('id', $formId, $operator_for_position));
			$position = $formHandler->getCount($criteria);
			$this->start = intval($position / $this->perpage) * $this->perpage;
		}
		$criteria->addSort($this->sortname, $this->sortorder);
		$criteria->setStart($this->start);
		$criteria->setLimit($this->perpage);
		$formObjects = $formHandler->getObjects($criteria);
		$GulHandler = xoops_getmodulehandler('groups_users_link','user');
		$tpl_vars = array();
		foreach($formObjects as $Obj){
			$row = array(
				'id' => $Obj->getVar('id'),
				'uid' => $Obj->getVar('owner'),
				'name' => $Obj->getVar('name'),
				'public'=> $Obj->getVar('public'),
				'uname' => XoopsUser::getUnameFromId($Obj->getVar('owner')),
				'title' => $Obj->getVar('title'),
				'changed' => $Obj->getVar('changed'),
				'published' => $Obj->getVar('published'),
				'expired' => $Obj->getVar('expired'),
				'status' => $Obj->getVar('status'),
				'status_desc' => $this->get_status($Obj->getVar('status')),
				'resp' => $this->get_responseCount($Obj->getVar('id'))
			);
			$row['realm'] = $this->_isGroupsOfUser( $GulHandler, $row['uid'] );
			$row['hidelist'] = 0;
			if ( $this->is_admin ){
				$accessible = TRUE;
			}else if ( $row['public'] == 'N' && $row['uid']!=$uid){
				$accessible = FALSE;
			}else if ($this->_checkMyGroup($row['realm'])){
				$accessible = TRUE;
			}
			if($accessible==TRUE){
				$submitted = 0;
				$this->set_manageFlag($row['uid'],$row['realm']);
				$row['editbyGroup'] = $this->editbyGroup;
				$row['viewbyGroup'] = $this->viewbyGroup;
				if($xoopsUser){
					$sbm_sql = 'SELECT submitted FROM '.TABLE_RESPONSE.' WHERE form_id='.$row['id'].' and uid="'.$xoopsUser->uname().'" ORDER BY submitted DESC';
					$sbm_result = $xoopsDB->query($sbm_sql);
					list($submitted) = $xoopsDB->fetchRow($sbm_result);
				}
				$row['submitted'] = $submitted;
				$this->get_status($row['status']);
				$tpl_vars[] = $row;
			}
		}
		return $tpl_vars;
	}

	/**
	 * 同じグループに所属するユーザIDをすべて返す
	 * @param $xoopsUser
	 * @return array
	 */
	protected function &_getSameGroupUserIds(&$xoopsUser)
	{
		$sameGroupUserIds = array($xoopsUser->uid());
		if ( is_object($xoopsUser) === FALSE ) {
			return $sameGroupUserIds;
		}
		$group_ids = $xoopsUser->getGroups();
		$gulHandler = xoops_getmodulehandler('groups_users_link','user');
		$criteria = new Criteria('groupid',implode(",",$group_ids),"IN");
		$gulObjects = $gulHandler->getObjects($criteria);
		foreach($gulObjects as $gulOnject){
			$sameGroupUserIds[] = $gulOnject->getVar('uid');
		}
		return $sameGroupUserIds;
	}

	/**
	 * @param int $userId
	 * @return bool|string
	 */
	protected function _getGeneralGroupByUserId($userId)
	{
		/** @protected XoopsMemberHandler $memberHandler  */
		$memberHandler = xoops_gethandler('member');
		/** @protected XoopsGroup[] $xoopsGroups */
		$xoopsGroups = $memberHandler->getGroupsByUser($userId, TRUE);

		foreach ( $xoopsGroups as $xoopsGroup ) {
			if ( $xoopsGroup->isGeneral() ) {
				return $xoopsGroup->get('groupid');
			}
		}

		return FALSE;
	}

	function get_Respondentinfo( $unm ){
		global $xoopsDB;
		$sql = "SELECT * FROM ".TABLE_RESPONDENT." WHERE uid='".$unm."'";
		$result = $xoopsDB->query($sql);
		if ($xoopsDB->getRowsNum($result) != 1) return(FALSE);
		$ret = $xoopsDB->fetchArray($result);

		$ret['sid'] = $ret['form_id'];
		$ret['rid'] = $ret['response_id'];
		return $ret;
	}
	function delete_respondent( $uid ){
		global $xoopsDB;
		$sql = "DELETE FROM ".TABLE_RESPONDENT." WHERE uid='".$uid."'";
		$result = $xoopsDB->query($sql);
		if(!$xoopsDB->query($sql)) {
			/* unsucessfull -- abort */
			echo _MB_Cannot_delete_account .$uid.' ('. $xoopsDB->error() .')';
		}
	}
	function update_respondent( $respondent ){
		global $xoopsDB;
		$debug=0;

		if ($debug) print_r($respondent);
		$disabled = ($respondent['disabled']==1) ? 'Y' : 'N';
		$sql = "SELECT * FROM ".TABLE_RESPONDENT." WHERE uid='".$respondent['uid']."'";
		$result = $xoopsDB->query($sql);
		if ($xoopsDB->getRowsNum($result) != 1){
			$sql = sprintf("insert into %s
				(uid,password,fname,lname,email,disabled,form_id,response_id,changed,expiration)
				values('%s','%s','%s','%s','%s','%s',%u,%u,CURRENT_TIMESTAMP(),'%s')",
				TABLE_RESPONDENT,
				$respondent['uid'],
				$respondent['password'],
				$respondent['fname'],
				$respondent['lname'],
				$respondent['email'],
				$disabled,
				$respondent['sid'],
				$respondent['rid'],
				$respondent['expiration']);
		}else{
			$sql = "UPDATE ".TABLE_RESPONDENT." SET "
			."password='".$respondent['password']."'"
			.",fname='".$respondent['fname']."'"
			.",lname='".$respondent['lname']."'"
			.",email='".$respondent['email']."'"
			.",disabled='". $disabled ."'"
			.",form_id=".$respondent['sid']
			.",response_id=".$respondent['rid']
			.",changed='".$respondent['changed']."'"
			.",expiration='".$respondent['expiration']."'"
			." WHERE uid='".$respondent['uid']."'";
		}
		if ($debug) echo "<p>".$sql;
		$xoopsDB->queryF($sql);
	}

	function createRssURL($uid){
		if((empty($useRerite)) || ($useRerite == 0) ){
			return POPNUPBLOG_DIR.'rss.php'.POPNUPBLOG_REQUEST_URI_SEP.$uid;
		}else{
			return POPNUPBLOG_DIR.'rss/'.$uid.".xml";
		}
	}

	function createUrl($uid){
		return XOOPS_URL."/modules/'.$this->myDirName.'/";
	}

	function createUrlNoPath($uid, $year = 0, $month = 0, $date = 0, $hours = 0, $minutes = 0, $seconds = 0, $command = NULL){
		$result = '';
		if((empty($useRerite)) || ($useRerite == 0) ){
			$result .= "index.php".POPNUPBLOG_REQUEST_URI_SEP.FormTable::makeParams($uid, $year, $month, $date, $hours, $minutes, $seconds, $command);
		}else{
			$result .= "view/".FormTable::makeParams($uid, $year, $month, $date, $hours, $minutes, $seconds, $command).".html";
		}
		return $result;
	}

	function mb_strcut($text, $start, $end){
		if(function_exists('mb_strcut')){
			// return mb_strcut($text, $start, $end);
			return mb_substr($text, $start, $end);
		}else{
			return substr($text, $start, $end);
			// return strcut($text, $start, $end);
		}
	}

	function toRssDate($time, $timezone = NULL){
		if(!empty($timezone)){
			$time = xoops_getUserTimestamp($time, $timezone);
		}
		$res =  date("Y-m-d\\TH:i:sO", $time);
		// mmmm
		$result = substr($res, 0, strlen($res) -2).":".substr($res, -2);
		return $result;
	}

	function checkUid($iuid){
		$uid = intval($iuid);
		if( $uid > 0){
			return $uid;
		}
	}

	function checkYear($iyear){
		$year = intval($iyear);
		if ( ($year > 1000) && ($year < 3000) ){
			return $iyear;
		}
		redirect_header(XOOPS_URL.'/',1,_MD_POPNUPBLOG_INVALID_DATE.'(YEAR)'.$iyear);
		exit();
	}

	function checkMonth($imonth){
		$month = intval($imonth);
		if ( ($month > 0) && ($month < 13) ){
			return $imonth;
		}
		redirect_header(XOOPS_URL.'/',1,_MD_POPNUPBLOG_INVALID_DATE.'(MONTH)');
		exit();
	}

	function checkDate($year, $month, $date){
		if(checkdate(intval($month), intval($date), intval($year))){
			return $date;
		}
		redirect_header(XOOPS_URL.'/',1,_MD_POPNUPBLOG_INVALID_DATE.'(ALL DATE) '.intval($year)."-".intval($month)."-". intval($date));
		exit();
	}

	function makeParams($uid, $year=0, $month=0, $date=0, $hours=0, $minutes=0, $seconds=0, $command = NULL){
		$result = '';
		$c = '';
		if(!empty($command)){
			$c = '-'.$command;
		}
		if($year == 0){
			$result = $uid;
		}else if($date == 0){
			$result = sprintf("%s-%04u%02u%s", "".$uid, $year, $month, $c);
		}else{
			$result = sprintf("%s-%04u%02u%02u%02u%02u%02u%s", "".$uid, $year, $month, $date, $hours, $minutes, $seconds, $c);
		}
		return $result;
	}

	function makeTrackBackURL($uid, $year = 0, $month = 0, $date = 0, $hours=0, $minutes=0, $seconds=0){
		return XOOPS_URL.'/modules/popnupform/trackback.php'.POPNUPBLOG_REQUEST_URI_SEP.FormTable::makeParams($uid, $year, $month, $date, $hours, $minutes, $seconds);
	}

	function isCompleteDate($d){
		if(!empty($d['year'])){
			if(checkdate(intval($d['month']), intval($d['date']), intval($d['year']))){
				return TRUE;
			}
		}
		return FALSE;
	}
	function complementDate($d){
		if(!checkdate(intval($d['month']), intval($d['date']), intval($d['year']))){
			$time = time();
			$d['year'] = date('Y',$time);
			$d['month'] = sprintf('%02u', date('m',$time));
			$d['date'] =  sprintf('%02u', date('d',$time));
			$d['hours'] =  sprintf('%02u', date('H',$time));
			$d['minutes'] =  sprintf('%02u', date('i',$time));
			$d['seconds'] =  sprintf('%02u', date('s',$time));
		}
		//print($d['hours'].$d['minutes'].$d['seconds']);
		return $d;
	}

	function convert_encoding(&$text, $from = 'auto', $to){
		if(function_exists('mb_convert_encoding')){
			return mb_convert_encoding($text, $to, $from);
		} else if(function_exists('iconv')){
			return iconv($from, $to, $text);
		}else{
			return $text;
		}
	}

	function assign_message(&$tpl){
		$all_constants_ = get_defined_constants();
		foreach($all_constants_ as $key => $val){
			if(preg_match("/^_(MB|MD|AM|MI)_BMSURVEY_(.)*$/", $key) || preg_match("/^BMSURVEY_(.)*$/", $key)){
				if(is_array($tpl)){
					$tpl[$key] = $val;
				}else if(is_object($tpl)){
					$tpl->assign($key, $val);
				}
			}
		}
	}
	/*
	function get_recent_trackback($date){
		global $xoopsDB;
		$sql = 'select title, url from '.POPNUPBLOG_TABLE_TRACKBACK.' where uid = '.$date['uid'].' order by t_date desc';
		if(!$db_result = $this->xoopsDB->query($sql)){
			return false;
		}
		$i = 0;

		$result['html'] = '<div>';
		while(list($title, $url) = $this->xoopsDB->fetchRow($db_result)){
			$result[data][] = new array(){ 'title' => $title, 'url' => $url};
			$i++;
			$result['html'] .= '<a href="'.$url.'" target="_blank">'.$title.'</a><br />';
		}
		$result['html'] .= '</div>';

		return $result;
	}
	*/
	function send_trackback_ping($trackback_url, $url, $title, $form_name, $excerpt = NULL) {
		bmsurveyPing2::send_trackback_ping($trackback_url, $url, $title, $form_name, $excerpt) ;
	}


	function remove_html_tags($t){
		return preg_replace_callback(
			"/(<[a-zA-Z0-9\"\'\=\s\/\-\~\_;\:\.\n\r\t\?\&\+\%\&]*?>|\n|\r)/ms",
			/* "/(<[*]*?>|\n|\r)/ms", */
			"popnupform_remove_html_tags_callback",
			$t);
	}


	function convert2sqlString($text){
		$ts = MyTextSanitizer::getInstance();
		if(!is_object($ts)){
			exit();
		}
		$res = $ts->stripSlashesGPC($text);
		$res = $ts->censorString($res);
		$res = addslashes($res);
		return $res;
	}
	function mail_popimg(){
		global $log,$limit_min;
		if (filemtime($log) < time() - $limit_min * 60) {
			return "<div style=\"text-align:center;\"><img src=./pop.php?img=1&time=".time()."\" width=70 height=1 /></div>POPed";
		} else {
			return "snoozed";
		}
	}
	function get_mailcode(){
		switch (_LANGCODE){
		case "af": $code = "ISO-8859-1";break;	//Afrikaans
		case "ar": $code = "ISO-8859-6";break;	//Arabic
		case "be": $code = "ISO-8859-5";break;	//Byelorussian
		case "bg": $code = "ISO-8859-5";break;	//Bulgarian
		case "ca": $code = "ISO-8859-1";break;	//Catalan
		case "cs": $code = "ISO-8859-2";break;	//Czech
		case "da": $code = "ISO-8859-1";break;	//Danish
		case "de": $code = "ISO-8859-1";break;	//German
		case "el": $code = "ISO-8859-7";break;	//Greek
		case "en": $code = "us-ascii";	break;	//English
		case "eo": $code = "ISO-8859-3";break;	//Esperanto
		case "es": $code = "ISO-8859-1";break;	//Spanish
		case "eu": $code = "ISO-8859-1";break;	//Basque
		case "et": $code = "iso-8859-15";break;	//Estonian
		case "fi": $code = "ISO-8859-1";break;	//Finnish
		case "fo": $code = "ISO-8859-1";break;	//Faroese
		case "fr": $code = "ISO-8859-1";break;	//French
		case "ga": $code = "ISO-8859-1";break;	//Irish
		case "gd": $code = "ISO-8859-1";break;	//Scottish
		case "gl": $code = "ISO-8859-1";break;	//Galician
		case "hr": $code = "ISO-8859-2";break;	//Croatian
		case "hu": $code = "ISO-8859-2";break;	//Hungarian
		case "is": $code = "ISO-8859-1";break;	//Icelandic
		case "it": $code = "ISO-8859-1";break;	//Italian
		case "iw": $code = "ISO-8859-8";break;	//Hebrew
		case "ja": $code = "ISO-2022-JP";break;	//Japanese (Shift_JIS)
		case "ko": $code = "EUC_KR";	break;	//Korean
		case "lt": $code = "ISO-8859-13";break;	//Lithuanian
		case "lv": $code = "ISO-8859-13";break;	//Latvian
		case "mk": $code = "ISO-8859-5";break;	//Macedonian
		case "mt": $code = "ISO-8859-5";break;	//Maltese
		case "nl": $code = "ISO-8859-1";break;	//Dutch
		case "no": $code = "ISO-8859-1";break;	//Norwegian
		case "pl": $code = "ISO-8859-2";break;	//Polish
		case "pt": $code = "ISO-8859-1";break;	//Portuguese
		case "ro": $code = "ISO-8859-2";break;	//Romanian
		case "ru": $code = "ISO-8859-5";break;	//Russian
		case "sh": $code = "ISO-8859-5";break;	//Serbo-Croatian
		case "sk": $code = "ISO-8859-2";break;	//Slovak
		case "sl": $code = "ISO-8859-2";break;	//Slovenian
		case "sq": $code = "ISO-8859-2";break;	//Albanian
		case "sr": $code = "ISO-8859-2";break;	//Serbian
		case "sv": $code = "ISO-8859-1";break;	//Swedish
		case "th": $code = "TIS620";	break;	//Thai
		case "tr": $code = "ISO-8859-9";break;	//Turkish
		case "uk": $code = "ISO-8859-5";break;	//Ukrainian
		case "zh": $code = "GB2312";	break;	//Chainese
		default: $code = "UTF-8";break;
		}
		return $code;
	}
}
?>
