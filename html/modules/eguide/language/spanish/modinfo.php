<?php
// $Id: modinfo.php,v 1.11 2010-10-10 06:30:12 nobu Exp $
// Module Info

if (defined('_MI_EGUIDE_NAME')) return;

// The name of this module
define("_MI_EGUIDE_NAME","Eventos");

// A brief description of this module
define("_MI_EGUIDE_DESC","Event Detail display and Reservation system");

// Names of blocks for this module (Not all module has blocks)
define("_MI_EGUIDE_MYLIST","Reservaciones");
define("_MI_EGUIDE_SUBMIT","Registrar Nuevo Evento");
define("_MI_EGUIDE_COLLECT","Settings collection");
define("_MI_EGUIDE_REG","Notificarme sobre nuevos Eventos");
define("_MI_EGUIDE_HEADLINE","Encuentro de la Lenin");
define("_MI_EGUIDE_HEADLINE_DESC","Upcomming Recent Event List");
define("_MI_EGUIDE_HEADLINE2","Nuevos Eventos");
define("_MI_EGUIDE_HEADLINE2_DESC","Eventos recientes");
define("_MI_EGUIDE_HEADLINE3","Terminado Eventos");
define("_MI_EGUIDE_HEADLINE3_DESC","Evento Lista de los ya terminados");
define("_MI_EGUIDE_CATBLOCK","Evento Categoría");
define("_MI_EGUIDE_CATBLOCK_DESC","Elija caso de la categoría");

define("_MI_EGUIDE_EVENTS","Event article Operation");
define("_MI_EGUIDE_NOTIFIES","Notify to New registers");
define("_MI_EGUIDE_CATEGORY","Categorías de Eventos");
define("_MI_EGUIDE_SUMMARY","Sumario de Reservación");
define("_MI_EGUIDE_CATEGORY_MARK","Categoría - ");
define("_MI_EGUIDE_ABOUT","sobre eguide");

