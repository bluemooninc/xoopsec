<?php
// Event Guide common functions
// $Id: functions.php,v 1.40 2010-10-10 10:11:55 nobu Exp $

// exploding addional informations.
function explodeopts($opts) {
    $myitem = array();
    foreach (explode("\n",preg_replace('/\r/','',$opts)) as $ln) {
	// comment line
	if (preg_match('/^\s*#/', $ln)||preg_match('/^\s*$/', $ln)) continue;
	$fld = preg_split("/,\s*/", $ln);
	$lab = preg_replace('/^!\s*/', '', preg_replace('/[\*#]$/', "", array_shift($fld)));
	$myitem[] =  $lab;
    }
    return $myitem;
}

if (!function_exists("unserialize_vars")) {
    // expand: label=value[,\n](label=value...) 
    function unserialize_vars($text,$rev=false) {
	if (preg_match("/^\w+: /", $text)) return unserialize_text($text);
	$array = array();
	$text = ltrim($text);
	$pat = array('/""/', '/^"(.*)"$/');
	$rep = array('"', '$1');
	$delm = preg_match('/[\n\r]/', $text)?'\n\r':',\n\r'; // allow comma format
	while ($text && preg_match("/^(\"[^\"]*\"|[^\"$delm]*)*[$delm]?/", $text, $d)) {
	    $ln = preg_replace("/[\\s$delm]\$/", '', $d[0]);
	    $text = ltrim(substr($text, strlen($d[0])));
	    if (preg_match('/^\s*([^=]+)\s*=\s*(.+)$/', $ln, $d)) {
		if (preg_match('/^#/', $d[1])) continue;
		if ($rev) {
		    $k = $d[2];
		    $v = $d[1];
		} else {
		    $k = $d[1];
		    $v = $d[2];
		}
		$array[$k] = preg_replace($pat, $rep, $v);
	    }
	}
	return $array;
    }
}
if (!function_exists("serialize_text")) {
    function serialize_text($array) {
	$text = '';
	foreach ($array as $name => $val) {
	    if (is_array($val)) $val = join(', ', $val);
	    if (preg_match('/\n/', $val)) {
		$val = preg_replace('/\n\r?/', "\n\t", $val);
	    }
	    $text .= "$name: $val\n";
	}
	return $text;
    }

    function unserialize_text($text) {
	$array = array();
	foreach (preg_split("/\r?\n/", $text) as $ln) {
	    if (preg_match('/^\s/', $ln)) {
		$val .= "\n".substr($ln, 1);
	    } elseif (preg_match('/^([^:]*):\s?(.*)$/', $ln, $d)) {
		$name = $d[1];
		$array[$name] = $d[2];
		$val =& $array[$name];
	    }
	}
	return $array;
    }
}

function xss_filter($text) {
    return preg_replace('/<script[^>]*>.*<\/script[^>]*>/si', '', $text);
}

