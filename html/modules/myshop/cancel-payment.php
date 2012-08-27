<?php

/**
 * Page for Paypal if order is cancelled
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_cancelpurchase.html';
require_once XOOPS_ROOT_PATH . '/header.php';

require_once MYSHOP_PATH.'class/myshop_paypal.php';
if(isset($_GET['id'])) {
	$order = null;
	$order = $h_myshop_commands->getOrderFromCancelPassword($_GET['id']);
	if(is_object($order)) {
		$h_myshop_commands->setOrderCanceled($order);
	}
	$h_myshop_caddy->emptyCart();
}

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_ORDER_CANCELED)));

$title = _MYSHOP_ORDER_CANCELED.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
myshop_utils::setCSS();
require_once(XOOPS_ROOT_PATH . '/footer.php');
?>
