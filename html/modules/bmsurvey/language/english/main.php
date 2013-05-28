<?php
// $Id: main.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $
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
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'BMSURVEY_MB_LOADED' ) ) {

define( 'BMSURVEY_MB_LOADED' , 1 ) ;

define('_MB_ORDER', 'Order');
define('_MB_TILDE', ' to ');
define('_MB_NUMBERSTRING', '');
define('_MB_ALL', 'All');
define('_MB_FILTER', 'Filter');
define('_MB_LIST_CHECKED', 'Checked');
define('_MB_LIST_TITLE', 'Title');
define('_MD_BMSURVEY_DETAIL', 'Detail');
define('_MB_From_Option','From address');
define('_MD_FROM_OPTION','From address (Form address is set at preferences)');
define('_MD_FROM_OPTION_0','Form address');
define('_MD_FROM_OPTION_1','Users address');
define('_MD_FROM_OPTION_2',"In the questionnaire");
define('_MB_Default_Response','Default Responce');
define('_MD_FROM_DEFRES',"Default Responce ID (Fill Input Example)");
define('_MB_LIST_UNAME', 'Owner');
define('_MB_LIST_DATE', 'Date');
define('_MB_LIST_SUBTITLE', 'Sub Title');
define('_MD_BMSURVEY_THANKS_ENTRY', 'Thank You For Completing This Form!');
define('_MD_BMSURVEY_CAN_WRITE_USER_ONLY', 'Guest cannot edit form!');
define('_MD_BMSURVEY_YOU_DONT_HAVE_A_PERMISSION', 'You don\'t have a permission.');
define('_MD_ASTERISK_REQUIRED', 'Questions marked with a <font color="#FF0000">*</font> are required.');
define('_MD_MAIL_TITLE', 'Response from BMSURVEY:');
define("_MD_DENYRESULT","Deny this result");
define("_MD_DENYRESULTSURE","Deny this result. Are you sure?");
define("_MD_DENYRESULTDONE","Denied this result");
define('_MD_DEFAULTRESULT','Set default input this result');
define('_MD_EDITRESULT','Edit this result');
define('_MD_DEFAULTRESULTDONE','Saved as default response');
define('_MD_RESPONDENT','Respondent');
define('_MD_QUESTION_OTHER','Other');
define('_MD_BMSURVEY_FORMATERR', ' is not correctly input.');
define('_MD_BMSURVEY_DIGITERR', ' is not digit.');
define('_MD_BMSURVEY_MAXOVER', ' may not accept over %u.');
define('_MD_BMSURVEY_CHECKANY', '(Check any)');
define('_MD_BMSURVEY_CHECKLIMIT', '(Check until %u)');
define('_MD_BMSURVEY_CHECKRESET', 'Reset');
define('_MD_SUBMIT_FORM', 'Submit Form');

define('_MD_NEXT_PAGE', 'Next Page');
define('_MD_BMSURVEY_COPY_TITLE_PREFIX', 'Copy %s~ ');
define("_MD_FORM_LIST","Active form list");

define('_MD_POP_KEY_M','Member');
define('_MD_POP_KEY_U','Usage');
define('_MD_POP_KEY_Q','Questionnaire');
define('_MD_POP_KEY_ERR','POP-Key Error');
define('_MD_POP_CMD_NEW','Resister');
define('_MD_POP_CMD_INP','Response');
define('_MD_POP_CMD_DEL','Delete');
define('_MD_POP_MNEW_ENTRY','Risiterd user name as %s.');
define('_MD_POP_MNEW_AREADY','The user name has already been registered. Please register by another name.');
define('_MD_POP_QINP_HEADER','Please make the reply mail, input between parentheses, and transmit.
Two or more parentheses that exist in one line are choice items. () are single, [] are multiple. 
Only one [] a line are the text input items. Please input the character string. 
----

');
define('_MD_POP_QINP_FAILEDLOGIN','The user-name or the ticket number is different.');
define('_MD_POP_QINP_SUCCEEDED','%s, Your answer was registered. ');
define('_MD_POP_QINP_DELETEIT','This questionnaire has already been answered.
It is possible to delete it by replying to this mail.');
define('_MD_POP_QDEL_SUCCEEDED','%s, Your answer was deleted.');

define('_AM_BMSURVEY_MANAGE','Form Management');
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
define('_AM_BMSURVEY_PURGE','Purge');

//
// From /locale/messages.po
//
define("_MB_Unable_to_open_include_file","Unable to open include file. Check INI settings. Aborting.");
define("_MB_Service_Unavailable","Service Unavailable");
define("_MB_Your_progress_has_been_saved","Your progress has been saved.  You may return at any time to complete this form.  To do so, simply bookmark the link below.  You may be prompted for your uid and password to complete the form.");
define("_MB_Resume_form","Resume form");
define("_MB_Invalid_argument","Invalid argument");
define("_MB_Error_opening_form","Error opening form.");
define("_MB_Error_opening_forms","You may not open more than one form. Click the finish button at editing form.");
define("_MB_No_responses_found","No responses found.");
define("_MB_TOTAL","TOTAL");
define("_MB_No_questions_found","No questions found.");
define("_MB_Page_d_of_d","Page %d of %d");
define("_MB_Yes","Yes");
define("_MB_No","No");
define("_MB_1","1");
define("_MB_2","2");
define("_MB_3","3");
define("_MB_4","4");
define("_MB_5","5");
define("_MB_NA","N/A");
define("_MB_SUM","Sum");
define("_MB_Page","Page");
define("_MB_of","of");
define("_MB_Error_system_table_corrupt","Error system table corrupt.");
define("_MB_Table","Table");
define("_MB_Report_for","Report for");
define("_MB_ID","ID");
define("_MB_Num","#");
define("_MB_Req_d","Req'd");
define("_MB_Public","Public");
define("_MB_Content","Content");
define("_MB_Previous","Previous");
define("_MB_Next","Next");
define("_MB_Navigate_Individual_Respondent_Submissions","Navigate Individual Respondent Submissions");
define("_MB_Error_cross_analyzing_Question_not_valid_type","Error cross-analyzing. Question not valid type.");
define("_MB_Cross_analysis_on_QID","Cross analysis on QID:");
define("_MB_Sorry_please_fill_out_the_name","Sorry, please fill out the name, group, and title before proceeding.");
define("_MB_Sorry_name_already_in_use","Sorry, name already in use. Pick a new name.");
define("_MB_Sorry_that_name_is_already_in_use","Sorry, that name is already in use.");
define("_MB_Warning_error_encountered","Warning, error encountered.");
define("_MB_Please_enter_text","Please enter text for this question.");
define("_MB_Sorry_you_must_select_a_type_for_this_question","Sorry, you must select a type for this question.");
define("_MB_New_Field","New Field");
define("_MB_Sorry_you_cannot_change_between_those_types_of_question","Sorry, you cannot change between those types of question. Create a new question instead.");
define("_MB_Sorry_you_need_at_least_one_answer_option_for_this_question_type","Sorry, you need at least one answer option for this question type.");
define("_MB_Error_cross_tabulating","Error cross-tabulating.");
define("_MB_Error_same_question","Please ensure that your column and row selections are not of the same question.");
define("_MB_Error_column_and_row","Please ensure you make both a column and row selection.");
define("_MB_Error_analyse_and_tabulate","You are attempting to cross analyse and tabulate at the same time. This is not possible!");
define("_MB_Error_processing_form_Security_violation","Error processing form: Security violation.");
define("_MB_Unable_to_execute_access","Unable to execute query for access.");
define("_MB_Unable_to_execute_respondents","Unable to execute query respondents.");
define("_MB_Unauthorized","Unauthorized");
define("_MB_Incorrect_User_ID_or_Password","Incorrect User ID or Password, or your account has been disabled/expired.");
define("_MB_Your_account_has_been_disabled","Your account has been disabled or you have already completed this form.");
define("_MB_Unable_to_load_ACL","Unable to load ACL.");
define("_MB_Management_Interface","Management Interface");
define("_MB_This_account_does_not_have_permission","This account does not have permission");
define("_MB_Go_back_to_Management_Interface","Go back to Management Interface");
define("_MB_Submit","Submit");
define("_MB_Rank","Rank");
define("_MB_Response","Response");
define("_MB_Average_rank","Average rank");
define("_MB_You_are_missing_the_following_required_questions","You are missing the following required questions:");
define("_MB_Form_Design_Completed","Form Design Completed");
define("_MB_You_have_completed_this_form_design","You have completed this form design.");
define("_MB_To_insert_this_form_into_your_web_page","To insert this form into your web page, copy the text below, and paste it into the HTML of your page.");
define("_MB_Once_activated_you_can_also_access_the_form_directly_from_the_following_URL","Once activated you can also access the form directly from the following URL.");
define("_MB_You_must_activate_this_form","You must activate this form before you can collect results. Once a form is active, you may no longer make any changes to it. You may activate this form by choosing <b>Change the Status of an Existing Form</b> from the Management Interface.");
define("_MB_The_information_on_this_tab_applies_to_the_whole_form","The information on this tab applies to the whole form. Fill out this page then go to the <b>Fields</b> tab to edit individual fields.");
define("_MB_Name","Name");
define("_MB_Required","Required");
define("_MB_Form_filename.","Form filename");
define("_MB_This_is_used_for_all_further_access_to_this_form","This is used for all further access to this form.");
define("_MB_no_spaces","no spaces");
define("_MB_alpha_numeric_only","alpha-numeric only");
define("_MB_Owner","Owner");
define("_MB_User_and_Group_that_owns_this_form","Select the group that can inspect the responce of this form.");
define("_MB_User_and_Group_that_input_this_form","Select the group that can responce of this form.");
define("_MB_Respondents","Group of response");

define("_MB_Title","Title");
define("_MB_Title_of_this_form","Title of this form.");
define("_MB_This_appears_at","This appears at the top of every page of this form.");
define("_MB_free_form_including_spaces","free-form, including spaces");
define("_MB_Subtitle","Subtitle");
define("_MB_Subtitle_of_this_form","Subtitle of this form.");
define("_MB_Appears_below_the","Appears below the title.");
define("_MB_Additional_Info","Additional Info");
define("_MB_Text_to_be_displayed_on_this_form_before_any_fields","Text to be displayed on this form before any fields. (i.e. instructions, background info, etc.)");
define("_MB_Confirmation_Page","Confirmation Page");
define("_MB_URL","(URL)");
define("_MB_The_URL_to_which_a_user_is_redirected_after_completing_this_form","The URL to which a user is redirected after completing this form.");
define("_MB_OR","OR");
define("_MB_heading_text","(heading text)");
define("_MB_body_text","(body text)");
define("_MB_Heading_in_bold","Heading (in bold) and body text for the &quot;Confirmation&quot; page displayed after a user completes this form.");
define("_MB_URL_if_present","(URL, if present, takes precedent over confirmation text.)");
define("_MB_Email","Email");
define("_MB_Sends_a_copy","Sends a copy of each submission to address (or leave blank for no email backup).");
define("_MB_Theme","Theme");
define("_MB_Select_a_theme","Select a theme (css) to use with this form.");
define("_MB_Options","Options");
define("_MB_Allow_to_save","Allow form respondents to save/resume. (Form login required.)");
define("_MB_Allow_to_forward","Allow form respondents to go forward and back between form sections.");
define("_MB_Change_the_order","Change the order that questions are presented by choosing the desired position from the list.");
define("_MB_Section_Break","----- Section Break -----");
define("_MB_Remove","Remove");
define("_MB_Edit","Edit");
define("_MB_Add_Section_Break","Add Section Break");
define("_MB_This_is_a_preview","This is a preview of how this form will look. In the preview the form navigation buttons are inactive, use the section number buttons to view different sections. Some navigation buttons may not appear on your final form, depending on what access it is assigned. The form will use the background color of the document in which it is embedded. If you have no further changes click <b>Finish</b> at the bottom of this page.");
define("_MB_Section","Section");
define("_MB_Previous_Page","Previous Page");
define("_MB_Save","Save");
define("_MB_SaveAsDefault","Save as default");
define("_MB_Next_Page","Next Page");
define("_MB_Submit_Form","Submit Form");
define("_MB_Edit_this_field","Edit this field, or click the number of the field you would like to edit:");
define("_MB_Field","Field");
define("_MB_Field_Name","Field Name");
define("_MB_Type","Type");
define("_MB_Length","Length");
define("_MB_Precision","Precision");
define("_MB_Enter_the_possible_answers","Enter the possible answers (if applicable). Enter %s on an line by itself to create a fill-in-the-blank answer at the end of this question. Any blank lines will be suppressed.");
define("_MB_Add_another_answer_line","Add another answer line");
define("_MB_Please_select_a_group","Please select a group.");
define("_MB_Private","Private");
define("_MB_Form_Access","Form Access");
define("_MB_This_lets_you_control","This lets you control who has access to fill out a form. Public forms let anyone submit data. Private forms are restricted by Respondent Groups.");
define("_MB_Note","Note");
define("_MB_You_must_use","You must use %s when using private forms.");
define("_MB_Group","Group");
define("_MB_Max_Responses","Max Responses");
define("_MB_Save_Restore","Save/Restore");
define("_MB_Back_Forward","Back/Forward");
define("_MB_Add","Add");
define("_MB_Make_Public","Make Public");
define("_MB_Make_Private","Make Private");
define("_MB_to_access_this_group","to access this group");
define("_MB_Cannot_delete_account","Cannot delete account.");
define("_MB_uid_are_required","uid, Password, and Group are required.");
define("_MB_Error_adding_account","Error adding account.");
define("_MB_Cannot_change_account_data","Cannot change account data.");
define("_MB_Account_not_found","Account not found.");
define("_MB_Designer_Account_Administration","Designer Account Administration");
define("_MB_uid","uid");
define("_MB_Password","Password");
define("_MB_First_Name","First Name");
define("_MB_Last_Name","Last Name");
define("_MB_Expiration","Expiration");
define("_MB_year","year");
define("_MB_month","month");
define("_MB_day","day");
define("_MB_Disabled","Disabled");
define("_MB_Update","Update");
define("_MB_Cancel","Cancel");
define("_MB_Delete","Delete");
define("_MB_Design_Forms","Design Forms");
define("_MB_Change_Form_Status","Change Form Status");
define("_MB_Activate_End","Activate/End");
define("_MB_Export_Form_Data","Export Form Data");
define("_MB_Group_Editor","Group Editor");
define("_MB_may_edit","may edit <b>all</b> forms owned by this group");
define("_MB_Administer_Group_Members","Administer Group Members");
define("_MB_Administer_Group_Respondents","Administer Group Respondents");
define("_MB_Respondent_Account_Administration","Respondent Account Administration");
define("_MB_to_access_this_form","to access this form");
define("_MB_Error_copying_form","Error copying form.");
define("_MB_Copy_Form","Copy Form");
define("_MB_Choose_a_form","Choose a form of which to make a copy. The copy will have the same status of a newly created form. You will be able to edit the form, and will have to activate it before use.");
define("_MB_Status","Status");
define("_MB_Archived","Archived");
define("_MB_Ended","Ended");
define("_MB_Active","Active");
define("_MB_Testing","Testing");
define("_MB_Editing","Editing");
define("_MB_You_are_attempting","You are attempting to cross analyze and tabulate at the same time. This is not possible!");
define("_MB_Only_superusers_allowed","Only superusers allowed.");
define("_MB_No_form_specified","No form specified.");
define("_MB_Manage_Web_Form_Designer","Manage Web Form Designer Accounts");
define("_MB_Click_on_a_uid_to_edit","Click on a uid to edit, or click on add new user below.");
define("_MB_disabled","disabled");
define("_MB_Add_a_new_Designer","Add a new Designer");
define("_MB_Bulk_Upload_Designers","Bulk Upload Designers");
define("_MB_Invalid_form_ID","Invalid form ID.");
define("_MB_DBF_download_not_yet","DBF download not yet implemented.");
define("_MB_The_PHP_dBase","The PHP dBase Extension is not installed.");
define("_MB_Edit_a_Form","Edit a Form");
define("_MB_Pick_Form_to_Edit","Pick Form to Edit");
define("_MB_Export_Data","Export Data");
define("_MB_Format","Format");
define("_MB_CSV","CSV");
define("_MB_download","download");
define("_MB_DBF","DBF");
define("_MB_HTML","HTML");
define("_MB_Testing_Form","Testing Form...");
define("_MB_SID","SID");
define("_MB_Form_exported_as","Form exported as:");
define("_MB_Error_exporting_form_as","Error exporting form as:");
define("_MB_Error_adding_group","Error adding group.");
define("_MB_Error_deleting_group","Error deleting group.");
define("_MB_Group_is_not_empty","Group is not empty.");
define("_MB_Manage_Groups","Manage Groups");
define("_MB_Description","Description");
define("_MB_Members","Members");
define("_MB_Users_guide_not_found","User's guide not found.");
define("_MB_Log_back_in","Log back in.");
define("_MB_Superuser","Superuser");
define("_MB_Choose_a_function","Choose a function");
define("_MB_Create_a_New_Form","Create a New Form");
define("_MB_Edit_an_Existing_Form","Edit an Existing Form");
define("_MB_Test_a_Form","Test a Form");
define("_MB_Copy_an_Existing_Form","Copy an Existing Form");
define("_MB_Change_the_Status_of_a_Form","Change the Status of a Form");
define("_MB_active_end_delete","(active/end/delete)");
define("_MB_Change_Access_To_a_Form","Change Access To a Form");
define("_MB_Limit_Respondents","Limit Respondents.");
define("_MB_View_Results_from_a_Form","View Results from a Form");
define("_MB_Cross_Tabulate_Form_Results","Cross Tabulate Form Results");
define("_MB_View_a_Form_Report","View a Form Report");
define("_MB_Export_Data_to_CSV","Export Data to CSV");
define("_MB_Change_Your_Password","Change Your Password");
define("_MB_Manage_Designer_Accounts","Manage Designer Accounts");
define("_MB_Manage_Respondent_Accounts","Manage Respondent Accounts");
define("_MB_View_the_list_of_things_still_to_do","View the list of things still to do");
define("_MB_development_goals","(development goals)");
define("_MB_View_the_User_Administrator_Guide","View the User &amp; Administrator Guide");
define("_MB_Log_out","Log out");
define("_MB_SIDS","SIDS");
define("_MB_Error","Error!");
define("_MB_You_need_to_select_at_least_two_forms","You need to select at least two forms!");
define("_MB_Merge_Form_Results","Merge Form Results");
define("_MB_Pick_Forms_to_Merge","Pick Forms to Merge");
define("_MB_List_of_Forms","List of Forms");
define("_MB_Forms_to_Merge","Forms to Merge");
define("_MB_Change_Password","Change Password");
define("_MB_Your_password_has_been_successfully_changed","Your password has been successfully changed.");
define("_MB_Password_not_set","Password not set, check your old password.");
define("_MB_New_passwords_do_not_match_or_are_blank","New passwords do not match or are blank.");
define("_MB_Old_Password","Old Password");
define("_MB_New_Password","New Password");
define("_MB_Confirm_New_Password","Confirm New Password");
define("_MB_Purge_Forms","Purge Forms");
define("_MB_This_page_is_not_directly","This page is not directly on the main menu because it is dangerous. This <b>completely</b> removes everything about a form from the database <b>forever</b>. All question info, general info, results, etc. are purged from the database. Do not do anything here that you are not completely certain about. There is no confirmation, there is no turning back.");
define("_MB_Qs","# Q's");
define("_MB_Clear_Checkboxes","Clear Checkboxes");
define("_MB_README_not_found","README not found.");
define("_MB_Go_back_to_Report_Menu","Go back to Report Menu");
define("_MB_View_Form_Report","View Form Report");
define("_MB_Pick_Form_to_View","Pick Form to View");
define("_MB_Add_a_new_Respondent","Add a new Respondent");
define("_MB_Bulk_Upload_Respondents","Bulk Upload Respondents");
define("_MB_Cross_Tabulation","Cross Tabulation");
define("_MB_Test_Form","Test Form");
define("_MB_Reset","Reset");
define("_MB_Cross_Tabulate","Cross Tabulate");
define("_MB_View_Form_Results","View Form Results");
define("_MB_Pick_Form_to_Cross_Tabulate","Pick Form to Cross Tabulate");
define("_MB_Respondent","Respondent");
define("_MB_Resp","Resp");
define("_MB_Can_not_set_form_status","Can not set form status.");
define("_MB_Form_Status","Form Status");
define("_MB_Test_transitions","<b>Test</b> transitions a form into testing mode. At which point you may perform a live test by taking the form, and viewing the results. You will not be able to make any further changes to the form once you have switched to test mode.");
define("_MB_Activate_transitions","<b>Activate</b> transitions a form into active mode. In this mode the form is open for production use, and may be put online. This will clear any results from testing mode (if any). No further editing of form is allowed.");
define("_MB_End_transitions","<b>End</b> transitions a form into ended mode. In this mode, no edits are possible, no users may take the form (it is inactive), but results are still viewable from the results menu.");
define("_MB_Archive_removes","<b>Archive</b> removes this form. It is still stored in the database, but no further interaction is allowed. You may <b>not</b> view the results of an archived form.");
define("_MB_Test","Test");
define("_MB_Activate","Activate");
define("_MB_End","End");
define("_MB_Archive","Archive");
define("_MB_No_tabs_defined","No tabs defined. Please check your INI settings.");
define("_MB_Help","Help");
define("_MB_General","General");
define("_MB_Questions","Questions");
define("_MB_Order","Order");
define("_MB_Preview","Preview");
define("_MB_Finish","Finish");
define("_MB_Click_cancel_to_cancel","Click cancel to cancel this form, or click continue to proceed to the next tab.");
define("_MB_The_form_title_and_other","The form title and other general fields are on the <b>General</b> tab. Individual form questions are added and modified on the <b>Questions</b> tab. Questions may be re-ordered or deleted from the <b>Order</b> tab. You may see a preview of your form at any time, by going to the <b>Preview</b> tab. If you have no further changes click <b>Finish</b> to go back to the Management Interface.");
define("_MB_Click_here_to_open_the_Help_window","Click here to open the Help window.");
define("_MB_View_Results","View Results");
define("_MB_Pick_Form_to_Test","Pick Form to Test");
define("_MB_Export","Export");
define("_MB_Results","Results");
define("_MB_Todo_list_not_found","Todo list not found.");
define("_MB_An_error_Rows_that_failed","An error occurred during upload.  Rows that failed are listed below.");
define("_MB_An_error_Please_check_the_format","An error occurred during upload.  Please check the format of your text file.");
define("_MB_An_error_Please_complete_all_form_fields","An error occurred during upload.  Please complete all form fields.");
define("_MB_Upload_Account_Information","Upload Account Information");
define("_MB_All_fields_are_required","All fields are required");
define("_MB_File_Type","File Type");
define("_MB_Tab_Delimited","Tab Delimited");
define("_MB_File_to_upload","File to upload");
define("_MB_Thank_You_For_Completing_This_Form","Thank You For Completing This Form.");
define("_MB_Please_do_not_use_the_back_button","Please do not use the back button on your browser to go back. Please click on the link below to return you to where you launched this form.");
define("_MB_Unable_to_find_the_phpESP_directory","Unable to find the phpESP %s directory. \t\t\tPlease check %s to ensure that all paths are set correctly.");
define("_MB_Gettext_Test_Failed","%%%% Gettext Test Failed");
define("_MB_Form_not_specified","Error processing form: Form not specified.");
define("_MB_Form_is_not_active","Error processing form: Form is not active.");
define("_MB_Sorry_the_account_request_form_is_disabled","Sorry, the account request form is disabled.");
define("_MB_Please_complete_all_required_fields","Please complete all required fields.");
define("_MB_Passwords_do_not_match","Passwords do not match.");
define("_MB_Request_failed","Request failed, please choose a different uid.");
define("_MB_Your_account_has_been_created","Your account, %s, has been created!");
define("_MB_Account_Request_Form","Account Request Form");
define("_MB_Please_complete_the_following","Please complete the following form to request an account. Items marked with a %s are required.");
define("_MB_Email_Address","Email Address");
define("_MB_Confirm_Password","Confirm Password");
define('_MB_LIST_SUBMITTED_DESC', 'You are already answeard.');

}

?>