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

/**
 * Stores
 */

if(!defined("MYSHOP_ADMIN")) exit();
switch($action) {
	case 'default':	
        xoops_cp_header();
        myshop_adminMenu(1);
		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
		$stores = array();
		$form = "<form method='post' action='$baseurl' name='frmaddstore' id='frmaddstore'><input type='hidden' name='op' id='op' value='stores' /><input type='hidden' name='action' id='action' value='add' /><input type='submit' name='btngo' id='btngo' value='"._AM_MYSHOP_ADD_ITEM."' /></form>";
		echo $form;
		myshop_utils::htitle(_MI_MYSHOP_ADMENU0,4);
		$stores = $h_myshop_stores->getAllStores($start, $limit);
		$class='';
		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._MYSHOP_STORE."</th><th align='center'>"._AM_MYSHOP_ACTION."</th></tr>";
		foreach ($stores as $item) {
			$id = $item->getVar('store_id');
			$class = ($class == 'even') ? 'odd' : 'even';
			$actions = array();
			$actions[] = "<a href='$baseurl?op=stores&action=edit&id=".$id."' title='"._MYSHOP_EDIT."'>".$icones['edit'].'</a>';
			$actions[] = "<a href='$baseurl?op=stores&action=delete&id=".$id."' title='"._MYSHOP_DELETE."'".$conf_msg.">".$icones['delete'].'</a>';
			echo "<tr class='".$class."'>\n";
			echo '<td>'.$id."</td><td align='center'>".$item->getVar('store_name')."</td><td align='center'>".implode(' ', $actions)."</td>\n";
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
        myshop_adminMenu(1);
		if($action == 'edit') {
			$title = _AM_MYSHOP_EDIT_STORE;
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if(empty($id)) {
				myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
			}
			// Item exits ?
			$item = null;
			$item = $h_myshop_stores->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$edit = true;
			$label_submit = _AM_MYSHOP_MODIFY;
		} else {
			$title = _AM_MYSHOP_ADD_STORE;
			$item = $h_myshop_stores->create(true);
			$label_submit = _AM_MYSHOP_ADD;
			$edit = false;
		}
		$sform = new XoopsThemeForm($title, 'frmaddstore', $baseurl);
		$sform->addElement(new XoopsFormHidden('op', 'stores'));
		$sform->addElement(new XoopsFormHidden('action', 'saveedit'));
		$sform->addElement(new XoopsFormHidden('store_id', $item->getVar('store_id')));
		$sform->addElement(new XoopsFormText(_MYSHOP_STORE,'store_name',50,150, $item->getVar('store_name','e')), true);

		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', $label_submit, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);
		$sform = myshop_utils::formMarkRequiredFields($sform);
		$sform->display();
		break;


	case 'saveedit':
		xoops_cp_header();
		$id = isset($_POST['store_id']) ? intval($_POST['store_id']) : 0;
		if(!empty($id)) {
			$edit = true;
			$item = $h_myshop_stores->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$item->unsetNew();
		} else {
			$item= $h_myshop_stores->create(true);
		}
		$opRedirect = 'stores';
		$item->setVars($_POST);
		$res = $h_myshop_stores->insert($item);
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
		$opRedirect = 'stores';
		// Check attached products
		$cnt = $h_myshop_stores->getStoreProductsCount($id);
		if($cnt == 0) {
			$item = null;
			$item = $h_myshop_stores->get($id);
			if(is_object($item)) {
				$res = $h_myshop_stores->deleteStore($item);
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
			myshop_utils::redirect(_AM_MYSHOP_ERROR_6, $baseurl.'?op='.$opRedirect,5);
		}
		break;
}
?>