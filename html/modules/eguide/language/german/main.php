<?php
// $Id: main.php,v 1.17 2010-10-10 06:30:12 nobu Exp $
// German language files by El Cario www.el-cario.de

if (defined('_MD_RESERV_FORM')) return;

define("_MD_RESERV_FORM","Jetzt Tickets reservieren...");
define("_MD_RESERVATION","Jetzt Tickets reservieren");
define("_MD_NAME","/^Name\\*?\$/");
define('_MD_SDATE_FMT', 'd.m.Y');
define('_MD_STIME_FMT', 'H:i');
// Localization Transrate Weekly date name
global $ev_week;
$ev_week = array('Sun'=>'Son', 'Mon'=>'Mon','Tue'=>'Die', 'Wed'=>'Mit','Thu'=>'Don','Fri'=>'Fre', 'Sam'=>'A');
define('_MD_UNAME','Benutzername');
define("_MD_POSTED_FMT", "d.m.Y H:i");
define("_MD_TIME_FMT", "d.m.Y H:i");
define("_MD_READMORE","Lesen Sie Mehr...");
define("_MD_EMAIL","Email Addresse");
define("_MD_EMAIL_CONF","E-Mail abrufen");
define('_MD_EMAIL_CONF_DESC','Bitte geben Sie Ihre E-Mail Adresse zur Bestätigung erneut');
define("_MD_SUBJECT","Bestätigung - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_NOTIFY_EVENT",  "Benachrichtigung über neue Veranstaltungen erhalten");
define("_MD_NOTIFY_REQUEST", "Benachrichtigen Sie mich, wenn weitere Veranstaltungen stattfinden");
define('_MD_REQUIRE_MARK','*');
define('_MD_LISTITEM_FMT', '[%s]');
define("_MD_ORDER_NOTE1",_MD_REQUIRE_MARK." = Pflichtfelder müssen ausgefüllt sein");
define("_MD_ORDER_NOTE2","'[ ]' Felder werden auf öffentlicher Bestellseite für jeden angezeigt");
define("_MD_ORDER_SEND","Reservierung");
define('_MD_ORDER_CONF','Bestätigen');

define("_MD_EVENT_NONE","Es gibt derzeit keine Veranstaltungshinweise");
define("_MD_BACK","Zurück");
define("_MD_RESERVED","Sie haben für diese Veranstaltung bereits reserviert! Vielen Dank");
define("_MD_RESERV_NUM","Max. %d Plätze verfügbar ");
define("_MD_RESERV_REG","%d Plätze sind schon reserviert");
define("_PRINT", "Drucken");

define("_MD_NOITEM_ERR","Bitte geben sie einen Wert ein.");
define("_MD_NUMITEM_ERR","muss eine Zahl sein");
define("_MD_MAIL_ERR","E-Mail Adresse ist falsch");
define('_MD_MAIL_CONF_ERR','Bestätigen Sie E-Mail Adresse nicht überein');
define("_MD_SEND_ERR","Fehler beim Senden der E-Mail");
define("_MD_DUP_ERR","Wir haben auf diese E-Mail Adresse bereits reservierte Plätze");
define("_MD_DUP_REGISTER","Sie werden bereits über kommende Veranstaltungen informiert");
define("_MD_REGISTERED","Benachrichtigung per E-Mail aktiviert");
define('_MD_DATE_ERR','Dieses Datum ist ungültig');
define('_MD_DATEDELETE_ERR','Datum nicht verändern, es liegen Reservierungen vor!');


define("_MD_RESERV_ACCEPT","Bestätigungsmail versendet");
define("_MD_RESERV_STOP","Onlinereservierungen derzeit für diese Veranstaltungen nicht möglich");
define("_MD_RESERV_CONF","Bestellinformationen");
define("_MD_RESERV_ADMIN","Reservierungsliste");
define("_MD_RESERV_REGISTER","Register reservation");

define("_AM_MAILGOOD","Erfolg: %s");
define("_AM_SENDMAILNG","Fortschritt: %s");

define("_MD_RESERV_ACTIVE"," wurde akzeptiert.");
define("_MD_RESERV_REFUSE"," wurde abgelehnt.");


