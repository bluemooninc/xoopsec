<?php
/***************************************************************************
                           download.php  -  description
                           ----------------------------
    begin                : Wed Apr 21 2004
    copyleft             : (C) 2004,2005 Bluemoon inc.
    home page            : http://www.bluemooninc.biz/
    auther               : Y.Sakai
    email                : webmaster@bluemooninc.biz
    Special Thanks to    : Nat Sakimura,funran7

    $Id: download.php,v 0.85 2008/04/10 11:47:36 yoshis Exp $

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
include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
include './admin/phpESP.ini.php';
if (!is_object($xoopsUser) && GUEST_DOWNLOAD==0){
	redirect_header(XOOPS_URL."/user.php",2,_FILEUP_ERROR);
	exit();
}
$filename = cnv_mbstr(htmlspecialchars ( rawurldecode($_GET['url']) , ENT_QUOTES ));
$a = strpos($filename,'_');
$b = strrpos($filename,'/');
$c = strrpos($filename,'.');
$dl_filename = substr($filename,$a+1,$c-$a-1);
$filename = XOOPS_ROOT_PATH.$FMXCONFIG['attach_path'].substr($filename,$b+1);
if(!file_exists($filename)){
	print("Error - $filename does not exist.");
	return ;
}
$size = filesize($filename);
// Modified by Nat Sakimura
$fname = cnv_mbstr($dl_filename);
$fnamedotpos = strrpos($fname,'.');
$fext = substr($fname,$fnamedotpos+1);
switch(strtolower($fext)) {
	case "pdf":
		$ctype = "application/pdf";
		break;
	case "doc":
		$ctype = "application/msword";
		break;
	case "xls":
		$ctype = "application/excel";
		break;
	case "ppt":
		$ctype = "application/powerpoint";
		break;
	case "jpg":
		$ctype = "image/jpeg";
		break;
	case "txt":
		$ctype = "text/plain";
		break;
	case "csv":
		$ctype = "text/plain";
		break;
	default:
		$ctype = "application/octet-stream-dummy";
		break;
}
ob_clean();
@ignore_user_abort();
@set_time_limit(0);
// till here
header("Cache-Control: public");
header("Content-length: " . $size);

//header("Content-disposition: inline; filename=".cnv_mbstr($dl_filename));
header("Content-disposition: inline;" . cnv_mbstr_httpfn($dl_filename));

// Modified by Nat Sakimura
header("Content-type: " . $ctype);
header("Pragma: private");
header("Cache-Control: public");
header("Content-Transfer-Encoding: binary");
header("x-extension: " . $ctype );
$fp=fopen(cnv_mbstr($filename),'r');
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
$postlog = $filename.'.log';
$fp = fopen($postlog, 'a');
fwrite($fp, $str."\n");
fclose($fp);
//
// Convert for Multi-byte Strings
/*
function cnv_mbstr($str) {
	if (extension_loaded('mbstring')){
		return  mb_convert_encoding($str,SAVE_AS_MBSTR,"auto");
	} else {
		return $str;
	}
}
*/
// for Content-disposition by funran7
//
function cnv_mbstr_httpfn($str) {
	if (extension_loaded('mbstring')){
		if (mb_detect_encoding($str,"ASCII,UTF-8,EUC-JP,SJIS")!="ASCII"){
			if (preg_match("/Firefox|Netscape\/8/",$_SERVER['HTTP_USER_AGENT'])){
		        $fn = "filename*=ISO-2022-JP''" .  rawurlencode(mb_convert_encoding($str,"ISO-2022-JP","auto"));
		    } elseif (preg_match("/MSIE 6/",$_SERVER['HTTP_USER_AGENT'])){
		        $fn = "filename=" . mb_convert_encoding($str,"SJIS","auto");
		    } elseif (preg_match("/Opera\/8/",$_SERVER['HTTP_USER_AGENT'])){
		        $fn = "filename=" . mb_convert_encoding($str,"UTF-8","auto");
		    } else {
		    	// CFNetwork=Safari, Mozilla=IE5.2:Mac
				$fn = "filename=" . $_SERVER['HTTP_USER_AGENT'];
		    }
		} else {
			$fn = "filename=$str";
		}
    } else {
		$fn = "filename=$str";
    }
    return $fn;
}
?>
