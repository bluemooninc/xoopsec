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


if(!defined("MYSHOP_ADMIN")) exit();


switch($action) {
	case 'default':	
        xoops_cp_header();
        myshop_adminMenu(7);
        $form = "<form method='post' action='$baseurl' name='frmadddiscount' id='frmadddiscount'><input type='hidden' name='op' id='op' value='discounts' /><input type='hidden' name='action' id='action' value='add' /><input type='submit' name='btngo' id='btngo' value='"._AM_MYSHOP_ADD_ITEM."' /></form>";
		echo $form;
		myshop_utils::htitle(_MI_MYSHOP_ADMENU6, 4);

		$discounts = array();
		$itemsCount = 0;
		$class = '';
		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

		$itemsCount = $h_myshop_discounts->getCount();	
		if($itemsCount > $limit) {
			$pagenav = new XoopsPageNav( $itemsCount, $limit, $start, 'start', 'op=discounts');
		}

		$criteria = new Criteria('disc_id', 0, '<>');
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$discounts = $h_myshop_discounts->getObjects($criteria);

		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._TITLE."</th><th align='center'>"._AM_MYSHOP_ACTION."</th></tr>";
		foreach ($discounts as $item) {
			$class = ($class == 'even') ? 'odd' : 'even';
			$id = $item->getVar('disc_id');
			$actions = array();
			$actions[] = "<a href='$baseurl?op=discounts&action=edit&id=".$id."' title='"._MYSHOP_EDIT."'>".$icones['edit'].'</a>';
			$actions[] = "<a href='$baseurl?op=discounts&action=delete&id=".$id."' title='"._MYSHOP_DELETE."'".$conf_msg.">".$icones['delete'].'</a>';
			$actions[] = "<a href='$baseurl?op=discounts&action=copy&id=".$id."' title='"._MYSHOP_DUPLICATE_DISCOUNT."'>".$icones['copy'].'</a>';
			echo "<tr class='".$class."'>\n";
			echo "<td>".$id."</td><td align='center'>".$item->getVar('disc_title')."</td><td align='center'>".implode(' ', $actions)."</td>\n";
			echo "<tr>\n";
		}
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'>\n";
		echo "<td colspan='3' align='center' class='foot'>".$form."</td>\n";
		echo "</tr>\n";
		echo '</table>';
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<div align='right'>".$pagenav->renderNav()."</div>";
		}
		$myshop_reductions = new myshop_reductions();

		break;

	case 'add':	
	case 'edit':
        xoops_cp_header();
        myshop_adminMenu(7);
		if($action == 'edit') {
			$title = _AM_MYSHOP_EDIT_DISCOUNT;
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if(empty($id)) {
				myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
			}
			// Item exits ?
			$item = null;
			$item = $h_myshop_discounts->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$edit = true;
			$label_submit = _AM_MYSHOP_MODIFY;
		} else {
			$title = _AM_MYSHOP_ADD_DSICOUNT;
			$item = $h_myshop_discounts->create(true);
			$label_submit = _AM_MYSHOP_ADD;
			$edit = false;
		}
		include_once XOOPS_ROOT_PATH . '/class/template.php';
		$xoopsTpl = new XoopsTpl();
		$xoopsTpl->assign('formTitle', $title);
		$xoopsTpl->assign('action', 'edit');
		$xoopsTpl->assign('baseurl', $baseurl);
		$xoopsTpl->assign('label_submit', $label_submit);
		$discountForTemplate = $item->toArray();
		$discountForTemplate['disc_pediod_checked'] = $item->getVar('disc_date_from') > 0 && $item->getVar('disc_date_to') > 0 ? "checked='checked'" : '';

		$disc_date_from = new XoopsFormTextDateSelect(_AM_MYSHOP_DISCOUNT_PERFROM, 'disc_date_from', 15, $item->getVar('disc_date_from'));
		$discountForTemplate['disc_date_from'] = $disc_date_from->render();
		$disc_date_to = new XoopsFormTextDateSelect(_AM_MYSHOP_DISCOUNT_PERTO, 'disc_date_to', 15, $item->getVar('disc_date_to'));
		$discountForTemplate['disc_date_to'] = $disc_date_to->render();

		$reductionType0 = $reductionType1 = $reductionType2 = '';
		$checked = "checked='checked'";

		switch($item->getVar('disc_price_type')) {
			case MYSHOP_DISCOUNT_PRICE_TYPE0:
				$reductionType0 = $checked;
				break;
			case MYSHOP_DISCOUNT_PRICE_TYPE1:
				$reductionType1 = $checked;
				break;
			case MYSHOP_DISCOUNT_PRICE_TYPE2:
				$reductionType2 = $checked;
				break;
		}
		$discountForTemplate['disc_price_type_checked0'] = $reductionType0;
		$discountForTemplate['disc_price_type_checked1'] = $reductionType1;
		$discountForTemplate['disc_price_type_checked2'] = $reductionType2;
		$disc_price_amount_type1 = $disc_price_amount_type2 = '';
		if($item->getVar('disc_price_amount_type') == MYSHOP_DISCOUNT_PRICE_REDUCE_PERCENT) {
			$disc_price_amount_type1 = $checked;
		} elseif($item->getVar('disc_price_amount_type') == MYSHOP_DISCOUNT_PRICE_REDUCE_MONEY) {
			$disc_price_amount_type2 = $checked;
		}
		$discountForTemplate['disc_price_amount_type_checked1'] = $disc_price_amount_type1;
		$discountForTemplate['disc_price_amount_type_checked2'] = $disc_price_amount_type2;
		$disc_price_amount_on_checked1 = $disc_price_amount_on_checked2 = '';
		if($item->getVar('disc_price_amount_on') == MYSHOP_DISCOUNT_PRICE_AMOUNT_ON_PRODUCT) {
			$disc_price_amount_on_checked1  = $checked;
		} elseif($item->getVar('disc_price_amount_on') == MYSHOP_DISCOUNT_PRICE_AMOUNT_ON_CART) {
			$disc_price_amount_on_checked2  = $checked;
		}
		$discountForTemplate['disc_price_amount_on_checked1'] = $disc_price_amount_on_checked1;
		$discountForTemplate['disc_price_amount_on_checked2'] = $disc_price_amount_on_checked2;
		$disc_price_case_checked1 = $disc_price_case_checked2 = $disc_price_case_checked3 = $disc_price_case_checked4 = '';
		switch($item->getVar('disc_price_case')) {
			case MYSHOP_DISCOUNT_PRICE_CASE_ALL:
				$disc_price_case_checked1 = $checked;
				break;
			case MYSHOP_DISCOUNT_PRICE_CASE_FIRST_BUY:
				$disc_price_case_checked2 = $checked;
				break;
			case MYSHOP_DISCOUNT_PRICE_CASE_PRODUCT_NEVER:
				$disc_price_case_checked3 = $checked;
				break;
			case MYSHOP_DISCOUNT_PRICE_CASE_QTY_IS:
				$disc_price_case_checked4 = $checked;
				break;
		}
		$discountForTemplate['disc_price_case_checked1'] = $disc_price_case_checked1;
		$discountForTemplate['disc_price_case_checked2'] = $disc_price_case_checked2;
		$discountForTemplate['disc_price_case_checked3'] = $disc_price_case_checked3;
		$discountForTemplate['disc_price_case_checked4'] = $disc_price_case_checked4;

		// ****
		$quantityConditions = array(MYSHOP_DISCOUNT_PRICE_QTY_COND1 => MYSHOP_DISCOUNT_PRICE_QTY_COND1_TEXT,
		 							MYSHOP_DISCOUNT_PRICE_QTY_COND2 => MYSHOP_DISCOUNT_PRICE_QTY_COND2_TEXT,
		 							MYSHOP_DISCOUNT_PRICE_QTY_COND3 => MYSHOP_DISCOUNT_PRICE_QTY_COND3_TEXT,
		 							MYSHOP_DISCOUNT_PRICE_QTY_COND4 => MYSHOP_DISCOUNT_PRICE_QTY_COND4_TEXT,
		 							MYSHOP_DISCOUNT_PRICE_QTY_COND5 => MYSHOP_DISCOUNT_PRICE_QTY_COND5_TEXT
		 							);
		$xoopsTpl->assign('disc_price_case_qty_cond_options', $quantityConditions);
		$xoopsTpl->assign('disc_price_case_qty_cond_selected', $item->getVar('disc_price_case_qty_cond'));

		$disc_shipping_type_checked1 = $disc_shipping_type_checked2 = $disc_shipping_type_checked3 = $disc_shipping_type_checked4 = '';
		switch($item->getVar('disc_shipping_type')) {
			case MYSHOP_DISCOUNT_SHIPPING_TYPE1:
				$disc_shipping_type_checked1 = $checked;
				break;
			case MYSHOP_DISCOUNT_SHIPPING_TYPE2:
				$disc_shipping_type_checked2 = $checked;
				break;
			case MYSHOP_DISCOUNT_SHIPPING_TYPE3:
				$disc_shipping_type_checked3 = $checked;
				break;
			case MYSHOP_DISCOUNT_SHIPPING_TYPE4:
				$disc_shipping_type_checked4 = $checked;
				break;
		}
		$discountForTemplate['disc_shipping_type_checked1'] = $disc_shipping_type_checked1;
		$discountForTemplate['disc_shipping_type_checked2'] = $disc_shipping_type_checked2;
		$discountForTemplate['disc_shipping_type_checked3'] = $disc_shipping_type_checked3;
		$discountForTemplate['disc_shipping_type_checked4'] = $disc_shipping_type_checked4;

		// Groups
		$xoopsTpl->assign('disc_groups_selected', $item->getVar('disc_group'));
		$member_handler =& xoops_gethandler('member');
		$groups = array();
		$groups = $member_handler->getGroupList();
		$groups[0] = _ALL;
		ksort($groups);
		$xoopsTpl->assign('disc_groups_options', $groups);

		// Categories
		$categories = $h_myshop_cat->getAllCategories();
		$mytree = new Myshop_XoopsObjectTree($categories, 'cat_cid', 'cat_pid');
		$categoriesSelect = $mytree->makeSelBox('disc_cat_cid', 'cat_title', '-', $item->getVar('disc_cat_cid'), _ALL);
		$discountForTemplate['disc_cat_cid_select'] = $categoriesSelect;

		// stores
		$stores = $h_myshop_stores->getList();
		$stores[0] = _ALL;
		ksort($stores);

		$xoopsTpl->assign('disc_store_id_options', $stores);
		$xoopsTpl->assign('disc_store_id_selected', $item->getVar('disc_store_id'));

		// Category
		$xoopsTpl->assign('disc_cat_cid_options', $categoriesSelect);

		// Products
		$products = $h_myshop_products->getList();
		$products[0] = _ALL;
		ksort($products);
		$xoopsTpl->assign('disc_product_id_options', $products);
		$xoopsTpl->assign('disc_product_id_selected', $item->getVar('disc_product_id'));

		$xoopsTpl->assign('discount', $discountForTemplate);
		$xoopsTpl->assign('currencyName', myshop_utils::getModuleOption('money_full'));
		$editor = myshop_utils::getWysiwygForm(_AM_MYSHOP_DISCOUNT_DESCR, 'disc_description', $item->getVar('disc_description','e'), 15, 60, 'description_hidden');
		$xoopsTpl->assign('editor', $editor->render());
		$xoopsTpl->display('db:myshop_admin_discounts.html');
		break;

	case 'copy':
		xoops_cp_header();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'discounts';
		$item = null;
		$item = $h_myshop_discounts->get($id);
		if(is_object($item)) {
			$newDiscount = $item->xoopsClone();
			$newDiscount->setVar('disc_title', xoops_trim($item->getvar('disc_title')).' '._AM_MYSHOP_DUPLICATED);
			$newDiscount->setVar('disc_id', 0);
			$newDiscount->setNew();
			$res = $h_myshop_discounts->insert($newDiscount, true);
			if($res) {
				myshop_utils::updateCache();
				myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect, 2);
			} else {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect, 5);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect, 5);
		}


	case 'saveedit':
		xoops_cp_header();
		$id = isset($_POST['disc_id']) ? intval($_POST['disc_id']) : 0;
		if(!empty($id)) {
			$edit = true;
			$item = $h_myshop_discounts->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$item->unsetNew();
		} else {
			$item = $h_myshop_discounts->create(true);
		}
		$opRedirect = 'discounts';
		$item->setVars($_POST);
		if(isset($_POST['disc_pediod']) && intval($_POST['disc_pediod']) == 1) {
			$item->setVar('disc_date_from', strtotime($_POST['disc_date_from']));
			$item->setVar('disc_date_to', strtotime($_POST['disc_date_to']));
		} else {
			$item->setVar('disc_date_from', 0);
			$item->setVar('disc_date_to', 0);
		}
		$res = $h_myshop_discounts->insert($item);
		if($res) {
			myshop_utils::updateCache();
			myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect, 2);
		} else {
			myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect, 5);
		}
		break;

	case 'delete':	
        xoops_cp_header();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'discounts';
		$item = $h_myshop_discounts->get($id);
		if(is_object($item)) {
			$res = $h_myshop_discounts->delete($item, true);
			if($res) {
				myshop_utils::updateCache();
				myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect, 2);
			} else {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect, 5);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect, 5);
		}
		break;
}
?>