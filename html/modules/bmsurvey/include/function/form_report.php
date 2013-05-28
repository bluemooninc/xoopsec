<?php
// $Id: form_report.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

/* {{{ proto string form_report(int form_id, bool details, string format)
    Build a description of a form, including all unique ids.
	Rerturns an empty string on success, else an error message. */
function form_report($sid, $details = 0, $format = '') {
	if(empty($sid)) return;
	$bg = '';
	// build associative array holding weather each question
	// type has answer choices or not and the table the answers are in
	$has_choices = array();
	$response_table = array();
	$sql = "SELECT id,has_choices,response_table FROM ".TABLE_QUESTION_TYPE." ORDER BY id";
	if(!($result = $xoopsDB->query($sql))) {
		$errmsg = _MB_Error_system_table_corrupt ." [ ". _MB_Table .": question_type ]";
		return($errmsg);
	}
	while($row = $xoopsDB->fetchRow($result)) {
		$has_choices[$row[0]] = $row[1];
		$response_table[$row[0]] = $row[2];
	}
	

	// load form title (and other globals)
	$sql = "SELECT * FROM ".TABLE_FORM." WHERE id='$sid'";
	if(!($result = $xoopsDB->query($sql))) {
		$errmsg = _MB_Error_opening_form ." [ ID:${sid} R:" . $xoopsDB->getRowsNum($result) ."]";
		return($errmsg);
	}
	$form = $xoopsDB->fetchArray($result);
	

	// load form questions
	$sql = "SELECT * FROM ".TABLE_QUESTION."
			 WHERE form_id='$sid' AND deleted='N'
			 ORDER BY position";
	if(!($questions_result = $xoopsDB->query($sql))) {
		$errmsg = _MB_Error_opening_form .' '. _MB_No_questions_found ." [ ID:${sid} ]";
		return($errmsg);
	}
?>
<h2><?php echo(_MB_Report_for); echo (': '. $form["title"] .' ['. _MB_ID .': '. $form['id'] .']'); ?></h2>
<h3><?php echo($form["subtitle"]); ?></h3>
<blockquote><?php echo($form["info"]); ?></blockquote>
<table border="0" cellspacing="2" cellpadding="0" width="100%">
<tr>
	<th align="left"><?php echo(_MB_Num); ?></th>
	<th align="left"><?php echo(_MB_ID); ?></th>
	<th align="left"><?php echo(_MB_Req_d); ?></th>
	<th align="left"><?php echo(_MB_Public); ?></th>
	<th align="left" colspan="2"><?php echo(_MB_Content); ?></th>
</tr>
<?php
	$i = 0;
	while($question = $xoopsDB->fetchArray($questions_result)) {
		// process each question
		$qid   = &$question['id'];
		$tid   = &$question['type_id'];
		$reqd  = ($question['required'] == 'Y') ?
					_MB_Yes : _MB_No;
		$publ  = ($question['public'] == 'Y') ?
					_MB_Yes : _MB_No;
		$table = &$response_table[$tid];

		if ($tid == 99) {
			echo("<tr><td colspan=\"6\"><hr></td></tr>\n");
			continue;
		}

		if($bg != '#ffffff')	$bg = '#ffffff';
		else					$bg = '#eeeeee';

?>
<tr bgcolor="<?php echo($bg); ?>">
 	<td align="right"><?php if ($tid < 50) echo(++$i); ?></td>
	<th align="right"><?php echo($qid); ?></th>
	<td><?php echo($reqd); ?></td>
	<td><?php echo($publ); ?></td>
	<td colspan="2"><?php echo($question["content"]); ?></td>
</tr>
<?php
		if($has_choices[$tid]) {
			$sql = "SELECT * FROM ".TABLE_QUESTION_CHOICE."
					 WHERE question_id = $qid
					 ORDER BY id";
 			$choices_result = $xoopsDB->query($sql);
			while($choice = $xoopsDB->fetchArray($choices_result)) {
?>
<tr bgcolor="<?php echo($bg); ?>"><th align="left"></th>
	<td></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<th align="right"><?php echo($choice['id']); ?></th>
	<td><?php echo($choice['content']); ?></td>
</tr>
<?php
			}

		} // end if has_choices
	} // end while
	
?>
</table>
<?php
	return;
}
/* }}} */

?>