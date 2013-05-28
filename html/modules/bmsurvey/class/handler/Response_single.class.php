<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
class Bmsurvey_Response_singleObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('response_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('question_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('choice_id', XOBJ_DTYPE_INT, 0);
	}
}
class Bmsurvey_Response_singleHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmsurvey_response_single';
	public $mPrimary = 'id';
	public $mClass = 'Bmsurvey_Response_singleObject';
	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
}