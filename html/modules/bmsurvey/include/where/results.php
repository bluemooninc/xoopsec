<?php
// $Id: results.php,v 2.0 2009/02/01 15:00:00 makinosuke Exp $
require_once("./include/function/form_results.php");

$xoopsOption['template_main'] = 'bmsurvey_manage.html';
$xoopsTpl->assign('xoops_module_header', '<link href="style.css" media="screen,tv,print" type="text/css" rel="stylesheet" />');
if ($sid) {
	//$precision = !empty($_GET['precision']) ? intval($_GET['precision']) : '';
	//$totals    = !empty($_GET['totals'])    ? intval($_GET['totals'])    : '';
	$cids      = !empty($_GET['cids'])      ? addslashes($_GET['cids']) : (!empty($_POST['cids']) ? addslashes($_POST['cids']) : '');	//array_map('addslashes', $_POST['cids'])
	$qid       = !empty($_GET['qid'])       ? intval($_GET['qid'])       : (!empty($_POST['qid'])  ? intval($_POST['qid'])                    : '');
	$rid       = !empty($_POST['rid'])      ? intval($_POST['rid'])      : (!empty($_GET['rid'])   ? intval($_GET['rid'])                     : '');
	$deny      = !empty($_POST['deny'])     ? intval($_POST['deny'])     : (!empty($_GET['deny'])  ? intval($_GET['deny'])                    : '');
	$defset    = !empty($_GET['defset'])    ? $_GET['defset']            : '';
	$guicross  = $type = !empty($_GET['type']) ? $_GET['type'] : '';
	if($rid){
	    $ret = form_results($sid, '', '', $rid, '', $deny, $defset); // <---- Results per rid.
	}else if($guicross){
//		$ret = form_results($sid, '', '', '', $guicross); // <---- Cross Tab & Cross Analysis Setting
		$ret = crosstab_crossanalysis_settingview($sid);
	}else{
		$ret = form_results($sid, $qid, $cids); // <---- Summary Math. & Cross Analysis
	}
	$xoopsTpl->assign($ret);
	
	$show_formlist = FALSE;
}else{
	$show_formlist = TRUE;
}

?>