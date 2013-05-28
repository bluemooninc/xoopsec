<?php
# $Id: form_results.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $
//
// Original v 1.29 2003/03/05 19:26:31 Written by James Flemer <jflemer@alum.rpi.edu>
//
require_once XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";

if(empty($GLOBALS['FMXCONFIG']['DEBUG_RESULTS'])){
	$GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] = $GLOBALS['FMXCONFIG']['DEBUG'];
}

function form_results($sid, $qid = '', $cids = '', $rid = '', $guicross='', $deny='', $defset='') {
	global $xoopsModuleConfig,$xoopsDB;

	if(is_int($cids)){
		$cids = array($cids);
	}
	// set up things differently for cross analysis
	$cross = !empty($qid);
	if($cross) {
		if($cids && count($cids)>0) {
			$cidstr = array_to_insql($cids);
		} else {
			$cidstr = 0;
		}
	}

	/* Respondent Data
	***********************************************************************************************/
	if($rid){
		$sql = "SELECT R.uid, R.submitted FROM ".TABLE_RESPONSE." R WHERE R.form_id='${sid}' and R.id='${rid}'";
		if($result = $xoopsDB->query($sql)) {
			list($curr_uname,$curr_submitted) = $xoopsDB->fetchRow($result);

		}
	}
	// build associative array holding whether each question
	// type has answer choices or not and the table the answers are in
	$has_choices = array();
	$response_table = array();
	$sql = "SELECT id,has_choices,response_table FROM ".TABLE_QUESTION_TYPE." ORDER BY id";
	if(!($result = $xoopsDB->query($sql))) {
        $errmsg = sprintf('%s [ %s: question_type ]',
                _MB_Error_system_table_corrupt, _MB_Table);
		return($errmsg);
	}
	while($row = $xoopsDB->fetchRow($result)) {
		$has_choices[$row[0]]=$row[1];
		$response_table[$row[0]]=TABLE_.$row[2];
	}


	// load form title (and other globals)
	$sql = "SELECT * FROM ".TABLE_FORM." WHERE id='${sid}'";
	if(!($result = $xoopsDB->query($sql))) {
		$errmsg = _MB_Error_opening_form ." [ ID:${sid} R:" . $xoopsDB->getRowsNum($result) ."]";
		return($errmsg);
	}
	$form = $xoopsDB->fetchArray($result);


	// load form questions
	$sql = "SELECT * FROM ".TABLE_QUESTION." WHERE form_id='${sid}' AND deleted='N' ORDER BY position,id";
	if(!($questions_result = $xoopsDB->query($sql))) {
		$errmsg = _MB_Error_opening_form .' '. _MB_No_questions_found ." [ ID:${sid} ]";
		return($errmsg);
	}

	// find out more about the question we are cross analyzing on (if any)
	if($cross) {
		$sql = "SELECT type_id FROM ".TABLE_QUESTION." WHERE id=${qid}";
		$res = $xoopsDB->fetchRow($xoopsDB->query($sql));
		$crossTable = $response_table[$res];

		if(!in_array($crossTable, array(TABLE_RESPONSE_SINGLE,TABLE_RESPONSE_BOOL,TABLE_RESPONSE_MULTIPLE))) {
			$errmsg = _MB_Error_cross_analyzing_Question_not_valid_type .' [ '. _MB_Table .": ${crossTable} ]";
			return($errmsg);
		}
	}

    $sql = "";
    if($cross) {
	    $sql = "SELECT A.response_id FROM ${crossTable} A,".TABLE_RESPONSE
	    	." R WHERE R.complete='Y' AND A.response_id=R.id AND AND A.question_id='${qid}' AND A.choice_id ${cidstr} ORDER BY A.response_id";
    } else {
	    $sql = "SELECT R.id FROM ".TABLE_RESPONSE." R WHERE R.complete='Y' AND R.form_id='${sid}' ORDER BY R.id";
    }
	/* Count Total Response
	*******************************************************************************************/
    if(!($result = $xoopsDB->query($sql))) {
	    $errmsg = _MB_Error_opening_form ." [ ID:${sid} ] [ ".$xoopsDB->error()."]";
	    return($errmsg);
    }
    $total = $xoopsDB->getRowsNum($result);
    if($total < 1) {
	    $errmsg = _MB_Error_opening_form .' '. _MB_No_responses_found ." [ ID:${sid} ]";
		    return($errmsg);
	    if ( $GLOBALS['FMXCONFIG']['DEBUG'] )
			    {
				    echo("<!-- \$errmsg = '$errmsg' -->\n");
			    }
    }
	/* Respondents ID List
	*******************************************************************************************/
	$rids = array();
	$i = 0;
	while ($row = $xoopsDB->fetchRow($result)) {
		$rid_index = ($rid == $row[0]) ? $i : 0;
		$rids[] = $row[0];
		$i ++;
	}


	/* Respondents ID Navs
	*******************************************************************************************/
	$rid_options = '<option value=""'.(!$rid ? ' selected="selected"' : '').'>----</option>';
	foreach($rids as $k => $i){
		if($rid == $i){
			$prev_rid = $k > 0 ? $rids[$k - 1] : 0;
			$next_rid = $k < count($rids)-1 ? $rids[$k + 1] : count($rids);
		}
		$rid_options .= '<option value="'.$i.'"'.(($rid == $i) ? ' selected="selected"' : '').'>'.$i.'</option>';
	}
	$ret = array(
		'respondents' => array(
			'rid_index' => $rid_index,
			'prev_rid' => isset($prev_rid) ? $prev_rid : '',
			'next_rid' => isset($next_rid) ? $next_rid : '',
			'rids' => $rids,
			'rid_options' => $rid_options,
			'current_rid' => $rid
		),
		'langs' => array(
			'prev' => _MB_Previous,
			'next' => _MB_Next,
			'individual_respondent_submissions' => _MB_Navigate_Individual_Respondent_Submissions
		)
	);
	// create a string suitable for inclusion in a SQL statement
	// containing the desired Response IDs
	// ex: "('304','311','317','345','365','370','403','439')"
	if (!empty($rid)) {
		$ridstr = "= '${rid}'";
        $total = 1;
	}else{
		$ridstr = "IN (" . ereg_replace("([^,]+)","'\\1'", join(",", $rids)) .")";
	}

	/* Form Setting Data
	***********************************************************************************************/
	$ret['form'] = $form;
	$ret['form']['sid'] = $form['id'];
	$ret["respondents"]['current_respondent'] = isset($curr_uname) ? $curr_uname : '';
	$ret["respondents"]['current_submitted'] =  isset($curr_submitted) ? $curr_submitted : NULL;

	$ret["langs"]["respondent"] = _MD_RESPONDENT;
	$ret["langs"]["crosstab_on_qid"] = _MB_Cross_analysis_on_QID;
	/* <---- by makinosuke @ 2009.1.30  */

	if($cross) {
		echo("<blockquote>" ._MB_Cross_analysis_on_QID ." ${qid}</blockquote>\n");
	}

	/* Questions Data
	***********************************************************************************************/
	$i=0; // question number counter
	$question_typeids_to_typenames = array(
		1  => 'yesno',
		2  => 'textbox',
		3  => 'essaybox',
		4  => 'radio',
		5  => 'checkbox',
		6  => 'dropdown',
		8  => 'rate',
		9  => 'date',
		10 => 'numeric',
		40 => 'attach'
	);
	while($question = $xoopsDB->fetchArray($questions_result)) {
		// process each question
		$qid = $question['id'];
		$tid = $question['type_id'];
		$table = $response_table[$tid];

		if ($tid >= 99) {
			continue;
		}
		if($cross){
			if( !in_array($tid, array(1, 4, 5, 6)) ){
				continue;
			}
		}

		/* Responses Data
		***********************************************************************************************/
		// delete these lines over time >>>>>
		$counts = array();
		// <<<<< delete these lines over time
		$responses = array(); // <---- by makinosuke @ 2009.2.3
		$responses_options = array(); // <---- by makinosuke @ 2009.2.6
		$responses_others = array(); // <---- by makinosuke @ 2009.2.6
		$responses_total = 0; // <---- by makinosuke @ 2009.2.3
		$responceCount = 0;
		switch ($table) {
			// -------------------------------- response_bool --------------------------------
			case TABLE_RESPONSE_BOOL:
				$sql = "SELECT A.choice_id, COUNT(A.response_id) FROM ${table} A
					WHERE A.question_id='${qid}' AND A.response_id ${ridstr} AND A.choice_id != '' GROUP BY A.choice_id";
				if ( $GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] )    {
					echo("<!-- \$sql = '$sql' -->\n");
				}
				if($result = $xoopsDB->query($sql)) {
					while(list($ccontent,$count) = $xoopsDB->fetchRow($result)) {
						$responses[] = $responses_options[] = array(
							'cid' => $ccontent,
							'onfocus' => in_array($ccontent, is_array($cids) ? $cids : array()) ? 1 : 0,
							'response' => ($ccontent == 'Y') ? _MB_Yes : _MB_No,
							'subtotal' => $count
						);
					}

				}
				$responceCount = count($responses);
				break;
			// -------------------------------- response_multiple --------------------------------
			case TABLE_RESPONSE_MULTIPLE:
				$res_id = array();
				$sql = "SELECT A.response_id FROM "
						.TABLE_QUESTION_CHOICE." C, ${table} A
						WHERE C.question_id='${qid}' AND
						C.content NOT LIKE '!other%' AND
						A.question_id=C.question_id AND
						A.choice_id=C.id
						GROUP BY A.response_id ORDER BY A.response_id";
				if($result = $xoopsDB->query($sql)) {
					while(list($res_tmp) = $xoopsDB->fetchRow($result)) {
						$res_id[] = $res_tmp;
					}
				}
				$sql = "SELECT A.response_id
						FROM ".TABLE_RESPONSE_OTHER."  A,".TABLE_QUESTION_CHOICE." C
						WHERE A.question_id='${qid}' AND
						A.choice_id=C.id AND
						A.response_id ${ridstr}
						GROUP BY A.response_id ORDER BY A.response_id";

				if($result = $xoopsDB->query($sql)) {
					while(list($res_tmp) = $xoopsDB->fetchRow($result)) {
						if (!in_array($res_tmp , $res_id)) {
							$res_id[] = $res_tmp;
						}
					}
				}

				$sql = "SELECT C.id, C.content, COUNT(A.response_id) AS num FROM "
						.TABLE_QUESTION_CHOICE." C, ${table} A
						WHERE C.question_id='${qid}' AND
						C.content NOT LIKE '!other%' AND
						A.question_id=C.question_id AND
						A.choice_id=C.id
						GROUP BY C.id ORDER BY C.id";

				if ( $GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] )    {
					echo("<!-- \$sql = '$sql' -->\n");
				}

				if($result = $xoopsDB->query($sql)) {

					while(list($cid, $ccontent,$count) = $xoopsDB->fetchRow($result)) {
						$responses[] = array('response' => $ccontent, 'subtotal' => $count);
						$onfocus = 0;
						if ( is_array($cids) ) {
							$onfocus = in_array($cid, $cids) ? 1 : 0;
						}
						$responses_options[] = array(
								'cid' => $cid,
								'onfocus' => $onfocus,
								'res_id' => $res_id,
								'response' => $ccontent,
								'subtotal' => $count
								);
						}
						if (isset($options)){
						foreach($options as $option){
						$responses_options[] = array('response' => $option, 'subtotal' => 0);
						}
					}
				}

				// handle 'other...'
				$sql = "SELECT A.response, C.content, COUNT(A.response) AS total
						FROM ".TABLE_RESPONSE_OTHER."  A,".TABLE_QUESTION_CHOICE." C
						WHERE A.question_id='${qid}' AND
						A.choice_id=C.id AND
						A.response_id ${ridstr}
						GROUP BY A.question_id, A.choice_id, A.response
						ORDER BY C.id, A.response";

				if ( $GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] )    {
					echo("<!-- \$sql = '$sql' -->\n");
				}

				$otherformat = $xoopsModuleConfig['CSV_OTHERF'] ? $xoopsModuleConfig['CSV_OTHERF'] : "Other: %s";
			
				if($result = $xoopsDB->query($sql)) {

					while(list($answer,$ccontent,$group_count) = $xoopsDB->fetchRow($result)) {
						$otherformat1 = $otherformat;
						if (empty($answer)){
							$otherformat1 = str_replace("(%s)","%s",$otherformat);
						}
						$content = sprintf($otherformat1, htmlspecialchars($answer) );
						$responses[] = array(
							'response' => $content, 
							'subtotal' => (isset($group_count) ? $group_count : 0)
						);
						$responses_others[] = array(
							'response' => (!empty($answer) ? $ccontent."($answer)" :$ccontent), 
							'subtotal' => (isset($group_count) ? $group_count : 0)
						);
					}
				}
				break;
			// -------------------------------- response_single --------------------------------
			case TABLE_RESPONSE_SINGLE:
