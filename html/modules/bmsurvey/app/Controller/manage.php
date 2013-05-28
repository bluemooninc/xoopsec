<?php
/**
 * Created by JetBrains PhpStorm.
 * Copyright (c) : Y.Sakai ( @bluemooninc )
 * Licence : GPL V3
 * Date: 2013/03/17
 * Time: 12:53
 * To change this template use File | Settings | File Templates.
 */
require_once _MY_MODULE_PATH . 'app/View/view.php';
require_once _MY_MODULE_PATH . 'app/View/General.class.php';
require_once _MY_MODULE_PATH . 'app/Model/Status.class.php';
require_once _MY_MODULE_PATH . 'app/Model/General.class.php';
require_once _MY_MODULE_PATH . 'app/Model/FormTable.class.php';
include_once _MY_MODULE_PATH . 'app/View/HtmlRender.class.php';


class Controller_Manage extends AbstractAction
{
	protected $manageObjects;
	protected $tpl_vars;

	public function __construct()
	{
		/*
		** Check XOOPS user
		*/
		parent::__construct();
		if (!$this->root->mContext->mXoopsUser) {
			redirect_header(XOOPS_URL . '/modules/bmsurvey/', 2, _MD_BMSURVEY_CAN_WRITE_USER_ONLY);
			exit();
		}
	}

	private function _setFormId(){
		$this->form_id =isset($this->mParams[0]) ? intval($this->mParams[0]) : null;
		if (!$this->form_id && isset($_POST['form_id'])){
			$this->form_id = $this->root->mContext->mRequest->getRequest('form_id');
		}
	}
	public function action_stop(){
		$this->template = 'bmsurvey_manage.html';
		$Model_General = Model_General::forge();
		$this->form_id = $Model_General->setStatus(intval($this->mParams[0]),'stop');
	}

	public function action_test(){
		$this->template = 'bmsurvey_manage.html';
		$Model_General = Model_General::forge();
		$this->form_id = $Model_General->setStatus(intval($this->mParams[0]),'test');
	}

	public function action_active(){
		$this->template = 'bmsurvey_manage.html';
		$Model_General = Model_General::forge();
		$this->form_id = $Model_General->setStatus(intval($this->mParams[0]),'active');
	}

	public function action_stock(){
		$this->template = 'bmsurvey_manage.html';
		$Model_General = Model_General::forge();
		$this->form_id = $Model_General->setStatus(intval($this->mParams[0]),'stock');
	}

	private function _setControlParameter(){
		/*
		** Get parameter as command.
		*/
		if (count(array_intersect($this->root->mContext->mModuleConfig['MANAGERS'], $this->root->mContext->mXoopsUser->getGroups())) > 0) {
			$is_manager = true;
		}else{
			$is_manager = false;
		}
		$this->manageObjects = array(
			'where' => xoops_getrequest('where'),
			'surveyId' => xoops_getrequest('surveyId'),
			'newid' => xoops_getrequest('newid'),
			'uid' => xoops_getrequest('newid'),
			'is_manager' => $is_manager
		);

	}
	private function _checkPermission($where,$surveyId,$uid,$is_manager,&$xoopsUser){
		/*
		** Permission Check
		** check ACL to see if user is allowed to editForm
		** _this_ form
		*/
		$formTable = new FormTable($surveyId);
		$err = false;

		switch($where){
			case 'new':
				/** @var XoopsUser $xoopsUser  */
				if ( $is_manager == false ) {
					$err = true;
				}
				break;
			case 'download':
				if ( is_object($xoopsUser) === false or $xoopsUser->isAdmin() === false ) {
					$err = true;
				}
				if ( !$formTable->viewbyGroup() ) $err = true;
				break;
			case 'results':
				if ( !$formTable->viewbyGroup() ) $err = true;
				break;
			case 'status':
			case 'access':
			case 'tab':
			case 'purge':
				if ( $formTable->editbyGroup()==false && $uid!=$xoopsUser->uid()) $err = true;
				break;
			case 'copy':
				if ( $formTable->copybyGroup($formTable->uid())==false && $formTable->uid()!=$xoopsUser->uid()) $err = true;
				break;
		}
		if($err==true){
			$xoopsTpl->assign('message', _MD_BMSURVEY_YOU_DONT_HAVE_A_PERMISSION);
			$xoopsOption['template_main'] = 'bmsurvey_message.html';
			include(XOOPS_ROOT_PATH.'/footer.php');
			exit;
		}
	}
	private function _purgeResponse(&$responseObjects){
		$responseBoolHandler = xoops_getmodulehandler('response_bool');
		$responseDateHandler = xoops_getmodulehandler('response_date');
		$responseMultipleHandler = xoops_getmodulehandler('response_multiple');
		$responseOtherHandler = xoops_getmodulehandler('response_other');
		$responseRankHandler = xoops_getmodulehandler('response_rank');
		$responseSingleHandler = xoops_getmodulehandler('response_single');
		$responseTextHandler = xoops_getmodulehandler('response_text');
		foreach($responseObjects as $responseObject){
			$response_id = $responseObject->getVar('id');
			$criteria = new Criteria('response_id',$response_id);
			$responseBoolHandler->deleteAll($criteria,true);
			$responseDateHandler->deleteAll($criteria,true);
			$responseMultipleHandler->deleteAll($criteria,true);
			$responseOtherHandler->deleteAll($criteria,true);
			$responseRankHandler->deleteAll($criteria,true);
			$responseSingleHandler->deleteAll($criteria,true);
			$responseTextHandler->deleteAll($criteria,true);
		}

	}
	public function action_purge()
	{
		$this->template = 'bmsurvey_manage.html';
		$this->_setFormId();
		$Model_Question = Model_Question::forge();
		$choiceHandler = xoops_getmodulehandler('question_choice');
		$responseHandler = xoops_getmodulehandler('response');
		$questionObjects = $Model_Question->getObjectsOnForm($this->form_id);
		$criteria = new Criteria('form_id',$this->form_id);
		$responseObjects = $responseHandler->getObjects($criteria);
		// Delete Respose data
		$this->_purgeResponse($responseObjects);
		// Delete Question Choice data
		foreach($questionObjects as $questionObject){
			$question_id = $questionObject->getVar('id');
			$criteria = new Criteria('question_id',$question_id);
			$choiceHandler->deleteAll($criteria,true);
		}
		// Delete Question
		$Model_Question->deleteAll($this->form_id,true);
		// Delete General
		$generalHandler = xoops_getmodulehandler('form');
		$generalObject = $generalHandler->get($this->form_id);
		$generalHandler->delete($generalObject,true);
	}
	public function action_index()
	{
		$this->template = 'bmsurvey_manage.html';
		$this->_setControlParameter();
		$status = new bmsurveyStatus();
		$editForm = new bmsurveyEditForm();
		$editForm->setFromPost($_POST);
		$this->_checkPermission(
			$this->manageObjects['where'],
			$this->manageObjects['surveyId'],
			$this->manageObjects['uid'],
			$this->manageObjects['is_manager'],
			$this->root->mContext->mXoopsUser
		);
		$myFunction = $this->manageObjects['where'];
		$this->$myFunction($editForm);
	}

	public function action_view()
	{
		$view = new View($this->root);
		$view->setTemplate($this->template);
		$view->set('is_manager', $this->manageObjects['is_manager']);
		$view->set('tab', $this->tab);
		$view->set('tpl_vars', $this->contents);
		$view->set('form_id', $this->form_id);
	}
}