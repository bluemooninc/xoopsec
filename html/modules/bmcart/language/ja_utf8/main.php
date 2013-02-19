<?php
define('_MD_BMCART_ERROR_DBUPDATE_FAILED','データベースの更新に失敗しました');
define('_MD_BMCART_ERROR_REQUIRED', "{0}は必ず入力して下さい");
define('_MD_BMCART_ITEMID', '商品番号');
define('_MD_BMCART_ERROR_MAXLENGTH', "{0}は半角{1}文字以内で入力して下さい");
define('_MD_BMCART_ERROR_MINLENGTH', "{0}は半角{1}文字以上にして下さい");

define('_MD_BMCART_NEED_LOGIN', 'チェックアウトするにはログインする必要があります。');

define('_MD_BMCART_MODULE_TITLE', 'ショッピング');
define('_MD_BMCART_TABLE_STATUS', '備考');
define('_MD_BMCART_TABLE_STATUS_0', 'カートの中身');
define('_MD_BMCART_TABLE_STATUS_1', '注文中の商品');
define('_MD_BMCART_TABLE_STATUS_2', '配送中の商品');
define('_MD_BMCART_TABLE_STATUS_3', '購入済の商品');
define('_MD_BMCART_TABLE_TITLE', '件名');
define('_MD_BMCART_TABLE_DATE', '日時');
define('_MD_BMCART_TABLE_UPDATE', '更新する');
define('_MD_BMCART_TABLE_CLOSE', '閉じる');
define('_MD_BMCART_DIALOG_DELETE', 'レコード削除');
define('_MD_BMCART_DIALOG_DELETE_DESC', 'このレコードを削除してもよろしいですか？');
define('_MD_BMCART_CATEGORY_LIST', 'カテゴリ一覧');
define('_MD_BMCART_CATEGORY_NAME', 'カテゴリ名');
define('_MD_BMCART_ITEM_LIST', '商品一覧');
define('_MD_BMCART_ITEM_DETAIL', '商品の情報');
define('_MD_BMCART_ITEM_IMAGE', '画像をクリックして拡大イメージを表示');
define('_MD_BMCART_ITEM_NAME', '商品名');
define('_MD_BMCART_ITEM_DESC', '商品説明');
define('_MD_BMCART_ITEM_STOCK', '在庫数');
define('_MD_BMCART_ITEM_PRICE', '販売価格');
define('_MD_BMCART_AMOUNT', '金額');
define('_MD_BMCART_TOTAL_AMOUNT', '合計金額');
define('_MD_BMCART_ITEM_SHIPPING_FEE', '送料');
define('_MD_BMCART_FREE_SHIPPING', '送料無料');
define('_MD_BMCART_UPDATE', '更新日付');
define('_MD_BMCART_ITEM_PRICE_DESC', '円（税込、送料別）');
define('_MD_BMCART_PRICE_DESC', '円');
define('_MD_BMCART_FREE_SHIPPING_DESC', '円以上 送料無料');
define('_MD_BMCART_FEE', '手数料');
define('_MD_BMCART_SHIPPING_FEE', '配送料');
define('_MD_BMCART_SHIPPING_AND_FEE', '配送料・手数料');
define('_MD_BMCART_ADDTOCART', 'カートに入れる');
define('_MD_BMCART_CART_LIST', 'カートの中身');
define('_MD_BMCART_REMOVE_ITEM', '削除');
define('_MD_BMCART_QTY_UPDATE', '更新');
define('_MD_BMCART_TO_CHECKOUT', 'レジに進む');
define('_MD_BMCART_CHECKOUT', '注文内容の確認');
define('_MD_BMCART_SHIPPING_TITLE', 'お届け先住所：');
define('_MD_BMCART_BILLING_TITLE', '支払い方法:');
define('_MD_BMCART_MODIFY', '配送先の入力');
define('_MD_BMCART_ADDNEW', '入力する');
define('_MD_BMCART_PHONE', '電話番号：');
define('_MD_BMCART_LAST3CODE', '下3桁');
define('_MD_BMCART_CHECK_YOUR_ADDRESS', ' 欄の入力項目をご確認下さい。');

