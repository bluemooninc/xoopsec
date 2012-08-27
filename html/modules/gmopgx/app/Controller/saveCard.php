<?php
class Controller_SaveCard extends AbstractAction{
	private $params;
	var $viewFullPath;
	var $viewTemplate;
	
	public function setParams($params){
		$this->params=$params;
	}
	public function setTemplate($controllerName){
		if (is_null($this->viewTemplate)) $this->viewTemplate = $controllerName . ".html";
	}
	public function setView($viewFullPath){
		$this->viewFullPath = $viewFullPath;
	}
	public function template(){
		return $this->viewTemplate;
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
	}
	/*
	 * Method Section
	*/
	public function index(){
	}
	public function submit(){
		global $xoopsModuleConfig,$xoopsUser;
		if( $_POST['method'] == "submit" ){
			$comdir = _MY_MODULE_PATH . "/vendor/gpay_client/src/";
			set_include_path($comdir);
			require_once( 'com/gmo_pg/client/input/SaveCardInput.php');
			require_once( 'com/gmo_pg/client/tran/SaveCard.php');
			
			//入力パラメータクラスをインスタンス化します
			$input = new SaveCardInput();/* @var $input SaveCardInput */
			
			//このサンプルでは、サイトID・パスワードはコンフィグファイルで
			//定数defineしています。
			$input->setSiteId( $xoopsModuleConfig['PGCARD_SITE_ID'] );
			$input->setSitePass( $xoopsModuleConfig['PGCARD_SITE_PASS'] );
			
			//会員IDは必須です
			$input->setMemberId( $xoopsUser->uid() );
			
			//カード登録連番が指定された場合、パラメータに設定します。
			$cardSeq = $_POST['CardSeq'];
			if( 0 < strlen( $cardSeq ) ){
				//登録カード連番
				$input->setCardSeq( $cardSeq );
				$input->setSeqMode( $_POST['SeqMode'] );
			}
			
			$input->setCardNo( $_POST['CardNo'] );
			$input->setCardPass( $_POST['CardPass'] );
			$input->setExpire( $_POST['Expire'] );
			$input->setHolderName( $_POST['HolderName']);
			$input->setCardName( $_POST['CardName']);
			$input->setDefaultFlag( $_POST['DefaultFlag']);
			
			//API通信クラスをインスタンス化します
			$exe = new SaveCard();/* @var $exec SearchCard */
			
			//パラメータオブジェクトを引数に、実行メソッドを呼びます。
			//正常に終了した場合、結果オブジェクトが返るはずです。
			$output = $exe->exec( $input );/* @var $output SaveCardOutput */
			
			//実行後、その結果を確認します。
			
			if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
				$this->root->mController->executeRedirect(XOOPS_URL, 5, "Connection ERROR!");
				
				//サンプルでは、例外メッセージを表示して終了します。
				require_once( PGCARD_SAMPLE_BASE . '/display/Exception.php');
				exit();
			
			}else{
				//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
				if( $output->isErrorOccurred() ){//出力パラメータにエラーコードが含まれていないか、チェックしています。					
					$errorHandle = new ErrorHandler();
					$errorList = $output->getErrList();
					$this->emsg = "";
					foreach( $errorList as  $errorInfo ){/* @var $errorInfo ErrHolder */
						$this->emsg .= '<li>'
						. $errorInfo->getErrCode()
						. ':' . $errorInfo->getErrInfo()
						. ':' . $errorHandle->getMessage( $errorInfo->getErrInfo() )
						.'</li>';
					
					}
					$this->root->mController->executeRedirect(XOOPS_URL, 5, $this->emsg);
					//サンプルでは、エラーが発生していた場合、エラー画面を表示して終了します。
					require_once( PGCARD_SAMPLE_BASE . '/display/Error.php');
					exit();
				}
				//例外発生せず、エラーの戻りもないので、正常とみなします。
				//このif文を抜けて、結果を表示します。
			}
		}
	}
}