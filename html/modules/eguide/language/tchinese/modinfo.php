<?php
// $Id: modinfo.php,v 1.11 2010-10-10 06:30:12 nobu Exp $
// Module Info

if (defined('_MI_EGUIDE_NAME')) return;

// The name of this module
define('_MI_EGUIDE_NAME', '活動快訊');

// A brief description of this module
define('_MI_EGUIDE_DESC', '公佈活動快訊以及活動報名');

// Names of blocks for this module (Not all module has blocks)
define('_MI_EGUIDE_MYLIST', '．我已參加的活動清單');
define('_MI_EGUIDE_SUBMIT', '．新增活動訊息');
define('_MI_EGUIDE_COLLECT', '．活動內容管理');
define('_MI_EGUIDE_REG', '．登錄電子郵件通知');
define('_MI_EGUIDE_HEADLINE', '活動快訊');
define('_MI_EGUIDE_HEADLINE_DESC', '未來活動');
define('_MI_EGUIDE_HEADLINE2', '新活動');
define('_MI_EGUIDE_HEADLINE2_DESC', '最新活動訊息');
define("_MI_EGUIDE_HEADLINE3","成品活動");
define("_MI_EGUIDE_HEADLINE3_DESC","事件已經結束名單");
define("_MI_EGUIDE_CATBLOCK","活動分類");
define("_MI_EGUIDE_CATBLOCK_DESC","選擇活動分類");

define('_MI_EGUIDE_EVENTS', '活動內容設定');
define('_MI_EGUIDE_NOTIFIES', '提醒新註冊會員');
define('_MI_EGUIDE_CATEGORY', '活動分類');
define('_MI_EGUIDE_SUMMARY', '報名總數');
define('_MI_EGUIDE_CATEGORY_MARK', '分類-');
define('_MI_EGUIDE_ABOUT', '關於活動快訊');

