<?php
// $Id: main.php,v 1.18 2010-10-10 06:30:12 nobu Exp $

if (defined('_MD_RESERV_FORM')) return;

define('_MD_RESERV_FORM', '立即報名 &gt;&gt;');
define('_MD_RESERVATION', '報名表');
define('_MD_NAME', '/^Name\*?$/');
define('_MD_SDATE_FMT', 'Y-m-d');//2006-09-13
define('_MD_STIME_FMT', 'H:i');
// Localization Transrate Weekly date name
global $ev_week;
$ev_week = array('Sun'=>'星期日', 'Mon'=>'星期一','Tue'=>'星期二', 'Wed'=>'星期三','Thu'=>'星期四','Fri'=>'星期五', 'Sat'=>'星期六');
define('_MD_POSTED_FMT', 'Y-m-d H:i');//j M Y H:i >Y-m-d H:i
define('_MD_TIME_FMT', 'Y-m-d H:i');//j M Y H:i >Y-m-d H:i
define('_MD_READMORE', '詳細...');
define('_MD_EMAIL', '電子郵件');
define("_MD_EMAIL_CONF","檢查電子郵件");
define('_MD_EMAIL_CONF_DESC','請輸入您的電子郵件地址再次確認');
define('_MD_UNAME', '使用者名稱');
define('_MD_SUBJECT', '確認報名 - {EVENT_DATE} {EVENT_TITLE}');
define('_MD_NOTIFY_EVENT', '登錄電子郵件通知');
define('_MD_NOTIFY_REQUEST', '有新的活動訊息時請以電子郵件通知我');
define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_LISTITEM_FMT', '[%s]');
define('_MD_ORDER_NOTE1', '\''._MD_REQUIRE_MARK.'\'* 為必填項目');
define('_MD_ORDER_NOTE2', '\'[ ]\' 會顯示在參加者一覽表。');
define('_MD_ORDER_SEND', '確認資料無誤後按此報名');
define('_MD_ORDER_CONF', '你去確認');

define('_MD_EVENT_NONE', '並無公佈的活動訊息');
define('_MD_BACK', '返回');
define('_MD_RESERVED', '本活動受理報名中...');
define('_MD_RESERV_NUM', '名額 %d 人');
define('_MD_RESERV_REG', '已報名 %d 人');
define('_PRINT', '列印');

define('_MD_NOITEM_ERR', '必填項目沒有輸入內容');
define('_MD_NUMITEM_ERR', '請輸入內容');
define('_MD_MAIL_ERR', '請確認電子郵件格式');
define('_MD_MAIL_CONF_ERR','確認電子郵件地址不匹配');
define('_MD_SEND_ERR', '電子郵件寄送失敗');
define('_MD_DUP_ERR', '這個電子郵件已經註冊了');
define('_MD_DATE_ERR', '報名時間已截止');
define('_MD_DATEDELETE_ERR', '這個日期仍有報名活動，請勿刪除');
define('_MD_DUP_REGISTER', '電子郵件重複');
define('_MD_REGISTERED', '已經登記完成');

define('_MD_RESERV_ACCEPT', '您的報名表已經送出，我們將盡快與您聯繫！');
define('_MD_RESERV_STOP', '很抱歉！這項活動報名已經終止。');
define('_MD_RESERV_CONF', '您的報名資訊');
define('_MD_RESERV_ADMIN', '參加者一覽表');
define('_MD_RESERV_REGISTER', '會員直接報名');

define('_MD_RESERV_ACTIVE', '報名已受理');
define('_MD_RESERV_REFUSE', '被拒絕報名');

define('_AM_MAILGOOD', '成功： %s');
define('_AM_SENDMAILNG', '失敗： %s');

