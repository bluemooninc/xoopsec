<?php
// Event Guide global administration
// $Id: index.php,v 1.35 2008-10-19 14:25:11 nobu Exp $

include 'admin_header.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

$op = param('op', 'events');
$eid = param('eid');

function css_tags() { return array("even","odd"); }
if ($op == 'summary_csv') summary_csv();

global $mydirpath, $mydirname;
$mydirpath = dirname(dirname(__FILE__));
$mydirname = basename($mydirpath);
if( ! empty( $_GET['lib'] ) ) {
    // common libs (eg. altsys)
    $lib = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET['lib'] ) ;
    $page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_GET['page'] ) ;
    
    if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ) ) {
	include XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ;
	} else if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ) ) {
	include XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ;
    } else {
	die( 'wrong request' ) ;
    }
    exit;
}

switch ($op) {
case 'catsave':
    $catid=intval($_POST['catid']);
    $vals = array();
    foreach (array('catname', 'catdesc', 'catpri', 'weight', 'catimg') as $k) {
	$vals[$k] = $xoopsDB->quoteString(param($k,''));
    }
    if ($catid) {
	foreach ($vals  as $k=>$v) {
	    $vals[$k] = "$k=$v";
	}
	$xoopsDB->query("UPDATE ".CATBL." SET ".join(',', $vals)." WHERE catid=$catid");
    } else {
	$xoopsDB->query("INSERT INTO ".CATBL."(".join(',', array_keys($vals)).") VALUES (".join(',', $vals).")");
    }
    redirect_header("?op=category",1,_AM_DBUPDATED);
    exit;

case 'save':
    $status = param('status');
    $uid = param('uid');
    $result = $xoopsDB->query("UPDATE ".EGTBL." SET uid=$uid, status=$status WHERE eid=$eid");
    redirect_header("?op=events",1,_AM_DBUPDATED);
    exit;
case 'delnotify':
    $dels = array();
    foreach ($_POST['rm'] as $v) {
	$dels[] = intval($v);
    }
    $result = $xoopsDB->queryF($sql = "DELETE FROM ".RVTBL." WHERE eid=0 AND rvid IN (".join(',', $dels).")");
    redirect_header("?op=notifies",1,_AM_DBUPDATED);
    exit;

case 'catdel':
    $dels = $_POST['dels'];
    foreach (array_keys($dels) as $i) {
	$dels[$i] = intval($i);
    }
    $res = $xoopsDB->query("DELETE FROM ".CATBL." WHERE catid IN (".join(",",$dels).")");
    redirect_header("?op=category",1,_AM_DBUPDATED);
    exit;

case 'impsave':
    $mid = param('mid');
    $res = $xoopsDB->query('SELECT * FROM '.$xoopsDB->prefix('newblocks')." WHERE mid=$mid AND func_num=1");
    if (!$res || $xoopsDB->getRowsNum($res)!=1) {
	redirect_header('?op=category', 3, _NOPERM);
	exit;
    }
    $block = $xoopsDB->fetchArray($res);
    $prefix = preg_replace('/_block_top\.html$/', '', $block['template']);
    $xoopsDB->query('DELETE FROM '.CATBL);
    function dbquote($x) {
	global $xoopsDB;
	return $xoopsDB->quoteString($x);
    }
    $res = $xoopsDB->query('SELECT * FROM '.$xoopsDB->prefix($prefix.'_category'));
    while ($data = $xoopsDB->fetchArray($res)) {
	if (!$xoopsDB->query('INSERT INTO '.CATBL.' VALUES ('.join(',', array_map('dbquote',$data)).')')) die('DB ERROR');
    }
    redirect_header("?op=category", 1, _AM_DBUPDATED);
    exit;
case 'resvCtrl':
    $rv = isset($_POST['rv'])?$_POST['rv']:array();
    $ck = isset($_POST['ck'])?$_POST['ck']:array();
    $off = $on = "";
    foreach (array_keys($rv) as $k) {
	if (isset($ck[$k])) {
	    if ($on!="") $on .= " OR ";
	    $on .= "eid=".intval($k);
	} else {
	    if ($off!="") $off .= " OR ";
	    $off .= "eid=".intval($k);
	}
    }
    if ($on != "") {
	$result = $xoopsDB->query("UPDATE ".OPTBL." SET reservation=1 WHERE $on");
    }
    if ($off != "") {
	$result = $xoopsDB->query("UPDATE ".OPTBL." SET reservation=0 WHERE $off");
    }
    redirect_header("?op=events",1,_AM_DBUPDATED);
    exit;

}

