<?php
// $Id: main.php,v 1.11 2010-10-10 06:30:12 nobu Exp $
// Spanish language files by Gerardo

if (defined('_MD_RESERV_FORM')) return;

define("_MD_RESERV_FORM","Confirmar Asistencia");
define("_MD_RESERVATION","Confirmar Asistencia");
define("_MD_NAME","/^Name\\*?\$/");
define('_MD_SDATE_FMT', 'D, j M Y');
define('_MD_STIME_FMT', 'H:i');
// Localization Transrate Weekly date name
//global $ev_week;
//$ev_week = array('Sun'=>'S', 'Mon'=>'M','Tue'=>'T', 'Wed'=>'W','Thu'=>'U','Fri'=>'F', 'Sat'=>'A');
define("_MD_POSTED_FMT", "j M Y H:i");
define("_MD_TIME_FMT", "j M Y H:i");
define("_MD_READMORE","Más...");
define("_MD_EMAIL","EMail");
define("_MD_EMAIL_CONF","Consultar el EMail");
define('_MD_EMAIL_CONF_DESC','Por favor, introduzca su dirección de EMail de nuevo para su confirmación');
define('_MD_UNAME','Usuario');
define("_MD_SUBJECT","Confirmar - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_NOTIFY_EVENT",  "Notificación sobre nuevos Eventos");
define("_MD_NOTIFY_REQUEST","Notificarme por EMail sobre novedades de este Evento");
define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_LISTITEM_FMT', '[%s]');
define("_MD_ORDER_NOTE1","'"._MD_REQUIRE_MARK."'requerido. ");
define("_MD_ORDER_NOTE2","'[ ]' item to be displayed on list of participants.");
define('_MD_ORDER_SEND','Reservar');
define('_MD_ORDER_CONF','Confirmar');

define("_MD_EVENT_NONE","Esto no es un Evento");
define("_MD_BACK","Regresar");
define("_MD_RESERVED","Tu Reservación ya ha sido registrada");
define("_MD_RESERV_NUM","Plazas disponibles %d");
define("_MD_RESERV_REG","Plazas reservadas %d");
define("_PRINT", "Imprimir");

define("_MD_NOITEM_ERR","Ingresa un valor.");
define("_MD_NUMITEM_ERR","Debe ser numérico");
define("_MD_MAIL_ERR","Formato de eMail erróneo");
define('_MD_MAIL_CONF_ERR','Confirmar dirección de EMail no coinciden');
define("_MD_SEND_ERR","No se pudo enviar el eMail");
define("_MD_DUP_ERR","Ya existe una plaza reservada con tu direción eMail");
define('_MD_DATE_ERR','The Date is out of range');
define('_MD_DATEDELETE_ERR','Stop remove the date, there is reservation exists');
define("_MD_DUP_REGISTER","MLa Notificación por eMail ya está registrada");
define("_MD_REGISTERED","Notificación por eMail registrada");

define("_MD_RESERV_ACCEPT","Enviando eMail de Confirmación");
define("_MD_RESERV_STOP","Reservations have been halted.");
define("_MD_RESERV_CONF","Información");
define("_MD_RESERV_ADMIN","Lista de Participantes");
define("_MD_RESERV_REGISTER","Registro de Reservaciones");

define("_MD_RESERV_ACTIVE"," is accepted.");
define("_MD_RESERV_REFUSE"," is refused.");

define("_AM_MAILGOOD","Enviado con éxito: %s");
define("_AM_SENDMAILNG","Fallo de envío: %s");

define("_MD_RESERV_NOTFOUND","No reservation or Allready cancelled.");
define("_MD_RESERV_CANCEL","Estás seguro de cancelar esta Reservación?");
define("_MD_RESERV_CANCELED","Tu Reservación ha sido cancelada");
define("_MD_RESERV_NOCANCEL","Imposible cancelar Reservación despues del tiempo de cierre");
define("_MD_RESERV_NOTIFY","%s\n\nEmail de petición: %s\nReservación para Evento: %s\n  %s\n");
define("_MD_RESERV_FULL","La Reservación ha sido cancelada. El Evento tiene el máximo de asistentes.");
define('_MD_RESERV_TOMATCH',' %d is too match (%d izquierda)');
define('_MD_RESERV_CLOSE','Proceso de Reservación concluido');
define('_MD_RESERV_NEEDLOGIN','Necesitas <a href="'.XOOPS_URL.'/user.php">Ingresar</a>, para reservar');
define('_MD_RESERV_PLUGIN_FAIL','Not enough condition for reservation');
define("_MD_CANCEL_FAIL","Imposible cancelar");
define('_MD_CANCEL_SUBJ','Cancelar - {EVENT_DATE} {EVENT_TITLE}');
define("_MD_NODATA","No hay participantes");
define("_MD_NOEVENT","No hay Eventos publicados");
define("_MD_SHOW_PREV","Eventos Anteriores");
define("_MD_SHOW_NEXT","Próximos Eventos");

