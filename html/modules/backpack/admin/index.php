<?php
// $Id: index.php,v 0.90 2007/12/22 12:06:16 yoshis Exp $
//  ------------------------------------------------------------------------ //
//             BackPack - Bluemoon Backup/Restore Module for XOOPS           //
//             Copyright (c) 2005,2007 Yoshi Sakai / Bluemoon inc.           //
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
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require('../include/zip.lib.php');
require('../include/defines.lib.php');
require('../include/read_dump.lib.php');
// Include backup functions
include("backup.ini.php");
include("../class/class.backpack.php");

xoops_cp_header();

$bp = new backpack(NULL);
if ($bp->err_msg) echo "<font color='red'>" . $bp->err_msg ."</font>";

$time_start = time();
$dump_buffer = null;
$dump_line =0;
$dump_size =0;
$download_count = 0;
$download_fname = array();
$mime_type = "";
$query_res = array(); // for query result

if( isset( $_POST[ 'purgeallfiles'] )){
	$bp->purge_allfiles();
	redirect_header("./index.php", 1, _AM_PURGED_ALLFILES);
}
// Make sure we pick up variables passed via URL
if( isset( $_GET[ 'mode' ] )       ) $mode        = $_GET[ 'mode' ];       else $mode = '' ;
if( isset( $_GET[ 'action' ] )     ) $action      = $_GET[ 'action' ];     else $action = '' ;
if( isset( $_GET[ 'num_tables' ] ) ) $num_tables  = $_GET[ 'num_tables' ]; else $num_tables = '' ;
if( isset( $_GET[ 'checkall' ] )   ) $checkall    = $_GET[ 'checkall' ];   else $checkall = '' ;

// Display Admin Menu Tag
include_once './adminmenu.php';

$tr_comp = "<tr><td class='odd'><b>"._AM_COMPRESSION."</b></td>"
	."<td><input type='radio' id='gzip' name='file_compression' value='gzip' checked='checked' />"
	."<label for='gz'>gzip</label>&nbsp;&nbsp;\n"
	."<input type='radio' id='zip' name='file_compression' value='zip' />"
	."<label for='sql'>zip</label>&nbsp;&nbsp\n"
	."<input type='radio' id='plain' name='file_compression' value='none' />"
	."<label for='sql'>text</label>&nbsp;&nbsp\n</td></tr>";
$tr_strd = "<tr><td class='odd' width='30%'><b>"._AM_DETAILSTOBACKUP."</b></td>"
	."<td><input type=\"checkbox\" name=\"structure\" checked />&nbsp;"._AM_TABLESTRUCTURE."&nbsp;\n"
	."<input type=\"checkbox\" name=\"data\" checked />&nbsp;"._AM_TABLEDATA."&nbsp;\n</td></tr>";

