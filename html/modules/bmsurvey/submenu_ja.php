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
$_SESSION�ѿ���ꥵ���٥���ɬ�ץǡ������ڤ�Ф��ޤ���......> qid ��Ŭ���ѹ�����������
******************************************************************************/
// qid��õ�������
//<td class="even" align="left" >��̾��</td>
//<td class="odd" align="left"><input type="text" size="30" name="31" />
//���Ϥ��줿̾�Τ򽦤��������ϡ����󥱡��ȤΥ�������ɽ�������ơ�ʸ����֭�̾�Ρפ�õ������ľ��ˤ���name="31"�ο�����ʬ��qid�Ǥ���
//
$sids = array();									// �����٥�ID�μ�������
foreach($_SESSION['bmsurvey'] as $key => $val) {	// SESSION�ѿ���Ÿ��
	if (!in_array($val['sid'], $sids))				// ��Ѥߥ����٥�ID�ʳ��ʤ�
		$sids[]=$val['sid'];						// ����Ѥߥ����٥���ID������ɲ�
	if ($val['qid'] == 31)							// �����ͤ򽦤����������qid�ǻ��ꤷ......> Ǥ�դ�qid�ͤ��ѹ�����������
		$inputname = $val['val'];					// �����ͤ��ѿ�����������
	if ($val['qid'] == 142)							// ����ʬ������ Multiple Choice �� qid......> Ǥ�դ�qid�ͤ��ѹ�����������
		$choiced_menu = explode("|",$val['val']);	// ������ܤ�Choice ID (question_choice�ơ��֥뻲��)������˳�Ǽ
}
/******************************************************************************
��˥塼ʸ��������......> cid,sid,title,url ��Ŭ���ѹ�����������
******************************************************************************/
// Usage :
//   'cid' : �ޥ�����祤�������򤵤����ܤ�ID�Ǥ���ʬ�������󥱡��ȤΥ������ǳ����ս�򸡺����뤫bmsurvey_question_choice�ơ��֥��긡������������
//           ���<input type="checkbox" name="142[]" value="384" />��������ʸ����.... ���ξ��ϡ�qid=142 cid=384 �Ȥ������ˤʤ�ޤ���
//   'sid' : �����٥�ID�Ǥ��������٥�����ΰ����κ�ü�Υʥ�С��ǻ��ꤷ�ޤ����ơ��֥�Ǥϡ�bmsurvey_form��긡���Ǥ��ޤ���
// 'title' : ���֥�˥塼��ɽ�����륢�󥱡��ȤΥ����ȥ�ʸ����Ǥ���HTML�����������������Ǥ��ޤ���
//   'url' : �����٥���URL����ꤷ�ޤ���
$form_url = XOOPS_URL."/modules/'.$mydirname.'/webform.php?name=";
$menus = array(
array('cid'=>"384", 'sid'=>"3",  'title'=>"1. ���䣱�ǣ�������ؤ��ɲü���", 'url'=>$form_url . "detail_a"),
array('cid'=>"385", 'sid'=>"4",  'title'=>"2. ���䣱�ǣ¤�����ؤ��ɲü���", 'url'=>$form_url . "detail_b"),
array('cid'=>"386", 'sid'=>"5",  'title'=>"3. ���䣱�ǣä�����ؤ��ɲü���", 'url'=>$form_url . "detail_c"),
);
/******************************************************************************
�ʲ������������ѿ������Ѥ��ƥ�å��������˥塼��ư������ޤ���
******************************************************************************/
echo "<H2>".$inputname."���󡢥��󥱡��Ȳ���ͭ�񤦤������ޤ�����³������������ܤΥ��󥱡��Ȥˤ�����������</H2>";
if (in_array( $menus[ 0]['cid'], $choiced_menu))
	if (in_array( $menus[ 0]['sid'], $sids)) echo $menus[ 0]['title'] . '<FONT color="red">...����Ѥ�</FONT><BR />';
	else echo '<A HREF="'. $menus[ 0]['url'].'">'. $menus[ 0]['title'].'</A><BR />';
if (in_array( $menus[ 1]['cid'], $choiced_menu))
	if (in_array( $menus[ 1]['sid'], $sids)) echo $menus[ 1]['title'] . '<FONT color="red">...����Ѥ�</FONT><BR />';
	else echo '<A HREF="'. $menus[ 1]['url'].'">'. $menus[ 1]['title'].'</A><BR />';
if (in_array( $menus[ 2]['cid'], $choiced_menu))
	if (in_array( $menus[ 2]['sid'], $sids)) echo $menus[ 2]['title'] . '<FONT color="red">...����Ѥ�</FONT><BR />';
	else echo '<A HREF="'. $menus[ 2]['url'].'">'. $menus[ 2]['title'].'</A><BR />';
/******************************************************************************
XOOPS footer
******************************************************************************/
include(XOOPS_ROOT_PATH.'/footer.php');
?>
