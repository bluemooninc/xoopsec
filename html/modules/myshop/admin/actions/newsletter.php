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
        myshop_adminMenu(8);
		myshop_utils::htitle(_MI_MYSHOP_ADMENU7, 4);
		require_once MYSHOP_PATH.'class/tree.php';
		$sform = new XoopsThemeForm(_MI_MYSHOP_ADMENU7, 'frmnewsletter', $baseurl);
		$datesTray = new XoopsFormElementTray(_AM_MYSHOP_NEWSLETTER_BETWEEN);
		$minDate = $maxDate = 0;
		$h_myshop_products->getMinMaxPublishedDate($minDate, $maxDate);
		$date1 = new XoopsFormTextDateSelect('', 'date1',15,$minDate);
		$date2 = new XoopsFormTextDateSelect(_AM_MYSHOP_EXPORT_AND, 'date2',15,$maxDate);
		$datesTray->addElement($date1);
		$datesTray->addElement($date2);
		$sform->addElement($datesTray);

		$categories = $h_myshop_cat->getAllCategories();
		$mytree = new Myshop_XoopsObjectTree($categories, 'cat_cid', 'cat_pid');
		$htmlSelect = $mytree->makeSelBox('cat_cid', 'cat_title', '-', 0, _AM_MYSHOP_ALL);
		$sform->addElement(new XoopsFormLabel(_AM_MYSHOP_IN_CATEGORY, $htmlSelect), true);

		$sform->addElement(new XoopsFormHidden('op', 'newsletter'), false);
		$sform->addElement(new XoopsFormHidden('action', 'launch'), false);
		$sform->addElement(new XoopsFormRadioYN(_AM_MYSHOP_REMOVE_BR, 'removebr', 1), false);
		$sform->addElement(new XoopsFormRadioYN(_AM_MYSHOP_NEWSLETTER_HTML_TAGS, 'removehtml', 0), false);
		$sform->addElement(new XoopsFormTextArea(_AM_MYSHOP_NEWSLETTER_HEADER, 'header', '', 4, 70), false);
		$sform->addElement(new XoopsFormTextArea(_AM_MYSHOP_NEWSLETTER_FOOTER, 'footer', '', 4, 70), false);
		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);
		$sform = myshop_utils::formMarkRequiredFields($sform);
		$sform->display();
		break;

	case 'launch':	
        xoops_cp_header();
        myshop_adminMenu(8);
		myshop_utils::htitle(_MI_MYSHOP_ADMENU7, 4);

		$newsletterTemplate = '';
		if (file_exists(MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/newsletter.php')) {
			require_once MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/newsletter.php';
		} else {
			require_once MYSHOP_PATH.'language/english/newsletter.php';
		}
		echo '<br />';
		$removeBr = $removeHtml = false;
		$removeBr = isset($_POST['removebr']) ? intval($_POST['removebr']) : 0;
		$removeHtml = isset($_POST['removehtml']) ? intval($_POST['removehtml']) : 0;
		$header = isset($_POST['header']) ? $_POST['header'] : '';
		$footer = isset($_POST['footer']) ? $_POST['footer'] : '';
		$date1 = strtotime($_POST['date1']);
		$date2 = strtotime($_POST['date2']);
		$cat_id = intval($_POST['cat_cid']);
		$products = $categories = array();
		$products = $h_myshop_products->getProductsForNewsletter($date1, $date2, $cat_id);
		$newsfile = MYSHOP_NEWSLETTER_PATH;
		$categories = $h_myshop_cat->getAllCategories(0, 0, 'cat_title', 'ASC', true);
		$vats = $h_myshop_vat->getAllVats();

		$fp = fopen($newsfile,'w');
		if(!$fp) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_7, $baseurl.'?op=newsletter', 5);
		}
		if(xoops_trim($header) != '') {
			fwrite($fp, $header);
		}
		foreach($products as $item) {
			$content = $newsletterTemplate;
			$tblTmp = $tblTmp2 = array();
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('pm_product_id', $item->getVar('product_id'), '='));
			$tblTmp = $h_myshop_productsmanu->getObjects($criteria);
			foreach($tblTmp as $productManufacturer) {
				$tblTmp2[] = $productManufacturer->getVar('pm_manu_id');
			}
			$manufacturers = $h_myshop_manufacturer->getObjects(new Criteria('manu_id', '('.implode(',', $tblTmp2).')', 'IN'), true);
			$tblTmp = array();
			foreach($manufacturers as $manufacturer) {
				$tblTmp[] = $manufacturer->getVar('manu_commercialname').' '.$manufacturer->getVar('manu_name');
			}

			$search = array('%title%','%category%','%author%','%published%','%price%','%money%','%hometext%','%fulltext%','%discountprice%','%link%','%product_sku%','%product_extraid%','%product_width%','%product_date%','%product_shipping_price%','%product_stock%','%product_unitmeasure1%','%product_weight%', '%product_unitmeasure2%','%product_download_url%', '%product_length%');
			$replace = array($item->getVar('product_title'),$categories[$item->getVar('product_cid')]->getVar('cat_title'),implode(', ', $tblTmp),formatTimestamp($item->getVar('product_submitted'),'s'),myshop_utils::getTTC($item->getVar('product_price'), $vats[$item->getVar('product_vat_id')]->getVar('vat_rate')),myshop_utils::getModuleOption('money_full'),$item->getVar('product_summary'),$item->getVar('product_description'),myshop_utils::getTTC($item->getVar('product_discount_price'), $vats[$item->getVar('product_vat_id')]->getVar('vat_rate')), $item->getLink(), $item->getVar('product_sku'),$item->getVar('product_extraid'),$item->getVar('product_width'),$item->getVar('product_date'),$item->getVar('product_shipping_price'),$item->getVar('product_stock'),$item->getVar('product_unitmeasure1'),$item->getVar('product_weight'),$item->getVar('product_unitmeasure2'),$item->getVar('product_download_url'),$item->getVar('product_length'));
			$content = str_replace($search, $replace, $content);
			if($removeBr) {
				$content = str_replace('<br />',"\r\n",$content);
			}
			if($removeHtml) {
				$content = strip_tags($content);
			}
			fwrite($fp,$content);
		}
		if(xoops_trim($footer) != '') {
			fwrite($fp, $footer);
		}
		fclose($fp);
		$newsfile = MYSHOP_NEWSLETTER_URL;
		echo "<a href='$newsfile' target='_blank'>"._AM_MYSHOP_NEWSLETTER_READY."</a>";
		break;
}
?>