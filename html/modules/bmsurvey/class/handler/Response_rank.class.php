<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
class Bmsurvey_Response_rankObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('response_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('question_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('choice_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('response', XOBJ_DTYPE_INT, 0);
	}
}
class Bmsurvey_Response_rankHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmsurvey_response_rank';
	public $mPrimary = 'id';
	public $mClass = 'Bmsurvey_Response_rankObject';
	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
}