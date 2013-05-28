<?php

# $Id: form_merge.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

if(empty($GLOBALS['FMXCONFIG']['DEBUG_MERGE']))
	$GLOBALS['FMXCONFIG']['DEBUG_MERGE'] = $GLOBALS['FMXCONFIG']['DEBUG'];

/* {{{ proto string form_merge(array form_ids, int precision, bool show_totals)
   Builds a HTML result page after merging the results from
   each of the form ids.
   Return an empty string on sucess, else a string with an
   error message. */
function form_merge($sids, $precision = 1, $showTotals = 1) {
	// sanity check arguments
	if(!is_array($sids)) {
		$errmsg = _MB_Invalid_argument ." [ ${sids} ]";
		return($errmsg);
	}
	$num = count($sids);
	if($num < 1) {
		$errmsg = _MB_Invalid_argument .' [ '. join(',',$sids) .' ]';
		return($errmsg);
	}

	// set defaults
	if(empty($precision))	$precision  = 1;
	if(empty($showTotals))	$showTotals = 1;

	// convert arguments to alternate forms
	$sidstr = array_to_insql($sids);

	$response_table = esp_type_response_table();

	// load form title (and other globals) from 1st formId
	$sid = $sids[0];
	$sql = "SELECT * FROM ".TABLE_FORM." WHERE id=${sid}";
	if($GLOBALS['FMXCONFIG']['DEBUG_MERGE']) echo("<!-- \$sql = ${sql} -->\n");
	if(!($result = $xoopsDB->query($sql))) {
		$errmsg = _MB_Error_opening_form ." [ ID:${sid} R:" . $xoopsDB->getRowsNum($result) ."] [ ".$xoopsDB->error()."]";
		return($errmsg);
	}
	$form = $xoopsDB->fetchArray($result);
	

	// find total number of form responses
	$sql = "SELECT R.id FROM ".TABLE_RESPONSE." R WHERE R.form_id ${sidstr} AND R.complete='Y'";
	if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
	if(!($result = $xoopsDB->query($sql))) {
		$errmsg = _MB_Error_opening_forms ." [ ID: ${sidstr} ] [ ".$xoopsDB->error()."]";
		return($errmsg);
	}
	$total = $xoopsDB->getRowsNum($result);
	if($total < 1) {
		$errmsg = _MB_Error_opening_forms ." ".
			_MB_No_responses_found ." [ ID: ${sidstr} ] [ ". _MB_TOTAL .": ${total} ]";
		
		return($errmsg);
	}
	// and the desired response id's
	$rids = array();
	while($row = $xoopsDB->fetchRow($result)) {
		array_push($rids, $row[0]);
	}
	
	$ridstr = array_to_insql($rids);

	// load form questions
	for($i=0; $i<$num; $i++) {
		$sid = $sids[$i];
		$sql = "SELECT * FROM ".TABLE_QUESTION." WHERE form_id=${sid} AND deleted='N' ORDER BY position,id";
		if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
		$questions[$i] = $xoopsDB->query($sql);
		if(!$questions[$i]) {
			$errmsg = _MB_Error_opening_forms .' '. _MB_No_questions_found . " [ ID:${sid} ] [ ".$xoopsDB->error()."]";
			return($errmsg);
		}
	}

?>
<h2><?php echo($form["title"]); ?></h2>
<h3><?php echo($form["subtitle"]); ?></h3>
<blockquote><?php echo($form["info"]); ?></blockquote>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<?php
	$q=0; // question number counter
	while(1) {
		// get next question from each of SIDs (lock-step)
		$qids = array();
		for($i=0; $i<$num; $i++) {
			if(!($question[$i] = $xoopsDB->fetchArray($questions[$i]))) {
				echo("</table>\n");
				return;
			}
			if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$i = $i; \$question[\$i]['id'] = ".$question[$i]['id']." -->\n");
			array_push($qids, $question[$i]['id']);
		}
		$qidstr = array_to_insql($qids);
		if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$qidstr = $qidstr -->\n");

		// now -- we assume the forms are identical, and there is a
		// one-to-one relation between the questions of each
		// we take the first element of the SIDs array to be the "master"

		$tid = $question[0]['type_id'];
		$table = $response_table[$tid];
		if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$table = $table -->\n");

		if($tid == 99) {
			echo("<tr><td><hr></td></tr>\n");
			continue;
		}
		if($tid == 100) {
			echo("<tr><td>". $question[0]['content'] ."</td></tr>\n");
			continue;
		}

		++$q;

		if($bg != '#eeeeee')	$bg = '#eeeeee';
		else                	$bg = '#ffffff';
?>
	<tr xbgcolor="<?php echo($bg); ?>">
 		<td>
			<A NAME="Q<?php echo($q); ?>"><?php echo($q); ?>.</A>
			<?php echo($question[0]['content']); ?>

			<blockquote>
<?php
		$counts = array();

		switch($table) {
// -------------------------------- response_bool --------------------------------
		case TABLE_RESPONSE_BOOL:
			$sql = "SELECT A.choice_id, COUNT(A.response_id)
					  FROM ${table} A
					 WHERE A.question_id ${qidstr} AND
						   A.response_id ${ridstr}
					 GROUP BY A.choice_id";
			if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
			$result = $xoopsDB->query($sql);
			while(list($text,$count) = $xoopsDB->fetchRow($result)) {
				$counts[$text] = $count;
			}
			

			if(empty($question[0]['result_id']))
				$question[0]['result_id'] = 1;	// default to percentages for yes/no

			break;

// -------------------------------- response_single ----------------------------------
// -------------------------------- response_multiple --------------------------------
		case 'response_multiple':
			$showTotals = 0;
		case 'response_single':
			for($i=0; $i<$num; $i++) {
				$sid = $sids[$i];
				$qid = $question[$i]['id'];
				$sql = "SELECT id
					      FROM ".TABLE_QUESTION_CHOICE."
						 WHERE question_id=${qid} AND
							   content NOT LIKE '!other%'
						 ORDER BY id";
				if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
				$result = $xoopsDB->query($sql);
				$cids[$i] = array();
				while(list($cid) = $xoopsDB->fetchRow($result)) {
					array_push($cids[$i],$cid);
				}
				
			}
			$content = array();
			foreach($cids[0] as $cid) {
				$sql = "SELECT content FROM ".TABLE_QUESTION_CHOICE." WHERE id=${cid}";
				if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
				$res = $xoopsDB->fetchRow($xoopsDB->query($sql));
				array_push($content, $res);
				
			}
			$cnum = count($content);
			for($j=0; $j<$cnum; $j++) {
				$mycids = array();
				for($i=0; $i<$num; $i++) {
					array_push($mycids, $cids[$i][$j]);
				}
				$mycidstr = array_to_insql($mycids);

				$sql = "SELECT COUNT(*)
						  FROM ${table} A
						 WHERE A.choice_id ${mycidstr} AND
							   A.response_id ${ridstr}";
				if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
				list($res)=$xoopsDB->fetchRow($xoopsDB->query($sql));
				$counts[$content[$j]] = $res;
				
			}

			// handle 'other...'
			for($i=0; $i<$num; $i++) {
				$sid = $sids[$i];
				$qid = $question[$i]['id'];
				$sql = "SELECT id
					      FROM ".TABLE_QUESTION_CHOICE."
						 WHERE question_id ${qidstr} AND
							   content LIKE '!other%'
						 ORDER BY id";
				if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
				$result = $xoopsDB->query($sql);
				$cids[$i] = array();
				while(list($cid) = $xoopsDB->fetchRow($result)) {
					array_push($cids[$i],$cid);
				}
				
			}
			$content = array();
			foreach($cids[0] as $cid) {
				$sql = "SELECT content FROM ".TABLE_QUESTION_CHOICE." WHERE id=${cid}";
				if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
				$res = $xoopsDB->fetchRow($xoopsDB->query($sql));
				$text = ereg_replace("!other=?", "", $res);
				if(!empty($text))
					$text .= ': ';
				array_push($content, $text);
				
			}
			$cnum = count($content);
			for($j=0; $j<$cnum; $j++) {
				$mycids = array();
				for($i=0; $i<$num; $i++) {
					array_push($mycids, $cids[$i][$j]);
				}
				$mycidstr = array_to_insql($mycids);

				$sql = "SELECT A.response, COUNT(A.response_id)
						  FROM ".TABLE_RESPONSE_OTHER."  A
						 WHERE A.choice_id ${mycidstr} AND
							   A.response_id ${ridstr}
						 GROUP BY A.response";
				if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
				$result=$xoopsDB->query($sql);
				while(list($response,$count) = $xoopsDB->fetchRow($result)) {
					if(!empty($response)) {
						$text = $content[$j] . htmlspecialchars($response);
						$counts[$text] = $count;
					}
				}
				
			}

			if(empty($question[0]['result_id']))
				$question[0]['result_id'] = 1;	// default to percentages

			break;
// -------------------------------- response_text --------------------------------
		case 'response_text':
			$sql = "SELECT A.response, COUNT(A.response_id)
					  FROM ${table} A
					 WHERE A.question_id ${qidstr} AND
						   A.response_id ${ridstr}
					 GROUP BY A.response";
			if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
			$result = $xoopsDB->query($sql);
			while(list($response, $count) = $xoopsDB->fetchRow($result)) {
				if(!empty($response))
					$counts[htmlspecialchars($response)] = $count;
			}
			

			$question[0]['result_id'] = 4;	// force "list" type response for text fields

			break;
// -------------------------------- response_rank --------------------------------
		case 'response_rank':
			if($tid == 8) { //Rank
				for($i=0; $i<$num; $i++) {
					$sid = $sids[$i];
					$qid = $question[$i]['id'];
					$sql = "SELECT id
					          FROM ".TABLE_QUESTION_CHOICE."
							 WHERE question_id ${qidstr}
							 ORDER BY id";
					if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
					$result = $xoopsDB->query($sql);
					$cids[$i] = array();
					while(list($cid) = $xoopsDB->fetchRow($result)) {
						array_push($cids[$i],$cid);
					}
					
				}
				$content = array();
				foreach($cids[0] as $cid) {
					$sql = "SELECT content FROM ".TABLE_QUESTION_CHOICE." WHERE id=${cid}";
					if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
					$res = $xoopsDB->fetchRow($xoopsDB->query($sql));
					array_push($content, $res);
					
				}
				$cnum = count($content);
				for($j=0; $j<$cnum; $j++) {
					$mycids = array();
					for($i=0; $i<$num; $i++) {
						array_push($mycids, $cids[$i][$j]);
					}
					$mycidstr = array_to_insql($mycids);

					$sql = "SELECT AVG(A.rank)
							  FROM ${table} A
							 WHERE A.choice_id ${mycidstr} AND
								   A.response_id ${ridstr} AND
								   A.rank>0";
					if($GLOBALS['FMXCONFIG']['DEBUG_MERGE'])	echo("<!-- \$sql = ${sql} -->\n");
					$res = $xoopsDB->fetchRow($xoopsDB->query($sql));
					$counts[$content[$j]] = $res;
					
				}

				$question[0]['result_id'] = 99;	// force to rank
			} else {
				// deprecated ... I am not going to write this
				// code. If you need it email me or write it yourself.
			}
			break;
		}
// ---------------------------------------------------------------------------
		switch($question[0]['result_id']) {
			case '1':	// Percentages
				mkrespercent($counts,$total,$precision,$showTotals);
				break;
			case '2':	// Rank
				mkresrank($counts,$total,$precision,$showTotals);
				break;
			case '3':	// Count
				mkrescount($counts,$total,$precision,$showTotals);
				break;
			case '4':	// List
				mkreslist($counts,$total,$precision,$showTotals);
				break;
			case '99':	// Average
				mkresavg($counts,$total,$precision,$showTotals,0);
				break;
		} // end switch
?>
			</blockquote>
		</td>
	</tr>
<?php	} // end while -- execution should never pass this point ?>
</table>
<?php
	return;
}
/* }}} */

?>