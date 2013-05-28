<?php
include_once('bmsurveyModel_Question.class.php');

class responseLoader  extends Model_Question{
	var $responseId = 0;
	var $responseValues = array();
	var $load_bool = FALSE;
	var $load_single = FALSE;
	var $load_multiple = FALSE;
	var $load_other = FALSE;
	var $load_rank = FALSE;
	var $load_text = FALSE;
	var $load_date = FALSE;
	
	function responseLoader($responseId=0){
		$this->responseId = $responseId;
	}
	// --------------------- response_bool ---------------------
	function response_bool($responseId){
		global $xoopsDB;
		$sql = "SELECT * FROM ".TABLE_RESPONSE_BOOL." WHERE response_id='${responseId}'";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchArray($result)) {
			$this->responseValues[$row['question_id']] = $row['choice_id'];// == 'Y' ? _MB_Yes : _MB_No;
		}
	}
	// --------------------- response_single ---------------------
	function response_single($responseId){
		global $xoopsDB;
		
		$sql = "SELECT a.question_id,c.content,c.id FROM ".TABLE_RESPONSE_SINGLE." a, "
			.TABLE_QUESTION_CHOICE." c WHERE a.response_id='${responseId}' AND a.choice_id=c.id";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchArray($result)) {
			if (preg_match('/^!other/i', $row['content'])) $row['id'] = 'other_' . $row['id'];
			$this->responseValues[$row['question_id']] = array(	"Q".$row['question_id'] => $row['id']);
		}
	}
	
	// --------------------- response_multiple ---------------------
	function response_multiple($responseId){
		global $xoopsDB;
		$sql = "SELECT a.question_id, c.content,c.id FROM ".
			TABLE_RESPONSE_MULTIPLE."  a, ".TABLE_QUESTION_CHOICE.
			" c WHERE a.response_id='${responseId}' AND a.choice_id=c.id ORDER BY a.question_id,c.id";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchArray($result)) {
			if (preg_match('/^!other/i', $row['content'])) $row['id'] = 'other_' . $row['id'];
			$this->responseValues[$row['question_id']][] = $row['id'];
		}
	}	
	
	// --------------------- response_other ---------------------
	function response_other($responseId){
		global $xoopsDB;
		$sql = "SELECT question_id, choice_id, response FROM ".TABLE_RESPONSE_OTHER." WHERE response_id='${responseId}'";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchArray($result)) {
			$this->responseValues[$row['question_id']]["Q${row['question_id']}_${row['choice_id']}"] = $row['response'];
		}
	}	
	/*
	
	// --------------------- response_rank ---------------------
	$sql = "SELECT CONCAT($order,'_',c.id) AS id $col,c.content,a.rank FROM ".
		TABLE_RESPONSE_RANK."  a, ".TABLE_QUESTION." q, ".TABLE_QUESTION_CHOICE.
		" c WHERE a.response_id='${rid}' AND a.question_id=q.id AND a.choice_id=c.id $qids ORDER BY a.question_id,c.id";
	$result = $xoopsDB->query($sql);
	while($row = $xoopsDB->fetchRow($result)) {
		$qid = array_shift($row);
		settype($row[count($row) - 1], 'integer');
		$values[$qid] = $row;
	}
	*/
	// --------------------- response_text ---------------------
	function response_text($responseId=0){
		global $xoopsDB;
		$sql = "SELECT question_id,response FROM ".TABLE_RESPONSE_TEXT
			." WHERE response_id='$responseId'";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchArray($result)) {
			$this->responseValues[$row['question_id']] = $row['response'];
		}
	}

	// --------------------- response_date ---------------------
	function response_date($responseId){
		global $xoopsDB;
		$sql = "SELECT * FROM ".TABLE_RESPONSE_DATE." WHERE response_id='${responseId}'";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchArray($result)) {
			$this->responseValues[$row['question_id']] = $row['response'];
		}
	}	
	/*
	 * Loading default response data.
	 */
	function loadDefaultValue($typeid,$defaultRid){
		if(!isset($defaultRid)) return;
		switch($typeid) {
			case 1:
				if (!$this->load_bool){
					$this->load_bool = TRUE;
					$this->response_bool($defaultRid);
				}
				break;
/*

				if (!$this->has_single ){
				}
				if (!$this->has_multiple){
				}
				if (!$this->has_other){
					
				}
				if (!$this->has_rank){
				
				}
*/
			case 2:
			case 3:
				if (!$this->load_text ){
					$this->load_text = TRUE;
					$this->response_text($defaultRid);
				}
				break;
			case 4:
			case 6:
				if (!$this->load_single){
					$this->load_single = TRUE;
					$this->response_single($defaultRid);
				}
				if (!$this->load_other){
					$this->load_other = TRUE;
					$this->response_other($defaultRid);
				}
				break;
			case 5:
				if (!$this->load_multiple){
					$this->load_multiple = TRUE;
					$this->response_multiple($defaultRid);
				}
				if (!$this->load_other){
					$this->load_other = TRUE;
					$this->response_other($defaultRid);
				}
				break;
			case 9:
				if (!$this->load_date ){
					$this->load_date = TRUE;
					$this->response_date($defaultRid);
				}
				break;
		}
	}
	/* {{{ proto array response_select(int form_id, int response_id, array columns, array question_ids)
	   Returns the values from the specific response in a sorted
	   (associative) array indexed by question_id.
	   
	   The key in the associative array is the Question ID, or in the case
	   of "!other", or rank questions the Question ID concatenated with the
	   Choice ID ("${qid}_${cid").  The value for all types is an array. 
	   This array contains any columns requested by the parameter $col as
	   the first elements.  The last two elements are the response content,
	   and the content ID respectively.  (For multiple answer questions,
	   the value is an array of these arrays.)
	   
	   For example, for a boolean type question (ID #42) and a check box
	   type (ID #44), you might get something like:
	
		  $response_select = array(
			'42' => array(_('No'), 'N'),
			'44' => array(
					  array('Blue', 102),
					  array('Green', 104)
					)
			);
	
	   When in doubt, consult var_dump() as to the format of the returned
	   array.
	 */
	function response_select($sid, $rid, $col = null, $qids = null,$order = null, $makenumber=null) {
		global $xoopsDB;
	
		$values = array();
	
		if ($col == null) {
			$col = '';
		}
		if (!is_array($col) && !empty($col)) {
			$col = explode(',', preg_replace("/\s/",'', $col));
		}
		if (is_array($col) && count($col) > 0) {
			$col = ',' . implode(',', array_map(create_function('$a','return "q.$a";'), $col));
		}
	
		if ($qids == null) {
			$qids = '';
		} elseif (is_array($qids)) {
			$qids = 'AND a.question_id ' . array_to_insql($qids);
		} elseif (intval($qids) > 0) {
			$qids = 'AND a.question_id = ' . intval($qids);
		} else {
			$qids = '';
		}
		if ($order == null) {
			$order = 'q.id';
		}
		// --------------------- response_bool ---------------------
		$sql = "SELECT $order $col,a.choice_id FROM ".TABLE_RESPONSE_BOOL." a, ".TABLE_QUESTION." q WHERE a.response_id='${rid}' AND a.question_id=q.id $qids";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchRow($result)) {
			$qid = array_shift($row);
			$val = array_pop($row);
			$values[$qid] = $row;
			array_push($values["$qid"], ($val == 'Y') ? _MB_Yes : _MB_No, $val);
		}
		
	
		// --------------------- response_single ---------------------
		$sql = "SELECT $order $col,c.content,c.id FROM ".TABLE_RESPONSE_SINGLE." a, ".
			TABLE_QUESTION." q, ".TABLE_QUESTION_CHOICE." c WHERE a.response_id='${rid}' AND a.question_id=q.id AND a.choice_id=c.id $qids";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchRow($result)) {
			$qid = array_shift($row);
			$c = count($row);
			$val = $row[$c - 2];
			settype($row[$c - 1], 'integer');
			// Make a Sequential number for CSV output
			if($makenumber!=null){
				$sql = "SELECT id FROM ".TABLE_QUESTION_CHOICE." WHERE question_id=$qid AND id<=".$row[$c - 1];
				$row[] = $xoopsDB->getRowsNum($xoopsDB->query($sql));
			}
			if (ereg('/^!other/i', $val)) $row[$c - 1] = 'other_' . $row[$c - 1];
			$values[$qid] = $row;
		}
		
	
		// --------------------- response_multiple ---------------------
		$sql = "SELECT $order $col, c.content,c.id FROM ".
			TABLE_RESPONSE_MULTIPLE."  a, ".TABLE_QUESTION." q, ".TABLE_QUESTION_CHOICE.
			" c WHERE a.response_id='${rid}' AND a.question_id=q.id AND a.choice_id=c.id $qids ORDER BY a.question_id,c.id";
		$result = $xoopsDB->query($sql);
		$arr = array();
		$tmp = null;
		while($row = $xoopsDB->fetchRow($result)) {
			$qid = array_shift($row);
			$c = count($row);
			$cidp = $c - 1;
			$val = $row[$c - 2];
			settype($row[$c - 1], 'integer');
			if($tmp == $qid) {
				if($makenumber!=null) $row[] = array_search($row[$c - 1],$cids);
				if (ereg('/^!other/i', $val)) $row[$cidp] = 'other_' . $row[$cidp];
				$arr[] = $row;
				continue;
			}
			if($tmp != null)
				$values["$tmp"]=$arr;
			$tmp = $qid;
			// Make a Sequential number for CSV output
			if($makenumber!=null){
				$sql = "SELECT id FROM ".TABLE_QUESTION_CHOICE." WHERE question_id=$qid ORDER BY id";
				$res = $xoopsDB->query($sql);
				$cids = array();
				$i = 1;
				while(list($cid) = $xoopsDB->fetchRow($res)) {
					$cids[$i]=$cid;
					$i++;
				}
				$row[] = array_search($row[$c - 1],$cids);
				if (ereg('/^!other/i', $val)) $row[$cidp] = 'other_' . $row[$cidp];
			}
			$arr = array($row);
		}
		if($tmp != null)
			$values["$tmp"]=$arr;
		unset($arr);
		unset($tmp);
		unset($row);
	
		// --------------------- response_other ---------------------
		$sql = "SELECT $order, c.id $col, a.response FROM ".TABLE_RESPONSE_OTHER.
			" a, ".TABLE_QUESTION." q, ".TABLE_QUESTION_CHOICE.
			" c WHERE a.response_id='${rid}' AND a.question_id=q.id AND a.choice_id=c.id $qids ORDER BY a.question_id,c.id";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchRow($result)) {
			$qid = array_shift($row);
			$cid = array_shift($row);
			array_push($row, $row[count($row) - 1]);
			$values["${qid}_${cid}"] = $row;
		}
		
	
		// --------------------- response_rank ---------------------
		$sql = "SELECT CONCAT($order,'_',c.id) AS id $col,c.content,a.rank FROM ".
			TABLE_RESPONSE_RANK."  a, ".TABLE_QUESTION." q, ".TABLE_QUESTION_CHOICE.
			" c WHERE a.response_id='${rid}' AND a.question_id=q.id AND a.choice_id=c.id $qids ORDER BY a.question_id,c.id";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchRow($result)) {
			$qid = array_shift($row);
			settype($row[count($row) - 1], 'integer');
			$values[$qid] = $row;
		}
		
	
		// --------------------- response_text ---------------------
		$sql = "SELECT $order $col,a.response FROM ".TABLE_RESPONSE_TEXT." a, ".
			TABLE_QUESTION." q WHERE a.response_id='${rid}' AND a.question_id=q.id $qids";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchRow($result)) {
			$qid = array_shift($row);
			$values["$qid"]=$row;
			$val = array_pop($values["$qid"]);
			array_push($values["$qid"], $val, $val);
		}
		
	
		// --------------------- response_date ---------------------
		$sql = "SELECT $order $col,a.response FROM ".TABLE_RESPONSE_DATE." a, ".
			TABLE_QUESTION." q WHERE a.response_id='${rid}' AND a.question_id=q.id $qids";
		$result = $xoopsDB->query($sql);
		while($row = $xoopsDB->fetchRow($result)) {
			$qid = array_shift($row);
			$values["$qid"]=$row;
			$val = array_pop($values["$qid"]);
			array_push($values["$qid"], $val, $val);
		}
		
	
		// --------------------- return ---------------------
		uksort($values, array($this,"response_key_cmp"));
		return($values);
	}
	/* }}} */
	
	/* {{{ proto array response_select_human(int form_id, int response_id, array question_ids)
	   A wrapper around response_select(), that returns an array of
	   key/value pairs more suitable for humans.
	 */
	function response_select_human($sid, $rid, $qids = null) {
		$res = $this->response_select($sid, $rid, 'type_id,content', $qids,'position');	//
		$hmn = array();
		reset($res);
		$tmpk = null;
		$tmpv = array();
		while(list($qid, $arr) = each($res)) {
			$key = null;
			$val = null;
			if (strstr($qid, '_')) {
				// rank or other
				//   Those parameter will picked it up by non $sub array
				list($qid, $sub) = explode('_', $qid);
				if ($arr[0] != 8)
					continue;
				// rank
				$key = $arr[1];
				if ($arr[3] < 0)
					$arr[3] = 'n/a';
				else
					$arr[3]++;
				$val = $arr[2] . ' = ' . $arr[3];
				if ($tmpk != $key) {
					if (!empty($tmpk) || count($tmpv))
						array_push($hmn, array($tmpk, $tmpv));
					$tmpk = null;
					$tmpv = array();
				}
				$tmpk = $key;
				array_push($tmpv, $val);
				continue;
			}
			if (!empty($tmpk) || count($tmpv))
				array_push($hmn, array($tmpk, $tmpv));
			if (is_array($arr[0])) {
				// mutiple
				$key = $arr[0][1];
				$val = array();
				foreach ($arr as $subarr) {
					if (ereg("^!other", $subarr[2])) {
						$tmpv = preg_replace(array("/^!other=/","/^!other/"),
								array('', 'Other'), $subarr[2]);
						$tmp = $qid ."_". preg_replace("/^other/", $qid, $subarr[3]);
						if (isset($res[$tmp]))
							$tmpv .= ': '. $res[$tmp][2];
						array_push($val, $tmpv);
					} else {
						array_push($val, $subarr[2]);
					}
				}
			} else {
				$key = $arr[1];
				if (ereg("^!other", $arr[2])) {
					$val = preg_replace(array("/^!other=/","/^!other/"),
							array('', 'Other'), $arr[2]);
					$tmp = $qid ."_". preg_replace("/^other/", $qid, $arr[3]);
					if (isset($res[$tmp]))
						$val .= ': '. $res[$tmp][2];
				} else {
					$val = $arr[2];
				}
			}
			$tmpk = null;
			$tmpv = array();
			$hmn[] = array($key, $val);
		}
		if (!empty($tmpk) || count($tmpv))
			array_push($hmn, array($tmpk, $tmpv));
		return $hmn;
	}
	/* }}} */
	
	/* {{{ proto array response_select_compact(int form_id, int response_id, array question_ids)
	   A wrapper around response_select(), that returns an array of
	   key/value pairs more suitable for computer parsing.
	 */
	function response_select_compact($sid, $rid, $qids = null) {
		$res = response_select($sid, $rid, 'type_id', $qids);
		$cpq = array();
		reset($res);
		while(list($qid, $arr) = each($res)) {
			if (strstr($qid, '_')) {
				// rank or other
				if ($arr[0] == 8) {
					// rank
					$cpq[] = array($qid, $arr[2], array($arr[1]));
				} else {
					// other
					$cpq[] = array($qid, $arr[1]);
				}
			} elseif (is_array($arr[0])) {
				// multiple
				$cpq[] = array($qid,
						array_map(create_function('$a', 'return $a[2];'), $arr),
						array_map(create_function('$b', 'return $b[1];'), $arr));
			} else {
				if ($arr[0] == 4 || $arr[0] == 6)
					$cpq[] = array($qid, $arr[2], array($arr[1]));
				else
					$cpq[] = array($qid, $arr[2]);
			}
		}
		return $cpq;
	}
	function response_select_defval($sid, $rid, $qids = null) {
		$res = response_select($sid, $rid, 'type_id', $qids);
		$cpq = array();
		reset($res);
		while(list($qid, $arr) = each($res)) {
			$qname = "Q" . $qid;
			if (strstr($qid, '_')) {
				// rank or other
				if ($arr[0] == 8) {
					// rank
					$cpq[$qname] = array( $arr[2], array($arr[1]));
				} else {
					// other
					$cpq[$qname] = $arr[1];
				}
			} elseif (is_array($arr[0])) {
				// multiple
				$cpq[$qname] = array(
						array_map(create_function('$a', 'return $a[2];'), $arr),
						array_map(create_function('$b', 'return $b[1];'), $arr));
			} else {
				if ($arr[0] == 4 || $arr[0] == 6)
					$cpq[$qname] = array($arr[2], array($arr[1]));
				else
					$cpq[$qname] = $arr[2];
			}
		}
		return $cpq;
	}
	/* }}} */
	
	/* {{{ proto array response_select_name(int form_id, int response_id, array question_ids,int makenumber)
	   A wrapper around response_select(), that returns an array of
	   key/value pairs using the field name as the key.
	 */
	function response_select_name($sid, $rid, $qids=null, $makenumber=null, $otherformat='Other: %s') {
		$res = $this->response_select($sid, $rid, 'type_id,name', $qids, null, $makenumber);
		$nam = array();
		reset($res);
	//	$r=1;
		while(list($qid, $arr) = each($res)) {
			$key = null;
			$val = null;
			if (strstr($qid, '_')) {
				// rank or other
				list($qid, $sub) = explode('_', $qid);
				if ($arr[0] != 8)
					continue; // other
	
				// rank
				$str1 = $this->cnv_mbstr( $arr[2] , $GLOBALS['FMXCONFIG']['csv_charset'] );
	/*
				do {
					$str2 = $str1;
					$str1 = eregi_replace(
						"(^| )(what|which|why|how|who|where|how|is|are|were|the|a|it|of|do|you|your|please|enter)[ ?]",
						" ", $str2);
				} while ($str1 != $str2);
				$str1 = trim(strtoupper(eregi_replace(
					"[^A-Z0-9]+", " ", $str1)));
	*/
				$str1 = ereg_replace(' +','_',$str1);
				/* Change for number response
				$str1 = ereg_replace(' +','_',$r); $r++;
				*/
				$arr[1] .= "_$str1";
				$nam[$arr[1]] = $arr[3];
				continue;
			}
			if (is_array($arr[0])) {
				// mutiple
				$key = $arr[0][1];
				$val = array();
				foreach ($arr as $subarr) {
					if (ereg("^!other", $subarr[2])) {
						$tmp = $qid."_".$subarr[3];
						if (isset($res[$tmp]))
							$tmpv = sprintf($otherformat, $res[$tmp][2]);
						array_push($val, $tmpv);
					} else {
						if ($makenumber!=null)
							array_push($val, $subarr[4]);	// Set seq number
						else
							array_push($val, $subarr[2]);	// Set strings
					}
				}
			} else {
				$key = $arr[1];
				if (ereg("^!other", $arr[2])) {
					$tmp = $qid."_".$arr[3];
					if (isset($res[$tmp]))
						$val = sprintf($otherformat, $res[$tmp][2]);
				} else {
					if ($makenumber!=null and count($arr)>4){
						$val = $arr[4];		// Set number
					}else{
						$val = $arr[2];		// Set strings
					}
				}
			}
			$nam[$key] = $val;
		}
		return $nam;
	}
	/* }}} */
	/* {{{ proto int response_key_cmp(mixed left, mixed right)
	   Key comparator for response keys (to handle numeric, and strings
	   composed of QID_CID).
	 */
	function response_key_cmp($l, $r) {
		$lx = explode('_', $l);
		$rx = explode('_', $r);
		$lc = intval($lx[0]);
		$rc = intval($rx[0]);
		if ($lc == $rc) {
			if (count($lx) > 1 && count($rx) > 1) {
				$lc = intval($lx[1]);
				$rc = intval($rx[1]);
			} else if (count($lx) > 1) {
				$lc++;
			} else if (count($rx) > 1) {
				$rc++;
			}
		}
		if ($lc == $rc)
			return 0;
		return ($lc > $rc) ? 1 : -1;
	}
	/* }}} */
	
}
?>