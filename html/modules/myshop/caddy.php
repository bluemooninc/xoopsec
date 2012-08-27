<?php

/**
 * Cart
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_caddy.html';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once MYSHOP_PATH.'class/registryfile.php';

$xoopsTpl->assign('mod_pref', $mod_pref);

if(myshop_utils::getModuleOption('restrict_orders', false)) {
	$registry = new myshop_registryfile();
	$text = $registry->getfile(MYSHOP_TEXTFILE5);
	$xoopsTpl->assign('restrict_orders_text', xoops_trim($text));
} else {
	$xoopsTpl->assign('restrict_orders_text', '');
}


$op = 'default';
if(isset($_POST['op'])) {
	$op = $_POST['op'];
} elseif(isset($_GET['op'])) {
	$op = $_GET['op'];
}

$productId = 0;
if(isset($_POST['product_id'])) {
	$productId = $_POST['product_id'];
} elseif(isset($_GET['product_id'])) {
	$productId = $_GET['product_id'];
}

$cmdId = 0;
if(isset($_POST['cmd_id'])) {
    $cmdId = $_POST['cmd_id'];
} elseif(isset($_GET['cmd_id'])) {
    $cmdId = $_GET['cmd_id'];
}

$xoopsTpl->assign('op', $op);
$xoopsTpl->assign('confEmpty', myshop_utils::javascriptLinkConfirm(_MYSHOP_EMPTY_CART_SURE,true));
$xoopsTpl->assign('confirm_delete_item', myshop_utils::javascriptLinkConfirm(_MYSHOP_EMPTY_ITEM_SURE, false));

$uid = myshop_utils::getCurrentUserID();
if($uid > 0) {
    $xoopsTpl->assign('isCartExists', $h_myshop_persistent_cart->isCartExists());
} else {
    $xoopsTpl->assign('isCartExists', false);
}

// Cart content

function listCart()
{
	global $xoopsTpl, $uid;
	$cartForTemplate = $discountsDescription = array();
	$emptyCart = false;
	$shippingAmount = $commandAmount = $vatAmount = $commandAmountTTC = $discountsCount =0;
	$goOn = '';
	$reductions = new myshop_reductions();
	$reductions->computeCart($cartForTemplate, $emptyCart, $shippingAmount, $commandAmount, $vatAmount, $goOn, $commandAmountTTC, $discountsDescription, $discountsCount);
	$myshop_Currency = & myshop_Currency::getInstance();
	$xoopsTpl->assign('emptyCart', $emptyCart);											// Empty
	$xoopsTpl->assign('caddieProducts', $cartForTemplate);								// Products
	$xoopsTpl->assign('shippingAmount', $myshop_Currency->amountForDisplay($shippingAmount));		
	$xoopsTpl->assign('commandAmount', $myshop_Currency->amountForDisplay($commandAmount));		
	$xoopsTpl->assign('vatAmount', $myshop_Currency->amountForDisplay($vatAmount));	
	$xoopsTpl->assign('discountsCount', $discountsCount);						
	$xoopsTpl->assign('goOn', $goOn);													
	$xoopsTpl->assign('commandAmountTTC', $myshop_Currency->amountForDisplay($commandAmountTTC));
	$xoopsTpl->assign('discountsDescription', $discountsDescription);
	$showOrderButton = true;
	if( xoops_trim(myshop_utils::getModuleOption('paypal_email')) == '' && myshop_utils::getModuleOption('offline_payment') == 0) {
		$showOrderButton = false;
	}
	$showRegistredOnly = false;
	if(myshop_utils::getModuleOption('restrict_orders', false) && $uid == 0) {
		$showRegistredOnly = true;
		$showOrderButton = false;
	}
	$xoopsTpl->assign('showRegistredOnly', $showRegistredOnly);
	$xoopsTpl->assign('showOrderButton', $showOrderButton);
}


switch ($op) {
	
	case 'update':	// Re-calculate quantity
	
		if( !$h_myshop_caddy->updateQuantites() ){
            myshop_utils::redirect(_MYSHOP_ERROR0, 'caddy.php', 4);
        }
		listCart();
		break;

	case 'reload':    // Loast last Cart
    
	    $h_myshop_caddy->reloadPersistentCart();
        listCart();
	    break;

	case 'delete':
	
		$productId--;
		$h_myshop_caddy->deleteProduct($productId);
		listCart();
		break;

	case 'addproduct':
	
		if($productId == 0) {
			myshop_utils::redirect(_MYSHOP_ERROR9, 'index.php', 4);
		}
		$product = null;
		$product = $h_myshop_products->get($productId);
		if(!is_object($product)) {
			myshop_utils::redirect(_MYSHOP_ERROR9, 'index.php', 4);
		}
		if($product->getVar('product_online') == 0) {
			myshop_utils::redirect(_MYSHOP_ERROR2, 'index.php', 4);
		}

		if($product->getVar('product_stock') - 1 >= 0) {
			$h_myshop_caddy->addProduct($productId, 1);
			$url = MYSHOP_URL.'caddy.php';
			header("Location: $url");
		} else {
			myshop_utils::redirect(_MYSHOP_PROBLEM_QTY,'index.php', 5);	// No more stock
		}
		listCart();
		break;

	case 'empty':  // Delete Caddy Content
	
		$h_myshop_caddy->emptyCart();
		listCart();
		break;

    case 'purchased':	// Purchased list
        $purchased = $h_myshop_caddy->purchased($xoopsUser->uid(),$cmdId);
        $myshop_Currency = & myshop_Currency::getInstance();
        foreach($purchased as $purchase){
            $product[] = array(
                'product_number' => $purchase['caddy_product_id'],
                'product_title' => $purchase['product_title'],
                'unitBasePriceFormated' => $myshop_Currency->amountForDisplay($purchase['caddy_price']),
                'product_qty' => $purchase['caddy_qte'],
                'discountedPriceWithQuantityFormated' => $purchase['caddy_qte'],
                'discountedShippingFormated' => $myshop_Currency->amountForDisplay($purchase['caddy_shipping']),
                'totalPriceFormated' => $myshop_Currency->amountForDisplay($purchase['caddy_price'])
            );
//                'totalPriceFormated' => $purchase['caddy_price'] * $purchase['caddy_qte'] + $purchase['caddy_shipping']
        }
        $xoopsTpl->assign('purchased',true);
        $xoopsTpl->assign('caddieProducts',$product);
        break;

    case 'default':
	
		listCart();
		break;
}

	myshop_utils::setCSS();
	if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php')) {
		require_once  MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
	} else {
		require_once  MYSHOP_PATH.'language/english/modinfo.php';
	}

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MI_MYSHOP_SMNAME1)));

$title = _MI_MYSHOP_SMNAME1.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
require_once XOOPS_ROOT_PATH . '/footer.php';
?>