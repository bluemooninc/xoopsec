<?php
# resolv dirname base naming
# $Id: mydirname.php,v 1.2 2008-02-11 02:55:02 nobu Exp $

global $egdirname, $myprefix;
$mydirpath = dirname(__FILE__);
$myprefix = $egdirname = basename($mydirpath);
if (preg_match('/^[^a-zA-Z0-9_]+$/', $egdirname)) die("Dirname not accept: $egdirname");
$mypostfix = preg_replace('/.*[^\d](\d*)$/', '$1', $egdirname);
if (!file_exists("$mydirpath/templates/{$myprefix}_index.html")) {
    $myprefix = 'eguide'.$mypostfix;	// using 'eguide' + number;
    if (!file_exists("$mydirpath/templates/{$myprefix}_index.html")) die("eguide configure error: $egdirname");
}
?>