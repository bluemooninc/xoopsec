<?php
// $Id: doc_updateinfo.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $

include '../../../../mainfile.php';

include '../../../../include/cp_functions.php';

	xoops_cp_header();
?>
<h1>Update Information</h1>

It's need a backup restore tool before this method. <p>
<li><a href=http://www.bluemooninc.biz/~xoops2/modules/mydownloads/singlefile.php?cid=3&lid=36">BackPack</a> at Bluemooninc.biz<p>
<li><a href=http://www.phpmyadmin.net/home_page/index.php">phpMyAdmin</a> at The phpMyAdmin Project<p>
<hr>
<h2>Update V0.3 to V0.4</h2>

<h3>1. Backup bmsurvey_form table</h3>
<p>Backup a bmsurvey_form table. ('xoops_' is XOOPS prefix.)

<h3>2. Edit backup file.</h3>
<p><li> Open a backup file by Text Editor.
<p><li> Add a one line below after 'changed'.
<p>&nbsp;&nbsp; response_id	INT UNSIGNED NOT NULL,
<p><li> save it. 

<h3>3. Restore a backup file</h3>
<p>Restore an edited backup file.
<p>If you use the phpMyAdmin, Drop a table before restore.
<hr>

<h2>Update V0.2X to V0.3</h2>
<h3>1. Backup BMEF tables</h3>
<p>Backup all xoops_bmef_* tables. ('xoops_' is XOOPS prefix.) 
<h3>2. Edit backup file.</h3>
<p><li> Open a backup file by Text Editor.
<p><li> Replace all structure of bmef_respondent table. 
<p>&nbsp;&nbsp;  Copy all structure from bmsurvey_respondent table on bmsurvey/sql/mysql.sql and replace it.
<p><li> Find a bmef_form table and add one line after email.
<p>&nbsp;&nbsp;  from_option TINYINT( 3 ) UNSIGNED DEFAULT '0' NOT NULL,
<p><li> Rename all tables name 'bmef_' to 'bmsurvey_'
<p><li> save it. 
<h3>3. Restore a backup file</h3>
<p>Restore an edited backup file.
<p>If you use the phpMyAdmin, Drop all bmsurvey tables before restore.
<hr>

<?php
	xoops_cp_footer();
?>
