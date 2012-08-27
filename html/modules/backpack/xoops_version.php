<?php
// $Id: xoops_version.php,v 0.93 2008/04/25 10:25:58 yoshis Exp $
//  ------------------------------------------------------------------------ //
//             BackPack - Bluemoon Xoops  Backup/Restore Module              //
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
$modversion['name'] = _MI_MOD_NAME;
$modversion['version'] = "0.9801";
$modversion['description'] = _MI_MOD_DESC;
$modversion['author'] = "Yoshi Sakai";
$modversion['credits'] = "Copyright (c) Bluemoon inc. 2004 - 2012";
$modversion['help'] = "help.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/backpack.png";
$modversion['dirname'] = "backpack";

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 0;

// Blocks


// Search
$modversion['hasSearch'] = 0;

// Smarty
$modversion['use_smarty'] = 1;

/**
* Option
*/
$modversion['config'][1]['name'] = 'max_dumpsize';
$modversion['config'][1]['title'] = '_MI_MAX_DUMPSIZE';
$modversion['config'][1]['description'] = '_MI_MAX_DUMPSIZEDSC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 15000000;
/*
$modversion['config'][2]['name'] = 'encodingto';
$modversion['config'][2]['title'] = '_MI_ENCODING_TO';
$modversion['config'][2]['description'] = '_MI_ENCODING_TO_DSC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'UTF-8';
*/
$modversion['config'][3]['name'] = 'xoopsurlto';
$modversion['config'][3]['title'] = '_MI_XOOPSURL_TO';
$modversion['config'][3]['description'] = '_MI_XOOPSURL_DSC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'text';
$modversion['config'][3]['default'] = XOOPS_URL;
?>