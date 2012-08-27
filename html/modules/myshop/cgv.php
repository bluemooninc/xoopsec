<?php

/**
 * conditions
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_cgv.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once MYSHOP_PATH.'class/registryfile.php';

$registry = new myshop_registryfile();

$xoopsTpl->assign('nostock_msg', myshop_utils::getModuleOption('nostock_msg'));
$xoopsTpl->assign('mod_pref', $mod_pref);
$xoopsTpl->assign('cgv_msg', $registry->getfile(MYSHOP_TEXTFILE2));

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_CGV)));

myshop_utils::setCSS();
myshop_utils::setMetas(_MYSHOP_CGV.' '.myshop_utils::getModuleName(), _MYSHOP_CGV.' '.myshop_utils::getModuleName());
require_once(XOOPS_ROOT_PATH . '/footer.php');
?>
