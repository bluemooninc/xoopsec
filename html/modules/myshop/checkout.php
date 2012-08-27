<?php

/**
 * User fatal validation and redirection to Paypal
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_command.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once MYSHOP_PATH.'class/myshop_paypal.php';
require_once MYSHOP_PATH.'class/registryfile.php';

$uid = myshop_utils::getCurrentUserID();

// Orders reserved to registered users
if(myshop_utils::getModuleOption('restrict_orders', false) == 1 && $uid == 0) {
	$registry = new myshop_registryfile();
	$text = $registry->getfile(MYSHOP_TEXTFILE5);
	myshop_utils::redirect(xoops_trim($text), 'index.php', 5);
}

$op = 'default';
if(isset($_POST['op'])) {
	$op = $_POST['op'];
}

$xoopsTpl->assign('op', $op);
$cartForTemplate = array();
$emptyCart = false;
$shippingAmount = $commandAmount = $vatAmount = $commandAmountTTC = $discountsCount = 0;
$goOn = '';
$discountsDescription = array();

function formHidden(){

}
function listCart()
{
	global $cartForTemplate, $emptyCart, $shippingAmount, $commandAmount, $vatAmount, $goOn, $commandAmountTTC, $discountsDescription;
	$reductions = new myshop_reductions();
	$reductions->computeCart($cartForTemplate, $emptyCart, $shippingAmount, $commandAmount, $vatAmount, $goOn, $commandAmountTTC, $discountsDescription, $discountsCount);
}

$countries = XoopsLists::getCountryList();
$myshop_Currency = & myshop_Currency::getInstance();

switch ($op)
{
	case 'default':

		if($h_myshop_caddy->isCartEmpty()) {
			myshop_utils::redirect(_MYSHOP_CART_IS_EMPTY, MYSHOP_URL, 4);
		}
		listCart();
		$notFound = true;

		if($uid > 0) {	// if registered user, search old orders to fill form fields
			$commande = null;
			$commande = $h_myshop_commands->getLastUserOrder($uid);
			if(is_object($commande)) {
				$notFound = false;
			}
		}

		if($notFound) {
			$commande = $h_myshop_commands->create(true);
			$commande->setVar('cmd_country', MYSHOP_DEFAULT_COUNTRY);
		}

		$sform = new XoopsThemeForm(_MYSHOP_PLEASE_ENTER, "informationfrm", MYSHOP_URL.'checkout.php', 'post');
		$sform->addElement(new XoopsFormHidden('op', 'paypal'));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_TOTAL, $myshop_Currency->amountForDisplay($commandAmountTTC)));
		//$sform->addElement(new XoopsFormLabel(_MYSHOP_SHIPPING_PRICE, $myshop_Currency->amountForDisplay($shippingAmount)));
		$sform->addElement(new XoopsFormText(_MYSHOP_LASTNAME,'cmd_lastname',50,255, $commande->getVar('cmd_lastname')), true);
		$sform->addElement(new XoopsFormText(_MYSHOP_FIRSTNAME,'cmd_firstname',50,255, $commande->getVar('cmd_firstname')), false);
		$sform->addElement(new XoopsFormTextArea(_MYSHOP_STREET,'cmd_adress', $commande->getVar('cmd_adress'), 3, 50), true);
		$sform->addElement(new XoopsFormText(_MYSHOP_CP,'cmd_zip',5,30, $commande->getVar('cmd_zip')), true);
		$sform->addElement(new XoopsFormText(_MYSHOP_CITY,'cmd_town',40,255, $commande->getVar('cmd_town')), true);
		$sform->addElement(new XoopsFormSelectCountry(_MYSHOP_COUNTRY, 'cmd_country', $commande->getVar('cmd_country')), true);
		$sform->addElement(new XoopsFormText(_MYSHOP_PHONE,'cmd_telephone',15,50, $commande->getVar('cmd_telephone')), false);
		if($uid > 0) {
			$sform->addElement(new XoopsFormText(_MYSHOP_EMAIL,'cmd_email',50,255, $xoopsUser->getVar('email')), true);
		} else {
			$sform->addElement(new XoopsFormText(_MYSHOP_EMAIL,'cmd_email',50,255,''), true);
		}
		$sform->addElement(new XoopsFormRadioYN(_MYSHOP_INVOICE,'cmd_bill', 0), true);
		// Pay off-line
		if(myshop_utils::getModuleOption('offline_payment') == 1 ) {
			if(xoops_trim(myshop_utils::getModuleOption('paypal_email')) != '') {
				$sform->addElement(new XoopsFormRadioYN(_MYSHOP_ASK_PAY_ONLINE, 'offline_payment', 1), true);
			} else {
				$sform->addElement(new XoopsFormHidden('offline_payment', 0));
			}
		}

		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', _MYSHOP_SAVE, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);

		$sform = myshop_utils::formMarkRequiredFields($sform);
		$xoopsTpl->assign('form', $sform->render());

		break;

	case 'paypal':	// Validation before sent to paypal
	
		if($h_myshop_caddy->isCartEmpty()) {
			myshop_utils::redirect(_MYSHOP_CART_IS_EMPTY, MYSHOP_URL, 4);
		}
		listCart();

		$password = md5(xoops_makepass());
		$passwordCancel = md5(xoops_makepass());
		$paypal = new myshop_paypal(myshop_utils::getModuleOption('paypal_test'), myshop_utils::getModuleOption('paypal_email'), myshop_utils::getModuleOption('paypal_money'), true, $passwordCancel);

		$commande = $h_myshop_commands->create(true);
		$commande->setVars($_POST);
		$commande->setVar('cmd_uid',$uid);
		$commande->setVar('cmd_date',date("Y-m-d"));
		$commande->setVar('cmd_state',MYSHOP_STATE_NOINFORMATION);
		$commande->setVar('cmd_ip', myshop_utils::IP());
		$commande->setVar('cmd_articles_count', count($cartForTemplate));
		$commande->setVar('cmd_total', $commandAmountTTC);
		$commande->setVar('cmd_shipping', $shippingAmount);
		$commande->setVar('cmd_password', $password);
		$commande->setVar('cmd_cancel', $passwordCancel);
		$commande->setVar('cmd_text', implode("\n",$discountsDescription));
		$res = $h_myshop_commands->insert($commande, true);
		if(!$res) {
			myshop_utils::redirect(_MYSHOP_ERROR10, MYSHOP_URL, 6);
		}

		// Save Cart
		$msgCommande = '';
		foreach($cartForTemplate as $line) {
			$panier = $h_myshop_caddy->create(true);
			$panier->setVar('caddy_product_id', $line['product_id']);
			$panier->setVar('caddy_qte', $line['product_qty']);
			$panier->setVar('caddy_price', $line['totalPrice']);	// Attention! All-fee price with shipping
			$panier->setVar('caddy_cmd_id', $commande->getVar('cmd_id'));
			$panier->setVar('caddy_shipping', $line['discountedShipping']);
			$panier->setVar('caddy_pass', md5(xoops_makepass()));	// Download
			$msgCommande .= str_pad(wordwrap($line['product_title'], 60), 60, ' ').' '.str_pad($line['product_qty'],8, ' ', STR_PAD_LEFT).' '.str_pad($line['totalPrice'],10,' ',STR_PAD_LEFT).' '.str_pad($line['discountedShipping'],10,' ',STR_PAD_LEFT)."\n";
			$res = $h_myshop_caddy->insert($panier, true);
		}
		// Total
		$msgCommande .= "\n\n"._MYSHOP_SHIPPING_PRICE.' '.$myshop_Currency->amountForDisplay($shippingAmount)."\n";
		$msgCommande .= _MYSHOP_TOTAL." ".$myshop_Currency->amountForDisplay($commandAmountTTC)."\n";
		if(count($discountsDescription) > 0) {
			$msgCommande .= "\n\n"._MYSHOP_CART4."\n";
			$msgCommande .= implode("\n",$discountsDescription);
			$msgCommande .= "\n";
		}
		$msg = array();
		$msg['COMMANDE'] = $msgCommande;
		$msg['NUM_COMMANDE'] = $commande->getVar('cmd_id');
		$msg['NOM'] = $commande->getVar('cmd_lastname');
		$msg['PRENOM'] = $commande->getVar('cmd_firstname');
		$msg['ADRESSE'] = $commande->getVar('cmd_adress');
		$msg['CP'] = $commande->getVar('cmd_zip');
		$msg['VILLE'] = $commande->getVar('cmd_town');
		$msg['PAYS'] = $countries[$commande->getVar('cmd_country')];
		$msg['TELEPHONE'] = $commande->getVar('cmd_telephone');
		$msg['EMAIL'] = $commande->getVar('cmd_email');
		$msg['URL_BILL'] = MYSHOP_URL.'invoice.php?id='.$commande->getVar('cmd_id').'&pass='.$password;
		$msg['IP'] = myshop_utils::IP();
		if($commande->getVar('cmd_bill') == 1) {
			$msg['FACTURE'] = _YES;
		} else {
			$msg['FACTURE'] = _NO;
		}
		// Send mail to user
		myshop_utils::sendEmailFromTpl('command_client.tpl', $commande->getVar('cmd_email'), sprintf(_MYSHOP_THANKYOU_CMD, $xoopsConfig['sitename']), $msg);
		// Send mail to group admin
		myshop_utils::sendEmailFromTpl('command_shop.tpl', myshop_utils::getEmailsFromGroup(myshop_utils::getModuleOption('grp_sold')), _MYSHOP_NEW_COMMAND, $msg);

		// Display form to send to Paypal
		// Display final caddy with hidden values
        $offline_payment = myshop_utils::getModuleOption('offline_payment');
        $paypal_email = xoops_trim(myshop_utils::getModuleOption('paypal_email'));
        $gmopg_payment = intval(myshop_utils::getModuleOption('gmopg_payment'));
		if(
            ( $offline_payment== 1  && isset($_POST['offline_payment']) && intval($_POST['offline_payment']) == 0)
            || $commandAmountTTC == 0
            || ( $paypal_email == '' && $gmopg_payment == 0 )
        ) {
			$payURL = XOOPS_URL;
			$registry = new myshop_registryfile();
			$text = $registry->getfile(MYSHOP_TEXTFILE4);
			$xoopsTpl->assign('text', xoops_trim($text));
			$sform = new XoopsThemeForm(_MYSHOP_FINISH, 'payform', $payURL, 'post');
			$h_myshop_caddy->emptyCart();
		} elseif( $gmopg_payment == 1 ) {
            $payURL = "http://localhost/gmopg/html/modules/gmopgx/entryTran";
            $sform = new XoopsThemeForm(_MYSHOP_PAY_ONLINE, 'payform', $payURL, 'post');
            $sform->addElement(new XoopsFormHidden("OrderID", $commande->getVar('cmd_id')));
            $sform->addElement(new XoopsFormHidden("PayAmount", $commandAmountTTC));
        } else {
			$payURL = $paypal->getURL();
			$sform = new XoopsThemeForm(_MYSHOP_PAY_ONLINE, 'payform', $payURL, 'post');
			$elements = array();
			$elements = $paypal->getFormContent(
                $commande->getVar('cmd_id'), $commandAmountTTC, $commande->getVar('cmd_email')
            );
			foreach($elements as $key => $value) {
				$sform->addElement(new XoopsFormHidden($key, $value));
			}
		}
		$sform->addElement(new XoopsFormLabel(_MYSHOP_TOTAL, $myshop_Currency->amountForDisplay($commandAmountTTC)));
		//$sform->addElement(new XoopsFormLabel(_MYSHOP_SHIPPING_PRICE, $myshop_Currency->amountForDisplay($shippingAmount)));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_LASTNAME, $commande->getVar('cmd_lastname')));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_FIRSTNAME, $commande->getVar('cmd_firstname')));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_STREET, $commande->getVar('cmd_adress')));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_CP, $commande->getVar('cmd_zip')));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_CITY, $commande->getVar('cmd_town')));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_COUNTRY, $countries[$commande->getVar('cmd_country')]));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_PHONE, $commande->getVar('cmd_telephone')));
		$sform->addElement(new XoopsFormLabel(_MYSHOP_EMAIL, $commande->getVar('cmd_email')));

		if($commande->getVar('cmd_bill') == 0) {
			$sform->addElement(new XoopsFormLabel(_MYSHOP_INVOICE, _NO));
		} else {
			$sform->addElement(new XoopsFormLabel(_MYSHOP_INVOICE, _YES));
		}
		$button_tray = new XoopsFormElementTray('' ,'');
		if(($offline_payment == 1  && isset($_POST['offline_payment']) && intval($_POST['offline_payment']) == 0) || $commandAmountTTC == 0) {
			$submit_btn = new XoopsFormButton('', 'post', _MYSHOP_FINISH, 'submit');
            $button_tray->addElement($submit_btn);
        } elseif( $gmopg_payment == 1 ) {
            $submit_btn2 = new XoopsFormButton('', 'post', _MYSHOP_PAY_CCARD, 'submit');
            $button_tray->addElement($submit_btn2);
        } else {
            $submit_btn = new XoopsFormButton('', 'post', _MYSHOP_PAY_PAYPAL, 'submit');
            $button_tray->addElement($submit_btn);
        }
		$sform->addElement($button_tray);
		$xoopsTpl->assign('form', $sform->render());
		break;
}

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MYSHOP_VALIDATE_CMD)));

$title = _MYSHOP_VALIDATE_CMD.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
myshop_utils::setCSS();
require_once(XOOPS_ROOT_PATH . '/footer.php');
