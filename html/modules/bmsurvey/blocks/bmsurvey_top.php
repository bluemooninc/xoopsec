<?php
// $Id: bmsurvey_top.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $
if(!defined('XOOPS_ROOT_PATH')){
	exit();
}

$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/class/FormTable.class.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/conf.php';

function b_bmsurvey_wait_appl($options){
	global $xoopsUser;
	$block = array();
	FormTable::assign_message($block);
	if($xoopsUser && ($xoopsUser->isAdmin())){
		$block['bmsurvey_applicationNum'] = FormTable::getApplicationNum();
	}
	return $block;
}

function b_bmsurvey_show($options) {
	global $xoopsUser;
	
	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$block = array();
	$fmt = new FormTable();
	$block['form'] = $fmt->get_form_list();
	$block['url'] = XOOPS_URL.'/modules/'.$mydirname;
	/*
	$block['show_rss'] = ($options[0] == 1) ? 1 : 0;
	$block['blogTitle'] = _MB_POPNUPBLOG_BLOG_TITLE;
	$block['unameTitle'] = _MB_POPNUPBLOG_BLOGGER_NAME;
	$block['lastUpdateTitle'] = _MB_POPNUPBLOG_UPDATE_DATE;
	*/
	return $block;
}

function b_bmsurvey_edit($options){
	$checked = array();
	$checked[0] = ($options[0] == 1) ? ' selected' : '';
	$checked[1] = ($checked[0] == '') ? ' selected' : '';
	$form = '';
	/*
	$form .= _MB_POPNUPBLOG_SHOW_RSS_LINK." :";
	$form .= "<select name='options[0]'>\n";
	$form .= "<option value='1'".$checked[0].">"._MB_POPNUPBLOG_YES."</option>\n";
	$form .= "<option value='0'".$checked[1].">"._MB_POPNUPBLOG_NO."</option>\n";
	$form .= "</select>\n";
	*/
	return $form;
}
?>
