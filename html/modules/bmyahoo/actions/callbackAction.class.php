<?php
/*
 * B.M.yconnect - yconnect Module on XOOPS Cube v2.2 / PHP5.3 or later
 * Copyright (c) Bluemoon inc. 2013 All rights reserved.
 * Author : Yoshi Sakai (http://bluemooninc.jp)
 * Licence : GPL V3 licence
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
// YConnectライブラリ読み込み
require './class/YConnect.inc';
require './kernel/MyPageNavi.class.php';

class callbackAction extends AbstractAction
{
	private $yconnect;
	private $user_profile;
	private $login=false;
	private $userObject;

	public function __construct()
	{
		parent::__construct();
		$this->root = XCube_Root::getSingleton();

		// Create our Application instance (replace this with your appId and secret).
		$this->yconnect = array(
			'appId'  => $this->root->mContext->mModuleConfig['appId'],
			'secret' => $this->root->mContext->mModuleConfig['secret']
		);

		// 各パラメータ初期化
		$redirect_uri = XOOPS_URL . "/modules/bmyahoo/?action=callback";
		// クレデンシャルインスタンス生成
		$cred = new ClientCredential( $this->yconnect['appId'], $this->yconnect['secret'] );
		// YConnectクライアントインスタンス生成
		$client = new YConnectClient( $cred );
		// リクエストとコールバック間の検証用のランダムな文字列を指定してください
		$state = xoops_getrequest('state');
		// リプレイアタック対策のランダムな文字列を指定してください
		$nonce = "5YOV44Go5aWR57SE44GX44GmSUTljqjjgavjgarjgaPjgabjgog=";
		// Authorization Codeを取得
		if ($_SESSION['yconnect_state']!=$state) die("Got state error orz;".$_SESSION['yconnect_state']);
		$code_result = $client->getAuthorizationCode( $state );
		if( !$code_result ) {
			die("Got state error orz;".$_SESSION['yconnect_state']);
		}
		/****************************
		Access Token Request
		 ****************************/
		// Tokenエンドポイントにリクエスト
		$client->requestAccessToken(
			$redirect_uri,
			$code_result
		);

		/*****************************
		Verification ID Token
		 *****************************/
		// IDトークンを検証
		$client->verifyIdToken( $nonce );

		/************************
		UserInfo Request
		 ************************/
		// UserInfoエンドポイントにリクエスト
		$client->requestUserInfo( $client->getAccessToken() );
		$client->verifyIdToken( $nonce );
		$this->user_profile = $client->getUserInfo();
		/******************************
		Set Token for next some process
		 *****************************/
		$code = $_REQUEST["code"];
		if($code){
			$_SESSION['yconnect_token'] = array(
				'accessToken' => $client->getRefreshToken(),
				'expiration' => $client->getAccessTokenExpiration()
			);
		}
	}
	private function _loginByyconnect(&$userObject){
		$this->root->mSession->regenerate();
		//$_SESSION = array();
		$_SESSION['xoopsUserId'] = $userObject->getVar('uid');
		$_SESSION['xoopsUserGroups'] = $userObject->getGroups();
		$this->userObject = $userObject;
		$this->login = true;
	}
	private function _makeUserName(){
		$name_prefix = substr($this->user_profile['given_name'],0,1) . $this->user_profile['family_name'];
		if ($name_prefix==""){
			list($username,$domain) = explode('@',$this->user_profile['email']);
			$name_prefix = $username;
		}
		$name_postfix = dechex(intval(substr($this->user_profile['user_id'],7,8)));
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
		$userObject = $this->_checkUser($userHandler,'user_yconnect',$this->user_profile['user_id']);
		if(!$userObject){
			$userObject = $this->_checkUser($userHandler,'email',$this->user_profile['email']);
			if($userObject){
				$userObject->set('user_yconnect',$this->user_profile['user_id']);
				$userHandler->insert($userObject,true);
			}
		}
		if($userObject){
			// member login
			$this->_loginByyconnect($userObject);
		}else{
			// make account
			$uname = $this->_makeUserName();
			$userObject = $userHandler->create();
			$userObject->set('uname',$uname);
			$userObject->set('user_yconnect',$this->user_profile['user_id']);
			$userObject->set('name',$this->user_profile['name']);
			$userObject->set('email',$this->user_profile['email']);
			$userObject->set('pass',md5(rand(0,time())));
			$userObject->set('level',1);
			$userObject->set('timezone_offset',9);
			$ret = $userHandler->insert($userObject,true);
			if($ret){
				$uid = $userHandler->db->getInsertId();
				$GulObject = $GulHandler->create();
				$GulObject->set("groupid",$this->root->mContext->mModuleConfig['defaultGroup']);
				$GulObject->set("uid",$uid);
				$GulHandler->insert($GulObject,true);
				$this->_loginByyconnect($userObject);
			}
		}
		if ($userObject) return true;
	}
	public function execute()
	{
		if(!$this->root->mContext->mXoopsUser){
			if ($this->_checkLogin()){
				redirect_header(XOOPS_URL,3,"Login by Yahoo ID!");
			}
		}
	}

	public function executeView(&$render)
	{
	}
}
