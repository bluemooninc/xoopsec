<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
class Bmsurvey_Question_typeObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('id', XOBJ_DTYPE_INT, 0);
		$this->initVar('type', XOBJ_DTYPE_STRING, '', true, 32);
		$this->initVar('has_choices', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('response_table', XOBJ_DTYPE_STRING, '', true, 32);
	}
}
class Bmsurvey_Question_typeHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmsurvey_question_type';
	public $mPrimary = 'id';
	public $mClass = 'Bmsurvey_Question_typeObject';
	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
}