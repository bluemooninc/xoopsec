--------------------------------------------------------------
Module Name : Bluemoon.XOOPS Backup/Restore (Code: BackPack)
Folder Name : BackPack
Copyright(c): Yoshi Sakai, Bluemoon inc.
License     : GPL v2.0
Web Page    : http://www.bluemooninc.jp/
Released    : 2005/01/05
--------------------------------------------------------------
Bluemoon.XOOPS Backup/Restore is a PHP script that allows backup and restore of XOOPS tables.

It is written and distributed under the GNU General Public License which means that its
source is freely-distributed and available to the general public. See license.txt for
more information.

This module is based by Class-1 MySQL Backup/Restore ( http://www.class1web.co.uk/ )

Features
--------
This script fully functioning. Some of the advanced features are listed here;
 * Extremely easy installation
 * Extremely easy usage
 * Select which tables to backup or 1-click all tables.
 * Choose whether to backup just table structure, data or both
 * Choose whether to restore just table structure, data or both
 * Choose compression gzip,zip for backup and gzip,bzip for restore
 * Optimize database tables.
 * Cross Compatible with phpMyAdmin file.

What's New?
-----------
v0.1  2005/01/05 - Initial release
v0.2  2005/01/05 - Add French (Thx Outch),TChinese (Thx gary711.twbbs.org) languages.
v0.3  2005/02/06 - Add optimizer.php
v0.4  2005/02/09 - Support cross compatibility with phpMyAdmin.
Rev.a 2005/02/13 - Change function set_time_limit(180) to @set_time_limit(300).
Rev.b 2005/02/13 - Output dummy header for browser timeout.
Rev.c 2005/02/14 - Add Flush,Lock and Unlock tables during backup.
Rev.d 2005/02/17 - Bugfix about skip comments process in restore.
Rev.e 2005/06/05 - Bugfix about GET parameter on backup.
Rev.f 2005/06/17 - Update French by Outch.
Rev.g 2005/07/25 - Add a define TIME_LIMIT for set_time_limit.
v0.5  2005/08/07 - Add a Module Backup function.
v0.6  2005/09/03 - Bugfix CREATE TABLE at backup.inc (line 229).
v0.61 2005/09/05 - Update French language by seb75net.
v0.7  2005/09/09 - Bugfix LF to CR+LF at CREATE SQL strings in backup.inc (line 65).
v0.71 2005/11/03 - Add Big TChinese (Thx gary711.twbbs.org) languages.
v0.8  2006/02/15 - Security update for vulnerability of system globals. Bugfix for backup buffer. Add Content-Encoding for gzip.
v0.81 2006/02/19 - Support XOOPS2.2.x for admin menu.
v0.82 2006/04/18 - Support MySQL Under ver.4.0.2 for index type as FULLTEXT.
v0.83 2006/04/23 - Bugfix for compression using PMA_PHP_INT_VERSION.
v0.84 2006/07/07 - Prefix will be replaced to XOOPS_DB_PREFIX. Bugfix for output 'NULL' when the value is NULL.
v0.85 2006/10/10 - Accept DELETE command as sql syntax.
v0.86 2006/11/02 - Support restore from uploaded file.
v0.87 2006/12/03 - Changed tmp default to backpack/sql. It's for rental server.
Update French language by seb75net.
v0.88 2006/12/26 - Supported split downloading for big dump.
v0.88a 2007/06/26 - Fix French by seb75net.
v0.88b 2007/07/24 - Bugfix for make a zip file.
v0.89 2007/10/24 - Fix broken tag menu at IE6 on XOOPS Cube Legacy 2.1.
v0.90 2007/12/22 - Fix output header process at download.php. It passed with Xoops CL2.1 / Xoops 2.0.17.1 / Xoops 2.0.16a.
v0.91 2008/03/10 - Added grave accent for key name as UNIQUE KEY / FULLTEXT. Thanks for reporting seb75net.
v0.92 2008/04/14 - Change "Content-Disposition: inline;" header to "attachment;" at download.php for Xoops 2.0.18.
v0.93 2008/04/25 - Security update for XSS Vulnerability at download.php.
v0.94 2009/07/27 - Add "SET NAMES" for EUC-JP on MySQL 5.1.33. Other language (except UTF-8) set at restore.php
v0.95 2009/10/15 - Add max dump size for big dump. You can set it at module admin. Default parameter will compress about under 2Mbyte for download.
v0.96 2010/02/18 - Supported XOOPS_TRUST_PATH. Make a "./modules/backpack/sql" folder in your trust path. The core source file name changed from backup.inc.php to class.backpack.php and that changed more object-oriented. gzip and the bzip file changed to one extension. When restoring it, "CURRENT_TIMESTAMP" is omitted.
v0.97 2010/10/30 - New function as URL repleace when you restore to the new domain. For easy to moving!

Installation
------------
 * Upload backpack folder to XOOPS_URL/modules/.

 * module install from XOOPS admin.

 * Click a backpack icon in XOOPS admin.


Requirements
------------
This software requires a web server running XOOPS2, PHP and MySQL.

It has been developed and tested on the following plaforms;
 * Windows XP running Apache 1.3.33, PHP 4.3.10, MySQL 4.0.22, XOOPS2.0.x / 2.2.x

It has been tested with the following web browsers;
 * Mozilla FireFox
