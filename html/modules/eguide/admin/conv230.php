<?php
// convert text serialize before 2.30
// $Id: conv230.php,v 1.1 2007-07-18 04:53:43 nobu Exp $

include "admin_header.php";

// note: search text fields special string as ": \"+"\n"
$res = $xoopsDB->query("SELECT rvid,eid,info FROM ".RVTBL." WHERE info LIKE ".$xoopsDB->quoteString("%: \\\\\n%"));

$count = $xoopsDB->getRowsNum($res);

if (isset($_POST['convert'])) {
    if ($count) {
	$opts = array();
	while (list($rvid, $eid, $info) = $xoopsDB->fetchRow($res)) {
	    if (!isset($opts[$eid])) {
		$ost = $xoopsDB->query("SELECT optfield FROM ".OPTBL." WHERE eid=".$eid);
		list($opts[$eid]) = $xoopsDB->fetchRow($ost);
	    }
	    $item = $opts[$eid];
	    $info = serialize_text(explodeinfo($info, $item));
	    $xoopsDB->query("UPDATE ".RVTBL." SET info=".$xoopsDB->quoteString($info)." WHERE rvid=".$rvid);
	}
    }
    redirect_header('index.php', 1, _AM_DBUPDATED);
    exit;
}

xoops_cp_header();

echo "<h2>Convert Format before eguide 2.30</h2>";
echo "<div>"._AM_COUNT.": $count</div>";
if ($count) {
    echo "<form method='post'><input type='submit' name='convert'/></form>";
}

xoops_cp_footer();

// exploding addional informations.
// older CSV serialize
function explodeinfo($info, $item) {
    if (!is_array($item)) $item = explodeopts($item);
    $ln = explode("\n", preg_replace('/\r/','',$info));
    $n = 0;
    $result = array();
    while ($a = array_shift($ln)) {
	$lab = $item[$n];
	if (preg_match("/^".str_replace("/", '\/', quotemeta($lab)).": (.*)$/", $a, $m)) {
	    $v = isset($m[1])?$m[1]:"";
	    if ($m[1] == "\\") {
		$v = "";
		$x = "/^".(isset($item[$n+1])?quotemeta($item[$n+1]):"\n").": /";
		while (count($ln) && !preg_match($x, $ln[0])) {
		    $a=array_shift($ln);
		    $v .= $v?"\n$a":$a;
		}
	    }
	    $result[$lab] = "$v";
	} else {
	    global $xoopsConfig;
	    if (isset($xoopsConfig['debug']) && $xoopsConfig['debug']) {
		echo "<span class='error'>".$item[$n].",$a</span>";
	    }
	    break;
	}
	$n++;
    }
    return $result;
}

?>
