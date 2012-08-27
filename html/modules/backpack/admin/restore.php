<?php
// $Id: restore.php,v 1.1 2005/08/08 07:02:54 yoshis Exp $
//  ------------------------------------------------------------------------ //
//             BackPack - Bluemoon Backup/Restore Module for XOOPS           //
//              Copyright (c) 2005 Yoshi Sakai / Bluemoon inc.               //
//                       <http://www.bluemooninc.jp/>                       //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include '../../../include/cp_header.php';

xoops_cp_header();

require('../include/zip.lib.php');
require('../include/defines.lib.php');
require('../include/read_dump.lib.php');
// Include backup functions
include("backup.ini.php");
include("../class/class.backpack.php");

$mode = '' ;
$action = '' ;
$filename = '' ;
$restore_structure = '' ;
$restore_data = '' ;
$replace_url =  '';
// Make sure we pick up variables passed via URL
if( isset( $_GET[ 'mode' ] ) ) $mode = htmlspecialchars ( $_GET[ 'mode' ], ENT_QUOTES );
if( isset( $_GET[ 'action' ] ) ) $action = htmlspecialchars ( $_GET[ 'action' ], ENT_QUOTES );
if( isset( $_GET[ 'filename' ] ) ) $filename = htmlspecialchars ( $_GET[ 'filename' ], ENT_QUOTES );
if( isset( $_GET[ 'restore_structure' ] ) ) $restore_structure = htmlspecialchars ( $_GET[ 'restore_structure' ], ENT_QUOTES );
if( isset( $_GET[ 'restore_data' ] ) ) $restore_data = htmlspecialchars ( $_GET[ 'restore_data' ], ENT_QUOTES );
if( isset( $_POST['replace_url'] ) ) $replace_url =  htmlspecialchars ( $_POST['replace_url'], ENT_QUOTES );
			
$bp = new backpack(NULL);
if ($bp->err_msg) echo "<font color='red'>" . $bp->err_msg ."</font>";

// Display Admin Menu Tag
include_once './adminmenu.php';

