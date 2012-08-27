<?php
// $Id: modinfo.php,v 1.3 2010-10-10 06:30:12 nobu Exp $
// Module Info

if (defined('_MI_EGUIDE_NAME')) return;

// The name of this module
define("_MI_EGUIDE_NAME","イベント案内");

// A brief description of this module
define("_MI_EGUIDE_DESC","イベント案内の掲載と、受付処理を行う");

// Names of blocks for this module (Not all module has blocks)
define("_MI_EGUIDE_MYLIST","予約済みイベント");
define("_MI_EGUIDE_SUBMIT","新規イベントの登録");
define("_MI_EGUIDE_COLLECT","定員一括編集");
define("_MI_EGUIDE_REG","メール通知の登録");
define("_MI_EGUIDE_HEADLINE","イベント案内");
define("_MI_EGUIDE_HEADLINE_DESC","開催が近付いたイベントの一覧");
define("_MI_EGUIDE_HEADLINE2","新規掲載イベント");
define("_MI_EGUIDE_HEADLINE2_DESC","最近掲載されたイベントの一覧");
define("_MI_EGUIDE_HEADLINE3","終了イベント");
define("_MI_EGUIDE_HEADLINE3_DESC","終了したイベントの一覧");
define("_MI_EGUIDE_CATBLOCK","イベント案内カテゴリ");
define("_MI_EGUIDE_CATBLOCK_DESC","カテゴリ選択を行う");

define("_MI_EGUIDE_EVENTS","イベント案内の操作");
define("_MI_EGUIDE_NOTIFIES","新規登録のメール通知");
define("_MI_EGUIDE_CATEGORY","カテゴリの管理");
define("_MI_EGUIDE_CATEGORY_MARK","カテゴリ - ");
define("_MI_EGUIDE_SUMMARY","予約の一覧");
define("_MI_EGUIDE_ABOUT","eguide について");

