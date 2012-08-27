<?php
# user/admin common use resources
# $Id: common.php,v 1.1.1.1 2010-04-04 04:13:25 nobu Exp $

define("_MD_ORDER_DATE","受付日時");
define("_MD_CSV_OUT","CSV形式");
define('_MD_EXTENT_DATE','開催日');
define('_MD_RESERV_PERSONS','定員');
define("_MD_INFO_REQUEST","メール通知希望者");
define("_MD_INFO_COUNT","件数: %d");

global $expire_set,$edit_style,$ev_stats,$ev_extents,$rv_stats;

$expire_set = array(''=>'← テキスト指定', '+0'=>'開始時', '+3600'=>'1時間',
		    '+86400'=>'翌日', '+172800'=>'2日後',
		    '+259200'=>'3日後', '+604800'=>'1週間後');

$edit_style=array(0=>'XOOPS タグのみ変換',
		  1=>'改行をタグ&lt;br&gt;に変換',
		  2=>'HTML タグを無効にする');

$ev_stats=array(0=>'掲載中',
		1=>'承認待',
		4=>'削除');

$rv_stats=array(0=>'承認待',
		1=>'予約',
		2=>'拒否');

$ev_extents=array('none'=>'一回のみ',
		  'daily'=>'毎日', 'weekly'=>'毎週', 'monthly'=>'毎月');

?>
