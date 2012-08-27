<?php
/*
** file upload by Y.Sakai @ bluemooninc.biz  2004/3/14
*/
class fileup {
  var $gd_ver = 2;
  var $thumb_dir = "/uploads/";
  var $thumb_ext = array("bmp","png","gif","jpeg","jpg");
  var $im_in;
  function fileup(){
  	
  }	
  function getimagetype($data){
    if (strncmp("\x00\x00\x01\x00", $data, 4) == 0) {
        // ICO
        return "ico";
    } else if (strncmp("\x89PNG\x0d\x0a\x1a\x0a", $data, 8) == 0) {
        // PNG
        return "png";
    } else if (strncmp('BM', $data, 2) == 0) {
        // BMP
        return "bmp";
    } else if (strncmp('GIF87a', $data, 6) == 0 || strncmp('GIF89a', $data, 6) == 0) {
        // GIF
        return "gif";
    } else if (strncmp("\xff\xd8", $data, 2) == 0) {
        // JPEG
        return "jpg";
    } else {
        return false;
    }
  }
  function getImageSize($src){
    // Get witdh,Height and type
	$size = GetImageSize($src);
	switch ($size[2]) {
  		case 1 : $this->im_in = @ImageCreateFromGif($src); break;
  		case 2 : $this->im_in = @ImageCreateFromJPEG($src); break;
  		case 3 : $this->im_in = @ImageCreateFromPNG($src);  break;
  	}
  	if (!$this->im_in){ echo "Error!"._NW_NOGDLIB; die(_NW_NOGDLIB); }
  	return $size;
  }
  function thumb_create($src, $W, $H, $thumb_dir="./"){
	
	$size = $this->getImageSize($src);
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
	
  	if ($this->gd_ver == 2){
		// Make thumbsnail image from original (for GD2.0)
		$im_out = ImageCreateTrueColor($out_w, $out_h);
		$resize = ImageCopyResampled($im_out, $this->im_in, 0, 0, 0, 0, $out_w, $out_h, $size[0], $size[1]);
	} else {
		// (for under GD2.0)
		$im_out = ImageCreate($out_w, $out_h);
		ImageCopyResized($im_out, $this->im_in, 0, 0, 0, 0, $out_w, $out_h, $size[0], $size[1]);
	}
	// Oputput thumbsnail to folder
	$filename = substr($src, strrpos($src,"/")+1);
	//if ($size[2]!=2){
		$filename = substr($filename, 0, strrpos($filename,"."));
		$filename = $filename.".gif";
	//}
	
	touch($thumb_dir.$filename);
  	$ret = ImageGIF($im_out, $thumb_dir.$filename);
  	if (!$ret) { echo "Error at ImageGIF"; die;}
  	//ImagePNG($im_out, $thumb_dir.$filename.".png");
  	// Delete images
  	ImageDestroy($this->im_in);
  	ImageDestroy($im_out);
  	return $filename;
  }
  function get_uploadfiles($inputNames){
      $ret = array();
      foreach($inputNames as $fname){
            $ret[$fname] = $this->get_uploadfile($fname);
      }
      return $ret;
  }
  function get_uploadfile($inputName) {
  	global $xoopsUser;
    $htmlImage = null;
    $img_dir = "/uploads/";
    // embedding image MIME Content-Type
	$imgtype = "|gif|jpe?g|png|bmp|x-pmd|x-mld|x-mid|x-smd|x-smaf|x-mpeg";
    $w=$h=80;
	$upfile_localname = $thumb_localname = '';
    
	if (!$_FILES) return $htmlImage;
    $upfile       = $_FILES[$inputName];					//upload file object
    $upfile_tmp   = $_FILES[$inputName]['tmp_name'];     //tmp file name 
    $upfile_name  = basename($_FILES[$inputName]['name']);	//Local File Name ( Use basename for security )
    $upfile_name  = (get_magic_quotes_gpc()) ? stripslashes($upfile_name) : $upfile_name;
    $upfile_size  = $_FILES[$inputName]['size'];        //File Size
    $upfile_type  = $_FILES[$inputName]['type'];        //File MIME Content-Type
    $upfile_error = $_FILES[$inputName]['error'];		//upload file error no
    
    if ( $upfile_tmp && $xoopsUser ){
   		// Disp File Infomation for debug
        /*
		print("File Infomation:<BR>\n");
		print("File From : $upfile_tmp<BR>\n");
		print("File To : $upfile_name<BR>\n");
		print("File Size - $upfile_size<BR>\n");
		print("File type - $upfile_type<BR>\n");
        */
//    	$size = getimagesize($upfile_tmp);
//		$type = getimagetype($upfile_tmp);
		$fnamedotpos = strrpos($upfile_name,'.');
		$fext = strtolower(substr($upfile_name,$fnamedotpos+1));
//		if ( !$size || !strcmp($type,$upfile_type) ) return $addmsg." ERROR: getimagesize(".$size."),type(".$type.") ".$upfile_type;
		$upfile_localname = time() . substr(md5($upfile_name), 0, 8) . "." . $fext;
		$upfile_url = $img_dir.rawurlencode($upfile_localname);
    	$upfile_path = XOOPS_ROOT_PATH.$img_dir.$upfile_localname;
    	move_uploaded_file($upfile_tmp,$upfile_path);
		chmod($upfile_path,0644);
		// Thumbs Support ( PHP GD Libraly Required )
		if (in_array($fext,$this->thumb_ext)) {
			$size = $this->getImageSize($upfile_path);
			if ($size[0] > $w || $size[1] > $h) {
				$thumb_localname = "thumb_" . $this->thumb_create($upfile_path,$w,$h,XOOPS_ROOT_PATH.$this->thumb_dir);
				$thumbfile_url = XOOPS_URL.$this->thumb_dir.rawurlencode($thumb_localname);
			}
		}
    }
	return $upfile_url;
  }
}
?>