<?php
// reservation proceedings.
// $Id: reserv.php,v 1.48 2011-08-03 14:41:22 nobu Exp $
include 'header.php';

$op = param('op', "x");
$rvid = param('rvid');
$key = param('key');
$now=time();
$nlab = eguide_form_options('label_persons');
$myts =& MyTextSanitizer::getInstance();

if ($xoopsModuleConfig['member_only']==ACCEPT_MEMBER && !is_object($xoopsUser)) {
    redirect_header(XOOPS_URL."/user.php",2,_NOPERM);
    exit;
}

$isadmin = is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'));

function reserv_permit($ruid, $euid, $confirm) {
    global $xoopsUser, $xoopsModule, $isadmin, $xoopsModuleConfig;
    if (!is_object($xoopsUser)) {
	if ($confirm==param('key')) return true;
	if ($xoopsModuleConfig['member_only']==ACCEPT_MEMBER) return false;
	return true;
    }
    // administrator has permit
    if ($isadmin) return true;
    $uid = $xoopsUser->getVar('uid');
    // reservation person
    if ($uid==$ruid && $confirm==param('key')) return true;
    // event poster
    if ($uid==$euid) return true;
    return false;
}

switch ($op) {
case 'delete':
    $result = $xoopsDB->query('SELECT email,r.eid,r.exid,r.status,e.uid,r.uid ruid, info, confirm, optfield, cdate, counter, style, persons, IF(exdate,exdate,edate) edate, notify, title, closetime,IF(x.reserved IS NULL,o.reserved,x.reserved) reserved FROM '.RVTBL.' r LEFT JOIN '.EGTBL.' e ON r.eid=e.eid LEFT JOIN '.OPTBL.' o ON r.eid=o.eid LEFT JOIN '.EXTBL." x ON r.exid=x.exid WHERE rvid=$rvid");
    if (!$result || $xoopsDB->getRowsNum($result)==0) {
	$result = false;
    } else {		// there is reservation
	$data = $xoopsDB->fetchArray($result);
	$evurl = EGUIDE_URL.($data['eid']?'/event.php?eid='.$data['eid'].($data['exid']?'&sub='.$data['exid']:''):'/index.php');

	if (!reserv_permit($data['ruid'], $data['uid'], $data['confirm'])) {
	    redirect_header($evurl, 3, _MD_RESERV_NOTFOUND);
	    exit;
	}
    }
    if ($result) {
	$vals = unserialize_text($data['info']);
	$num = 1;
	if (isset($vals[$nlab])) {
	    $num = intval($vals[$nlab]);
	    if ($num<1) $num = 1;
	}
	if ($isadmin || empty($data['edate']) || $data['edate']-$data['closetime']>$now) {
	    $eid = $data['eid'];
	    if ($eid) edit_eventdata($data);
	    $exid = $data['exid'];
	    if ($isadmin || (is_object($xoopsUser) &&
			     $data['ruid']==$xoopsUser->getVar('uid'))) {
		$conf = "";
	    } else {
		$conf = "AND confirm=".intval($_POST['key']);
	    }
	    $result = $xoopsDB->query('DELETE FROM '.RVTBL." WHERE rvid=$rvid $conf");
	} else {
	    $result = false;
	}
    } else {
	redirect_header(EGUIDE_URL.'/index.php', 3, _MD_RESERV_NOTFOUND);
	exit;
    }
    if ($result) {
	$evurl = EGUIDE_URL.($eid?"/event.php?eid=$eid".($exid?"&sub=$exid":""):"/index.php");
	if ($data['status']!=_RVSTAT_REFUSED) {
	    if ($exid) {
		$xoopsDB->query('UPDATE '.EXTBL." SET reserved=reserved-$num WHERE exid=$exid");
	    } else {
		$xoopsDB->query('UPDATE '.OPTBL." SET reserved=reserved-$num WHERE eid=$eid");
	    }
	    if ($xoopsModuleConfig['use_plugins']) {
		include_once 'plugins.php';
		if (isset($hooked_function['cancel'])) {
		    foreach ($hooked_function['cancel'] as $func) {
			if (!$func($eid, $exid, $data['ruid'], $data['uid'])) {
			    echo "Cancel failed";
			}
		    }
		}
	    }
	    if ($data['notify']) {
		$poster = new XoopsUser($data['uid']);
		$title = eventdate($data['edate'])." ".$data['title'];
		$email = $data['email'];

		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();

		if ($xoopsModuleConfig['member_only'] && $data['ruid']) {
		    $user = new XoopsUser($data['ruid']);
		    $uinfo = sprintf("%s: %s (%s)\n", _MD_UNAME,
				     $user->getVar('uname'),
				     $user->getVar('name'));
		    $xoopsMailer->setToUsers($user);
		} else {
		    $uinfo = "";
		} 
		if ($email) $uinfo .= sprintf("%s: %s\n", _MD_EMAIL, $email);
		if (is_object($xoopsUser)) {
		    $xoopsMailer->assign("REQ_UNAME", $xoopsUser->getVar('uname'));
		    $xoopsMailer->assign("REQ_NAME", $xoopsUser->getVar('name'));
		} else {
		    $xoopsMailer->assign("REQ_UNAME", '*anonymous*');
		    $xoopsMailer->assign("REQ_NAME", $xoopsConfig['anonymous']);
		}
		$tags = array("TITLE"=>"{EVENT_DATE} {EVENT_TITLE}",
			      "EVENT_DATE"=>eventdate($data['edate']),
			      "EVENT_TITLE" => $data['title'],
			      "EVENT_URL"=>$evurl,
			      "RVID"=>$rvid,
			      "INFO"=>$uinfo.$data['info'],
			      );
		$xoopsMailer->assign($tags);
		$xoopsMailer->setSubject(_MD_CANCEL_SUBJ);
		$tpl = 'cancel.tpl';
		$xoopsMailer->setTemplateDir(template_dir($tpl));
		$xoopsMailer->setTemplate($tpl);
		if ($email) $xoopsMailer->setToEmails($email);
		$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
		$xoopsMailer->setFromName(eguide_from_name());
		if (!in_array($xoopsModuleConfig['notify_group'], $poster->groups())) {
		    $xoopsMailer->setToUsers($poster);
		}
		$member_handler =& xoops_gethandler('member');
		if ($xoopsModuleConfig['notify']) {
		    $notify_group = $member_handler->getGroup($xoopsModuleConfig['notify_group']);
		    $xoopsMailer->setToGroups($notify_group);
		}
		$xoopsMailer->send();
	    }
	}
	if (empty($_POST['back'])) {
	    $back = $evurl;
	} else {
	    $back = $myts->makeTboxData4Edit(trim($_POST['back']));
	}
	redirect_header($back,3,_MD_RESERV_CANCELED);
    } else {
	redirect_header($back,5,_MD_CANCEL_FAIL);
    }
    exit;

case 'notify':
    $email = param('email', '');
    if (preg_match('/^[\w\-_\.]+@[\w\-_\.]+$/', $email)) {
	$ml = $xoopsDB->quoteString(strtolower($email));
	$reg = $xoopsDB->query('SELECT rvid FROM '.RVTBL." WHERE email=$ml AND eid=0");
	if ($xoopsDB->getRowsNum($reg)==0) {
	    $conf = rand(10000,99999);
	    $uid = $xoopsUser?$xoopsUser->getVar('uid'):"NULL";
	    $xoopsDB->query('INSERT INTO '.RVTBL.
			    "(eid,uid,rdate,email,status,confirm) VALUES (0,$uid,$now,$ml,1,'$conf')");
	    $msg = _MD_REGISTERED;
	} else {
	    $msg = _MD_DUP_REGISTER;
	}
    } else {
	$msg = _MD_MAIL_ERR;
    }
    redirect_header(EGUIDE_URL."/index.php",5,$msg);
    exit;

case 'register':
    if (empty($xoopsModuleConfig['user_notify'])) {
	redirect_header($_SERVER['HTTP_REFERER'],2,_NOPERM);
	exit;
    }
}

