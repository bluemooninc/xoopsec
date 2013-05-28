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
require_once _MY_MODULE_PATH . 'app/View/Question.class.php';
require_once _MY_MODULE_PATH . 'app/Model/Status.class.php';
require_once _MY_MODULE_PATH . 'app/Model/General.class.php';
require_once _MY_MODULE_PATH . 'app/Model/Question.class.php';
require_once _MY_MODULE_PATH . 'app/Model/FormTable.class.php';
include_once _MY_MODULE_PATH . 'app/View/HtmlRender.class.php';


class Controller_Form extends AbstractAction
{
	protected $form_id;
	protected $question_id;
	protected $generalObject;
	protected $questionObjects;
	public function __construct()
	{
		parent::__construct();
		$this->htmlRender = new bmsurveyHtmlRender();
	}
	private function _setFormId(){
		$this->form_id =isset($this->mParams[0]) ? intval($this->mParams[0]) : null;
		if (!$this->form_id && isset($_POST['form_id'])){
			$this->form_id = $this->root->mContext->mRequest->getRequest('form_id');
		}
	}
	public function action_forge(){
		$this->template = 'bmsurvey_webform.html';
		$this->_setFormId();
		$Model_General = Model_General::forge();
		$this->generalObject = $Model_General->getFormObject($this->form_id);
		$Model_Question = Model_Question::forge();
		$this->questionObjects = $Model_Question->getObjectsOnForm($this->form_id);
		$this->contents = array(
			'generalObject' => $this->generalObject,
			'questionObjects' => $this->questionObjects
		);
	}
	public function action_view(){
		$view = new View($this->root);
		$view->setTemplate($this->template);
		$view->set('form_id', $this->form_id);
		$View_Question = View_Question::forge();
		$this->contents = array(
			'general' => $this->generalObject,
			'form' => $View_Question->generatePreview($this->htmlRender,$this->questionObjects)
		);
		$view->set('tpl_vars', $this->contents);
	}
}