function edit_eventdata(&$data) {
    global $xoopsModuleConfig, $xoopsUser;

    $myts =& MyTextSanitizer::getInstance();
    $str = $pat = array();
    $pat[] = '{X_DATE}';
    $str[] = $data['ldate'] =
	empty($data['exdate'])?$data['edate']:$data['exdate'];
    if (isset($data['closetime'])) {
	$data['closedate']=$data['ldate']-$data['closetime'];
	$data['dispclose'] = eventdate($data['closedate'], _MD_TIME_FMT);
    }
    $data['date'] = eventdate($data['ldate']);
    $pat[] = '{X_TIME}';
    $str[] = $data['time'] = eventdate($data['ldate'], _MD_STIME_FMT);
    $post = isset($data['cdate'])?$data['cdate']:time();
    $data['postdate'] = formatTimestamp($post, _MD_POSTED_FMT);
    $data['uname'] = isset($data['uid'])?XoopsUser::getUnameFromId($data['uid']):$xoopsUser->getVar('uname');
    $data['hits'] = sprintf(_MD_REFER, $data['counter']);
    $br = 0;
    $html = 1;
    switch ($data['style']) {
    case 2: $html = 0;
    case 1: $br = 1;
    }
    $data['disp_summary'] = empty($data['summary'])?'':str_replace($pat,$str,xss_filter($myts->displayTarea($data['summary'],$html,0,1,1,$br)));
    $data['disp_body'] = empty($data['body'])?'':str_replace($pat,$str,xss_filter($myts->displayTarea($data['body'],$html,0,1,1,$br)));
    $data['title'] = $myts->htmlSpecialChars($data['title']);
    // fill of seat
    if (!empty($data['persons'])) {
	$data['reserv_num']=sprintf(_MD_RESERV_NUM, $data['persons']);
	$data['reserv_reg']=sprintf(_MD_RESERV_REG, $data['reserved']);
	
	$marker = preg_split('/,|[\r\n]+/',$xoopsModuleConfig['maker_set']);
	$fill=$data['fill']=intval($data['reserved']/$data['persons']*100);
	if ($data['closedate']<time()) $fill = -1;
	while(list($k,$v) = array_splice($marker, 0, 2)) {
	    if ($fill<$k) {
		$data['fill_mark'] = $v;
		break;
	    }
	}
    }
    $catlist = get_eguide_category();
    if (isset($data['topicid'])) {
	$cid = $data['topicid'];
	if (isset($catlist[$cid])) {
	    $data['catid'] = $cid;
	    $data['catname'] = $catlist[$cid]['name'];
	    $data['catimg'] = $catlist[$cid]['image'];
	    $data['catgory'] = $catlist[$cid];
	}
    }
    return $data;
}

function apply_user_vars($text) {
    global $xoopsUser;
    if (preg_match_all("/{X_([A-Z_]+)}/", $text, $d)) {
	$u = is_object($xoopsUser);
	foreach ($d[1] as $vname) {
	    $rep = $u?$xoopsUser->getVar(strtolower($vname)):'';
	    $text = str_replace("{X_$vname}", $rep, $text);
	}
    }
    return $text;
}

