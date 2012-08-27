<?php
/*
** for clockedworks module
*/
function backpack_cron($parameter=null){
	$dirname = basename( dirname( __FILE__ ) ) ;
	require(XOOPS_ROOT_PATH . "/modules/" . $dirname . '/include/zip.lib.php');
	require(XOOPS_ROOT_PATH . "/modules/" . $dirname . '/include/defines.lib.php');
	require(XOOPS_ROOT_PATH . "/modules/" . $dirname . '/include/read_dump.lib.php');
	include(XOOPS_ROOT_PATH . "/modules/" . $dirname . '/admin/backup.ini.php');
	include(XOOPS_ROOT_PATH . "/modules/" . $dirname . '/class/class.backpack.php');

	$alltables = $backup_structure = $backup_data = 1;
	$result = mysql_list_tables($db_selected);
	$num_tables = mysql_num_rows($result);
	for ($i = 0; $i < $num_tables; $i++) {
		$tablename_array[$i] = mysql_tablename($result, $i);
	}
	$filename ="xdb".date("YmdHis",time());
	$cfgZipType =  'gzip';
	$bp = new backpack($dirname,$parameter);
	if ($bp->err_msg) echo "<font color='red'>" . $bp->err_msg ."</font>";
	$bp->backup_data($tablename_array, $backup_structure, $backup_data, $filename, $cfgZipType);
}
?>