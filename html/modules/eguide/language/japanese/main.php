<?php
// $Id: main.php,v 1.4 2010-10-10 06:30:12 nobu Exp $

if (defined('_MD_RESERV_FORM')) return;

define('_MD_RESERV_FORM','ご予約はこちら');
define('_MD_RESERVATION','予約申込');
define('_MD_NAME','/^(お|御)?名前\*?$/');
define('_MD_SDATE_FMT', 'Y年m月d日');
define('_MD_STIME_FMT', 'H時i分');
global $ev_week;
$ev_week = array('Sun'=>'日', 'Mon'=>'月','Tue'=>'火', 'Wed'=>'水',
		 'Thu'=>'木','Fri'=>'金', 'Sat'=>'土');
define('_MD_POSTED_FMT', 'm');
define('_MD_TIME_FMT', 'm');
define('_MD_READMORE','詳細...');
define('_MD_EMAIL','メール');
define('_MD_EMAIL_CONF','メール確認');
define('_MD_EMAIL_CONF_DESC','確認のためもう一度メールアドレスを入力してください');
define('_MD_UNAME','ユーザ名');
define('_MD_SUBJECT','予約確認 - {EVENT_DATE} {EVENT_TITLE}');
define('_MD_NOTIFY_EVENT',  '新規のイベント掲載をメールで通知する');
define('_MD_NOTIFY_REQUEST','新しいイベント案内が登録されたらメールで通知する');
define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_LISTITEM_FMT', '[%s]');
define('_MD_ORDER_NOTE1', _MD_REQUIRE_MARK.' は必須項目です。');
define('_MD_ORDER_NOTE2','[ ] の項目は参加者一覧に表示されます。');
define('_MD_ORDER_SEND','予約を申し込む');
define('_MD_ORDER_CONF','確認ページへ');

define('_MD_EVENT_NONE','掲載中のイベント案内はありません');
define('_MD_BACK','戻る');
define('_MD_RESERVED','このイベントを予約しています');
define('_MD_RESERV_NUM','定員数 %d人');
define('_MD_RESERV_REG','予約数 %d人');
define('_PRINT', '印刷');

define('_MD_NOITEM_ERR','必須項目の入力がありません');
define('_MD_NUMITEM_ERR','数値を入力してください');
define('_MD_MAIL_ERR','メールアドレスの書式を確認してください');
define('_MD_MAIL_CONF_ERR','確認入力のメールアドレスが一致しません');
define('_MD_SEND_ERR','メール送信に失敗しました');
define('_MD_DUP_ERR','お申し込みメールアドレスで既に予約があります');
define('_MD_DATE_ERR','指定日時が範囲外です');
define('_MD_DATEDELETE_ERR','予約があるので削除を中止しました');
define('_MD_DUP_REGISTER','メール通知は既に登録済みです');
define('_MD_REGISTERED','メール通知を登録しました');

define('_MD_RESERV_ACCEPT','予約確認メールを送信しました。確認メールが届かない場合、担当者まで御連絡ください。');
define('_MD_RESERV_STOP','現在、予約受付が中止されています。');
define('_MD_RESERV_CONF','申込内容');
define('_MD_RESERV_ADMIN','予約受付');
define('_MD_RESERV_REGISTER','予約登録');

define("_MD_RESERV_ACTIVE","を受付けました。");
define("_MD_RESERV_REFUSE","は受付けられません。");

define('_AM_MAILGOOD','成功: %s');
define('_AM_SENDMAILNG','失敗: %s');

