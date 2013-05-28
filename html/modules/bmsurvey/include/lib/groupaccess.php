<?php 
// $Id: groupaccess.php,v 1.8 2005/02/07 01:25:26 phppp Exp $
//  ------------------------------------------------------------------------ //
//                        WFsections for XOOPS                               //
//                 Copyright (c) 2004 WF-section Team                        //
//                    <http://www.wf-projects.com/>                          //
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
// Author: WF-section Team                                                   //
// URL: http://www.wf-projects.com                                           //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
/**
 * -----------------------------------------------------------------------------------------
 * Useage:
 * See included Docs
 * ------------------------------------------------------------------------------------------
 */
function grp_cnv_oldperm($operm){
	switch ($operm){
	case 7 :
	case 6 : $ret="1"; break;
	case 1 : $ret="1 2"; break;
	case 0 : $ret="1 2 3"; break;
	}
	return $ret;
}

function grp_listGroups($grps = "-1",$select_name)
{
    global $xoopsDB;
	$myts = &MyTextSanitizer::getInstance();

    $result = $xoopsDB->query("SELECT groupid, name FROM " . $xoopsDB->prefix('groups') . " ORDER BY groupid");

    if (!is_array($grps))
    {
        $grps = explode(" ", $grps);
    }
    $grouplist = "<select name=".$select_name." size='5' multiple='multiple'>";

    while (list($groupid, $name) = $xoopsDB->fetchRow($result))
    {
        $grouplist .= "<option value='$groupid'";

        if (@in_array($groupid , $grps) || @in_array("-1", $grps))
        {
            $grouplist .= " selected='selected'";
        }

        $grouplist .= " />" . $myts->makeTboxData4Show($name) . "</option>";
    }
    $grouplist .= "</select>";
    return $grouplist;
}

/**
 * checkAccess()
 * 
 * See docs for usage
 */
function grp_checkAccess($grps, $time = -1, $message = '')
{
    global $xoopsUser, $xoopsModule;

	//if ( is_object($xoopsUser) && $xoopsUser->isAdmin() ) {
	//	return true;
	//}	
    if (empty($grps)) return false;
    
    $groupid = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
    $grps = explode(" ", $grps);

    foreach ($groupid as $group){
        if (in_array($group, $grps)) return true;
    }
    if ($time != -1){
        redirect_header('javascript:history.back(1);', $time, $message);
        exit();
    }else	return false;
}

/**
 * checkadminAccess()
 * 
 * @param  $grps 
 * @return 
 */
function grp_checkadminAccess($grps)
{
    global $xoopsUser, $xoopsModule;

    $groupid = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    if ($xoopsUser->getVar('uid') == 1)
    {
        return true;
    }

    $grps = explode(" ", $grps);

    foreach ($groupid as $group)
    {
        if (in_array($group, $grps))
            return true;
    }
    return false;
}

/**
 * saveAccess()
 * 
 * See docs for usage
 */

function grp_saveAccess($grps)
{
    if (is_array($grps)) $grps = implode(" ", $grps);
    return($grps);
}

function grp_getGroupIda($grps)
{
    $ret = array();

    if (!is_array($grps))	$ret = explode(" ", $grps);
    else $ret = $grps;
    return $ret;
}
?>