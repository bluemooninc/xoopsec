<?php
/*
* GMO-PG - Payment Module as XOOPS Cube Module
* Copyright (c) Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
* GPL V3 licence
 */
require_once _MY_MODULE_PATH.'app/Model/gmopg.class.php';

class Controller_MemberSave extends AbstractAction{
	private $params;
	var $viewFullPath;
	var $viewTemplate;
	protected $_gmopg;

	public function setParams($params){
		$this->params=$params;
		$this->_gmopg = new gmopg();
	}
	public function setTemplate($controllerName){
		if (is_null($this->viewTemplate)) $this->viewTemplate = $controllerName . ".html";
	}
	public function setView($viewFullPath){
		$this->viewFullPath = $viewFullPath;
	}
	public function template(){
		return $this->viewTemplate;
	}
	public function executeView(&$render){
		$render->setTemplateName($this->viewTemplate);
		$render->setAttribute('message', $this->_gmopg->get_message());
	}
	/*
	 * Method Section
	*/
	public function index(){
	}
	public function submit(){
		$this->_gmopg->saveMemberShip();
	}
}