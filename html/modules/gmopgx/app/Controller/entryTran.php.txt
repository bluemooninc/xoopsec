<?php
require_once _MY_MODULE_PATH.'app/Model/gmopg.class.php';
require_once _MY_MODULE_PATH.'app/Model/Model.class.php';

class Controller_EntryTran extends AbstractAction{
	private $params;
    private $listdata;
    private $cardSeq = NULL;
    var $viewFullPath;
    var $viewTemplate;

    public function setParams($params){
		$this->params = $params;
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
    private function getView_index(){
        $data = array();
        $data['ListData'] = $this->listdata;
        if ($this->mPagenavi){
            $data['pageNavi'] = $this->mPagenavi->mNavi;
        }
        $data['select'] = $this->select;
        $data['subject'] = $this->subject;
        $data['status'] = $this->status;
        $data['OrderID'] = intval( $_POST['OrderID'] );
        $data['PayAmount'] = intval( $_POST['PayAmount'] );
        $data['ListData'] = $this->listdata;
        return $data;
    }
    public function executeView(&$render){
        $getView = "getView_".$this->method;
        $data = $this->$getView();
        View::forge($render, $this->viewTemplate, $data);
    }
    /*
      * Method Section
     */
	public function index(){
        global $xoopsUser;
        $this->listdata = gmopg::get_listdata($xoopsUser->getVar('uid'));
    }
    public function submit(){
		global $xoopsModuleConfig,$xoopsUser;
		if( $_POST['method'] == "submit" ){
            // get Card Seq Number
            $this->cardSeq = intval($_POST['CardSeq']);
            // 先にレコード保存してオーダーidを確定する事！ yoshis

            $comdir = _MY_MODULE_PATH . "/vendor/gpay_client/src/";
			set_include_path($comdir);			
			require_once( 'com/gmo_pg/client/input/EntryTranInput.php');
			require_once( 'com/gmo_pg/client/tran/EntryTran.php');
	
			//入力パラメータクラスをインスタンス化します
			$input = new EntryTranInput();/* @var $input EntryTranInput */
	
			//このサンプルでは、ショップID・パスワードはコンフィグファイルで
			//定数defineしています。
			$input->setShopId( $xoopsModuleConfig['PGCARD_SHOP_ID'] );
			$input->setShopPass( $xoopsModuleConfig['PGCARD_SHOP_PASS'] );
	
			//各種パラメータを設定しています。
			//実際には、処理区分や利用金額、オーダーIDといったパラメータをカード所有者が直接入力することは無く、
			//購買内容を元に加盟店様システムで生成した値が設定されるものと思います。
			$input->setJobCd('AUTH');        //$_POST['JobCd']
			$input->setOrderId( intval($_POST['OrderID']) );
			$input->setItemCode( NULL );	//	$_POST['ItemCode'] カード会社との間の契約にて使用する商品コードが決められた場合のみ入力
			$input->setAmount( intval($_POST['Amount']) );
			$input->setTax( intval($_POST['Tax']) );
			$input->setTdFlag( intval($_POST['TdFlag']) );
			$input->setTdTenantName( $_POST['TdTenantName']);
	
			//API通信クラスをインスタンス化します
			$exe = new EntryTran();/* @var $exec EntryTran */
	
			//パラメータオブジェクトを引数に、実行メソッドを呼び、結果を受け取ります。
			$output = $exe->exec( $input );/* @var $output EntryTranOutput */

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
                model::setTable('payment');
                $data = array(
                    'id'=>NULL,
					'orderId'=> htmlspecialchars($_POST['OrderID'],ENT_QUOTES,_CHARSET),
					'amount' => intval( $_POST['Amount']),
					'tax'=> intval( $_POST['Tax']),
					'accessId' => $output->getAccessId(),
					'accessPass' => $output->getAccessPass(),
					'cardSeq'=> intval( $_POST['CardSeq'])
				);
                model::forge($data);
                model::save($xoopsUser->uid());
				//このif文を抜けて、結果を表示します。
                redirect_header(XOOPS_URL."/modules/gmopgx/execTran/index/".model::id(),5,_MD_GMOPAYMENT_DONE_ENTRYTRAN);
			}
		}
	}
}