xoops_cp_header();
include 'mymenu.php';

$myts =& MyTextSanitizer::getInstance();
$tags = css_tags();

switch ($op) {
case 'events':
    echo "<h3>"._MI_EGUIDE_EVENTS."</h3>";
    echo '<hr /><br />';
    echo "<ul class=\"toptab\"><li class=\"add\"><a href=\"../admin.php\">"._MI_EGUIDE_SUBMIT."</a> </li></ul>\n";
    $result = $xoopsDB->query('SELECT count(eid) FROM '.EGTBL);
    list($count) = $xoopsDB->fetchRow($result);
    $max = $xoopsModuleConfig['max_list'];
    $start = isset($_GET['start'])?intval($_GET['start']):0;
    $nav = new XoopsPageNav($count, $max, $start, "start", 'op=events');

    $result = $xoopsDB->query('SELECT o.*,edate,title,uid,status FROM '.EGTBL.
			      ' e LEFT JOIN '.OPTBL." o ON e.eid=o.eid ORDER BY e.eid DESC",$max,$start);
    $n = 0;
    echo "<form method='post'>\n";
    if ($count>$max) echo "<div>".$nav->renderNav()."</div>";
    echo "<table class='outer'>\n";
    echo "<tr><th>"._AM_RESERVATION."</th><th>".
	_AM_EVENT_DAY."</th><th>"._AM_TITLE."</th>";
    echo "<th>"._AM_POSTER."</th><th>"._AM_DISP_STATUS."</th>";
    echo "<th>"._AM_OPERATION."</th></tr>\n";
    while ($data = $xoopsDB->fetchArray($result)) {
	$bg = $tags[$n++%2];
	$eid = $data['eid'];
	$date = eventdate($data['edate']);
	$title = "<a href='../event.php?eid=$eid'>".$data['title']."</a>";
	$poster = new XoopsUser($data['uid']);
	$u = "<a href='".XOOPS_URL."/userinfo.php?uid=".$poster->uid()."'>".$poster->uname()."</a>";
	$s = $data['status'];
	$sn = $ev_stats[$data['status']];
	if ($s == STAT_DELETED) {
	    $sn = "<a href='../admin.php?op=delete&eid=$eid' class='deleted'>$sn</a>";
	} elseif ($s == STAT_POST) {
	    $sn = "<strong>$sn</strong>";
	}
	$ors = $xoopsDB->query("SELECT reservation FROM ".OPTBL." WHERE eid=$eid");
	if ($xoopsDB->getRowsNum($ors)) {
	    list($resv) = $xoopsDB->fetchRow($ors);
	    $mk = "<input type='hidden' name='rv[$eid]' value='on' />";
	    $mk .= "<input type='checkbox' name='ck[$eid]' ".($resv?" checked":"")." />";
	} else {
	    $mk = "&nbsp;";
	}
	    
	$edit = "<a href='../admin.php?eid=$eid' class='edit'>"._EDIT."</a>".
	    " <a href='?op=edit&eid=$eid' class='status'>"._AM_EDIT."</a>".
	    " <a href='../admin.php?op=delete&eid=$eid' class='delete'>"._DELETE."</a>";
	echo "<tr class='$bg'><td align='center'>$mk</td><td>$date</td><td>$title</td>";
	echo "<td>$u</td><td>$sn</td><td class='operate'>$edit</td></tr>\n";
    }
    echo "<tr><td colspan=\"6\" class=\"foot\">\n";
    echo "<input type='hidden' name='op' value='resvCtrl' />\n";
    echo "<input type='submit' value='"._AM_UPDATE."' />\n";
    echo "</td></tr></table></form>\n";
    $result = $xoopsDB->query("SELECT count(rvid) FROM ".RVTBL." WHERE eid=0");
    if ($result) {
	list($n) = $xoopsDB->fetchRow($result);
	echo "<ul class=\"toptab\"><li class=\"add\"><a href='?op=notifies'>"._MD_INFO_REQUEST."</a> ".sprintf(_MD_INFO_COUNT, $n)."</li></ul>\n";
    }
    CloseTable();
    break;

case 'notifies':
    echo "<h3>"._MD_INFO_REQUEST."</h3>";
    echo '<hr /><br />';
    $cond = "eid=0";
    if (isset($_GET['q'])) {
	$q = $_GET['q'];
	$cond .= " AND email like '%$q%'";
    }
    $result = $xoopsDB->query("SELECT * FROM ".RVTBL." WHERE $cond ORDER BY rdate");
    $n = 0;
    $nc = $xoopsDB->getRowsNum($result);
    echo "<form method='get'>\n".
	_AM_INFO_SEARCH." <input name='q' />".
	" <input type='hidden' name='op' value='notifies' />\n".
	" <input type='submit' value='"._SUBMIT."' />\n".
	"</form>\n";
    echo "<ul class=\"toptab\"><li class=\"add\"><a href='../reserv.php?op=register'>"._MI_EGUIDE_REG."</a></li></ul>\n";
    echo sprintf(_MD_INFO_COUNT, $nc);
    if ($nc) {
	echo "<form method='post'>\n".
	    "<input type='hidden' name='op' value='delnotify' />\n".
	    "<table class='outer'>\n".
	    "<tr><th></th><th>"._MD_ORDER_DATE."</th>".
	    "<th>"._AM_EMAIL."</th></tr>\n";
	while ($data = $xoopsDB->fetchArray($result)) {
	    $bg = $tags[$n++%2];
	    $rvid = $data['rvid'];
	    $date = formatTimestamp($data['rdate'], _AM_POST_FMT);
	    $email = $data['email'];
	    if (isset($data['uid'])) {
		$uid = $data['uid'];
		$uinfo = " (<a href='".XOOPS_URL."/userinfo.php?uid=$uid'>".XoopsUser::getUnameFromId($uid)."</a>)";
	    } else {
		$uinfo = "";
	    }
	    echo "<tr class='$bg'><td align='center'><input type='checkbox' name='rm[]' value='$rvid' /></td>".
		"<td>$date</td><td>$email $uinfo</td></tr>\n";
	}
	echo "<tr><td colspan=\"3\" class=\"foot\"><input type='submit' value='"._DELETE."' /> </td></tr>\n";
	echo "</table>";
    } else {
	echo "<div class='error'>"._AM_NODATA."</div>";
    }
    CloseTable();
    break;

case 'edit':
    $result = $xoopsDB->query("SELECT eid,edate,cdate,title,uid,status FROM ".EGTBL." WHERE eid=$eid");
    $data = $xoopsDB->fetchArray($result);
    $date = eventdate($data['edate']); 
    $title = "<a href='../event.php?eid=$eid'>".$data['title']."</a>";
    $uid = $data['uid'];
    $poster = new XoopsUser($uid);
    $post = formatTimestamp($data['cdate'], _AM_POST_FMT);

    echo "<h3>"._MI_EGUIDE_EVENTS." &gt;&gt; "._AM_DISP_STATUS."</h3>";
    echo "<hr /><br />";
    echo "<form method='post'>\n";
    echo "<table class='outer'>\n";
    echo "<tr><th colspan=\"2\">"._AM_TITLE." : $title</th></tr>";
    echo "<tr><td class='head'>"._AM_EVENT_DAY."</td><td class='even'>$date</td></tr>\n";
    echo "<tr><td class='head'>"._AM_TITLE."</td><td class='odd'>$title</td></tr>\n";
    echo "<tr><td class='head'>"._AM_POSTER."</td><td class='even'>";
    $result = $xoopsDB->query("SELECT u.uid,groupid,uname".
	" FROM ".$xoopsDB->prefix("groups_users_link")." l, ".
	$xoopsDB->prefix("users")." u WHERE l.uid=u.uid AND ".
	"(groupid=1 OR groupid=".$xoopsModuleConfig['group'].") GROUP BY u.uid ORDER BY uname");
    echo "<select name='uid'>\n";
    while($p=$xoopsDB->fetchArray($result)) {
	$ck = ($uid==$p['uid'])?" selected":"";
	printf("<option value='%d'$ck>%s</>\n", $p['uid'], $p['uname']);
    }
    echo "</select></td></tr>\n";
    echo "<tr><td class='head'>"._AM_POSTED."</td><td class='odd'>$post</td></tr>\n";
    echo "<tr><td class='head'>"._AM_DISP_STATUS."</td><td class='even'>\n";
    echo "<select name='status'>\n";
    $status=$data['status'];
    foreach ($ev_stats as $i =>$v) {
	$ck = ($status == $i)?" selected":"";
	echo "<option value='$i'$ck>$v</option>\n";
    }
    echo "</select>\n";
    echo "</td></tr>\n";
    echo "<tr><td colspan=\"2\" class=\"foot\"><input type='hidden' name='op' value='save' />";
    echo "<input type='hidden' name='eid' value='$eid' />";
    echo "<input type='submit' value='"._AM_UPDATE."' />";
    echo "&nbsp;<input type='button' value='"._AM_CANCEL."' onclick='javascript:history.go(-1)' />";
    echo "</td></tr></table>\n";
    echo "</form>";
    CloseTable();
    break;

case 'category':
    echo "<h3>"._AM_CATEGORY."</h3>\n";
    echo "<hr /><br />";

    if (isset($_GET['catid'])) {
	edit_category(intval($_GET['catid']));
    } else {
	show_categories();
    }
    break;

case 'catimp':
    echo "<h3>"._AM_CATEGORY."</h3>\n";
    echo "<hr /><br />";

    import_category();
    break;

case 'summary':
    echo "<h3>"._AM_SUMMARY."</h3>\n";
    echo "<hr /><br />";

    $now = time();
    $result = $xoopsDB->query('SELECT count(eid) FROM '.EGTBL.' LEFT JOIN '.EXTBL." ON eid=eidref");
    list($count) = $xoopsDB->fetchRow($result);
    $max = $xoopsModuleConfig['max_list'];
    $start = isset($_GET['start'])?intval($_GET['start']):0;
    $nav = new XoopsPageNav($count, $max, $start, "start", 'op=summary');
    $show = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/event.php';
    $receipt = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/receipt.php';
    $result = $xoopsDB->query('SELECT e.eid,if(x.exid,x.exid,0) exid, IF(exdate,exdate,edate) exdate,title,uid,status,persons,IF(x.reserved,x.reserved,o.reserved) reserved FROM '.EGTBL.' e LEFT JOIN '.OPTBL.' o ON e.eid=o.eid LEFT JOIN '.EXTBL." x ON e.eid=eidref ORDER BY exdate DESC,e.eid DESC", $max, $start);

    if ($count>$max) echo $nav->renderNav();
    echo "<ul class=\"toptab\"><li class=\"save\"><a href='index.php?op=summary_csv'>"._MD_CSV_OUT."</a></li></ul>\n";

    echo "<p>".sprintf(_MD_INFO_COUNT,$start+1)."/$count</p>";

    echo "<table class='outer'>";
    $n = 0;
    echo "<tr><th>ID</th><th>"._MD_EXTENT_DATE."</th><th>"._AM_TITLE."</th>".
	"<th>"._AM_POSTER."</th><th>"._MD_RESERV_PERSONS."</th><th>"._AM_RESERVATION."</th></tr>\n";
    while ($data=$xoopsDB->fetchArray($result)) {
	$bg = $tags[$n++%2];
	$eid = $data['eid'];
	$exid = $data['exid'];
	$id = $eid;
	if ($exid) $id .= '-'.$exid;
	$param = 'eid='.$eid;
	if ($exid) $param .= '&sub='.$exid;
	$date = eventdate($data['exdate']);
	$title = "<a href='$show?$param'>".$myts->makeTboxData4Show($data['title'])."</a>";
	$uname = xoops_getLinkedUnameFromId($data['uid']);
	$reserved = $data['reserved'];
	if ($reserved) $reserved = "<a href='$receipt?$param'>$reserved</a>";
	echo "<tr class='$bg'><td>$id<td>$date</td><td>$title</td>".
	    "<td>$uname</td><td align='right'>".$data['persons'].
	    "</td><td align='right'>$reserved</td></tr>\n";
    }
    echo "</table>";
    break;
}

