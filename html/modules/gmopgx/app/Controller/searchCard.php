<?php
require_once _MY_MODULE_PATH.'app/Model/gmopg.class.php';

class Controller_searchCard extends AbstractAction{
	private $listdata;
	private $params;
	var $viewFullPath;
	var $viewTemplate;
	
	public function setParams($params){
		$this->params=$params;
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
		$render->setAttribute('ListData', $this->listdata);
	}
	/*
	 * Method Section
	*/

	public function index(){
        global $xoopsUser;
        $this->listdata = gmopg::get_listdata($xoopsUser->getVar('uid')."-".$xoopsUser->getVar('uname'));
    }
	public function submit(){
        global $xoopsUser;
        if( isset( $_POST['submit'] ) ){
            $this->listdata = gmopg::get_listdata($xoopsUser->getVar('uid')."-".$xoopsUser->getVar('uname'));
		}
	}
}