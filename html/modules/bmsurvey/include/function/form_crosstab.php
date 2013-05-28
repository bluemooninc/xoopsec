<?php

function get_crosstab($sid, $qidc, $qidr){
	$qids = array($qidc, $qidr);
	$questions = array();
	foreach ($qids as $index => $qid){
		$sql = "SELECT * FROM ".TABLE_QUESTION."
			WHERE form_id='${sid}'
			AND id = '${qid}'";
		$tid_result = $xoopsDB->query($sql);
		$result = $xoopsDB->fetchArray($tid_result);
		$tids[] = $result['type_id'];
		$questions[] = array(
			'qid' => $result['id'],
			'typeid' => $result['type_id'],
			'name' => $result['name'],
			'content' => $result['content'],
			'variabletype' => $index == 0 ? 'independent' : 'dependent'
		);
		
	    unset($sql);
	    unset($result);
	}
	// Now that we know the question's type	
	// let's grab each question's choice content.
	$response_tables = array();
	foreach ($questions as $question){
		if($question['typeid'] == 1){ // Yes/No
			if($question['variabletype'] == 'independent'){ // Col
				$independent_variable_outcomes = array( _MB_Yes, _MB_No );
				$independent_variable_outcome_ids = array( 'Y', 'N' );
			}else{ // Row
				$dependent_variable_outcomes = array( _MB_Yes, _MB_No );
				$dependent_variable_outcome_ids = array( 'Y', 'N' );
			}
		}else{ // Radio, Checkbox, Dropdown(Single-Select)
			$sql = "SELECT id,content FROM ".TABLE_QUESTION_CHOICE." WHERE question_id='".($question['variabletype'] == 'independent' ? $qidc : $qidr)."' ORDER BY id";
			if ($result = $xoopsDB->query($sql)){
				while ($choice = $xoopsDB->fetchArray($result)){
					if($question['variabletype'] == 'independent'){ // Col
						$independent_variable_outcomes[] = $choice['content'];
						$independent_variable_outcome_ids[] = $choice['id'];
					}else{ // Row
						$dependent_variable_outcomes[] = $choice['content'];
						$dependent_variable_outcome_ids[] = $choice['id'];
					}
				}
			}
			
			unset($sql);
		}
		switch($question['typeid']){
			case 1:
				$response_tables[] = TABLE_RESPONSE_BOOL;
				break;
			case 4:
			case 6:
				$response_tables[] = TABLE_RESPONSE_SINGLE;
				break;
			case 5:
				$response_tables[] = TABLE_RESPONSE_MULTIPLE;
				break;
		}
	}

	$cells = array();
	$cells_percentage = array();
	$cells_expectedfrequency = array();
	$column_marginals = array();
//	array_pad($column_marginals, count( $independent_variable_outcome_ids ), 0);
	$column_marginals_sum = 0;
	$row_marginals = array();
//	array_pad($row_marginals, count( $dependent_variable_outcome_ids ), 0);
	$row_marginals_sum = 0;
	$row_marginals_percentage = array();
	
	$emptycell = 0;
    foreach ($dependent_variable_outcome_ids as $i => $yy){
		$cells[ $i ] = array();
    	foreach ($independent_variable_outcome_ids as $j => $xx){
        	$sql1 = "SELECT count(*) FROM $response_tables[0] r1, $response_tables[1] r2 ,".TABLE_RESPONSE." r3
					 WHERE (r1.question_id = '${qids[0]}' AND r1.choice_id = '${xx}')
					 AND (r2.question_id = '${qids[1]}' AND r2.choice_id = '${yy}')
					 AND r1.response_id = r2.response_id
					 AND r1.response_id = r3.id AND r2.response_id = r3.id AND r3.complete = 'Y'";
            $result1 = $xoopsDB->query($sql1);
            while (list($counts) = $xoopsDB->fetchRow($result1)){
				$emptycell = ($cells[ $i ][ $j ] = intval($counts[0])) ? 0 : 1;
				if( !isset( $column_marginals[ $j ]) ){
					$column_marginals[ $j ] = 0;
				}
				$column_marginals[ $j ]  += intval($counts[0]);
				$column_marginals_sum += intval($counts[0]);
				if( !isset( $row_marginals[ $i ]) ){
					$row_marginals[ $i ] = 0;
				}
				$row_marginals[ $i ] += intval($counts[0]);
				$row_marginals_sum += intval($counts[0]);
            }
		}
	}
	// 2nd process (Percentages, Expected frequency, and Chi-square test)
	$chi_square = 0;
	foreach($cells as $i => $cols){
		$cells_percentage[ $i ] = array();
		$cells_expectedfrequency[ $i ] = array();
		foreach($cols as $j => $cell){
			$cells_percentage[ $i ][ $j ] = $column_marginals[ $j ] ? $cell / $column_marginals[ $j ] * 100 : 0;
			if($emptycell == 0){
				$cells_expectedfrequency[ $i ][ $j ] = ($row_marginals[ $i ] * $column_marginals[ $j ]) / $row_marginals_sum;
				$chi_square += (pow($cell - $cells_expectedfrequency[ $i ][ $j ], 2) / $cells_expectedfrequency[ $i ][ $j ]);
			}
		}
		$row_marginals_percentage[ $i ] = $row_marginals_sum ? $row_marginals[ $i ] / $row_marginals_sum * 100 : 0;
	}
	$degrees_of_freedom = (count($independent_variable_outcome_ids) - 1) * (count($dependent_variable_outcome_ids) - 1);
	if($emptycell == 0){
		$chi_square_critival_values = get_chisquare_criticalvalues($degrees_of_freedom);
	}
	$ret = array(
		'variables' => array(
			'independent' => array(
				'question' => $questions[0],
				'outcomes' => $independent_variable_outcomes,
				'outcomes_count' => count( $independent_variable_outcomes )
			),
			'dependent' => array(
				'question' => $questions[1],
				'outcomes' => $dependent_variable_outcomes,
				'outcomes_count' => count( $dependent_variable_outcomes )
			)
		),
		'cells' => $cells,
		'cells_percentage' => $cells_percentage,
		'cells_expectedfrequency' => $cells_expectedfrequency,
		'chi_square' => $chi_square,
		'chi_square_critival_values' => $chi_square_critival_values ? $chi_square_critival_values : NULL,
		'degrees_of_freedom' => $degrees_of_freedom,
		'column_marginals' => $column_marginals,
		'column_marginals_sum' => $column_marginals_sum,
		'row_marginals' => $row_marginals,
		'row_marginals_percentage' => $row_marginals_percentage,
		'row_marginals_sum' => $row_marginals_sum
	);
	return $ret;
}

