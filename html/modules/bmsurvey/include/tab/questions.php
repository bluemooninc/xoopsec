<?php
# $Id: questions.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $
// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>
include_once('./class/bmsurveyHtmlRender.class.php');
include_once('./class/bmsurveyModel_Question.class.php');
$fmxRender = new bmsurveyHtmlRender();

//var_dump($editForm->editInfo);

if(empty($editForm->editInfo['curr_qNumber'])) $editForm->editInfo['curr_qNumber'] = 0;
if(empty($_POST['id'])) $_POST['id'] = 0;
// update failed, stay on same question
if( !isset($_POST['q'])){
	//$editForm->isUpdated();
	$curr_qNumber = $editForm->editInfo['curr_qNumber'];
}else{
	$curr_qNumber = intval($_POST['q']);
}
//echo $curr_qNumber; die;
$sid = $editForm->editInfo['form_id'];
$id = intval($_POST['id']);

if (isset($_POST['type_id']))
    $_POST['type_id'] = intval($_POST['type_id']) ? $_POST['type_id'] : '';
else
    $_POST['type_id'] = '';

// build array of question IDs
$formQuestion = new Model_Question($sid);

if($curr_qNumber && isset($formQuestion->rows[$curr_qNumber-1])){
	$edit_qid = $formQuestion->rows[$curr_qNumber-1]['id'];
}else{
	$edit_qid = 0;
}
$editForm->edit_qid = $edit_qid;

$fields = array('name','type_id','length','precise','required','content','position');
$editQuestion = array('name'=>NULL,'type_id'=>NULL,'length'=>NULL,'precise'=>NULL,'required'=>NULL,'content'=>NULL,'position'=>NULL);
/* 
if(isset($_POST['extra_choices']) && $curr_qNumber==0){
	$edit_qid = $editForm->InsertQuestion($form_id);
	$curr_qNumber = $editForm->getNewPosition($form_id) + 1;
}*/
if( $curr_qNumber > 0 && isset($formQuestion->rows[$curr_qNumber-1])) {
	// form questions exist already
	// load values from DB
	if( is_array($formQuestion->rows[$curr_qNumber-1]))
		$editQuestion = $formQuestion->rows[$curr_qNumber-1];
}
$editQuestions['edit_qid'] = $edit_qid;
/*
 * Make number for fileds list
 */
for($i=1; $i<$formQuestion->totalRow+1; ++$i) {
	$editQuestions['qnumbers'][] = $i;
}
$editQuestions['qnumbers'][] = $i;//_MB_New_Field;
$editQuestions['curr_qNumber'] = $curr_qNumber;
$editForm->editInfo['curr_qNumber'] = $curr_qNumber;

$sql = "SELECT id, type FROM ".TABLE_QUESTION_TYPE." WHERE id != 99";
$result = $xoopsDB->query($sql);
$typeIdArr = array();
if ( !defined( BMSURVEY_QTYPE_1) ){
	$lang_typeId = array(
		1   => BMSURVEY_QTYPE_1,
		2   => BMSURVEY_QTYPE_2,
		3   => BMSURVEY_QTYPE_3,
		4   => BMSURVEY_QTYPE_4,
		5   => BMSURVEY_QTYPE_5,
		6   => BMSURVEY_QTYPE_6,
		7   => BMSURVEY_QTYPE_7,
		8   => BMSURVEY_QTYPE_8,
		9   => BMSURVEY_QTYPE_9,
		10  => BMSURVEY_QTYPE_10,
		40  => BMSURVEY_QTYPE_40,
		99  => BMSURVEY_QTYPE_99,
		100 => BMSURVEY_QTYPE_100
	);
}
while(list($key, $val) = $xoopsDB->fetchRow($result)) {
	if ( isset( $lang_typeId[$key] ) )
		$typeIdArr["$key"] = $lang_typeId[$key];
	else
		$typeIdArr["$key"] = $val;
}
if(empty($_POST['length'])) $_POST['length'] = 0;
if(empty($_POST['precise'])) $_POST['precise'] = 0;
if(empty($_POST['required'])) $_POST['required'] = 'N';
$editQuestions['input'] = array(
	'name'=>$fmxRender->mktext('name',12),
	'type_id'=>$fmxRender->mkselect('type_id',$typeIdArr),
	'length'=>$fmxRender->mktext("length",6),
	'precise'=>$fmxRender->mktext("precise",6),
	'required'=>$fmxRender->mkselect("required",array(	"Y" => _MB_Yes, "N" => _MB_No)),
	'content'=>$fmxRender->mktextarea("content",4,60,"VIRTUAL")
);
$xoopsTpl->assign('questions',$editQuestions);

