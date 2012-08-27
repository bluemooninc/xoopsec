<?php
// Reservation Entry by Poster
// $Id: entry.php,v 1.10 2010-06-27 04:12:30 nobu Exp $

include 'header.php';
$_GET['op'] = '';	// only for poster
include 'perm.php';

$eid = param('eid');
$exid = param('sub');
$data = fetch_event($eid, $exid, true);
$errs = array();
$now=time();

if (isset($_POST['eid'])) {
    include 'reserv_func.php';
    $myts =& MyTextSanitizer::getInstance();

    $vals = get_opt_values($data['optfield'], $errs, false, false);
    check_prev_order($data, $vals, $errs, true);
    $value = "";
    foreach ($vals as $name => $val) {
	if (preg_match('/\n/', $val)) {
	    $value .= "$name: \\\n$val\n";
	} else {
	    $value .= "$name: $val\n";
	}
    }
    $url = EGUIDE_URL.'/receipt.php?eid='.$eid;
    if ($exid) $url .= '&sub='.$exid;
    if (!$errs) {
	$data['closetime'] = 0;	// override close order time
	$accept = $data['autoaccept'];
	$strict = $data['strict'];
	$persons = $data['persons'];
	$num = 1;
	$nlab = eguide_form_options('label_persons');
	if ($nlab && isset($vals[$nlab])) {
	    $num =  intval($vals[$nlab]);
	    if ($num<1) $num = 1;
	}
	if (count_reserved($eid, $exid, $strict, $persons, $num)) {
	    srand();
	    $data['confirm'] = $conf = rand(10000,99999);
	    $email = param('email', '');
	    $ml = $xoopsDB->quoteString($email);
	    $uid = $xoopsUser->getVar('uid');
	    $xoopsDB->query('INSERT INTO '.RVTBL." 
(eid,exid,uid,rdate,email,status,confirm,info) VALUES
($eid,$exid,$uid,$now,$ml,"._RVSTAT_RESERVED.",$conf,".
			    $xoopsDB->quoteString($value).")");
	    $data['rvid'] = $xoopsDB->getInsertId();
	    order_notify($data, $email, $value); // error ignore
	    redirect_header($url, 1, _MD_DBUPDATED);
	    exit;
	} else $errs[] = _MD_RESERV_FULL;
    }
}

if (empty($data)) {
	redirect_header(EGUIDE_URL."/index.php",2,_MD_NOEVENT);
	exit();
}

$data['exid']=$exid;
$data['isadmin'] = true;
$data['link'] = true;
include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = EGPREFIX.'_entry.html';
assign_module_css();
edit_eventdata($data);
$xoopsTpl->assign('event', $data);
if ($errs) $xoopsTpl->assign('errors', $errs);
// check pical exists
$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname(PICAL);
if (is_object($module) && $module->getVar('isactive')==1) {
    $xoopsTpl->assign('caldate', formatTimestamp($data['edate'], 'Y-m-d'));
}
// page title
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name')." | "._MD_RESERVATION);
if ($data['closedate'] < $now) {
    if ($data['reservation']) $xoopsTpl->assign('message', _MD_RESERV_CLOSE);
} elseif ($data['reservation']) {
    $reserved = false;
    if ($data['strict'] && $data['persons']<=$data['reserved']) {
	$xoopsTpl->assign('message', _MD_RESERV_FULL);
    } else {
	if (empty($_POST['email'])) $_POST['email'] = '';
	$form = eventform($data);
	$form['lang_email'] = preg_replace('/\\*$/', '', _MD_EMAIL);
	$xoopsTpl->assign('form', $form);
    }
}

include XOOPS_ROOT_PATH.'/footer.php';
?>