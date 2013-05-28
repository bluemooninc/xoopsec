<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

if (!defined('XOOPS_ROOT_PATH')) exit();
class Bmsurvey_Question_choiceObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('id', XOBJ_DTYPE_INT, 0);
		$this->initVar('question_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('content', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('value', XOBJ_DTYPE_TEXT, '', false);
	}
}
class Bmsurvey_Question_choiceHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmsurvey_question_choice';
	public $mPrimary = 'id';
	public $mClass = 'Bmsurvey_Question_choiceObject';
	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}
}