// Configuration variable for this module
define("_MI_EGUIDE_POSTGROUP","Grupo de Eventos");
define("_MI_EGUIDE_POSTGROUP_DESC","Set a group the owner permited to administration for own evnet.");
define("_MI_EGUIDE_NOTIFYADMIN","Notify mail to Admin");
define("_MI_EGUIDE_NOTIFYADMIN_DESC","Notification mail to admin when New Event registerd");
define("_MI_EGUIDE_NOTIFY_ALWAYS","siempre");
define("_MI_EGUIDE_NOTIFYGROUP","Admin Group for Notification");
define("_MI_EGUIDE_NOTIFYGROUP_DESC","The group is received admin notification mail");
define("_MI_EGUIDE_NEEDPOSTAUTH","Do you need to approve New Event");
define("_MI_EGUIDE_NEEDPOSTAUTH_DESC","Need to approve New Event by site administrator");
define("_MI_EGUIDE_MAX_LISTITEM","Display additional items in list");
define("_MI_EGUIDE_MAX_LISTITEM_DESC","Display items entry order additional form");
define("_MI_EGUIDE_MAX_LISTLINES","Display list items in a page");
define("_MI_EGUIDE_MAX_LISTLINES_DESC","How many item lines in a page");
define("_MI_EGUIDE_MAX_EVENT","Display events in top page");
define("_MI_EGUIDE_MAX_EVENT_DESC","Number of listed events in top page");
define("_MI_EGUIDE_SHOW_EXTENTS","Show Multiple Entry");
define("_MI_EGUIDE_SHOW_EXTENTS_DESC","When event has multiple entry, show each entris. YES - display each entries. NO - Only show recenet entry.");
define("_MI_EGUIDE_USER_NOTIFY","User requested notification of new event");
define("_MI_EGUIDE_USER_NOTIFY_DESC","YES - Enable notification mail, NO - disable.");
define("_MI_EGUIDE_MEMBER","Event entry need to LOGIN");
define("_MI_EGUIDE_MEMBER_DESC","Only login user can be reservation event. (Not use email address)");
define("_MI_EGUIDE_MEMBER_RELAX","Ambos");
define("_MI_EGUIDE_ORDERCONF","Has confirm page");
define("_MI_EGUIDE_ORDERCONF_DESC","Display confirm page when reservation submit");
define("_MI_EGUIDE_CLOSEBEFORE","Close Time Before (min)");
define("_MI_EGUIDE_CLOSEBEFORE_DESC","Event entry close time before setting minits.");
define("_MI_EGUIDE_LAB_PERSONS","Additional item options");
define("_MI_EGUIDE_LAB_PERSONS_DESC","Additional item optional settings, like a field label for how many persons. Example: 'label_persons=Persons'. See <a href=\"../../eguide/admin/help.php#form_options\">about eguide page</a> more details.");
define("_MI_EGUIDE_DATE_FORMAT","Date Foramt");
define("_MI_EGUIDE_DATE_FORMAT_DESC","Open Event Date(Time) display format. Using PHP date function format.");
define("_MI_EGUIDE_DATE_FORMAT_DEF","D, d M Y");
define("_MI_EGUIDE_EXPIRE_AFTER","Expire Time");
define("_MI_EGUIDE_EXPIRE_AFTER_DESC","Event expired on top page when after event start time in minites.");
define("_MI_EGUIDE_PERSONS","Persons default value");
define("_MI_EGUIDE_PERSONS_DESC","Reservation persons in event post form");
define("_MI_EGUIDE_PLUGINS","Use Other moudle plugins");
define("_MI_EGUIDE_PLUGINS_DESC","Internal Control accept entry form other modules");
define("_MI_EGUIDE_COMMENT","Allow Comments");
define("_MI_EGUIDE_COMMENT_DESC","Allow commnets to event");
define("_MI_EGUIDE_MARKER","Current entry level mark");
define("_MI_EGUIDE_MARKER_DESC","The mark mean of how many entry in current. Show mark correspond percentage. (xx,yy mean less than xx% showup yy. And '0,yy' mean out of date mark)");
define("_MI_EGUIDE_MARKER_DEF","0,[Close]\n50,[Vacant]\n100,[Many]\n101,[Full]\n");
define("_MI_EGUIDE_TIME_DEFS","Time Table Labels");
define("_MI_EGUIDE_TIME_DEFS_DESC","Set starting time in Settings collection page. e.g.: 08:00,14:00,16:00");
define("_MI_EGUIDE_EXPORT_LIST","Item List in export reservations");
define("_MI_EGUIDE_EXPORT_LIST_DESC","Item `name' or `number' seperated comma(,). Astarisk(*) mean left items. e.g.: 3,4,0,2,*");
// Templates
define("_MI_EGUIDE_INDEX_TPL", "Event Guide Top page list");
define("_MI_EGUIDE_EVENT_TPL", "Detail of Event");
define("_MI_EGUIDE_ENTRY_TPL", "Reservation entry");
define("_MI_EGUIDE_EVENT_PRINT_TPL", "Detail of Event for Print");
define("_MI_EGUIDE_RECEIPT_TPL", "Reservations List");
define("_MI_EGUIDE_ADMIN_TPL", "Event Entry Form");
define("_MI_EGUIDE_RECEIPT_PRINT_TPL", "Reservations List for Print");
define("_MI_EGUIDE_EVENT_ITEM_TPL", "Item of Event Showup");
define("_MI_EGUIDE_EVENT_CONF_TPL", "Event Confirmation Form");
define("_MI_EGUIDE_EVENT_LIST_TPL", "Reserved Event List");
define("_MI_EGUIDE_EVENT_CONFIRM_TPL", "Confirmación");
define("_MI_EGUIDE_EDITDATE_TPL", "Editar fecha abierta");
define("_MI_EGUIDE_COLLECT_TPL", "Reservation setting collection");
define("_MI_EGUIDE_EXCEL_TPL", "Excel (XML) file format in exporting");

// Notifications
define('_MI_EGUIDE_GLOBAL_NOTIFY', 'Grobal en el módulo');
define('_MI_EGUIDE_GLOBAL_NOTIFY_DESC', 'Notification in Event Guide module');
define('_MI_EGUIDE_CATEGORY_NOTIFY', 'Current category');
define('_MI_EGUIDE_CATEGORY_NOTIFY_DESC', 'Notification at category in Event Guide module');
define('_MI_EGUIDE_CATEGORY_BOOKMARK', 'Evento actual');
define('_MI_EGUIDE_CATEGORY_BOOKMARK_DESC', 'Notifcation at current event in Event Guide module');

define('_MI_EGUIDE_NEWPOST_SUBJECT', 'Nuevo Evento - {EVENT_DATE} {EVENT_TITLE}');
define('_MI_EGUIDE_NEWPOST_NOTIFY', 'New event post');
define('_MI_EGUIDE_NEWPOST_NOTIFY_CAP', 'Notificarme cuando hayan nuevos Eventos');
define('_MI_EGUIDE_CNEWPOST_NOTIFY', 'New event post in category');
define('_MI_EGUIDE_CNEWPOST_NOTIFY_CAP', 'Notify when new event posted in current category');
// for altsys
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Plantillas');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Bloques de los módulos');
    define('_MD_A_MYMENU_MYLANGADMIN','Administración de textos');
    define('_MD_A_MYMENU_MYPREFERENCES','Preferences');
}
?>
