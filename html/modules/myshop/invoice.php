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
 * Visualisation d'une facture � l'�cran
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_bill.html';
require_once XOOPS_ROOT_PATH . '/header.php';

if(isset($_GET['id'])) {
	$cmdId = intval($_GET['id']);
} else {
	myshop_utils::redirect(_MYSHOP_ERROR11,'index.php',6);
}

if(isset($_GET['pass'])) {
	$pass = $_GET['pass'];
} else {
	if(!myshop_utils::isAdmin()) {
		myshop_utils::redirect(_MYSHOP_ERROR11,'index.php',6);
	}
}

$order = null;
$order = $h_myshop_commands->get($cmdId);
if(!is_object($order)) {
	myshop_utils::redirect(_MYSHOP_ERROR11, 'index.php', 6);
}

// V�rification du mot de passe (si pas admin)
if(!myshop_utils::isAdmin()) {
	if($pass != $order->getVar('cmd_password')) {
		myshop_utils::redirect(_MYSHOP_ERROR11, 'index.php', 6);
	}
}

// V�rification de la validit� de la facture (si pas admin)
if(!myshop_utils::isAdmin()) {
	if($order->getVar('cmd_state') != MYSHOP_STATE_VALIDATED) {	// Commande non valid�e
		myshop_utils::redirect(_MYSHOP_ERROR12, 'index.php', 6);
	}
}

$caddy = $tmp = $products = $vats = $manufacturers = $tmp2 = $manufacturers = $productsManufacturers = array();

// R�cup�ration des TVA
$vats = $h_myshop_vat->getAllVats();

// R�cup�ration des caddy associ�s
$caddy = $h_myshop_caddy->getCaddyFromCommand($cmdId);
if(count($caddy) == 0) {
	myshop_utils::redirect(_MYSHOP_ERROR11, 'index.php',6);
}

foreach($caddy as $item) {
	$tmp[] = $item->getVar('caddy_product_id');
}

// Recherche des produits ***********************************************************************************************
$products = $h_myshop_products->getProductsFromIDs($tmp, true);

// Recherche des fabricants **********************************************************************************************
$tmp2 = $h_myshop_productsmanu->getFromProductsIds($tmp);
$tmp = array();
foreach($tmp2 as $item) {
	$tmp[] = $item->getVar('pm_manu_id');
	$productsManufacturers[$item->getVar('pm_product_id')][] = $item;
}
$manufacturers = $h_myshop_manufacturer->getManufacturersFromIds($tmp);

// Informations sur la commande ***************************************************************************************
$xoopsTpl->assign('order', $order->toArray());

// Boucle sur le caddy ************************************************************************************************
foreach($caddy as $itemCaddy) {
	$productForTemplate = $tblJoin = $productManufacturers = array();
	$product = $products[$itemCaddy->getVar('caddy_product_id')];
	$productForTemplate = $product->toArray();	// Produit
	$productManufacturers = $productsManufacturers[$product->getVar('product_id')];
	foreach($productManufacturers as $myshop_productsmanu) {
		if(isset($manufacturers[$myshop_productsmanu->getVar('pm_manu_id')])) {
			$manufacturer = $manufacturers[$myshop_productsmanu->getVar('pm_manu_id')];
			$tblJoin[] = $manufacturer->getVar('manu_commercialname').' '.$manufacturer->getVar('manu_name');
		}
	}
	if(count($tblJoin) > 0) {
		$productForTemplate['product_joined_manufacturers'] = implode(', ', $tblJoin);
	}
	$productForTemplate['product_caddy'] = $itemCaddy->toArray();
	$xoopsTpl->append('products', $productForTemplate);
}

myshop_utils::setCSS();
$title = _MYSHOP_BILL.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
require_once XOOPS_ROOT_PATH . '/footer.php';
?>