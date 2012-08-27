<?php
/***************************************************************************
                           fileup.ini.php  -  description
                           ------------------------------
    begin                : Tue Mar 23 2004
    copyleft             : (C) 2004,2005 Bluemoon inc.
    home page            : http://www.bluemooninc.biz/
    auther               : Y.Sakai
    email                : webmaster@bluemooninc.biz

    $Id: fileup.ini.php,v 1.5 2005/11/03 08:39:53 yoshis Exp $

 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
	//
	// for converting to text file
	//
	define( "SAVE_AS_TEXT" , "UTF-8" );			// Text decoding as client local ( SJIS,UTF-8 )
	//
	// Viewer section
	//
	$def_sortsince = 3650;	// Default view since from 'n' days. (Param=1,2,5,10,20,30,40,60,90,180,365,1000=ALL)
	//
	// Editor section
	//
	define( 'READ_SIGN' , 1 );					// Sign as read 0 = Not USE, 1 = Private Only ,2= ALL
	define( 'ALTANATE_DISP' , 0 );				// Altanate 0 = Off, 1 = On
	//
	// Edit Option ( If you care about attack by malicious people, keep WYSIWYG editor off. )
	//
	$BB_CNF['use_spaw'] = 1;		// 0 = OFF, 1= ON ( Anonymous are always off )
	$BB_CNF['spaw_path'] = XOOPS_ROOT_PATH."/common/spaw/";	// SPAW folder ( Recommend in TinyD )
	//
	// Upload File section
	//
	define( 'UPLOADS' , '../../uploads/' );		// Upload folder. You should set more secure folder (ex.'c:/upload/','/Users/xoops/Shared/').
	define( 'GUEST_DOWNLOAD' , 0 ); 			// Guest Download Acceptable 0 = No , 1 = YES
	$upload_acclevel = 1 ;						// 0 = Guest upload ok, 1 = xoopsUser, 2 = Auther(Admin&Modelater), Default = 1
	$denyUID = array(0,99999);					// Set deny naughty user's UID. It's work with $upload_acclevel = 1
	//
	// Image and Thumbnail Section
	//
	$gd_ver = 2;								// PHP GD Library Version (0:Not support, 1:Ver 1, 2:Ver 2)
	$img_dir = "/uploads/";						// image folder ( It work with XOOPS_URL,XOOPS_ROOT_PATH )
	$thumb_dir = "/uploads/thumbs/";			// Thumb image folder ( You have to create this folder. )
	$thumb_ext = ".+\.jpe?g$|.+\.png$|.+\.gif$";	// Thumb image target file extentions
	$w = 100;									// Thumb target width
	$h = 100;									// Thumb target height
	// Max upload file size
	// If you want set upper 2M, You must change php.ini
	//   memory_limit = 8M (default)
	//   post_max_size = 8M (default)
	//   upload_max_filesize =2M (default)
	//---- Those parameter no longer to use. it moved to module administration after V1.80 ----
	//$normal_maxbyte = 2000000;			// 2MB for Normal Forum
	//$private_maxbyte = 40000000;		// 40MB for Private Forum

	// Acceptable MIME Content-Type
	//---- Those parameter no longer to use. it moved to module administration after V1.88 ----
	//$subtype = "gif|jpe?g|png|bmp|video|audio|zip|lzh|pdf|excel|msword|powerpoint|octet-stream|x-pmd|x-mld|x-mid|x-smd|x-smaf|x-mpeg|x-shockwave-flash|x-ms-asf";

	// embedding image MIME Content-Type
	$imgtype = "gif|jpe?g|png|bmp|x-pmd|x-mld|x-mid|x-smd|x-smaf|x-mpeg";

	// embedding EMBED MIME Content-Type
	$embedtype = "video|audio|x-shockwave-flash|x-ms-asf";
	$embed_w = 1024;		// Embed Default width
	$embed_h = 768;		// Embed Default height

	// Reject Ext. name
	$viri = "cgi|php|jsp|pl|htm";

////////////////// end ///////////////////
?>