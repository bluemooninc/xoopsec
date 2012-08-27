<?php
// Administration Date by Poster
// $Id: editdate.php,v 1.16 2010-06-27 04:12:30 nobu Exp $

include 'header.php';
require 'perm.php';

$eid = param('eid');

$result=$xoopsDB->query('SELECT rvid FROM '.RVTBL." WHERE eid=$eid AND exid=0", 1);
if ($xoopsDB->getRowsNum($result)>0) {
    redirect_header(empty($_SERVER['HTTP_REFERER'])?EGUIDE_URL.'/admin.php':$_SERVER['HTTP_REFERER'], 1, _NOPERM);
}

$event = fetch_event($eid, 0);
if (!$event) {
    redirect_header(EGUIDE_URL.'/index.php', 2, _MD_NOEVENT);
}

include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = EGPREFIX.'_editdate.html';
assign_module_css();
$edate = $event['edate'];
$xoopsTpl->assign('event', edit_eventdata($event));
$paths = array();
if (!empty($event['title'])) {
    $paths[$event['title']] = "event.php?eid=$eid";
}
$paths[_MD_EDIT_EXTENT] = "editdate.php?eid=$eid";
set_eguide_breadcrumbs($event['catid'], $paths);

$myts =& MyTextSanitizer::getInstance();
$now = time();
$extents = get_extents($eid, true);
$errors = array();
if (isset($_POST['adds'])) {
    $dels = empty($_POST['dels'])?array():$_POST['dels'];
    $mods = $_POST['mods'];
    $exps = $_POST['exps'];
    $adds = preg_split('/[\n\r]+/', trim($_POST['adds']));
    $chg = 0;
    $updated = "";
    foreach ($extents as $data) {
	$id = $data['exid'];
	if (isset($dels[$id])) {
	    if ($data['exdate']>$now && $data['reserved']) {
		$errors[] = formatTimestamp($data['exdate'], 'Y-m-d H:i').' - '._MD_DATEDELETE_ERR;
	    } else {
		$xoopsDB->query('DELETE FROM '.RVTBL." WHERE eid=$eid AND exid=$id");
		$xoopsDB->query('DELETE FROM '.EXTBL." WHERE exid=$id");
		$updated .= sprintf("(id:%s) %s [%s]\n", "$eid-$exid", _DELETE,
				    formatTimestamp($data['exdate'], _MD_POSTED_FMT));
		$chg++;
	    }
	} elseif (isset($mods[$id])) {
	    $exdate = $data['exdate'];
	    $pre = formatTimestamp($exdate, 'Y-m-d H:i');
	    $v = trim($mods[$id]);
	    if ($pre==$v && $exps[$id]==$data['expersons']) continue;
	    $n = $exps[$id]==''?'null':intval($exps[$id]);
	    list($date, $time) = split(' ', trim($mods[$id]));
	    if (preg_match('/^(\d+)[-\/](\d\d?)[-\/](\d\d?)$/', $date, $d)) {
		$yy = $d[1]; $mm=$d[2]; $dd = $d[3];
	    } else {
		$errors[] = "$v - "._MD_DATE_ERR;
		continue;
	    }
	    if (preg_match('/^(\d\d?):(\d\d?)/', $time, $d)) {
		$hour=$d[1]; $min = $d[2];
	    } else {
		$hh = formatTimestamp($exdate, 'H');
		$mm = formatTimestamp($exdate, 'i');
	    }
	    $tm = userTimeToServerTime(mktime($hour,$min, 0, $mm, $dd, $yy), $xoopsUser->getVar("timezone_offset"));
	    
	    if (($tm >= $event['opendate']) && ($tm > $now)) {
		$post = formatTimestamp($tm, 'Y-m-d H:i');
		$xoopsDB->query("UPDATE ".EXTBL." SET exdate=$tm, expersons=$n WHERE eidref=$eid AND exid=$id");
		$date = formatTimestamp($data['exdate'], _MD_POSTED_FMT);
		if ($data['exdate']!=$tm) {
		    $date .= " -> ".formatTimestamp($tm, _MD_POSTED_FMT);
		}
		if (disp_value($data['expersons'])!=disp_value($n)) {
		    $exp = " "._MD_RESERV_PERSONS." ".
			disp_value($data['expersons'])." -> ".disp_value($n);
		} else {
		    $exp = '';
		}
		$updated .= sprintf("(id:%s) %s [%s]%s\n", "$eid-$id",
				    _MD_EXTENT_DATE, $date, $exp);
		$chg++;
	    } else {
		$errors[] = "$v - "._MD_DATE_ERR;
	    }
	}
    }
    if (!empty($adds[0])) {
	$defh = formatTimestamp($edate, 'H');
	$defi = formatTimestamp($edate, 'i');
	foreach ($adds as $v) {
	    $v = trim($v);
	    if (empty($v)) continue;
	    if (preg_match('/ /', $v)) {
		list($date, $time) = split(' ', $v);
	    } else {
		$date = $v;
		$time = '';
	    }
	    if (preg_match('/^(\d+)[-\/](\d\d?)[-\/](\d\d?)$/', $date, $d)) {
		$yy = $d[1]; $mm=$d[2]; $dd = $d[3];
	    } else {
		$errors[] = "$v - "._MD_DATE_ERR;
		continue;
	    }
	    if (preg_match('/^(\d\d?):(\d\d?)/', $time, $d)) {
		$hour=$d[1]; $min = $d[2];
	    } else {
		$hour = $defh; $min = $defi;
	    }
	    $tm = userTimeToServerTime(mktime($hour,$min, 0, $mm, $dd, $yy), $xoopsUser->getVar("timezone_offset"));
	    if ($tm >= $edate && $tm > $now) {
		$xoopsDB->query('INSERT INTO '.EXTBL."(eidref,exdate)VALUES($eid,$tm)");
		$exid = $xoopsDB->getInsertID();
		$updated .= sprintf("(id:%s) %s [new %s]\n", "$eid-$exid",
				    _MD_EXTENT_DATE,
				    formatTimestamp($tm, _MD_POSTED_FMT));
		$chg++;
	    } else {
		$errors[] = "$v - "._MD_DATE_ERR;
	    }
	}
    }
    if ($chg) {
	$extents = get_extents($eid, true);
	$xoopsDB->query('UPDATE '.EGTBL." SET ldate=0 WHERE eid=$eid");
	$res = $xoopsDB->query('SELECT * FROM '.EGTBL." WHERE eid=$eid");
	$data = $xoopsDB->fetchArray($res);
	if ($data['status']==STAT_NORMAL) {
	    $tags = array(
		'uid'=>$data['uid'],
		'URL_EVENTS' => $data['title']."\n".XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname')."/event.php?eid=".$eid,
		'UPDATED' => $updated,
		'DO_UNAME' => $xoopsUser->getVar('uname'));
	    include "notify.inc.php";
	    event_notify('update', $tags);
	}
	redirect_header(EGUIDE_URL.'/editdate.php?eid='.$eid, 1, _MD_DBUPDATED);
	exit;
    }
    $_POST['adds'] = '';
}

$xoopsTpl->assign('count', sprintf(_MD_INFO_COUNT, count($extents)));
$xoopsTpl->assign('labels', array(_DELETE, _MD_EXTENT_DATE, _MD_ORDER_COUNT,
	 _EDIT.sprintf(" (%s, %s)",_MD_EVENT_DATE, _MD_RESERV_PERSONS)));
foreach ($extents as $key => $data) {
    $tm = $data['exdate'];
    $extents[$key]['date'] = eventdate($tm);
    if ($tm>$now) {
	$extents[$key]['edit'] = formatTimestamp($tm, 'Y-m-d H:i');
    }
}

$xoopsTpl->assign('errors', $errors);
$xoopsTpl->assign('adds', htmlspecialchars(param('adds', '')));
$xoopsTpl->assign('extents', $extents);

include XOOPS_ROOT_PATH.'/footer.php';
?>