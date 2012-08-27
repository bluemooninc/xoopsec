<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}
$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;

$modversion['name'] = _MI_MYSHOP_NAME;
$modversion['version'] = 1.7;
$modversion['description'] = _MI_MYSHOP_DESC;
$modversion['author'] = "Myshop is originally based on Bookshop module by Instant Zero";
$modversion['credits'] = "Author Herve Thouzard. Update by Nuno Luciano";
$modversion['help'] = '';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image']       = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = 'myshop';

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'myshop_manufacturer';
$modversion['tables'][1] = 'myshop_products';
$modversion['tables'][2] = 'myshop_productsmanu';
$modversion['tables'][3] = 'myshop_caddy';
$modversion['tables'][4] = 'myshop_cat';
$modversion['tables'][5] = 'myshop_commands';
$modversion['tables'][6] = 'myshop_related';
$modversion['tables'][7] = 'myshop_vat';
$modversion['tables'][8] = 'myshop_votedata';
$modversion['tables'][9] = 'myshop_discounts';
$modversion['tables'][10] = 'myshop_stores';
$modversion['tables'][11] = 'myshop_files';
$modversion['tables'][12] = 'myshop_persistent_cart';

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Blocks
$cptb = 0;

/**
 * Recent products block
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_new.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME1;
$modversion['blocks'][$cptb]['description'] = 'Shows recently added products titles';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_new_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_new_edit';
$modversion['blocks'][$cptb]['options'] = '10|0|0';	// Display 10 products all categories or month only
$modversion['blocks'][$cptb]['template'] = 'myshop_block_new.html';

/**
 * Most viewed products block
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_top.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME2;
$modversion['blocks'][$cptb]['description'] = 'Shows most viewed products titles';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_top_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_top_edit';
$modversion['blocks'][$cptb]['options'] = '10|0';
$modversion['blocks'][$cptb]['template'] = 'myshop_block_top.html';

/**
 * Categories block
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_categories.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME3;
$modversion['blocks'][$cptb]['description'] = 'Show categories in relation with the category page';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_category_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_category_edit';
$modversion['blocks'][$cptb]['options'] = '0';	// 0 = Related to page, 1=classic
$modversion['blocks'][$cptb]['template'] = 'myshop_block_categories.html';

/**
 * Best sellers block
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_best_sales.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME4;
$modversion['blocks'][$cptb]['description'] = 'Show most solded products';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_bestsales_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_bestsales_edit';
$modversion['blocks'][$cptb]['options'] = '10|0';	// 10 products for all categories
$modversion['blocks'][$cptb]['template'] = 'myshop_block_bestsales.html';

/**
 * Top rated products
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_rated.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME5;
$modversion['blocks'][$cptb]['description'] = 'Shows best rated product';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_rated_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_rated_edit';
$modversion['blocks'][$cptb]['options'] = '10|0';
$modversion['blocks'][$cptb]['template'] = 'myshop_block_rated.html';

/**
 * Random product(s) block
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_random.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME6;
$modversion['blocks'][$cptb]['description'] = 'Shows a random product';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_random_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_random_edit';
$modversion['blocks'][$cptb]['options'] = '1|0|0';	// Number of products, category, products of month only
$modversion['blocks'][$cptb]['template'] = 'myshop_block_random.html';

/**
 * Products with a discount block
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_promotion.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME7;
$modversion['blocks'][$cptb]['description'] = 'Shows products in promotion';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_promotion_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_promotion_edit';
$modversion['blocks'][$cptb]['options'] = '10|0';
$modversion['blocks'][$cptb]['template'] = 'myshop_block_promotion.html';

/**
 * Cart block
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_cart.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME8;
$modversion['blocks'][$cptb]['description'] = 'Shows cart';
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_cart_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_cart_edit';
$modversion['blocks'][$cptb]['options'] = '4';	// Maximum count of items to show
$modversion['blocks'][$cptb]['template'] = 'myshop_block_cart.html';

/**
 * Recommended products
 */