define("_MD_RESERV_NOTFOUND","Keine Reservierung vorhanden oder bereits zurück gezogen.");
define("_MD_RESERV_CANCEL","Wollen Sie die Reservierung wirklich stornieren?");
define("_MD_RESERV_CANCELED","Reservierung wurde erfolgreich storniert");
define("_MD_RESERV_NOTIFY","%s\n\nBestell Email: %s\nReservierte Veranstaltung: %s\n  %s\n");
define("_MD_RESERV_FULL","Onlinereservierungen nicht mehr möglich, da keine freien Plätze mehr verfügbar sind. Bitte Fragen Sie telefonisch nach Restkarten oder besuchen Sie die Abendkasse.");
define('_MD_RESERV_PLUGIN_FAIL','Für Ihren Reservierungswunsch sind nicht genügend freie Plätze vorhanden!');
define("_MD_CANCEL_FAIL","Stornieren fehlgeschlagen");
define('_MD_CANCEL_SUBJ','Stornieren - {EVENT_DATE} {EVENT_TITLE}');
define("_MD_NODATA","Noch nix reserviert? Da dann nix wie ran... Event raussuchen und gleich noch einen Platz sichern!");
define("_MD_NOEVENT","Neue Veranstaltung auf der Liste");
define("_MD_SHOW_PREV","letzte Veranstaltungen");
define("_MD_SHOW_NEXT","nächste Veranstaltungen");
define("_MD_RESERV_NOCANCEL","Resvervierung konnte nicht storniert werden");
define('_MD_RESERV_TOMATCH',' %d sind zu viele (%d noch verfügbar)');
define('_MD_RESERV_CLOSE','Reservierungen leider nicht mehr möglich');
define('_MD_RESERV_NEEDLOGIN','Sie müssen sich <a href="'.XOOPS_URL.'/user.php">erst einloggen</a>!');

define("_MD_POSTERC","Eingetragen von");
define('_MD_POSTDATE','am');
define('_MD_STARTTIME','Startzeit');
define('_MD_CLOSEDATE','Online Reservierung möglich bis:');
define('_MD_CLOSEBEFORE','Reservierungsende (x Minuten vor Veranstaltungsbeginn');
define('_MD_CLOSEBEFORE_DESC','vor dem Start (e.g.: 3days, 2hour, 50min)');
define('_MD_TIME_UNIT','days,hour,min');
define('_MD_TIME_REG','d(ay)?s?,h(our)?,min');
define('_MD_CALENDAR','Kalender anzeigen');
define('_MD_CAL','Kalender');
define('_MD_CAL_MONDAY_FIRST', true);
define("_MD_REFER","%d Aufrufe");
define("_MD_RESERV_LIST","Reservierungsliste");

define('_MD_NEED_UPGRADE','Modul muss upgedated werden!');

