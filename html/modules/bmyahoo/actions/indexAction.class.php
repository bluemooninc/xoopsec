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

class indexAction extends AbstractAction
{
	private $yconnect;
	private $loginUrl;
	private $userObject;


	public function __construct()
	{
		parent::__construct();
		$this->root = XCube_Root::getSingleton();
	}
	public function execute()
	{
		if(!$this->root->mContext->mXoopsUser){
			// Create our Application instance (replace this with your appId and secret).
			// アプリケーションID, シークレッvト
			//$client_id     = "dj0zaiZpPU1yY1NnQWNmWTREWSZkPVlXazlhMWN4VEc5SU5XTW1jR285TUEtLSZzPWNvbnN1bWVyc2VjcmV0Jng9MTU-";
			//$client_secret = "b5495db6f755de552108dcaa8a329969a979fecf";
			 $this->yconnect = array(
				'appId'  => $this->root->mContext->mModuleConfig['appId'],
				'secret' => $this->root->mContext->mModuleConfig['secret']
			);
			$scope = array(
				OIDConnectScope::OPENID,
				OIDConnectScope::PROFILE,
				OIDConnectScope::EMAIL,
				OIDConnectScope::ADDRESS
			);
			// 各パラメータ初期化
			$redirect_uri = XOOPS_URL . "/modules/bmyahoo/?action=callback";
			// クレデンシャルインスタンス生成
			$cred = new ClientCredential( $this->yconnect['appId'], $this->yconnect['secret'] );
			// YConnectクライアントインスタンス生成
			$client = new YConnectClient( $cred );
			// リクエストとコールバック間の検証用のランダムな文字列を指定してください
			$state = md5(rand());
			// リプレイアタック対策のランダムな文字列を指定してください
			$nonce = "5YOV44Go5aWR57SE44GX44GmSUTljqjjgavjgarjgaPjgabjgog=";
			$response_type = OAuth2ResponseType::CODE_IDTOKEN;
			$display = OIDConnectDisplay::DEFAULT_DISPLAY;
			$prompt = array(
				OIDConnectPrompt::DEFAULT_PROMPT
			);
			// Authorization Codeを取得
			$code_result = $client->getAuthorizationCode( $state );
			if( !$code_result ) {
				$_SESSION['yconnect_state'] = $state;
				/*****************************
				Authorization Request
				 *****************************/
				$getUrl = true;
				// Authorizationエンドポイントにリクエスト
				$this->loginUrl = $client->requestAuth(
					$redirect_uri,
					$state,
					$nonce,
					$response_type,
					$scope,
					$display,
					$prompt,
					$getUrl
				);
			}
		}
	}

	public function executeView(&$render)
	{
		$render->setTemplateName('yahoo_login.html');
		$render->setAttribute('loginUrl', $this->loginUrl);
		$render->setAttribute('userObject',$this->userObject);
	}
}
