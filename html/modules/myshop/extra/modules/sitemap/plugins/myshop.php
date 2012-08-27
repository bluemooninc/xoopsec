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

function b_sitemap_myshop() {
	require '../myshop/header.php';
	global $sitemap_configs;
	$xoopsDB =& Database::getInstance();
	$table = $xoopsDB->prefix('myshop_cat');
	$id_name = 'cat_cid';
	$pid_name = 'cat_pid';
	$title_name = 'cat_title';
	$url = 'category.php?cat_cid=';
	$order = 'cat_title';

	include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
	$mytree = new XoopsTree($table, $id_name, $pid_name);
	$xoopsDB =& Database::getInstance();

	$sitemap = array();
	$myts =& MyTextSanitizer::getInstance();

	$i = 0;
	$sql = "SELECT `$id_name`,`$title_name` FROM `$table` WHERE `$pid_name`=0" ;
	if ($order != '') {
		$sql .= " ORDER BY `$order`" ;
	}
	$result = $xoopsDB->query($sql);
	while (list($catid, $name) = $xoopsDB->fetchRow($result))
	{
		$sitemap['parent'][$i]['id'] = $catid;
		$sitemap['parent'][$i]['title'] = $myts->makeTboxData4Show( $name ) ;
		if( myshop_utils::getModuleOption('urlrewriting') == 1 ) {	// On utilise l'url rewriting
			$url = 'category'.'-'.intval($catid).myshop_utils::makeSeoUrl($name).'.html';
		} else {	// Pas d'utilisation de l'url rewriting
			$url = 'category.php?cat_cid='.intval($catid);
		}
		$sitemap['parent'][$i]['url'] = $url;

		if(@$sitemap_configs["show_subcategoris"]){
			$j = 0;
			$child_ary = $mytree->getChildTreeArray($catid, $order);
			foreach ($child_ary as $child)
			{
				$count = strlen($child['prefix']) + 1;
				$sitemap['parent'][$i]['child'][$j]['id'] = $child[$id_name];
				$sitemap['parent'][$i]['child'][$j]['title'] = $myts->makeTboxData4Show( $child[$title_name] ) ;
				$sitemap['parent'][$i]['child'][$j]['image'] = (($count > 3) ? 4 : $count);
				if( myshop_utils::getModuleOption('urlrewriting') == 1 ) {	// On utilise l'url rewriting
					$url = 'category'.'-'.intval($child[$id_name]).myshop_utils::makeSeoUrl($child[$title_name]).'.html';
				} else {	// Pas d'utilisation de l'url rewriting
					$url = 'category.php?cat_cid='.intval($child[$id_name]);
				}
				$sitemap['parent'][$i]['child'][$j]['url'] = $url;

				$j++;
			}
		}
		$i++;
	}
	return $sitemap;
}
?>