<?PHP
//  ------------------------------------------------------------------------ //
//                Bluemoon.Multi-Form                                      //
//                    Copyright (c) 2006 Yoshi.Sakai @ Bluemoon inc.         //
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
/******************************************************************************
XOOPS Header
******************************************************************************/
require('../../mainfile.php');
require(XOOPS_ROOT_PATH.'/header.php');
/******************************************************************************
Pick up form data from $_SESSION ......> Customize qid parameter as yourself.
******************************************************************************/
// How to search qid parameter
//Example Souce:
//    <td class="even" align="left" >Your Name</td>
//    <td class="odd" align="left"><input type="text" size="30" name="Q31" />
//If you want to pickup answer of 'Your name', then search 'your name ' by source view from your browser.
//And take a look name of input tag. That is qid. (Example is "Q31")
//
$sids = array();									// For pick up form ids.
foreach($_SESSION['bmsurvey'] as $key => $val) {	// Spread a SESSION value.
	if (!in_array($val['sid'], $sids))				// Find unpickuped form id
		$sids[]=$val['sid'];						//   then push to Form id correction.
	if ($val['qid'] == 1)							// Check target qid or not......> Change the number as yourself.
		$inputname = $val['val'];					//   then copy from value
	if ($val['qid'] == 5)							// Check target qid as multiple choice......> Change the number as yourself.
		$choiced_menu = explode("|",$val['val']);	//   then explode Choice ID (this id from question_choice table) and set to correction.
}
/******************************************************************************
Definission for menu strings......> Change cid,sid,title,url as yourself.
******************************************************************************/
// Usage :
//   'cid' : It is ID of the item selected by the multi choice. Please retrieve the corresponding section by the source of the former divergence questionnaire or retrieve it from the bmsurvey_question_choice table.
//           Ex><input type="checkbox" name="Q142[]" value="384" />question strings.... This mean qid=142 cid=384.
//   'sid' : It is form ID. It specifies it by the number of left ends of the list of the form management. In the table, it is possible to retrieve it from bmsurvey_form.
// 'title' : It is a title string of the questionnaire displayed in the submenu. It is possible to decorate it as HTML tag.
//   'url' : Set the URL with form name parameter.
$form_url = XOOPS_URL."/modules/'.$mydirname.'/webform.php?name=";
$menus = array(
array('cid'=>"10", 'sid'=>"2",  'title'=>"1. Additional question to answer in question 1 as A", 'url'=>$form_url . "detail_a"),
array('cid'=>"11", 'sid'=>"3",  'title'=>"2. Additional question to answer in question 1 as B", 'url'=>$form_url . "detail_b"),
array('cid'=>"12", 'sid'=>"4",  'title'=>"3. Additional question to answer in question 1 as C", 'url'=>$form_url . "detail_c"),
);
/******************************************************************************
Display the Secondaly menu.
******************************************************************************/
echo "<H2>Hello ".$inputname.". Thank you for answer. Please proceed next questions.</H2>";
if (in_array( $menus[ 0]['cid'], $choiced_menu))
	if (in_array( $menus[ 0]['sid'], $sids)) echo $menus[ 0]['title'] . '<FONT color="blue">...Ansered</FONT><BR />';
	else echo '<A HREF="'. $menus[ 0]['url'].'"><FONT size="4" color="red">'. $menus[ 0]['title'].'</FONT></A><BR />';
if (in_array( $menus[ 1]['cid'], $choiced_menu))
	if (in_array( $menus[ 1]['sid'], $sids)) echo $menus[ 1]['title'] . '<FONT color="blue">...Ansered</FONT><BR />';
	else echo '<A HREF="'. $menus[ 1]['url'].'"><FONT size="4" color="red">'. $menus[ 1]['title'].'</FONT></A><BR />';
if (in_array( $menus[ 2]['cid'], $choiced_menu))
	if (in_array( $menus[ 2]['sid'], $sids)) echo $menus[ 2]['title'] . '<FONT color="blue">...Ansered</FONT><BR />';
	else echo '<A HREF="'. $menus[ 2]['url'].'"><FONT size="4" color="red">'. $menus[ 2]['title'].'</FONT></A><BR />';
/******************************************************************************
XOOPS footer
******************************************************************************/
include(XOOPS_ROOT_PATH.'/footer.php');
?>
