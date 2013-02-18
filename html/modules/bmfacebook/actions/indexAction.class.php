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

class indexAction extends AbstractAction
{
	private $facebook;
	private $user;
	private $user_profile;
	private $logoutUrl;
	private $loginUrl;

	public function __construct()
	{
		parent::__construct();
		$this->root = XCube_Root::getSingleton();
		// Create our Application instance (replace this with your appId and secret).
		$this->facebook = new Facebook(array(
			'appId'  => $this->root->mContext->mModuleConfig['appId'],
			'secret' => $this->root->mContext->mModuleConfig['secret']
		));
		// Get User ID
		$this->user = $this->facebook->getUser();
		// We may or may not have this data based on whether the user is logged in.
		//
		// If we have a $user id here, it means we know the user is logged into
		// Facebook, but we don't know if the access token is valid. An access
		// token is invalid if the user logged out of Facebook.

		if ($this->user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$this->user_profile = $this->facebook->api('/me');
			} catch (FacebookApiException $e) {
				error_log($e);
				$this->user = NULL;
			}
		}
		// Login or logout url will be needed depending on current user state.
		if ($this->user) {
			$this->logoutUrl = $this->facebook->getLogoutUrl();
		} else {
			$this->loginUrl = $this->facebook->getLoginUrl();
		}

	}
	private function _loginByFaceBook(&$userObject){
		$this->root->mSession->regenerate();
		$_SESSION = array();
		$_SESSION['xoopsUserId'] = $userObject->getVar('uid');
		$_SESSION['xoopsUserGroups'] = $userObject->getGroups();
	}
	private function _checkLogin(){
		$userHandler = xoops_getmodulehandler('users','user');
		$GulHandler = xoops_getmodulehandler('groups_users_link','user');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('email', $this->user_profile['email']));
		$userObjects = $userHandler->getobjects($criteria);
		if ($userObjects){
			// member login
			$this->_loginByFaceBook($userObjects[0]);
		}else{
			// make account
			$uname = substr($this->user_profile['username'],0,16) ."-". dechex(intval(substr($this->user_profile['id'],7,8)));
			$userObject = $userHandler->create();
			$userObject->set('uname',$uname);
			$userObject->set('name',$this->user_profile['name']);
			$userObject->set('email',$this->user_profile['email']);
			$userObject->set('url',$this->user_profile['link']);
			$userObject->set('pass',md5(rand(0,time())));
			$userObject->set('level',1);
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
	}
}
