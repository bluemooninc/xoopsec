<?php
// $Id: main.php,v 1.28 2010-10-10 06:30:12 nobu Exp $

if (defined('_MD_RESERV_FORM')) return;

define("_MD_RESERV_FORM","Reservation Here");
define("_MD_RESERVATION","Make a Reservation");
define("_MD_NAME","/^Name\\*?\$/");
define('_MD_SDATE_FMT', 'D, j M Y');
define('_MD_STIME_FMT', 'H:i');
// Localization Transrate Weekly date name
//global $ev_week;
//$ev_week = array('Sun'=>'S', 'Mon'=>'M','Tue'=>'T', 'Wed'=>'W','Thu'=>'U','Fri'=>'F', 'Sat'=>'A');
define("_MD_POSTED_FMT", "j M Y H:i");
define("_MD_TIME_FMT", "j M Y H:i");
define("_MD_READMORE","More...");
define("_MD_EMAIL","EMail Address");
define("_MD_EMAIL_CONF","Confirm EMail Address");
define('_MD_EMAIL_CONF_DESC','Please enter your email address again for confirmation');
define('_MD_UNAME','Username');
define("_MD_SUBJECT","Confirm - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_NOTIFY_EVENT",  "Notification of new events");
define("_MD_NOTIFY_REQUEST","Notify me by mail when other new events are posted");
define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_LISTITEM_FMT', '[%s]');
define("_MD_ORDER_NOTE1","'"._MD_REQUIRE_MARK."'required items. ");
define("_MD_ORDER_NOTE2","'[ ]' item to be displayed on list of participants.");
define('_MD_ORDER_SEND','Reservation');
define('_MD_ORDER_CONF','Go to Confirm');

define("_MD_EVENT_NONE","There is no event guide");
define("_MD_BACK","Back");
define("_MD_RESERVED","This is a reservation only");
define("_MD_RESERV_NUM","Max. no of Places %d");
define("_MD_RESERV_REG","Currently Reserved Places %d");
define("_PRINT", "Print");

define("_MD_NOITEM_ERR","No input, please enter a value.");
define("_MD_NUMITEM_ERR","Needs to be numeric");
define("_MD_MAIL_ERR","Mail address format error");
define('_MD_MAIL_CONF_ERR','Confirm email address do not match');
define("_MD_SEND_ERR","failed to send mail");
define("_MD_DUP_ERR","We have already reserved a place with your mail address");
define('_MD_DATE_ERR','The Date is out of range');
define('_MD_DATEDELETE_ERR','Stop remove the date, there is reservation exists');
define("_MD_DUP_REGISTER","Mail notification was already registered");
define("_MD_REGISTERED","Mail notification registered");

define("_MD_RESERV_ACCEPT","Sending confirmation email");
define("_MD_RESERV_STOP","Reservations have been halted.");
define("_MD_RESERV_CONF","Order information");
define("_MD_RESERV_ADMIN","Reservation list");
define("_MD_RESERV_REGISTER","Register reservation");

define("_MD_RESERV_ACTIVE"," is accepted.");
define("_MD_RESERV_REFUSE"," is refused.");

define("_AM_MAILGOOD","Success: %s");
define("_AM_SENDMAILNG","Failure: %s");

define("_MD_RESERV_NOTFOUND","No reservation or Allready cancelled.");
define("_MD_RESERV_CANCEL","Are you sure you want to cancel?");
define("_MD_RESERV_CANCELED","Event reservation has been canceled");
define("_MD_RESERV_NOCANCEL","Can't cancel reservation after close time");
define("_MD_RESERV_NOTIFY","%s\n\nOrdering Email: %s\nReservation Event: %s\n  %s\n");
define("_MD_RESERV_FULL","Reservations have been stopped, because the event is now fully booked.");
define('_MD_RESERV_TOMATCH',' %d is too match (%d left)');
define('_MD_RESERV_CLOSE','Finish reservation');
define('_MD_RESERV_NEEDLOGIN','You need <a href="'.XOOPS_URL.'/user.php">login</a>, when reservation this');
define('_MD_RESERV_PLUGIN_FAIL','Not enough condition for reservation');
define("_MD_CANCEL_FAIL","Failed to cancel");
define("_MD_NODATA","There is No Data");
define("_MD_NOEVENT","No Event Listed");
define("_MD_SHOW_PREV","Previous Events");
define("_MD_SHOW_NEXT","Upcoming Events");

define("_MD_POSTERC","Poster");
define('_MD_POSTDATE','Registered');
define('_MD_STARTTIME','Starting Event');
define('_MD_CLOSEDATE','Close Reservation');
define('_MD_CLOSEBEFORE','Close time before');
define('_MD_CLOSEBEFORE_DESC','before from start (e.g.: 3days, 2hour, 50min)');
define('_MD_TIME_UNIT','days,hour,min');
define('_MD_TIME_REG','d(ay)?s?,h(our)?,min');
define('_MD_CALENDAR','Go Calendar');
define('_MD_CAL','Calender');
define('_MD_CAL_MONDAY_FIRST', true);
define("_MD_REFER","%d hits");
define("_MD_RESERV_LIST","List of participants");

define('_MD_NEED_UPGRADE','Need to Proceed module Upgrade');

