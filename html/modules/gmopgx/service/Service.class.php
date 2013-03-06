<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once(XOOPS_ROOT_PATH . '/modules/gmopgx/class/ErrorMessageHandler.php');

class Gmopgx_Service extends XCube_Service
{
	protected $comdir;
	public $mServiceName = 'Gmopgx_Service';
	public $mNameSpace = 'Gmopgx';
	public $mClassName = 'Gmopgx_Service';
	function __construct(){
		$this->comdir = XOOPS_ROOT_PATH . "/modules/gmopgx/vendor/gpay_client/src/";
	}
	public function prepare()
	{
		$this->addFunction(S_PUBLIC_FUNC('int checkOrderStatus(int orderId)'));
		$this->addFunction(S_PUBLIC_FUNC('int execTranByModule(int orderId,int uid)'));
		$this->addFunction(S_PUBLIC_FUNC('int saveMemberShip()'));
		$this->addFunction(S_PUBLIC_FUNC('int saveCardInformation()'));
		$this->addFunction(S_PUBLIC_FUNC('array getRegisteredCardList()'));
		$this->addFunction(S_PUBLIC_FUNC('int entryTransit(int order_id,int CardSeq,int amount, int tax'));
	}

	public function checkOrderStatus()
	{
		$ret = FALSE;
		$root = XCube_Root::getSingleton();
		$orderId = $root->mContext->mRequest->getRequest('orderId');
		if ($root->mContext->mUser->isInRole('Site.RegisteredUser')) {
			$uid = $root->mContext->mXoopsUser->get('uid');
			$modHand = xoops_getmodulehandler('payment', 'gmopgx');
			$myrow = $modHand->getDataById($uid, $orderId);
			if ($myrow) {
				if ($myrow['status'] == 1) $ret = TRUE;
			}
		}
		return $ret;
	}

	/**
	 * 決済実行API
	 * 決済を実行し、成功すれば true を返す
	 * @return bool
	 */
	public function execTranByModule()
	{
		$ret = FALSE;
		$root = XCube_Root::getSingleton();
		$orderId = $root->mContext->mRequest->getRequest('orderId');
		$uid = $root->mContext->mRequest->getRequest('uid');
		if ($root->mContext->mUser->isInRole('Site.RegisteredUser')) {
			$modHand = xoops_getmodulehandler('payment', 'gmopgx');
			$objects = $modHand->getByOrderId($uid, $orderId, 0);
			if (count($objects) > 0) {
				$object = $objects[0];
				$cardSeq = $object->getVar('cardSeq');
				$accessId = $object->getVar('accessId');
				$accessPass = $object->getVar('accessPass');
				$ret = $this->_execTransit($orderId, $uid, $cardSeq, $accessId, $accessPass);
				if ($ret) {
					$object->set('utime', time());
					$object->set('status', 1);
					$modHand->insert($object);
				}
			}
		}
		return $ret;
	}

	/**
	 * memberId = uid + uname
	 * @param $root
	 * @return string
	 */
	private function _getMemberId(&$root)
	{
		return $root->mContext->mXoopsUser->get('uid') . "-" . $root->mContext->mXoopsUser->get('uname');
	}

	private function _getMemberIdByUid($uid)
	{
		$user = new XoopsUser($uid);
		return $uid . "-" . $user->getVar('uname');
	}

	public function &getRegisteredCardList()
	{
		require_once($this->comdir.'com/gmo_pg/client/input/SearchCardInput.php');
		require_once($this->comdir.'com/gmo_pg/client/tran/SearchCard.php');

		$root = XCube_Root::getSingleton();
		$memberId = $this->_getMemberId($root);
		$root->mController->setupModuleContext('gmopgx');
		$myModuleConfig = $root->mContext->mModuleConfig;

		//入力パラメータクラスをインスタンス化します
		$input = new SearchCardInput();

		//サイトID・パスワード
		$input->setSiteId($myModuleConfig['PGCARD_SITE_ID']);
		$input->setSitePass($myModuleConfig['PGCARD_SITE_PASS']);

		//会員IDは必須です
		$input->setMemberId($memberId);

		//カード登録連番が指定された場合、パラメータに設定します。
		if (isset($_POST['CardSeq'])) {
			$cardSeq = $root->mContext->mRequest->getRequest('CardSeq');
			$seqMode = $root->mContext->mRequest->getRequest('SeqMode');
			if (0 < strlen($cardSeq)) {
				//登録カード連番
				$input->setCardSeq($cardSeq);
				$input->setSeqMode($seqMode);
			}
		}
		//API通信クラスをインスタンス化します
		$exe = new SearchCard();

		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec($input);
		$cardList = array();

		//実行後、その結果を確認します。
		if ($exe->isExceptionOccured()) {
			//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			$this->error_message = "Connection ERROR!";
			return $cardList;
		} else {
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			if ($output->isErrorOccurred()) { //出力パラメータにエラーコードが含まれていないか、チェックしています。
				$errorHandle = new ErrorHandler();
				$errorList = $output->getErrList();
				$this->error_message = "";
				foreach ($errorList as $errorInfo) {
					/* @var $errorInfo ErrHolder */
					$this->error_message .= '<li>'
						. $errorInfo->getErrCode()
						. ':' . $errorInfo->getErrInfo()
						. ':' . $errorHandle->getMessage($errorInfo->getErrInfo())
						. '</li>';
				}
				//echo $myModuleConfig['PGCARD_SITE_ID'].$memberId;
				//echo $this->error_message; die;
				return $cardList;
			}
			//例外発生せず、エラーの戻りもないので、正常とみなします。
			//このif文を抜けて、結果を表示します。
		}
		$cardList = $output->getCardList();
		return $cardList;
	}

