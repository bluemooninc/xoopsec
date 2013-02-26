<?php
/*
 * B.M.facebook - facebook Module on XOOPS Cube v2.2 / PHP5.3 or later
 * Copyright (c) Bluemoon inc. 2013 All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
require './class/facebook.php';
require './kernel/MyPageNavi.class.php';

class callbackAction extends AbstractAction
{
	private $facebook;
	private $user;
	private $user_profile;
	private $logoutUrl;
	private $loginUrl;
	private $userObject;

	public function __construct()
	{
		parent::__construct();
		$this->root = XCube_Root::getSingleton();
		// Create our Application instance (replace this with your appId and secret).
		$appId = $this->root->mContext->mModuleConfig['appId'];
		$secret = $this->root->mContext->mModuleConfig['secret'];
		$this->facebook = new Facebook( array( 'appId'  => $appId, 'secret' => $secret ) );

		// We may or may not have this data based on whether the user is logged in.
		//
		// If we have a $user id here, it means we know the user is logged into
		// Facebook, but we don't know if the access token is valid. An access
		// token is invalid if the user logged out of Facebook.
		//$callBackUrl = XOOPS_URL . "/modules/bmfacebook/?action=callback";
		//$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.
		//	$appId . '&redirect_uri=' . urlencode($callBackUrl) . '&client_secret='.
		//	$secret . '&code=' . $code;

		if (isset($_SESSION['accessToken'])){
			$this->facebook->setAccessToken($_SESSION['accessToken']);
		}else{
			$code = $_REQUEST["code"];
			if($code){
				$_SESSION['accessToken'] = $this->facebook->getAccessToken();
			}
		}
		// Get User ID
		$this->user = $this->facebook->getUser();

		//$this->userProfile = $this->facebook->api('/me/accounts');

		if ($this->user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$this->user_profile = $this->facebook->api('/me');
			} catch (FacebookApiException $e) {
				$this->user = NULL;
				$login_url = $this->facebook->getLoginUrl();
				echo 'Please <a href="' . $login_url . '">login.</a>';
				echo $e->getType();
				echo $e->getMessage();
				die;
			}
		}
	}
	private function _loginByFaceBook(&$userObject){
		$this->root->mSession->regenerate();
		$_SESSION = array();
		$_SESSION['xoopsUserId'] = $userObject->getVar('uid');
		$_SESSION['xoopsUserGroups'] = $userObject->getGroups();
		$this->userObject = $userObject;
	}
	private function _makeUserName(){
		$name_prefix = substr($this->user_profile['first_name'],0,1) . $this->user_profile['last_name'];
		$name_postfix = dechex(intval(substr($this->user_profile['id'],7,8)));
		return substr($name_prefix,0,16) ."-". $name_postfix;
	}
	private function _checkUser(&$userHandler,$name,$value){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria($name,$value));
		$userObjects = $userHandler->getobjects($criteria);
		if ($userObjects){
			return $userObjects[0];
		}
	}
	private function _checkLogin(){
		$userHandler = xoops_getmodulehandler('users','user');
		$GulHandler = xoops_getmodulehandler('groups_users_link','user');
		$userObject = $this->_checkUser($userHandler,'user_facebook',$this->user_profile['id']);
		if(!$userObject){
			$userObject = $this->_checkUser($userHandler,'email',$this->user_profile['email']);
			if($userObject){
				$userObject->set('user_facebook',$this->user_profile['id']);
				$userHandler->insert($userObject,true);
			}
		}
		if($userObject){
			// member login
			$this->_loginByFaceBook($userObject);
		}else{
			// make account
			$uname = $this->_makeUserName();
			$userObject = $userHandler->create();
			$userObject->set('uname',$uname);
			$userObject->set('user_facebook',$this->user_profile['id']);
			$userObject->set('name',$this->user_profile['name']);
			$userObject->set('email',$this->user_profile['email']);
			$userObject->set('url',$this->user_profile['link']);
			$userObject->set('pass',md5(rand(0,time())));
			$userObject->set('level',1);
			$userObject->set('timezone_offset',$this->user_profile['timezone']);
			$ret = $userHandler->insert($userObject,true);
			if($ret){
				$uid = $userHandler->db->getInsertId();
				$GulObject = $GulHandler->create();
				$GulObject->set("groupid",$this->root->mContext->mModuleConfig['defaultGroup']);
				$GulObject->set("uid",$uid);
				$GulHandler->insert($GulObject,true);
				$this->_loginByFaceBook($userObject);
			}
		}
	}
	public function execute()
	{
		if(!$this->root->mContext->mXoopsUser){
			$this->_checkLogin();
		}
	}

	public function executeView(&$render)
	{
		$render->setTemplateName('login.html');
		//$render->setAttribute('pageNavi', $this->mPagenavi->mNavi);
		$render->setAttribute('user', $this->user);
		$render->setAttribute('user_profile', $this->user_profile);
		$render->setAttribute('logoutUrl', $this->logoutUrl);
		$render->setAttribute('loginUrl', $this->loginUrl);
		$render->setAttribute('userObject',$this->userObject);
	}
}