$cptb++;
$modversion['blocks'][$cptb]['file'] = 'myshop_recommended.php';
$modversion['blocks'][$cptb]['name'] = _MI_MYSHOP_BNAME9;
$modversion['blocks'][$cptb]['description'] = "Shows last recommanded products";
$modversion['blocks'][$cptb]['show_func'] = 'b_myshop_recomm_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_myshop_recomm_edit';
$modversion['blocks'][$cptb]['options'] = '10|0';
$modversion['blocks'][$cptb]['template'] = 'myshop_block_recommended.html';


// Menu
$modversion['hasMain'] = 1;
$cptm = 0;
require_once 'class/myshop_utils.php';

if(myshop_utils::getModuleOption('use_price')) {
	$cptm++;
	$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME1;
	$modversion['sub'][$cptm]['url'] = '';
    $cptm++;
    $modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME1_1;
    $modversion['sub'][$cptm]['url'] = 'caddy.php';
    $cptm++;
    $modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME1_2;
    $modversion['sub'][$cptm]['url'] = 'order-history.php';
}
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME2;
$modversion['sub'][$cptm]['url'] = '';
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME2_1;
$modversion['sub'][$cptm]['url'] = 'recommended.php';
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME2_2;
$modversion['sub'][$cptm]['url'] = 'category.php';
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME2_3;
$modversion['sub'][$cptm]['url'] = 'categories-map.php';
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME2_4;
$modversion['sub'][$cptm]['url'] = 'all-products.php';
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME2_5;
$modversion['sub'][$cptm]['url'] = 'search.php';
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME3;
$modversion['sub'][$cptm]['url'] = '';
$cptm++;
$modversion['sub'][$cptm]['name'] = _MI_MYSHOP_SMNAME3_1;
$modversion['sub'][$cptm]['url'] = 'cgv.php';

// Add parent categories as sub-menu 
global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname'] && $xoopsModule->getVar('isactive')) {
	if(!isset($h_myshop_cat)) {
		$h_myshop_cat = xoops_getmodulehandler('myshop_cat', 'myshop');
	}
	$categories = $h_myshop_cat->getMotherCategories();
	foreach($categories as $category) {
		$cptm++;
		$modversion['sub'][$cptm]['name'] = $category->getVar('cat_title');
		$modversion['sub'][$cptm]['url'] = basename($category->getLink());
	}
}

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'myshop_search';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'product_id';
$modversion['comments']['pageName'] = 'product.php';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'myshop_com_approve';
$modversion['comments']['callback']['update'] = 'myshop_com_update';

// Templates
$cptt = 0;

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_chunk.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_categories_list.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_index.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_category.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_product.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_bill.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_caddy.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_command.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_thankyou.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_cgv.html';
$modversion['templates'][$cptt]['description'] = 'General Conditions Of Sale';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_search.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_rss.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_map.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_orderhistory.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_allproducts.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_manufacturer.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_rate_product.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_pdf_catalog.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_purchaseorder.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_cancelpurchase.html';
$modversion['templates'][$cptt]['description'] = '';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_recommended.html';
$modversion['templates'][$cptt]['description'] = 'Latest recommended products';

$cptt++;
$modversion['templates'][$cptt]['file'] = 'myshop_admin_discounts.html';
$modversion['templates'][$cptt]['description'] = '';

// SETTINGS 

$cpto = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'newproducts';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_NEWLINKS';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_NEWLINKSDSC';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 10;

$cpto++;
$modversion['config'][$cpto]['name'] = 'perpage';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_PERPAGE';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_PERPAGEDSC';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 10;

