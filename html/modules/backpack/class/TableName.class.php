<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/02/02
 * Time: 17:20
 * To change this template use File | Settings | File Templates.
 */
class TableName{
	private function _changePrefixDirname($table,$dirname){
		$tableName = str_replace(
			array('{prefix}_','{dirname}'),
			array('',$dirname),
			$table
		);
		return $tableName;
	}
	function get_module_tables($dirname){
		if (!$dirname ) return;
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($dirname);
		// Get tables used by this module
		$modtables = $module->getInfo('tables');
		if ($modtables != false && is_array($modtables)) {
			$tableNames = array();
			foreach($modtables as $table){

				$tableNames[] = $this->_changePrefixDirname($table,$dirname);
			}
			return $tableNames;
		}else{
			echo __LINE__;
			// TABLES (loading mysql.sql)
			$sql_file_path = XOOPS_TRUST_PATH . "/modules/" . $dirname.'/sql/mysql.sql' ;
			$prefix_mod = $dirname ;
			if( file_exists( $sql_file_path ) ) {
				$sql_lines = file( $sql_file_path ) ;
				foreach( $sql_lines as $sql_line ) {
					if( preg_match( '/^CREATE TABLE \`?([a-zA-Z0-9_-]+)\`? /i' , $sql_line , $regs ) ) {
						$tableName = $this->_changePrefixDirname($regs[1],$dirname);
						$modtables[] = $prefix_mod.'_'.$tableName ;
					}
				}
				return $modtables;
			}
		}
		die( "No Table" );
	}
}