xoops_cp_footer();

function show_categories() {
    global $xoopsDB;
    $myts =& MyTextSanitizer::getInstance();
    $res = $xoopsDB->query('SELECT c.*,count(topicid) count, if (p.weight, p.weight, c.weight) ord1, if(p.weight IS NULL, -1, c.weight) ord2 FROM '.CATBL.' c LEFT JOIN '.CATBL.' p ON c.catpri=p.catid LEFT JOIN '.EGTBL.' ON c.catid=topicid GROUP BY c.catid ORDER BY ord1,ord2,c.catid');

    // display entries
    $showlist = array('catname'=>_AM_CAT_NAME, 'weight'=>_AM_WEIGHT,
		      'catimg' =>_AM_CAT_IMG,  'catdesc'=>_AM_CAT_DESC, 
		      'count'  =>_AM_COUNT,    'op'=>_AM_OPERATION);

    echo "
	<ul class=\"toptab\">
	<li class=\"addDir\">
	<a href='index.php?op=category&catid=0'>"._AM_CATEGORY_NEW."</a>
	</li>
	<li class=\"import\">
	<a href='index.php?op=catimp'>"._AM_CATEGORY_IMPORT."</a>
	</li>
	</ul>\n";

    echo "<p class='evnavi'>"._AM_COUNT.' '.$xoopsDB->getRowsNum($res)."</p>";

    echo "<form action='index.php?op=catdel' method='post'>\n";
    echo "<table class=\"outer\">\n";
    echo "<tr><th>"._DELETE."</th><th>".join('</th><th>', $showlist)."</th></tr>\n";
    $ndel = $n = 0;
    while ($data = $xoopsDB->fetchArray($res)) {
	$name =  $myts->htmlSpecialChars($data['catname']);
	$haschild = $data['count'];
	if ($data['catpri']) {
	    $data['catname'] = " -- ".$name;
	} else {
	    if ($haschild==0) {
		$sub = $xoopsDB->query("SELECT count(catid) FROM ".CATBL." WHERE catpri=".$data['catid']);
		list($haschild) = $xoopsDB->fetchRow($sub);
	    }
	}
	$id = $data['catid'];
	$desc =  $myts->htmlSpecialChars($data['catdesc']);
	$img = $data['catimg'];
	if (preg_match('/^\//', $img)) $img = XOOPS_URL.$img;
	elseif (!empty($img) && !preg_match('/^https?:/', $img)) {
	    $img = EGUIDE_URL."/$img";
	} else {
	    $img = "";
	}
	if (!empty($img)) $img = "<img src='$img' alt='$name' width='32' />";
	$data['catimg'] = $img;
	$data['op'] = "<a href='index.php?op=category&catid=$id'>"._EDIT."</a>";
	if ($haschild) {
	    $del="-";
	} else {
	    $del="<input type='checkbox' name='dels[$id] value='$id'/>";
	    $ndel++;
	}
	echo '<tr class="'.($n++%2?'even':'odd')."\"><td align='center'>$del</td>";
	foreach (array_keys($showlist) as $key) {
	    echo "<td>".$data[$key]."</td>";
	}
	echo "</tr>\n";
    }
    if ($ndel) echo "<tr><td colspan=\"7\" class=\"foot\"><input type='submit' value='"._DELETE."'/></td></tr>";
    echo "</table></form>\n";
}

