<?php
// Event Guide Module for XOOPS
// $Id: index.php,v 1.23 2010-02-21 11:07:50 nobu Exp $

include 'header.php';

$prev = param('prev');
$page = param('page');

if ($page<0) {
    $prev = -$page;
    $page=0;
} elseif ($prev<0) {
    $page = -$prev;
    $prev = 0;
}

set_next_event();

$now = time();
$max = $xoopsModuleConfig['max_event'];
$cond = 'status='.STAT_NORMAL;

if (empty($prev)) {
    // show upcomming event (constant is gurd value)
    $cond .= " AND ((expire>=edate AND expire>$now) OR (expire<edate AND (IF(exdate,exdate,edate)+expire)>$now))";
    //$cond .= " AND (exdate>$now OR exdate IS NULL)";
    $start = (empty($page)?0:$page-1)*$max;
    $ord = 'ASC';
    $ext = $xoopsModuleConfig['show_extents']?'':'AND ldate=exdate';
} else {
    $cond .= " AND edate<$now"; // show passed event
    $cond .= " AND (exdate<$now OR exdate IS NULL)";
    $start = ($prev-1)*$max;
    $ord = 'DESC';
    $ext = $xoopsModuleConfig['show_extents']?'':'AND 0';
}

$catlist = get_eguide_category();
$catid = isset($_GET['cat'])&&preg_match('/^(\d+,)*\d+$/', $_GET['cat'])?$_GET['cat']:0;
if (isset($catlist[$catid])) {
    $vals = array($catid);
    if ($catlist[$catid]['catpri']==0) { // also children categories
	foreach ($catlist as $data) {
	    if ($data['catpri']==$catid) {
		$vals[] = $data['catid'];
	    }
	}
    }
    $opt = ' AND topicid IN ('.join(',', $vals).')';
} else {
    $opt = $catid?' AND topicid IN ('.$catid.')':'';
}

$fields = "e.eid, cdate, title, summary, closetime,
IF(expersons IS NULL,persons, expersons) persons,
IF(exdate,exdate,edate) edate, 
IF(x.reserved,x.reserved,o.reserved) reserved,
reservation, uid, status, style, counter, topicid, exid, exdate,
uploadimage1,uploadimage2,uploadimage3";
$result = $xoopsDB->query('SELECT '.$fields.' FROM '.EGTBL.' e LEFT JOIN '.
OPTBL.' o ON e.eid=o.eid LEFT JOIN '.EXTBL." x ON e.eid=eidref $ext
  WHERE $cond$opt ORDER BY edate $ord", $max, $start);

$events = array();
$isadmin = false;
$uid = 0;
if (is_object($xoopsUser)) {
    $isadmin = $xoopsUser->isAdmin($xoopsModule->getVar('mid'));
    $uid = $xoopsUser->getVar('uid');
}
while ($event = $xoopsDB->fetchArray($result)) {
    $event['isadmin'] = ($isadmin || $event['uid']==$uid);
    $event['link'] = true;
    $event['expire'] = ($event['edate']-$event['closetime']) > $now;
    $more = 'event.php?eid='.$event['eid'];
    $cid = $event['topicid'];
    if (isset($catlist[$cid])) {
	$event['catid'] = $cid;
	$event['catname'] = $catlist[$cid]['name'];
	$event['catimg'] = $catlist[$cid]['image'];
    }
    if (!empty($event['exid'])) {
	$event['extent']=true;	// also show editdate link
	$more .= '&sub='.$event['exid'];
    }
    $event['detail'] = $more;
    edit_eventdata($event);
    $events[] = $event;
}

include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = EGPREFIX.'_index.html';

$xoopsTpl->assign('events', $events);
assign_module_css();
if (count($catlist)>1) {
    foreach ($catlist as $id => $cat) {
	if ($cat['catpri']) $catlist[$id]['name'] = '-- '.$cat['name'];
    }
    $xoopsTpl->assign('categories',
		      array('options'=>$catlist,
			    'action'=>'index.php',
			    'dirname'=>basename(dirname(__FILE__))));
}

if (empty($prev)) {
    if ($page < 2) {
	$result = $xoopsDB->query('SELECT eid FROM '.EGTBL.' e LEFT JOIN '.EXTBL." ON e.eid=eidref $ext WHERE (edate<$now OR exdate<$now) AND status=".STAT_NORMAL.$opt, 1);
	$p = $xoopsDB->getRowsNum($result);
    } else {
	$p = true;
    }
    $result = $xoopsDB->query('SELECT eid FROM '.EGTBL.' e LEFT JOIN '.EXTBL." ON e.eid=eidref $ext WHERE ".$cond.$opt, 1,$start+$max);
    $q = $xoopsDB->getRowsNum($result);	// there is next page
    if (empty($page) || $page==1) {
	$prev="?prev=1";
	$page="?page=2";
    } else {
	$prev="?page=".($page-1);
	$page="?page=".($page+1);
    }
} else {
    $result = $xoopsDB->query('SELECT eid FROM '.EGTBL.' e LEFT JOIN '.EXTBL." ON e.eid=eidref $ext WHERE ".$cond.$opt, 1,$start+$max);
    $p = $xoopsDB->getRowsNum($result);	// there is more prev page?
    $q = true;			// always next page exists.
    if ($prev==1) {
	$prev="?prev=".($prev+1);
	$page="?page=1";
    } else {
	$page="?prev=".($prev-1);
	$prev="?prev=".($prev+1);
    }
}

set_eguide_breadcrumbs(is_numeric($catid)?$catid:0);

$opt = $catid?"&cat=".$catid:'';

if ($p) $xoopsTpl->assign('page_prev', $prev.$opt);
if ($q) $xoopsTpl->assign('page_next', $page.$opt);
if (count($events)==0 && !$p) {
    unset($xoopsOption['template_main']);
    echo _MD_NODATA;
}

include XOOPS_ROOT_PATH.'/footer.php';
?>