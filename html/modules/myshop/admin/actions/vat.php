<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

if(!defined("MYSHOP_ADMIN")) exit();
switch($action) {
	case 'default':
        xoops_cp_header();
        myshop_adminMenu(2);
		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
		$vats = array();
		$form = "<form method='post' action='$baseurl' name='frmaddvat' id='frmaddvat'><input type='hidden' name='op' id='op' value='vat' /><input type='hidden' name='action' id='action' value='add' /><input type='hidden' name='action' id='action' value='add' /><input type='submit' name='btngo' id='btngo' value='"._AM_MYSHOP_ADD_ITEM."' /></form>";
		echo $form;
		myshop_utils::htitle(_MI_MYSHOP_ADMENU1, 4);
		$vats = $h_myshop_vat->getAllVats($start, $limit);
		$class='';
		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._AM_MYSHOP_RATE."</th><th align='center'>"._AM_MYSHOP_ACTION."</th></tr>";
		foreach ($vats as $item) {
			$id = $item->getVar('vat_id');
			$class = ($class == 'even') ? 'odd' : 'even';
			$actions = array();
			$actions[] = "<a href='$baseurl?op=vat&action=edit&id=".$id."' title='"._MYSHOP_EDIT."'>".$icones['edit'].'</a>';
			$actions[] = "<a href='$baseurl?op=vat&action=delete&id=".$id."' title='"._MYSHOP_DELETE."'".$conf_msg.">".$icones['delete'].'</a>';
			echo "<tr class='".$class."'>\n";
			echo "<td>".$id."</td><td align='right'>".$myshop_Currency->amountInCurrency($item->getVar('vat_rate'))."</td><td align='center'>".implode(' ', $actions)."</td>\n";
			echo "<tr>\n";
		}
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'>\n";
		echo "<td colspan='3' align='center' class='foot'>".$form."</td>\n";
		echo "</tr>\n";
		echo '</table>';
		break;

	case 'add':
	case 'edit':
        xoops_cp_header();
        myshop_adminMenu(2);
		if($action == 'edit') {
			$title = _AM_MYSHOP_EDIT_VAT;
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if(empty($id)) {
				myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
			}
			// Item exits ?
			$item = null;
			$item = $h_myshop_vat->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$edit = true;
			$label_submit = _AM_MYSHOP_MODIFY;
		} else {
			$title = _AM_MYSHOP_ADD_VAT;
			$item = $h_myshop_vat->create(true);
			$label_submit = _AM_MYSHOP_ADD;
			$edit = false;
		}
		$sform = new XoopsThemeForm($title, 'frmaddvat', $baseurl);
		$sform->addElement(new XoopsFormHidden('op', 'vat'));
		$sform->addElement(new XoopsFormHidden('action', 'saveedit'));
		$sform->addElement(new XoopsFormHidden('vat_id', $item->getVar('vat_id')));
		$sform->addElement(new XoopsFormText(_AM_MYSHOP_RATE,'vat_rate',10,15, $item->getVar('vat_rate','e')), true);

		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', $label_submit, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);
		$sform = myshop_utils::formMarkRequiredFields($sform);
		$sform->display();
		break;

	case 'saveedit':
		xoops_cp_header();
		$id = isset($_POST['vat_id']) ? intval($_POST['vat_id']) : 0;
		if(!empty($id)) {
			$edit = true;
			$item = $h_myshop_vat->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$item->unsetNew();
		} else {
			$item= $h_myshop_vat->create(true);
		}
		$opRedirect = 'vat';
		$item->setVars($_POST);
		$res = $h_myshop_vat->insert($item);
		if($res) {
			myshop_utils::updateCache();
			myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect, 2);
		} else {
			myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect,5);
		}
		break;


	case 'delete':
        xoops_cp_header();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'vat';
		// Check products using this VAT
		$cnt = $h_myshop_vat->getVatProductsCount($id);
		if($cnt == 0) {
			$item = null;
			$item = $h_myshop_vat->get($id);
			if(is_object($item)) {
				$res = $h_myshop_vat->deleteVat($item);
				if($res) {
					myshop_utils::updateCache();
					myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect,2);
				} else {
					myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect,5);
				}
			} else {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect,5);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_2, $baseurl.'?op='.$opRedirect,5);
		}
		break;
}
?>