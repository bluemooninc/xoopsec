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
	private $userObject;

	public function __construct()
	{
		parent::__construct();
		$this->root = XCube_Root::getSingleton();
	}
	private function _loginByFaceBook(&$userObject){
		$this->root->mSession->regenerate();
		$_SESSION = array();
		$_SESSION['xoopsUserId'] = $userObject->getVar('uid');
		$_SESSION['xoopsUserGroups'] = $userObject->getGroups();
		$this->userObject = $userObject;
	}
	public function execute()
	{
		if(!$this->root->mContext->mXoopsUser){
			// Create our Application instance (replace this with your appId and secret).
			$this->facebook = new Facebook(array(
				'appId'  => $this->root->mContext->mModuleConfig['appId'],
				'secret' => $this->root->mContext->mModuleConfig['secret']
			));
			$permissions = array(
				"scope" => 'email',
				"redirect_uri" => XOOPS_URL . "/modules/bmfacebook/?action=callback"
			);
			$this->loginUrl = $this->facebook->getLoginUrl($permissions);
		}
	}

	public function executeView(&$render)
	{
		$render->setTemplateName('login.html');
		$render->setAttribute('logoutUrl', $this->logoutUrl);
		$render->setAttribute('loginUrl', $this->loginUrl);
		$render->setAttribute('userObject',$this->userObject);
	}
}
