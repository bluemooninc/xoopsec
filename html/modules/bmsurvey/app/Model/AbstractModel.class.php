<?php
/**
 * Created by JetBrains PhpStorm.
 * Copyright(c): bluemooninc
 * Date: 2013/01/08
 * Time: 15:55
 * To change this template use File | Settings | File Templates.
 */
define('TABLE_REALM', $xoopsDB->prefix("bmsurvey_realm"));
define('TABLE_RESPONDENT', $xoopsDB->prefix("bmsurvey_respondent"));
define('TABLE_editFormER', $xoopsDB->prefix("bmsurvey_editFormer"));
define('TABLE_FORM', $xoopsDB->prefix("bmsurvey_form" ));
define('TABLE_QUESTION_TYPE', $xoopsDB->prefix("bmsurvey_question_type" ));
define('TABLE_QUESTION', $xoopsDB->prefix("bmsurvey_question" ));
define('TABLE_QUESTION_CHOICE', $xoopsDB->prefix("bmsurvey_question_choice" ));
define('TABLE_ACCESS', $xoopsDB->prefix("bmsurvey_access" ));
define('TABLE_RESPONSE', $xoopsDB->prefix("bmsurvey_response" ));
define('TABLE_RESPONSE_BOOL', $xoopsDB->prefix("bmsurvey_response_bool" ));
define('TABLE_RESPONSE_SINGLE', $xoopsDB->prefix("bmsurvey_response_single" ));
define('TABLE_RESPONSE_MULTIPLE', $xoopsDB->prefix("bmsurvey_response_multiple" ));
define('TABLE_RESPONSE_RANK', $xoopsDB->prefix("bmsurvey_response_rank" ));
define('TABLE_RESPONSE_TEXT', $xoopsDB->prefix("bmsurvey_response_text" ));
define('TABLE_RESPONSE_OTHER', $xoopsDB->prefix("bmsurvey_response_other" ));
define('TABLE_RESPONSE_DATE', $xoopsDB->prefix("bmsurvey_response_date" ));
define('TABLE_', $xoopsDB->prefix("bmsurvey_" ));

define('STATUS_EDIT',    0x00);
define('STATUS_ACTIVE',  0x01);
define('STATUS_STOP',    0x02);
define('STATUS_DELETED', 0x04);
define('STATUS_TEST',    0x08);

abstract class AbstractModel {
	// object
	protected $root = null;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->root = XCube_Root::getSingleton();
	}
	protected function getModuleNames($isactive = FALSE)
	{
		$criteria = new CriteriaCompo();
		if ($isactive) {
			$criteria->add(new Criteria('isactive', '1', '='));
		}
		$module_handler =& xoops_gethandler('module');
		$objs = $module_handler->getObjects($criteria);
		$ret = array();
		foreach ($objs as $obj) {
			$ret[$obj->getVar('mid')] = $obj->getVar('name');
		}
		return $ret;
	}

	/**
	 * @param $array
	 * @return array
	 */
	function array_flatten($array){
		$result = array();
		array_walk_recursive($array, function($v) use (&$result){
			$result[] = $v;
		});
		return $result;
	}
}