<?php

// Paypal

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

class myshop_paypal
{
	public $testMode;
	public $email;
	public $moneyCode;
	public $useIpn;
	public $passwordCancel;

	function __construct($testMode, $emailPaypal, $moneyCode, $ipn=false, $passwordCancel='')
	{
		$this->testMode = $testMode;
		$this->email = $emailPaypal;
		$this->moneyCode = $moneyCode;
		$this->useIpn = $ipn;
		$this->passwordCancel = $passwordCancel;
	}

	/**
	 * Return URL according to test mode or not
	 */
	 function getURL($securized=false)
	 {
	 	if(!$securized) {
	 		if($this->testMode == 1 ) {
   				return 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			} else {
				return 'https://www.paypal.com/cgi-bin/webscr';
	 		}
	 	} else {
	 		if($this->testMode == 1 ) {
   				return 'www.sandbox.paypal.com';
			} else {
				return 'www.paypal.com';
	 		}
	 	}
	 }

	/**
	 * Formate le montant au format Paypal
	 */
	private function formatAmount($amount)
	{
		return sprintf("%.02f", $amount);
	}


	/**
	 * Renvoie les éléments à ajouter au formulaire en tant que zones cachées
	 *
	 * @param integer $commmandId
	 * @param float $ttc
	 */
	function getFormContent($commandId, $ttc, $emailClient)
	{
		global $xoopsConfig;
		$ret = array();
		$ret['cmd'] = '_xclick';
		$ret['upload'] = '1';
		$ret['currency_code'] = $this->moneyCode;
		$ret['business'] = $this->email;
		$ret['return'] = MYSHOP_URL.'thankyou.php';			// Page (générique) de remerciement après paiement
		$ret['image_url'] = XOOPS_URL.'/images/logo.gif';
		$ret['cpp_header_image'] = XOOPS_URL.'/images/logo.gif';
		$ret['invoice'] = $commandId;
		$ret['item_name'] = _MYSHOP_COMMAND.$commandId.' - '.$xoopsConfig['sitename'];
		$ret['item_number'] =  $commandId;
		$ret['tax'] = 0;	// ajout 25/03/2008
		$ret['amount'] = $this->formatAmount($ttc);
		$ret['custom'] = $commandId;
		//$ret['rm'] = 2;	// Return data by POST (normal)
		$ret['email'] = $emailClient;
		// paypal_pdt
		if(xoops_trim($this->passwordCancel) != '') {	// URL à laquelle le navigateur du client est ramené si le paiement est annulé
			$ret['cancel_return'] = MYSHOP_URL.'cancel-payment.php?id='.$this->passwordCancel;
		}
		if($this->useIpn == 1) {
			$ret['notify_url'] = MYSHOP_URL.'paypal-notify.php';
		}
		return $ret;
	}
}
?>
