<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once _MY_MODULE_PATH.'app/Model/MyPageNavi.class.php';
require_once _MY_MODULE_PATH.'app/Model/Model.class.php';

class Controller_ExecTran extends AbstractAction{
    private $listdata;
	private $params;
	private $mName = 'payment';
    private $pagenum = 20;
    private $id;
    private $orderId;

    var $viewFullPath;
	var $viewTemplate;

    public function setParams($params){
		$this->params=$params;
	}
	private function setPageNavi($sortName, $sortIndex){
		$this->mPagenavi = new MyPageNavi($this->mHandler);
		$this->mPagenavi->setUrl($this->url);
		$this->mPagenavi->setPagenum($this->pagenum);
		$this->mPagenavi->addSort($sortName,$sortIndex);
		$this->mPagenavi->addCriteria(new Criteria('uid', $this->root->mContext->mXoopsUser->get('uid')));
		$this->mPagenavi->fetch();
	}
	private function getModObj($id=null){
		if (!is_null($id) && $this->mHandler){
			$this->mPagenavi->addCriteria(new Criteria('id', intval($id)));
            $this->select = $this->mHandler->getDataById($this->root->mContext->mXoopsUser->get('uid'),$id);
            $modObj = $this->mHandler->getObjects($this->mPagenavi->getCriteria());
        }
		foreach ($modObj as $key => $val) {
			foreach ( array_keys($val->gets()) as $var_name ) {
				$item_ary[$var_name] = $val->getShow($var_name);
			}
			if (!is_null($id)){
				$this->listdata = $item_ary;
			}else{
				$this->listdata[] = $item_ary;
			}
			unset($item_ary);
		}
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
        $render->setAttribute('id', $this->id);
	}
	/*
	 * Method Section
	*/
	public function index(){
		if ($this->params) {
            model::setTable($this->mName);
            model::find(intval($this->params));
            $this->id = model::get('id');
            $this->orderId = model::get('orderId');
        }
	}
	public function submit(){
		global $xoopsModuleConfig,$xoopsUser;
		if( $_POST['method'] == "submit" ){
			$comdir = _MY_MODULE_PATH . "/vendor/gpay_client/src/";
			set_include_path($comdir);			
			require_once( 'com/gmo_pg/client/input/ExecTranInput.php');
			require_once( 'com/gmo_pg/client/tran/ExecTran.php');
			$id = intval($_POST['id']);

            //入力パラメータクラスをインスタンス化します
			$input = new ExecTranInput();/* @var $input ExecTranInput */
			
			//各種パラメータを設定します。
            model::setTable($this->mName);
            model::find($id);

            //カード番号入力型・会員ID決済型に共通する値です。
			$input->setAccessId( model::get('accessId') );
			$input->setAccessPass( model::get('accessPass') );
			$input->setOrderId( model::get('orderId') );
			
			//支払方法に応じて、支払回数のセット要否が異なります。
			$method = $_POST['PayMethod'];
			$input->setMethod( $method );
			if( $method == '2' || $method == '4'){//支払方法が、分割またはボーナス分割の場合、支払回数を設定します。
				$input->setPayTimes( $_POST['PayTimes'] );
			}
			
			//このサンプルでは、加盟店自由項目１～３を全て利用していますが、これらの項目は任意項目です。
			//利用しない場合、設定する必要はありません。
			//また、加盟店自由項目に２バイトコードを設定する場合、SJISに変換して設定してください。
            /*
			$input->setClientField1( mb_convert_encoding( $_POST['ClientField1'] , 'SJIS' , _CHARSET ) );
			$input->setClientField2( mb_convert_encoding( $_POST['ClientField2'] , 'SJIS' , _CHARSET ) );
			$input->setClientField3( mb_convert_encoding( $_POST['ClientField3'] , 'SJIS' , _CHARSET ) );
			*/
			//HTTP_ACCEPT,HTTP_USER_AGENTは、3Dセキュアサービスをご利用の場合のみ必要な項目です。
			//Entryで3D利用フラグをオンに設定した場合のみ、設定してください。
			//設定する場合、カード所有者のブラウザから送信されたリクエストヘッダの値を、無加工で
			//設定してください。
			$input->setHttpUserAgent( $_SERVER['HTTP_USER_AGENT']);
			$input->setHttpAccept( $_SERVER['HTTP_ACCEPT' ]);
			
			//ここから、カード番号入力型決済と会員ID型決済それぞれの場合で
			//異なるパラメータを設定します。
			
			//ここでは、「画面で会員IDが入力されたか」を判断基準にして、
			//決済のタイプを判別しています。
			//$memberId = $_POST['MemberID'];
			$memberId = $xoopsUser->uid();
			
			if( 0 < strlen( $memberId )  ){//会員ID決済
				//サンプルでは、サイトID・サイトパスワードはコンスタント定義しています。
				$input->setSiteId( $xoopsModuleConfig['PGCARD_SITE_ID'] );
				$input->setSitePass( $xoopsModuleConfig['PGCARD_SITE_PASS'] );			
				//会員IDは必須です。
				$input->setMemberId( $memberId );
				//登録カード連番は任意です。
				$input->setCardSeq( model::get('cardSeq') );
			}
			//API通信クラスをインスタンス化します
			$exe = new ExecTran();/* @var $exec ExecTran */

			//パラメータオブジェクトを引数に、実行メソッドを呼びます。
			//正常に終了した場合、結果オブジェクトが返るはずです。
			$output = $exe->exec( $input );/* @var $output ExecTranOutput */
			//実行後、その結果を確認します。
			if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
				$this->root->mController->executeRedirect(XOOPS_URL, 5, "Connection ERROR!");
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
					$this->root->mController->executeRedirect(XOOPS_URL, 10, $this->emsg);
				}else if( $output->isTdSecure() ){//決済実行の場合、3Dセキュアフラグをチェックします。
					//3Dセキュアフラグがオンである場合、リダイレクトページを表示する必要があります。
					//サンプルでは、モジュールタイプに標準添付されるリダイレクトユーティリティを利用しています。
					//リダイレクト用パラメータをインスタンス化して、パラメータを設定します
					require_once( 'com/gmo_pg/client/input/AcsParam.php');
					require_once( 'com/gmo_pg/client/common/RedirectUtil.php');
					$redirectInput = new AcsParam();
					$redirectInput->setAcsUrl( $output->getAcsUrl() );
					$redirectInput->setMd( model::get('accessId') );
					$redirectInput->setPaReq( $output->getPaReq() );
					$redirectInput->setTermUrl( PGCARD_SAMPLE_URL . '/SecureTran.php');
					//リダイレクトページ表示クラスをインスタンス化して実行します。
					$redirectShow = new RedirectUtil();
					print ($redirectShow->createRedirectPage( PGCARD_SECURE_RIDIRECT_HTML , $redirectInput ) );
					exit();
				}
				//例外発生せず、エラーの戻りもなく、3Dセキュアフラグもオフであるので、実行結果を表示します。
                model::setValue(array('status'=>1));
                model::save($xoopsUser->uid());
                $url = XOOPS_URL . "/modules/" . $xoopsModuleConfig['PGCARD_RETURN_URL']. model::get('orderId');
                $this->root->mController->executeRedirect($url, 5, _MD_GMOPAYMENT_DONE_EXECTRAN);
            }
		}
	}
}