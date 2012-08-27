<?php
// event guide daily limitation plugins
// $Id: dlimit.php,v 1.4 2010-02-20 03:02:15 nobu Exp $

/*
 * dlimit plugins feature
 *   - Limitation reservation per 1day.
 *     (default max_register_in_day=1)
 *   - Limitation reservation in future.
 *     (default max_register_in_future=0 as unlimit)
 */

/* PLUGIN GENERAL SPECS
     filename ::= basename + '.php'

   hooked funcitons (
     check   ... when reservation form display
     reserve ... when reservation sending
     cancel  ... when reservation canceled

   function results
     true: can reservation
     false: cann't reservation

   side effect (typicaly)
     assign template vars 'message' when false results.

   function name as:
     func_name ::= 'eguide_' + basename + '_' + (hooked-function-name)

 */

// plugin local function (share check and reservation)
function eguide_dlimit_condition($eid, $exid) {
    global $xoopsDB,$xoopsUser, $xoopsConfig;

    // check reservation count
    $uid = $xoopsUser->getVar('uid');
    $res = $xoopsDB->query("SELECT IF(exdate, exdate, edate) edate FROM ".EGTBL." LEFT JOIN ".EXTBL." ON eid=eidref AND exid=$exid WHERE eid=$eid");
    list($edate) = $xoopsDB->fetchRow($res);
    // start of day calc in default time zone
    list($y, $m, $d) = explode('-', eventdate($edate, 'Y-m-d', $xoopsConfig['default_TZ']));
    $bound = eguide_form_options('bound_time', '00:00');
    list($hour, $min) = explode(':', $bound);
    $start = userTimeToServerTime(mktime($hour,$min,0, $m, $d, $y), $xoopsConfig['default_TZ']);
    $last = $start + 24*3600-1;	/* +1day */
    $res = $xoopsDB->query("SELECT count(rvid) FROM ".RVTBL." r LEFT JOIN ".EGTBL." e ON r.eid=e.eid LEFT JOIN ".EXTBL." x ON r.eid=x.eidref AND x.exid=r.exid WHERE r.uid=$uid AND IF(exdate, exdate, edate) BETWEEN $start AND $last");
    list($count) = $xoopsDB->fetchRow($res);
    return $count;
}

function eguide_dlimit_rsvcount($eid, $exid) {
    global $xoopsDB, $xoopsUser;
    $now = time();
    $uid = $xoopsUser->getVar('uid');
    $res = $xoopsDB->query("SELECT count(rvid) FROM ".RVTBL." r LEFT JOIN ".EGTBL." e ON r.eid=e.eid LEFT JOIN ".EXTBL." x ON r.eid=x.eidref AND x.exid=r.exid WHERE r.uid=$uid AND IF(exdate, exdate, edate) > $now");
    list($count) = $xoopsDB->fetchRow($res);
    return $count;
}

// pre check amount enough
function eguide_dlimit_check($eid, $exid, $poster) {
    global $xoopsUser, $xoopsModule, $xoopsTpl;

    $tpl = is_object($xoopsTpl);
    if(!is_object($xoopsUser)) { // need login in this plugin
	if ($tpl) $xoopsTpl->assign('message', _MD_RESERV_NEEDLOGIN);
	return false;
    }
    // need points for order
    $limit = eguide_form_options('max_register_in_day', 1);
    $nrec = eguide_dlimit_condition($eid, $exid);
    if ($limit==0 || $nrec < $limit) {
	// check more condition
	$rmax = eguide_form_options('max_register_in_future', 0);
	if ($rmax==0) return true;
	if (eguide_dlimit_rsvcount($eid, $exid) < $rmax) return true;
	if ($tpl) $xoopsTpl->assign('message', sprintf(_PI_EGUIDE_DLIMIT_FULL_OF_FUTURE, $rmax));
    } else {
	if ($tpl) $xoopsTpl->assign('message', sprintf(_PI_EGUIDE_DLIMIT_FULL_OF_DAY, $limit));
    }
    return false;
}

// check also reserve action
function eguide_dlimit_reserve($eid, $exid, $date, $poster) {
    return eguide_dlimit_check($eid, $exid, $poster);
}

// cancel reserved points
/* don't care in this method
function eguide_dlimit_cancel($eid, $exid, $uid, $poster) {
}
*/
