<?php
// $Id: modinfo.php,v 1.12 2010-10-10 06:30:12 nobu Exp $
// Module Info
// German language files by El Cario www.el-cario.de

if (defined('_MI_EGUIDE_NAME')) return;

// The name of this module
define("_MI_EGUIDE_NAME","Veranstaltungskalender");

// A brief description of this module
define("_MI_EGUIDE_DESC","Veranstaltungskalender mit Online-Reservierung");

// Names of blocks for this module (Not all module has blocks)
define("_MI_EGUIDE_MYLIST","Meine Reservierungen");
define("_MI_EGUIDE_SUBMIT","Neue Veranstaltung eintragen");
define("_MI_EGUIDE_COLLECT","Sammeleinstellungen");
define("_MI_EGUIDE_REG","Bei neuen Veranstaltungen benachrichtigen");
define("_MI_EGUIDE_HEADLINE","Veranstaltungskalender");
define("_MI_EGUIDE_HEADLINE_DESC","Nächste Veranstaltungen");
define("_MI_EGUIDE_HEADLINE2","Neue Veranstaltungen");
define("_MI_EGUIDE_HEADLINE2_DESC","neu eingetragene Veranstaltungen");
define("_MI_EGUIDE_HEADLINE3","Abgeschlossene Veranstaltungen");
define("_MI_EGUIDE_HEADLINE3_DESC","Event Liste der bereits fertig");
define("_MI_EGUIDE_CATBLOCK","Event Kategorie");
define("_MI_EGUIDE_CATBLOCK_DESC","CWählen Sie Event-Kategorie");

define("_MI_EGUIDE_EVENTS","Veranstaltungen bearbeiten");
define("_MI_EGUIDE_NOTIFIES","Benachrichtigen bei neuen Veranstaltungen");
define("_MI_EGUIDE_CATEGORY","Kategorien");
define("_MI_EGUIDE_SUMMARY","Reservierungsliste");
define("_MI_EGUIDE_CATEGORY_MARK","-> ");
define("_MI_EGUIDE_ABOUT","mehr über eguide");