/*
				$sql = "SELECT C.id, C.content, COUNT(A.response_id) AS num
						  FROM ".TABLE_QUESTION_CHOICE." C,
							   ${table} A
						 WHERE C.question_id='${qid}' AND
							   C.content NOT LIKE '!other%' AND
							   A.question_id=C.question_id AND
							   A.choice_id=C.id AND
							   A.response_id ${ridstr}
						 GROUP BY C.id ORDER BY C.id";
*/
				$sql = "SELECT C.id, C.content, COUNT(A.response_id) AS num FROM "
					.TABLE_QUESTION_CHOICE." C, ${table} A
						 WHERE C.question_id='${qid}' AND
							   C.content NOT LIKE '!other%' AND
							   A.question_id=C.question_id AND
							   A.choice_id=C.id
						 GROUP BY C.id ORDER BY C.id";

				if ( $GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] )    {
					echo("<!-- \$sql = '$sql' -->\n");
				}
				//echo $sql;die;
				if($result = $xoopsDB->query($sql)) {
					while(list($cid, $ccontent,$count) = $xoopsDB->fetchRow($result)) {
						$responses[] = array('response' => $ccontent, 'subtotal' => $count);
						$onfocus = 0;
						if ( is_array($cids) ) {
							$onfocus = in_array($cid, $cids) ? 1 : 0;
						}
						$responses_options[] = array(
							'cid' => $cid,
							'onfocus' => $onfocus,
							'response' => $ccontent,
							'subtotal' => $count
						);
					}
					if (isset($options)){
						foreach($options as $option){
							$responses_options[] = array('response' => $option, 'subtotal' => 0);
						}
					}
				}

				// handle 'other...'
				$sql = "SELECT A.response, C.content, COUNT(A.response) AS total
						  FROM ".TABLE_RESPONSE_OTHER."  A,".TABLE_QUESTION_CHOICE." C
						 WHERE A.question_id='${qid}' AND
							   A.choice_id=C.id AND
	    					   A.response_id ${ridstr}
						 GROUP BY A.question_id, A.choice_id, A.response
						 ORDER BY C.id, A.response";
				if ( $GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] )    {
					echo("<!-- \$sql = '$sql' -->\n");
				}
				$otherformat = $xoopsModuleConfig['CSV_OTHERF'] ? $xoopsModuleConfig['CSV_OTHERF'] : "Other: %s";

				if($result = $xoopsDB->query($sql)) {
					while(list($answer,$ccontent,$group_count) = $xoopsDB->fetchRow($result)) {
						$otherformat1 = $otherformat;
						if (empty($answer)){
							$otherformat1 = str_replace("(%s)","%s",$otherformat);
						}
						//$content = preg_replace(array('/^!other=/', '/^!other/'),array('', 'Other:'), $ccontent);
						$content = sprintf($otherformat1, htmlspecialchars($answer) );

						$responses[] = array('response' => $content, 'subtotal' => (isset($group_count) ? $group_count : 0));
						$responses_others[] = array('response' => (!empty($answer) ? $ccontent."($answer)" :$ccontent), 'subtotal' => (isset($group_count) ? $group_count : 0));
					}
				}
				break;
			// -------------------------------- response_text --------------------------------
			case TABLE_RESPONSE_TEXT:
				$sql = "SELECT A.response, COUNT(A.response_id) AS num
						 FROM ${table} A
						 WHERE A.question_id='${qid}' AND
	    				       A.response_id ${ridstr}
						 GROUP BY A.response";
				if($tid == 10){
					$sql .= " ORDER BY CAST(A.response AS SIGNED)";
				}
				if ( $GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] )    {
					echo("<!-- \$sql = '$sql' -->\n");
				}
				if($result = $xoopsDB->query($sql)) {
					while(list($text, $num) = $xoopsDB->fetchRow($result)) {
						if(!empty($text)){
							//$counts[htmlspecialchars($text)] = $num;
							$counts[$text] = $num;	// modified by Y.Sakai
						}
						$responses[] = array('response' => $text, 'subtotal' => $num); // <---- by makinosuke @ 2009.2.3
					}

				}
				break;
			// -------------------------------- response_date --------------------------------
			case TABLE_RESPONSE_DATE:
				$sql = "SELECT A.response, COUNT(A.response_id) AS num
						  FROM ${table} A
						 WHERE A.question_id='${qid}' AND
	    					   A.response_id ${ridstr}
						 GROUP BY A.response";
				if ( $GLOBALS['FMXCONFIG']['DEBUG_RESULTS'] )    {
					echo("<!-- \$sql = '$sql' -->\n");
				}
				if($result = $xoopsDB->query($sql)) {
					while(list($text, $num) = $xoopsDB->fetchRow($result)) {
						if(!empty($text)){
							$counts[htmlspecialchars($text)] = $num;
						}
						$responses[] = array('response' => $text, 'subtotal' => $num); // <---- by makinosuke @ 2009.2.3
					}

				}
				break;
			// -------------------------------- response_rank --------------------------------
			case TABLE_RESPONSE_RANK:
				if($tid == 8) { //Rank
					$sql = "SELECT C.Content
							FROM ".TABLE_QUESTION_CHOICE." C
							WHERE C.question_id = '${qid}'
							AND C.Content NOT LIKE '!other%'";
					$result = $xoopsDB->query($sql);
					while (list($subject_tmp) = $xoopsDB->fetchRow($result)) {
						$subjects[$subject_tmp] = array();
					}

					$sql = "SELECT C.content, A.rank, COUNT(A.rank) AS cnt
							FROM ".TABLE_QUESTION_CHOICE." C, ${table} A
							WHERE C.question_id='${qid}' AND A.question_id='${qid}' AND
								  A.choice_id=C.id AND A.rank>=0 AND A.response_id ${ridstr}
							GROUP BY C.id,A.rank";

					if($result = $xoopsDB->query($sql)) {
						$temp0 = array();
						$temp1 = array();
						$temp2 = array();
						foreach($subjects as $key => $value) {
							$temp0[$key] = $value;
							$temp1[$key] = 0;
							$temp2[$key] = 0;
						}
						while(list($subject,$rate,$subtotal) = $xoopsDB->fetchRow($result)) {
							$temp0[ $subject ][ $rate + 1  ] = $subtotal;
							if( !isset($temp1[ $subject ]) ){
								$temp1[ $subject ] = $subtotal;
							}else{
								$temp1[ $subject ] += $subtotal;
							}
							if( !isset($temp2[ $subject ]) ){
								$temp2[ $subject ] = ($rate + 1) * $subtotal;
							}else{
								$temp2[ $subject ] += ($rate + 1) *  $subtotal;
							}
						}

						$j = 0;
						foreach($temp0 as $key => $value){
							if ($temp1[$key]) {
								$responses[ $j ] = array(
									'subject' => $key,
									'total' => $temp1[ $key ],
									'average' => $temp2[ $key ] / $temp1[ $key ],
									'NA_total' => $total - $temp1[ $key ],
									'NA_total_percentage' => ($total - $temp1[ $key ]) / $total * 100,
									'rates' => array()
								);
							} else {
								$responses[ $j ] = array(
										'subject' => $key,
										'total' => 0,
										'average' => 0,
										'NA_total' => $total,
										'NA_total_percentage' => 100,
										'rates' => array()
								);
							}
							foreach(range(1,5) as $key2){
								$responses[ $j ]['rates'][ $key2 ] = array(
									'rate' => $key2,
									'subtotal' => isset($temp0[ $key ][ $key2 ]) ? $temp0[ $key ][ $key2 ] : 0,
									'percentage' => isset($temp0[ $key ][ $key2 ]) ? $temp0[ $key ][ $key2 ] / $temp1[ $key ] * 100 : 0,
									'percentage_countNA' => isset($temp0[ $key ][ $key2 ]) ? $temp0[ $key ][ $key2 ] / $total * 100 : 0
								);
							}
							$j ++;
						}

					}
				} else {
					$sql = "SELECT A.rank, COUNT(A.response_id) AS num
							  FROM ${table} A
							 WHERE A.question_id='${qid}' AND
	    						   A.response_id ${ridstr}
							 GROUP BY A.rank";
					if($result = $xoopsDB->query($sql)) {
						while(list($rank, $num) = $xoopsDB->fetchRow($result)) {
							if($rank == -1) { $rank = "N/A"; }
							$counts[_($rank)] += $num;
							$responses[] = array('response' => $rank, 'subtotal' => $num); // <---- by makinosuke @ 2009.2.3
						}

					}
				}
				break;
		}
		/* by makinosuke @ 2009.1.30 ----> */
		$question_type = $question_typeids_to_typenames[$tid];
		$responses_total = 0;
		$response_diversity = count($responses);
		$percentages_total = 0;
		$percentages_total_countNA = 0;
		if($question_type && $question_type != 'attach' && $question_type != 'rate' && $question_type != 'checkbox'){
			foreach($responses as $resdata){
				$responses_total += $resdata['subtotal'];
			}
			//if(!in_array($tid, array('essaybox', 'numeric'))){
				foreach($responses as $index => $resdata){
					$responses[$index]['percentage'] = $resdata['subtotal'] / $responses_total * 100;
					$responses[$index]['percentage_countNA'] = $resdata['subtotal'] / $total * 100;
				}
				foreach($responses_options as $index => $resdata){
					$responses_options[$index]['percentage'] = $resdata['subtotal'] / $responses_total * 100;
					$responses_options[$index]['percentage_countNA'] = $resdata['subtotal'] / $total * 100;
				}
				foreach($responses_others as $index => $resdata){
					$responses_others[$index]['percentage'] = $resdata['subtotal'] / $responses_total * 100;
					$responses_others[$index]['percentage_countNA'] = $resdata['subtotal'] / $total * 100;
				}
			//}
		}

		if($question_type && $question_type == 'checkbox'){
			$responses_total = FormMakeX_FormResultHelper::getAvailableResponseTotal($qid);
			$naTotal = FormMakeX_FormResultHelper::getNotAvailableResponseTotal($sid, $qid);

			$subtotal_total = 0;

			foreach ( $responses as $response ) {
				$subtotal_total += $response['subtotal'];
			}

			$subtotal_total_with_na = $subtotal_total + $naTotal;

			foreach($responses as $index => $resdata){
				$responses[$index]['percentage'] = $resdata['subtotal'] / $subtotal_total_with_na * 100;
				$responses[$index]['percentage_countNA'] = $resdata['subtotal'] / $total * 100;
			}
			foreach($responses_options as $index => $resdata){
				$responses_options[$index]['percentage'] = $resdata['subtotal'] / $subtotal_total_with_na * 100;
				$responses_options[$index]['percentage_countNA'] = $resdata['subtotal'] / $total * 100;
			}
			foreach($responses_others as $index => $resdata){
				$responses_others[$index]['percentage'] = $resdata['subtotal'] / $subtotal_total_with_na * 100;
				$responses_others[$index]['percentage_countNA'] = $resdata['subtotal'] / $total * 100;
			}

			$ret['form']['questions'][$i] = $question;
			$merge_data = array(
				'onfocus' => $question['id'] == $qid ? 1 : 0,
				'qid' => $question['id'],
				'typeid' => $tid,
				'responses' => $responses,
				'typename' => $question_type,
				'maxlength' => 'length',
				'total' => $total,
				'responses_options' => $responses_options,
				'responses_others' => $responses_others,
				'response_diversity' => $response_diversity,
				'responses_total' => $responses_total,
				'responses_total_countNA' => $total,
				'NA_total' => $naTotal,
				'NA_total_percentage' => $naTotal /$subtotal_total_with_na*100 ,
				'percentages_total' => 100.0,
				'percentages_total_countNA' => 100.0
			);

		} else {
			$ret['form']['questions'][$i] = $question;
			$merge_data = array(
				'onfocus' => $question['id'] == $qid ? 1 : 0,
				'qid' => $question['id'],
				'typeid' => $tid,
				'responses' => $responses,
				'typename' => $question_type,
				'maxlength' => 'length',
				'total' => $total,
				'responses_options' => $responses_options,
				'responses_others' => $responses_others,
				'response_diversity' => $response_diversity,
				'responses_total' => $responses_total,
				'responses_total_countNA' => $total,
				'NA_total' => ($total - $responses_total >= 0) ? ($total - $responses_total) : 0,
				'NA_total_percentage' => ($total - $responses_total >= 0) ? ($total - $responses_total)/$total*100 : 0,
				'percentages_total' => 100.0,
				'percentages_total_countNA' => 100.0
			);
		}

		echo $qid .":".$total."-".$responses_total."<br>";
		$ret['form']['questions'][$i] = array_merge($ret['form']['questions'][$i], $merge_data);

		if($tid == 9){ // type == date
			$date_responses_nested = array();
			foreach($ret['form']['questions'][$i]['responses'] as $value){
				$temp = explode('-', $value['response'], 4);
				// Year
				if( isset($date_responses_nested[ $temp[0] ]['subtotal']) ){
					$date_responses_nested[ $temp[0] ]['subtotal'] += $value['subtotal'];
				}else{
					$date_responses_nested[ $temp[0] ]['subtotal'] = $value['subtotal'];
				}
				$date_responses_nested[ $temp[0] ]['percentage_countNA']
					= $date_responses_nested[ $temp[0] ]['subtotal'] / $total * 100;
				// Month
				if( isset($date_responses_nested[ $temp[0] ]['month']) && !is_array($date_responses_nested[ $temp[0] ]['month']) ){
					$date_responses_nested[ $temp[0] ]['month'] = array();
				}
				if( isset($date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['subtotal']) ){
					$date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['subtotal'] += $value['subtotal'];
				}else{
					$date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['subtotal'] = $value['subtotal'];
				}
				$date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['percentage_countNA']
					= $date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['subtotal'] / $total * 100;
				// day
				if( isset($date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day']) && !is_array($date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day']) ){
					$date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day'] = array();
				}
				if( isset($date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day'][ $temp[2] ]['subtotal']) ){

					$date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day'][ $temp[2] ]['subtotal'] += $value['subtotal'];
				}else{
					$date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day'][ $temp[2] ]['subtotal'] = $value['subtotal'];
				}
				$date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day'][ $temp[2] ]['percentage_countNA']
					= $date_responses_nested[ $temp[0] ]['month'][ $temp[1] ]['day'][ $temp[2] ]['subtotal'] / $total * 100;
			}
			$ret['form']['questions'][$i]['date_responses_nested'] = $date_responses_nested;
		}
		if($tid == 10){ // type == numeric
			$temp0 = $temp1 = $temp2 = $temp3 = $temp4 = 0;
			$temp3 = PHP_INT_MAX;
			$temp5 = array();
			foreach($ret['form']['questions'][$i]['responses'] as $value){
				$temp0 += $value['subtotal']; // Valid responses total
				$temp1 += $value['response'] *  $value['subtotal'];
				$temp5 = array_pad($temp5, $temp0, $value['response']);
				// Max & Min
				if($value['response'] > $temp2){
					$temp2 = $value['response']; // Max
				}
				if($value['response'] < $temp3){
					$temp3 = $value['response']; // Min
				}
			}
			// Avg
			$ret['form']['questions'][$i]['numeric_responses_average'] = $temp1 / $temp0;
			$ret['form']['questions'][$i]['numeric_responses_max'] = $temp2;
			$ret['form']['questions'][$i]['numeric_responses_min'] = $temp3;
			// Median
			//sort($temp5, SORT_NUMERIC);
			//$ret['form']['questions'][$i]['numeric_responses_sequence'] = $temp5;
			if($temp0 % 2 == 0){
				$ret['form']['questions'][$i]['numeric_responses_median'] = ( $temp5[ $temp0 / 2 ] + $temp5[ ($temp0 / 2) - 1 ] ) / 2;
			}else{
				$ret['form']['questions'][$i]['numeric_responses_median'] = $temp5[ ($temp0 - 1) / 2 ];
			}
		}
		/* <---- by makinosuke @ 2009.1.30~2.6  */

		$i++;
	} // end while

	/* Result Controls
	***********************************************************************************************/
	global $xoopsUser;
	$admin = !empty($xoopsUser) ? $xoopsUser->isAdmin() : NULL; // by makinosuke @ 2009.2.1
	if ($admin && $rid){
		//
		// Edit Response
		//
		$ret['langs']['edit_result'] = _MD_EDITRESULT;
		//
		// Delete Response
		//
		/* by makinosuke @ 2009.1.30 ---->  */
		//$ret['deny']['process'] = !$deny? 'before' : ($deny==1) ? 'confirm' : 'after';
		$ret['langs']['deny_result_sure'] = _MD_DENYRESULTSURE;
		$ret['langs']['deny_result_done'] = _MD_DENYRESULTDONE;
		/* <---- by makinosuke @ 2009.1.30  */
		if (!$deny){// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Response Deny
			$url = $GLOBALS['FMXCONFIG']['manage'] . "?where=results&sid=$sid";
		//	echo "<HR><a href=\"".$url."&rid=".$rid."&deny=1\">"._MD_DENYRESULT."</a>";
			$ret['langs']['deny_result'] = _MD_DENYRESULT;
			$ret['deny']['process'] = 1;
		}elseif ($deny==1){
			$url = $GLOBALS['FMXCONFIG']['manage'] . "?where=results&sid=$sid";
		//	echo "<HR><a href=\"".$url."&rid=".$rid."&deny=2\">"._MD_DENYRESULTSURE."</a>";
			$ret['langs']['deny_result'] = _MD_DENYRESULTSURE;
			$ret['deny']['process'] = 2;
		}elseif ($deny==2){
			$sql = "UPDATE ".TABLE_RESPONSE." SET complete = 'N' WHERE form_id='${sid}' AND id ='${rid}'";
			$result = $xoopsDB->query($sql);
			$ret['langs']['deny_result'] = _MD_DENYRESULTDONE;
			$ret['deny']['process'] = 3;
		//	echo _MD_DENYRESULTDONE;
		}
	}