define('_MD_RESERV_NOTFOUND','指定の予約がないか、既に取り消されています。');
define('_MD_RESERV_CANCEL','この予約を取り消します。');
define('_MD_RESERV_CANCELED','イベント予約を取り消しました');
define('_MD_RESERV_NOCANCEL','締め切り後の予約の取り消しは行えません');
define('_MD_RESERV_NOTIFY',"%s\n\n予約者アドレス: %s\n予約イベント: %s\n  %s\n");
define('_MD_RESERV_FULL','予約人数に達したため受付を終了しました');
define('_MD_RESERV_TOMATCH',' %d が多過ぎます (残り %d)');
define('_MD_RESERV_CLOSE','受付を終了しました');
define('_MD_RESERV_NEEDLOGIN','イベントの予約には<a href="'.XOOPS_URL.'/user.php">ログイン</a>が必要です');
define('_MD_RESERV_PLUGIN_FAIL','申込の条件が不足しています');
define('_MD_CANCEL_FAIL','取り消し処理が失敗しました');
define('_MD_CANCEL_SUBJ','予約取消 - {EVENT_DATE} {EVENT_TITLE}');
define('_MD_NODATA','データがありません');
define('_MD_NOEVENT','選択されたイベント記事は存在しません');
define('_MD_SHOW_PREV','前のイベント');
define('_MD_SHOW_NEXT','次のイベント');

define('_MD_POSTERC','担当者');
define('_MD_POSTDATE','登録日時');
define('_MD_STARTTIME','開始時間');
define('_MD_CLOSEDATE','予約締切時間');
define('_MD_CLOSEBEFORE','予約終了時間');
define('_MD_CLOSEBEFORE_DESC','開始までの時間を長さで指定する (例: 3日間, 2時間, 50分)');
define('_MD_TIME_UNIT','日間,時間,分');
define('_MD_TIME_REG','日(間)?,時(間)?,分');
define('_MD_CALENDAR','カレンダーへ');
define('_MD_CAL','カレンダ');
define('_MD_CAL_MONDAY_FIRST', false);
define('_MD_REFER','%d ヒット');
define('_MD_RESERV_LIST','参加者一覧');

define('_MD_NEED_UPGRADE','モジュールのアップグレード処理を行います');

//%%%%%%	File Name receiept.php 	%%%%%
define("_MD_RESERV_EDIT","予約情報の編集");
define("_MD_OPERATION","操作");
define("_MD_STATUS","受付");
define("_MD_RESERV_RETURN","一覧へ戻る");
define("_MD_RESERV_REC","予約情報の詳細");
define("_MD_RVID","受付ID");
define("_MD_ORDER_COUNT","申し込み数");
define("_MD_PRINT_DATE","表示日時");
define("_MD_SAVECHANGE","変更を保存");
define("_MD_RESERV_DEL","この予約を削除する");
define("_MD_DETAIL","詳細");
define("_MD_RESERV_MSG_H","応答で送るメッセージ");
define("_MD_ACTIVATE","受付承認");
define("_MD_REFUSE","受付拒否");
define("_MD_EXPORT_OUT","Excel形式");
define('_MD_EXPORT_CHARSET', 'UTF-8');
define("_MD_INFO_MAIL","メール送信");
define("_MD_SUMMARY","集計");
define("_MD_SUM_ITEM","集計項目");
define("_MD_SUM","計");

