<?php
/*
* GMO-PG - Payment Module as XOOPS Cube Module
* Copyright (c) Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
* GPL V3 licence
 */
require_once _MY_MODULE_PATH.'app/Model/gmopg.class.php';

class Controller_SaveCard extends AbstractAction{
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
		$root = XCube_Root::getSingleton();

		$render->setTemplateName($this->viewTemplate);
		$render->setAttribute('ListData', $this->listdata);
		if ($this->mPagenavi){
			$render->setAttribute('pageNavi', $this->mPagenavi->mNavi);
		}
		$render->setAttribute('select', $this->select);
		$render->setAttribute('subject', $this->subject);
		$render->setAttribute('status', $this->status);
		$render->setAttribute('message', $this->_gmopg->get_message());
		$render->setAttribute('return_url',
			XOOPS_URL . "/modules/" . $root->mContext->mModuleConfig['PGCARD_RETURN_URL']
		);
	}
	/*
	 * Method Section
	*/
	public function index(){
	}

	public function submit(){
		if( $_POST['method'] == "submit" ){
			// use XCL_Service
			$this->_gmopg->saveCardInformation();
		}
	}
}