//	return; // by makinosuke @ 2009.1.30
	return $ret; // by makinosuke @ 2009.1.30
}
/* }}} */

class FormMakeX_FormResultHelper
{
	/** @var int[] */
	protected static $responseTotal = array();
	/** @var int[] */
	protected static $availableResponseTotals = array();

	/**
	 * フォームIDから回答数を返す
	 * @static
	 * @param int $formId
	 * @return int
	 */
	public static function getResponseTotalByFormId($formId)
	{
		if ( array_key_exists($formId, self::$responseTotal) === false ) {
			$database = self::_getDatabase();
			$table = $database->prefix('bmsurvey_response');
			$query = "SELECT COUNT(*) FROM $table WHERE form_id = $formId";
			$total = (int) self::_fetchColumn($query);
			self::$responseTotal[$formId] = $total;
		}

		return self::$responseTotal[$formId];
	}

	/**
	 * 無効回答数を返す
	 * @static
	 * @param int $formId
	 * @param int $questionId
	 * @return int
	 */
	public static function getNotAvailableResponseTotal($formId, $questionId)
	{
		$responseTotal = self::getResponseTotalByFormId($formId);
		$availableResponseTotal = self::getAvailableResponseTotal($questionId);
		return $responseTotal - $availableResponseTotal;
	}