$tpl_vars['content']['tab'] = array(
	'title' => _MB_Questions,
	'name' => 'questions',
	'description' => ''
);
$tpl_vars['content']['questionNav'] = array();
for($i=0; $i<$formQuestion->totalRow; ++$i) {
	$tpl_vars['content']['questionNav'][] = array(
		'num' => $i+1,
		'isCurrent' => $i+1 == $curr_qNumber ? 1 : 0,
		'name' => isset($formQuestion->rows[$i]['name']) ? $formQuestion->rows[$i]['name'] : '',
		'typeId' => isset($formQuestion->rows[$i]['type_id']) ? $formQuestion->rows[$i]['type_id'] : '',
		'typeName' => isset($typeIdArr[$formQuestion->rows[$i]['type_id']]) ? $typeIdArr[$formQuestion->rows[$i]['type_id']] : ''
	);
}
$tpl_vars['content']['currentQuestion'] = array(
	'id' => $edit_qid,
	'num' => $curr_qNumber ,
	'questionInfos' => array(
		'name' => array(
			'input' => $fmxRender->mktext('name',12,NULL,$editQuestion["name"]),
			'label' => _MB_Field_Name,
			'restrictions' => array(_MB_alpha_numeric_only)
		),
		'type_id' => array(
			'input' => $fmxRender->mkselect('type_id',$typeIdArr,$editQuestion["type_id"]),
			'label' => _MB_Type
		),
/*		'length' => array(
			'input' => $fmxRender->mktext("length",6,NULL,$editQuestion["length"]),
			'label' => _MB_Length
		),
		'precise' => array(
			'input' => $fmxRender->mktext("precise",6,NULL,NULL,$editQuestion["precise"]),
			'label' => _MB_Precision
		),*/
		'required' => array(
			'input' => $fmxRender->mkselect("required",array("Y" => _MB_Yes, "N" => _MB_No),$editQuestion["required"],0),
			'label' => _MB_Required
		),
		'content' => array(
			'input' => $fmxRender->mktextarea("content",4,60,"VIRTUAL",$editQuestion["content"]),
			'label' => BMSURVEY_TABS_QUESTIONS_QUESTION_CONTENT
		)
	)
);

$tpl_vars['langs']['question_name'] = _MB_Field_Name;
$tpl_vars['langs']['choices_description'] = BMSURVEY_TABS_QUESTIONS_CHOICES_DESC;

$xoops_module_header = '
<script language="javascript">
function clearTextInputs() {
	var i = 1;
	while (document.phpesp.elements["choice_content_" + i]) {
		document.phpesp.elements["choice_content_" + i].value = "";
		i++;
    }
}
</script>
';
/*
 *   extraChoices options add or new
 */
$formQuestion->questionHasChoices($editQuestion["type_id"]);
if( $formQuestion->has_choices=='Y' ){
	$formQuestion->questionChoice($updated,$curr_qNumber,$edit_qid);
	$tpl_vars['content']['currentQuestion']['num_choices'] = $formQuestion->questions_option['num_choices'];
	$tpl_vars['content']['currentQuestion']['choicesInfos'] = $formQuestion->questions_option['choices'];
	$xoopsTpl->assign('questions_option',$formQuestion->questions_option);
/*
** Java Script Section
*/
$xoops_module_header .='
<!--
/*<script type="text/javascript">
var optlist = new Array();
var optvkey = new Array();
foreach($js_val as $k =>$v ){
	optlist["$k"] = new Array($v);
} 
foreach($js_key as $k =>$v ){
	optvkey["$k"] = new Array($v);
} 
function setSelect2Options(val){
  var selecter = document.phpesp.copy_qid;
  var list = optlist[val];
  var vkey = optvkey[val];
 
  selecter.options.length = list.length;
  for(i=0; i<list.length; i++){
    selecter.options[i].value = vkey[i];
    selecter.options[i].text = list[i];
  }
  selecter.options[0].selected=true;
}
</script>*/
//-->
';
}

$xoopsTpl->assign('xoops_module_header', $xoopsTpl->get_template_vars('xoops_module_header').$xoops_module_header);
?>