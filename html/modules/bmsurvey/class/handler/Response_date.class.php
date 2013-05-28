<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
class Bmsurvey_Response_dateObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('response_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('question_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('response',XOBJ_DTYPE_INT, 0);
	}
}
class Bmsurvey_Response_dateHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmsurvey_response_date';
	public $mPrimary = 'id';
	public $mClass = 'Bmsurvey_Response_dateObject';
	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
}