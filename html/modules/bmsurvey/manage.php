<?php
// $Id: manage.php,v 0.92 2008/08/18 17:49:03 yoshis Exp $
//  ------------------------------------------------------------------------ //
//                Bluemoon.Multi-Form                                      //
//                    Copyright (c) 2005 Yoshi.Sakai @ Bluemoon inc.         //
//                       <http://www.bluemooninc.biz/>                       //
//                    Based by phpESP v1.6.1 ( James Flemer )                //
// ------------------------------------------------------------------------- //
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
require('../../mainfile.php');
require_once XOOPS_ROOT_PATH.'/header.php';
require_once('./admin/phpESP.ini.php');
include_once('./conf.php');
include_once('./class/FormTable.class.php');
include_once('./class/bmsurveyHtmlRender.class.php');
include_once('./class/bmsurveyEditForm.class.php');
include_once('./class/bmsurveyStatus.class.php');
include_once('./class/submitcount.class.php');		// 2010.05.25 yoshis
/*
** Check XOOPS user
*/
if (!is_object($xoopsUser)) {
	redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/',2,_MD_BMSURVEY_CAN_WRITE_USER_ONLY);
	exit();
}
$is_manager = false;
if ( count(array_intersect($xoopsModuleConfig['MANAGERS'],$xoopsUser->getGroups()))>0 ) {
	$is_manager = true;
}

/*
** Get parameter as command.
*/
$editForm = new bmsurveyEditForm();
$editForm->setFromPost($_POST);

$where = '';
if(isset($_POST['where'])) $where = htmlspecialchars ( $_POST['where'] , ENT_QUOTES );
elseif(isset($_GET['where'])) $where = htmlspecialchars ( $_GET['where'] , ENT_QUOTES );
else  $where = 'manage';

$sid = 0;
if(isset($_POST['sid'])) $sid = intval($_POST['sid']);
elseif(isset($_GET['sid'])) $sid = intval($_GET['sid']);
elseif(isset($editForm->editInfo['form_id'])) $sid = $editForm->editInfo['form_id'];

$newid = isset($_GET['newid']) ? intval($_GET['newid']) : 0;
$newid = isset($_POST['newid']) ? intval($_POST['newid']) : $newid;
if ($sid==0 && $newid>0) $sid= $newid;

$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;

$fmxStatus = new bmsurveyStatus();

/*
** Permission Check
** check ACL to see if user is allowed to design
** _this_ form
*/
$formTable = new FormTable($sid);
$err = false;

switch($where){
	case 'new':
		/** @var XoopsUser $xoopsUser  */
		if ( $is_manager == false ) {
			$err = true;
		}
		break;
	case 'download':
		if ( is_object($xoopsUser) === false or $xoopsUser->isAdmin() === false ) {
			$err = true;
		}
		if ( !$formTable->viewbyGroup() ) $err = true;
		break;
	case 'results':
		if ( !$formTable->viewbyGroup() ) $err = true;
		break;
	case 'status':
	case 'access':
	case 'tab':
	case 'purge':
		if ( $formTable->editbyGroup()==false && $uid!=$xoopsUser->uid()) $err = true;
		break;
	case 'copy':
		if ( $formTable->copybyGroup($formTable->uid())==false && $formTable->uid()!=$xoopsUser->uid()) $err = true;
		break;
}
if($err==true){
	$xoopsTpl->assign('message', _MD_BMSURVEY_YOU_DONT_HAVE_A_PERMISSION);
	//2011.12.09 S.Uchi delete /duplicated call of header require
//	require(XOOPS_ROOT_PATH.'/header.php');
	//2011.12.09 S.Uchi delete
	$xoopsOption['template_main'] = 'bmsurvey_message.html';
	include(XOOPS_ROOT_PATH.'/footer.php');
	exit;
}

$FMXCONFIG['csv_charset']  = FormTable::getXoopsModuleConfig('CSV_CHARSET');

//esp_init_db();

if($FMXCONFIG['auth_design']) {
	if(!manage_auth(
			addslashes(@$_SERVER['PHP_AUTH_USER']),
			addslashes(@$_SERVER['PHP_AUTH_PW'])))
		exit;
} else {
	$fmxEditForm->setAccessLevel();
}
if ($where == 'download') {
	include($fmxStatus->esp_where($where));
	exit;
}elseif ($where == 'test' && $sid) {
	$xoopsOption['template_main'] = 'bmsurvey_form.html';
}elseif (in_array($where,array('tab','new')) ){
	$fmxEditForm->_setDatepicker(); //要望 #1061対応 CNC@Tei 2012/06/12 Add
	if ($where == 'new') {
		$sid=$newid=0;
		$fmxEditForm->start_new();
	}else{
		if ($newid>0) $fmxEditForm->start_editing($newid);
	}
	$xoopsOption['template_main'] = 'bmsurvey_editform.html';
}elseif ($where == 'status' && $sid) {
	if (isset($_GET['op'])){
		$op = in_array($_GET['op'],array('c','t','m','a','e','d','r','v','p')) ?  htmlspecialchars ( $_GET['op'] , ENT_QUOTES ) : NULL ;
	}
	if (isset($_POST['op'])){
		$op = in_array($_POST['op'],array('c','t','m','a','e','d','r','v','p')) ?  htmlspecialchars ( $_POST['op'] , ENT_QUOTES ) : NULL ;
	}
}else{
	$fmxEditForm->editInfo['form_id'] = null;
	$fmxEditForm->editInfo['curr_qNumber'] = 1;
}
if($FMXCONFIG['DEBUG']) {
	include("./include/debug.php");
}
/*
 * Include Edit Programs
 */
switch ($where){
	case 'purge':
	case 'status':
		$fmxStatus->doWhere($where,$sid,$op);
		break;
	default:
		include ( $fmxStatus->esp_where($where) );
		break;
}

if (!isset($GLOBALS['errmsg'])) $GLOBALS['errmsg']="";
if ($GLOBALS['errmsg']){
	redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/',2,$GLOBALS['errmsg']);
}
if (isset($tab) && $tab=='finish'){
	header('Location: '.XOOPS_URL.'/modules/'.$mydirname.'/');	//index.php?sid=$sid
}
if (($where == 'status' || $where == 'purge') && $sid) {
	header('Location: '.XOOPS_URL.'/modules/'.$mydirname.'/index.php?manage_on=1');//&status='.$fmxStatus->op2statusNumber($op));
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
}

include(XOOPS_ROOT_PATH.'/footer.php');
?>
