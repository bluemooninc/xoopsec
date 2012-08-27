<?php

// Display Product Promotion

function b_myshop_promotion_show($options)
{
	// '10|0';	// Display 10 products from all categories or specify category id
	global $xoopsConfig, $xoopsTpl;
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	$block = $products = array();
	$start = 0;
	$limit = $options[0];
	$categoryId = $options[1];

	$myshop_shelf_parameters->resetDefaultValues()->setProductsType('promotional')->setStart($start)->setLimit($limit)->setSort('product_submitted DESC, product_title')->setOrder('ASC')->setCategory($categoryId);
	$products = $myshop_shelf->getProducts($myshop_shelf_parameters);
	if(isset($products['lastTitle'])) {
		unset($products['lastTitle']);
	}
	if(count($products) > 0) {
		$url = MYSHOP_URL.'include/myshop.css';
		$block['nostock_msg'] = myshop_utils::getModuleOption('nostock_msg');
		$block['block_products'] = $products;
//		$xoopsTpl->assign("xoops_module_header", "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" />");
		return $block;
	} else {
		return false;
	}
}

// Block Settings

function b_myshop_promotion_edit($options)
{
	// '10|0';	// Display 10 products from all categories or specify category id
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
	//$form .= '<tr><td>'._MB_MYSHOP_SORT_ORDER."</td><td><input type='radio' name='options[]' id='options[]' value='0' ".$checkeds[0]." />"._MB_MYSHOP_SORT_1." <input type='radio' name='options[]' id='options[]' value='1' ".$checkeds[1]." />"._MB_MYSHOP_SORT_2.'</td></tr>';
	$select = $mytree->makeSelBox('options[]', 'cat_title', '-', $options[1], _MB_MYSHOP_ALL_CATEGORIES);
	$form .= '<tr><td>'._MB_MYSHOP_CATEGORY.'</td><td>'.$select.'</td></tr>';
	$form .= '</table>';
	return $form;
}

// Random Block

function b_myshop_promotion_show_duplicatable($options)
{
	$options = explode('|',$options);
	$block = & b_myshop_promotion_show($options);

	$tpl = new XoopsTpl();
	$tpl->assign('block', $block);
	$tpl->display('db:myshop_block_promotion.html');
}
?>