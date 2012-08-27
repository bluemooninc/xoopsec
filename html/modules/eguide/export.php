<?php
// Export event reservations in Excel/XML format
// $Id: export.php,v 1.6 2010-03-19 03:50:16 nobu Exp $

include 'header.php';
include_once XOOPS_ROOT_PATH.'/class/template.php';
$_GET['op'] = '';	// only for poster
include 'perm.php';

$eid = intval($_GET['eid']);

$result = $xoopsDB->query("SELECT optfield FROM ".OPTBL." WHERE eid=$eid");
list($optfield) = $xoopsDB->fetchRow($result);

$fields = "e.eid, cdate, title, closetime,
IF(expersons IS NULL,persons, expersons) persons, expersons,
IF(exdate,exdate,edate) edate, 
IF(x.reserved,x.reserved,o.reserved) reserved,
reservation, uid, status, style, counter, catid, catname, catimg, exid, exdate";
$now = time();
$cond = 'status='.STAT_NORMAL;
//$cond .= " AND IF(exdate,exdate,edate)>$now";
$cond .= " AND e.eid=$eid";
if (isset($_GET['sub'])) {
    $cond .= " AND x.exid=".intval($_GET['sub']);
}
$result = $xoopsDB->query('SELECT '.$fields.' FROM '.EGTBL.' e LEFT JOIN '.
OPTBL.' o ON e.eid=o.eid LEFT JOIN '.CATBL.' ON topicid=catid LEFT JOIN '.
EXTBL." x ON e.eid=eidref WHERE $cond ORDER BY edate");

if (isset($_GET['line'])) {
    $max_rows=intval($_GET['line']);
    $max_sect=max(1,intval(40/$max_rows));
} elseif ($xoopsDB->getRowsNum($result)==1) { // only one page
    $max_sect=1;
    $max_rows=eguide_form_options('excel_max_rows', 0); // max line output
} else {				      // multiple sections
    $max_sect=eguide_form_options('excel_multi_sections', 5);
    $max_rows=eguide_form_options('excel_multi_rows', 8);
}

$sheets = array();

$items = explodeopts($optfield);
$outs = array();
if ($xoopsModuleConfig['export_field']) {
    $temp = $items;
    array_unshift($temp, _MD_ORDER_DATE, _MD_EMAIL, _MD_RVID, _MD_UNAME);
    $exports = preg_split('/\\s*,\\s*/',$xoopsModuleConfig['export_field']);
    foreach ($exports as $k) {
	if ($k == '*') {	// left all
	    foreach ($temp as $v) {
		if (!isset($outs[$v])) $outs[$v] = true;
	    }
	    break;
	} elseif (preg_match('/^\\d+$/', $k)) {	// present position
	    if (isset($temp[$k])) {
		$outs[$temp[$k]] = true;
	    }
	} elseif ($k == '' || in_array($k, $temp)) { // present name
	    $outs[$k] = true;
	}
    }
}
$nfield = eguide_form_options('excel_max_cols', count($outs)+1);
$outs = array_keys($outs);
$blank = array();
$nbsp = array("value"=>"", "type"=>"String");
for ($i=0; $i<$nfield; $i++) {
    $blank[] = $nbsp;
}

while ($data = $xoopsDB->fetchArray($result)) {
    $edate = $data['edate'];
    $tab = formatTimestamp($edate, 'md');
    $n = 1;
    while (isset($sheets[$tab]) && count($sheets[$tab]['rows'])>=$max_sect) {
	$n++;
	$tab = formatTimestamp($edate, 'md')."($n)";
    }
    if (empty($sheets[$tab])) {
	$day = formatTimestamp($edate, 'Y-m-d');
	$sheets[$tab] = array('title'=>$data['title'], 'edate'=>$day, 'rows'=>array());
    }
    $res = $xoopsDB->query("SELECT * FROM ".RVTBL." WHERE eid=$eid AND status="._RVSTAT_RESERVED." AND exid=".(empty($data['exid'])?0:$data['exid']));
    $rows = array();
    $member_handler =& xoops_gethandler('member');
    while ($rvdata = $xoopsDB->fetchArray($res)) {
	$row = unserialize_text($rvdata['info']);
	$user = $member_handler->getUser($rvdata['uid']);
	$name = is_object($user)?$user->getVar('name'):'';
	$row[_MD_ORDER_DATE] = formatTimestamp($rvdata['rdate'], 'Y-m-d H:i:s');
	$row[_MD_EMAIL] = $rvdata['email'];
	$row[_MD_UNAME] = is_object($user)?$user->getVar('uname').($name?" ($name)":""):$xoopsConfig['anonymous'];
	$row[_MD_RVID] = $rvdata['rvid'];
	$vals = array();
	foreach ($outs as $k) {
	    $v = empty($k)||empty($row[$k])?"":$row[$k];
	    $type = preg_match('/^-?\\d+$/', $v)?"Number":"String";
	    $vals[] = array('value'=>$v, 'type'=>$type);
	}
	while (count($vals) < $nfield) { // padding blanks
	    $vals[] = $nbsp;
	}
	$rows[] = $vals;
    }
    while (count($rows)<$max_rows) {	// minimum line padding
	$rows[] = $blank;
    }
    if ($max_rows==0) $max_rows = count($rows);
    $time = formatTimestamp($edate, 'H:i');
    $sheets[$tab]['rows'][$time]=$rows;
}
while (count($outs) < $nfield) {
    $outs[] = "";
}

$fileTpl = new XoopsTpl();
$fileTpl->assign(array('sheets'=>$sheets,
		       'created'=>date('Y-m-d\TH:i:s\Z', $now-$xoopsConfig['server_TZ']*3600),
		       'uname'=>$xoopsUser->getVar('uname'),
		       'max_sect'=>$max_sect,
		       'max_rows'=>$max_rows, 'max_cols'=>$nfield,
		       'items'=>$outs));

$fileTpl->template_dir = EGUIDE_PATH.'/templates';
$contents = $fileTpl->fetch('db:eguide_excel.xml');

$tm=formatTimestamp($now, 'Ymd');
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=eguide-$tm.xml");
header("Cache-Control: public");
header("Pragma: public");

if (function_exists("mb_convert_encoding")) {
    echo mb_convert_encoding($contents, _MD_EXPORT_CHARSET, _CHARSET);
} else {
    echo $contents;
}

exit;
?>