	public function entryTransit()
	{
		require_once($this->comdir.'com/gmo_pg/client/input/EntryTranInput.php');
		require_once($this->comdir.'com/gmo_pg/client/tran/EntryTran.php');

		$root = XCube_Root::getSingleton();
		$memberId = $this->_getMemberId($root);
		$root->mController->setupModuleContext('gmopgx');
		$myModuleConfig = $root->mContext->mModuleConfig;

		//$orderId = intval($root->mContext->mRequest->getRequest('order_id']);
		$orderId = $root->mContext->mRequest->getRequest('order_id');
		$cardSeq = $root->mContext->mRequest->getRequest('cardSeq');
		$amount = $root->mContext->mRequest->getRequest('amount');
		$tax = $root->mContext->mRequest->getRequest('tax');

		//入力パラメータクラスをインスタンス化します
		$input = new EntryTranInput();
		/* @var $input EntryTranInput */

		//このサンプルでは、ショップID・パスワードはコンフィグファイルで
		//定数defineしています。
		$input->setShopId($myModuleConfig['PGCARD_SHOP_ID']);
		$input->setShopPass($myModuleConfig['PGCARD_SHOP_PASS']);

		//各種パラメータを設定しています。
		//実際には、処理区分や利用金額、オーダーIDといったパラメータをカード所有者が直接入力することは無く、
		//購買内容を元に加盟店様システムで生成した値が設定されるものと思います。
		$input->setJobCd('AUTH'); //$root->mContext->mRequest->getRequest('JobCd']
		$input->setOrderId($orderId);
		$input->setItemCode(NULL); // カード会社との間の契約にて使用する商品コードが決められた場合のみ入力
		$input->setAmount(intval($amount));
		$input->setTax(intval($tax));
		$input->setTdFlag(NULL); //intval($root->mContext->mRequest->getRequest('TdFlag']);
		$input->setTdTenantName(NULL); //$root->mContext->mRequest->getRequest('TdTenantName']

		//API通信クラスをインスタンス化します
		$exe = new EntryTran();
		/* @var $exec EntryTran */

		//パラメータオブジェクトを引数に、実行メソッドを呼び、結果を受け取ります。
		$output = $exe->exec($input);
		/* @var $output EntryTranOutput */

		//実行後、その結果を確認します。

		if ($exe->isExceptionOccured()) { //取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。

			$this->root->mController->executeRedirect(XOOPS_URL, 5, "Connection ERROR!");
			//サンプルでは、例外メッセージを表示して終了します。

			require_once(PGCARD_SAMPLE_BASE . '/display/Exception.php');
			exit();

		} else {
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			if ($output->isErrorOccurred()) { //出力パラメータにエラーコードが含まれていないか、チェックしています。
				$errorHandle = new ErrorHandler();
				$errorList = $output->getErrList();
				$this->emsg = "";
				foreach ($errorList as $errorInfo) {
					/* @var $errorInfo ErrHolder */
					$this->emsg .= '<li>'
						. $errorInfo->getErrCode()
						. ':' . $errorInfo->getErrInfo()
						. ':' . $errorHandle->getMessage($errorInfo->getErrInfo())
						. '</li>';

				}
				$root->mController->executeRedirect(XOOPS_URL, 5, $this->emsg);

				//サンプルでは、エラーが発生していた場合、エラー画面を表示して終了します。
				require_once(PGCARD_SAMPLE_BASE . '/display/Error.php');
				exit();

			}
			//例外発生せず、エラーの戻りもないので、正常とみなします。
			$myHandler = xoops_getmodulehandler('payment', 'gmopgx');
			$object = $myHandler->create();
			$object->set('uid', $memberId);
			$object->set('orderId', htmlspecialchars($orderId, ENT_QUOTES, _CHARSET));
			$object->set('amount', intval($amount));
			$object->set('tax', intval($tax));
			$object->set('accessId', $output->getAccessId());
			$object->set('accessPass', $output->getAccessPass());
			$object->set('cardSeq', $cardSeq);
			$myHandler->insert($object);
			//このif文を抜けて、結果を表示します。
			return TRUE;
		}
	}

