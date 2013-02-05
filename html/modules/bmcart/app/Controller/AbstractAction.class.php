<?php
/* $Id: $ */

if (!defined('XOOPS_ROOT_PATH')) exit();

/**
 * AbstractAction
 */
abstract class AbstractAction {

	// object
	protected $root = null;
	protected $mHandler = null;
	protected $mPagenavi = null;
	protected $mUtility = null;
	protected $mTokenHandler = null;

	// set variable
	protected $mUrl = 'bmcart';
	protected $method_params = null;
	protected $mDirname;
	protected $mControllerName;
	protected $mTemplate;
	protected $mViewFullPath;

	// variable
	protected $mListData;
	protected $select;
	protected $isError = false;
	protected $mErrMsg = "";
	protected $mTicketHidden = '';

	// constant
	protected $PAGENUM = 20;
	protected $TIMUOUT_SUCCESS = 2;
	protected $TIMUOUT_ERROR   = 5;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->root = XCube_Root::getSingleton();
		//$this->mUtility = Acl_Utility::getInstance();
		$this->mTokenHandler = new XoopsMultiTokenHandler();
		if ($this->checkToken()==false) die("Token Error!") ;
		$this->setToken();
	}

//---------------------------------------------------------
// call from main controller
//---------------------------------------------------------


	/**
	 * set Params
	 *
	 * @param array $params
	 * @return none
	 */
	public function setParams($params){
		$this->mParams = $params;
	}

	/**
	 * set ViewFullPath
	 *
	 * @param string $viewFullPath
	 * @return none
	 */
	public function setView( $viewFullPath ){
		$this->mViewFullPath = $viewFullPath;
	}

	/**
	 * set Dirname
	 *
	 * @param string $dirname
	 * @return none
	 */
	public function setDirname($dirname){
		$this->mDirname = $dirname;
	}

	/**
	 * set ControllerName
	 *
	 * @param string $controller_name
	 * @return none
	 */
	public function setControllerName($controllerName){
		$this->mControllerName = $controllerName;
	}

	/**
	 * set DefaultTemplate
	 *
	 * @param string $template
	 * @return none
	 */
	public function setDefaultTemplate($template){
		$this->mTemplate = $template;
	}

	/**
	 * get template
	 *
	 * @param none
	 * @return string template
	 */
	public function getTemplate(){
		return $this->mTemplate;
	}

//-----------------
// public
//-----------------
	/**
	 * get Url(
	 *
	 * @param none
	 * @return string url
	 */
	public function getUrl() {
		return $this->mUrl;
	}

	/**
	 * isError
	 *
	 * @param none
	 * @return boolean isError
	 */
	public function isError() {
		return $this->isError;
	}

	/**
	 * get ErrMsg
	 *
	 * @param none
	 * @return stirng ErrMsg(
	 */
	public function getErrMsg() {
		return $this->mErrMsg;
	}

//-----------------
// protected
//-----------------

	/**
	 * index
	 *
	 * @param none
	 * @return none
	 */
	protected function indexDefault($primaryKey='id') {
		$this->setPageNavi($primaryKey, 'ASC');
	}
	/**
	 * edit
	 *
	 * @param none
	 * @return none
	 */
	protected function editDefault($primaryKey='id') {
		$this->id = intval( $this->mParams[0] );
		if ( $this->id > 0 ){
			$this->setPageNavi($primaryKey, 'ASC');
			$this->mPagenavi->addCriteria(new Criteria($primaryKey, $this->id));
		}
	}
	/**
	 * delete
	 *
	 * @param none
	 * @return none
	 */
	protected function deleteDefault($id=null) {
		$this->id = is_null($id) ? intval( $this->getRequest('id') ) : intval($id);
		if ( $this->id > 0 ){
			$this->mHandler->delete($this->id);
			$this->executeRedirect($this->mUrl, $this->TIMUOUT_SUCCESS, 'DELETED');
		}
	}
	/**
	 * set PageNavi
	 *
	 * @param string $sortName
	 * @param string $sortIndex
	 * @return none
	 */
	protected function setPageNaviDefault($sortName, $sortIndex){
		$class = $this->getPagenaviClass();
		$this->mPagenavi = new $class($this->mHandler);
		$this->mPagenavi->setPagenum($this->PAGENUM);
		$this->mPagenavi->setUrl($this->mUrl);
		$this->mPagenavi->addSort($sortName,$sortIndex);
		$this->mPagenavi->fetch();
	}
	protected function getPagenaviClass(){
		// Acl_PageNavi
		return ucwords($this->mDirname).'_PageNavi';
	}

	protected function setModel($modelName){
		$this->mHandler = xoops_getmodulehandler($modelName);
	}
	/*protected function setTemplate($controllerName){
		$this->mTemplate = $this->mDirname.'_'.$this->mControllerName.'_'.$controllerName . '.html';
	}*/
	protected function setUrl($url) {
		$this->mUrl = $url;
	}
	protected function getRequest( $key ) {
		return $this->root->mContext->mRequest->getRequest( $key );
	}
	protected function setToken( $name='bmcart', $timeout=0 ) {
		$ticket = $this->mTokenHandler->create($name,$timeout);
		$this->mTicketHidden = $ticket->getHtml();
		return $this->mTicketHidden;
	}

	/**
	 * @param string $name
	 * @return null
	 */
	protected function checkToken( $name='bmcart') {
		$keys = array_keys($_POST);
		$token = preg_grep("/^XOOPS_TOKEN_(.*)/", $keys);
		if ($token){
			$ret = $this->mTokenHandler->autoValidate($name);
			return $ret;
		}
		return true;
	}
	protected function executeRedirect( $url, $timeout, $msg ) {
		$this->root->mController->executeRedirect( $url, $timeout, $msg );
	}
	protected function setErr($msg) {
		$this->isError = true;
		$this->mErrMsg = $msg;
	}
}

?>