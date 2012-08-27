<?php

// The name of this module
define("_MI_MYSHOP_NAME","マイ・ショップ");

// A brief description of this module
define("_MI_MYSHOP_DESC","Creates an online shop to display and sell products.");

// Names of blocks for this module (Not all module has blocks)
define("_MI_MYSHOP_BNAME1","最近登録された商品");
define("_MI_MYSHOP_BNAME2","Top Products");
define("_MI_MYSHOP_BNAME3","カテゴリーから選ぶ");
define("_MI_MYSHOP_BNAME4","ベストセラー");
define("_MI_MYSHOP_BNAME5","評価の高い商品");
define("_MI_MYSHOP_BNAME6","ランダム表示");
define("_MI_MYSHOP_BNAME7","プロモーション商品");
define("_MI_MYSHOP_BNAME8","ショッピングカート");
define("_MI_MYSHOP_BNAME9","おすすめ商品");

// Sub menu titles
define("_MI_MYSHOP_SMNAME1","ショッピング・カート");
define("_MI_MYSHOP_SMNAME1_1","&nbsp;カートの中身を見る");
define("_MI_MYSHOP_SMNAME1_2","&nbsp;注文履歴を見る");
define("_MI_MYSHOP_SMNAME2","商品を選ぶ");
define("_MI_MYSHOP_SMNAME2_1","&nbsp;おすすめ商品");
define("_MI_MYSHOP_SMNAME2_2","&nbsp;商品一覧");
define("_MI_MYSHOP_SMNAME2_3","&nbsp;カテゴリーから選ぶ");
define("_MI_MYSHOP_SMNAME2_4","&nbsp;カテゴリー一覧");
define("_MI_MYSHOP_SMNAME2_5","&nbsp;検索");
define("_MI_MYSHOP_SMNAME3","その他");
define("_MI_MYSHOP_SMNAME3_1","&nbsp;販売条件について");


// Names of admin menu items
define("_MI_MYSHOP_ADMENU0","店舗登録");
define("_MI_MYSHOP_ADMENU1","税率設定");
define("_MI_MYSHOP_ADMENU2","カテゴリー");
define("_MI_MYSHOP_ADMENU3","メーカー");
define("_MI_MYSHOP_ADMENU4","商品設定");
define("_MI_MYSHOP_ADMENU5","注文状況");
define("_MI_MYSHOP_ADMENU6","値引き");
define("_MI_MYSHOP_ADMENU7","ニュースレター");
define("_MI_MYSHOP_ADMENU8", "各種テキスト");
define("_MI_MYSHOP_ADMENU9", "在庫情報");
define("_MI_MYSHOP_ADMENU10", "ダッシュボード");
define("_MI_MYSHOP_ADMENU11", "添付ファイル");

// Title of config items
define('_MI_MYSHOP_NEWLINKS', 'トップページに表示する新着商品の最大数');
define('_MI_MYSHOP_PERPAGE', '各ページに表示する商品の最大数');

// Description of each config items
define('_MI_MYSHOP_NEWLINKSDSC', '');
define('_MI_MYSHOP_PERPAGEDSC', '');

// Text for notifications

define('_MI_MYSHOP_GLOBAL_NOTIFY', 'ショッピング情報のお知らせ');
define('_MI_MYSHOP_GLOBAL_NOTIFYDSC', 'Global lists notification options.');

define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFY', '新しいカテゴリ');
define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYCAP', "新しいカテゴリが追加された時にお知らせを受け取ります");
define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYDSC', "新しい商品が登録された時にお知らせを受け取ります");
define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New Product category');

define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFY', '新しい商品');
define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYCAP', '新しい商品が登録された時にお知らせを受け取ります');
define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYDSC', 'Receive notification when any new product is posted.');
define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New Product');

