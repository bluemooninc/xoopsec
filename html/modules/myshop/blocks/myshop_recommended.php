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

function b_myshop_recomm_show($options)
{
	// '10|0';	// Display 10 products from all categories or specify category id
	global $xoopsConfig, $xoopsTpl;
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	$products = $block = array();
	$start = 0;
	$limit = $options[0];
	$categoyrId = $options[1];

	$myshop_shelf_parameters->resetDefaultValues()->setProductsType('recommended')->setStart($start)->setLimit($limit)->setSort('product_recommended')->setOrder('DESC')->setCategory($categoyrId);
	$products = $myshop_shelf->getProducts($myshop_shelf_parameters);

	if($h_myshop_products->getRecommendedCount() > $limit) {
		$block['showMore'] = true;
	}
	if(isset($products['lastTitle'])) {
		unset($products['lastTitle']);
	}
	if(count($products) > 0) {
		$url = MYSHOP_URL.'include/myshop.css';
		$block['nostock_msg'] = myshop_utils::getModuleOption('nostock_msg');
		$block['block_products']= $products;
		$xoopsTpl->assign("xoops_module_header", "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" />");
		return $block;
	} else {
		return false;
	}
}

/**
 * Block Settings
 */
function b_myshop_recomm_edit($options)
{
	// '10|0';	// Display 10 products from all categories
	global $xoopsConfig;
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	include_once MYSHOP_PATH.'class/tree.php';
	$tblCategories = array();
	$tblCategories = $h_myshop_cat->getAllCategories();
	$mytree = new Myshop_XoopsObjectTree($tblCategories, 'cat_cid', 'cat_pid');
	$form = '';
	$checkeds = array('','');
	$checkeds[$options[1]] = 'checked';
	$form .= "<table border='0'>";
	$form .= '<tr><td>'._MB_MYSHOP_PRODUCTS_CNT . "</td><td><input type='text' name='options[]' id='options' value='".$options[0]."' /></td></tr>";
	$select = $mytree->makeSelBox('options[]', 'cat_title', '-', $options[1], _MB_MYSHOP_ALL_CATEGORIES);
	$form .= '<tr><td>'._MB_MYSHOP_CATEGORY.'</td><td>'.$select.'</td></tr>';
	$form .= '</table>';
	return $form;
}

/**
 * Random Block
 */
function b_myshop_recomm_show_duplicatable($options)
{
	$options = explode('|',$options);
	$block = & b_myshop_recomm_show($options);

	$tpl = new XoopsTpl();
	$tpl->assign('block', $block);
	$tpl->display('db:myshop_block_recommended.html');
}
?>