// Configuration variable for this module
define("_MI_EGUIDE_POSTGROUP","新規イベントの登録可能グループ");
define("_MI_EGUIDE_POSTGROUP_DESC","管理権限のないユーザでイベント掲載を行えるグループを指定する");
define("_MI_EGUIDE_NOTIFYADMIN","イベント管理者にメールで通知");
define("_MI_EGUIDE_NOTIFYADMIN_DESC","イベントが登録/変更された場合、管理者にメールで通知する");
define("_MI_EGUIDE_NOTIFY_ALWAYS","常に通知");
define("_MI_EGUIDE_NOTIFYGROUP","イベント管理者グループ");
define("_MI_EGUIDE_NOTIFYGROUP_DESC","管理通知メールを受け取るグループを指定する");
define("_MI_EGUIDE_NEEDPOSTAUTH","イベント掲載には承認が必要");
define("_MI_EGUIDE_NEEDPOSTAUTH_DESC","新規に登録されたイベントの掲載には管理者の承認を必要とする");
define("_MI_EGUIDE_MAX_LISTITEM","一覧で表示する追加項目数");
define("_MI_EGUIDE_MAX_LISTITEM_DESC","申し込み一覧で表示するフォームの追加項目の数");
define("_MI_EGUIDE_MAX_LISTLINES","一覧表示の表示行数");
define("_MI_EGUIDE_MAX_LISTLINES_DESC","一覧形式で表示する場合の最大表示行数");
define("_MI_EGUIDE_MAX_EVENT","トップページに掲載するイベント数");
define("_MI_EGUIDE_MAX_EVENT_DESC","トップページに一覧で掲載するイベントの最大数");
define("_MI_EGUIDE_SHOW_EXTENTS","複数掲載日を個別表示する");
define("_MI_EGUIDE_SHOW_EXTENTS_DESC","複数日指定のイベントを重複して表示を行う。「いいえ」を指定した場合、直近の日付のみ表示する");
define("_MI_EGUIDE_USER_NOTIFY","ユーザに新規イベントの通知");
define("_MI_EGUIDE_USER_NOTIFY_DESC","新規イベントが登録された場合に希望者へ通知を行う");
define("_MI_EGUIDE_MEMBER","ログインによる認証に限定");
define("_MI_EGUIDE_MEMBER_DESC","申し込みをログインユーザに限定する。(申し込みにメールアドレスを使わない)");
define("_MI_EGUIDE_MEMBER_RELAX","両方利用する");
define("_MI_EGUIDE_ORDERCONF","予約時の確認画面を表示");
define("_MI_EGUIDE_ORDERCONF_DESC","予約処理時に確認用の画面を表示する");
define("_MI_EGUIDE_CLOSEBEFORE","受付〆切時間");
define("_MI_EGUIDE_CLOSEBEFORE_DESC","申込受付を開始時間の何分前に締め切るかを指定する");
define("_MI_EGUIDE_PERSONS","予約人数の初期値");
define("_MI_EGUIDE_PERSONS_DESC","イベントを作成するフォームの申し込み人数の既定値を指定する");
define("_MI_EGUIDE_LAB_PERSONS","追加項目オプション指定");
define("_MI_EGUIDE_LAB_PERSONS_DESC","追加項目での予約人数を指定など付加的な設定を行う。例: 'label_persons=参加人数'。詳細は<a href=\"../../eguide/admin/help.php#form_options\">「eguideについて」</a>を参照のこと");
define("_MI_EGUIDE_DATE_FORMAT","日付表示の形式");
define("_MI_EGUIDE_DATE_FORMAT_DESC","イベントの開催日(時)を表示する形式を PHP の date 関数形式で指定する");
define("_MI_EGUIDE_DATE_FORMAT_DEF","Y-m-d (D)");
define("_MI_EGUIDE_EXPIRE_AFTER","掲載終了時間");
define("_MI_EGUIDE_EXPIRE_AFTER_DESC","イベントの時間以降の何分後にトップページの掲載を終了するかの既定値を指定する");
define("_MI_EGUIDE_PLUGINS","連携プラグインを有効にする");
define("_MI_EGUIDE_PLUGINS_DESC","イベントの申込制御に介入を行うプラグインを有効にする");
define("_MI_EGUIDE_COMMENT","イベント案内にコメントできる");
define("_MI_EGUIDE_COMMENT_DESC","イベント案内に対するコメント機能を有効にする");
define("_MI_EGUIDE_MARKER","予約状況の分類マーク");
define("_MI_EGUIDE_MARKER_DESC","予約量に応じて表示するマークを %で指定する。(xx,yy で xx%未満なら yy を表示、ただし 0,yy は受付終了時のマークを指定)");
define("_MI_EGUIDE_MARKER_DEF","0,[終]\n50,[空]\n100,[混]\n101,[満]\n");
define("_MI_EGUIDE_TIME_DEFS","時間枠指定");
define("_MI_EGUIDE_TIME_DEFS_DESC","定員一括画面で使う時間枠を指定する。例: 08:00,14:00,16:00");
define("_MI_EGUIDE_EXPORT_LIST","予約のファイルで出力項目");
define("_MI_EGUIDE_EXPORT_LIST_DESC","フィールド名または、フィールド番号をカンマ区切りで並べて指定する。* は残りを表す。例: 3,4,0,2,*");
// Templates
define("_MI_EGUIDE_INDEX_TPL", "イベント案内トップの一覧");
define("_MI_EGUIDE_EVENT_TPL", "個別イベントの詳細表示");
define("_MI_EGUIDE_ENTRY_TPL", "担当者による予約登録画面");
define("_MI_EGUIDE_EVENT_PRINT_TPL", "個別イベントの詳細印刷");
define("_MI_EGUIDE_RECEIPT_TPL", "予約受付の一覧表示");
define("_MI_EGUIDE_ADMIN_TPL", "イベント投稿フォーム");
define("_MI_EGUIDE_RECEIPT_PRINT_TPL", "予約受付の一覧の印刷");
define("_MI_EGUIDE_EVENT_ITEM_TPL", "掲載イベントの個別表示");
define("_MI_EGUIDE_EVENT_CONF_TPL", "掲載イベントの予約確認");
define("_MI_EGUIDE_EVENT_LIST_TPL", "予約イベント一覧");
define("_MI_EGUIDE_EVENT_CONFIRM_TPL", "予約確認画面");
define("_MI_EGUIDE_EDITDATE_TPL", "開催日の編集画面");
define("_MI_EGUIDE_COLLECT_TPL", "定員一括編集画面");
define("_MI_EGUIDE_EXCEL_TPL", "Excel (XML) 出力ファイル出力書式");

// Notifications
define('_MI_EGUIDE_GLOBAL_NOTIFY', 'モジュール全体');
define('_MI_EGUIDE_GLOBAL_NOTIFY_DESC', 'イベント案内モジュール全体における通知オプション');
define('_MI_EGUIDE_CATEGORY_NOTIFY', '表示中のカテゴリ');
define('_MI_EGUIDE_CATEGORY_NOTIFY_DESC', 'イベント案内モジュールのカテゴリにおける通知オプション');
define('_MI_EGUIDE_CATEGORY_BOOKMARK', '表示中のイベント');
define('_MI_EGUIDE_CATEGORY_BOOKMARK_DESC', 'イベント案内モジュールの掲載イベントにおける通知オプション');

define('_MI_EGUIDE_NEWPOST_SUBJECT', '新規イベント - {EVENT_DATE} {EVENT_TITLE}');
define('_MI_EGUIDE_NEWPOST_NOTIFY', '新規イベントの登録');
define('_MI_EGUIDE_NEWPOST_NOTIFY_CAP', '新しいイベントが登録された場合に通知する');
define('_MI_EGUIDE_CNEWPOST_NOTIFY', 'カテゴリに新規イベントの登録');
define('_MI_EGUIDE_CNEWPOST_NOTIFY_CAP', 'このカテゴリに新しいイベントが登録された場合に通知する');

// for altsys 
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','テンプレート管理');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','ブロック/アクセス管理');
    define('_MD_A_MYMENU_MYLANGADMIN','言語定数管理');
    define('_MD_A_MYMENU_MYPREFERENCES','一般設定');
}
?>