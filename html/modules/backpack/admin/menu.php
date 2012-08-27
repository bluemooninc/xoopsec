<?php
// $Id: menu.php,v 1.1.1.1 2005/08/28 02:13:08 yoshis Exp $
$adminmenu[0]['title'] = _MI_BACKUPTITLE;
$adminmenu[0]['link'] = "admin/index.php";
$adminmenu[1]['title'] = _MI_MODULEBACKUP;
$adminmenu[1]['link'] = "admin/index.php?mode=7";
$adminmenu[2]['title'] = _MI_SELECTTABLES;
$adminmenu[2]['link'] = "admin/index.php?mode=2&action=backup";
$adminmenu[3]['title'] = _MI_RESTORE;
$adminmenu[3]['link'] = "admin/restore.php";
$adminmenu[4]['title'] = _MI_OPTIMIZE;
$adminmenu[4]['link'] = "admin/optimizer.php";
?>