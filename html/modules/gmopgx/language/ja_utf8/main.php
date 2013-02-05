<?php
define('_MD_GMOPGX_MODULE_TITLE', 'GMO Payment');
define('_MD_GMOPGX_RECEIPT', 'クレジットご利用明細');
define('_MD_GMOPGX_TABLE_STATUS', '備考');
define('_MD_GMOPGX_TABLE_STATUS_0', 'カートの中身');
define('_MD_GMOPGX_TABLE_STATUS_1', '注文中の商品');
define('_MD_GMOPGX_TABLE_STATUS_2', '配送中の商品');
define('_MD_GMOPGX_TABLE_STATUS_3', '購入済の商品');
define('_MD_GMOPGX_TABLE_TITLE', '件名');
define('_MD_GMOPGX_TABLE_DATE', '日時');
define('_MD_GMOPGX_TABLE_UPDATE', '更新する');
define('_MD_GMOPGX_TABLE_CLOSE', '閉じる');
define('_MD_GMOPGX_DIALOG_DELETE', 'レコード削除');
define('_MD_GMOPGX_DIALOG_DELETE_DESC', 'このレコードを削除してもよろしいですか？');
// cart.html
define('_MD_GMOPGX_CART_INDEX', 'ショッピングカート');
define('_MD_GMOPGX_CART_ITEMID', '商品番号');
define('_MD_GMOPGX_CART_CONTENT', '商品名等');
define('_MD_GMOPGX_CART_PRICE', '価格');
define('_MD_GMOPGX_CART_QTY', '数量');


