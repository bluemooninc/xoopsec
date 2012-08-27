<?php
// $Id: comment_new.php,v 1.1 2005-12-27 08:29:43 nobu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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
include 'header.php';

$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
$eid = $com_itemid;
$exid = 0;
if (preg_match('/sub=(\d+)/', $_SERVER['HTTP_REFERER'], $d)) {
    $exid = $d[1];
}

$result = $xoopsDB->query('SELECT * FROM '.EGTBL.' e LEFT JOIN '.OPTBL.' o ON e.eid=o.eid LEFT JOIN '.CATBL.' ON topicid=catid LEFT JOIN '.EXTBL." ON e.eid=eidref AND exid=$exid WHERE e.eid=$eid AND status=".STAT_NORMAL);

$data = $xoopsDB->fetchArray($result);
edit_eventdata($data);
$com_replytext = _POSTEDBY.'&nbsp;<b>'.$data['uname'].'</b>&nbsp;'._DATE.'&nbsp;<b>'.$data['postdate'].'</b><br /><br />'.$data['disp_summary'];

$com_replytext .= "<br/><br/>".$data['disp_body']."<br/>";
$com_replytitle = $data['date'].': '.$data['title'];

include XOOPS_ROOT_PATH.'/include/comment_new.php';
?>