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
 * Page for Paypal
 */
@error_reporting(0);
require 'header.php';
require_once MYSHOP_PATH.'class/myshop_paypal.php';
require_once MYSHOP_PATH.'class/registryfile.php';
@error_reporting(0);

$log = '';
$req = 'cmd=_notify-validate';
$slashes = get_magic_quotes_gpc();
foreach ($_POST as $key => $value) {
	if($slashes) {
		$log .= "$key=".stripslashes($value)."\n";
		$value = urlencode(stripslashes($value));
	} else {
		$log .= "$key=".$value."\n";
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}

$paypal = new myshop_paypal(myshop_utils::getModuleOption('paypal_test'), myshop_utils::getModuleOption('paypal_email'), myshop_utils::getModuleOption('paypal_money'), true);
$url = $paypal->getURL(true);
$header = '';
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: ". strlen($req)."\r\n\r\n";
$errno = 0;
$errstr = '';
$fp = fsockopen ($url, 80, $errno, $errstr, 30);
if ($fp) {
	fputs ($fp, "$header$req");
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp($res, "VERIFIED") == 0) {
			$log .= "VERIFIED\t";
			$paypalok = true;
			if (strtoupper($_POST['payment_status']) != 'COMPLETED') $paypalok = false;
			if (strtoupper($_POST['receiver_email']) != strtoupper(myshop_utils::getModuleOption('paypal_email'))) $paypalok = false;
			if (strtoupper($_POST['mc_currency']) != strtoupper(myshop_utils::getModuleOption('paypal_money'))) $paypalok = false;
			if (!$_POST['custom']) $paypalok = false;
			$montant = $_POST['mc_gross'];
			if ($paypalok) {
				$ref = intval($_POST['custom']);	// Order n°
				$commande = null;
				$commande = $h_myshop_commands->get($ref);
				if(is_object($commande)) {
					if($montant == $commande->getVar('cmd_total')) {	// Order checked
						$h_myshop_commands->validateOrder($commande);	// Validation and stocks update
					} else {
						$h_myshop_commands->setFraudulentOrder($commande);
					}
				}
        	} else {
				if(isset($_POST['custom'])) {
					$ref = intval($_POST['custom']);
					$commande = null;
					$commande = $h_myshop_commands->get($ref);
					if(is_object($commande)) {
						switch(strtoupper($_POST['payment_status'])) {
							case 'PENDING':
								$h_myshop_commands->setOrderPending($commande);
								break;
							case 'FAILED':
								$h_myshop_commands->setOrderFailed($commande);
								break;
						}
					}
				}
        	}
 		} else {
			$log .= "$res\n";
		}
	}
	fclose ($fp);
} else {
	$log .= "Error with the fsockopen function, unable to open communication ' : ($errno) $errstr\n";
}

if(!file_exists(MYSHOP_PAYPAL_LOG_PATH)) {
	file_put_contents(MYSHOP_PAYPAL_LOG_PATH, '<?php exit(); ?>');
}
$fp = fopen(MYSHOP_PAYPAL_LOG_PATH, 'a');
if($fp) {
	fwrite($fp, str_repeat('-',120)."\n");
	fwrite($fp, date('d/m/Y H:i:s')."\n");
	if(isset($_POST['txn_id'])) {
		fwrite($fp, "Transaction : ".$_POST['txn_id']."\n");
	}
	fwrite($fp, "Result : ".$log."\n");
	fclose($fp);
}
?>