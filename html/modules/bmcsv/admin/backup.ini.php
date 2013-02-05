<?php
// $Id: export.ini.php,v 1.3 2005/09/14 01:45:44 yoshis Exp $
// Defines
DEFINE ("TIME_LIMIT",300);
DEFINE ("DB_SELECT_FORM", 1);
DEFINE ("POST_DB_SELECT_FORM", 2);
DEFINE ("POST_SELECT_TABLES_FORM", 3);
DEFINE ("import_DATA", 4);
DEFINE ("POST_CONFIG_FORM", 5);
DEFINE ("DELETE_CONFIG_FILE", 6);
DEFINE ("POST_SELECT_MODULE_FORM",7);
DEFINE ("MAX_DUMPLINE",131071);
DEFINE ("MAX_DUMPSIZE",1024);

// For the export features...
$cfg['ZipDump']               = TRUE;   // Allow the use of zip/gzip/bzip
$cfg['GZipDump']              = TRUE;   // compression for
$cfg['BZipDump']              = TRUE;   // dump files
//Check for php.ini
//memory_limit = 8M      ; Maximum amount of memory a script may consume (8MB)
//; Maximum size of POST data that PHP will accept.
//post_max_size = 8M
//; Maximum allowed size for uploaded files.
//upload_max_filesize = 2M
$maxbyte = "8000000";	// Upload Max FileSize ( Dipend on php.ini def = 2M )
//
// Start a session and get variables
//
$db_selected = XOOPS_DB_NAME;
$db_host=XOOPS_DB_HOST;
$db_user=XOOPS_DB_USER;
$db_pass=XOOPS_DB_PASS;

$sys_tables = array(
	"groups",
	"users",
	"groups_users_link",
	"group_permission",
	"modules",
	"newblocks",
	"block_module_link",
	"tplfile",
	"tplsource",
	"tplset",
	"config",
	"configcategory",
	"configoption",
	"avatar",
	"avatar_user_link",
	"xoopsnotifications",
	"image",
	"imagebody",
	"imagecategory",
	"imgset",
	"online",
	"priv_msgs",
	"smiles",
	"session",
	"xoopscomments",
	"bannerclient",
	"banner",
	"bannerfinish"
);
$footer = "<center>Copyright(c) Bluemoon inc. 2004-2009</center>";

// Whether the os php is running on is windows or not
if (!defined('PMA_IS_WINDOWS')) {
    if (defined('PHP_OS') && stristr(PHP_OS, 'win')) {
        define('PMA_IS_WINDOWS', 1);
    } else {
        define('PMA_IS_WINDOWS', 0);
    }
}
// Connect to MySQL
$link = mysql_connect("$db_host", "$db_user", "$db_pass");
if (!$link) die("Failed to connect to MySQL - ".mysql_error());
if ($db_selected) {
	$result = mysql_selectdb($db_selected, $link);
	if (!$result) {
		$_SESSION = array();
		session_destroy();
		die("Failed to select database - ".mysql_error());
	}
}
?>