define('_MD_RESERV_NOTFOUND', '無法找到相關的申請或是已取消申請。');
define('_MD_RESERV_CANCEL', '取消此報名。');
define('_MD_RESERV_CANCELED', '活動報名已取消');
define('_MD_RESERV_NOCANCEL', '在活動結束後無法取消預約');
define('_MD_RESERV_NOTIFY', '%snn報名者郵件： %sn申請活動內容： %sn %sn');
define('_MD_RESERV_FULL', '報名人數已滿，所以受理終止');
define('_MD_RESERV_TOMATCH', ' %d個名額 (%d個名額)');
define('_MD_RESERV_CLOSE', '報名活動已截止');
define('_MD_RESERV_NEEDLOGIN', '您需要<a href="'.XOOPS_URL.'/user.php">登入</a>,才可以報名');
define('_MD_RESERV_PLUGIN_FAIL', '缺少預約時需要的條件');
define('_MD_CANCEL_FAIL', '取消處裡失敗');
define('_MD_CANCEL_SUBJ', '取消 - {EVENT_DATE} {EVENT_TITLE}');
define('_MD_NODATA', '無資料');
define('_MD_NOEVENT', '無法找到該活動的內容紀錄');
define('_MD_SHOW_PREV', '上個活動');
define('_MD_SHOW_NEXT', '下個活動');

define('_MD_POSTERC', '聯絡人');
define('_MD_POSTDATE', '登記日期');
define('_MD_STARTTIME', '活動幾點開始');
define('_MD_CLOSEDATE', '截止報名時間');
define('_MD_CLOSEBEFORE', '距離活動多久時間停止報名');
define('_MD_CLOSEBEFORE_DESC', '(即活動多久後開始,如: 1小時、2小時或50分鐘）');
define('_MD_TIME_UNIT', '天,小時,分鐘');
define('_MD_TIME_REG', 'd(ay)?s?,h(our)?,min');
define('_MD_CALENDAR', '前往行事例');
define('_MD_CAL', '行事曆');
define('_MD_CAL_MONDAY_FIRST', true);
define('_MD_REFER', '人氣：%d');
define('_MD_RESERV_LIST', '參加者一覽表');

define('_MD_NEED_UPGRADE', '需要模組更新');

//%%%%%%	File Name receiept.php 	%%%%%
define('_MD_RESERV_EDIT', '編輯報名內容');
define('_MD_OPERATION', '設定');
define('_MD_STATUS', '狀態');
define('_MD_RESERV_RETURN', '回報名名單');
define('_MD_RESERV_REC', '報名記錄');
define('_MD_RVID', '報名ID編號');
define('_MD_ORDER_COUNT', '統計');
define('_MD_PRINT_DATE', '列表日期');
define('_MD_SAVECHANGE', '儲存修改');
define('_MD_RESERV_DEL', '刪除報名');
define('_MD_DETAIL', '參加者一覽表');
define('_MD_RESERV_MSG_H', '傳送訊息給報名者');
define('_MD_ACTIVATE', '審核');
define('_MD_REFUSE', '拒絕');
define('_MD_EXPORT_OUT', '匯出Excel格式');
define('_MD_EXPORT_CHARSET', 'UTF-8');
define('_MD_INFO_MAIL', '活動通知');
define('_MD_SUMMARY', '總結');
define('_MD_SUM_ITEM', '總結項目');
define('_MD_SUM', '總和');

