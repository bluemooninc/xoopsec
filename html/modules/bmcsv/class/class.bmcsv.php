<?php
// $Id: class.bmcsvphp,v 0.96 2009/11/19 12:05:16 yoshis Exp $
//  ------------------------------------------------------------------------ //
//             bmcsv - Bluemoon Import/Export Module for XOOPS           //
//             Copyright (c) 2005-2009 Yoshi Sakai / Bluemoon inc.           //
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
/*=============================================================================
Based by class-1 MySQL Import/Export
    (c) class-1 Web Design (http://www.class1web.co.uk), 2004
=============================================================================*/

class bmcsv {
	var $debug = 0;		// Define this to enable debugging
	var $export_dir;
	var $dump_size;
	var $dump_line;
	var $dump_buffer;
	var $query_res;
	var $download_count;
	var $download_fname;
	var $mime_type;
	var $time_start;
	var $xoopsModuleConfig;
	var $err_msg;

	function bmcsv($dirname=NULL,$purgeBefore=NULL){
		global $xoopsModuleConfig,$xoopsModule;
		if (!$dirname){
			$this->xoopsModuleConfig = $xoopsModuleConfig;
			$dirname = $xoopsModule->dirname();
		}else{
			$this->xoopsModuleConfig($dirname);
		}
		$this->set_export_dir($dirname);
		$this->time_start = time();
		$this->dump_buffer = null;
		$this->dump_line =0;
		$this->dump_size =0;
		$this->download_count = 0;
		$this->download_fname = array();
		$this->mime_type = "";
		$this->query_res = array();
		if ($purgeBefore)
			$this->purge_allfiles($purgeBefore);
	}
	function set_export_dir($dirname){
		if ( defined('XOOPS_TRUST_PATH')) {
			$export_dir = XOOPS_TRUST_PATH . '/cache/';
		}else{
			$export_dir = XOOPS_ROOT_PATH . '/cache/';
		}
		if(!is_writable($export_dir)){
			$this->err_msg = "Temporaly using cache. Cause no exist or can not writable=> ".$export_dir;
			$export_dir = XOOPS_TRUST_PATH . '/cache/';
			$upload_tmp_dir = @ini_get('upload_tmp_dir');
			if (!empty($upload_tmp_dir)) {
			    //$export_dir = (PMA_IS_WINDOWS ? 'C:' : '') . $upload_tmp_dir ."/";
		    	//Modify by seb75net
		    	$export_dir =  $upload_tmp_dir ."/";
			} else {
				$export_dir = "/tmp/";
			}
		}
		//die( $export_dir );
		$this->export_dir = $export_dir;
	}
	function xoopsModuleConfig($dirname){
		$module_handler =& xoops_gethandler('module');
		$this_module =& $module_handler->getByDirname($dirname);
		$mid = $this_module->getVar('mid');
		$config_handler =& xoops_gethandler('config');
		$this->xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $mid);
	}
	function PMA_backquote($a_name, $do_it = TRUE){
	    if ($do_it
	        && PMA_MYSQL_INT_VERSION >= 32306
	        && !empty($a_name) && $a_name != '*') {
	        return '`' . $a_name . '`';
	    } else {
	        return $a_name;
	    }
	} // end of the 'PMA_backquote()' function
	
	function makeCsvHeader_string($tablename){

	}
	function makeCsvBody_string($tablename,$filename,$cfgZipType){
	}
	function make_download($filename,$cfgZipType){
	
		if (($cfgZipType == 'bzip') && @function_exists('bzcompress')) {	// (PMA_PHP_INT_VERSION >= 40004 && 
			$filename .= $this->download_count>0 ? "-".$this->download_count.".sql" : ".sql"  ;
		    $ext       = 'bz2';
		    $this->mime_type = 'application/x-bzip';
	        $op_buffer = bzcompress($this->dump_buffer);
            $filename = preg_replace("/\./", "", $filename);
		} else if (($cfgZipType == 'gzip') && @function_exists('gzencode')) {	// (PMA_PHP_INT_VERSION >= 40004 && 
			$filename .= $this->download_count>0 ? "-".$this->download_count.".sql" : ".sql"  ;
		    $ext       = 'gz';
		    $content_encoding = 'x-gzip';
		    $this->mime_type = 'application/x-gzip';
	        // without the optional parameter level because it bug
		    $op_buffer = gzencode($this->dump_buffer,9);
            $filename = preg_replace("/\./", "", $filename);
		} else if (($cfgZipType == 'zip') && @function_exists('gzcompress')) {	// (PMA_PHP_INT_VERSION >= 40000 && 
			$filename .= $this->download_count>0 ? "-".$this->download_count : "";
		    $ext       = 'zip';
		    $this->mime_type = 'application/x-zip';
	        $extbis = '.sql';
	        $zipfile = new zipfile();
	        $zipfile -> addFile($this->dump_buffer, $filename . $extbis);
	        $op_buffer = $zipfile -> file();
		} else {
			$filename .= $this->download_count>0 ? "-".$this->download_count : "";
		    $ext       = 'sql';
			$cfgZipType = 'none';
		    $this->mime_type = "text/plain";
		    $op_buffer = $this->dump_buffer;
		}
		$fpathname = $this->export_dir.$filename.'.'.$ext;
		if ($this->debug) echo $fpathname."<br />";
		$fp = fopen($fpathname,'w');
		fwrite($fp, $op_buffer);
		fclose($fp);
		unset($op_buffer);
		if(!file_exists($fpathname)){
			print("Error - $filename does not exist.");
			return false;
		}
		$this->download_fname[$this->download_count]['filename'] = $filename.'.'.$ext;
		$this->download_fname[$this->download_count]['line'] = $this->dump_line;
		$this->download_fname[$this->download_count]['size'] = filesize($fpathname);
		$this->download_count++;
	}
	/*
	** $beforeDays : You can purge before N days
	*/
	function purge_allfiles($beforeDays=NULL){
		if ($handle = opendir( $this->export_dir )) {
		    while (false !== ($file = readdir($handle))) {
		        if (preg_match("/sql/",$file)) {
					$fileDate = filemtime( $this->export_dir.$file );
		            if ($beforeDays){
		            	$beforeDate = time() - 86400 * intval($beforeDays);
		            	if ( $fileDate < $beforeDate ){
				            if ($this->debug) echo "DELETE - $file $fileDate\n<BR>";
			            	unlink($this->export_dir.$file);
			            }
		            }else{
			            if ($this->debug) echo "DELETE - $file $fileDate\n<BR>";
		            	unlink($this->export_dir.$file);
		            }
		        }
		    }
		    closedir($handle);
		}
	}
	function check_dump_buffer($filename,$cfgZipType){
		$max_dumpsize = $this->xoopsModuleConfig['max_dumpsize'];
		if( !$max_dumpsize ) $max_dumpsize = MAX_DUMPSIZE;
		//echo $this->dump_line . " - " .strlen( bin2hex( $this->dump_buffer)) / 2  . "byte<br />";
		if ($this->dump_line >= MAX_DUMPLINE || $this->dump_size >= $max_dumpsize ){ 
			$this->make_download($filename,$cfgZipType);
			//unset($GLOBALS['dump_buffer']);
			//unset($GLOBALS['$this->dump_line']);
			$this->dump_buffer = "";
			$this->dump_line = 0;
			$this->dump_size = 0;
		}
	}
	function Lock_Tables($tablename_array){
	    $q = "LOCK TABLES";
	
		for ($i = 0; $i <count($tablename_array); $i++) {
	      $q .= " " .$tablename_array[$i] ." read,";
	    }
	    $q = substr($q,0,strlen($q)-1);
	    mysql_query($q);
	}
	function export_data($tablename_array, $export_structure, $export_data, $filename, $cfgZipType){
		
		$field_string = "-- Bluemoon.CSV Import/Export Module\r\n-- bmcsv\r\n-- http://www.bluemooninc.jp/\r\n"
			. "-- --------------------------------------------\r\n";
		$this->dump_buffer = $field_string;
		$this->dump_size += strlen(bin2hex($field_string)) / 2;
		preg_match_all("/\r\n/",$this->dump_buffer,$c);
		$this->dump_line += count($c[0]);
	    mysql_query("FLUSH TABLES");
		$this->Lock_Tables($tablename_array);
		for ($i = 0; $i <count($tablename_array); $i++) {
			if ( $export_structure ) $this->makeCsvHeader_string( $tablename_array[$i] );
			if ( $export_data      ){
				$this->makeCsvBody_string ( $tablename_array[$i], $filename, $cfgZipType);
			}
			$this->check_dump_buffer( $filename , $cfgZipType );
	        $time_now = time();
	        if ($this->time_start >= $time_now + 30) {
	            $this->time_start = $time_now;
	            header('X-pmaPing: Pong');
	        }
		}
	    mysql_query("UNLOCK TABLES");
	    if ( $this->dump_buffer ) $this->make_download( $filename, $cfgZipType );
	}
	function import_data($filename, $import_structure, $import_data, $db_selected, $replace_url='')
	{
		if (!file_exists($filename)) exit();
		$handle = fopen("$filename", "r");
	
		$prefix ='';
		mysql_set_charset('utf8');
		while (!feof($handle)) {
			$buffer='';
			while (!feof($handle)) {
				$cbuff = preg_replace("\n|\r|\t","",fgets($handle));
				// print (preg_match('--',$cbuff)?"true<br>":"false<br>");
				if (!preg_match('^--',$cbuff)) $buffer .= $cbuff;
				if (preg_match(';',$cbuff)!=false) break;
			}
			if (preg_match("/^CREATE TABLE|^INSERT INTO|^DELETE/i",$buffer)){
				if (!$prefix){
					$match = explode(" ",$buffer);
					$prefix = explode("_",$match[2]);
					$prefix = preg_replace("/^`/","", $prefix[0]);
				}
				$buffer = preg_replace("/".$prefix."_/" , XOOPS_DB_PREFIX."_" , $buffer);
				if ($replace_url){
					$pattern = 'http://' . $replace_url;
					$buffer = preg_replace( '/' . preg_quote($pattern, '/') . '/' , XOOPS_URL , $buffer);
				}
			}
			// 20100218
			$buffer = preg_replace("/on update CURRENT_TIMESTAMP default \'CURRENT_TIMESTAMP\'/i","",$buffer);
			if ($buffer) {
				// if this line is a create table query then check if the table already exists
				if (preg_match("^CREATE TABLE",$buffer) ) {
					if ($import_structure) {
						$tablename = explode(" ", $buffer);
						$tablename = preg_replace("`","",$tablename[2]);
						$result = mysql_list_tables($db_selected);
						for ($i = 0; $i < mysql_num_rows($result); $i++) {
							if (mysql_tablename($result, $i) == $tablename) {
								//$rand = substr(md5(time()), 0, 8);
								//$random_tablename = sprintf("%s_bak_%s", $tablename, $rand);
								mysql_query("DROP TABLE IF EXISTS $tablename");
								//mysql_query("RENAME TABLE $tablename TO $random_tablename");
								//echo "Backed up $tablename to $random_tablename.<br />\n";
							}
						}
						$result = mysql_query($buffer);
						if (!$result) {
							echo mysql_error()."<br />\n";
						} else {
							echo "Table '$tablename' successfully recreated.<br />\n";
						}
					}
				} else {
					//echo "[".$buffer."]";die;
					if ($import_data) {
						$result = mysql_query($buffer);
						if (!$result) echo mysql_error()."<br />\n";
					}
				}
			}
		}
		fclose($handle);
	}
	function get_module_tables($dirname){
		global $xoopsConfig,$xoopsDB;
		if (!$dirname ) return;
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($dirname);
		// Get tables used by this module
		$modtables = $module->getInfo('tables');
		if ($modtables != false && is_array($modtables)) {
			return $modtables;
		}else{
			// TABLES (loading mysql.sql)
			$sql_file_path = XOOPS_TRUST_PATH . "/modules/" . $dirname.'/sql/mysql.sql' ;
			$prefix_mod = $dirname ;
			if( file_exists( $sql_file_path ) ) {
				$sql_lines = file( $sql_file_path ) ;
				foreach( $sql_lines as $sql_line ) {
					if( preg_match( '/^CREATE TABLE \`?([a-zA-Z0-9_-]+)\`? /i' , $sql_line , $regs ) ) {
						$modtables[] = $prefix_mod.'_'.$regs[1] ;
					}
				}
				return $modtables;
			}
		}
		die( "No Table" );
	}
	function make_module_selection($select_dirname='',$addblank=0)
	{
	    global $xoopsDB;
		$sql = "SELECT name,dirname FROM ".$xoopsDB->prefix('modules');
		if (!$result = $xoopsDB->query($sql)) {
			return false;
		}
		$mod_selections  = "<select name=\"dirname\">\n";
		$mod_selections .= $addblank ? "<option value=''></option>\n" : "" ;
		while(list($name, $dirname) = $xoopsDB->fetchRow( $result ) ) {
			if (strcmp($dirname,$select_dirname)==0) $opt = "selected";
			else $opt="";
			$mod_selections .= "<option value=\"${dirname}\" ${opt}>${name}</option>\n";
		}
		$mod_selections .= "</select>\n";
		return $mod_selections;
	}
	/**
	 * Maximum upload size as limited by PHP
	 * Used with permission from Moodle (http://moodle.org) by Martin Dougiamas
	 *
	 * this section generates $max_upload_size in bytes
	 */
	
	function get_real_size($size=0) {
	/// Converts numbers like 10M into bytes
	    if (!$size) {
	        return 0;
	    }
	    $scan['MB'] = 1048576;
	    $scan['Mb'] = 1048576;
	    $scan['M'] = 1048576;
	    $scan['m'] = 1048576;
	    $scan['KB'] = 1024;
	    $scan['Kb'] = 1024;
	    $scan['K'] = 1024;
	    $scan['k'] = 1024;
	
	    while (list($key) = each($scan)) {
	        if ((strlen($size)>strlen($key))&&(substr($size, strlen($size) - strlen($key))==$key)) {
	            $size = substr($size, 0, strlen($size) - strlen($key)) * $scan[$key];
	            break;
	        }
	    }
	    return $size;
	}
	/**
	* Displays the maximum size for an upload
	*
	* @param   integer  the size
	*
	* @return  string   the message
	*
	* @access  public
	*/
	function PMA_displayMaximumUploadSize($max_upload_size) {
	    list($max_size, $max_unit) = $this->PMA_formatByteDown($max_upload_size);
	    return '(' . sprintf(_AM_SELECTAFILE_DESC, $max_size, $max_unit) . ')';
	}
	/**
	 * Formats $value to byte view
	 *
	 * @param    double   the value to format
	 * @param    integer  the sensitiveness
	 * @param    integer  the number of decimals to retain
	 *
	 * @return   array    the formatted value and its unit
	 *
	 * @access  public
	 *
	 * @author   staybyte
	 * @version  1.2 - 18 July 2002
	 */
	function PMA_formatByteDown($value, $limes = 6, $comma = 0)
	{
	    $dh           = pow(10, $comma);
	    $li           = pow(10, $limes);
	    $return_value = $value;
		$byteunits = array('Byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
	    $unit         = $byteunits[0];
		$number_thousands_separator = ',';
		$number_decimal_separator = '.';
	
	    for ( $d = 6, $ex = 15; $d >= 1; $d--, $ex-=3 ) {
	        if (isset($byteunits[$d]) && $value >= $li * pow(10, $ex)) {
	            $value = round($value / ( pow(1024, $d) / $dh) ) /$dh;
	            $unit = $byteunits[$d];
	            break 1;
	        } // end if
	    } // end for
	
	    if ($unit != $byteunits[0]) {
	        $return_value = number_format($value, $comma, $number_decimal_separator, $number_thousands_separator);
	    } else {
	        $return_value = number_format($value, 0, $number_decimal_separator, $number_thousands_separator);
	    }
	
	    return array($return_value, $unit);
	} // end of the 'PMA_formatByteDown' function
	function download_fname(){
		return $this->download_fname;
	}
	// end function
}
?>