<?php
// display events
// $Id: event.php,v 1.30 2010-06-27 04:12:30 nobu Exp $
include 'header.php';

$eid = param('eid');
$exid = param('sub');
$op = param('op', 'view');

$myts =& MyTextSanitizer::getInstance();

$isadmin = false;
$uid = 0;
if (is_object($xoopsUser)) {
    $isadmin = $xoopsUser->isAdmin($xoopsModule->getVar('mid'));
    $uid = $xoopsUser->getVar('uid');
    if (!$isadmin) {
	$result = $xoopsDB->query('SELECT uid FROM '.EGTBL." WHERE eid=$eid AND uid=$uid");
	if ($xoopsDB->getRowsNum($result)>0) $isadmin = true;
    }
}

set_next_event();
$data = fetch_event($eid, $exid, $isadmin);

if (empty($data)) {
    redirect_header(EGUIDE_URL.'/index.php', 3, _NOPERM);
    exit;
}
$_GET['cat']=$data['topicid'];	// for notification
$now=time();

$data['exid']=$exid;
// sub
$extents = get_extents($eid);
if ($exid) $data['extent']=true; // show editdate link
else if (count($extents) && $exid==0) {
    if (count($extents)==1) {    // only one extent, chose that.
	header('Location: '.EGUIDE_URL.'/event.php?eid='.$eid.'&sub='.$extents[0]['exid']);
	exit;
    }
    $data['extent']=true;	// also show editdate link
    $data['extents'] = $extents;
    $data['exdate']=$extents[0]['exdate'];
}

$data['isadmin'] = ($isadmin || $data['uid']==$uid);

if ($op != "print") {
    if (!$xoopsUser || $data['uid']!=$xoopsUser->uid()) {
	$xoopsDB->queryF("UPDATE ".EGTBL." SET counter=counter+1 WHERE eid=$eid");
	$data['counter']++;
    }
    $data['link'] = true;
}

// check pical exists
$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname(PICAL);

if (is_object($module) && $module->getVar('isactive')==1) {
    $pidate = formatTimestamp($data['edate'], 'Y-m-d');
    if (empty($_GET['caldate'])) {
	$_GET['caldate'] = $pidate;
    }
    $_POST['pical_jumpcaldate'] = true; // pical cache disable hack
}

include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = EGPREFIX.'_event.html';
assign_module_css();
edit_eventdata($data);
$title = $data['date']." ".$data['title'];
set_eguide_breadcrumbs($data['topicid'], array($title=>''));
$xoopsTpl->assign('event', $data);
if (isset($pidate)) $xoopsTpl->assign('caldate', $pidate);
// page title
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name')." | ".$title);if ($data['closedate'] < $now) {
    if ($data['reservation']) $xoopsTpl->assign('message', _MD_RESERV_CLOSE);
} elseif ($data['reservation']) {
    $reserved = false;
    if (is_object($xoopsUser)) {
	$result = $xoopsDB->query("SELECT * FROM ".RVTBL." WHERE eid=$eid AND exid=$exid AND uid=".$xoopsUser->getVar('uid'));
	$reserved = ($xoopsDB->getRowsNum($result)>0);
    }
    if ($data['strict'] && $data['persons']<=$data['reserved']) {
	$xoopsTpl->assign('message', _MD_RESERV_FULL);
    } elseif (!is_object($xoopsUser) && $xoopsModuleConfig['member_only']==ACCEPT_MEMBER) {
	$xoopsTpl->assign('message', _MD_RESERV_NEEDLOGIN);
    } else {
	$ok = true;
	if ($xoopsModuleConfig['use_plugins']) {
	    include_once 'plugins.php';
	    foreach ($hooked_function['check'] as $func) {
		$ok = $func($eid, $exid, $data['uid']);
		if (!$ok) break;
	    }
	}
	if ($reserved) {
	    $xoopsTpl->assign('message', _MD_RESERVED);
	} elseif ($ok) $xoopsTpl->assign('form', eventform($data));
    }
}

$xoopsTpl->assign(make_lists($data));

if ($op == "print") {
    $xoopsOption['template_main'] = EGPREFIX.'_event_print.html';
    $xoopsTpl->assign('lang_comefrom', sprintf(_MD_THISCOMESFROM, $xoopsConfig['sitename']));
    $xoopsTpl->display('db:'.EGPREFIX.'_event_print.html');
    exit;
}

if ($xoopsModuleConfig['use_comment']) {
    include XOOPS_ROOT_PATH.'/include/comment_view.php';
}

include XOOPS_ROOT_PATH.'/footer.php';

function make_lists($data) {
    global $xoopsDB;
    $eid = $data['eid'];
    $exid = $data['exid'];
    $myts =& MyTextSanitizer::getInstance();
    if ($data['reservation'] && !empty($data['reserved'])) {
	$show = array();
	$item = array();
	foreach (explode("\n", trim($data['optfield'])) as $n) {
	    $a = explode(",", preg_replace('/[\n\r]/',"", $n));
	    $lab = preg_replace('/[\*#]$/', "",array_shift($a));
	    if (preg_match('/^!/', $lab)) {
		$lab = preg_replace('/^!\s*/', '', $lab);
		$show[] = $lab;
	    }
	    $item[] = $lab;
	}
	$list = array();
	if (count($show)) {
	    $result = $xoopsDB->query('SELECT * FROM '.RVTBL." WHERE eid=$eid AND exid=$exid AND status="._RVSTAT_RESERVED.' ORDER BY rdate');
	    $nc = 0;
	    while($rdata = $xoopsDB->fetchArray($result)) {
		$a = unserialize_text($rdata['info']);
		if (!empty($rdata['uid'])) {
		    $uid = $rdata['uid'];
		    $uinfo = " (<a href='".XOOPS_URL."/userinfo.php?uid=$uid'>".XoopsUser::getUnameFromId($uid)."</a>)";
		} else {
		    $uinfo = "";
		}
		$order = array();
		foreach ($show as $v) {
		    $order[] = $myts->sanitizeForDisplay($a[$v]).$uinfo;
		    $uinfo = "";
		}
		$list[++$nc] = $order;
	    }
	}
	return array('labels'=>$show, 'list'=>$list);
    }
    return array();
}
?>