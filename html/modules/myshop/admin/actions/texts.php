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
        myshop_adminMenu(9);
		require_once MYSHOP_PATH.'class/registryfile.php';
		$registry = new myshop_registryfile();

		$sform = new XoopsThemeForm(_MI_MYSHOP_ADMENU8, 'frmatxt', $baseurl);
		$sform->addElement(new XoopsFormHidden('op', 'texts'));
		$sform->addElement(new XoopsFormHidden('action', 'savetexts'));
		$editor1 = myshop_utils::getWysiwygForm(_AM_MYSHOP_INDEX_PAGE,'welcome1', $registry->getfile(MYSHOP_TEXTFILE1), 5, 60, 'hometext1_hidden');
		if($editor1) {
			$sform->addElement($editor1, false);
		}

		$editor2 = myshop_utils::getWysiwygForm(_MYSHOP_CGV,'welcome2', $registry->getfile(MYSHOP_TEXTFILE2), 5, 60, 'hometext2_hidden');
		if($editor2) {
			$sform->addElement($editor2, false);
		}

		$editor3 = myshop_utils::getWysiwygForm(_AM_MYSHOP_RECOMM_TEXT,'welcome3', $registry->getfile(MYSHOP_TEXTFILE3), 5, 60, 'hometext3_hidden');
		if($editor3) {
			$sform->addElement($editor3, false);
		}

		$editor4 = myshop_utils::getWysiwygForm(_AM_MYSHOP_OFFLINEPAY_TEXT,'welcome4', $registry->getfile(MYSHOP_TEXTFILE4), 5, 60, 'hometext4_hidden');
		if($editor4) {
			$sform->addElement($editor4, false);
		}

		$editor5 = myshop_utils::getWysiwygForm(_AM_MYSHOP_RESTRICT_TEXT,'welcome5', $registry->getfile(MYSHOP_TEXTFILE5), 5, 60, 'hometext5_hidden');
		if($editor5) {
			$sform->addElement($editor5, false);
		}

		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', _AM_MYSHOP_MODIFY, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);
		$sform = myshop_utils::formMarkRequiredFields($sform);
		$sform->display();
		break;

	case 'savetexts':
		require_once MYSHOP_PATH.'class/registryfile.php';
		$registry = new myshop_registryfile();
		$registry->savefile($myts->stripSlashesGPC($_POST['welcome1']), MYSHOP_TEXTFILE1);
		$registry->savefile($myts->stripSlashesGPC($_POST['welcome2']), MYSHOP_TEXTFILE2);
		$registry->savefile($myts->stripSlashesGPC($_POST['welcome3']), MYSHOP_TEXTFILE3);
		$registry->savefile($myts->stripSlashesGPC($_POST['welcome4']), MYSHOP_TEXTFILE4);
		$registry->savefile($myts->stripSlashesGPC($_POST['welcome5']), MYSHOP_TEXTFILE5);
		myshop_utils::updateCache();
		myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl, 2);
		break;
}
?>