	/**
	 * @param $orderId
	 * @param $uid
	 * @param $cardSeq
	 * @param $accessId
	 * @param $accessPass
	 * @param string $paymentMethod
	 * @return bool
	 */
	private function _execTransit($orderId, $uid, $cardSeq, $accessId, $accessPass, $paymentMethod = '1')
	{
		require_once($this->comdir.'com/gmo_pg/client/input/ExecTranInput.php');
		require_once($this->comdir.'com/gmo_pg/client/tran/ExecTran.php');

		$root = XCube_Root::getSingleton();
		$memberId = $this->_getMemberIdByUid($uid);
		$root->mController->setupModuleContext('gmopgx');
		$myModuleConfig = $root->mContext->mModuleConfig;

		//入力パラメータクラスをインスタンス化します
		$input = new ExecTranInput();

		//カード番号入力型・会員ID決済型に共通する値です。
		$input->setAccessId($accessId);
		$input->setAccessPass($accessPass);
		$input->setOrderId($orderId);

		//支払方法に応じて、支払回数のセット要否が異なります。
		$input->setMethod($paymentMethod); // デフォルトは一括払い

		//このサンプルでは、加盟店自由項目１～３を全て利用していますが、これらの項目は任意項目です。
		//利用しない場合、設定する必要はありません。
		//また、加盟店自由項目に２バイトコードを設定する場合、SJISに変換して設定してください。
		/*
		$input->setClientField1( mb_convert_encoding( $root->mContext->mRequest->getRequest('ClientField1'] , 'SJIS' , _CHARSET ) );
		$input->setClientField2( mb_convert_encoding( $root->mContext->mRequest->getRequest('ClientField2'] , 'SJIS' , _CHARSET ) );
		$input->setClientField3( mb_convert_encoding( $root->mContext->mRequest->getRequest('ClientField3'] , 'SJIS' , _CHARSET ) );
		*/
		//HTTP_ACCEPT,HTTP_USER_AGENTは、3Dセキュアサービスをご利用の場合のみ必要な項目です。
		//Entryで3D利用フラグをオンに設定した場合のみ、設定してください。
		//設定する場合、カード所有者のブラウザから送信されたリクエストヘッダの値を、無加工で
		//設定してください。
		$input->setHttpUserAgent($_SERVER['HTTP_USER_AGENT']);
		$input->setHttpAccept($_SERVER['HTTP_ACCEPT']);

		//ここから、カード番号入力型決済と会員ID型決済それぞれの場合で
		//異なるパラメータを設定します。

		if (0 < strlen($memberId)) { //会員ID決済
			//サンプルでは、サイトID・サイトパスワードはコンスタント定義しています。
			$input->setSiteId($myModuleConfig['PGCARD_SITE_ID']);
			$input->setSitePass($myModuleConfig['PGCARD_SITE_PASS']);
			//会員IDは必須です。
			$input->setMemberId($memberId);
			//登録カード連番は任意です。
			$input->setCardSeq($cardSeq);
		}
		//API通信クラスをインスタンス化します
		$exe = new ExecTran();

		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec($input);
		//実行後、その結果を確認します。
		if ($exe->isExceptionOccured()) { //取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			$this->root->mController->executeRedirect(XOOPS_URL, 5, "Connection ERROR!");
		} else {
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			if ($output->isErrorOccurred()) { //出力パラメータにエラーコードが含まれていないか、チェックしています。
				$errorHandle = new ErrorHandler();
				$errorList = $output->getErrList();
				$this->emsg = "";
				foreach ($errorList as $errorInfo) {
					/* @var $errorInfo ErrHolder */
					$this->emsg .= '<li>'
						. $errorInfo->getErrCode()
						. ':' . $errorInfo->getErrInfo()
						. ':' . $errorHandle->getMessage($errorInfo->getErrInfo())
						. '</li>';

				}
				$this->root->mController->executeRedirect(XOOPS_URL, 10, $this->emsg);
			} else if ($output->isTdSecure()) { //決済実行の場合、3Dセキュアフラグをチェックします。
				//3Dセキュアフラグがオンである場合、リダイレクトページを表示する必要があります。
				//サンプルでは、モジュールタイプに標準添付されるリダイレクトユーティリティを利用しています。
				//リダイレクト用パラメータをインスタンス化して、パラメータを設定します
				require_once($this->comdir.'com/gmo_pg/client/input/AcsParam.php');
				require_once($this->comdir.'com/gmo_pg/client/common/RedirectUtil.php');
				$redirectInput = new AcsParam();
				$redirectInput->setAcsUrl($output->getAcsUrl());
				$redirectInput->setMd(model::get('accessId'));
				$redirectInput->setPaReq($output->getPaReq());
				$redirectInput->setTermUrl(PGCARD_SAMPLE_URL . '/SecureTran.php');
				//リダイレクトページ表示クラスをインスタンス化して実行します。
				$redirectShow = new RedirectUtil();
				print ($redirectShow->createRedirectPage(PGCARD_SECURE_RIDIRECT_HTML, $redirectInput));
				exit();
			}
			//例外発生せず、エラーの戻りもなく、3Dセキュアフラグもオフであるので、実行結果を表示します。
			return TRUE;
		}
	}
}