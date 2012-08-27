<?php
# user/admin common use resources
# $Id: common.php,v 1.1 2008-02-02 05:54:11 nobu Exp $

define('_MD_ORDER_DATE', '日期');
define('_MD_CSV_OUT', '匯出CSV格式');
define('_MD_EXTENT_DATE', '報名開始受理日期');
define('_MD_RESERV_PERSONS', '活動名額');
define('_MD_INFO_REQUEST', '提醒活動通知註冊會員');
define('_MD_INFO_COUNT', '報名人員，共%d人');

global $expire_set,$edit_style,$ev_stats,$ev_extents,$rv_stats;

$expire_set = array(""=>"-- 使用文字 --", "+3600"=>"一個鐘頭",
		    "+10800"=>"三個鐘頭", "+21600"=>"半天",
		    "+0"=>"當天", "+172800"=>"兩天",
		    "+259200"=>"三天","+604800"=>"一星期");

$edit_style=array(0=>"只使用 XOOPS 標籤",
		  1=>"分行使用 &lt;br&gt; 標籤",
		  2=>"停用 HTML 標籤");

$ev_stats=array(0=>"顯示",
		1=>"等待",
		4=>"刪除");

$rv_stats=array(0=>"等待",
		1=>"保留",
		2=>"拒絕");

$ev_extents=array('none'=>'一次',
		  'daily'=>'每天', 'weekly'=>'每週', 'monthly'=>'每月');
?>
