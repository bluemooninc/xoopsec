<?php
// $Id: admin.php,v 1.3 2005/08/08 07:03:06 yoshis Exp $
define("_AM_TITLE", "BackPack");
define("_AM_BACKUPTITLE","Database Backup");
define("_AM_MODULEBACKUP","Module Backup");
define("_AM_SELECTTABLES","Table Backup");
define("_AM_RESTORE","Restore");
define("_AM_OPTIMIZE","Optimize");
define("_AM_RESTORETITLE","Restore (Prefix will be replaced to '" . XOOPS_DB_PREFIX . "'.)");
define("_AM_DETAILSTOBACKUP","Select details to backup");
define("_AM_SELECTMODULE","Select Module");
define("_AM_COMPRESSION","Compression");
define("_AM_OTHER","Other");
define("_AM_SELECTAFILE","Select a file");
define("_AM_DETAILSTORESTORE","Select details to restore");
define("_AM_TABLESTRUCTURE","Table Structure");
define("_AM_TABLEDATA","Table Data");
define("_AM_BACKUP","Backup");
define("_AM_RESET","Reset");
define("_AM_BACKUPNOTICE","Once you click 'Backup' the selected tables will be backed up and a file download will start which will download the backup file to your computer.");
define("_AM_SELECTTABLE","Select Tables for backup");
define("_AM_CHECKALL","Check All");
define("_AM_RETURNTOSTART","Return to Start");
define("_AM_OPT_WARNING","WARNING: YOUR DATABASE WILL BE UNACCESSIBLE DURING THE OPTIMIZE.");
define("_AM_OPT_STARTING","STARTING OPTIMIZE ON DATABASE %s in %s SECONDS.");
define("_AM_BACKPACK_SITE","Support Site");
// After V0.86
define("_AM_RESTORETITLE1","Upload and restore");
define("_AM_RESTORETITLE2","Restore from %s folder files");
define("_AM_SELECTAFILE_DESC",'Max: %s%s');
define("_AM_UPLOADEDFILENAME","Input uploaded file name");
define("_AM_UPLOADEDFILENAME_DESC",'&nbsp;Upload before restoration. The file will be deleted after restoration.');
// After V0.88
define("_AM_DOWNLOAD_LIST","Download list");
define("_AM_PURGE_FILES","Purge all download files.");
define("_AM_PURGED_ALLFILES","All download files are purged.");
define("_AM_READY_TO_DOWNLOAD","Ready to download.");
// After V0.90
define("_AM_IFNOTRELOAD","If the download does not automatically start, please click <a href='%s'>here</a>");
// After V0.97
define('_AM_REPLACEURL','Replace URL(ommit http://)');
define('_AM_REPLACEURL_DESC','Describe the URL peplace to \''.XOOPS_URL.'\'');
?>