function get_chisquare_criticalvalues($df){
	$alpha = array( '.05', '.01' );
	$criticals = array();
	$ret = array();
	$ret['df'] = $df = intval($df);
	switch( $df ){
		case 1:
			$criticals = array(3.8414, 6.6349 );
			break;
		case 2:
			$criticals = array(5.9914, 9.2103);
			break;
		case 3:
			$criticals = array(7.8147, 11.3449);
			break;
		case 4:
			$criticals = array(9.4877, 13.2767);
			break;
		case 5:
			$criticals = array(11.0705, 15.0863);
			break;
		case 6:
			$criticals = array(12.5916, 16.8119);
			break;
		case 7:
			$criticals = array(14.0671, 18.4753);
			break;
		case 8:
			$criticals = array(15.5073, 20.0902);
			break;
		case 9:
			$criticals = array(16.9190, 21.6660);
			break;
		case 10:
			$criticals = array(18.3070, 23.2093);
			break;
		case 11:
			$criticals = array(19.6751, 24.7250);
			break;
		case 12:
			$criticals = array(21.0261, 26.2170);
			break;
		case 13:
			$criticals = array(22.3621, 27.6883);
			break;
		case 14:
			$criticals = array(23.6848, 29.1413);
			break;
		case 15:
			$criticals = array(24.9958, 30.5779);
			break;
		case 16:
			$criticals = array(26.2962, 31.9999);
			break;
		case 17:
			$criticals = array(27.5871, 33.4087);
			break;
		case 18:
			$criticals = array(28.8693, 34.8058);
			break;
		case 19:
			$criticals = array(30.1435, 36.1908);
			break;
		case 20:
			$criticals = array(31.4104, 37.5662);
			break;
		case 21:
			$criticals = array(32.6705, 38.9321);
			break;
		case 22:
			$criticals = array(33.9244, 40.2894);
			break;
		case 23:
			$criticals = array(35.1725, 41.6384);
			break;
		case 24:
			$criticals = array(36.4151, 42.9798);
			break;
		case 25:
			$criticals = array(37.6525, 44.3141);
			break;
		case 26:
			$criticals = array(38.8853, 45.6417);
			break;
		case 27:
			$criticals = array(40.1133, 46.9680);
			break;
		case 28:
			$criticals = array(41.3372, 48.2782);
			break;
		case 29:
			$criticals = array(42.5569, 49.5879);
			break;
		case 30:
			$criticals = array(43.7729, 50.8922);
			break;
		default:
			$ret['df'] = 0;
	} // End switch
	$ret['alpha'] = $alpha;
	$ret['critical_values'] = $criticals;
	return $ret;
}

?>