//%%%%%%	File Name admin.php 	%%%%%
define('_MD_EDITARTICLE','イベント記事を編集');
define('_MD_NEWTITLE','新規登録イベント');
define('_MD_NEWSUB','新規登録イベント - {EVENT_DATE} {EVENT_TITLE}');
define('_MD_TITLE','表題');
define('_MD_EVENT_DATE','イベント日時');
define('_MD_EVENT_EXPIRE','掲載終了時間');
define('_MD_EVENT_EXTENT','繰り返し開催');
define('_MD_EVENT_CATEGORY','カテゴリ');
define('_MD_EDIT_EXTENT','開催日の編集');
define('_MD_EXTENT_REPEAT','回数');
define('_MD_ADD_EXTENT','開催日の追加');
define('_MD_ADD_EXTENT_DESC','追加する開催日を YYYY-MM-DD HH:MM 形式で記入 (複数は改行で区切る)');
define('_MD_INTROTEXT','本文');
define('_MD_EXTEXT','詳細本文');
define('_MD_EVENT_STYLE','出力の編集形式');
define('_MD_RESERV_SETTING','予約処理');
define('_MD_RESERV_DESC','予約受付処理を行う');
define('_MD_RESERV_STOPFULL','定員になったら受付中止');
define('_MD_RESERV_AUTO','自動受付 (予約承認をしない)');
define('_MD_RESERV_NOTIFYPOSTER','申込をメールで担当者に通知する');
define('_MD_RESERV_UNIT','人');
define('_MD_RESERV_ITEM','追加項目');
define('_MD_RESERV_LAB','項目名');
define('_MD_RESERV_LABREQ','項目名を入力してください');
define('_MD_RESERV_REQ','必須項目');
define('_MD_RESERV_ADD','追加');
define('_MD_RESERV_OPTREQ','引数が必要です');
define('_MD_RESERV_ITEM_DESC','<a href="language/japanese/help.html#form" target="help">追加項目の書式について</a>');
define('_MD_RESERV_LABEL_DESC','予約人数の指定は項目名「%s」で行います');
define('_MD_OPTION_VARS','オプション変数');
define('_MD_OPTION_OTHERS','その他');
define('_MD_RESERV_REDIRECT','予約後に遷移する URL');
define('_MD_RESERV_REDIRECT_DESC','待ち時間を秒数で指定できる (例: "4;http://...")。変数: {X_EID}, {X_SUB}, {X_RVID}');
define('_MD_APPROVE','掲載承認');
define('_MD_PREVIEW','プレビュー');
define('_MD_SAVE','保存');
define('_MD_UPDATE','更新する');
define('_MD_DBUPDATED','データベースを更新しました');
define('_MD_DBDELETED','イベントを削除しました');

define('_MD_EVENT_DEL_DESC','このイベントを削除します。');
define('_MD_EVENT_DEL_ADMIN','申込情報を含めすべてのデータを削除します。');

define('_MD_TIMEC','時間');
// Localization Transrate Month name
global $ev_month;
$ev_month = array("Jan"=>"1月", "Feb"=>"2月", "Mar"=>"3月", "Apr"=>"4月",
		  "May"=>"5月", "Jun"=>"6月", "Jul"=>"7月", "Aug"=>"8月",
		  "Sep"=>"9月", "Oct"=>"10月", "Nov"=>"11月", "Dec"=>"12月");

define('_MD_RESERV_DEFAULT_ITEM',"名前*,size=40\n住所\n");
define('_MD_RESERV_DEFAULT_MEMBER',"");

// notification message
define('_MD_APPROVE_REQ','内容を確認して承認を行ってください。');
//%%%%%%	File Name sendinfo.php 	%%%%%
define("_MD_INFO_TITLE","お知らせメールの送信");
define("_MD_INFO_CONDITION","送信先");
define("_MD_INFO_NODATA","データがありません");
define("_MD_INFO_SELF","内容を自分自身 (%s) にも送信する");
define("_MD_INFO_DEFAULT","-お知らせの本文-\n\n\n予約イベントの詳細\n    {EVENT_URL}\n");
define("_MD_INFO_MAILOK","メール送信に成功しました");
define("_MD_INFO_MAILNG","メール送信が失敗しました");
define("_MD_UPDATE_SUBJECT","イベントの更新通知");
define("_MD_UPDATE_DEFAULT","規定値");

//%%%%%%	File Name print.php 	%%%%%

define('_MD_URLFOREVENT','このイベント記事が掲載されているURL：');
// %s represents your site name
define('_MD_THISCOMESFROM','%sにて更に多くのイベント案内を読むことができます');

//%%%%%%	File Name mylist.php 	%%%%%
define('_MD_MYLIST','これまでに予約したイベント');
define('_MD_CANCEL','予約取消');
?>