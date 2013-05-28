<?php

require_once XOOPS_ROOT_PATH."/class/xoopstopic.php";
require_once XOOPS_ROOT_PATH."/class/xoopsuser.php";
require_once XOOPS_ROOT_PATH."/class/xoopsobject.php";

class BmSurvey extends XoopsObject{
	var $relation ;
	var $newstopic = null ;
	var $table = '' ;

	function BmSurvey( $formName )
	{
		$this->db =& Database::getInstance();
		$this->table = $this->db->prefix( "bmsurvey_form" ) ;

		$this->initVar("id", XOBJ_DTYPE_INT, null, false);
		$this->initVar("name", XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar("owner", XOBJ_DTYPE_INT, null, false);
		$this->initVar("realm", XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar("respondents", XOBJ_DTYPE_TXTBOX, null, false, 64);
		if ( !empty($formName) ) {
			$this->load($formName);
			$this->vars['id']['value'] = $this->getVar('id');
			$this->vars['name']['value'] = $this->getVar('name');
			$this->vars['owner']['value'] = $this->getVar('owner');
			$this->vars['realm']['value'] = $this->getVar('realm');
			$this->vars['respondents']['value'] = $this->getVar('respondents');
		}
	}

	function load($formName)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE name='".mysql_real_escape_string($formName)."'";
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
	}
}
?>