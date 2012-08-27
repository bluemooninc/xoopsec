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
 * Paypal confirmation
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
require_once MYSHOP_PATH.'class/myshop_paypal.php';
@error_reporting(0);
$success = true;
$datasPaypal = false;
$success = true;

$xoopsOption['template_main'] = 'myshop_thankyou.html';
require_once XOOPS_ROOT_PATH . '/header.php';
$h_myshop_caddy->emptyCart();
$xoopsTpl->assign('success', $success);

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_PURCHASE_FINSISHED)));

$title = _MYSHOP_PURCHASE_FINSISHED.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
myshop_utils::setCSS();
require_once(XOOPS_ROOT_PATH . '/footer.php');
?>
