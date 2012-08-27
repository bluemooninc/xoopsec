<?php
// $Id: class.backpackphp,v 0.96 2009/11/19 12:05:16 yoshis Exp $
//  ------------------------------------------------------------------------ //
//             BackPack - Bluemoon Backup/Restore Module for XOOPS           //
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
Based by class-1 MySQL Backup/Restore
    (c) class-1 Web Design (http://www.class1web.co.uk), 2004
=============================================================================*/

class backpack {
	var $debug = 0;		// Define this to enable debugging
	var $backup_dir;
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

	function backpack($dirname=NULL,$purgeBefore=NULL){
		global $xoopsModuleConfig,$xoopsModule;
		if (!$dirname){
			$this->xoopsModuleConfig = $xoopsModuleConfig;
			$dirname = $xoopsModule->dirname();
		}else{
			$this->xoopsModuleConfig($dirname);
		}
		$this->set_backup_dir($dirname);
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
	function set_backup_dir($dirname){
		if ( defined('XOOPS_TRUST_PATH')) {
			$backup_dir = XOOPS_TRUST_PATH . '/cache/';
		}else{
			$backup_dir = XOOPS_ROOT_PATH . '/cache/';
		}
		if(!is_writable($backup_dir)){
			$this->err_msg = "Temporaly using cache. Cause no exist or can not writable=> ".$backup_dir;
			$backup_dir = XOOPS_TRUST_PATH . '/cache/';
			$upload_tmp_dir = @ini_get('upload_tmp_dir');
			if (!empty($upload_tmp_dir)) {
			    //$backup_dir = (PMA_IS_WINDOWS ? 'C:' : '') . $upload_tmp_dir ."/";
		    	//Modify by seb75net
		    	$backup_dir =  $upload_tmp_dir ."/";
			} else {
				$backup_dir = "/tmp/";
			}
		}
		//die( $backup_dir );
		$this->backup_dir = $backup_dir;
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
	
	function create_table_sql_string($tablename){
	    $crlf = "\r\n";
	
		// Start the SQL string for this table
		$field_header = "CREATE TABLE `$tablename` (";
		$field_string = "";
		
		// Get the field info and output to a string in the correct MySQL syntax
		$result = mysql_query("DESCRIBE $tablename");
		if ($this->debug) echo $tablename." .field_info\n\n";
		while ($field_info = mysql_fetch_array($result)) {
			if ($this->debug) {
				for ($i = 0; $i < count($field_info); $i++) {
					echo "$i: $field_info[$i]\n";
				}
			}
			$field_name = $field_info[0];
			$field_type = $field_info[1];
			$field_not_null = ($field_info[2] == "YES") ? "" : " NOT NULL";
			$field_default = ($field_info[4] == NULL) ? "" : sprintf(" default '%s'", $field_info[4]);;
			$field_auto_increment = ($field_info[5] == NULL) ? "" : sprintf(" %s", $field_info[5]);
			$field_string .= $field_string ? "," : $field_header ;
			$field_string .= $crlf.sprintf("  `%s` %s%s%s%s",  $field_name, $field_type, $field_not_null, $field_auto_increment, $field_default);
		}
		// Get the index info and output to a string in the correct MySQL syntax
		$result = mysql_query("SHOW KEYS FROM $tablename");	//SHOW INDEX FROM 
		if ($this->debug) echo "\nindex_info\n\n";
		while ($row = mysql_fetch_array($result)) {
	        $kname    = $row['Key_name'];
	        $ktype  = (isset($row['Index_type'])) ? $row['Index_type'] : '';
	        if (!$ktype && (isset($row['Comment']))) $ktype = $row['Comment']; // For Under MySQL v4.0.2
	        $sub_part = (isset($row['Sub_part'])) ? $row['Sub_part'] : '';
	         if ($kname != 'PRIMARY' && $row['Non_unique'] == 0) {
	            $kname = 'UNIQUE KEY `'.$kname.'`';
	        }
	        if ($ktype == 'FULLTEXT') {
	            $kname = 'FULLTEXT KEY `'.$kname.'`';
	        }
	        if (!isset($index[$kname])) {
	            $index[$kname] = array();
	        }
	        if ($sub_part > 1) {
	            $index[$kname][] = $this->PMA_backquote($row['Column_name'], 0) . '(' . $sub_part . ')';
	        } else {
	            $index[$kname][] = $this->PMA_backquote($row['Column_name'], 0);
	        }
	    } // end while
	    mysql_free_result($result);
	    $index_string = "";
	    while (list($x, $columns) = @each($index)) {
	        $index_string     .= ',' . $crlf;
	        if ($x == 'PRIMARY') {
	            $index_string .= '   PRIMARY KEY (';
	        } else if (substr($x, 0, 6) == 'UNIQUE') {
	            $index_string .= '   UNIQUE ' . substr($x, 7) . ' (';
	        } else if (substr($x, 0, 8) == 'FULLTEXT') {
	            $index_string .= '   FULLTEXT ' . substr($x, 9) . ' (';
	        } else {
	            $index_string .= '   KEY `' . $x . '` (';
	        }
	        $index_string .= implode($columns, ', ') . ')';
	    } // end while
	    $index_string .= $crlf;
		
		// Get the table type and output it to a string in the correct MySQL syntax
		$result = mysql_query("SHOW TABLE STATUS");
		if ($this->debug) echo "\nstatus_info\n\n";
		while ($status_info = mysql_fetch_array($result)) {
			for ($i = 0; $i < count($status_info); $i++) {
				if ($this->debug) echo "$i: $status_info[$i]\n";
				if ($status_info[0] == $tablename) $table_type = sprintf("ENGINE=%s", $status_info[1]);
			}
		}
	
		// Append the index string to the field string
		$field_string = sprintf("%s%s", $field_string, $index_string);
	
		// Put the field string in parantheses
		$field_string = sprintf("%s)", $field_string);
		
		// Finalise the MySQL create table string
		$field_string .= $table_type.";";
		$field_string = "-- \r\n-- ".$tablename." structure.\r\n-- ".$crlf.$field_string.$crlf;
		$this->dump_buffer .= $field_string;
		preg_match_all("/\r\n/",$field_string,$c);
		$this->dump_line += count($c[0]);
		$this->dump_size += strlen(bin2hex($field_string)) / 2;
	}
	function create_data_sql_string($tablename,$filename,$cfgZipType){
		global $xoopsModuleConfig,$xoopsDB;
		// Get field names from MySQL and output to a string in the correct MySQL syntax
		$this->query_res = $xoopsDB->query("SELECT * FROM $tablename");
		
		// Get table data from MySQL and output to a string in the correct MySQL syntax
		$this->dump_buffer .= "-- \r\n-- ".$tablename." dump.\r\n-- \r\n";
		$this->dump_line+=3;
		while ($row = $xoopsDB->fetchRow($this->query_res)) {
			// Initialise the data string
			$data_string = "";
			// Loop through the records and append data to the string after escaping
			for ($i = 0; $i < mysql_num_fields($this->query_res); $i++) {
				if ( $data_string != "") $data_string .= ",";
				if (!isset($row[$i]) || is_null($row[$i]))
					$data_string .= "NULL";
				else
					$data_string .= '"'.mysql_real_escape_string($row[$i]).'"';
				//$data_string = str_replace("`","\'",$data_string);
			}
			//die($data_string);
			// URL change
			if ( strcmp( $xoopsModuleConfig['xoopsurlto'], XOOPS_URL)<>0 )
				$data_string = preg_replace( '/' . preg_quote(XOOPS_URL, '/') . '/' , $xoopsModuleConfig['xoopsurlto'] , $data_string);
			// Encoding change
			/*
			if(extension_loaded("mbstring") && function_exists("mb_convert_encoding")){
				if ( strcmp( $xoopsModuleConfig['encodingto'], _CHARSET)<>0 )
					$data_string = mb_convert_encoding($data_string, $xoopsModuleConfig['encodingto'],_CHARSET);
			}*/
			// Put the data string in parantheses and prepend "VALUES "
			$data_string = sprintf("VALUES (%s)", $data_string);
			// Finalise the MySQL insert into string for this record
			$field_string = sprintf("INSERT INTO `%s` %s;\r\n", $tablename, $data_string);
			$this->dump_buffer .= $field_string;
			$this->dump_size += strlen(bin2hex($field_string)) / 2;
			$this->dump_line++;
			$this->check_dump_buffer($filename,$cfgZipType);
		}
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
		$fpathname = $this->backup_dir.$filename.'.'.$ext;
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
		if ($handle = opendir( $this->backup_dir )) {
		    while (false !== ($file = readdir($handle))) {
		        if (preg_match("/sql/",$file)) {
					$fileDate = filemtime( $this->backup_dir.$file );
		            if ($beforeDays){
		            	$beforeDate = time() - 86400 * intval($beforeDays);
		            	if ( $fileDate < $beforeDate ){
				            if ($this->debug) echo "DELETE - $file $fileDate\n<BR>";
			            	unlink($this->backup_dir.$file);
			            }
		            }else{
			            if ($this->debug) echo "DELETE - $file $fileDate\n<BR>";
		            	unlink($this->backup_dir.$file);
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
	function backup_data($tablename_array, $backup_structure, $backup_data, $filename, $cfgZipType){
		
		$field_string = "-- Bluemoon.Xoops Backup/Restore Module\r\n-- BackPack\r\n-- http://www.bluemooninc.jp/\r\n"
			. "-- --------------------------------------------\r\n";
		$this->dump_buffer = $field_string;
		$this->dump_size += strlen(bin2hex($field_string)) / 2;
		preg_match_all("/\r\n/",$this->dump_buffer,$c);
		$this->dump_line += count($c[0]);
	    mysql_query("FLUSH TABLES");
		$this->Lock_Tables($tablename_array);
		for ($i = 0; $i <count($tablename_array); $i++) {
			if ( $backup_structure ) $this->create_table_sql_string( $tablename_array[$i] );
			if ( $backup_data      ){
				$this->create_data_sql_string ( $tablename_array[$i], $filename, $cfgZipType);
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
	function restore_data($filename, $restore_structure, $restore_data, $db_selected, $replace_url='')
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
					if ($restore_structure) { 
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
					if ($restore_data) {
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