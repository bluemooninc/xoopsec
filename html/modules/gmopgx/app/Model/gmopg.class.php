<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/07/23
 * Time: 23:16
 * To change this template use File | Settings | File Templates.
 */

$comdir = _MY_MODULE_PATH . "/vendor/gpay_client/src/";
set_include_path($comdir);

class gmopg
{
	protected $root;
	var $error_message = NULL;

	public function __construct()
	{
		$this->root = XCube_Root::getSingleton();
	}

	/**
	 * memberId = uid + uname
	 * @param $root
	 * @return string
	 */
	private function _getMemberId()
	{
		return $this->root->mContext->mXoopsUser->get('uid')
			. "-" . $this->root->mContext->mXoopsUser->get('uname');
	}

	private function _setAPIconfig(&$input)
	{
		$memberId = $this->_getMemberId();
		$this->root->mController->setupModuleContext('gmopgx');
		$myModuleConfig = $this->root->mContext->mModuleConfig;

		//サイトID・パスワード
		$input->setSiteId($myModuleConfig['PGCARD_SITE_ID']);
		$input->setSitePass($myModuleConfig['PGCARD_SITE_PASS']);
		//会員IDは必須です
		$input->setMemberId($memberId);
	}

	private function _set_cardSeq(&$input)
	{
		//登録カード連番
		$input->setCardSeq($this->root->mContext->mRequest->getRequest('CardSeq'));
		$input->setSeqMode($this->root->mContext->mRequest->getRequest('SeqMode'));
	}

	private function _set_message(&$output)
	{
		$errorHandle = new ErrorHandler();
		$errorList = $output->getErrList();
		$this->emsg = "<ul>";
		foreach ($errorList as $errorInfo) {
			/* @var $errorInfo ErrHolder */
			$this->emsg .= '<li>'
				. $errorInfo->getErrCode()
				. ':' . $errorInfo->getErrInfo()
				. ':' . $errorHandle->getMessage($errorInfo->getErrInfo())
				. '</li>';
		}
		$this->emsg .= "</ul>";
	}

	private function _set_exceptionMessage(&$exe)
	{
		$exception = $exe->getException();
		$title = $exception->getMessage();
		$messages = $exception->getMessages();
		$this->emsg = $title . "<ul>";
		if (is_array($messages)) {
			foreach ($messages as $message) {
				$this->emsg .= '<li>' . $message . '</li>';
			}
		}
		$this->emsg .= "</ul>";
	}

	public function &get_message()
	{
		return $this->emsg;
	}

	public function saveMemberShip()
	{
		require_once('com/gmo_pg/client/input/SaveMemberInput.php');
		require_once('com/gmo_pg/client/tran/SaveMember.php');

		//入力パラメータクラスをインスタンス化します
		$input = new SaveMemberInput();
		$this->_setAPIconfig($input);

		//会員名称は任意です。
		$input->setMemberName(
			mb_convert_encoding($this->root->mContext->mXoopsUser->get('uname'), 'SJIS', _CHARSET)
		);

		//API通信クラスをインスタンス化します
		$exe = new SaveMember();

		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec($input);

		//実行後、その結果を確認します。
		if ($exe->isExceptionOccured()) {
			//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			$this->_set_exceptionMessage($exe);
			return false;
		} else {
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			if ($output->isErrorOccurred()) { //出力パラメータにエラーコードが含まれていないか、チェックしています。
				$this->_set_message($output);
				//エラーが発生していた場合、エラー画面を表示して終了します。
				return false;
			}
			//例外発生せず、エラーの戻りもないので、正常とみなします。
			//このif文を抜けて、結果を表示します。
		}
		return true;
	}

	public function saveCardInformation()
	{
		require_once('com/gmo_pg/client/input/SaveCardInput.php');
		require_once('com/gmo_pg/client/tran/SaveCard.php');

		//入力パラメータクラスをインスタンス化します
		$input = new SaveCardInput();
		$this->_setAPIconfig($input);

		//カード登録連番が指定された場合、パラメータに設定します。
		if (isset($_POST['CardSeq'])) {
			$this->_set_cardSeq($input);
		}
		$input->setCardNo($this->root->mContext->mRequest->getRequest('CardNo'));
		$input->setCardPass($this->root->mContext->mRequest->getRequest('CardPass'));
		$input->setExpire($this->root->mContext->mRequest->getRequest('Expire'));
		$input->setHolderName($this->root->mContext->mRequest->getRequest('HolderName'));
		$input->setCardName($this->root->mContext->mRequest->getRequest('CardName'));
		$input->setDefaultFlag($this->root->mContext->mRequest->getRequest('DefaultFlag'));
		//API通信クラスをインスタンス化します
		$exe = new SaveCard();
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec($input);
		//実行後、その結果を確認します。
		if ($exe->isExceptionOccured()) {
			//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			$this->_set_exceptionMessage($exe);
			return FALSE;
		} else {
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			if ($output->isErrorOccurred()) { //出力パラメータにエラーコードが含まれていないか、チェックしています。					
				$this->_set_message($output);
				return FALSE;
			}
			//例外発生せず、エラーの戻りもないので、正常とみなします。
			//このif文を抜けて、結果を表示します。
		}
		return TRUE;
	}

	public function getCardList($MemberId)
	{
		require_once('com/gmo_pg/client/input/SearchCardInput.php');
		require_once('com/gmo_pg/client/tran/SearchCard.php');

		//入力パラメータクラスをインスタンス化します
		$input = new SearchCardInput();
		$this->_setAPIconfig($input);

		//カード登録連番が指定された場合、パラメータに設定します。
		if (isset($_POST['CardSeq'])) {
			$this->_set_cardSeq($input);
		}
		//API通信クラスをインスタンス化します
		$exe = new SearchCard();

		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec($input);

		//実行後、その結果を確認します。
		if ($exe->isExceptionOccured()) { //取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			$this->_set_exceptionMessage($exe);
			return FALSE;
		} else {
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			if ($output->isErrorOccurred()) { //出力パラメータにエラーコードが含まれていないか、チェックしています。
				$this->_set_message($output);
				return FALSE;
			}
			//例外発生せず、エラーの戻りもないので、正常とみなします。
			//このif文を抜けて、結果を表示します。
		}
		$cardList = $output->getCardList();
		return $cardList;
	}
}