function eventform($data) {
    global $xoopsUser, $xoopsModuleConfig;
    $myts =& MyTextSanitizer::getInstance();

    if (empty($data['reservation'])) return null;

    $form = array();
    $optfield = $data['optfield'];
    // reservation form
    if (isset($_POST['email'])) {
	$email = $myts->stripSlashesGPC($_POST['email']);
    } else $email = is_object($xoopsUser)?$xoopsUser->email():"";
    $conf = isset($_POST['email_conf'])?$myts->stripSlashesGPC($_POST['email_conf']):$email;
    $form['email'] = $myts->makeTboxData4Edit($email);
    $form['email_conf'] = $myts->makeTboxData4Edit($conf);
    $form['user_notify'] = $xoopsModuleConfig['user_notify'];
    $form['check'] = array();
    $mo = $xoopsModuleConfig['member_only'];
    $mo = ($mo && is_object($xoopsUser)?$mo!=ACCEPT_MEMBER:0);
    $form['member_only'] = $mo;
    if (!$mo) $form['check']['email'] = preg_replace('/\\*$/', '', _MD_EMAIL).": ".strip_tags(_MD_ORDER_NOTE1);
    $items = array();
    $field = 0;
    $note1 = $note2 = "";
    foreach (explode("\n", $optfield) as $n) {
	$field++;
	$n = rtrim($n);
	if ($n=="") continue;
	$attr = "";
	$require = false;
	if (preg_match('/^\s*#/', $n)) {
	    $opts = preg_replace('/^\s*#\s*/', "", $n);
	    $type = "#";
	    $name = "&nbsp;";
	} else {
	    $opt = array(); 
	    $p = 0;
	    $len = strlen($n);
	    while ($p < $len) {
		$w = '';
		while ($p < $len) {
		    $c = $n[$p++];
		    if ($c == ',') break;
		    if($c == '\\' && $p<$len) {
			$c = $n[$p++];
			if ($c == 'n') $c = "\n";
			elseif ($c != '\\' && $c != ',') $c = "\\$c";
		    }
		    $w .= $c;
		}
		$opt[] = $w; 
	    }
	    $name = array_shift($opt);
	    if (preg_match('/[\*#]$/', $name)) {
		$require = true;
		$attr = 'evms';
		$note1 = _MD_ORDER_NOTE1;
	    }
	    if (preg_match('/^!/', $name)) {
		$name = preg_replace('/^!/', '', $name);
		$attr = 'evop';
		$note2 = _MD_ORDER_NOTE2;
	    }
	    $v = "";
	    $type = "text";
	    $aname = isset($opt[0])?strtolower($opt[0]):"";
	    switch ($aname) {
		case "hidden":
		case "const":
		case "text":
		case "checkbox":
		case "radio":
		case "textarea":
		case "select":
		    $type = $aname;
		    array_shift($opt);
	    }
	    if ($type=='hidden') continue;
	    $size = eguide_form_options('size', 60);
	    $cols = eguide_form_options('cols', 40);
	    $rows = eguide_form_options('rows', 5);
	    $opts = "";
	    $comment = "";
	    $fname = "opt$field";
	    $sub = 0;
	    $prop = '';
	    if (isset($_POST[$fname])) {
		$v = $myts->stripSlashesGPC($_POST[$fname]);
	    }
	    while ($opt) {
		$op = array_shift($opt);
		if (preg_match("/^#/",$op)) {
		    array_unshift($opt, preg_replace("/^#/","",$op));
		    $comment .= join(',', $opt);
		    $opt = array();
		    continue;
		}
		$args = explode("=", $op, 2);
		// XXX: strtolower PHP4 mbstring bug escape.
		$aname=isset($args[1])?strtolower($args[0]):$args[0];
		switch ($aname) {
		case "size":
		    $size = $args[1];
		    break;
		case "rows":
		    $rows = $args[1];
		    break;
		case "cols":
		    $cols = $args[1];
		    break;
		case 'prop':
		   $prop = $args[1]; 
		   break; 
		default:
		    $an = preg_replace('/\+$/', "", $args[0]);
		    if ($v) {
			$ck = ($an == $v)?" checked='checked'":"";
		    } else {
			$ck = ($an != $args[0])?" checked='checked'":"";
		    }
		    if ($type=='radio') {
			$sub++;
			if (isset($args[1])) {
			    $opts .= "<input type='$type' name='$fname' value='$an'$ck $prop/>".$args[1]." ";
			} else {
			    $opts .= "<input type='$type' name='$fname' value='$an'$ck $prop/>$an &nbsp; ";
			}
		    } elseif (in_array($type, array('text','textarea','const'))) {
			if (!isset($_POST[$fname])) {
			    $v .= ($v==""?"":",").$op;
			}
		    } elseif ($type=='checkbox') {
			if (isset($_POST[$fname])) {
			    $ck = in_array($an, $_POST[$fname])?' checked':'';
			}
			$lab = empty($args[1])?"$an &nbsp; ":$args[1]." ";
			$opts .= "<input type='$type' name='${fname}[]' id='${fname}[]' value='$an'$ck $prop/>".$lab;
		    } elseif ($type=='select') {
			if ($ck != "") $ck = " selected";
			$lab = empty($args[1])?$an:$args[1];
			$opts .= "<option value='$an'$ck>$lab</option>\n";
		    }
		}
	    }
	    if (!isset($_POST[$fname])) {
		if (empty($v) && $xoopsUser && preg_match(_MD_NAME, $name)) { // compat old version
		    $v = $xoopsUser->getVar('name');
		} else $v = apply_user_vars($v);
		$v = htmlspecialchars($v);
	    }
	    if ($type == "text") {
		$opts .= "<input size='$size' name='$fname' value=\"$v\" $prop/>";
	    } elseif ($type == "textarea") {
		$opts .= "<textarea name='$fname' rows='$rows' cols='$cols' wrap='virtual' $prop>$v</textarea>";
	    } elseif ($type == "select") {
		$opts = "<select name='$fname' $prop>\n$opts</select>";
	    } elseif ($type == "const") {
		$opts = $v;
	    }
	}
	if ($require) {
	    if ($type == 'checkbox') $fname .= '[]';
	    $form['check'][$fname] = preg_replace('/\\*$/', '', $name).": ".strip_tags(_MD_ORDER_NOTE1);
	}
	$name = preg_replace('/\\*$/', _MD_REQUIRE_MARK, $name);
	if ($attr=='evop') $name = sprintf(_MD_LISTITEM_FMT, $name);
	$items[] = array('attr'=>$attr, 'label'=>$name,
			 'value'=>$opts, 'comment'=>$comment);
    }
    $form['op'] = ($xoopsModuleConfig['has_confirm']&&
		   (count($items)||!$mo))?'confirm':'order';
    $form['items'] = $items;
    $form['note'] = $note1.(!empty($note1)&&!empty($note2)?" ":"").$note2;
    $form['eid'] = empty($data['eid'])?0:$data['eid'];
    $form['options'] = eguide_form_options();
    return $form;
}

