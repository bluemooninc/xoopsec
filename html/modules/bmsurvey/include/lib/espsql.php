<?php

# $Id: espsql.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>



/* {{{ proto int form_num_sections(int form_id)
   Returns the number of sections in the form. */
function form_num_sections($sid) {
	global $xoopsDB;
	$sql = "SELECT COUNT(*) + 1 FROM ".TABLE_QUESTION." WHERE form_id='${sid}' AND type_id='99' AND deleted='N'";
	list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	
	return($count);
}
/* }}} */

/* }}} */

/* {{{ proto array form_get_section_questions(int form_id)
	Returns 2D-array with question id's of sections, excludes
    the section text question type. */
function form_get_section_questions($sid, $field = 'id') {
	global $xoopsDB;

	$sql = "SELECT $field, type_id FROM ".TABLE_QUESTION." WHERE form_id = $sid AND deleted = 'N' ORDER BY position";
	if (!($result = $xoopsDB->query($sql))) return array();
	$ret = array();
	$sec = array();
	while (list($key, $type) = $xoopsDB->fetchRow($result)) {
        if ($type != 100) {
	    	if ($type != 99) {
		    	$sec[] = $key;
	    	} else {
	    		$ret[] = $sec;
	    		$sec = array();
	    	}
        }
	}
	$ret[] = $sec;
	return $ret;
}
/* }}} */


/* {{{ proto array esp_type_has_choices()
   Returns an associative array of bools indicating if each
   question type has answer choices. */
function esp_type_has_choices() {
	global $xoopsDB;
	$has_choices = array();
	$sql = "SELECT id, has_choices FROM ".TABLE_QUESTION_TYPE." ORDER BY id";
	$result = $xoopsDB->query($sql);
	while(list($tid,$answ) = $xoopsDB->fetchRow($result)) {
		if($answ == 'Y')
			$has_choices[$tid]=1;
		else
			$has_choices[$tid]=0;
	}
	
	return($has_choices);
}
/* }}} */

/* {{{ proto array esp_type_response_table()
   Returns an associative array of bools indicating the
   table the responses are stored in. */
function esp_type_response_table() {
	$sql = "SELECT id, response_table FROM ".TABLE_QUESTION_TYPE." ORDER BY id";
	$result = $xoopsDB->query($sql);
	$response_table = array();
	while(list($tid,$answ) = $xoopsDB->fetchRow($result)) {
		$response_table[$tid]=TABLE_.$answ;
	}
	
	return($response_table);
}
/* }}} */

?>