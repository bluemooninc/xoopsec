<?php

# $Id: form_copy.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

/* {{{ proto void add_squotes(string* value, string key)
   Adds single quotes to value. */
function add_squotes (&$val, $key) {
	$val = "'" . addcslashes($val,"\\'") . "'";
}
/* }}} */

/* {{{ proto bool form_copy(int form_id)
   Creates an editable copy of a form. */
function form_copy($sid) {
	global $xoopsDB,$xoopsUser;
	$sql = "SELECT * FROM ".TABLE_FORM." WHERE id='${sid}'";
	$result = $xoopsDB->query($sql);
	if($xoopsDB->getRowsNum($result) != 1)
		return(false);
	$form = $xoopsDB->fetchArray($result);
	

	// clear the sid, clear the creation date, change the name, and clear the status
	$form['id'] = '';
	$form['owner'] = $xoopsUser->uid();
	$form['name'] .= '_copy';
	$form['status'] = 0;
	$dtstamp = date( 'Ymd\THis\Z' , time() ) ;
	$form['changed'] = $dtstamp;

	// check for 'name' conflict, and resolve
	$sql = "SELECT COUNT(*) FROM ".TABLE_FORM." WHERE name='". $form['name'] ."'";
	list($cnt) = $xoopsDB->fetchRow( $xoopsDB->query($sql) ) ;
	$i=0;
	while( $cnt > 0 ) {
		$sql = "SELECT COUNT(*) FROM ".TABLE_FORM." WHERE name='". $form['name'] . ++$i ."'";
		list($cnt) = $xoopsDB->fetchRow( $xoopsDB->query($sql) ) ;
	}
	$titleNums = '';
	if($i>0){
		$form['name'] .= $i;
		if ($i>1) $titleNums = "(" . $i . ") ";
	}
	$form['title'] = sprintf(_MD_BMSURVEY_COPY_TITLE_PREFIX,$titleNums) . $form['title'];
	$form['changed'] = date('Y-m-d H:i:s');
	// create new form
	array_walk($form, 'add_squotes');
	$sql  = "INSERT INTO ".TABLE_FORM;
	$sql .= ' ('. join(',',array_keys($form)) .') ';
	$sql .= 'VALUES ( '. join(',',array_values($form)) .' )';
	//echo $sql; die;
	$result = $xoopsDB->queryF($sql);
	if(!$result)
		return(false);
	$new_sid = $xoopsDB->getInsertId();

	$formQuestion = new Model_Question($sid);
	$has_choices = $formQuestion->esp_type_has_choices();
	
	// make copies of all the questions
	$sql = "SELECT * FROM ".TABLE_QUESTION." WHERE form_id='${sid}' AND deleted='N' ORDER by position,id";

	$result = $xoopsDB->query($sql);
	$pos=1;
	while($question = $xoopsDB->fetchArray($result)) {
		$tid = $question['type_id'];
		$qid = $question['id'];

		// fix some fields first
		$question['id'] = '';
		$question['form_id'] = $new_sid;
		$question['position'] = $pos++;

		// copy question to new form
		array_walk($question,'add_squotes');
		$sql = "INSERT INTO ".TABLE_QUESTION." ";
		$sql .= '('. join(',',array_keys($question)) .') ';
		$sql .= 'VALUES ( '. join(',',array_values($question)) .' )';
		if(!$xoopsDB->queryF($sql))
			return(false);
		$new_qid = $xoopsDB->getInsertId();

		// make copies of all the question choices (if exist)
		if($has_choices[$tid]) {
			$sql = "SELECT * FROM ".TABLE_QUESTION_CHOICE."
				WHERE question_id='${qid}'
				ORDER BY id";
			$result2 = $xoopsDB->query($sql);
			while($choice = $xoopsDB->fetchArray($result2)) {
				$choice['id'] = '';
				$choice['question_id'] = $new_qid;

				array_walk($choice,'add_squotes');
				$sql = "INSERT INTO ".TABLE_QUESTION_CHOICE." ";
				$sql .= '('. join(',',array_keys($choice)) .') ';
				$sql .= 'VALUES ( '. join(',',array_values($choice)) .' )';
				if(!$xoopsDB->queryF($sql))
					return(false);
			}
			
		}
	}
	

	return(true);
}
/* }}} */

?>