define('_MI_MYSHOP_PAYPAL_EMAIL', "Paypal Email アドレス");
define('_MI_MYSHOP_PAYPAL_EMAILDSC', "Paypalの支払いと受注の通知に使用するアドレス。<br />
<u><b>このフィールドを記入しない場合は、オンライン決済は無効になります。</u></b>");
define('_MI_MYSHOP_PAYPAL_TEST', "Paypal sandbox を使用しますか?");
define("_MI_MYSHOP_FORM_OPTIONS","フォームオプション");
define("_MI_MYSHOP_FORM_OPTIONS_DESC","Select the editor to use. If you have a 'simple' install (e.g you use only xoops core editor class, provided in the standard Xoops core package), then you can just select DHTML and Compact");

define("_MI_MYSHOP_FORM_COMPACT","Compact");
define("_MI_MYSHOP_FORM_DHTML","DHTML");
define("_MI_MYSHOP_FORM_SPAW","Spaw Editor");
define("_MI_MYSHOP_FORM_HTMLAREA","HtmlArea Editor");
define("_MI_MYSHOP_FORM_FCK","FCK Editor");
define("_MI_MYSHOP_FORM_KOIVI","Koivi Editor");
define("_MI_MYSHOP_FORM_TINYEDITOR","TinyEditor");

define("_MI_MYSHOP_INFOTIPS","Length of tooltips");
define("_MI_MYSHOP_INFOTIPS_DES","If you use this option, links related to products will contains the first (n) characters of the product. If you set this value to 0 then the infotips will be empty");
define('_MI_MYSHOP_UPLOADFILESIZE', 'MAX Filesize Upload (KB) 1048576 = 1 Meg');

define('_MI_PRODUCTSBYTHISMANUFACTURER', 'Products by the same manufacturer');

define('_MI_MYSHOP_PREVNEX_LINK','Show Previous and Next link ?');
define('_MI_MYSHOP_PREVNEX_LINK_DESC','When this option is set to \'Yes\', two new links are visibles at the bottom of each product. Those links are used to go to the previous and next product according to the publish date');

define('_MI_MYSHOP_SUMMARY1_SHOW','Show recent products in all categories?');
define('_MI_MYSHOP_SUMMARY1_SHOW_DESC','When you use this option, a summary containing links to all the recent published products is visible at the bottom of each product');

define('_MI_MYSHOP_SUMMARY2_SHOW','Show recent products in current category ?');
define('_MI_MYSHOP_SUMMARY2_SHOW_DESC','When you use this option, a summary containing links to all the recent published products is visible at the bottom of each product');

define('_MI_MYSHOP_OPT23',"[METAGEN] - Maximum count of keywords to generate");
define('_MI_MYSHOP_OPT23_DSC',"Select the maximum count of keywords to automatically generate.");

define('_MI_MYSHOP_OPT24',"[METAGEN] - Keywords order");
define('_MI_MYSHOP_OPT241',"Create them in the order they appear in the text");
define('_MI_MYSHOP_OPT242',"Order of word's frequency");
define('_MI_MYSHOP_OPT243',"Reverse order of word's frequency");

define('_MI_MYSHOP_OPT25',"[METAGEN] - Blacklist");
define('_MI_MYSHOP_OPT25_DSC',"Enter words (separated by a comma) to remove from meta keywords");
define('_MI_MYSHOP_RATE','Enable users to rate Products ?');

define("_MI_MYSHOP_ADVERTISEMENT","広告メッセージ");
define("_MI_MYSHOP_ADV_DESCR","Enter a text or a javascript code to display in your products");
define("_MI_MYSHOP_MIMETYPES","Enter authorised Mime Types for upload (separated them on a new line)");
define('_MI_MYSHOP_STOCK_EMAIL', "Email address to use when stocks are low");
define('_MI_MYSHOP_STOCK_EMAIL_DSC', "Don't type anything if you don't want to use this function.");

define('_MI_MYSHOP_OPT7',"Use RSS feeds ?");
define('_MI_MYSHOP_OPT7_DSC',"The last Products will be available via an RSS Feed");

define('_MI_MYSHOP_CHUNK1',"Span for most recent Products");
define('_MI_MYSHOP_CHUNK2',"Span for most purchased Products");
define('_MI_MYSHOP_CHUNK3',"Span for most viewed Products");
define('_MI_MYSHOP_CHUNK4',"Span for best ranked Products");
define('_MI_MYSHOP_ITEMSCNT',"Items count to display in the administration");
define('_MI_MYSHOP_PDF_CATALOG',"Allow the use of the PDF catalog ?");
define('_MI_MYSHOP_URL_REWR',"Urlのリライトを行いますか？");

define('_MI_MYSHOP_MONEY_F',"通貨名");
define('_MI_MYSHOP_MONEY_S',"通貨シンボル");
define('_MI_MYSHOP_MONEY_P',"Paypal 通貨コード");
define('_MI_MYSHOP_NO_MORE',"在庫が無いときにその商品を表示しますか?");
define('_MI_MYSHOP_MSG_NOMORE',"仕入れの停止した商品に対してのメッセージ");
define('_MI_MYSHOP_GRP_SOLD',"Group to send an email when a product is sold ?");
define('_MI_MYSHOP_GRP_QTY',"Group of users authorized to modify products quantities from the Product page");
define('_MI_MYSHOP_BEST_TOGETHER',"Display 'Better Together' ?");
define('_MI_MYSHOP_UNPUBLISHED',"Display product who's publication date if later than today ?");
define('_MI_MYSHOP_DECIMAL', "小数点以下の桁数");
define('_MI_MYSHOP_PDT', "Paypal - Payment Data Transfer Token (optional)");
define('_MI_MYSHOP_CONF04',"千の位記号");
define('_MI_MYSHOP_CONF05', "小数点記号");
define('_MI_MYSHOP_CONF00',"通貨表示位置は?");
define('_MI_MYSHOP_CONF00_DSC', "Yes = 右寄せ, No = 左寄せ");
define('_MI_MYSHOP_MANUAL_META', "Enter meta data manually ?");

define('_MI_MYSHOP_OFFLINE_PAYMENT', "銀行振込等のオフラインでの支払いに対応しますか？");
define('_MI_MYSHOP_OFF_PAY_DSC', "これを許可する場合はモジュール管理のテキストタブに支払い方法を記述する必要があります");

define('_MI_MYSHOP_GMOPG_PAYMENT', "GMO-PG の支払いに対応しますか？");
define('_MI_MYSHOP_GMOPG_PAY_DSC', "これを許可する場合はGMO-PGの設定を記述する必要があります");
define('_MI_MYSHOP_GMOPG_URL', "GMO-PG の支払いURL");
define('_MI_MYSHOP_GMOPG_URL_DSC', "GMO-PGの決済モジュールのURLを記述します");

define('_MI_MYSHOP_USE_PRICE', "金額欄を使用しますか？");
define('_MI_MYSHOP_USE_PRICE_DSC', "このオプションにより金額を非表示として商品カタログ等に利用出来ます。");

define('_MI_MYSHOP_PERSISTENT_CART', "Do you want to use the persistent cart?");
define('_MI_MYSHOP_PERSISTENT_CART_DSC', "when this option is set to Yes, the user's cart is saved (Warning, this option will consume resources)");

define('_MI_MYSHOP_RESTRICT_ORDERS', "Restrict orders to registred users ?");
define('_MI_MYSHOP_RESTRICT_ORDERS_DSC', "If you set this option to Yes then only the registred users can order products");

define('_MI_MYSHOP_RESIZE_MAIN', "Do you want to automatically resize the main picture of each product's picture ?");
define('_MI_MYSHOP_RESIZE_MAIN_DSC', '');

define('_MI_MYSHOP_CREATE_THUMBS', "Do you want the module to automatically create the product's thumb ?");
define('_MI_MYSHOP_CREATE_THUMBS_DSC', "If you don't use this option then you will have to upload products thumbs yourself");

define('_MI_MYSHOP_IMAGES_WIDTH', "Images width");
define('_MI_MYSHOP_IMAGES_HEIGHT', "Images height");

define('_MI_MYSHOP_THUMBS_WIDTH', "Thumbs width");
define('_MI_MYSHOP_THUMBS_HEIGHT', "Thumbs height");

define('_MI_MYSHOP_RESIZE_CATEGORIES', "Do you also want to resize categories'pictures and manufacturers pictures to the above dimensions ?");

define('_MI_MYSHOP_SHIPPING_QUANTITY', "Mutiply the produt's shipping amount by the product's quantity ?");
?>