//%%%%%%	File Name receiept.php 	%%%%%
define("_MD_RESERV_EDIT","Reservierungen bearbeiten");
define("_MD_OPERATION","Aktion");
define("_MD_STATUS","Status");
define("_MD_RESERV_RETURN","Zurück zur Liste");
define("_MD_RESERV_REC","Eingetragene Reservierungen");
define("_MD_RVID","Buchungsnummer");
define("_MD_ORDER_COUNT","Anzahl");
define("_MD_PRINT_DATE","Ausdruck am");
define("_MD_SAVECHANGE","Änderungen speichern");
define("_MD_RESERV_DEL","Reservierung löschen");
define("_MD_DETAIL","Details");
define("_MD_RESERV_MSG","{TITLE}\n{EVENT_URL}\n
Reservierung Nummer {RVID} {RESULT}\n
Bestellinformation:
------------
{INFO}------------\n
Bestätigt durch {REQ_UNAME}\n
Falls Sie die Bestellung stornieren möchten klicken Sie bitte hier:
  {CANCEL_URL}
");

define("_MD_RESERV_MSG_H","Sende Nachricht für die Reservierung");
define("_MD_ACTIVATE","Reservierungsbestätigung");
define("_MD_REFUSE","Reservierung wurde nicht akzeptiert");
define("_MD_EXPORT_OUT","Als Excel exportieren");
define("_MD_INFO_MAIL","Sende Email");
define("_MD_SUMMARY","Zusammenfassung");
define("_MD_SUM_ITEM","Feld");
define("_MD_SUM","Summe");
define('_MD_EXPORT_CHARSET', 'UTF-8');

//%%%%%%	File Name admin.php 	%%%%%
define("_MD_EDITARTICLE","Veranstaltung bearbeiten");
define("_MD_NEWTITLE","Neue Veranstaltung");
define("_MD_NEWSUB","Neue Veranstaltung - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_TITLE","Titel");
define("_MD_EVENT_DATE","Datum");
define("_MD_EVENT_EXPIRE","Enddatum anzeigen");
define('_MD_EVENT_EXTENT','Wiederholung der Veranstaltung');
define('_MD_EVENT_CATEGORY','Kategorie');
define('_MD_EDIT_EXTENT','Startdatum bearbeiten');
define('_MD_EXTENT_REPEAT','Repeats');
define('_MD_ADD_EXTENT','Startdatum hinzufügen');
define('_MD_ADD_EXTENT_DESC','Zusätzliches Startdatum mit Zeit "JJJJ-MM-TT HH:MM" Format hinzufügen (Mehrfacheintrag in neue Zeile)');
define("_MD_INTROTEXT","Einleitung");
define("_MD_EXTEXT","Beschreibung");
define("_MD_EVENT_STYLE","Ausgabeformat");
define('_MD_RESERV_SETTING','Reservierung');
define("_MD_RESERV_DESC","Reservierungen erlauben");
define('_MD_RESERV_STOPFULL','Reservierungen stoppen wenn Plätze ausgebucht');
define("_MD_RESERV_AUTO","Automatisches Erlauben von Reservierungen (keine Bestätigung mehr nötig)");
define('_MD_RESERV_NOTIFYPOSTER','Bei Reservierung per mail benachrichtigen');
define('_MD_RESERV_UNIT','');
define('_MD_RESERV_ITEM','zusätzliche Felder');
define('_MD_RESERV_LAB','Item Namen');
define('_MD_RESERV_LABREQ','Bitte geben Sie Name item');
define('_MD_RESERV_REQ','Erforderlich');
define('_MD_RESERV_ADD','Hinzufügen');
define('_MD_RESERV_OPTREQ','Need Option Argument');
define('_MD_RESERV_ITEM_DESC','<a href="language/english/help.html#form" target="help">Zur Hilfe (englisch)</a>');
define('_MD_RESERV_LABEL_DESC','Use item name "%s" if multiple persons reservation.');
define('_MD_OPTION_VARS','Option Variablen');
define('_MD_OPTION_OTHERS','Andere');
define('_MD_RESERV_REDIRECT','Redirect After Reservation URL');
define('_MD_RESERV_REDIRECT_DESC','Set a number waiting seconds (e.g.: "4;http://..."). variables: {X_EID}, {X_SUB}, {X_RVID}');
define('_MD_APPROVE','Anerkannte anzeigen');
define('_MD_PREVIEW','Vorschau');
define('_MD_SAVE','speichern');
define('_MD_UPDATE','aktualisieren');
define('_MD_DBUPDATED','Datenbank aktualisiert');
define('_MD_DBDELETED','Veranstaltung gelöscht');

define('_MD_EVENT_DEL_DESC','diese Veranstaltung löschen');
define('_MD_EVENT_DEL_ADMIN','Alle Daten löschen (auch bereits getätigte Reservierungen)');

define('_MD_TIMEC','Zeit');
// Localization Transrate Month name
global $ev_month;
$ev_month = array("Jan"=>"Jan", "Feb"=>"Feb", "Mar"=>"Mär", "Apr"=>"Apr",
		  "May"=>"Mai", "Jun"=>"Jun", "Jul"=>"Jul", "Aug"=>"Aug",
		  "Sep"=>"Sep", "Oct"=>"Okt", "Nov"=>"Nov", "Dec"=>"Dez");

define('_MD_RESERV_DEFAULT_ITEM',"Name*\nAdresse\nTelefonnummer\nAnzahl Tickets*,select,1,2,3,4,5,6");
define('_MD_RESERV_DEFAULT_MEMBER',"");

// notification message
define('_MD_APPROVE_REQ','Bitte bestätigen Sie die Veranstaltung');
define('_MD_ADMIN_NOTIFY_NEW',"Neue Veranstaltung eingetragen.\n
Datum: {EVENT_DATE}\n
Titel: {EVENT_TITLE}\n
{EVENT_URL}\n
{EVENT_NOTE}");

define('_MD_NOTIFY_NEW',"{SITENAME}\n
Hiermit werden Sie über eine neue Veranstaltung informiert!\n
\n
{TITLE}\n
  Link zum Eintrag: {EVENT_URL}\n
\n  
Wenn sie zukünftig nicht mehr benachrichtigt werden wollen, folgen sie bitte diesem Link:\n
  {CANCEL_URL}\n
");

//%%%%%%	File Name sendinfo.php 	%%%%%
define("_MD_INFO_TITLE","Inhalt der ausgehenden E-Mail");
define("_MD_INFO_CONDITION","Gesendet an");
define("_MD_INFO_NODATA","Keine Einträge");
define("_MD_INFO_SELF","An eigene Email-Adresse senden (%s)");
define("_MD_INFO_DEFAULT","-bitte hier den Text eingeben-\n\n\nReservierte Veranstaltung\n    {EVENT_URL}\n");
define("_MD_INFO_MAILOK","Email gesendet");
define("_MD_INFO_MAILNG","Email konnte nicht gesendet werden");
define("_MD_UPDATE_SUBJECT","Event Aktualisiert");
define("_MD_UPDATE_DEFAULT","Default");

//%%%%%%	File Name print.php 	%%%%%

define("_MD_URLFOREVENT","URL der Veranstaltung:");
// %s represents your site name
define("_MD_THISCOMESFROM","Weitere Informationen %s");

//%%%%%%	File Name mylist.php 	%%%%%
define('_MD_MYLIST','Meine Reservierungen');
define('_MD_CANCEL','Stornieren');
?>