<?php

// Display Recent Products

function b_myshop_new_show($options)
{
	// '10|0';	// Display 10 products from all categories or specify category id
	global $xoopsConfig, $xoopsTpl;
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	$tblLivres = $tblCategories = $tblTmp = $tbl_tmp_vat = $tbl_vat = $tbl_tmp_lang = $block = $tbl_books_id = array();
	$tblLivres = $h_myshop_products->getRecentProducts(0, $options[0], $options[1]);
	if(count($tblLivres) > 0) {
		$url = MYSHOP_URL.'myshop.css';
				$block['nostock_msg'] = myshop_utils::getModuleOption('nostock_msg');

		return $block;
	} else {
		return false;
	}
}


// Block Settings
function b_myshop_new_edit($options)
{
	// '10|0|0';	// Display 10 products, all categories
	global $xoopsConfig;
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	include_once MYSHOP_PATH.'class/tree.php';
	$tblCategories = array();
	$tblCategories = $h_myshop_cat->getAllCategories();
	$mytree = new Myshop_XoopsObjectTree($tblCategories, 'cat_cid', 'cat_pid');
	$form = '';
	$form .= "<table border='0'>";
	$form .= '<tr><td>'._MB_MYSHOP_PRODUCTS_CNT . "</td><td><input type='text' name='options[]' id='options' value='".$options[0]."' /></td></tr>";
	$select = $mytree->makeSelBox('options[]', 'cat_title', '-', $options[1], _MB_MYSHOP_ALL_CATEGORIES);
	$form .= '<tr><td>'._MB_MYSHOP_CATEGORY.'</td><td>'.$select.'</td></tr>';

	$checked = array('', '');
	$checked[$options[2]] = "checked='checked'";
	$form .= '<tr><td>'._MB_MYSHOP_THIS_MONTH."</td><td><input type='radio' name='options[]' id='options' value='1'".$checked[1]." />"._YES." <input type='radio' name='options[]' id='options' value='0'".$checked[0]." />"._NO."</td></tr>";

	$form .= '</table>';
	return $form;
}

// Random Block

function b_myshop_new_show_duplicatable($options)
{
	$options = explode('|',$options);
	$block = & b_myshop_new_show($options);

	$tpl = new XoopsTpl();
	$tpl->assign('block', $block);
	$tpl->display('db:myshop_block_new.html');
}
?>