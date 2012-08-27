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
 * @author             Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

/**
 * commands
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_orderhistory.html';
require_once XOOPS_ROOT_PATH . '/header.php';
$statusMessage = array(
    _MYSHOP_CMD_STATE1,
    _MYSHOP_CMD_STATE2,
    _MYSHOP_CMD_STATE3,
    _MYSHOP_CMD_STATE4,
    _MYSHOP_CMD_STATE5,
    _MYSHOP_CMD_STATE6
);
$tblAll = $tblAnnuaire = array();
$commands = $h_myshop_commands->getLastUserOrder($xoopsUser->uid(), 10);
$orderList = array();
foreach ($commands as $key => $val) {
    $orderList[] = array(
        'id' => $val->get('cmd_id'),
        'date' => $val->get('cmd_date'),
        'total' => $val->get('cmd_total'),
        'shipping' => $val->get('cmd_shipping'),
        'state' => $statusMessage[$val->get('cmd_state')]
    );
}
$xoopsTpl->assign('orderList', $orderList);

myshop_utils::setCSS();
if (file_exists(MYSHOP_PATH . 'language/' . $xoopsConfig['language'] . '/modinfo.php')) {
    require_once MYSHOP_PATH . 'language/' . $xoopsConfig['language'] . '/modinfo.php';
} else {
    require_once MYSHOP_PATH . 'language/english/modinfo.php';
}
$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL . basename(__FILE__) => _MI_MYSHOP_SMNAME5)));

$title = _MI_MYSHOP_SMNAME5 . ' - ' . myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
require_once XOOPS_ROOT_PATH . '/footer.php';
