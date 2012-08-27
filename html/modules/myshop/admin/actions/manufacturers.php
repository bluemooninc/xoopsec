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
        myshop_adminMenu(4);
		$vats = array();
		$form = "<form method='post' action='$baseurl' name='frmaddmanufacturer' id='frmaddmanufacturer'><input type='hidden' name='op' id='op' value='manufacturers' /><input type='hidden' name='action' id='action' value='add' /><input type='submit' name='btngo' id='btngo' value='"._AM_MYSHOP_ADD_ITEM."' /></form>";
		echo $form;
		myshop_utils::htitle(_MI_MYSHOP_ADMENU3,4);

		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('manu_id', 0, '<>'));

		$itemsCount = $h_myshop_manufacturer->getCount($criteria);
		if($itemsCount > $limit) {
			$pagenav = new XoopsPageNav( $itemsCount, $limit, $start, 'start', 'op=manufacturers');
		}

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort('manu_name, manu_commercialname');

		$manufacturers = $h_myshop_manufacturer->getObjects($criteria);
		$class = '';
		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<tr><td colspan='2' align='left'>".$pagenav->renderNav()."</td><td align='right' colspan='3'>&nbsp;</td></tr>\n";
		}
		echo "<tr><th align='center'>"._MYSHOP_LASTNAME."</th><th align='center'>"._MYSHOP_COMM_NAME."</th><th align='center'>"._MYSHOP_EMAIL."</th><th align='center'>"._AM_MYSHOP_ACTION."</th></tr>";
		foreach ($manufacturers as $item) {
			$class = ($class == 'even') ? 'odd' : 'even';
			$id = $item->getVar('manu_id');
			$actions = array();
			$actions[] = "<a href='$baseurl?op=manufacturers&action=edit&id=".$id."' title='"._MYSHOP_EDIT."'>".$icones['edit'].'</a>';
			$actions[] = "<a href='$baseurl?op=manufacturers&action=delete&id=".$id."' title='"._MYSHOP_DELETE."'".$conf_msg.">".$icones['delete'].'</a>';
			echo "<tr class='".$class."'>\n";
			echo "<td>".$item->getVar('manu_name')."</td><td align='left'>".$item->getVar('manu_commercialname')."</td><td align='center'>".$item->getVar('manu_email')."</td><td align='center'>".implode(' ', $actions)."</td>\n";
			echo "<tr>\n";
		}
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'>\n";
		echo "<td colspan='4' align='center' class='foot'>".$form."</td>\n";
		echo "</tr>\n";
		echo '</table>';
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<div align='right'>".$pagenav->renderNav()."</div>";
		}
		break;


	case 'add':		
	case 'edit':	
        xoops_cp_header();
        myshop_adminMenu(4);

        if($action == 'edit') {
			$title = _AM_MYSHOP_EDIT_MANUFACTURER;
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if(empty($id)) {
				myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
			}
			$item = null;
			$item = $h_myshop_manufacturer->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$edit = true;
			$label_submit = _AM_MYSHOP_MODIFY;
		} else {
			$title = _AM_MYSHOP_ADD_MANUFACTURER;
			$item = $h_myshop_manufacturer->create(true);
			$label_submit = _AM_MYSHOP_ADD;
			$edit = false;
		}

		$sform = new XoopsThemeForm($title, 'frmmanufacturer', $baseurl);
		$sform->setExtra('enctype="multipart/form-data"');
		$sform->addElement(new XoopsFormHidden('op', 'manufacturers'));
		$sform->addElement(new XoopsFormHidden('action', 'saveedit'));
		$sform->addElement(new XoopsFormHidden('manu_id', $item->getVar('manu_id')));
		$sform->addElement(new XoopsFormText(_MYSHOP_LASTNAME,'manu_name',50,255, $item->getVar('manu_name','e')), true);
		$sform->addElement(new XoopsFormText(_MYSHOP_COMM_NAME,'manu_commercialname',50,255, $item->getVar('manu_commercialname','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_EMAIL,'manu_email',50,255, $item->getVar('manu_email','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_SITEURL,'manu_url',50,255, $item->getVar('manu_url','e')), false);

		$editor = myshop_utils::getWysiwygForm(_MYSHOP_MANUFACTURER_INF,'manu_bio', $item->getVar('manu_bio','e'), 15, 60, 'bio_hidden');
		if($editor) {
			$sform->addElement($editor, false);
		}
		for($i = 1; $i <= 5; $i++) {
			if( $action == 'edit' && $item->pictureExists($i) ) {
				$pictureTray = new XoopsFormElementTray(_AM_MYSHOP_CURRENT_PICTURE ,'<br />');
				$pictureTray->addElement(new XoopsFormLabel('', "<img src='".$item->getPictureUrl($i)."' alt='' border='0' />"));
				$deleteCheckbox = new XoopsFormCheckBox('', 'delpicture'.$i);
				$deleteCheckbox->addOption(1, _DELETE);
				$pictureTray->addElement($deleteCheckbox);
				$sform->addElement($pictureTray);
				unset($pictureTray, $deleteCheckbox);
			}
			$sform->addElement(new XoopsFormFile(_AM_MYSHOP_PICTURE.' '.$i , 'attachedfile'.$i, myshop_utils::getModuleOption('maxuploadsize')), false);
		}

		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', $label_submit, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);

		$sform = myshop_utils::formMarkRequiredFields($sform);
		$sform->display();
		break;

	case 'saveedit':	
		xoops_cp_header();
		$id = isset($_POST['manu_id']) ? intval($_POST['manu_id']) : 0;
		if(!empty($id)) {
			$edit = true;
			$item = $h_myshop_manufacturer->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$item->unsetNew();
		} else {
			$item = $h_myshop_manufacturer->create(true);
		}
		$opRedirect = 'manufacturers';
		$item->setVars($_POST);
		for($i = 1; $i <= 5; $i++) {
			if(isset($_POST['delpicture'.$i]) && intval($_POST['delpicture'.$i]) == 1) {
				$item->deletePicture($i);
			}
		}

		// Upload 
		for($i = 1; $i <= 5; $i++) {
			$res1 = myshop_utils::uploadFile($i-1, MYSHOP_PICTURES_PATH);
			if($res1 === true) {
				if(myshop_utils::getModuleOption('resize_others')) {	
					myshop_utils::resizePicture(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$destname, MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$destname, myshop_utils::getModuleOption('images_width'), myshop_utils::getModuleOption('images_height'), true);
				}
				$item->setVar('manu_photo'.$i, basename($destname));
   			} else {
	   			if($res1 !== false) {
   					echo $res1;
   				}
   			}
		}

		$res = $h_myshop_manufacturer->insert($item);
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
		$opRedirect = 'manufacturers';
		$cnt = $h_myshop_manufacturer->getManufacturerProductsCount($id);
		if($cnt == 0) {
			$item = null;
			$item = $h_myshop_manufacturer->get($id);
			if(is_object($item)) {
				$res = $h_myshop_manufacturer->deleteManufacturer($item);
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
			myshop_utils::redirect(_AM_MYSHOP_ERROR_5, $baseurl.'?op='.$opRedirect,5);
		}
		break;
}
?>