function edit_category($catid) {
    global $xoopsDB;

    $myts =& MyTextSanitizer::getInstance();
    if ($catid) {
	$res = $xoopsDB->query('SELECT * FROM '.CATBL." WHERE catid=$catid");
	$data = $xoopsDB->fetchArray($res);
    } else {
	$data = array('catid'=>0, 'catname'=>'', 'catimg'=>'','catdesc'=>'',
		      'catpri'=>0, 'weight'=>0);
    }
    $form = new XoopsThemeForm($catid?_AM_CATEGORY_EDIT:_AM_CATEGORY_NEW, 'myform', 'index.php');
    $form->addElement(new XoopsFormHidden('catid', $catid));
    $form->addElement(new XoopsFormHidden('op', 'catsave'));
    $form->addElement(new XoopsFormText(_AM_CAT_NAME, 'catname', 40, 40, $data['catname']), true);
    $form->addElement(new XoopsFormText(_AM_CAT_IMG, 'catimg', 60, 255, $data['catimg']));
    $form->addElement(new XoopsFormDhtmlTextArea(_AM_CAT_DESC, 'catdesc', $data['catdesc']));
    $catpri = new XoopsFormSelect(_AM_CAT_PRIMARY, 'catpri', $data['catpri']);
    $catpri->addOption(0, _NONE);
    foreach (get_eguide_category(false) as $cat) {
	if ($catid != $cat['catid']) {
	    $catpri->addOption($cat['catid'], $cat['name']);
	}
    }
    $form->addElement($catpri);
    $form->addElement(new XoopsFormText(_AM_WEIGHT, 'weight', 4, 4, $data['weight']));
    $form->addElement(new XoopsFormButton('' , 'catsave', _SUBMIT, 'submit'));
    $form->display();
}

