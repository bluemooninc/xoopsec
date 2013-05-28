<?php # $Id: crossset.php,v 1.0 2009/02/10 09:30:00 makinosuke Exp $
$xoopsOption['template_main'] = 'bmsurvey_manage.html';

if($sid){
	$form = array();
	
	// load form data by sid
	$sql = "SELECT * FROM ".TABLE_FORM." WHERE id='${sid}'";
	if(!($result = $xoopsDB->query($sql))) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/', 2, _MB_Error_opening_form ." [ ID:${sid} R:" . $xoopsDB->getRowsNum($result) ."]");
		exit;
		
	}
	$form = $xoopsDB->fetchArray($result);
	$form['sid'] = $form['id'];
	
	
	// load questions data by sid
	$sql = "SELECT * FROM ".TABLE_QUESTION." WHERE form_id='${sid}' AND type_id IN ('1','4','5','6') AND deleted='N' ORDER BY position,id";
	if(!($questions_result = $xoopsDB->query($sql))) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/', 2, _MB_Error_opening_form .' '. _MB_No_questions_found ." [ ID:${sid} ]");
		exit;
	}
	
	$typenames = array(
		1  => 'yesno',
		4  => 'radio',
		5  => 'checkbox',
		6  => 'dropdown',
	);
	$i = 0;
	$form['questions'] = array();
	while($question = $xoopsDB->fetchArray($questions_result)) {
		// process each question
		$form['questions'][$i] = $question;
		$form['questions'][$i]['qid'] = $question['id'];
		$form['questions'][$i]['typeid'] = $question['type_id'];
		$form['questions'][$i]['typename'] = $typenames[ $question['type_id'] ];
		
		$outcomes = array();
		if($question['type_id'] == 1){ // Yes/No
			$outcomes = array(
				array( 'content' => _MB_Yes, 'id' => 'Y' ),
				array( 'content' => _MB_No, 'id' => 'N' )
			);
		}else{ // Radio, Checkbox, Dropdown(Single-Select)
			$sql = "SELECT id,content FROM ".TABLE_QUESTION_CHOICE." WHERE question_id='".$question['id']."' ORDER BY id";
			if ($result = $xoopsDB->query($sql)){
				while ($choice = $xoopsDB->fetchArray($result)){
					$outcomes[] = array('content' => $choice['content'], 'id' => $choice['id']);
				}
				
			}
		}
		$form['questions'][$i]['outcomes'] = $outcomes;
		$i ++;
	}
	
	
	
	$xoopsTpl->assign('form', $form);
	$show_formlist = FALSE;
}

?>