<?php
// $Id: modinfo.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $
//  ------------------------------------------------------------------------ //
//                Bluemoon.Multi-Form                                      //
//                    Copyright (c) 2005 Yoshi.Sakai @ Bluemoon inc.         //
//                       <http://www.bluemooninc.biz/>                       //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'BMSURVEY_MI_LOADED' ) ) {

define( 'BMSURVEY_MI_LOADED' , 1 ) ;

// The name of this module
define("_MI_BMSURVEY_NAME","Web Form");
define("_MI_BMSURVEY_LIST","Form list");
define("_MI_BMSURVEY_NEW","Make new");
define("_MI_BMSURVEY_MANAGE","Management");
// A brief description of this module
define("_MI_BMSURVEY_BNAME1","Form Form");
define("_MI_BMSURVEY_DESC","Bluemoon.Multi-Form");

// Names of blocks for this module
define('_MI_BMSURVEY_RESPONDENT','Edit Respondents');
define('_MI_BMSURVEY_CASTFORM','Send Question');
define('_MI_BMSURVEY_RECIEVECHECK','Recieve Response');
define('_MI_BMSURVEY_RESISTER','Send Resister mail');
define('_MI_BMSURVEY_STATUS','Status Check');
define('_MI_BMSURVEY_FILECHARSET', 'Character-code for attach file');
define('_MI_BMSURVEY_FILECHARSET_DESC', 'Set the character-code for save to server. (ASCII,UTF-8,EUC etc)');
define('_MI_BMSURVEY_CSVCHARSET', 'Character-code for CSV file');
define('_MI_BMSURVEY_CSVCHARSET_DESC', 'Set the character-code for CSV download to cliants. (ASCII,UTF-8,EUC etc)');
define('_MI_BMSURVEY_CSVADDNUM', 'Add number for CSV');
define('_MI_BMSURVEY_CSVADDNUM_DESC', 'Add number for CSV oputput header.(line 1)');
define('_MI_BMSURVEY_CHOICEOPT','Type of choice output on CSV');
define('_MI_BMSURVEY_CHOICEOPT_DESC','Select type as strings or sequential number.');
define('_MI_BMSURVEY_CSVOTHERF','!other format on CSV output');
define('_MI_BMSURVEY_CSVOTHERF_DESC','Set CSV output format for !other responce.');
define('_MI_BMSURVEY_MAILSERVER', 'POP3 mail server');
define('_MI_BMSURVEY_MAILSERVER_DESC', 'Set the POP3 server for recieve mail.');
define('_MI_BMSURVEY_MAILUSER', 'POP3 User name');
define('_MI_BMSURVEY_MAILUSER_DESC', 'Set user name for POP3.');
define('_MI_BMSURVEY_MAILPWD', 'POP3 Password');
define('_MI_BMSURVEY_MAILPWD_DESC', 'Set pasword for POP3.');
define('_MI_BMSURVEY_MAILADDR', 'Mail Address');
define('_MI_BMSURVEY_MAILADDR_DESC', 'Set mail address for POP3 and SMTP From');
define('_MI_BMSURVEY_CASTKEY', 'Cast Key');
define('_MI_BMSURVEY_CASTKEY_DESC', 'Set key strings for cast.php.');
define('_MI_BMSURVEY_MANAGEGROUP', 'Management Groups');
define('_MI_BMSURVEY_MANAGEGROUP_DESC', 'Set groups for form management');
define('_MI_BMSURVEY_MGPSTATUS', 'Manage group status');
define('_MI_BMSURVEY_MGPSTATUS_DESC', 'For group permission to edit,activate and end.');
define('_MI_BMSURVEY_BLOCKLIST', 'Block list number');
define('_MI_BMSURVEY_BLOCKLIST_DESC', 'Number of list at block');
define('_MI_BMSURVEY_ADDINFO', 'Add info to response');
define('_MI_BMSURVEY_ADDINFO_DESC', 'Send response mail with additional info');
define('_MI_BMSURVEY_ADDUSAGE', 'Add usage to questionnaire');
define('_MI_BMSURVEY_ADDUSAGE_DESC', 'Send questionnaire mail with usage info');
define('_MI_BMSURVEY_ONERESPONSE', 'Accept One Response');
define('_MI_BMSURVEY_ONERESPONSE_DESC', 'Accept one response for one question. No = Accept all responses');
define('_MI_BMSURVEY_RESETRADIOBUTTON', 'Reset for radio button');
define('_MI_BMSURVEY_RESETRADIOBUTTON_DESC', 'It can be reset for radio button');
define('_MI_BMSURVEY_RESULTRANK', 'Rate report type at view a form report');
define('_MI_BMSURVEY_RESULTRANK_DESC', 'Select avarage or count');
define('_MI_BMSURVEY_UNSETGROUP', 'Unset Groups');
define('_MI_BMSURVEY_UNSETGROUP_DESC', 'Divide |');
define('_MI_BMSURVEY_SUBMITJUMPURI', 'Redirect URL after submit');
define('_MI_BMSURVEY_SUBMITJUMPURI_DESC', '');
define('_MI_BMSURVEY_INVALIDJUMPURI', 'Redirect URL for invalid request');
define('_MI_BMSURVEY_INVALIDJUMPURI_DESC', '');
define('_MI_SHOW_PUBLIC_TO_OTHERGROUP','Show to any groups for input form');
define('_MI_SHOW_PUBLIC_TO_OTHERGROUP_DESC','');
}

?>