<?php
// Event Guide - Personal reservation event list
// $Id: mylist.php,v 1.5 2008-07-22 15:09:44 nobu Exp $

include 'header.php';
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL.'/user.php', 1, _NOPERM);
}
$uid = $xoopsUser->getVar('uid');

include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = EGPREFIX.'_mylist.html';

$res = $xoopsDB->query('SELECT count(rvid) FROM '.RVTBL.' WHERE uid='.$uid);
list($rvcount) = $xoopsDB->fetchRow($res);
$rvmax = $xoopsModuleConfig['max_list'];
$rvstart = isset($_GET['start'])?intval($_GET['start']):0;
$nav = new XoopsPageNav($rvcount, $rvmax, $rvstart, "start");
if ($rvcount>$rvmax) $xoopsTpl->assign('navigation',$nav->renderNav());

$res = $xoopsDB->query('SELECT r.eid,r.exid, r.rdate, e.title,
IF(exdate,exdate,edate) edate, rvid, confirm, closetime
FROM '.RVTBL.' r LEFT JOIN '.EGTBL.' e ON r.eid=e.eid LEFT JOIN '.EXTBL.' x
  ON r.eid=eidref AND r.exid=x.exid LEFT JOIN '.OPTBL." o ON e.eid=o.eid
 WHERE r.uid=$uid ORDER BY edate DESC", $rvmax, $rvstart);

$now = time();
while ($data = $xoopsDB->fetchArray($res)) {
    $data['edate_fmt'] = eventdate($data['edate']);
    $data['cancel']=($data['edate']-$data['closetime'])>$now;
    $data['rdate_fmt']=formatTimestamp($data['rdate'], _MD_TIME_FMT);
    $xoopsTpl->append('reserved', $data);
}
include XOOPS_ROOT_PATH.'/footer.php';
?>