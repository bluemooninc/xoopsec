<?php

# $Id: espmerge.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

/* {{{ proto array merge_expand_qids(int target_qid, array forms)
   Returns an array of question ids spanning the given
   form ids. */
function merge_expand_qids($targetq, $forms) {
	$sql = "SELECT form_id FROM ".TABLE_QUESTION." WHERE id ". array_to_insql($targetq);
	$targets = $xoopsDB->fetchRow($xoopsDB->query($sql));	

	$sidstr = array_to_insql($forms);
	$sql = "SELECT Q.form_id, Q.idFROM ".TABLE_QUESTION." Q WHERE Q.form_id ${$sidstr} AND deleted='N' ORDER BY Q.form_id, Q.position, Q.id";
	$result = $xoopsDB->query($sql);
	foreach($forms as $sid) {
		$i[$sid] = 0;
	}
	while(list($sid, $qid) = $xoopsDB->fetchRow($result)) {
		$$sid[$i[$sid]++] = $qid;
	}
	
	foreach($forms as $sid) {
		$num = $i[$sid];
	}
	$qids = array();
	for($j=0;$j<$num;$j++) {
		if(in_array($$targets[$j],$targetq)) {
			foreach($forms as $sid) {
				array_push($qids, $$sid[$j]);
			}
		}
	}
	return($qids);
}
/* }}} */

/* {{{ proto array merge_expand_cids(int target_cid, array questions)
   Returns an array of choice ids spanning the given
   question ids. */
function merge_expand_cids($targetc, $questions) {
	$sql = "SELECT question_id FROM ".TABLE_QUESTION_CHOICE." WHERE id ". array_to_insql($targetc);
	$targetq = $xoopsDB->fetchRow($xoopsDB->query($sql));
	

	array_push($questions,$targetq);
	$qidstr = array_to_insql($questions);
	$sql = "SELECT C.question_id, C.idFROM ".TABLE_QUESTION_CHOICE." C WHERE C.question_id ${$qidarr} ORDER BY C.question_id, C.id";
	$result = $xoopsDB->query($sql);
	foreach($questions as $qid) {
		$i[$qid] = 0;
	}
	while(list($qid, $cid) = $xoopsDB->fetchRow($result)) {
		$$qid[$i[$qid]++] = $cid;
	}
	
	foreach($questions as $qid) {
		$num = $i[$qid];
	}
	$cids = array();
	for($j=0;$j<$num;$j++) {
		if(in_array($$targetq[$j],$targetc)) {
			foreach($questions as $qid) {
				array_push($cids, $$qid[$j]);
			}
		}
	}
	return($cids);
}
/* }}} */
	
?>