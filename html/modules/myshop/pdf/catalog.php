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

/**
 * Impression du catalogue au format PDF
 */

require '../../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';

error_reporting(0);
@$xoopsLogger->activated = false;

if(myshop_utils::getModuleOption('pdf_catalog') != 1) {
	die();
}

require_once XOOPS_ROOT_PATH . '/class/template.php';
$details = isset($_POST['catalogFormat']) ? intval($_POST['catalogFormat']) : 0;
$Tpl = new XoopsTpl();
$vatArray = $tbl_categories  = array();
$vatArray = $h_myshop_vat->getAllVats();
$tbl_categories = $h_myshop_cat->getAllCategories();
$Tpl->assign('mod_pref', $mod_pref);	// Pr�f�rences du module

$cat_cid = 0 ;
$tbl_tmp = array();
$tblProducts = array();
$tblProducts = $h_myshop_products->getRecentProducts(0, 0, $cat_cid);

if(count($tblProducts) > 0) {
	if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php')) {
		require_once  MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
	} else {
		require_once  MYSHOP_PATH.'language/english/modinfo.php';
	}
	$Tpl->assign('details', $details);
	$tblAuthors = $tbl_tmp = $tblManufacturersPerProduct = array();
	$tblAuthors = $h_myshop_productsmanu->getObjects(new Criteria('pm_product_id', '('.implode(',', array_keys($tblProducts)).')', 'IN'), true);
	foreach($tblAuthors as $item) {
		$tbl_tmp[] = $item->getVar('pm_manu_id');
		$tblManufacturersPerProduct[$item->getVar('pm_product_id')][] = $item;
	}
	$tbl_tmp = array_unique($tbl_tmp);
	$tblAuthors = $h_myshop_manufacturer->getObjects(new Criteria('manu_id', '('.implode(',', $tbl_tmp).')', 'IN'), true);
	foreach($tblProducts as $item) {
		$tbl_tmp = array();
		$tbl_tmp = $item->toArray();
		$tbl_tmp['product_category'] = isset($tbl_categories[$item->getVar('product_cid')]) ? $tbl_categories[$item->getVar('product_cid')]->toArray() : null;
		$tbl_tmp['product_price_ttc'] = myshop_utils::getTTC($item->getVar('product_price'), $vatArray[$item->getVar('product_vat_id')]->getVar('vat_rate'), false, 's');
		$tbl_tmp['product_discount_price_ttc'] = myshop_utils::getTTC($item->getVar('product_discount_price'), $vatArray[$item->getVar('product_vat_id')]->getVar('vat_rate') , false, 's');
		$tbl_join = array();
		foreach($tblManufacturersPerProduct[$item->getVar('product_id')] as $author) {
			$auteur = $tblAuthors[$author->getVar('pm_manu_id')];
			$tbl_join[] = $auteur->getVar('manu_commercialname').' '.$auteur->getVar('manu_name');
		}
		if(count($tbl_join) > 0) {
			$tbl_tmp['product_joined_manufacturers'] = implode(', ', $tbl_join);
		}
		$Tpl->append('products', $tbl_tmp);
	}
}

$content1 = utf8_encode($Tpl->fetch('db:myshop_pdf_catalog.html'));
if(myshop_utils::getModuleOption('use_price')) {
	$content2 = utf8_encode($Tpl->fetch('db:myshop_purchaseorder.html'));
} else {
	$content2 = '';
}

// ****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************
// ****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************
// ****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************

$doc_title = _MYSHOP_CATALOG;
$doc_subject = _MYSHOP_CATALOG;
$doc_keywords = "Instant Zero";

require_once MYSHOP_PATH.'pdf/config/lang/'._LANGCODE.'.php';
require MYSHOP_PATH.'pdf/tcpdf.php';

//create new PDF document (document units are set by default to millimeters)
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(PDF_AUTHOR);
$pdf->SetTitle($doc_title);
$pdf->SetSubject($doc_subject);
$pdf->SetKeywords($doc_keywords);

$firstLine = utf8_encode(myshop_utils::getModuleName().' - '.$xoopsConfig['sitename']);
$secondLine = MYSHOP_URL.' - '.formatTimestamp(time(), 'm');
$pdf->SetHeaderData('', '', $firstLine, $secondLine);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->setLanguageArray($l); //set language items


//initialize document
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->writeHTML($content1, true, 0);
if(myshop_utils::getModuleOption('use_price')) {
	$pdf->AddPage();
	$pdf->writeHTML($content2, true, 0);
}
$pdf->Output();
?>