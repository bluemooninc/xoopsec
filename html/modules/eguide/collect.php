<?php
// Event collection setting by Poster
// $Id: collect.php,v 1.9 2010-02-21 11:07:50 nobu Exp $

include 'header.php';
$_GET['op'] = '';	// only for poster
include 'perm.php';

if (isset($_POST['persons'])) {
    $updated = "";
    $ids = array();
    foreach ($_POST['persons'] as $k => $v) {
	if ($v=='') $v = 'null';
	else $v = intval($v);
	if (preg_match('/^(\\d+)-(\\d+)$/', $k, $d)) {
	    $eid = intval($d[1]);
	    $exid = intval($d[2]);
	    $cond = ($v=='null')?"expersons IS NOT NULL":"(expersons IS NULL OR expersons<>$v)";
	    $res = $xoopsDB->query("SELECT exdate,expersons FROM ".EXTBL." WHERE $cond AND exid=$exid AND eidref=$eid");
	    if ($xoopsDB->getRowsNum($res)==1) {
		list($date, $persons) = $xoopsDB->fetchRow($res);
		$res = $xoopsDB->query("UPDATE ".EXTBL." SET expersons=$v WHERE exid=$exid AND eidref=$eid");
		if ($res) {
		    if (empty($persons)) $persons = _MD_UPDATE_DEFAULT;
		    $updated .= sprintf("(id:%s) %s [%s] %s -> %s\n", $k,
					_MD_RESERV_PERSONS,
					formatTimestamp($date, _MD_POSTED_FMT),
					$persons, disp_value($v));
		    $ids[$eid] = true;
		}
	    }
	} else {
	    $eid = intval($k);
	    $res = $xoopsDB->query("SELECT edate,persons FROM ".OPTBL." WHERE persons<>$v AND eid=$eid");
	    if ($xoopsDB->getRowsNum($res)==1) {
		list($date, $persons) = $xoopsDB->fetchRow($res);
		$res = $xoopsDB->query("UPDATE ".OPTBL." SET persons=$v WHERE eid=$eid");
		if ($res) {
		    $updated .= sprintf("(id:%s) %s [%s] %s -> %s\n", $k,
					_MD_RESERV_PERSONS,
					formatTimestamp($date, _MD_POSTED_FMT),
					disp_value($persons), $v);
		    $ids[$eid] = true;
		}
	    }
	}
    }
    if ($updated) {
	include "notify.inc.php";
	$res = $xoopsDB->query("SELECT eid,title,uid FROM ".EGTBL." WHERE eid IN (".join(',', array_keys($ids)).") AND status=".STAT_NORMAL);
	$urls = "";
	$dirname = basename(dirname(__FILE__));
	if ($xoopsDB->getRowsNum($res)) {
	    while ($data = $xoopsDB->fetchArray($res)) {
		if ($urls) $urls .= "\n\n";
		$urls .= $data['title']."\n".XOOPS_URL."/modules/$dirname/event.php?eid=".$data['eid'];
	    }
	    $tags = array(
		'uid'=>$data['uid'],
		'URL_EVENTS' => $urls,
		'UPDATED' => $updated,
		'DO_UNAME' => $xoopsUser->getVar('uname'));
	    event_notify('update', $tags);
	}
    }
    $url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:EGUIDE_URL.'/collect.php';
    redirect_header($url, 1, _MD_DBUPDATED);
    exit;
}

$fields = "e.eid, cdate, title, closetime, summary, topicid,
IF(expersons IS NULL,persons, expersons) persons, expersons,
IF(exdate,exdate,edate) edate, 
IF(x.reserved,x.reserved,o.reserved) reserved,
uid, status, style, counter, exid, exdate";
$now = time();
$cond = 'status<>'.STAT_DELETED.' AND reservation';
$cond .= " AND IF(exdate,exdate,edate)>$now";

if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
    if (isset($_GET['uid'])) $cond .= ' AND uid='.intval($_GET['uid']);
} else {
    $cond .= ' AND uid='.$xoopsUser->getVar('uid');
}
if (isset($_GET['eid'])) $cond .= ' AND e.eid='.intval($_GET['eid']);

$result = $xoopsDB->query('SELECT '.$fields.' FROM '.EGTBL.' e LEFT JOIN '.
OPTBL.' o ON e.eid=o.eid LEFT JOIN '.EXTBL." x ON e.eid=eidref
  WHERE $cond ORDER BY edate");

include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = EGPREFIX.'_collect.html';
assign_module_css();

$num = $xoopsDB->getRowsNum($result);

$dateline = $timeline = $cells = $event = array();
$peid = 0;			// prime event id
while ($data = $xoopsDB->fetchArray($result)) {
    $edate = $data['edate'];
    $data['date']=eventdate($edate);
    $day = formatTimestamp($edate, 'Y-m-d');
    $time = formatTimestamp($edate, 'H:i');
    $eid = $data['eid'];
    if (!isset($event[$eid])) {
	$event[$eid] = edit_eventdata($data);
	if (!$peid && $data['exid']) $peid = $data['eid'];
    }
    if (!isset($timeline[$time])) {
	$timeline[$time] = formatTimestamp($edate, _MD_STIME_FMT);
    }
    if (!isset($cells[$day])) {
	$cells[$day] = array();
	$dateline[$day] = formatTimestamp($edate, _MD_SDATE_FMT);
    }
    if (isset($cells[$day][$time])) {
	$cells[$day][$time][] = $data;
    } else {
	$cells[$day][$time] = array($data);
    }
}

if (!empty($xoopsModuleConfig['time_defs'])) {
    foreach (explode(',', $xoopsModuleConfig['time_defs']) as $tm) {
	if (strpos($tm, '=')) list($tm)=explode('=', $tm);
	$timeline[$tm]=date(_MD_STIME_FMT, strtotime($tm));
    }
}
ksort($timeline);
$xoopsTpl->assign('event', $event);
$xoopsTpl->assign('peid', $peid);
$xoopsTpl->assign('timeline', $timeline);
$xoopsTpl->assign('dateline', $dateline);
$xoopsTpl->assign('cells', $cells);

$paths = array();
$catid = 0;
if (!empty($eid)) {
    if (!empty($event[$eid]['title'])) {
	$paths[$event[$eid]['title']] = "event.php?eid=$eid";
    }
    $catid = $event[$eid]['catid'];
}
$paths[_MD_RESERV_PERSONS._EDIT] = "";
set_eguide_breadcrumbs($catid, $paths);

include XOOPS_ROOT_PATH.'/footer.php';
?>