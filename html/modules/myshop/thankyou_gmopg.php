<?php
/**
 * ****************************************************************************
 * GMO-PG - Payment Module as XOOPS Cube Module
 * Copyright (c) Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author             Yoshi Sakai a.k.a bluemooninc
 *
 * Version : $Id:
 * ****************************************************************************
 */
require 'header.php';
/**
 * GMO-PG Controller
 */
@error_reporting(0);
$datasGmopg = false;
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : NULL;
$success = false;
if (!is_null($orderId)) {
    $creditService = $root->mServiceManager->getService('gmoPayment');
    if ($creditService != null) {
        $client = $root->mServiceManager->createClient($creditService);
        $paid = $client->call('checkOrderStatus', array('orderID' => $orderId));
    }
    $commande = $h_myshop_commands->getLastUserOrder($xoopsUser->uid());
    if (is_object($commande)) {
        if ($paid == true) {
            // Order checked
            $h_myshop_commands->validateOrder($commande); // Validation and stocks update
            $h_myshop_caddy->emptyCart();
            $GLOBALS['current_category'] = -1;
            $success = true;
        } else {
            $h_myshop_commands->setFraudulentOrder($commande);
        }
    }
}
/*
 * forge::View
 */
require_once XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('success', $success);
$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL . basename(__FILE__) => _MYSHOP_PURCHASE_FINSISHED)));
$title = _MYSHOP_PURCHASE_FINSISHED . ' - ' . myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
myshop_utils::setCSS();
$xoopsOption['template_main'] = 'myshop_thankyou.html';
require_once(XOOPS_ROOT_PATH . '/footer.php');
?>
