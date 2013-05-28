<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
class Bmsurvey_QuestionObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('id', XOBJ_DTYPE_INT, 0);
		$this->initVar('form_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('name', XOBJ_DTYPE_STRING, '', true, 30);
		$this->initVar('type_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('result_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('length', XOBJ_DTYPE_INT, 0);
		$this->initVar('precise', XOBJ_DTYPE_INT, 0);
		$this->initVar('position', XOBJ_DTYPE_INT, 0);
		$this->initVar('content', XOBJ_DTYPE_TEXT, '', true);
		$this->initVar('required', XOBJ_DTYPE_INT, 0);
		$this->initVar('deleted', XOBJ_DTYPE_STRING, 'N', true, 1);
		$this->initVar('public', XOBJ_DTYPE_INT, 0);
	}
}
class Bmsurvey_QuestionHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmsurvey_question';
	public $mPrimary = 'id';
	public $mClass = 'Bmsurvey_QuestionObject';
	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
}