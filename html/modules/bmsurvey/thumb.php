<?php
/***************************************************************************
                            thumb.php  -  description
                           ---------------------------
    begin                : Wed Apr 21 2004
    copyleft             : (C) 2004 Bluemoon inc.
    home page            : http://www.bluemooninc.biz/
    auther               : Yoshi.Sakai
    email                : webmaster@bluemooninc.biz
    Memo                 : This is Thumbsnail function.
                         : It need to set the GD libraly option on PHP. (php.ini)
    Original source from : http://php.s3.to/ (Let's PHP!)

    $Id: thumb.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
function thumb_create($src, $W, $H, $thumb_dir="./"){
	global $BlogCNF;					// By Yoshi.S
	
  // Get witdh,Height and type
  $size = GetImageSize($src);
  switch ($size[2]) {
    case 1 : $im_in = @ImageCreateFromGif($src); break;
    case 2 : $im_in = @ImageCreateFromJPEG($src); break;
    case 3 : $im_in = @ImageCreateFromPNG($src);  break;
  }
  if (!$im_in) die(_NW_NOGDLIB);	// By Yoshi.S
  // Resize
  if ($size[0] > $W || $size[1] > $H) {
    $key_w = $W / $size[0];
    $key_h = $H / $size[1];
    ($key_w < $key_h) ? $keys = $key_w : $keys = $key_h;
    $out_w = $size[0] * $keys;
    $out_h = $size[1] * $keys;
  } else {
    $out_w = $size[0];
    $out_h = $size[1];
  }
  if ($BlogCNF['gd_ver'] == 2){
	  // Make thumbsnail image from original (for GD2.0)
	  $im_out = ImageCreateTrueColor($out_w, $out_h);
	  $resize = ImageCopyResampled($im_out, $im_in, 0, 0, 0, 0, $out_w, $out_h, $size[0], $size[1]);
	} else {
	  // (for under GD2.0)
	  $im_out = ImageCreate($out_w, $out_h);
	  ImageCopyResized($im_out, $im_in, 0, 0, 0, 0, $out_w, $out_h, $size[0], $size[1]);
	}
  // Oputput thumbsnail to folder
  $filename = substr($src, strrpos($src,"/")+1);
  $filename = substr($filename, 0, strrpos($filename,"."));
  ImageJPEG($im_out, $thumb_dir.$filename.".jpg");
  //ImagePNG($im_out, $thumb_dir.$filename.".png");
  // Delete images
  ImageDestroy($im_in);
  ImageDestroy($im_out);
  return $filename.".jpg";
}
?>