// remove slashes
if (XOOPS_USE_MULTIBYTES && function_exists("mb_convert_encoding") &&
    $GLOBALS['xoopsConfig']['language'] == 'japanese') {
    if (get_magic_quotes_gpc()) {
	function post_filter($s) {
	    return mb_convert_encoding(stripslashes($s), _CHARSET, "EUC-JP,UTF-8,Shift_JIS,JIS");
	}
    } else {
	function post_filter($s) {
	    return mb_convert_encoding($s, _CHARSET, "EUC-JP,UTF-8,Shift_JIS,JIS");
	}
    }
} else {
    if (get_magic_quotes_gpc()) {
	function post_filter($s) {
	    return stripslashes($s);
	}
    } else {
	function post_filter($s) {
	    return $s;
	}
    }
}

// take HTTP paramater with normalize filter
function param($name, $def=0) {
    if (isset($_POST[$name])) $val = $_POST[$name];
    elseif (isset($_GET[$name])) $val = $_GET[$name];
    else return $def;
    return is_numeric($def)?intval($val):post_filter($val);
}

// set ldate to next event date if exists extent entry.
function set_next_event() {
    global $xoopsDB;
    $now = time();
    // Search already passed event that exist next extent.
    $res = $xoopsDB->query("SELECT eid, min(exdate),edate FROM ".EGTBL." LEFT JOIN ".EXTBL." ON eid=eidref AND exdate>$now WHERE (edate<$now OR ldate=0) AND ldate<$now AND expire>$now GROUP BY eid");
    while (list($eid, $exdate, $edate) = $xoopsDB->fetchRow($res)) {
	if (empty($exdate)) $exdate = $edate;
	$xoopsDB->queryF("UPDATE ".EGTBL." SET ldate=$exdate WHERE eid=$eid");
    }
}

function get_extents($eid, $all=false) {
    global $xoopsDB;
    $result=$xoopsDB->query('SELECT exid,exdate,expersons,x.reserved,if(expersons IS NULL,persons,expersons) persons FROM '.EXTBL.' x LEFT JOIN '.OPTBL." o ON eidref=eid WHERE eidref=$eid".($all?"":" AND exdate-closetime>".time()).' ORDER BY exdate');
    $extents = array();
    while ($extent = $xoopsDB->fetchArray($result)) {
	$extent['date'] = eventdate($extent['exdate']);
	$extents[] = $extent;
    }
    return $extents;
}

