<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once _MY_MODULE_PATH.'app/Model/MyPageNavi.class.php';

class Controller_index extends AbstractAction{
	private $listdata;
	private $mPagenavi = null;
	private $select;
	private $subject = "";
	private $status = "";
	private $pagenum = 20;
	private $mName = 'payment';
	private $params;
	var $viewFullPath;
	var $viewTemplate;
	public function setParams($params){
		$this->params=$params;
	}
	private function setPageNavi($sortName, $sortIndex){
		$this->mPagenavi = new MyPageNavi($this->mHandler);
		$this->mPagenavi->setUrl($this->url);
		$this->mPagenavi->setPagenum($this->pagenum);
		$this->mPagenavi->addSort($sortName,$sortIndex);
		$this->mPagenavi->addCriteria(new Criteria('uid', $this->root->mContext->mXoopsUser->get('uid')));
		$this->mPagenavi->fetch();
	}
	public function setTemplate($controllerName){
		if (is_null($this->viewTemplate)) $this->viewTemplate = $controllerName . ".html";
	}
	public function template(){
		return $this->viewTemplate;
	}
	public function setView($viewFullPath){
		$this->viewFullPath = $viewFullPath;
	}
	public function executeView(&$render){
		$render->setTemplateName($this->viewTemplate);
	    $render->setAttribute('ListData', $this->listdata);
	    if ($this->mPagenavi){
	    	$render->setAttribute('pageNavi', $this->mPagenavi->mNavi);
	    }
	    $render->setAttribute('select', $this->select);
	    $render->setAttribute('subject', $this->subject);
	    $render->setAttribute('status', $this->status);
	    $headerScript = $this->root->mContext->getAttribute('headerScript');
	    $headerScript->addStylesheet(_MY_MODULE_URL.'/style.css');
	}
	/*
	 * Method Section
	 */
	public function index() {
		model::setTable($this->mName);
		$this->setPageNavi('utime', 'DESC');
		$this->getModObj();
	}
	public function search() {
		model::setTable($this->mName);
		$this->setPageNavi('utime', 'DESC');
		$this->subject = $this->root->mContext->mRequest->getRequest('subject');
		if ( $this->subject != "" ) {
			$this->mPagenavi->addCriteria(new Criteria('title', '%'.$this->subject.'%', 'LIKE'));
		}
		$this->status = $this->root->mContext->mRequest->getRequest('status');
		if ( $this->status !== "" ) {
			$this->status = intval($this->status);
			$this->mPagenavi->addCriteria(new Criteria('status', $this->status));
		}
		$this->getModObj();
		$this->setTemplate("index");
	}
	public function detail() {
		model::setTable($this->mName);
		$this->setPageNavi('utime', 'DESC');
		$this->id = intval($this->params);
		$this->mPagenavi->addCriteria(new Criteria('id', $this->id));
		$this->getModObj($this->id);
	}
	public function edit() {
		model::setTable($this->mName);
		$uid = $this->root->mContext->mXoopsUser->get('uid');
		$this->id = $this->root->mContext->mRequest->getRequest('id');
		$title = $this->root->mContext->mRequest->getRequest('PME_data_title');
		$message = $this->root->mContext->mRequest->getRequest('PME_data_message');
		if ($this->id && $uid){
			$this->setPageNavi('utime', 'DESC');
			$this->mPagenavi->addCriteria(new Criteria('id', $this->id));
			$this->getModObj($this->id);
		}
	}
	public function update() {
		model::setTable($this->mName);
		$uid = $this->root->mContext->mXoopsUser->get('uid');
		$this->id = $this->root->mContext->mRequest->getRequest('id');
		$title = $this->root->mContext->mRequest->getRequest('PME_data_title');
		$message = $this->root->mContext->mRequest->getRequest('PME_data_message');
		if ($this->id){
			$this->setPageNavi('utime', 'DESC');
			$this->mPagenavi->addCriteria(new Criteria('id', $this->id));
			$this->mHandler->update($this->id,$title,$message);
			$this->getModObj($this->id);
			$this->setTemplate("edit");
		}else{
			$ret = $this->mHandler->addNew($uid,$title,$message);
  		    $this->root->mController->executeRedirect($this->url, 2, "UPDATE");
		}
	}
	public function delete() {
		model::setTable($this->mName);
		$uid = $this->root->mContext->mXoopsUser->get('uid');
		$this->id = $this->root->mContext->mRequest->getRequest('id');
		if ($this->id && $uid){
			$this->mHandler->delete($this->id,$uid);
  		    $this->root->mController->executeRedirect($this->url, 2, "DELETED");
		}
	}
	public function mp3(){
		header('Content-Type: audio/x-mpegurl');
		echo XOOPS_URL.'/uploads/0.mp3';
		die;	
	}
    private function getModObj($id=null){
        if (!is_null($id)){
            $this->mPagenavi->addCriteria(new Criteria('id', intval($id)));
        }
        $this->select = $this->mHandler->getDefaultList($this->root->mContext->mXoopsUser->get('uid'),$id);
        $modObj = $this->mHandler->getObjects($this->mPagenavi->getCriteria());
        foreach ($modObj as $key => $val) {
            foreach ( array_keys($val->gets()) as $var_name ) {
                $item_ary[$var_name] = $val->getShow($var_name);
            }
            if (!is_null($id)){
                $this->listdata = $item_ary;
            }else{
                $this->listdata[] = $item_ary;
            }
            unset($item_ary);
        }

    }
}