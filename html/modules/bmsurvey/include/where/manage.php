<?php
$xoopsOption['template_main'] = 'bmsurvey_manage.html';
$tpl_vars = array('content' => array(), 'langs' => array(), 'config' => array());
$tpl_vars['content']['forms'] = FormTable::get_form_list(0,true,'changed','DESC',false);
$tpl_vars['langs'] = array(
	'form_title' => _MB_LIST_TITLE,
	'form_subtitle' => _MB_LIST_SUBTITLE,
	'form_uid' => _MB_LIST_UNAME,
	'form_lastupdate' => _MB_LIST_DATE,
	'form_ischecked', _MB_LIST_CHECKED,
	'form_make_public' => _MB_Make_Public,
	'form_make_private' => _MB_Make_Private,
	'form_test' => _MB_Test,
	'form_activate' => _MB_Activate,
	'form_end' => _MB_End,
	'form_archive' => _MB_Archive,
	'form_public_Y' => _MB_Public,
	'form_public_N' => _MB_Private,
	'form_status_active' => _MB_Active,
	'form_status_ended' => _MB_Ended,
	'form_status_archived' => _MB_Archived,
	'form_status_testing' => _MB_Testing
);
//$xoopsTpl->assign('bmsurvey', $tpl_vars);

?>