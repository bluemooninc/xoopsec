<?php
// $Id: admin.php,v 1.2 2007/07/24 10:17:04 yoshis Exp $
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
define("_AM_BMSURVEY_ERROR01", "not writable");
// Admin Top Menu
define("_AM_PREFERENCES","Preferences");
define("_AM_BMSURVEY_GOMOD","Go to Module");
define("_AM_BMSURVEY_FAQ","FAQ");
define("_AM_BMSURVEY_SUPPORTSITE","Support Site");
// Admin Tag menu
define('_AM_BMSURVEY_MANAGE','Form Management');
define("_AM_BMSURVEY_RESPONDENT","Edit Respondents");
define("_AM_BMSURVEY_CASTFORM","Send Question");
define("_AM_BMSURVEY_CHECKRESPONSE","Recieve Response");
define("_AM_BMSURVEY_RESISTER","Send Resister mail");
define("_AM_BMSURVEY_STATUS","Status Check");
// Document Link
define("_AM_BMSURVEY_DOC_POPNUPBLOG","How work with PopnupBlog");
define("_AM_BMSURVEY_DOC_UPDATEINFO","Update Infomation");
define('_AM_BMSURVEY_DOC_MAILTO','Mail Options');
// Admin Body
define("_AM_BMSURVEY_RESPONDENTS","List of Mail Respondents");
define("_AM_BMSURVEY_RESPONDENT_USAGE","Do not input about astalisk colmn. It use by program.<br>\nTicket Number will change at next sending questions.");
define("_AM_BMSURVEY_uid","User Name");
define("_AM_BMSURVEY_PASSWORD","Ticket Number");
define("_AM_BMSURVEY_FNAME","First Name");
define("_AM_BMSURVEY_LNAME","Last Name");
define("_AM_BMSURVEY_EMAIL","Mail Address");
define("_AM_BMSURVEY_DISABLED","Disabled");
define("_AM_BMSURVEY_FORMID","Form ID");
define("_AM_BMSURVEY_RESPONSEID","Response ID");
define("_AM_BMSURVEY_CHANGED","Change Date");
define("_AM_BMSURVEY_EXPIRE","Expire Date");
define("_AM_BMSURVEY_INVITATION","Send a resister mail to respondent");
define("_AM_BMSURVEY_SUBJECT","Subject");
define("_AM_BMSURVEY_SUBJECT_NEW","Resistration for Form");
define("_AM_BMSURVEY_MESSAGE","Body");
define("_AM_BMSURVEY_MESSAGE_NEW","\nThe registration is necessary to answer the questionnaire that will be sent in the future. \nPlease input to [] and reply. \n----\nu:[] Input a user name.\nf:[] Input your first name\nl:[] Input your last name\ns:[] Form ID for answer.\nd:[] Expire date as respondent.");
define("_AM_BMSURVEY_CHOSEFORM","Chose a form");
define("_AM_BMSURVEY_SENDQUESTION","Send a Question");
define("_AM_BMSURVEY_CONFIRM","Confirm respondents");
define("_AM_BMSURVEY_SENDQUESTIONNOW","When you click here, send questions.");
define("_AM_BMSURVEY_SENDQUESTIONUSAGE","(If new questions are transmitted, the ticket number will updated, and old questions becomes irrecoverable. )\n<p>If following URL is called with Wget and the scheduler, it is possible to automate it. <p>%s\n<p>When '&hide=1' is specified, the question sentence is omitted. ");
define("_AM_BMSURVEY_CHECKRESPONSENOW","When you click here, check the response mail.");
define("_AM_BMSURVEY_CHECKRESPONSEUSAGE","If following URL is called with Wget and the scheduler, it is possible to automate it. \n<p>%s");

define("_AM_BMSURVEY_SEEARESULT","See a result");
define('_AM_BMSURVEY_COPYQUESTION','Copy question from form');
define('_AM_BMSURVEY_SELECTSTATUS','Select Status');
define('_AM_BMSURVEY_RATECOUNT','Count as each rate');
define('_AM_BMSURVEY_NORESPONSE','No Response');
define('_AM_BMSURVEY_TOTAL','Total');
define('_AM_BMSURVEY_QUESTIONNUMBER','Q No');
define('_AM_BMSURVEY_FILEDNAME_DESC','');
define('_AM_BMSURVEY_ARCHIVED','Archived');
define('_AM_BMSURVEY_TEST','Test');
define('_AM_BMSURVEY_EXPIRATION','Expiration');
define('_AM_BMSURVEY_ACTIVE','Active');
define('_AM_BMSURVEY_EDIT','Edit');

?>
