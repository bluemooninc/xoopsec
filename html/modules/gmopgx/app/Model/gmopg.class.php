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
require_once('com/gmo_pg/client/input/SearchCardInput.php');
require_once('com/gmo_pg/client/tran/SearchCard.php');

class gmopg
{
    var $error_message = NULL;

    public function get_listdata($MemberId)
    {
        global $xoopsModuleConfig;

        //入力パラメータクラスをインスタンス化します
        $input = new SearchCardInput();
        /* @var $input SearchCardInput */

        //サイトID・パスワード
        $input->setSiteId($xoopsModuleConfig['PGCARD_SITE_ID']);
        $input->setSitePass($xoopsModuleConfig['PGCARD_SITE_PASS']);


        //会員IDは必須です
        $input->setMemberId($MemberId);

        //カード登録連番が指定された場合、パラメータに設定します。
        $cardSeq = $_POST['CardSeq'];
        if (0 < strlen($cardSeq)) {
            //登録カード連番
            $input->setCardSeq($cardSeq);
            $input->setSeqMode($_POST['SeqMode']);
        }

        //API通信クラスをインスタンス化します
        $exe = new SearchCard();
        /* @var $exec SearchCard */

        //パラメータオブジェクトを引数に、実行メソッドを呼びます。
        //正常に終了した場合、結果オブジェクトが返るはずです。
        $output = $exe->exec($input);
        /* @var $output SearchCardOutput */

        //実行後、その結果を確認します。

        if ($exe->isExceptionOccured()) { //取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
            $this->error_message = "Connection ERROR!";
            return NULL;
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
                return NULL;
            }
            //例外発生せず、エラーの戻りもないので、正常とみなします。
            //このif文を抜けて、結果を表示します。
        }
        $cardList = $output->getCardList();
        return $cardList;
    }
}