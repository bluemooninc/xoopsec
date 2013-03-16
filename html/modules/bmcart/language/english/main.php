<?php
define('_MD_BMCART_ERROR_DBUPDATE_FAILED','Update failed for database');
define('_MD_BMCART_ERROR_REQUIRED', "{0} Must input");
define('_MD_BMCART_ITEMID', 'Product ID');
define('_MD_BMCART_ERROR_MAXLENGTH', "{0} must be under {1} charactior");
define('_MD_BMCART_ERROR_MINLENGTH', "{0} must be order {1} charactior");

define('_MD_BMCART_NEED_LOGIN', 'You need login for checkout');

define('_MD_BMCART_MODULE_TITLE', 'Shopping');
define('_MD_BMCART_TABLE_STATUS', 'Description');
define('_MD_BMCART_TABLE_STATUS_0', 'in my cart');
define('_MD_BMCART_TABLE_STATUS_1', 'now under ordering');
define('_MD_BMCART_TABLE_STATUS_2', 'now under shipping');
define('_MD_BMCART_TABLE_STATUS_3', 'bought items');
define('_MD_BMCART_TABLE_TITLE', 'Title');
define('_MD_BMCART_TABLE_DATE', 'Date');
define('_MD_BMCART_TABLE_UPDATE', 'Update');
define('_MD_BMCART_TABLE_CLOSE', 'Close');
define('_MD_BMCART_DIALOG_DELETE', 'Delete');
define('_MD_BMCART_DIALOG_DELETE_DESC', 'Are you sure to delete this?');
define('_MD_BMCART_CATEGORY_LIST', 'Category list');
define('_MD_BMCART_CATEGORY_NAME', 'Category name');
define('_MD_BMCART_ITEM_LIST', 'Products list');
define('_MD_BMCART_ITEM_DETAIL', 'Products information');
define('_MD_BMCART_ITEM_IMAGE', 'Click image for showing bigger image');
define('_MD_BMCART_ITEM_NAME', 'Product name');
define('_MD_BMCART_ITEM_DESC', 'Description');
define('_MD_BMCART_ITEM_STOCK', 'Stock');
define('_MD_BMCART_ITEM_PRICE', 'Price');
define('_MD_BMCART_AMOUNT', 'Amount');
define('_MD_BMCART_TOTAL_AMOUNT', 'Total');
define('_MD_BMCART_ITEM_SHIPPING_FEE', 'Shipping Fee');
define('_MD_BMCART_FREE_SHIPPING', 'Free Shipping');
define('_MD_BMCART_UPDATE', 'update');
define('_MD_BMCART_ITEM_PRICE_DESC', 'Yen（including TAX,except shipping fee)');
define('_MD_BMCART_PRICE_DESC', 'Yen');
define('_MD_BMCART_FREE_SHIPPING_DESC', 'Yen will have became a free shipping.');
define('_MD_BMCART_FEE', 'Charge');
define('_MD_BMCART_SHIPPING_FEE', 'Shipping Fee');
define('_MD_BMCART_SHIPPING_AND_FEE', 'Shipping/Charge');
define('_MD_BMCART_ADDTOCART', 'Add to Cart');
define('_MD_BMCART_CART_LIST', 'Check my Cart');
define('_MD_BMCART_REMOVE_ITEM', 'Remove');
define('_MD_BMCART_QTY_UPDATE', 'Update');
define('_MD_BMCART_TO_CHECKOUT', 'Goto Checkout');
define('_MD_BMCART_CHECKOUT', 'Make sure order');
define('_MD_BMCART_SHIPPING_TITLE', 'Shipping who:');
define('_MD_BMCART_BILLING_TITLE', 'Payment method:');
define('_MD_BMCART_MODIFY', 'Edit shipping address');
define('_MD_BMCART_ADDNEW', 'Add new');
define('_MD_BMCART_PHONE', 'Phone');
define('_MD_BMCART_LAST3CODE', 'Last 3 words');
define('_MD_BMCART_CHECK_YOUR_ADDRESS', ' Check your address - ');

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
define('_MD_BMCART_ADDRESS', '市区町村等');
define('_MD_BMCART_ZIP2ADDRESS', '郵便番号から住所を自動入力');
define('_MD_BMCART_ADDRESS_ETC', 'その他');
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
define('_MD_BMCART_ADD_SKU', 'SKU在庫追加');

define('_MD_BMCART_ORDER_DETAIL','ご注文商品の一覧');
define('_MD_BMCART_CUSTOMER_REVIEW','カスタマーレビュー');

// For Dependency Injection Component
define('_MD_BMCART_NEED_SKUID','この商品は、色やサイズ等の指定が必要です。');
define('_MD_BMCART_NO_STOCKSKU','  %s は只今在庫がありません。');
