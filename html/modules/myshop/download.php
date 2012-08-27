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
 * Download file after order validation
 */
require_once 'header.php';
error_reporting(0);
@$xoopsLogger->activated = false;

$download_id = isset($_GET['download_id']) ? $_GET['download_id'] : '';

// TODO: Allow webmaster to re-activate download

if(xoops_trim($download_id) == '') {
	myshop_utils::redirect(_MYSHOP_ERROR13, MYSHOP_URL, 5);
}

// Search related products in the caddy
$caddy = null;
$caddy = $h_myshop_caddy->getCaddyFromPassword($download_id);
if( !is_object($caddy)) {
	myshop_utils::redirect(_MYSHOP_ERROR14, MYSHOP_URL, 5);
}

// Search related product
$product = null;
$product = $h_myshop_products->get($caddy->getVar('caddy_product_id'));
if($product == null) {
	myshop_utils::redirect(_MYSHOP_ERROR15, MYSHOP_URL, 5);
}

// Verifiy order paiment
$order = null;
$order = $h_myshop_commands->get($caddy->getVar('caddy_cmd_id'));
if($order == null) {
	myshop_utils::redirect(_MYSHOP_ERROR16, MYSHOP_URL, 5);
}

// Send file to download if it exists
$file = '';
$file = $product->getVar('product_download_url');
if(xoops_trim($file) == '') {
	myshop_utils::redirect(_MYSHOP_ERROR17, MYSHOP_URL, 5);
}
if(!file_exists($file)) {
	myshop_utils::redirect(_MYSHOP_ERROR18, MYSHOP_URL, 5);
}

// Update, file is not available to download
$h_myshop_caddy->markCaddyAsNotDownloadableAnyMore($caddy);

// Display file with mime type
header("Content-Type: ".myshop_utils::getMimeType($file));
header('Content-disposition: inline; filename="'.basename($file).'"');
readfile($file);
?>