// cart.html
define('_MD_BMCART_CART_INDEX', 'ショッピングカート');
define('_MD_BMCART_CART_ITEMID', '商品番号');
define('_MD_BMCART_CART_CONTENT', '商品名等');
define('_MD_BMCART_CART_PRICE', '価格');
define('_MD_BMCART_CART_QTY', '数量');

define('_MD_BMCART_PAYMENT_TYPE_WIRE', '銀行振込 : ABC銀行 <br />&nbsp;&nbsp;&nbsp;DFG支店 普通）1234567');
define('_MD_BMCART_PAYMENT_TYPE_CREDIT_CARD', 'クレジットカード');

define('_MD_BMCART_SHIPPING_TO', '配送先氏名');
define('_MD_BMCART_FIRSTNAME', '名');
define('_MD_BMCART_LASTNAME', '姓');
define('_MD_BMCART_SHIPPING_ADDRESS', '配送先住所');
define('_MD_BMCART_ZIP_CODE', '郵便番号');
define('_MD_BMCART_STATE', '都道府県');
define('_MD_BMCART_ADDRESS', '市区町村番地');
define('_MD_BMCART_ZIP2ADDRESS', '郵便番号から住所を自動入力');
define('_MD_BMCART_ADDRESS2', 'マンション名等');
define('_MD_BMCART_STATE_OPTIONS',
'北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,'.
'茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,'.
'新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,'.
'三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,'.
'鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,'.
'福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県');
define('_MD_BMCART_REGISTER','登録する');
define('_MD_BMCART_ORDER_FIXED','注文を確定する');
define('_MD_BMCART_ORDER_MAIL','ご注文の確認');
define('_MD_BMCART_MESSAGE_LESS_STOCK',' %s は只今の在庫数が %d です。ご注文頂くにはこの数量以下にして下さい。');
define('_MD_BMCART_NO_STOCK','  %s は只今の在庫がありません。この商品をカートから取り除いて下さい。');
define('_MD_BMCART_PAYMENT_DESC_CARD','クレジットカードによるお支払いを選択されました。
クレジットカードの決済予約を行いました。実際の決済は商品発送時に行われます。');
define('_MD_BMCART_PAYMENT_DESC_WIRE','銀行振込によるお支払いを選択されました。
以下の口座にお振込下さい。入金確認後に発送の手続きを行います。
振込先口座：あいう銀行　えお支店（普通口座）1234567
振込先名義：カキク　ケコ');

define('_MD_BMCART_THANKS_FOR_ORDER','ご注文ありがとうございます。ご注文の確認メールを送信します。');

define('_MD_BMCART_ORDER_LIST','ご注文一覧');
define('_MD_BMCART_ORDER_ID','注文番号');
define('_MD_BMCART_ORDER_DATE','注文日時');
define('_MD_BMCART_SUB_TOTAL','商品合計(内消費税)');
define('_MD_BMCART_QTY_DESC', '個');
define('_MD_BMCART_PAYMENT_TYPE', 'お支払い方法');
define('_MD_BMCART_PAYBY_WIRE', '銀行振込');
define('_MD_BMCART_PAYBY_CREDIT', 'クレジットカード');
define('_MD_BMCART_ADD_CREDIT', 'クレジットカード追加');
define('_MD_BMCART_CASHON_DELIVERLY', '代引き');
define('_MD_BMCART_EDIT', '編集する');
define('_MD_BMCART_ADD_IMAGE', '画像追加');

define('_MD_BMCART_ORDER_DETAIL','ご注文商品の一覧');
define('_MD_BMCART_CUSTOMER_REVIEW','カスタマーレビュー');
