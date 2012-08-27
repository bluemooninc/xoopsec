<?php

// Display block of categories related to content

function b_myshop_category_show($options)
{
	global $xoopsTpl;
	$block = array();
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	$url = MYSHOP_URL.'include/myshop.css';
	$xoopsTpl->assign("xoops_module_header", "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" />");
	$block['nostock_msg'] = myshop_utils::getModuleOption('nostock_msg');

	if(intval($options[0]) == 0) {
		$block['block_option'] = 0;
		if(!isset($GLOBALS['current_category']) || $GLOBALS['current_category'] == -1) {
			return false;
		}
		$cat_cid = intval($GLOBALS['current_category']);
		include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';

		if($cat_cid > 0 ) {
			include_once XOOPS_ROOT_PATH . '/class/tree.php';
			$tbl_categories = $tblChilds = $tbl_tmp = array();
			$tbl_categories = $h_myshop_cat->getAllCategories();
			$mytree = new XoopsObjectTree($tbl_categories, 'cat_cid', 'cat_pid');
			$tblChilds = $mytree->getAllChild($cat_cid);
			foreach($tblChilds as $item) {
				$tbl_tmp[] = "<a href='".$item->getLink()."' title='".myshop_utils::makeHrefTitle($item->getVar('cat_title'))."'>".$item->getVar('cat_title')."</a>";
			}
			$block['block_categories'] = $tbl_tmp;

			$category = null;
			if($cat_cid > 0) {
				$category = $h_myshop_cat->get($cat_cid);
				if(is_object($category)) {
					$block['block_current_category'] = $category->toArray();
				}
			}
		} else {	
			$tbl_categories = array();
			$criteria = new Criteria('cat_pid', 0, '=');
			$criteria->setSort('cat_title');
			$tbl_categories = $h_myshop_cat->getObjects($criteria, true);
			foreach($tbl_categories as $item) {
				$tbl_tmp[] = "<a href='".$item->getLink()."' title='".myshop_utils::makeHrefTitle($item->getVar('cat_title'))."'>".$item->getVar('cat_title')."</a>";
			}
			$block['block_categories'] = $tbl_tmp;
		}
	} else {	
		// Normal display
		$block['block_option'] = 1;
		include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
		include_once MYSHOP_PATH.'class/tree.php';
		$tbl_categories = $h_myshop_cat->getAllCategories();
		$mytree = new Myshop_XoopsObjectTree($tbl_categories, 'cat_cid', 'cat_pid');
		$jump = MYSHOP_URL."category.php?cat_cid=";
		$additional = "onchange='location=\"".$jump."\"+this.options[this.selectedIndex].value'";
		if(isset($GLOBALS['current_category']) && $GLOBALS['current_category'] != -1) {
			$cat_cid = intval($GLOBALS['current_category']);
		} else {
			$cat_cid = 0;
		}
		$htmlSelect = $mytree->makeSelBox('cat_cid', 'cat_title', '-', $cat_cid, false, 0, $additional);
		$block['htmlSelect'] = $htmlSelect;
	}
	return $block;
}

function b_myshop_category_edit($options)
{
	global $xoopsConfig;
	include XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';

	$checkeds = array('','');
	$checkeds[$options[0]] = 'checked';
	$form = '';
	$form .= '<b>'._MB_MYSHOP_TYPE_BLOCK."</b><br /><input type='radio' name='options[]' id='options[]' value='0' ".$checkeds[0]." />"._MB_MYSHOP_TYPE_BLOCK2."<br /><input type='radio' name='options[]' id='options[]' value='1' ".$checkeds[1]." />"._MB_MYSHOP_TYPE_BLOCK1.'</td></tr>';
	return $form;
}

/**
 * Random block
 */
function b_myshop_category_duplicatable($options)
{
	$options = explode('|',$options);
	$block = & b_myshop_category($options);

	$tpl = new XoopsTpl();
	$tpl->assign('block', $block);
	$tpl->display('db:myshop_block_categories.html');
}

?>