	/**
	 * @static
	 * @param int $questionId
	 * @return int
	 */
	public static function getAvailableResponseTotal($questionId)
	{
		if ( array_key_exists($questionId, self::$availableResponseTotals) === false ) {
			$db = self::_getDatabase();
			$responseMultipleTable = $db->prefix('bmsurvey_response_multiple');
			$responseOtherTable    = $db->prefix('bmsurvey_response_other');

			$query = "
				SELECT COUNT(*) FROM (
					SELECT response_id
						FROM $responseMultipleTable
						WHERE question_id = $questionId

					UNION DISTINCT
						SELECT response_id
						FROM $responseOtherTable
						WHERE question_id = $questionId
				) AS response_id
			";

			$availableResponseTotal = self::_fetchColumn($query);
			$availableResponseTotal = intval($availableResponseTotal);

			self::$availableResponseTotals[$questionId] = $availableResponseTotal;
		}

		return self::$availableResponseTotals[$questionId];
	}

	/**
	 * @param string $query
	 * @return bool
	 */
	protected function _fetchColumn($query)
	{
		$database = self::_getDatabase();
		$result = $database->query($query);

		if ( $result === false ) {
			return false;
		}

		$row = $database->fetchRow($result);

		if ( is_array($row) and count($row) > 0 ) {
			return $row[0];
		}

		return false;
	}

	/**
	 * @static
	 * @return XoopsMySqlDatabase
	 */
	protected static function _getDatabase()
	{
		global $xoopsDB;
		return $xoopsDB;
	}
}

?>