// Handle URL actions
switch ($mode) {
	case POST_SELECT_MODULE_FORM: {
		$select_dirname = isset($_GET['dirname']) ? $_GET['dirname'] : 0;
		$mod_selections = $bp->make_module_selection($select_dirname);
		echo "<form method='post' action='index.php?mode=".POST_SELECT_TABLES_FORM."&alltables=on'>";
		echo "<table class='outer' width=100%><tr><td class=\"head\" colspan=2>"._AM_MODULEBACKUP."</td></tr>\n";
		echo "<tr><td class=\"odd\"><b>"._AM_SELECTMODULE."</b></td><td>$mod_selections</td></tr>\n";
		echo $tr_strd;
		echo $tr_comp;
		echo "<tr><td colspan=2 align='center'><input type=\"submit\" value=\""._AM_BACKUP."\">\n"
			."</td></tr></table>";
		echo "</form>\n";
		echo "<p />";
		break;
	}
	case POST_DB_SELECT_FORM: {
		$select_dirname = isset($_GET['dirname']) ? $_GET['dirname'] : 0;
		$mod_selections = $bp->make_module_selection($select_dirname,1);
		// Get list of tables in the database and output form
		if ($action=="module" && $dirname){
			$result = get_module_tables($dirname);
			$num_tables = sizeof($result);
			$checkall = true;
		}else{
			$result = mysql_list_tables($db_selected);
			$num_tables = mysql_num_rows($result);
		}
		echo "<table class='outer' width=100%>\n";
		echo "<form method=\"post\" action=\"index.php?mode=".POST_SELECT_TABLES_FORM."&num_tables=$num_tables\">\n";
		echo "<tr><td class=\"head\" colspan=2><b>"._AM_SELECTTABLES."</b></td></tr>\n";
		echo "<tr><td class=\"main_left\" colspan=2><p>"._AM_BACKUPNOTICE;
		echo "<p><b>"._AM_SELECTTABLE."</b></p>\n";
	    $checked   = (!empty($checkall) ? ' checked="checked"' : '');
		for ($i = 0; $i < $num_tables; $i++) {
			if ($action=="module" && $dirname){
				$tablename = $xoopsDB->prefix($result[$i]);
			} else {
				$tablename = mysql_tablename($result, $i);
			}
			$checkbox_string = sprintf("<input type=\"checkbox\" name=\"check_id%d\" $checked />
				<input type=\"hidden\" name=\"tablename%d\" value=\"%s\" />&nbsp;%s<br />\n",
				$i, $i, $tablename, $tablename);
			echo "<tr><td class=\"main_left\" colspan=2>$checkbox_string</td></tr>";
		}
		if ($action=="module" && $dirname){
			echo "<INPUT TYPE='hidden' NAME='dirname' VALUE='$dirname'>";
		}
		echo "<tr><td colspan=2>";
		echo "<a href=\"".XOOPS_URL."/modules/backpack/admin/index.php?mode=". POST_DB_SELECT_FORM
			."&action=backup&checkall=1\">"._AM_CHECKALL."</a></td></tr>";
		echo $tr_strd;
		echo $tr_comp;
		echo "<tr><td colspan=2>";
		echo "<p><input type=\"submit\" value=\""._AM_BACKUP."\">\n";
		echo "<input type=\"reset\" value=\""._AM_RESET."\">\n";
		echo "</p></td></tr>\n";
		echo "</form>\n";
		echo "</table>\n";
		break;
	}
	case POST_SELECT_TABLES_FORM: {
		$bp->purge_allfiles();
		@set_time_limit(TIME_LIMIT);
		$sql_string = "";
		$alltables = $backup_structure = $backup_data =0;
		if (isset($_GET['alltables'])) $alltables = ($_GET['alltables'] == "on") ? 1 : 0;
		if (isset($_POST['alltables'])) $alltables = ($_POST['alltables'] == "on") ? 1 : 0;
		if (isset($_POST['structure'])) $backup_structure = ($_POST['structure'] == "on") ? 1 : 0;
		if (isset($_POST['data'])) $backup_data = ($_POST['data'] == "on") ? 1 : 0;
		$dirname = isset($_POST['dirname']) ? $_POST['dirname'] : 0;
		if ($dirname){
			if (strcmp($dirname,"system")==0)
				$result = $sys_tables;
			else
				$result = $bp->get_module_tables($dirname);
			$num_tables = sizeof($result);
		}else{
			$result = mysql_list_tables($db_selected);
			$num_tables = mysql_num_rows($result);
		}
		$j = 0;
		$tablename_array = array();
		if (!$alltables){
			for ($i = 0; $i < $num_tables; $i++) {
				$check_id = sprintf("check_id%d", $i);
				$tablename = sprintf("tablename%d", $i);
				
				if ( isset($_POST[$check_id]) ) {
					if (isset($_POST[$tablename])){
						$tablename_array[$j] = $_POST[$tablename];
						$j++;
					}
				}
			}
		}else{
			for ($i = 0; $i < $num_tables; $i++) {
				if ( $dirname )
					$tablename_array[$i] = $xoopsDB->prefix($result[$i]);
				else
					$tablename_array[$i] = mysql_tablename($result, $i);
			}
		}
		if ($dirname){
			$filename =$dirname.date("YmdHis",time());
		}elseif($alltables){
			$filename ="xdb".date("YmdHis",time());
		}else{
			$filename ="xtbl".date("YmdHis",time());
		}
		$cfgZipType = $_POST['file_compression'];
		$bp->backup_data($tablename_array, $backup_structure, $backup_data, $filename, $cfgZipType);
		$download_fname = $bp->download_fname();
		if ( $bp->download_count == 1 ){
			//redirect_header("./download.php?url=".$download_fname[0]['filename'], 1, _AM_READY_TO_DOWNLOAD);
		    $url="./download.php?url=".$download_fname[0]['filename'];
		    $time=1;
		    $message=_AM_READY_TO_DOWNLOAD;
            $url = preg_replace("/&amp;/i", '&', htmlspecialchars($url, ENT_QUOTES));
            echo '
            <html>
            <head>
            <title>'.htmlspecialchars($xoopsConfig['sitename']).'</title>
            <meta http-equiv="Content-Type" content="text/html; charset='._CHARSET.'" />
            <meta http-equiv="Refresh" content="'.$time.'; url='.$url.'" />
            <style type="text/css">
                    body {background-color : #fcfcfc; font-size: 12px; font-family: Trebuchet MS,Verdana, Arial, Helvetica, sans-serif; margin: 0px;}
                    .redirect {width: 70%; margin: 110px; text-align: center; padding: 15px; border: #e0e0e0 1px solid; color: #666666; background-color: #f6f6f6;}
                    .redirect a:link {color: #666666; text-decoration: none; font-weight: bold;}
                    .redirect a:visited {color: #666666; text-decoration: none; font-weight: bold;}
                    .redirect a:hover {color: #999999; text-decoration: underline; font-weight: bold;}
            </style>
            </head>
            <body>
            <div align="center">
            <div class="redirect">
              <span style="font-size: 16px; font-weight: bold;">'.$message.'</span>
              <hr style="height: 3px; border: 3px #E18A00 solid; width: 95%;" />
              <p>'.sprintf(_AM_IFNOTRELOAD, $url).'</p>
            </div>
            </div>
            </body>
            </html>';
		}else{
			$form = new XoopsThemeForm( _AM_DOWNLOAD_LIST , 'download', $_SERVER['PHP_SELF'] ) ;
			for ($i=0; $i<count($download_fname); $i++){
				$url = "<A HREF='download.php?url=".$download_fname[$i]['filename'];
				$url .= "' target='_blank'>".$download_fname[$i]['filename']."</A> ";
				$url .= $download_fname[$i]['line']."lines ".$download_fname[$i]['size']."bytes<BR />\n";
				$form->addElement( new XoopsFormLabel( $i , $url ) ) ;
			}
		    $form->addElement(new XoopsFormButton('', 'purgeallfiles', _AM_PURGE_FILES, 'submit'));
			$form->display();
		}
		break;
	}
	
	case DB_SELECT_FORM: {
		echo "<table cellspacing=\"0\" cellpadding=\"3\">\n";
		if ($action == "backup") {
			echo "<tr><td class=\"title\">Backup MySQL Data</td></tr>\n";
			echo "<tr><td class=\"main_left\"><p><b>Select database to backup from</b>";
		}
		if ($action == "backup") echo "<form method=\"post\" action=\"index.php?mode=".POST_DB_SELECT_FORM."\">\n";
		echo "<input type=\"submit\" value=\"Restore\">\n";
		echo "</form>\n";
		echo "</p></td></tr>\n";
		echo "</table>\n";
		break;
	}
	default: {
		$result = mysql_list_tables($db_selected);
		$num_tables = mysql_num_rows($result);
		echo "<form method='post' action='index.php?mode=".POST_SELECT_TABLES_FORM."&num_tables=$num_tables&alltables=on'>";
		echo "<table class='outer' width=100%><tr><td class=\"head\" colspan=2>"._AM_BACKUPTITLE."</td></tr>\n";
		echo $tr_strd;
		echo $tr_comp;
		echo "<tr><td colspan=2 align='center'><input type=\"submit\" value=\""._AM_BACKUP."\">\n".
			"</td></tr></table></form>";
		echo "<p />";
	}
}
// Close MySQL link
mysql_close($link);
echo $footer;
xoops_cp_footer();

?>
