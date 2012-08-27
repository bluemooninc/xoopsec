<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

/**
 * Module parameters
 */

// Location of attached files, url and physical path
if(!defined("MYSHOP_ATTACHED_FILES_URL")) {
	// Define here the place where files attached to products are saved
	define("MYSHOP_ATTACHED_FILES_URL", XOOPS_UPLOAD_URL);		// WITHOUT Trailing slash
	define("MYSHOP_ATTACHED_FILES_PATH", XOOPS_UPLOAD_PATH);	// WITHOUT Trailing slash

	// Define here where pictures are saved
	define("MYSHOP_PICTURES_URL", XOOPS_UPLOAD_URL);		// WITHOUT Trailing slash
	define("MYSHOP_PICTURES_PATH", XOOPS_UPLOAD_PATH);		// WITHOUT Trailing slash

	// Maximum length of product's summary for pages (in characters)
	define("MYSHOP_SUMMARY_MAXLENGTH", 500);

	// Used in checkout to select a default country
	define("MYSHOP_DEFAULT_COUNTRY", 'EN');

	// RSS Feed cache duration (in minutes)
	define("MYSHOP_RSS_CACHE", 3600);

	// Maximum products count to display before to use a pager (inside products lists)
	define("MYSHOP_MAX_PRODUCTS", 200);

	// Newsletter URL (the folder must be writable)
	define("MYSHOP_NEWSLETTER_URL", XOOPS_URL.'/uploads/myshop_newsletter.txt');
	// Newsletter PATH (the folder must be writable)
	define("MYSHOP_NEWSLETTER_PATH", XOOPS_ROOT_PATH.'/uploads/myshop_newsletter.txt');

	// CSV path (the folder must be writable)
	define("MYSHOP_CSV_PATH", XOOPS_UPLOAD_PATH);
	// CSV URL (the folder must be writable)
	define("MYSHOP_CSV_URL", XOOPS_UPLOAD_URL);
	// CSV Separator
	define("MYSHOP_CSV_SEP", '|');

	// Paypal log's path (must be writable)
	define("MYSHOP_PAYPAL_LOG_PATH", XOOPS_TRUST_PATH.'/cache/logpaypal_myshop.php');

	// Do you want to show the list of main categories on the category page when user is on category.php (without specifying a category to see)
	define("MYSHOP_SHOW_MAIN_CATEGORIES", true);
	// Do you want to sho the list of sub categories of the current category on the category page (when viewing a specific category)
	define("MYSHOP_SHOW_SUB_CATEGORIES", true);

	// String to use to join the list of manufacturers of each product
	define("MYSHOP_STRING_TO_JOIN_MANUFACTURERS", ', ');

	// Thumbs prefix (when thumbs are automatically created)
	define("MYSHOP_THUMBS_PREFIX", 'thumb_');

	// Popup width and height (used in the product.php page to show the media.php page)
	define("MYSHOP_POPUP_MEDIA_WIDTH", 640);
	define("MYSHOP_POPUP_MEDIA_HEIGHT", 480);

	// Maximum attached files count to display on the product page
	define("MYSHOP_MAX_ATTACHMENTS", 20);

	// Define the MP3 player's dimensions (dewplayer)
	define("MYSHOP_DEWPLAYER_WIDTH", 240);		// I do not recommend to go lower than 240 pixels !!!!
	define("MYSHOP_DEWPLAYER_HEIGHT", 20);
}
?>