function eventdate($time, $format="", $offset="") {
    global $ev_week, $ev_month, $xoopsModuleConfig;
    if (empty($format)) $format = $xoopsModuleConfig['date_format'];
    $bound = eguide_form_options('bound_time', 0);
    if ($bound) {
	$etime = formatTimestamp($time, "H:i", $offset);
	if ($etime <= $bound) {
	    $ehour = intval(preg_replace('/:\d+$/', '', $etime));
	    $pat = array("g", "G", "h", "H");
	    $h12 = $ehour+12;
	    $h24 = $ehour+24;
	    $rep = array($h12, $h24, $h12, $h24);
	    switch (strtolower($format)) {
	    case 's':
		$format = _SHORTDATESTRING;
		break;
	    case 'm':
		$format = _MEDIUMDATESTRING;
		break;
	    case 'mysql':
		$format = "Y-m-d H:i:s";
		break;
	    case 'rss':
		$format = "r";
		break;
	    case 'l':
		$format = _DATESTRING;
		break;
	    }
	    $format = str_replace($pat, $rep, $format);
	    $time = $time - 43200; // sec of a 12hours
	}
    }
    $str = formatTimestamp($time, $format, $offset);
    if (isset($ev_week)) {
	static $week;
	if (!isset($week)) $week = preg_word_quote($ev_week);
	$str = preg_replace($week, $ev_week, $str);
    }
    if (isset($ev_month)) {
	static $month;
	if (!isset($month)) $month = preg_word_quote($ev_month);
	$str = preg_replace($month, $ev_month, $str);
    }
    return $str;
}

function preg_word_quote($a) {
    $ret = array();
    foreach (array_keys($a) as $v) {
	$ret[] = '/\b'.preg_quote($v).'\b/';
    }
    return $ret;
}
function get_eguide_category($all=true, $indent='') {
    global $xoopsDB;
    static $catall, $cattop;
    if ($all) {
	if (isset($catall)) return $catall;
	$result = $xoopsDB->query("SELECT c.catid, c.catname AS name, c.catimg AS image,if (p.weight, p.weight, c.weight) ord1, if(p.weight IS NULL, -1, c.weight) ord2,c.catpri, c.catdesc FROM ".CATBL." c LEFT JOIN ".CATBL." p ON c.catpri=p.catid ORDER BY ord1,ord2,catid");
    } else {
	if (isset($cattop)) return $cattop;
	$result = $xoopsDB->query("SELECT catid, catname AS name, catimg AS image, catpri, catdesc FROM ".CATBL." WHERE catpri=0 ORDER BY weight,catid");
    }
    $list = array();
    while ($data=$xoopsDB->fetchArray($result)) {
	$id = $data['catid'];
	$name = htmlspecialchars($data['name']);
	if (!empty($data['catpri'])) $name = $indent.$name;
	$data['name'] = $name;
	$list[$id] = $data;
    }
    if ($all) $catall = $list;
    else $cattop = $list;
    return $list;
}

function set_eguide_breadcrumbs($catid=0, $paths=array()) {
    global $xoopsModule, $xoopsTpl;
    $modurl = EGUIDE_URL.'/';
    $breadcrumbs = array(array('name'=>$xoopsModule->getVar('name'), 'url'=>$modurl));
    $catlist = get_eguide_category($catid);
    if ($catid && !empty($catlist[$catid]['name'])) {
	$pri = $catlist[$catid]['catpri'];
	if ($pri) {
	    $breadcrumbs[] = array('name'=>$catlist[$pri]['name'],'url'=>$modurl."index.php?cat=$pri");
	}
	if (basename($_SERVER['SCRIPT_NAME'])!='index.php') {
	    $url = $modurl."index.php?cat=$catid";
	} else {
	    $url = '';
	}
	$breadcrumbs[] = array('name'=>$catlist[$catid]['name'],'url'=>$url);
    }
    foreach ($paths as $lab=>$path) {
	$breadcrumbs[] = array('name'=>htmlspecialchars($lab),
			       'url' => empty($path)?'':"$modurl$path");
    }
    $xoopsTpl->assign('xoops_breadcrumbs', $breadcrumbs);
}

