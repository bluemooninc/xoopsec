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

/**
 * Product vote
 */
require 'header.php';

$product_id = 0;
// Permissions to vote
if(myshop_utils::getModuleOption('rateproducts') == 0 ) {
	myshop_utils::redirect(_MYSHOP_NORATE, 'index.php', 5);
}
//  Product n�
if(isset($_GET['product_id'])) {
	$product_id = intval($_GET['product_id']);
} elseif(isset($_POST['product_id'])) {
	$product_id = intval($_POST['product_id']);
} else {
	myshop_utils::redirect(_MYSHOP_ERROR1, 'index.php', 5);
}
// product exists
$product = null;
$product = $h_myshop_products->get($product_id);
if(!is_object($product)) {
	myshop_utils::redirect(_MYSHOP_ERROR1, 'index.php', 5);
}

// product on-line
if($product->getVar('product_online') == 0) {
	myshop_utils::redirect(_MYSHOP_ERROR2, 'index.php', 5);
}

// product publish
if(myshop_utils::getModuleOption('show_unpublished') == 0 && $product->getVar('product_submitted') > time()) {
	myshop_utils::redirect(_MYSHOP_ERROR3, 'index.php', 5);
}

// stock required
if(myshop_utils::getModuleOption('nostock_display') == 0 && $product->getVar('product_stock') == 0) {
	if(xoops_trim(myshop_utils::getModuleOption('nostock_display')) != '') {
		myshop_utils::redirect(myshop_utils::getModuleOption('nostock_display'), 'index.php', 5);
	}
}


if(!empty($_POST['btnsubmit'])) {
	$GLOBALS['current_category'] = -1;

	$ratinguser = myshop_utils::getCurrentUserID();
	$canRate = true;
	if ($ratinguser != 0) {
		if($h_myshop_votedata->hasUserAlreadyVoted($ratinguser, $product->getVar('product_id'))) {
			$canRate = false;
		}
	} else {
		if(hasAnonymousAlreadyVoted('', $product->getVar('product_id'))) {
			$canRate = false;
		}
	}
	if($canRate) {
		if($_POST['rating'] == '--' ) {
			myshop_utils::redirect(_MYSHOP_NORATING, MYSHOP_URL.'product.php?product_id='.$product->getVar('product_id'),4);
		}
		$rating = intval($_POST['rating']);
		if($rating <1 || $rating > 10) {
			exit(_ERRORS);
		}
		$result = $h_myshop_votedata->createRating($product->getVar('product_id'), $ratinguser, $rating);

		$totalVotes = 0;
		$sumRating = 0;
		$ret = 0;
		$ret = $h_myshop_votedata->getCountRecordSumRating($product->getVar('product_id'), $totalVotes, $sumRating);

		$finalrating = $sumRating / $totalVotes;
		$finalrating = number_format($finalrating, 4);
		$h_myshop_products->updateRating($product_id, $finalrating, $totalVotes);
		$ratemessage = _MYSHOP_VOTEAPPRE.'<br />'.sprintf(_MYSHOP_THANKYOU,$xoopsConfig['sitename']);
		myshop_utils::redirect($ratemessage, MYSHOP_URL.'product.php?product_id='.$product->getVar('product_id'), 2);
	} else {
		myshop_utils::redirect(_MYSHOP_VOTEONCE, MYSHOP_URL.'product.php?product_id='.$product->getVar('product_id'),5);
	}
} else {	// Display form
	$GLOBALS['current_category'] = $product->getVar('product_cid');
	$xoopsOption['template_main'] = 'myshop_rate_product.html';
	require_once XOOPS_ROOT_PATH . '/header.php';
	$xoopsTpl->assign('mod_pref', $mod_pref);
	$xoopsTpl->assign('product', $product->toArray());

	$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
	$breadcrumb = array( $product->getLink() => $product->getVar('product_title'),
				MYSHOP_URL.basename(__FILE__) => _MYSHOP_RATETHISPRODUCT);
	$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb($breadcrumb));

	$title = _MYSHOP_RATETHISPRODUCT.' : '.strip_tags($product->getVar('product_title')).' - '.myshop_utils::getModuleName();
	myshop_utils::setMetas($title, $title);
	myshop_utils::setCSS();
}


require_once XOOPS_ROOT_PATH . '/footer.php';
?>