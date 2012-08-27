<?php
class Controller_MemberSave extends AbstractAction{
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
	}
	/*
	 * Method Section
	*/
	public function index(){
	}
	public function submit(){
		global $xoopsModuleConfig,$xoopsUser;
		if( isset( $_POST['submit'] ) ){
			$comdir = _MY_MODULE_PATH . "/vendor/gpay_client/src/";
			set_include_path($comdir);
			require_once( 'com/gmo_pg/client/input/SaveMemberInput.php');
			require_once( 'com/gmo_pg/client/tran/SaveMember.php');
		
			//入力パラメータクラスをインスタンス化します
			$input = new SaveMemberInput();/* @var $input SaveMemberInput */
		
			//このサンプルでは、サイトID・パスワードはコンフィグファイルで
			//定数defineしています。
			$input->setSiteId( $xoopsModuleConfig['PGCARD_SITE_ID'] );
			$input->setSitePass( $xoopsModuleConfig['PGCARD_SITE_PASS'] );
		
			//会員IDは必須です
			$input->setMemberId( $xoopsUser->uid() );
		
			//会員名称は任意です。
			$input->setMemberName( mb_convert_encoding( $xoopsUser->getVar('uname') , 'SJIS' , _CHARSET ) );
		
			//API通信クラスをインスタンス化します
			$exe = new SaveMember();/* @var $exec SaveMember */
		
			//パラメータオブジェクトを引数に、実行メソッドを呼びます。
			//正常に終了した場合、結果オブジェクトが返るはずです。
			$output = $exe->exec( $input );/* @var $output SaveMemberOutput */
			
			//実行後、その結果を確認します。
			if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。	
				//サンプルでは、例外メッセージを表示して終了します。
				$exception = $exe->getException();
				$title = $exception->getMessage();
				$messages = $exception->getMessages();
				if( is_array( $messages ) ){
					echo $title.'<ul>';
					foreach( $messages as  $message ){
						echo '<li>' . $message .'</li>';
					}
					echo '</ul>';
				}
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
			/*
			$CardSeq = $output->getCardSeq();	// カード連番(CardSeq)
			$CardNo = $output->getCardNo();		// カード番号(CardNo)
			$Forward = $output->getForward();	//仕向先カード会社コード(Forward)
			$this->root->mController->executeRedirect(XOOPS_URL, 5, "Done as ". $CardNo);
			*/
		}
	}
}