/**
 * Enable offline payment ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'offline_payment';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_OFFLINE_PAYMENT';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_OFF_PAY_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Enable GMO-PG payment ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'gmopg_payment';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_GMOPG_PAYMENT';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_GMOPG_PAY_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;
$cpto++;
$modversion['config'][$cpto] = array(
    'name' => 'gmopg_url',
    'title' => '_MI_MYSHOP_GMOPG_URL',
    'description' => '_MI_MYSHOP_GMOPG_URL_DESC',
    'formtype' => 'text',
    'valuetype' => 'text',
    'default' => ''
);
/**
 * Email address to use for Paypal
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'paypal_email';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_PAYPAL_EMAIL';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_PAYPAL_EMAILDSC';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '';

/**
 * Paypal money's code
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'paypal_money';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_MONEY_P';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'select';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['options'] = array(
											'Australian Dollar' => 'AUD',
											'Canadian Dollar' => 'CAD',
											'Swiss Franc' => 'CHF',
											'Czech Koruna' => 'CZK',
											'Danish Krone' => 'DKK',
											'Euro' => 'EUR',
											'Pound Sterling' => 'GBP',
											'Hong Kong Dollar' => 'HKD',
											'Hungarian Forint' => 'HUF' ,
											'Japanese Yen' => 'JPY',
											'Norwegian Krone' => 'NOK',
											'New Zealand Dollar' => 'NZD',
											'Polish Zloty' => 'PLN',
											'Swedish Krona' => 'SEK',
											'Singapore Dollar' => 'SGD',
											'U.S. Dollar' => 'USD'
											);
$modversion['config'][$cpto]['default'] = 'EUR';

/**
 * Paypal development
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'paypal_test';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_PAYPAL_TEST';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Money, full label
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'money_full';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_MONEY_F';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '円';

/**
 * Money, short label
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'money_short';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_MONEY_S';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '円';

/**
 * Decimals count
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'decimals_count';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_DECIMAL';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = '0';

/**
 * Money symbol (left or right)
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'monnaie_place';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CONF00';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_CONF00_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Thousands separator
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'thousands_sep';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CONF04';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = ',';   //[space]

/**
 * Decimal separator
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'decimal_sep';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CONF05';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '.';

/**
 * URL rewriting
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'urlrewriting';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_URL_REWR';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Editor to use
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'bl_form_options';
$modversion['config'][$cpto]['title'] = "_MI_MYSHOP_FORM_OPTIONS";
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_FORM_OPTIONS_DESC';
$modversion['config'][$cpto]['formtype'] = 'select';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['options'] = array(
											_MI_MYSHOP_FORM_DHTML=>'dhtml',
											//_MI_MYSHOP_FORM_COMPACT=>'textarea',
											//_MI_MYSHOP_FORM_SPAW=>'spaw',
											//_MI_MYSHOP_FORM_HTMLAREA=>'htmlarea',
											//_MI_MYSHOP_FORM_KOIVI=>'koivi',
											_MI_MYSHOP_FORM_FCK=>'fck',
											//_MI_MYSHOP_FORM_TINYEDITOR=>'tinyeditor'
											);
$modversion['config'][$cpto]['default'] = 'dhtml';

/**
 * Tooltips, or infotips are some small textes you can see when you
 * move your mouse over an article's title. This text contains the
 * first (x) characters of the story
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'infotips';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_INFOTIPS';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_INFOTIPS_DES';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = '0';

/**
 * MAX Filesize Upload in kilo bytes
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'maxuploadsize';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_UPLOADFILESIZE';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1048576;


/**
 * If you set this option to yes then you will see two links at the bottom
 * of each item. The first link will enable you to go to the previous
 * item and the other link will bring you to the next item
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'showprevnextlink';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_PREVNEX_LINK';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_PREVNEX_LINK_DESC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Display a summary table of the last published products (in all categories) ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'summarylast';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_SUMMARY1_SHOW';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_SUMMARY1_SHOW_DESC';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 10;

/**
 * Display a summary table of the last published products in the same category ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'summarycategory';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_SUMMARY2_SHOW';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_SUMMARY2_SHOW_DESC';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 10;


/**
 * Better Together ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'better_together';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_BEST_TOGETHER';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Display unpublished products ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'show_unpublished';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_UNPUBLISHED';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * METAGEN, Max count of keywords to create
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'metagen_maxwords';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_OPT23';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_OPT23_DSC';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 40;

/**
 * METAGEN - Keywords order
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'metagen_order';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_OPT24';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'select';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 5;
$modversion['config'][$cpto]['options'] = array('_MI_MYSHOP_OPT241' => 0, '_MI_MYSHOP_OPT242' => 1, '_MI_MYSHOP_OPT243' => 2);

/**
 * METAGEN - Black list
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'metagen_blacklist';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_OPT25';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_OPT25_DSC';
$modversion['config'][$cpto]['formtype'] = 'textarea';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '';

/**
 * Do you want to enable your visitors to rate products ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'rateproducts';
$modversion['config'][$cpto]['title'] = "_MI_MYSHOP_RATE";
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Global module's Advertisement
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'advertisement';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_ADVERTISEMENT';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_ADV_DESCR';
$modversion['config'][$cpto]['formtype'] = 'textarea';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '';

/**
 * Mime Types
 * Default values : Web pictures (png, gif, jpeg), zip, pdf, gtar, tar, pdf
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'mimetypes';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_MIMETYPES';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textarea';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = "image/gif\nimage/jpeg\nimage/pjpeg\nimage/x-png\nimage/png\napplication/x-zip-compressed\napplication/zip\napplication/pdf\napplication/x-gtar\napplication/x-tar";

/**
 * Group of users to which send an email when a product's stock is low (if nothing is typed then there's no alert)
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'stock_alert_email';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_STOCK_EMAIL';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_STOCK_EMAIL_DSC';
$modversion['config'][$cpto]['formtype'] = 'group';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Group of users to wich send an email when a product is sold
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'grp_sold';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_GRP_SOLD';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'group';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Group of users authorized to modify products quantities from the product page
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'grp_qty';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_GRP_QTY';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'group';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;


/**
 * Display products when there are no more products ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'nostock_display';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_NO_MORE';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Message to display when there's not more quantity for a product ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'nostock_msg';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_MSG_NOMORE';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textarea';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '';

/**
 * Use RSS Feeds ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'use_rss';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_OPT7';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_OPT7_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Enable PDF Catalog ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'pdf_catalog';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_PDF_CATALOG';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Enter meta data manually ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'manual_meta';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_MANUAL_META';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Count of visible items in the module's administration
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'items_count';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_ITEMSCNT';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 15;

/**
 * Use the price field ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'use_price';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_USE_PRICE';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_USE_PRICE_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Use the persistent cart ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'persistent_cart';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_PERSISTENT_CART';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_PERSISTENT_CART_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

/**
 * Restrict orders to registred users ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'restrict_orders';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_RESTRICT_ORDERS';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_RESTRICT_ORDERS_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Do you want to automatically resize the main picture of each product ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'resize_main';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_RESIZE_MAIN';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_RESIZE_MAIN_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Create thumbs automatically ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'create_thumbs';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CREATE_THUMBS';
$modversion['config'][$cpto]['description'] = '_MI_MYSHOP_CREATE_THUMBS_DSC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Images width
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'images_width';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_IMAGES_WIDTH';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 150;

/**
 * Images height
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'images_height';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_IMAGES_HEIGHT';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 150;

/**
 * Thumbs width
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'thumbs_width';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_THUMBS_WIDTH';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 80;

/**
 * Thumbs height
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'thumbs_height';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_THUMBS_HEIGHT';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 80;

/**
 * Do you also want to resize categories'pictures to the above dimensions ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'resize_others';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_RESIZE_CATEGORIES';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

/**
 * Multiply Shipping by product's quantity ?
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'shipping_quantity';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_SHIPPING_QUANTITY';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;


// Hidden settings
$cpto++;
$modversion['config'][$cpto]['name'] = 'chunk1';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CHUNK1';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'text';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

$cpto++;
$modversion['config'][$cpto]['name'] = 'chunk2';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CHUNK2';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'text';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 2;

$cpto++;
$modversion['config'][$cpto]['name'] = 'chunk3';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CHUNK3';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'text';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 3;

$cpto++;
$modversion['config'][$cpto]['name'] = 'chunk4';
$modversion['config'][$cpto]['title'] = '_MI_MYSHOP_CHUNK4';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'text';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 4;

// Notifications
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'myshop_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_MYSHOP_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_MYSHOP_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php','category.php','product.php', 'categories-map.php', 'all-products.php');

$modversion['notification']['event'][1]['name'] = 'new_category';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_newcategory_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_MYSHOP_GLOBAL_NEWCATEGORY_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'new_product';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['title'] = _MI_MYSHOP_GLOBAL_NEWLINK_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_newproduct_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_MYSHOP_GLOBAL_NEWLINK_NOTIFYSBJ;
?>