//%%%%%%	File Name admin.php 	%%%%%
define('_MD_EDITARTICLE', '活動內容編輯');
define('_MD_NEWTITLE', '刊登新活動');
define('_MD_NEWSUB', '刊登新活動 - {EVENT_DATE} {EVENT_TITLE}');
define('_MD_TITLE', '項目名');
define('_MD_EVENT_DATE', '活動日期');
define('_MD_EVENT_EXPIRE', '活動時間(輸入數字即可，換算單位：分鐘，或使用右側下拉選單)');
define('_MD_EVENT_EXTENT', '重覆開放');
define('_MD_EVENT_CATEGORY', '分類');
define('_MD_EDIT_EXTENT', '編輯開放日期');
define('_MD_EXTENT_REPEAT', '重覆');
define('_MD_ADD_EXTENT', '增加開放日期');
define('_MD_ADD_EXTENT_DESC', '活動再開放時間，格式："2100-11-06 09:00" (多個選項請隔行輸入)');
define('_MD_INTROTEXT', '大綱');
define('_MD_EXTEXT', '詳細介紹');
define('_MD_EVENT_STYLE', '編輯形式');
define('_MD_RESERV_SETTING', '審核方式');
define('_MD_RESERV_DESC', '開啓報名表');
define('_MD_RESERV_STOPFULL', '報名人數滿時，是否停止報名');
define('_MD_RESERV_AUTO', '自動受理報名 (沒有審核)');
define('_MD_RESERV_NOTIFYPOSTER', '當有人報名時，用電子郵件通知');
define('_MD_RESERV_UNIT', '');
define('_MD_RESERV_ITEM', '<br>追加項目：');
define('_MD_RESERV_LAB','項目名');
define('_MD_RESERV_LABREQ','請輸入項目的名稱');
define('_MD_RESERV_REQ','所需');
define('_MD_RESERV_ADD','補充');
define('_MD_RESERV_OPTREQ','需要選項的說法');
define('_MD_RESERV_ITEM_DESC', '<a href="language/tchinese/help.html#form" target="help">編輯欄位方法</a>');
define('_MD_RESERV_LABEL_DESC', '如果是團體報名，要讓報名者填入人數，請使用這個欄位表示"%s"。');
define('_MD_OPTION_VARS','期權變量');
define('_MD_OPTION_OTHERS','其他');
define('_MD_RESERV_REDIRECT', '報名完成後，指定某一個網站連結');
define('_MD_RESERV_REDIRECT_DESC', '幾秒後開啟連結.請輸入數字，範例： "4;http://...  "。変数: {X_EID}, {X_SUB}, {X_RVID}');
define('_MD_APPROVE', '審核顯示');
define('_MD_PREVIEW', '預覽');
define('_MD_SAVE', '儲存');
define('_MD_UPDATE', '更新');
define('_MD_DBUPDATED', '資料庫更新');
define('_MD_DBDELETED', '已刪除活動');

define('_MD_EVENT_DEL_DESC', '注意：刪除這個活動');
define('_MD_EVENT_DEL_ADMIN', '將刪除所有資料與報名者資料');

define('_MD_TIMEC', '幾時開始');
// Localization Transrate Month name
global $ev_month;
$ev_month = array("Jan"=>"一月", "Feb"=>"二月", "Mar"=>"三月", "Apr"=>"四月",
		  "May"=>"五月", "Jun"=>"六月", "Jul"=>"七月", "Aug"=>"八月",
		  "Sep"=>"九月", "Oct"=>"十月", "Nov"=>"十一月", "Dec"=>"十二月");

define('_MD_RESERV_DEFAULT_ITEM', '姓名*,size=40\n連絡地址\n');
define('_MD_RESERV_DEFAULT_MEMBER', '');

// notification message
define('_MD_APPROVE_REQ', '請確認這個活動並審核它');
//%%%%%%	File Name sendinfo.php 	%%%%%
define('_MD_INFO_TITLE', '通知活動報名人員');
define('_MD_INFO_CONDITION', '郵寄到');
define('_MD_INFO_NODATA', '沒有資料');
define('_MD_INFO_SELF', '寄一份備份給自己(管理人%s)');
define('_MD_INFO_DEFAULT', '-訊息內容-\n\n\n預約活動\n {EVENT_URL}\n');
define('_MD_INFO_MAILOK', '已成功寄出');
define('_MD_INFO_MAILNG', '傳送失敗');
define("_MD_UPDATE_SUBJECT","事件更新");
define("_MD_UPDATE_DEFAULT","預設");

//%%%%%%	File Name print.php 	%%%%%

define('_MD_URLFOREVENT', '本活動內容網址：');
// %s represents your site name
define('_MD_THISCOMESFROM', '%s 可以取得更多活動訊息');

//%%%%%%	File Name mylist.php 	%%%%%
define('_MD_MYLIST', '我的活動清單');
define('_MD_CANCEL', '取消');
?>