define('_MD_GMOPAYMENT_TITLE_MEMBERSAVE','会員登録');
define('_MD_GMOPAYMENT_TITLE_MEMBERSAVED','決済アカウントの作成ありがとうございます。
次にカード登録のボタンをクリックして、クレジットカードの登録へお進み下さい。
');
define('_MD_GMOPAYMENT_TITLE_SAVECARD'  ,'クレジットカード登録');
define('_MD_GMOPAYMENT_TITLE_ADDCARD'  ,'クレジットカード登録');
define('_MD_GMOPAYMENT_TITLE_SEARCHCARD'  ,'登録カード検索');
define('_MD_GMOPAYMENT_TITLE_ENTRYTRAN' ,'クレジットカードによるお支払い');
define('_MD_GMOPAYMENT_TITLE_EXECTRAN'  ,'決済実行');
define('_MD_GMOPAYMENT_DESC_MEMBERSAVE',
'本サイトでは、GMOペイメントゲートウェイ株式会社( http://www.gmo-pg.com/ )のAPI決済代行システムを採用しております。
クレジットカードの全ての情報はこのサービスAPIにより行われ本サイトにカード情報は一切残りません。
上記カードのお取り扱いに同意頂ける事を条件に貴方のIDで決済用アカウントを登録します。よろしいですか？');
define('_MD_GMOPAYMENT_SUBMIT_REGISTRATION','同意してアカウントを作成する');
define('_MD_GMOPAYMENT_DESC_SAVECARD'  ,'GMO Payment Gateway に貴方のIDでクレジットカード情報を登録します。必要事項をご記入し登録をクリックしてください。');
define('_MD_GMOPAYMENT_DESC_SEARCHCARD','GMO Payment Gateway に貴方のIDで登録したクレジットカード情報を検索します。必要事項をご記入し登録をクリックしてください。');
define('_MD_GMOPAYMENT_DESC_ENTRYTRAN' ,'GMO Payment Gateway にてお支払いを行います。よろしければ「支払いを確定する」をクリックしてください。');
define('_MD_GMOPAYMENT_DESC_EXECTRAN'  ,'GMO Payment Gateway へのお支払い方法と回数をご指定ください。以上でで決済完了です。');
define('_MD_GMOPAYMENT_DONE_MEMBERSAVE','GMO Payment Gateway に貴方のIDでアカウントを作成しました。');
define('_MD_GMOPAYMENT_DONE_SAVECARD'  ,'GMO Payment Gateway に貴方のIDでクレジットカード情報を登録しました。');
define('_MD_GMOPAYMENT_DONE_SEARCHCARD','GMO Payment Gateway に貴方のIDで登録したクレジットカード情報を表示します。');
define('_MD_GMOPAYMENT_DONE_ENTRYTRAN' ,'GMO Payment Gateway にてお支払い内容の照会が完了しました。');
define('_MD_GMOPAYMENT_DONE_EXECTRAN'  ,'GMO Payment Gateway にてお支払いが完了しました。');
//SaveCard
define('_MD_GMOPAYMENT_MEMBERID','会員ID');			// XOOPSのUID
define('_MD_GMOPAYMENT_CARDSEQ','No.');		// クレジットカード複数毎指定時の選択
define('_MD_GMOPAYMENT_SEQMODE','カード連番モード');	// 論理連番(デフォルト）か物理連番
define('_MD_GMOPAYMENT_EXPIRE','カード有効期限YYMM');	
define('_MD_GMOPAYMENT_CARDNO','カード番号');
define('_MD_GMOPAYMENT_CARDPASS','カードパスワード');	// PIN
define('_MD_GMOPAYMENT_CARDNAME','カード会社略称');	// VISA,Master等
define('_MD_GMOPAYMENT_HOLDERNAME','カード名義人');
define('_MD_GMOPAYMENT_DEFAULTFLAG','通常使うカードに指定');
define('_MD_GMOPAYMENT_RESISTER','カード情報を登録');
define('_MD_GMOPAYMENT_SUBMIT','支払いを確定する');
define('_MD_GMOPAYMENT_DO','する');
define('_MD_GMOPAYMENT_DONOT','しない');
define('_MD_GMOPAYMENT_SECMODE0','論理');
define('_MD_GMOPAYMENT_SECMODE1','物理');
//EntryTran
define('_MD_GMOPAYMENT_ORDERID','クレジット決済番号');
define('_MD_GMOPAYMENT_JOBCD','処理区分');
define('_MD_GMOPAYMENT_JOBCD_AUTH','AUTH:仮売上');
define('_MD_GMOPAYMENT_JOBCD_CHECK','CHECK:有効性チェック');
define('_MD_GMOPAYMENT_JOBCD_CAPTURE','CAPTURE:即時売上');
define('_MD_GMOPAYMENT_ITEMCODE','商品コード');
define('_MD_GMOPAYMENT_AMOUNT','ご利用金額');
define('_MD_GMOPAYMENT_TAX','税送料');
define('_MD_GMOPAYMENT_TDFLAG','3D利用');
define('_MD_GMOPAYMENT_TDFLAG_SECURE','利用する');
define('_MD_GMOPAYMENT_TDFLAG_NOSECURE','利用しない');
define('_MD_GMOPAYMENT_TDTENANTNAME','3D認証画面店舗名');
//ExecTran
define('_MD_GMOPAYMENT_ACCESSID','取引ID');
define('_MD_GMOPAYMENT_HOLD','商品発送時決済予約中');
define('_MD_GMOPAYMENT_DONETRAN','お支払い済み');
define('_MD_GMOPAYMENT_ACCESSPASS','取引パスワード');
define('_MD_GMOPAYMENT_PAYMETHOD','支払方法');
define('_MD_GMOPAYMENT_PAYMETHOD1','1:一括');
define('_MD_GMOPAYMENT_PAYMETHOD2','2:分割');
define('_MD_GMOPAYMENT_PAYMETHOD3','3:ボーナス一括');
define('_MD_GMOPAYMENT_PAYMETHOD4','4:ボーナス分割');
define('_MD_GMOPAYMENT_PAYMETHOD5','5:リボ');
define('_MD_GMOPAYMENT_PAYTIMES','支払回数');
define('_MD_GMOPAYMENT_CLIENTFIELD1','加盟店自由項目１');
define('_MD_GMOPAYMENT_CLIENTFIELD2','加盟店自由項目２');
define('_MD_GMOPAYMENT_CLIENTFIELD3','加盟店自由項目３');