// Handle URL actions
switch ($mode) {
	case RESTORE_DATA: {
		@set_time_limit(TIME_LIMIT);
		echo "<b>Restore Complete</B><p>";
		echo "The Restore is complete. Any errors or messages encountered are shown below.";
		echo "<p />";

		$fnamedotpos = strrpos($filename,'.');
		$fext = substr($filename,$fnamedotpos+1);
		$sql_str = "";
		switch($fext) {
		case "gz":
			$mime_type = "application/x-gzip";
			$sql_str = PMA_readFile($bp->backup_dir.$filename,$mime_type);
			break;
		case "bz":
			$mime_type = "application/x-bzip";
			$sql_str = PMA_readFile($bp->backup_dir.$filename,$mime_type);
			break;
		case "sql":
			$mime_type = "text/plain";
			break;
		default:
			$mime_type = "";
			break;
		}
		if (!file_exists($bp->backup_dir.$filename)){
			echo "No exsist file: ".$bp->backup_dir.$filename;
			break;
		}
		if ($sql_str){
			unlink($bp->backup_dir.$filename);
			$filename = preg_match_replace( ".gz|.bz" , "" , $filename);
			$fp = fopen($bp->backup_dir.$filename, 'wb');
			fwrite($fp, $sql_str);
			fclose($fp);
		}
		if ( strcmp(_CHARSET,'EUC-JP')==0 ){
		    $result = mysql_query( "SET NAMES 'ujis'" );
		}
		$bp->restore_data($bp->backup_dir.$filename, $restore_structure, $restore_data, $db_selected, $replace_url);
		unlink($bp->backup_dir.$filename);
		break;
	}
	case DB_SELECT_FORM: {
		echo "<table cellspacing=\"0\" cellpadding=\"3\">\n";
		if ($action == "backup") {
			echo "<tr><td class=\"title\">Backup MySQL Data</td></tr>\n";
			echo "<tr><td class=\"main_left\"><p><b>Select database to backup from</b>";
		}
		if ($action == "restore") {
			$upload       = $_FILES['filename'];
			$upload_tmp   = $_FILES['filename']['tmp_name'];	// Temp File name
			$upload_name  = $_FILES['filename']['name'];		// Local File Name
			$upload_size  = $_FILES['filename']['size'];		// Size
			$upload_type  = $_FILES['filename']['type'];		// Type
			$upfile_error = $_FILES['filename']['error'];		//upload file error no
		    if ( $upfile_error > 0 ){
		    	switch ($upfile_error){
		    		case UPLOAD_ERR_INI_SIZE: echo "Over upload_max_filesize on php.ini"; break;
		    		case UPLOAD_ERR_FORM_SIZE: echo "Over MAX_FILE_SIZE at form"; break;
		    		case UPLOAD_ERR_PARTIAL: echo "An error occured while trying to recieve the file. Please try again."; break;
		    		case UPLOAD_ERR_NO_FILE: echo "No Upload File."; break;
					default: echo "Unknown Error - ".$upfile_error; print_r($_FILES); break;
				}
		    } 
			echo "<tr><td class=\"title\">Restore MySQL Data</td></tr>\n";
			if ( !$upload_name && isset($_POST['uploadedfilename'])) {
				$upload_name = $_POST['uploadedfilename'];
			} else {
				// Upload file
				$ret_val = move_uploaded_file($upload_tmp, $bp->backup_dir.$upload_name);
				if (!$ret_val) {
					echo "<br /><br />Could not upload file.\n";
					echo "Check upload_max_filesize, post_max_size, memory_limit parameters in php.ini";
					echo "</p></td></tr>\n";
					echo "</table>\n";
					break;
				}
			}
			echo "<tr><td class=\"main_left\"><p><b>restore from $upload_name</b>";
			echo "<tr><td class=\"main_left\"><p><b>replace URL from http://$replace_url</b>";
			$restore_structure = ($_POST['structure'] == "on") ? 1 : 0;
			$restore_data = ($_POST['data'] == "on") ? 1 : 0;
			echo "<form method=\"post\" action=\"restore.php?mode=".RESTORE_DATA.
				"&filename=$upload_name&restore_structure=$restore_structure&restore_data=$restore_data\">\n";
		}
		echo "<input type=\"submit\" value=\""._AM_RESTORE."\">\n";
		echo "</form>\n";
		echo "</p></td></tr>\n";
		echo "</table>\n";
		break;
	}
	default: {
		if (!$filesize = ini_get('upload_max_filesize')) {
			$filesize = "5M";
		}
		$max_upload_size = $bp->get_real_size($filesize);
		if ($postsize = ini_get('post_max_size')) {
			$postsize = $bp->get_real_size($postsize);
			if ($postsize < $max_upload_size) {
				$max_upload_size = $postsize;
			}
		}
		unset($filesize);
		unset($postsize);
		echo "<H2>"._AM_RESTORETITLE."</H2>";
		/*
		** for file upload
		*/
		echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\""
			.XOOPS_URL."/modules/backpack/admin/restore.php?mode=".DB_SELECT_FORM."&action=restore\">";
		echo "<table class='outer' width=100%><tr><td class=\"head\" colspan=2>"._AM_RESTORETITLE1."</td></tr>\n";
		echo "<tr><td class='odd' width='30%'><b>"._AM_SELECTAFILE."</b> (gz, bz, sql)</td>";
		echo "<td><INPUT TYPE='hidden' NAME='MAX_FILE_SIZE' VALUE='$maxbyte'>
			<input type='file' name='filename'>".$bp->PMA_displayMaximumUploadSize($max_upload_size)."</td></tr>";
		echo "<tr><td class='odd'><b>"._AM_DETAILSTORESTORE."</b></td>";
		echo "<td><input type=\"checkbox\" name=\"structure\" checked />&nbsp;"._AM_TABLESTRUCTURE."
				<input type=\"checkbox\" name=\"data\" checked />&nbsp;"._AM_TABLEDATA."</td></tr>";
		// preg_replace URL
		echo "<tr><td class='odd' width='30%'><b>"._AM_REPLACEURL."</b> </td>";
		echo "<td><input type='text' name='replace_url'> "._AM_REPLACEURL_DESC."</td></tr>";
		// submit
		echo "<tr><td colspan=2 align='center'><input type=\"submit\" value=\""._AM_RESTORE."\" />
			</td></tr></table></form>";
		echo "<p />";
		/*
		** for import only
		*/
		echo "<form method=\"post\" action=\""
			.XOOPS_URL."/modules/backpack/admin/restore.php?mode=".DB_SELECT_FORM."&action=restore\">";
		echo "<table class='outer' width=100%><tr><td class=\"head\" colspan=2>".sprintf(_AM_RESTORETITLE2,$bp->backup_dir)."</td></tr>\n";
		echo "<tr><td class='odd' width='30%'><b>"._AM_UPLOADEDFILENAME."</b> (gz, bz, sql)</td>";
		echo "<td><input type='text' name='uploadedfilename'>"._AM_UPLOADEDFILENAME_DESC."</td></tr>";
		echo "<tr><td class='odd'><b>"._AM_DETAILSTORESTORE."</b></td>";
		echo "<td><input type=\"checkbox\" name=\"structure\" checked />&nbsp;"._AM_TABLESTRUCTURE."
				<input type=\"checkbox\" name=\"data\" checked />&nbsp;"._AM_TABLEDATA."</td></tr>";
		// preg_replace URL
		echo "<tr><td class='odd' width='30%'><b>"._AM_REPLACEURL."</b></td>";
		echo "<td><input type='text' name='replace_url'> "._AM_REPLACEURL_DESC."</td></tr>";
		// submit
		echo "<tr><td colspan=2 align='center'><input type=\"submit\" value=\""._AM_RESTORE."\" />
			</td></tr></table></form>";
		echo "<p />";
	}
}
// Close MySQL link
mysql_close($link);
echo $footer;
xoops_cp_footer();
?>
