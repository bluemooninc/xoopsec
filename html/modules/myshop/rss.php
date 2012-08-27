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
 * RSS last products
 */
require 'header.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';

if(myshop_utils::getModuleOption('use_rss') == 0) {
	exit;
}
// Last cat_cid
$cat_cid = isset($_GET['cat_cid']) ? intval($_GET['cat_cid']) : 0;
if (function_exists('mb_http_output')) {
	mb_http_output('pass');
}
$charset = 'utf-8';
header ('Content-Type:text/xml; charset='.$charset);
$tpl = new XoopsTpl();

$tpl->xoops_setCaching(2);					// 1 = Global Cache, 2 = Individual Cache (by template)
$tpl->xoops_setCacheTime(MYSHOP_RSS_CACHE);	// Time cache in seconds

if (!$tpl->is_cached('db:myshop_rss.html', $cat_cid)) {
	$categoryTitle = '';
	if(!empty($cat_cid)) {
		$category = null;
		$category = $h_myshop_cat->get($cat_cid);
		if(is_object($category)) {
			$categoryTitle = $category->getVar('cat_title');
		}
	}
	$sitename = htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES);
	$email = checkEmail($xoopsConfig['adminmail'],true);
	$slogan = htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES);
	$limit = myshop_utils::getModuleOption('perpage');

	$tpl->assign('charset',$charset);
	$tpl->assign('channel_title', xoops_utf8_encode($sitename));
	$tpl->assign('channel_link', XOOPS_URL.'/');
	$tpl->assign('channel_desc', xoops_utf8_encode($slogan));
	$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
	$tpl->assign('channel_webmaster', xoops_utf8_encode($email));
	$tpl->assign('channel_editor', xoops_utf8_encode($email));
	$tpl->assign('channel_category', xoops_utf8_encode($categoryTitle));
	$tpl->assign('channel_generator', xoops_utf8_encode(myshop_utils::getModuleName()));
	$tpl->assign('channel_language', _LANGCODE);
	$tpl->assign('image_url', XOOPS_URL.'/images/logo.gif');
	$dimention = getimagesize(XOOPS_ROOT_PATH.'/images/logo.gif');
	if (empty($dimention[0])) {
		$width = 88;
	} else {
		$width = ($dimention[0] > 144) ? 144 : $dimention[0];
	}
	if (empty($dimention[1])) {
		$height = 31;
	} else {
		$height = ($dimention[1] > 400) ? 400 : $dimention[1];
	}
	$tpl->assign('image_width', $width);
	$tpl->assign('image_height', $height);

	$tblProducts = $h_myshop_products->getRecentProducts(0, $limit, $cat_cid);
	foreach($tblProducts as $item) {
		$title = htmlspecialchars($item->getVar('product_title'), ENT_QUOTES);
		$description = htmlspecialchars(strip_tags($item->getVar('product_summary')), ENT_QUOTES);
		$link = $item->getLink();
		$tpl->append('items', array('title' => xoops_utf8_encode($title),
          		'link' => $link,
          		'guid' => $link,
          		'pubdate' => formatTimestamp($item->getVar('product_submitted'), 'rss'),
          		'description' => xoops_utf8_encode($description)));
	}
}
$tpl->display('db:myshop_rss.html', $cat_cid);
?>