<?php
// reservation functions
// $Id: reserv_func.php,v 1.9 2010-10-10 06:30:12 nobu Exp $

function get_opt_values($optfield, &$errs, $hidden=false, $view=true) {
    $myts =& MyTextSanitizer::getInstance();
    $result = array();
    $field = 0;
    foreach (explode("\n", $optfield) as $n) {
	$field++;
	if (preg_match('/^\s*#/', $n)) continue;
	if (preg_match('/^\s*$/', $n)) continue;
	$a = preg_split("/,\\s*/", preg_replace('/[\n\r]/',"", $n));
	$name = preg_replace('/^!\s*/', '', array_shift($a));
	$fname = preg_replace('/[\*\#]$/', "", $name);
	$type = "text";
	$iname = "opt$field";
	if (isset($a[0])) {
	    $ty = strtolower(array_shift($a));
	    switch ($ty) {
	    case 'hidden':
	    case 'const':
		if (!$hidden) {	// pseudo POST variable
		    $_POST[$iname] = $result[$fname] = apply_user_vars(join(',', $a));
		}
	    case "checkbox":
	    case 'textarea':
		$type = $ty;
		break;
	    }
	}
	$input = "";
	if ($type == 'hidden' || $type == 'const') continue;
	elseif ($type == 'checkbox') {
	    $v = "";
	    if (!empty($_POST[$iname])) {
		foreach ($_POST[$iname] as $vv) {
		    $v .= ($v==""?"":",").$myts->stripSlashesGPC($vv);
		    if ($hidden) {
			$input .= "<input type='hidden' name='{$iname}[]' id='{$iname}[]' value='".$myts->makeTboxData4Edit($vv)."'/>";
		    }
		}
	    }
	} else {
	    $v = $myts->stripSlashesGPC($_POST["opt$field"]);
	    if ($type!='textarea') $v = preg_replace('/\n.*$/s', '', $v);
	    if ($hidden) {
		$input .= "<input type='hidden' name='opt$field' value='".
		    $myts->makeTboxData4Edit($v)."'/>";
	    }
	    // remove control char except textarea
	    if ($type!='textarea') $v = preg_replace('/[\x00-\x1f]/', '', $v);
	}
	$must = preg_match('/\*$/', $name);
	$nums = preg_match('/\#$/', $name);
	if ($must) {
	    // check for NULL
	    if (preg_match('/^\s*$/', $v)) {
		$errs[] = "$fname: "._MD_NOITEM_ERR;
	    }
	} elseif ($nums) {
	    // check Number
	    if (!preg_match('/^-?\d+$/', $v)) {
		$errs[] = "$fname: $v - "._MD_NUMITEM_ERR;
	    }
	}
	$result[$fname] = $hidden?$input:($view?$myts->displayTarea($v):$v);
    }
    return $result;
}

// check condition before entry event
// return errors (go on if empty)
function check_prev_order($data, $vals, &$errs, $force=false) {
    global $xoopsModuleConfig, $xoopsDB, $xoopsUser;
    $eid = $data['eid'];
    $exid = intval($data['exid']);
    // stopping if multiple event but no have exid (missing?)
    if (!empty($data) && empty($data['exid'])) {
	$result = $xoopsDB->query('SELECT exid FROM '.EXTBL." WHERE eidref=$eid");
	if ($xoopsDB->getRowsNum($result)>0) $errs[] = _MD_RESERV_STOP;
    }
    // stop reservation or limit over
    if (empty($data['reservation']) ||
	($data['edate']-$data['closetime'])<time()) {
	if (empty($errs)) $errs[] = _MD_RESERV_STOP;
    }

    // order duplicate check
    $mo = $xoopsModuleConfig['member_only'];
    if ($force || $mo==ACCEPT_EMAIL || ($mo==ACCEPT_BOTH && !is_object($xoopsUser))) {
	$email = param('email', '');
	if (!($force && empty($email))) {
	    if (!preg_match('/^[\w\-_\.]+@[\w\-_\.]+$/', $email)) {
		$errs[] =  _MD_EMAIL.": ".htmlspecialchars($email)." - "._MD_MAIL_ERR;
	    }
	    if (eguide_form_options('email_repeat_check')) {
		$conf = param('email_conf', '');
		if ($email !== $conf) $errs[] =  _MD_MAIL_CONF_ERR;
	    }
	    $ml = strtolower($email);
	    $result = $xoopsDB->query('SELECT rvid FROM '.RVTBL." WHERE eid=$eid AND exid=$exid AND email=".$xoopsDB->quoteString($ml));
	} else {
	    $result = false;
	}
    } else {
	if (!is_object($xoopsUser)) redirect_header($_SERVER['HTTP_REFERER'],2);
	$result = $xoopsDB->query('SELECT rvid FROM '.RVTBL." WHERE eid=$eid AND exid=$exid AND uid=".$xoopsUser->getVar('uid'));
	$email = $xoopsUser->getVar('uname');
	$ml = '';
    }
    if ($result && $xoopsDB->getRowsNum($result)) {
	$errs[] =  _MD_EMAIL.": ".htmlspecialchars($email)." - "._MD_DUP_ERR;
    }
    // checking is there any seat?
    $num = 1;			// how many orders?
    $nlab = eguide_form_options('label_persons');
    if ($nlab && isset($vals[$nlab])) {
	$num =  intval($vals[$nlab]);
	if ($num<1) $num = 1;
    }
    if ($data['strict']) {
	if ($data['persons']<=$data['reserved']) {
	    $errs[] = _MD_RESERV_FULL;
	} elseif ($data['persons']<($data['reserved']+$num)) {
	    $errs[] = sprintf($nlab._MD_RESERV_TOMATCH, $num,$data['persons']-$data['reserved']);
	}
    }
    return $errs;
}

function count_reserved($eid, $exid, $strict, $persons, $value=1) {
    global $xoopsDB;
    if ($exid) {
	$cond = "exid=$exid";
	$tbl = EXTBL;
    } else {
	$cond = "eid=$eid";
	$tbl = OPTBL;
    }
    $cond .= $strict?" AND reserved<=".($persons-$value):"";
    $res = $xoopsDB->query("UPDATE $tbl SET reserved=reserved+$value WHERE $cond");
    return $res && $xoopsDB->getAffectedRows();
}
?>