function import_category() {
    global $xoopsDB, $xoopsModule;
    $mid = $xoopsModule->getVar('mid');
    $res = $xoopsDB->query('SELECT m.mid,m.name,template FROM '.$xoopsDB->prefix('newblocks')." n, ".$xoopsDB->prefix('modules')." m WHERE edit_func='b_event_top_edit' AND func_num=1 AND n.mid<>$mid AND n.mid=m.mid ORDER BY m.weight");
    $mods = array();
    while (list($mid, $name, $temp)=$xoopsDB->fetchRow($res)) {
	$mods[] = array('mid'=>$mid,
			'name'=>htmlspecialchars($name),
			'prefix'=>preg_replace('/_block_top\.html$/', '', $temp));
    }
    $selmod = new XoopsFormSelect(_AM_CAT_IMPORTFROM, 'mid');
    $selmod->addOption(0, _NONE);
    foreach ($mods as $i => $mod) {
	$res = $xoopsDB->query('SELECT count(catid) FROM '.$xoopsDB->prefix($mod['prefix'].'_category'));
	list($n) = $xoopsDB->fetchRow($res);
	$selmod->addOption($mod['mid'], $mod['name']." ("._AM_COUNT."$n)");
    }
    $form = new XoopsThemeForm(_AM_CATEGORY_IMPORT, 'myform', 'index.php');
    $form->addElement(new XoopsFormHidden('op', 'impsave'));
    $form->addElement($selmod);
    $selmod->setDescription(_AM_CAT_IMPORTDESC);
    $form->addElement(new XoopsFormButton('' , 'impsave', _SUBMIT, 'submit'));
    $form->display();
}