// Configuration variable for this module
define('_MI_EGUIDE_POSTGROUP', '可以新增活動的群組');
define('_MI_EGUIDE_POSTGROUP_DESC', '選擇一個群組，可以管理自己新增的活動');
define('_MI_EGUIDE_NOTIFYADMIN', '提醒管理者');
define('_MI_EGUIDE_NOTIFYADMIN_DESC', '有新的資訊時會以電子郵件通知活動管理者');
define("_MI_EGUIDE_NOTIFY_ALWAYS","全件通知");
define('_MI_EGUIDE_NOTIFYGROUP', '提醒管理群');
define('_MI_EGUIDE_NOTIFYGROUP_DESC', '這個群組將會收到管理者提醒電子郵件');
define('_MI_EGUIDE_NEEDPOSTAUTH', '您需要審核新的活動嗎?');
define('_MI_EGUIDE_NEEDPOSTAUTH_DESC', '新的活動需要被網站管理員審核');
define('_MI_EGUIDE_MAX_LISTITEM', '顯示清單裏的其它選');
define('_MI_EGUIDE_MAX_LISTITEM_DESC', '以額外的表單顯示項目');
define('_MI_EGUIDE_MAX_LISTLINES', '以頁面清單顯示項目');
define('_MI_EGUIDE_MAX_LISTLINES_DESC', '一個頁面要顯示幾個項目');
define('_MI_EGUIDE_MAX_EVENT', '在最上頁顯示活動訊息');
define('_MI_EGUIDE_MAX_EVENT_DESC', '首頁要顯示的活動數量');
define('_MI_EGUIDE_SHOW_EXTENTS', '顯示多筆資料');
define('_MI_EGUIDE_SHOW_EXTENTS_DESC', '當有多個活動選項時，將每個活動選項打勾，請選是，選擇否，只勾選目前所選的選項');
define('_MI_EGUIDE_USER_NOTIFY', '使用者是否能夠訂閱新活動的通知');
define('_MI_EGUIDE_USER_NOTIFY_DESC', '是 - 啟用郵件通知，否 - 停用');
define('_MI_EGUIDE_MEMBER', '要檢視這個頁面的資料請先登入');
define('_MI_EGUIDE_MEMBER_DESC', '只有註冊/登入的使用者可以進行活動預約（或是在不使用郵件的前提下）');
define("_MI_EGUIDE_MEMBER_RELAX","兩者都使用");
define('_MI_EGUIDE_ORDERCONF', '是否要確認頁面？');
define('_MI_EGUIDE_ORDERCONF_DESC', '當報名時，顯示報名確認頁');
define('_MI_EGUIDE_CLOSEBEFORE', '預設報名活動在幾分鐘前關閉');
define('_MI_EGUIDE_CLOSEBEFORE_DESC', '活動的資訊在截止前幾分鐘關閉');
define('_MI_EGUIDE_LAB_PERSONS', '增列項目的選項');
define('_MI_EGUIDE_LAB_PERSONS_DESC', '增列項目，可選設置，就像一個領域的標籤有多少人，單位：人。例如：label_persons=團體報名(人)');
define('_MI_EGUIDE_DATE_FORMAT', '日期格式');
define('_MI_EGUIDE_DATE_FORMAT_DESC', '活動開始時間顯示格式，使用 PHP date 函式。');
define('_MI_EGUIDE_DATE_FORMAT_DEF', 'Y-m-d');
define('_MI_EGUIDE_EXPIRE_AFTER', '預設活動時間');
define('_MI_EGUIDE_EXPIRE_AFTER_DESC', '這個活動有多少時間，當時間超過後，該活動將視為過期。單位：分鐘');
define('_MI_EGUIDE_PERSONS', '預設名額');
define('_MI_EGUIDE_PERSONS_DESC', '預設活動名額');
define('_MI_EGUIDE_PLUGINS', '使用其他模組外掛');
define('_MI_EGUIDE_PLUGINS_DESC', '控制是否接受來自其他模組的資料');
define('_MI_EGUIDE_COMMENT', '允許評論');
define('_MI_EGUIDE_COMMENT_DESC', '允許活動的評論');
define('_MI_EGUIDE_MARKER', '活動狀態標示');
define('_MI_EGUIDE_MARKER_DESC', '這個標示會根據目前報名人數顯示，可以使用百分比標示。（xx,yy 表示人數少於 xx% 時顯示 yy ，而 \'0,yy\' 表示過期）');
define('_MI_EGUIDE_MARKER_DEF', '0,[關閉中],50,[報名中],100,[反應熱烈],101,[已額滿]');
define('_MI_EGUIDE_TIME_DEFS', '時間表');
define('_MI_EGUIDE_TIME_DEFS_DESC', '在集合頁面設定開始時間，例如：08:00,14:00,16:00');
define('_MI_EGUIDE_EXPORT_LIST', '匯出預約資料列表');
define('_MI_EGUIDE_EXPORT_LIST_DESC', '以項目名稱或數字組合的逗點分隔字串，星號(*) 表示剩下時間，例如： 3,4,0,2,*');
// Templates
define('_MI_EGUIDE_INDEX_TPL', '活動清單');
define('_MI_EGUIDE_EVENT_TPL', '活動詳細內容');
define('_MI_EGUIDE_ENTRY_TPL', '預約資料');
define('_MI_EGUIDE_EVENT_PRINT_TPL', '列印活動細節');
define('_MI_EGUIDE_RECEIPT_TPL', '報名名單');
define('_MI_EGUIDE_ADMIN_TPL', '活動表格');
define('_MI_EGUIDE_RECEIPT_PRINT_TPL', '列印報名名單');
define('_MI_EGUIDE_EVENT_ITEM_TPL', '顯示活動項目');
define('_MI_EGUIDE_EVENT_CONF_TPL', '活動確認表格');
define('_MI_EGUIDE_EVENT_LIST_TPL', '備取活動名單');
define('_MI_EGUIDE_EVENT_CONFIRM_TPL', '報名確認');
define('_MI_EGUIDE_EDITDATE_TPL', '編輯活動開始日期');
define('_MI_EGUIDE_COLLECT_TPL', '預約設定集合');
define('_MI_EGUIDE_EXCEL_TPL', '匯出 Excel (XML) 檔案格式');

// Notifications
define('_MI_EGUIDE_GLOBAL_NOTIFY', '全域');
define('_MI_EGUIDE_GLOBAL_NOTIFY_DESC', '全域通知提醒');
define('_MI_EGUIDE_CATEGORY_NOTIFY', '目前分類');
define('_MI_EGUIDE_CATEGORY_NOTIFY_DESC', '分類通知提醒');
define('_MI_EGUIDE_CATEGORY_BOOKMARK', '目前活動');
define('_MI_EGUIDE_CATEGORY_BOOKMARK_DESC', '目前活動提醒');

define('_MI_EGUIDE_NEWPOST_SUBJECT', '新活動-{EVENT_DATE}{EVENT_TITLE}');
define('_MI_EGUIDE_NEWPOST_NOTIFY', '新增一個活動');
define('_MI_EGUIDE_NEWPOST_NOTIFY_CAP', '當新的活動增加時提醒我');
define('_MI_EGUIDE_CNEWPOST_NOTIFY', '在分類裏新增一個活動');
define('_MI_EGUIDE_CNEWPOST_NOTIFY_CAP', '在分類裏新增一個活動時提醒我');

// for altsys
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Templates');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Blocks/Permissions');
    define('_MD_A_MYMENU_MYLANGADMIN','Languages');
    define('_MD_A_MYMENU_MYPREFERENCES','Preferences');
}
?>