// Configuration variable for this module
define("_MI_EGUIDE_POSTGROUP","Gruppen");
define("_MI_EGUIDE_POSTGROUP_DESC","Wer darf eigene Veranstaltungen bearbeiten.");
define("_MI_EGUIDE_NOTIFYADMIN","Benachrichtigung an den Admin");
define("_MI_EGUIDE_NOTIFYADMIN_DESC","Sollen Benachrichtigungen versendet werden");
define("_MI_EGUIDE_NOTIFY_ALWAYS","Immer");
define("_MI_EGUIDE_NOTIFYGROUP","Gruppe der Benachrichtigung");
define("_MI_EGUIDE_NOTIFYGROUP_DESC","Diese Gruppe ist Empfänger der Benachrichtigungen");
define("_MI_EGUIDE_NEEDPOSTAUTH","Bestätigen lassen");
define("_MI_EGUIDE_NEEDPOSTAUTH_DESC","Neue Veranstaltung durch Admin bestätigen lassen");
define("_MI_EGUIDE_MAX_LISTITEM","Zusätzliche Felder Teilnehmerliste");
define("_MI_EGUIDE_MAX_LISTITEM_DESC","Wievile zusätzliche Felder sollen in der Teilnehmerliste angezeigt werden");
define("_MI_EGUIDE_MAX_LISTLINES","Veranstaltungen in Liste");
define("_MI_EGUIDE_MAX_LISTLINES_DESC","Wie viele Veranstaltungen sollen in der Liste angezeigt werden");
define("_MI_EGUIDE_MAX_EVENT","Veranstaltungen auf Hauptseite");
define("_MI_EGUIDE_MAX_EVENT_DESC","Wieviele Veranstaltungen sollen in der Veranstaltungsübersicht angezeigt werden");
define("_MI_EGUIDE_SHOW_EXTENTS","Als Liste anzeigen");
define("_MI_EGUIDE_SHOW_EXTENTS_DESC","Wann JA - als Liste. Nein - Es werden alle Events einzeln angezeigt");
define("_MI_EGUIDE_USER_NOTIFY","Ja - Benachrichtigung aktivieren, Nein - deaktivieren.");
define("_MI_EGUIDE_USER_NOTIFY_DESC","Usern erlauben Benachrichtgungen über neue Veranstaltungen zu ehalten");
define("_MI_EGUIDE_MEMBER","Nur registrierte User können reservieren");
define("_MI_EGUIDE_MEMBER_DESC","Nur eingeloggte und registrierte User können reservieren");
define("_MI_EGUIDE_MEMBER_RELAX","Beide");
define("_MI_EGUIDE_ORDERCONF","Bestätigungsseite");
define("_MI_EGUIDE_ORDERCONF_DESC","Bestätigungsseite nach Reservierung anzeigen");
define("_MI_EGUIDE_CLOSEBEFORE","Schlusszeit (min)");
define("_MI_EGUIDE_CLOSEBEFORE_DESC","Zeit vor Beginn der Veranstaltung, in der keine Reservierungen mehr angenommen werden");
define("_MI_EGUIDE_LAB_PERSONS","Zusätzliche Optionen Posten");
define("_MI_EGUIDE_LAB_PERSONS_DESC","Zusätzliche Posten zusätzliche optionale Einstellungen, wie ein Feldbezeichnung für wie viele Personen. (z.B. 'label_persons=Anzahl Tickets')");
define("_MI_EGUIDE_DATE_FORMAT","Datumsformat");
define("_MI_EGUIDE_DATE_FORMAT_DESC","Eröffnungstermin Datum(Zeit) Anzeigeformat. Using PHP date function format.");
define("_MI_EGUIDE_DATE_FORMAT_DEF","D, d M Y");
define("_MI_EGUIDE_EXPIRE_AFTER","Ablaufzeit");
define("_MI_EGUIDE_EXPIRE_AFTER_DESC","Event gilt auf Startseite als abgelaufen, wenn Startzeit ist früher als in x Minuten");
define("_MI_EGUIDE_PERSONS","Weitere Artikel Optionen");
define("_MI_EGUIDE_PERSONS_DESC","Weitere Artikel optionsAdditional Artikel optionale Einstellungen, wie ein Feld Label für wie viele Personen. Beispiel: 'label_persons=Personen'. Siehe <a href=\"../../eguide/admin/help.php#form_options\">etwa eGuide Seite</a> weitere Informationen zu erhalten.");
define("_MI_EGUIDE_PLUGINS","Andere Module");
define("_MI_EGUIDE_PLUGINS_DESC","Sollen andere Module auf eGuide zugreifen dürfen");
define("_MI_EGUIDE_COMMENT","Kommentare erlauben");
define("_MI_EGUIDE_COMMENT_DESC","Kommentare zu den Veranstaltungen erlauben");
define("_MI_EGUIDE_MARKER","Verfügbarkeitsinformation");
define("_MI_EGUIDE_MARKER_DESC","Gibt an bis zu welchem prozentualen Wert an schon reservierten Tickets welche Information angezeigt wird.(xx,[text] zeigt den Text bei weniger als xx%  '0,[text]' zeigt den Text wenn Veranstaltung in der Vergangenheit)");
define("_MI_EGUIDE_MARKER_DEF","0,[geschlossen]\n50,[viele Plätze verfügbar]\n100,[noch einige Plätze verfügbar]\n101,[Ausverkauft]\n");
define("_MI_EGUIDE_TIME_DEFS","Zeittabellenbeschriftung");
define("_MI_EGUIDE_TIME_DEFS_DESC","Set starting time in Settings collection page. e.g.: 08:00,14:00,16:00");
define("_MI_EGUIDE_EXPORT_LIST","Item List in export reservation");
define("_MI_EGUIDE_EXPORT_LIST_DESC","Item `name' or `number' seperated comma(,). Astarisk(*) mean left items. e.g.: 3,4,0,2,*");
// Templates
define("_MI_EGUIDE_INDEX_TPL", "Event Guide Top page list");
define("_MI_EGUIDE_EVENT_TPL", "Details des Events");
define("_MI_EGUIDE_ENTRY_TPL", "Reservierungseintrag");
define("_MI_EGUIDE_EVENT_PRINT_TPL", "Detail of Event for Print");
define("_MI_EGUIDE_RECEIPT_TPL", "Reservierungsliste");
define("_MI_EGUIDE_ADMIN_TPL", "Event Entry Form");
define("_MI_EGUIDE_RECEIPT_PRINT_TPL", "Reservations List for Print");
define("_MI_EGUIDE_EVENT_ITEM_TPL", "Item of Event Showup");
define("_MI_EGUIDE_EVENT_CONF_TPL", "Event Confirmation Form");
define("_MI_EGUIDE_EVENT_LIST_TPL", "Reserved Event List");
define("_MI_EGUIDE_EVENT_CONFIRM_TPL", "Reservierungsbestätigung");
define("_MI_EGUIDE_EDITDATE_TPL", "Eröffnungsdatum bearbeiten");
define("_MI_EGUIDE_COLLECT_TPL", "Reservierungssammel Einstellungen");
define("_MI_EGUIDE_EXCEL_TPL", "Excel (XML) file format in exporting");

// Notifications
define('_MI_EGUIDE_GLOBAL_NOTIFY', 'Globale Benachrichtigungen');
define('_MI_EGUIDE_GLOBAL_NOTIFY_DESC', 'Benachrichtigungen im Veranstaltungskalender');
define('_MI_EGUIDE_CATEGORY_NOTIFY', 'Aktuelle Kategorie');
define('_MI_EGUIDE_CATEGORY_NOTIFY_DESC', 'Benachrichtigung in dieser Kategorie');
define('_MI_EGUIDE_CATEGORY_BOOKMARK', 'Aktuelle Veranstaltung');
define('_MI_EGUIDE_CATEGORY_BOOKMARK_DESC', 'Benachrichtigung für diese Veranstaltung');

define('_MI_EGUIDE_NEWPOST_SUBJECT', 'Neue Veranstaltung - {EVENT_DATE} {EVENT_TITLE}');
define('_MI_EGUIDE_NEWPOST_NOTIFY', 'Neue Veranstaltung eingetragen');
define('_MI_EGUIDE_NEWPOST_NOTIFY_CAP', 'Benachrichtigen, wenn neue Veranstaltung eingetragen');
define('_MI_EGUIDE_CNEWPOST_NOTIFY', 'Neue Veranstaltung in dieser Kategorie eingetragen');
define('_MI_EGUIDE_CNEWPOST_NOTIFY_CAP', 'Benachrichtigen, wenn neue Veranstaltung in dieser Kategorie eingetragen wird');

// for altsys
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Templates');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Modul-Blöcke');
    define('_MD_A_MYMENU_MYLANGADMIN','Sprachen');
    define('_MD_A_MYMENU_MYPREFERENCES','Preferences');
}
?>
