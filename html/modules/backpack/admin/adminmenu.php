<?php
// $Id: adminmenu.php,v 0.89 2007/10/24 12:51:28 yoshis Exp $
//  ------------------------------------------------------------------------ //
//             BackPack - Bluemoon Backup/Restore Module for XOOPS           //
//              Copyright (c) 2005 Yoshi Sakai / Bluemoon inc.               //
//                       <http://www.bluemooninc.jp/>                       //
// ------------------------------------------------------------------------- //
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
?>
	<!--/* Nice button styles */-->
	<style type="text/css">
	#buttontop { width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
	#buttonbar { float:left; width:100%; background: #e7e7e7 url("../images/bg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
	#buttonbar li { display:inline; margin:0; padding:0; }
	#buttonbar a { float:left; background:url("../images/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
	#buttonbar a span { float:left; display:block; background:url("../images/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
	/* Commented Backslash Hack hides rule from IE5-Mac \*/
	#buttonbar a span {float:none;}
	/* End IE5-Mac hack */
	#buttonbar a:hover span { color:#333; }
	#buttonbar #current a { background-position:0 -150px; border-width:0; }
	#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
	#buttonbar a:hover { background-position:0% -150px; }
	#buttonbar a:hover span { background-position:100% -150px; }
	</style>
<?php
	global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	$tblCol = Array();
	$tblCol[0]=$tblCol[1]=$tblCol[2]=$tblCol[3]=$tblCol[4]='';
//	$tblCol[$currentoption] = 'current';
	$verinfo =  $xoopsModule->getVar( 'name' ) . "&nbsp;v" . sprintf( "%2.2f" ,  $xoopsModule->getVar('version') / 100.0 ) ;

	echo "<div id='buttontop'>";
	echo "<table style='width: 100%; padding: 0;' cellspacing='0'><tr>";
	echo "<td style='width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;'>
		<a href='http://www.bluemooninc.jp/' target='_blank'>"._AM_BACKPACK_SITE."</a></td>";
	echo "<td style='width: 55%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>"
		.$verinfo."</b></td>";
	echo "</tr></table>";
	echo "</div>";

	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "<li id='".$tblCol[0]."'><a href='index.php'><span>"._AM_BACKUPTITLE."</span></a></li>";
	echo "<li id='".$tblCol[1]."'><a href='index.php?mode=". POST_SELECT_MODULE_FORM."'><span>"._AM_MODULEBACKUP."</span></a></li>";
	echo "<li id='".$tblCol[2]."'><a href='index.php?mode=". POST_DB_SELECT_FORM."&action=backup'><span>"._AM_SELECTTABLES."</span></a></li>";
	echo "<li id='".$tblCol[3]."'><a href='restore.php'><span>"._AM_RESTORE."</span></a></li>";
	echo "<li id='".$tblCol[4]."'><a href='optimizer.php'><span>"._AM_OPTIMIZE."</span></a></li>";
	//if (($xoopsModuleConfig['usecatperm'] == 1) || ($xoopsModuleConfig['usefileperm'] == 1)) {
	//}
	echo "</ul></div>&nbsp;<br />";
?>
