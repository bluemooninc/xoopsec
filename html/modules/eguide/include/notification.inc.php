<?php
// $Id: notification.inc.php,v 1.5 2008-07-05 06:22:07 nobu Exp $
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

include dirname(dirname(__FILE__))."/mydirname.php";

eval( '
function '.$myprefix.'_notify_iteminfo( $category, $item_id )
{
	return eguide_notify_iteminfo_base( "'.$egdirname.'" , "'.$myprefix.'" , $category, $item_id ) ;
}
' ) ;


if (!function_exists('eguide_notify_iteminfo_base')) {

include_once dirname(dirname(__FILE__)).'/const.php';

function eguide_notify_iteminfo_base($dirname, $prefix, $category, $item_id)
{
    global $xoopsDB;

    $item = array('name'=>'');
    if ($category=='event' && $item_id!=0) {
	// Assume we have a valid story id
	$sql = 'SELECT title FROM '.EGTBL. ' WHERE status=0 AND eid='.$item_id;
	$result = $xoopsDB->query($sql); // TODO: error check
	
	list($item['name']) = $xoopsDB->fetchRow($result);
	$item['url'] = XOOPS_URL."/modules/$dirname/event.php?eid=".$item_id;
    }
    return $item;
}

}
?>