include 'reserv_func.php';
include(XOOPS_ROOT_PATH."/header.php");

assign_module_css();
$eid = param('eid');
$exid = param('sub');
$errs = array();

switch($op) {
case 'order':
    $data = fetch_event($eid, $exid);
    $vals = get_opt_values($data['optfield'], $errs, false, false);
    check_prev_order($data, $vals, $errs);
    $value = serialize_text($vals);
    if ($xoopsModuleConfig['member_only']!=ACCEPT_MEMBER) {
	$email = param('email', '');
    } else {
	$email = '';
    }

    if (empty($errs)) {
	$accept = $data['autoaccept'];
	$strict = $data['strict'];
	$persons = $data['persons'];
	$num = 1;
	if ($nlab && isset($vals[$nlab])) {
	    $num =  intval($vals[$nlab]);
	    if ($num<1) $num = 1;
	}
	if (!count_reserved($eid, $exid, $strict, $persons, $num)) {
	    $a = '/^https?:'.preg_quote(preg_replace('/^https?:/','', XOOPS_URL), '/').'/';
	    // NOTE: Reservation failer in race others,
	    //     in other case not send referer. (counter by XSS)
	    $errs[] = preg_match($a,$_SERVER['HTTP_REFERER'])?_MD_RESERV_FULL:'REFERER '._ERRORS;
	}

	// plugin reserved
	if (empty($errs) && $xoopsModuleConfig['use_plugins']) {
	    include_once 'plugins.php';
	    foreach ($hooked_function['reserve'] as $func) {
		if (!$func($eid, $exid, $data['edate'], $data['uid'])) {
		    $msg = $xoopsTpl->get_template_vars('message');
		    $errs[] = empty($msg)?_MD_RESERV_PLUGIN_FAIL:$msg;
		    count_reserved($eid, $exid, $strict, $persons, -$num);
		    break;
		}
	    }
	}
    }

    if (empty($errs)) {
	srand();
	$data['confirm'] = $conf = rand(10000,99999);
	$uid = 'NULL';
	if (is_object($xoopsUser)) {
	    if (empty($ml) || strtolower($xoopsUser->getVar('email'))==$ml) {
		$uid = $xoopsUser->getVar('uid');
	    }
	}
	$ml = $xoopsDB->quoteString($email);
	$accept = $data['autoaccept'];
	$xoopsDB->query('INSERT INTO '.RVTBL."
	(eid, exid, uid, rdate, email, info, status, confirm)
VALUES ($eid,$exid,$uid,$now,$ml, ".$xoopsDB->quoteString($value).",$accept,'$conf')");
	$data['rvid'] = $rvid = $xoopsDB->getInsertId();
	$evurl = EGUIDE_URL."/event.php?eid=$eid".($exid?"&sub=$exid":"");
	if (order_notify($data, $email, $value)) {
	    $url = eguide_form_options('redirect', '');
	    if (!empty($url)) {
		$sec = 3;
		if (preg_match('/^(\d+);/', $url, $d)) {
		    $sec = $d[1];
		    $url = preg_replace('/^(\d+);\s*/', '', $url);
		}
		$url = str_replace(array('{X_EID}', '{X_SUB}', '{X_RVID}'),
				   array($eid, $exid, $rvid), $url);
		$xoopsTpl->assign('xoops_module_header', sprintf('<meta http-equiv="Refresh" content="%u; url=%s" />', $sec, htmlspecialchars($url)));
		assign_module_css();
	    }
	    echo "<div class='evform'>\n";
	    echo "<p><a href='$evurl' class='evhead'>".eventdate($data['edate'])." &nbsp; ".htmlspecialchars($data['title'])."</a></p>";
	    echo "<h3>"._MD_RESERVATION."</h3>\n";
	    echo "<p><b>"._MD_RESERV_ACCEPT."</b></p>";
	    if ($value) {
		echo "<h3>"._MD_RESERV_CONF."</h3>";
		echo "<blockquote class='evbody'>".$myts->displayTarea($value)."</blockquote>";
	    }
	    if ($url) echo "<p>".sprintf(_IFNOTRELOAD, $url)."</p>";
	    //
	    // register user notify request
	    //
	    if ($xoopsModuleConfig['user_notify'] && param('notify', '')) {
		$reg = $xoopsDB->query('SELECT * FROM '.RVTBL." WHERE email=$ml AND eid=0");
		if ($xoopsDB->getRowsNum($reg)==0) {
		    $conf = rand(10000,99999);
		    $xoopsDB->query('INSERT INTO '.RVTBL." 
(eid,exid,uid,rdate,email,status,confirm) VALUES (0,0,$uid,$now,$ml,1,'$conf')");
		} else {
		    echo "<div class='evnote'>"._MD_DUP_REGISTER."</div>\n";
		}
	    }
	    echo "</div>\n";
	} else {
	    echo "<div class='error'>"._MD_SEND_ERR."</div>\n";
	    // delete failer record.
	    $xoopsDB->query('DELETE FROM '.RVTBL." WHERE rvid=$rvid");
	    count_reserved($eid, $exid, $strict, $persons, -$num);
	}
    }
    if (empty($errs)) break;

case 'confirm':
    $xoopsOption['template_main'] = EGPREFIX.'_confirm.html';

    $data = fetch_event($eid, $exid);
    $opts = $data['optfield'];
    if ($op != 'order') {
	$vals = get_opt_values($opts, $errs);
	check_prev_order($data, $vals, $errs);
    }

    $emhide = "";
    $num = 1;
    if (isset($_POST['email'])) {
	$email = $myts->makeTboxData4Edit($_POST['email']);
	$vals=array_merge(array(_MD_EMAIL=>$email), $vals);
	$emhide = "<input type='hidden' name='email' value='$email'/>\n";
	if (isset($_POST['email_conf'])) {
	    $emhide .= "<input type='hidden' name='email_conf' value='".$myts->makeTboxData4Edit($_POST['email_conf'])."'/>\n";
	}
	if (!empty($_POST['notify'])) {
	    $emhide .= "<input type='hidden' name='notify' value='".
		$myts->makeTboxData4Edit($_POST['notify'])."'/>\n";
	}
    }

    $xoopsTpl->assign('event', edit_eventdata($data));

    $xoopsTpl->assign('errors', $errs);
    $items = array();
    foreach ($vals as $k=>$v) {
	$items[] = array('label'=>$k, 'value'=>$v);
    }
    $xoopsTpl->assign('items', $items);
    $form = "";
    if (!$errs) {
	$n = 0;
	$xoopsTpl->assign('submit',
	     "<form action='reserv.php?op=order' method='post'>".
	     "<input type='hidden' name='eid' value='$eid'/>\n".
	     $emhide.join("\n", get_opt_values($opts, $errs, true)).
	     "\n<input type='submit' value='"._MD_ORDER_SEND."'/>\n".
	     ($exid?"<input type='hidden' name='sub' value='$exid'/>\n":"").
	     "</form>");
    }
    $xoopsTpl->assign('cancel', "<form action='event.php?eid=$eid".
		      ($exid?'&sub='.$exid:''). "#form' method='post'>".$emhide.
		      join("\n", get_opt_values($opts, $errs, true)).
		      "\n<input type='submit' value='"._MD_BACK."'/>\n".
		      "</form>\n");
    break;

case 'cancel':
    $result = $xoopsDB->query('SELECT eid,exid,uid,confirm,email,info FROM '.RVTBL.' WHERE rvid='.$rvid);
    if ($result) {
	if ($xoopsDB->getRowsNum($result)) {
	    list($eid, $exid, $ruid, $conf, $email, $info) = $xoopsDB->fetchRow($result);
	} else $result = false;
    }
    if (!$result || $xoopsDB->getRowsNum($result)==0) {
	$result = false;
    } else {		// there is reservation
	$data = fetch_event($eid, $exid);
	$evurl = EGUIDE_URL.'/event.php?eid='.$data['eid'].($data['exid']?'&sub='.$data['exid']:'');
	if (!reserv_permit($ruid, $data['uid'], $conf)) {
	    redirect_header($evurl,5,_MD_CANCEL_FAIL);
	    exit;
	}
	$data['confirm'] = $conf;
	$data['ruid'] = $ruid;
	$data['email'] = $email;
    }
    if ($result) {
	if (!$isadmin && isset($date['edate']) && $data['edate']-$data['closetime']<$now) {
	    echo "<div class='evform'>\n";
	    echo "<div class='error'>"._MD_RESERV_NOCANCEL."</div>\n";
	    echo "</div>\n";
	} else {
	    $eid = $data['eid'];
	    $key = isset($_GET['key'])?intval($_GET['key']):'';
	    if ($eid) edit_eventdata($data);
	    $xoopsOption['template_main'] = EGPREFIX.'_confirm.html';
	    $xoopsTpl->assign('event', $data);
	    if (isset($_GET['back'])) {
		$back =  $myts->stripSlashesGPC($_GET['back']);
	    } else {
		$back = isset($_SERVER['HTTP_REFERER'])?$myts->makeTboxData4Edit($_SERVER['HTTP_REFERER']):'';
	    }
	    $form = "<h3>"._MD_RESERV_CANCEL."</h3>\n".
		"<form action='reserv.php' method='post'>\n".
		"<input type='hidden' name='op' value='delete' />\n".
		"<input type='hidden' name='eid' value='".$data['eid'].
		"' />\n<input type='hidden' name='key' value='$key' />\n".
		"<input type='hidden' name='back' value='$back' />\n".
		"<input type='hidden' name='rvid' value='$rvid' />\n".
		"<input type='submit' value='"._SUBMIT."' />\n</form>\n";
	    $xoopsTpl->assign('submit', $form);
	    $values = array();
	    if ($email) $values[_MD_EMAIL]=$email;
	    if ($ruid) $values[_MD_UNAME]=XoopsUser::getUnameFromId($ruid);
	    $values = array_merge($values, unserialize_text($info));
	    $xoopsTpl->assign('values', $values);
	}
    } else {
	echo "<div class='evform'>\n";
	echo "<div class='error'>"._MD_RESERV_NOTFOUND."</div>";
	echo "</div>\n";
    }
    break;

case 'register':
    $email = ($xoopsUser)?$xoopsUser->getVar('email'):"";
    echo "<h2>"._MD_NOTIFY_EVENT."</h2>\n";
    echo "<form action='reserv.php' method='post'>
<table class='evtbl' align='center'>\n";
    echo "<tr><th>"._MD_EMAIL."*</th><td><input size='40' name='email' value='$email'/> <input type='submit' value='"._REGISTER."'></td></tr>\n";
    echo "</table>\n";
    echo "<p align='center'>"._MD_NOTIFY_REQUEST."</p>";
    echo "<input type='hidden' name='op' value='notify' />\n</form>\n";
    break;
}

include(XOOPS_ROOT_PATH."/footer.php");
?>