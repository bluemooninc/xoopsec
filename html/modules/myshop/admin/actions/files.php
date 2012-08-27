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
    	myshop_adminMenu(11);
		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
		$form = "<form method='post' action='$baseurl' name='frmadd' id='frmadd'><input type='hidden' name='op' id='op' value='files' /><input type='hidden' name='action' id='action' value='add' /><input type='submit' name='btngo' id='btngo' value='"._AM_MYSHOP_ADD_ITEM."' /></form>";
		echo $form;
		myshop_utils::htitle(_MI_MYSHOP_ADMENU11, 4);
		$itemsCount = $h_myshop_files->getCount();	
		if($itemsCount > $limit) {
			$pagenav = new XoopsPageNav( $itemsCount, $limit, $start, 'start', 'op=files');
		}
		$items = $products = $productsIds = array();
		$items = $h_myshop_files->getItems($start, $limit);
		foreach($items as $item) {
			$productsIds[] = $item->getVar('file_product_id');
		}
		if(count($productsIds) > 0) {
			sort($productsIds);
			$productsIds = array_unique($productsIds);
			$products = $h_myshop_products->getProductsFromIDs($productsIds);
		}

		$class = '';
		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._AM_MYSHOP_DESCRIPTION."</th><th align='center'>"._AM_MYSHOP_ACTION."</th></tr>";
		foreach ($items as $item) {
			$class = ($class == 'even') ? 'odd' : 'even';
			$id = $item->getVar('file_id');
			$actions = array();
			$actions[] = "<a href='$baseurl?op=files&action=edit&id=".$id."' title='"._MYSHOP_EDIT."'>".$icones['edit'].'</a>';
			$actions[] = "<a href='$baseurl?op=files&action=delete&id=".$id."' title='"._MYSHOP_DELETE."'".$conf_msg.">".$icones['delete'].'</a>';
			echo "<tr class='".$class."'>\n";
			$product = isset($products[$item->getVar('file_product_id')]) ? $products[$item->getVar('file_product_id')]->getVar('product_title') : '';
			echo "<td>".$item->getVar('file_description')."</td><td align='center'>".$product."</td><td align='center'>".implode(' ', $actions)."</td>\n";
			echo "<tr>\n";
		}
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'>\n";
		echo "<td colspan='3' align='center'>".$form."</td>\n";
		echo "</tr>\n";
		echo '</table>';
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<div align='right'>".$pagenav->renderNav()."</div>";
		}
    	break;

	case 'add':		
	case 'edit':	
        xoops_cp_header();
        myshop_adminMenu(11);
		if($op == 'edit') {
			$title = _AM_MYSHOP_EDIT_FILE;
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if(empty($id)) {
				myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
			}
			// Item exits ?
			$item = null;
			$item = $h_myshop_files->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$edit = true;
			$label_submit = _AM_MYSHOP_MODIFY;
		} else {
			$title = _AM_MYSHOP_ADD_FILE;
			$item = $h_myshop_files->create(true);
			$label_submit = _AM_MYSHOP_ADD;
			$edit = false;
		}
		$products = array();
		$products = $h_myshop_products->getList();
		$sform = new XoopsThemeForm($title, 'frmadd', $baseurl);
		$sform->setExtra('enctype="multipart/form-data"');
		$sform->addElement(new XoopsFormHidden('op', 'files'));
		$sform->addElement(new XoopsFormHidden('action', 'saveedit'));
		$sform->addElement(new XoopsFormHidden('file_id', $item->getVar('file_id')));

		$file_product_id_select = new XoopsFormSelect(_MYSHOP_PRODUCT, 'file_product_id', $item->getVar('file_product_id', 'e'), 1, false);
		$file_product_id_select->addOptionArray($products);
		$sform->addElement($file_product_id_select, true);

		$sform->addElement(new XoopsFormText(_AM_MYSHOP_DESCRIPTION,'file_description',50,255, $item->getVar('file_description','e')), true);
		if( $op == 'edit' && trim($item->getVar('file_filename')) != '' && $item->fileExists() ) {
			$pictureTray = new XoopsFormElementTray(_AM_MYSHOP_CURRENT_FILE,'<br />');
			$pictureTray->addElement(new XoopsFormLabel('', "<a href='".$item->getURL()."' target='_blank' />".$item->getVar('file_filename')."</a>"));
			$sform->addElement($pictureTray);
			unset($pictureTray);
		}
		$sform->addElement(new XoopsFormFile(_AM_MYSHOP_FILENAME, 'attachedfile', myshop_utils::getModuleOption('maxuploadsize')), false);

		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', $label_submit, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);
		$sform = myshop_utils::formMarkRequiredFields($sform);
		$sform->display();
		break;

	case 'saveedit':	
		xoops_cp_header();
		$id = isset($_POST['file_id']) ? intval($_POST['file_id']) : 0;
		if(!empty($id)) {
			$edit = true;
			$item = $h_myshop_files->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$item->unsetNew();
		} else {
			$item= $h_myshop_files->create(true);
		}
		$opRedirect = 'files';
		$item->setVars($_POST);
		$destname = '';
		$result = myshop_utils::uploadFile(0, MYSHOP_ATTACHED_FILES_PATH);
		if( $result === true) {
			$item->setVar('file_filename', basename($destname));
			$item->setVar('file_mimetype', myshop_utils::getMimeType(MYSHOP_ATTACHED_FILES_PATH.DIRECTORY_SEPARATOR.$destname));
		} else {
			if($result !== false) {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB.'<br />'.$result, $baseurl.'?op='.$opRedirect, 5);
			}
		}
		$res = $h_myshop_files->insert($item);
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
		$opRedirect = 'files';
		$item = null;
		$item = $h_myshop_files->get($id);
		if(is_object($item)) {
			$res = $h_myshop_files->deleteAttachedFile($item);
			if($res) {
				myshop_utils::updateCache();
				myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect,2);
			} else {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect,5);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect,5);
		}
		break;
}
?>