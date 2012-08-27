<?php

// The name of this module
define("_MI_MYSHOP_NAME","My Shop");

// A brief description of this module
define("_MI_MYSHOP_DESC","Creates an online shop to display and sell products.");

// Names of blocks for this module (Not all module has blocks)
define("_MI_MYSHOP_BNAME1","Recent Products");
define("_MI_MYSHOP_BNAME2","Top Products");
define("_MI_MYSHOP_BNAME3","Categories");
define("_MI_MYSHOP_BNAME4","Best Sellers");
define("_MI_MYSHOP_BNAME5","Best Rated Products");
define("_MI_MYSHOP_BNAME6","Random Product");
define("_MI_MYSHOP_BNAME7","Products on promotion");
define("_MI_MYSHOP_BNAME8","Cart");
define("_MI_MYSHOP_BNAME9","Recommended products");

// Sub menu titles
define("_MI_MYSHOP_SMNAME1","Cart");
define("_MI_MYSHOP_SMNAME1_1","&nbsp;Watch my cart");
define("_MI_MYSHOP_SMNAME1_2","&nbsp;Order history");
define("_MI_MYSHOP_SMNAME2","Products");
define("_MI_MYSHOP_SMNAME2_1","&nbsp;Recommended Products");
define("_MI_MYSHOP_SMNAME2_2","&nbsp;All products");
define("_MI_MYSHOP_SMNAME2_3","&nbsp;Categories");
define("_MI_MYSHOP_SMNAME2_4","&nbsp;Categories map");
define("_MI_MYSHOP_SMNAME2_5","&nbsp;Search");
define("_MI_MYSHOP_SMNAME3","etc");
define("_MI_MYSHOP_SMNAME3_1","&nbsp;Sales policy");

// Names of admin menu items
define("_MI_MYSHOP_ADMENU0","Stores");
define("_MI_MYSHOP_ADMENU1","VAT");
define("_MI_MYSHOP_ADMENU2","Categories");
define("_MI_MYSHOP_ADMENU3","Manufacturers");
define("_MI_MYSHOP_ADMENU4","Products");
define("_MI_MYSHOP_ADMENU5","Orders");
define("_MI_MYSHOP_ADMENU6","Discounts");
define("_MI_MYSHOP_ADMENU7","Newsletter");
define("_MI_MYSHOP_ADMENU8", "Texts");
define("_MI_MYSHOP_ADMENU9", "Low stocks");
define("_MI_MYSHOP_ADMENU10", "Dashboard");
define("_MI_MYSHOP_ADMENU11", "Attached Files");

// Title of config items
define('_MI_MYSHOP_NEWLINKS', 'Select the maximum number of new products displayed on top page');
define('_MI_MYSHOP_PERPAGE', 'Select the maximum number of products displayed in each page');

// Description of each config items
define('_MI_MYSHOP_NEWLINKSDSC', '');
define('_MI_MYSHOP_PERPAGEDSC', '');

// Text for notifications

define('_MI_MYSHOP_GLOBAL_NOTIFY', 'Global');
define('_MI_MYSHOP_GLOBAL_NOTIFYDSC', 'Global lists notification options.');

define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFY', 'New Category');
define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYCAP', "Notify me when a new product's category is created.");
define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYDSC', "Receive notification when a new product's category is created.");
define('_MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New Product category');

define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFY', 'New Product');
define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYCAP', 'Notify me when any new product is posted.');
define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYDSC', 'Receive notification when any new product is posted.');
define('_MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New Product');

define('_MI_MYSHOP_PAYPAL_EMAIL', "Paypal Email address");
define('_MI_MYSHOP_PAYPAL_EMAILDSC', "Address to use for payments and orders notifications.<br /><u><b>If you don't fill this fields, then online payment is deactivated.</u></b>");
define('_MI_MYSHOP_PAYPAL_TEST', "Use Paypal sandbox ?");
define("_MI_MYSHOP_FORM_OPTIONS","Form Option");
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

define("_MI_MYSHOP_ADVERTISEMENT","Advertisement");
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
define('_MI_MYSHOP_URL_REWR',"Use Url Rewriting ?");

define('_MI_MYSHOP_MONEY_F',"Name of currency");
define('_MI_MYSHOP_MONEY_S',"Symbol for currency");
define('_MI_MYSHOP_MONEY_P',"Enter Paypal currency code");
define('_MI_MYSHOP_NO_MORE',"Display products even when there is no stock available ?");
define('_MI_MYSHOP_MSG_NOMORE',"Text to display when there's no more stock for a product");
define('_MI_MYSHOP_GRP_SOLD',"Group to send an email when a product is sold ?");
define('_MI_MYSHOP_GRP_QTY',"Group of users authorized to modify products quantities from the Product page");
define('_MI_MYSHOP_BEST_TOGETHER',"Display 'Better Together' ?");
define('_MI_MYSHOP_UNPUBLISHED',"Display product who's publication date if later than today ?");
define('_MI_MYSHOP_DECIMAL', "Decimal point for money");
define('_MI_MYSHOP_PDT', "Paypal - Payment Data Transfer Token (optional)");
define('_MI_MYSHOP_CONF04',"Thousands separator");
define('_MI_MYSHOP_CONF05', "Decimals separator");
define('_MI_MYSHOP_CONF00',"Money's position ?");
define('_MI_MYSHOP_CONF00_DSC', "Yes = right, No = left");
define('_MI_MYSHOP_MANUAL_META', "Enter meta data manually ?");

define('_MI_MYSHOP_OFFLINE_PAYMENT', "Do you want to enable offline payment?");
define('_MI_MYSHOP_OFF_PAY_DSC', "If you enable it, you must type some texts in the module's administration in the 'Texts' tab");

define('_MI_MYSHOP_USE_PRICE', "Do you want to use the price field?");
define('_MI_MYSHOP_USE_PRICE_DSC', "With this option you can disable products price (to do a catalog for example)");

define('_MI_MYSHOP_GMOPG_PAYMENT', "Do you want to use the GMO-PG?");
define('_MI_MYSHOP_GMOPG_PAY_DSC', "If you chose this option set GMO-PG config");
define('_MI_MYSHOP_GMOPG_URL', "GMO-PG payment URL");
define('_MI_MYSHOP_GMOPG_URL_DSC', "URL config for GMO-PG module");

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