function summary_csv() {
    global $xoopsDB;
    function _q($x) { return '"'.preg_replace('/"/', '""', $x).'"'; }
    $file = "eguide_summary_".formatTimestamp(time(),"Ymd").".csv";
    $charset = eguide_form_options('export_charset', _MD_EXPORT_CHARSET);
    header("Content-Type: text/plain; Charset=".$charset);
    header('Content-Disposition:attachment;filename="'.$file.'"');

    $result = $xoopsDB->query('SELECT e.eid,if(x.exid,x.exid,0) exid, IF(exdate,exdate,edate) exdate,title,uid,status,persons,IF(x.reserved,x.reserved,o.reserved) reserved FROM '.EGTBL.' e LEFT JOIN '.OPTBL.' o ON e.eid=o.eid LEFT JOIN '.EXTBL." x ON e.eid=eidref ORDER BY exdate DESC,e.eid DESC");
    $out = '"'.join('","',array("ID","",_MD_EXTENT_DATE,_AM_TITLE,_AM_POSTER,_MD_RESERV_PERSONS,_AM_RESERVATION))."\"\n";
    while ($data=$xoopsDB->fetchArray($result)) {
	$date = eventdate($data['exdate']);
	$poster = XoopsUser::getUnameFromId($data['uid']);
	$exid = $data['exid']?$data['exid']:'';
	$out .= join(',',array($data['eid'],$exid,_q($date),
			       _q($data['title']),_q($poster),
			       $data['persons'],$data['reserved']))."\n";
    }
    if ($charset != _CHARSET) {
	if (function_exists("mb_convert_encoding")) {
	    $out = mb_convert_encoding($out, $charset, _CHARSET);
	} elseif (function_exists("iconv")) {
	    $out = iconv($charset, _CHARSET, $out);
	}
    }
    echo $out;
    exit;
}
?>