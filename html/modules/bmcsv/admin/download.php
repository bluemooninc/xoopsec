<?php
/***************************************************************************
                           download.php  -  description
                           ----------------------------
    begin                : Wed Apr 21 2004
    copyleft             : (C) 2004 - 2007 Bluemoon inc.
    home page            : http://www.bluemooninc.jp/
    auther               : Yoshi Sakai
    email                : webmaster@bluemooninc.jp
    Special Thanks to    : Nat Sakimura,funran7

    $Id: download.php,v 0.92 2008/04/10 11:45:36 yoshis Exp $

 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
ini_set("memory_limit","20M");
include '../../../include/cp_header.php';
include '../include/ext2mime.php';		// Load the decode array of extension to MIME
include 'export.ini.php';

if (!is_object($xoopsUser) && !$xoopsUser->isAdmin()){
	xoops_cp_header();
	redirect_header(XOOPS_URL,2,"User permission error");
	exit();
}
$fpathname = htmlspecialchars ( rawurldecode($_GET['url']) , ENT_QUOTES );
$dl_filename = $fpathname;
if ( defined('XOOPS_TRUST_PATH')) {
	$export_dir = XOOPS_TRUST_PATH . '/cache/';
}else{
	$export_dir = XOOPS_ROOT_PATH . '/cache/';
}
$fpathname = $export_dir.$fpathname;
ob_clean();
if(!file_exists($fpathname)){
	if(file_exists($fpathname.".log")){
		echo "<B>Already downloaded by </B>";
		$fp=fopen($fpathname.".log",'r');
		while(!feof($fp)) {
			$line = fgets($fp);
			echo $line."<BR />";
		}
		fclose($fp);
		exit();
	}
	print("Error - $fpathname does not exist.");
	return ;
}
$browser = $version =0;
UsrBrowserAgent($browser,$version);
@ignore_user_abort();
@set_time_limit(0);
$fnamedotpos = strrpos($dl_filename,'.');
$fext = substr($dl_filename,$fnamedotpos+1);
$ctype = isset($ext2mime[$fext]) ? $ext2mime[$fext] : "application/octet-stream-dummy" ;
if ($fext=="gz") $content_encoding = 'x-gzip';
//echo $fext.$ctype; exit();
if ($browser == 'IE' && (ini_get('zlib.output_compression')) ) {
    ini_set('zlib.output_compression', 'Off');
}
//if (!empty($content_encoding)) {
//    header('Content-Encoding: ' . $content_encoding);
//}
if (!empty($content_encoding)) {
    header('Content-Encoding: ' . $content_encoding);
}
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($fpathname) );
header("Content-type: " . $ctype);
header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Last-Modified: ' . date("D M j G:i:s T Y"));
header('Content-Disposition: attachment; filename="' . $dl_filename . '"');
//header("Content-Disposition: inline; filename=" . $dl_filename);
header("x-extension: " . $ctype );

if ($browser == 'IE') {
    header('Pragma: public');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
} else {
    header('Pragma: no-cache');
}

$fp=fopen($fpathname,'r');
while(!feof($fp)) {
	$buffer = fread($fp, 1024*6); //speed-limit 64kb/s
	print $buffer;
	flush();
	ob_flush();
	usleep(10000); 
}
fclose($fp);
//
// Save download log
//
if ($xoopsUser) $uname = $xoopsUser->getVar('uname'); else $uname = "Anonymous";
$str = $uname.",".date("Y-m-d H:i:s", time());
$postlog = $fpathname.'.log';
$fp = fopen($postlog, 'a');
fwrite($fp, $str."\n");
fclose($fp);
unlink($fpathname);
//xoops_cp_footer();
//
// Check User Browser
//
function UsrBrowserAgent(&$browser,&$version) {
    if (preg_match('@Opera(/| )([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'], $log_version)) {
        $version= $log_version[2];
        $browser='OPERA';
    } elseif (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'], $log_version)) {
        $version= $log_version[1];
        $browser='IE';
    } elseif (preg_match('@OmniWeb/([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'], $log_version)) {
        $version= $log_version[1];
        $browser='OMNIWEB';
    } elseif (preg_match('@(Konqueror/)(.*)(;)@', $_SERVER['HTTP_USER_AGENT'], $log_version)) {
        $version= $log_version[2];
        $browser='KONQUEROR';
    } elseif (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'], $log_version)
               && preg_match('@Safari/([0-9]*)@', $_SERVER['HTTP_USER_AGENT'], $log_version2)) {
        $version= $log_version[1] . '.' . $log_version2[1];
        $browser='SAFARI';
    } elseif (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'], $log_version)) {
        $version= $log_version[1];
        $browser='MOZILLA';
    } else {
        $version= 0;
        $browser='OTHER';
    }
    return $browser;
}
?>