// fetch event data set
function fetch_event($eid, $exid, $admin=false) {
    global $xoopsDB;
    $stc=$admin?"":"AND status=".STAT_NORMAL;
    $fields = "e.eid, cdate, title, summary, body, optfield,
IF(expersons IS NULL, persons, expersons) persons, edate opendate,
IF(exdate,exdate,edate) edate, IF(x.reserved,x.reserved,o.reserved) reserved, 
closetime, reservation, uid, status, style, counter, topicid, 
exid, exdate, strict, autoaccept, notify, optvars, uploadimage1, uploadimage2, uploadimage3";
    $result = $xoopsDB->query("SELECT $fields FROM ".EGTBL.' e LEFT JOIN '.OPTBL.
' o ON e.eid=o.eid LEFT JOIN '.EXTBL." x ON e.eid=eidref AND exid=$exid
  WHERE e.eid=$eid $stc");
    $data = $xoopsDB->fetchArray($result);
    if (!empty($data['optvars'])) {
	    eguide_form_options(unserialize_vars($data['optvars']));
    }
    return $data;
}

if (!function_exists("template_dir")) {
    function template_dir($file='') {
	global $xoopsConfig;
	$lang = $xoopsConfig['language'];
	$dir = dirname(__FILE__).'/language/%s/mail_template/%s';
	$path = sprintf($dir,$lang, $file);
	if (file_exists($path)) {
	    $path = sprintf($dir,$lang, '');
	} else {
	    $path = sprintf($dir,'english', '');
	}
	return $path;
    }
}

function eguide_from_name() {
    return eguide_form_options("from_name", defined('_MD_FROM_NAME')?_MD_FROM_NAME:$GLOBALS['xoopsModule']->getVar('name'));
}

function order_notify($data, $email, $value) {
    global $xoopsModuleConfig, $xoopsUser, $xoopsModule;

    $poster = new XoopsUser($data['uid']);
    $eid = $data['eid'];
    $exid = $data['exid'];
    $url = EGUIDE_URL.'/event.php?eid='.$eid.($exid?"&sub=$exid":'');

    $xoopsMailer =& getMailer();
    $xoopsMailer->useMail();

    $tplname = $data['autoaccept']?"accept%s.tpl":"order%s.tpl";
    $extra = eguide_form_options('reply_extension');
    $tplfile = sprintf($tplname, ''); // default template name
    $tmpdir = template_dir($tplfile);
    if ($extra) {
	$vals=unserialize_text($value);
	if (isset($vals[$extra])) {
	    $extpl = sprintf($tplname, $vals[$extra]);
	    if (file_exists("$tmpdir$extpl")) $tplfile = $extpl;
	}
    } else {
	$extra = eguide_form_options('reply_tpl_suffix');
	if ($extra) {
	    $extpl = sprintf($tplname, $extra);
	    if (file_exists("$tmpdir$extpl")) $tplfile = $extpl;
	}
    }
    $xoopsMailer->setTemplateDir($tmpdir);
    $xoopsMailer->setTemplate($tplfile);
    if ($xoopsModuleConfig['member_only'] && is_object($xoopsUser)) {
	$uinfo = sprintf("%s: %s (%s)\n", _MD_UNAME,
			 $xoopsUser->getVar('uname'),
			 $xoopsUser->getVar('name'));
	$xoopsMailer->setToUsers($xoopsUser);
    } else {
	if (!empty($email)) $xoopsMailer->setToEmails($email);
	$uinfo = "";
    }
    if ($email) $uinfo .= sprintf("%s: %s\n", _MD_EMAIL, $email);
    $rvid = $data['rvid'];
    $conf = $data['confirm'];
    $edate = eventdate($data['edate']);
    $tags = array("EVENT_URL"=>$url, "RVID"=>$rvid, "CANCEL_KEY"=>$conf,
		  "CANCEL_URL"=>EGUIDE_URL."/reserv.php?op=cancel&rvid=$rvid&key=$conf",
		  "INFO"=>$uinfo.$value, "TITLE"=>$edate." ".$data['title'],
		  "EVENT_DATE"=>$edate, "EVENT_TITLE"=>$data['title'],
		  "SUMMARY"=>strip_tags($data['summary']));
    $subj = eguide_form_options('reply_subject', _MD_SUBJECT);
    $xoopsMailer->assign($tags);
    $xoopsMailer->setSubject($subj);
    $xoopsMailer->setFromEmail($poster->getVar('email'));
    $xoopsMailer->setFromName(eguide_from_name());
    $ret = $xoopsMailer->send(); // send to order person
    if (!$ret) return $ret;

    $xoopsMailer->reset();
    $xoopsMailer->useMail();
    $xoopsMailer->setTemplateDir(template_dir($tplfile));
    $xoopsMailer->setTemplate($tplfile);
    $xoopsMailer->assign($tags);
    $xoopsMailer->setSubject($subj);
    $xoopsMailer->setFromEmail($poster->getVar('email'));
    $xoopsMailer->setFromName(eguide_from_name());
    if ($data['notify']) {
	if (!in_array($xoopsModuleConfig['notify_group'], $poster->groups())) {
	    $xoopsMailer->setToUsers($poster);
	}
	$member_handler =& xoops_gethandler('member');
	$notify_group = $member_handler->getGroup($xoopsModuleConfig['notify_group']);
	$xoopsMailer->setToGroups($notify_group);
	$xoopsMailer->send();
    }
    return $ret;
}

function disp_value($val) {
    return (empty($val) || $val=='null')?_MD_UPDATE_DEFAULT:$val;
}

if(!function_exists("file_get_contents")) {
    // have php 4.2 later
    function file_get_contents($filename) {
	$fp = fopen($filename, "rb");
	if (!$fp) return false;
	$contents = "";
	while (! feof($fp)) {
	    $contents .= fread($fp, 4096);
	}
	return $contents;
    }
}

function eguide_form_options($name='', $def=false) {
    static $options;
    if (!isset($options)) {
	$options = is_array($def)?$def:array();
	$re = '/^\s*([a-z\d_]+)\s*=(.*)$/';
	$mydir = basename(dirname(__FILE__));
	global $xoopsModule;
	if ($xoopsModule && $xoopsModule->getVar("dirname") == $mydir) {
	    $opts = $GLOBALS['xoopsModuleConfig']['label_persons'];
	} else {
	    $module_handler =& xoops_gethandler('module');
	    $module =& $module_handler->getByDirname($mydir);
	    $config_handler =& xoops_gethandler('config');
	    $configs =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    $opts = $configs['label_persons'];
	}
	if (preg_match('/^[^\n]*$/', $opts) && !preg_match($re, $opts)) {
	    $options['label_persons']=trim($opts);
	} else {
	    foreach (explode("\n", $opts) as $ln) {
		if (preg_match('/\s*#/', $ln)) continue;
		if (preg_match($re, $ln, $d)) {
		    $options[$d[1]]=trim($d[2]);
		}
	    }
	}
    }
    if (is_array($name)) {	// works set options
	foreach ($name as $k => $v) {
	    $options[$k] = $v;
	}
	return;
    }
    return $name?(isset($options[$name])?$options[$name]:$def):$options;
}

function assign_module_css() {
    global $xoopsTpl;

    $css = htmlspecialchars(eguide_form_options('module_css', HEADER_CSS));
    $header = $xoopsTpl->get_template_vars('xoops_module_header');
    if ($css && !preg_match('/'.preg_quote($css,'/').'/', $header)) {
	$header .= '<link rel="stylesheet" type="text/css" media="all" href="'.$css.'" />';
	$xoopsTpl->assign('xoops_module_header', $header);
    }
}
?>