define("_MD_POSTERC","Publicado por");
define('_MD_POSTDATE','Registrado el:');
define('_MD_STARTTIME','Comienzo del Evento');
define('_MD_CLOSEDATE','Fecha tope de Admisión');
define('_MD_CLOSEBEFORE','Cierre del Evento');
define('_MD_CLOSEBEFORE_DESC','before from start (e.g.: 3days, 2hour, 50min)');
define('_MD_TIME_UNIT','days,hour,min');
define('_MD_TIME_REG','d(ay)?s?,h(our)?,min');
define('_MD_CALENDAR','Ir al Calendario');
define('_MD_CAL','Calendario');
define('_MD_CAL_MONDAY_FIRST', true);
define("_MD_REFER","%d vistas");
define("_MD_RESERV_LIST","Lista de Participantes");

define('_MD_NEED_UPGRADE','Need to Proceed module Upgrade');

//%%%%%%	File Name receiept.php 	%%%%%
define("_MD_RESERV_EDIT","Editar Reservación");
define("_MD_OPERATION","Operación");
define("_MD_STATUS","Estatus");
define("_MD_RESERV_RETURN","Regresar al Listado");
define("_MD_RESERV_REC","Reservaciones");
define("_MD_RVID","ID de Reservación");
define("_MD_ORDER_COUNT","Total");
define("_MD_PRINT_DATE","Fecha");
define("_MD_SAVECHANGE","Guardar cambios");
define("_MD_RESERV_DEL","Borrar Reservación");
define("_MD_DETAIL","Detalles");
define("_MD_RESERV_MSG_H","Sending message for reservation");
define("_MD_ACTIVATE","Aprobado");
define("_MD_REFUSE","Denegado");
define("_MD_EXPORT_OUT","Excel Format");
define('_MD_EXPORT_CHARSET', 'UTF-8');
define("_MD_INFO_MAIL","Enviando EMail");
define("_MD_SUMMARY","Acompañantes");
define("_MD_SUM_ITEM","Total de Acompañantes");
define("_MD_SUM","Total");

//%%%%%%	File Name admin.php 	%%%%%
define("_MD_EDITARTICLE","Editar nuevo Evento");
define("_MD_NEWTITLE","Nuevo Evento");
define("_MD_NEWSUB","Nuevo Evento - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_TITLE","Título");
define("_MD_EVENT_DATE","Fecha del Evento");
define("_MD_EVENT_EXPIRE","Finish Display");
define('_MD_EVENT_EXTENT','Repeat Open');
define('_MD_EVENT_CATEGORY','Categoría');
define('_MD_EDIT_EXTENT','Edit Open Date');
define('_MD_EXTENT_REPEAT','Repetir');
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
define('_MD_OPTION_VARS','Variables Opción');
define('_MD_OPTION_OTHERS','Otros');
define('_MD_RESERV_REDIRECT','Redirect After Reservation URL');
define('_MD_RESERV_REDIRECT_DESC','Set a number waiting seconds. e.g.: "4;http://..."');
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
//$ev_month = array(1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr",
//                  5=>"May", 6=>"Jun", 6=>"Jul", 8=>"Aug",
//                  9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec");

define('_MD_RESERV_DEFAULT_ITEM',"Nombre*,size=40\Curso,size=10,Acompañantes,size=5");
define('_MD_RESERV_DEFAULT_MEMBER',"");

// notification message
define('_MD_APPROVE_REQ','Confirmar y aprobar el Evento.');
//%%%%%%	File Name sendinfo.php 	%%%%%
define("_MD_INFO_TITLE","Information Mail to Send");
define("_MD_INFO_CONDITION","Enviar a");
define("_MD_INFO_NODATA","No DATA");
define("_MD_INFO_SELF","send to self (%s)");
define("_MD_INFO_DEFAULT","-messages-\n\n\nReserved Event\n    {EVENT_URL}\n");
define("_MD_INFO_MAILOK","Mail sent");
define("_MD_INFO_MAILNG","Imposible enviar el EMail");
define("_MD_UPDATE_SUBJECT","Evento actualizado");
define("_MD_UPDATE_DEFAULT","Default");

//%%%%%%	File Name print.php 	%%%%%

define("_MD_URLFOREVENT","Enlace del Evento:");
// %s represents your site name
define("_MD_THISCOMESFROM","Más información sobre próximos Eventos aquí en %s");

//%%%%%%	File Name mylist.php 	%%%%%
define('_MD_MYLIST','Reservaciones');
define('_MD_CANCEL','Cancelar');
?>