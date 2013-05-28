<?php
// $Id: submitcount.class.php,v0.01 2010/05/25 23:38:03 yoshis Exp $
//  ------------------------------------------------------------------------ //
//                      bmsurvey - Bluemoon Multi-Form                     //
//                   Copyright (c) 2005 - 2010 Bluemoon inc.                 //
//                       <http://www.bluemooninc.biz/>                       //
//              Original source by : phpESP V1.6.1 James Flemer              //
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
/**
 * Submit count for forms
 * @author yoshis
 *
 */
class submitCount {
	var $opFilePath;		// Full path for count	
	var $opFolder;			// count file folder
	var $emsg ='';			// Error message
	var $count = 0;			// count for submit
	var $xmlElement = "<submitCount>%u</submitCount>";

	/**
	 * Initial function
	 * @param char $opFolder
	 * @return NULL
	 */
	function submitCount($opFolder){
		$ret = $this->CheckOpFolder($opFolder);
		if (!$ret) return NULL;
	}
	/**
	 * Check output folder with mkdir.
	 * @param char $opFolder
	 * @return FALSE - NG | TRUE - Okay
	 */
	function CheckOpFolder($opFolder){
		global $xoopsModule;
		$opf = $opFolder;// . "/" . $xoopsModule->getVar("dirname");
		if (!file_exists($opf)){
			if (!mkdir($opf,0777)){
				$this->emsg = "error - mkdir(".$opf.");";
				return FALSE;
			}
		}
		$this->opFolder = $opf;
		return TRUE;
	}
	/**
	 * Set output file path with make new file.
	 * @param char $opFileName
	 * @return FALSE - NG | TRUE - Okay
	 */
	function setOpFilePath($opFileName){
		$this->opFilePath = $this->opFolder . "/" . $opFileName . ".xml";
		if (!file_exists($this->opFilePath)){
			if (!touch($this->opFilePath,0777)){
				$this->emsg = "error - touch(".$this->opFilePath.");";
				return FALSE;
			}
		}
		return TRUE;
	}
	/**
	 * Set count to output file.
	 * @param unknown_type $fp
	 * @return number
	 */
	function setCount($fp){
		if (flock($fp, LOCK_EX)) {		// File Lock
		    fseek($fp, 0);			// Cut Other strings
		    fwrite($fp, sprintf($this->xmlElement,$this->count));
		    flock($fp, LOCK_UN);		// Lock free
			$ret = $this->count;
		} else {
			$this->emsg = "error - flock(".$this->opFilePath.");";
			$ret = 0;
		}
		return $ret;
	}
	/**
	 * Count up for submit.
	 * @param char $opFileName
	 * @return number
	 */
	function countUp($opFileName){
		$this->setOpFilePath($opFileName);
		$fp = fopen( $this->opFilePath , "r+");
		fscanf($fp,$this->xmlElement,$c);
		$this->count = intval($c);
		$this->count++;
		$ret = $this->setCount($fp);
		fclose($fp);
		return $this->count;
	}
	/**
	 * Clear the count for restart count.
	 * @param char $opFileName
	 * @return number
	 */
	function countClear($opFileName){
		$this->setOpFilePath($opFileName);
		$fp = fopen( $this->opFilePath , "w");
		$this->count = 0;
		$ret = $this->setCount($fp);
		fclose($fp);
		return $this->count;
	}
}
?>