//%%%%%%	File Name receiept.php 	%%%%%
define("_MD_RESERV_EDIT","Edit Reservations");
define("_MD_OPERATION","Operation");
define("_MD_STATUS","Status");
define("_MD_RESERV_RETURN","Return to list");
define("_MD_RESERV_REC","Reservation Records");
define("_MD_RVID","Reservation ID");
define("_MD_ORDER_COUNT","Count");
define("_MD_PRINT_DATE","Print Date");
define("_MD_SAVECHANGE","Save Changes");
define("_MD_RESERV_DEL","Delete reservation");
define("_MD_DETAIL","Detail");
define("_MD_RESERV_MSG_H","Sending message for reservation");
define("_MD_ACTIVATE","Approved");
define("_MD_REFUSE","Refused");
define("_MD_EXPORT_OUT","Excel Format");
define('_MD_EXPORT_CHARSET', 'UTF-8');
define("_MD_INFO_MAIL","Sending Mail");
define("_MD_SUMMARY","Summary");
define("_MD_SUM_ITEM","Summary Item");
define("_MD_SUM","Sum");

//%%%%%%	File Name admin.php 	%%%%%
define("_MD_EDITARTICLE","Edit an Event");
define("_MD_NEWTITLE","New Event");
define("_MD_NEWSUB","New Event - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_TITLE","Title");
define("_MD_EVENT_DATE","Event Date Time");
define("_MD_EVENT_EXPIRE","Finish Display");
define('_MD_EVENT_EXTENT','Repeat Open');
define('_MD_EVENT_CATEGORY','Category');
define('_MD_EDIT_EXTENT','Edit Open Date');
define('_MD_EXTENT_REPEAT','Repeats');
define('_MD_ADD_EXTENT','Add Open Date');
define('_MD_ADD_EXTENT_DESC','Additional Open Date Time in "YYYY-MM-DD HH:MM" format (Multiple entry separate in newline)');
define("_MD_INTROTEXT","Introduction Text");
define("_MD_EXTEXT","Description");
define("_MD_EVENT_STYLE","Output Style");
define('_MD_RESERV_SETTING','Reservation');
define("_MD_RESERV_DESC","Allow reservations to proceed");
define('_MD_RESERV_STOPFULL','Stop reservations when limit reached');
define("_MD_RESERV_AUTO","Automatically accept reservations (No need approve)");
define('_MD_RESERV_NOTIFYPOSTER','Reservation notify by mail');
define('_MD_RESERV_UNIT','');
define('_MD_RESERV_ITEM','Additional Items');
define('_MD_RESERV_LAB','Item name');
define('_MD_RESERV_LABREQ','Please input item name');
define('_MD_RESERV_REQ','Required');
define('_MD_RESERV_ADD','Add');
define('_MD_RESERV_OPTREQ','Need option argument');
define('_MD_RESERV_ITEM_DESC','<a href="language/english/help.html#form" target="help">About Additional Items format</a>');
define('_MD_RESERV_LABEL_DESC','Use item name "%s" if multiple persons reservation.');
define('_MD_OPTION_VARS','Option Variables');
define('_MD_OPTION_OTHERS','Others');
define('_MD_RESERV_REDIRECT','Redirect After Reservation URL');
define('_MD_RESERV_REDIRECT_DESC','Set a number waiting seconds (e.g.: "4;http://..."). variables: {X_EID}, {X_SUB}, {X_RVID}');
define('_MD_APPROVE','Approve Display');
define('_MD_PREVIEW','Preview');
define('_MD_SAVE','save');
define('_MD_UPDATE','Update');
define('_MD_DBUPDATED','Database Updated');
define('_MD_DBDELETED','Event Deleted');

define('_MD_EVENT_DEL_DESC','Delete this event');
define('_MD_EVENT_DEL_ADMIN','Delete all data including reservations.');

define('_MD_TIMEC','Time');
// Localization Transrate Month name
//global $ev_month;
//$ev_month = array("Jan"=>"Jan", "Feb"=>"Feb", "Mar"=>"Mar", "Apr"=>"Apr",
//                  "May"=>"May", "Jun"=>"Jun", "Jul"=>"Jul", "Aug"=>"Aug",
//                  "Sep"=>"Sep", "Oct"=>"Oct", "Nov"=>"Nov", "Dec"=>"Dec");

define('_MD_RESERV_DEFAULT_ITEM',"Name*,size=40\nAddress\n");
define('_MD_RESERV_DEFAULT_MEMBER',"");

// notification message
define('_MD_APPROVE_REQ','Please confirm the event and Approve it.');
//%%%%%%	File Name sendinfo.php 	%%%%%
define("_MD_INFO_TITLE","Information Mail to Send");
define("_MD_INFO_CONDITION","Send to");
define("_MD_INFO_NODATA","No DATA");
define("_MD_INFO_SELF","send to self (%s)");
define("_MD_INFO_DEFAULT","-messages-\n\n\nReserved Event\n    {EVENT_URL}\n");
define("_MD_INFO_MAILOK","Mail sent");
define("_MD_INFO_MAILNG","Failed to send mail");
define("_MD_UPDATE_SUBJECT","Event Updated");
define("_MD_UPDATE_DEFAULT","Default");

//%%%%%%	File Name print.php 	%%%%%

define("_MD_URLFOREVENT","This event's URL:");
// %s represents your site name
define("_MD_THISCOMESFROM","More event information at %s");

//%%%%%%	File Name mylist.php 	%%%%%
define('_MD_MYLIST','Reservation Events');
define('_MD_CANCEL','Cancel');
define('_MD_CANCEL_SUBJ','Cancel - {EVENT_DATE} {EVENT_TITLE}');
?>
