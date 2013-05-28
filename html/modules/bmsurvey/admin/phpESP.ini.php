<?php
// # $Id: phpESP.ini.php,v 1.5 2005/11/16 10:20:17 yoshis Exp $
//  ------------------------------------------------------------------------ //
//                Bluemoon.Multi-Form                                      //
//                    Copyright (c) 2005 Yoshi.Sakai @ Bluemoon inc.         //
//                       <http://www.bluemooninc.biz/>                       //
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
// Original Written by James Flemer For eGrad2000.com <jflemer@alum.rpi.edu>
//
// Usage : Must have gettext libraly. mb-functions avaiable.
//

//include_once('./conf.php');

// Name of application
$FMXCONFIG['name'] = 'BM-Form';
// Application version
$FMXCONFIG['version'] = 'v0.8 Irene';
/*
** Here are all the configuration options.
*/
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$mydirpath = dirname( dirname( __FILE__ ) ) ;
// Base URL for phpESP
// The string $server['HTTP_HOST'] will be replaced by the server name
$FMXCONFIG['base_url'] = XOOPS_URL.'/modules/'.$mydirname.'/';

// URL of the images directory (for <img src='...'> tags)
$FMXCONFIG['image_url'] = $FMXCONFIG['base_url'] . 'images/';

// URL of the automatic form publisher
$FMXCONFIG['autopub_url'] = $FMXCONFIG['base_url'] . 'webform.php';

// URL of the CSS directory (for themes)
$FMXCONFIG['css_url'] = $FMXCONFIG['base_url'] . 'public/css/';

//
// Upload file Section
//

// Upload Folder. It work with XOOPS_ROOT_PATH or XOOPS_URL
$FMXCONFIG['attach_path'] = '/uploads/';

// Acceptable MIME Type
$FMXCONFIG['subtype'] = "gif|jpe?g|png|bmp|zip|lzh|pdf|excel|powerpoint|octet-stream|x-pmd|x-mld|x-mid|x-smd|x-smaf|x-mpeg";

// embedding image MIME Content-Type
$FMXCONFIG['imgtype'] = "gif|jpe?g|png|bmp|x-pmd|x-mld|x-mid|x-smd|x-smaf|x-mpeg";
	
// Reject Ext. name
$FMXCONFIG['viri'] = "cgi|php|jsp|pl|htm";


if (!defined('ESP_BASE')) define('ESP_BASE', dirname(dirname(__FILE__)) .'/');
if (isset($_SERVER))  $server =& $_SERVER;
else                  $server =& $_SERVER;

// Allow phpESP to send email 
$FMXCONFIG['allow_email'] =  1;		// 0=No mail 1=send responce mail
//$FMXCONFIG['special_addr'] = "";	// Work with 'allow_email'=7
//$FMXCONFIG['special_char'] = "b1,";	// Add a spesial char for mail subject. (Work with 'allow_email'=7)

// Send human readable email, rather than machine readable (BOOLEAN)
$FMXCONFIG['human_email'] = true;

// Use authentication for editFormer interface (BOOLEAN)
$FMXCONFIG['auth_editForm'] = false;

// Use authentication for form responders (BOOLEAN)
$FMXCONFIG['auth_response'] = true;

// Choose authentication type: { 'default', 'ldap' }
$FMXCONFIG['auth_type'] = 'default';

// LDAP connection information
// (Set these values if you choose 'ldap' as the authentication type.)
$FMXCONFIG['ldap_server'] = 'ldap.example.com';
$FMXCONFIG['ldap_port']   = '389';
$FMXCONFIG['ldap_dn']     = 'dc=example,dc=com';
$FMXCONFIG['ldap_filter'] = 'uid=';

// Group to add responders to via the sign-up page
// (Set to "null", without quotes, to disable the sign-up page.)
$FMXCONFIG['signup_realm'] = 'auto';
$FMXCONFIG['anonymousname'] = 1;	// 0 = 'Anonymous' / 1 = IP Address

// Default number of option lines for new questions
$FMXCONFIG['default_num_choices'] = 10;

// Colors used by phpESP
$FMXCONFIG['main_bgcolor']      = '#FFFFFF';
$FMXCONFIG['link_color']        = '#0000CC';
$FMXCONFIG['vlink_color']       = '#0000CC';
$FMXCONFIG['alink_color']       = '#0000CC';
$FMXCONFIG['table_bgcolor']     = '#0099FF';
$FMXCONFIG['active_bgcolor']    = '#FFFFFF';
$FMXCONFIG['dim_bgcolor']       = '#3399CC';
$FMXCONFIG['error_color']       = '#FF0000';
$FMXCONFIG['warn_color']        = '#00FF00';
$FMXCONFIG['reqd_color']        = '#FF00FF';
$FMXCONFIG['bgalt_color1']      = '#FFFFFF';
$FMXCONFIG['bgalt_color2']      = '#EEEEEE';

/*******************************************************************
 * Most users will not need to change anything below this line.    *
 *******************************************************************/

// Enable debugging code (BOOLEAN)
$FMXCONFIG['DEBUG'] = false;

// Form handler to use
$FMXCONFIG['handler']        = ESP_BASE . 'public/handler.php';
$FMXCONFIG['handler_e']       = ESP_BASE . 'public/handler_e.php';
// Valid tabs when editing forms
$FMXCONFIG['tabs'] = array('general', 'questions', 'preview', 'order', 'finish');

// Copy of PHP_SELF for later use
$FMXCONFIG['manage'] =  "index.php";

// CSS stylesheet to use for editFormer interface
$FMXCONFIG['style_sheet'] = null;

// Status of gettext extension
$FMXCONFIG['gettext'] = extension_loaded('gettext');

// HTML page title
$FMXCONFIG['title'] = $FMXCONFIG['name'] .', v'. $FMXCONFIG['version'];

// phpESP css path
$FMXCONFIG['css_path'] = ESP_BASE . '/public/css/';

// phpESP locale path
$FMXCONFIG['locale_path'] = ESP_BASE . '/locale/';

// Load I18N support
// i18n language set
switch (_LANGCODE){
	case "da": $FMXCONFIG['default_lang'] = 'da_DK'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
	case "de": $FMXCONFIG['default_lang'] = 'da_DE'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
	case "el": $FMXCONFIG['default_lang'] = 'el_GR'; $FMXCONFIG['mail_charset'] = 'ISO-8859-7'; break;
	case "en": $FMXCONFIG['default_lang'] = 'en_US'; $FMXCONFIG['mail_charset'] = 'us-ascii'; break;
	case "es": $FMXCONFIG['default_lang'] = 'es_ES'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
	case "fr": $FMXCONFIG['default_lang'] = 'fr_FR'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
	case "it": $FMXCONFIG['default_lang'] = 'it_IT'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
	case "ja": $FMXCONFIG['default_lang'] = 'ja_JP'; $FMXCONFIG['mail_charset'] = 'iso-2022-jp'; break;
	case "nl": $FMXCONFIG['default_lang'] = 'nl_NL'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
	case "pt": $FMXCONFIG['default_lang'] = 'pt_PT'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
	case "sv": $FMXCONFIG['default_lang'] = 'sv_SE'; $FMXCONFIG['mail_charset'] = 'ISO-8859-1'; break;
}

if (isset($GLOBALS)) {
    $GLOBALS['FMXCONFIG'] = $FMXCONFIG;
} else {
    global $FMXCONFIG;
}
?>
