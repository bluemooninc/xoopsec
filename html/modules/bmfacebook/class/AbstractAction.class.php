<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
define('_USE_XOOPSMAILER', false);

abstract class AbstractAction
{
  protected $isError = false;
  protected $errMsg = "";
  protected $root;
  protected $url = 'index.php';
  protected $unamelink = array();
  
  public function __construct()
  {
    $this->root = XCube_Root::getSingleton();
  }
  
  protected function setUrl($url)
  {
    $this->url = $url;
  }
  
  public function getUrl()
  {
    return $this->url;
  }
  
  protected function setErr($msg)
  {
    $this->isError = true;
    $this->errMsg = $msg;
  }
  
  public function getisError()
  {
    return $this->isError;
  }
  
  public function geterrMsg()
  {
    return $this->errMsg;
  }
  
  public function getSettings($uid = 0)
  {
    if ( $uid == 0 ) {
      $uid = $this->root->mContext->mXoopsUser->get('uid');
    }
    
    $modHand = xoops_getmodulehandler('settings', _MY_DIRNAME);
    $modObj = $modHand->get($uid);
    if ( !is_object($modObj) ) {
      $modObj = $modHand->create();
      $modObj->set('uid', $uid);
    }
    return $modObj;
  }
  
  abstract public function execute();
  abstract public function executeView(&$render);
}
?>
