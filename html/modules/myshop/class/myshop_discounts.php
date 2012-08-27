<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit('XOOPS root path not defined');
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}
// Define discounts

define("MYSHOP_DISCOUNT_PRICE_TYPE0", 0);	// Discount not defined
define("MYSHOP_DISCOUNT_PRICE_TYPE1", 1);	// Discount degressive
define("MYSHOP_DISCOUNT_PRICE_TYPE2", 2);	// Discount amount or percent

define('MYSHOP_DISCOUNT_PRICE_REDUCE_PERCENT', 1);
define('MYSHOP_DISCOUNT_PRICE_REDUCE_MONEY', 2);

define("MYSHOP_DISCOUNT_PRICE_AMOUNT_ON_PRODUCT", 1);
define("MYSHOP_DISCOUNT_PRICE_AMOUNT_ON_CART", 2);

define("MYSHOP_DISCOUNT_PRICE_CASE_ALL", 1);			// All cases
define("MYSHOP_DISCOUNT_PRICE_CASE_FIRST_BUY", 2);
define("MYSHOP_DISCOUNT_PRICE_CASE_PRODUCT_NEVER", 3);
define("MYSHOP_DISCOUNT_PRICE_CASE_QTY_IS", 4);			// product quantity is ...

define("MYSHOP_DISCOUNT_PRICE_QTY_COND1", 1);			//  >  
define("MYSHOP_DISCOUNT_PRICE_QTY_COND2", 2);			//  >=
define("MYSHOP_DISCOUNT_PRICE_QTY_COND3", 3);			//  < 
define("MYSHOP_DISCOUNT_PRICE_QTY_COND4", 4);			//  <= 
define("MYSHOP_DISCOUNT_PRICE_QTY_COND5", 5);			//  = 

define("MYSHOP_DISCOUNT_PRICE_QTY_COND1_TEXT", '>');			//  >
define("MYSHOP_DISCOUNT_PRICE_QTY_COND2_TEXT", '>=');			//  >= 
define("MYSHOP_DISCOUNT_PRICE_QTY_COND3_TEXT", '<');			//  < 
define("MYSHOP_DISCOUNT_PRICE_QTY_COND4_TEXT", '<=');			//  <= 
define("MYSHOP_DISCOUNT_PRICE_QTY_COND5_TEXT", '=');			//  = 

define('MYSHOP_DISCOUNT_SHIPPING_TYPE1', 1);			// Shipping fee
define('MYSHOP_DISCOUNT_SHIPPING_TYPE2', 2);			// Shipping fee are free
define('MYSHOP_DISCOUNT_SHIPPING_TYPE3', 3);			// Shipping fee has discount of ...
define('MYSHOP_DISCOUNT_SHIPPING_TYPE4', 4);			// Shipping fee is degressive

class myshop_discounts extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('disc_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_title',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_group',XOBJ_DTYPE_INT,null,false);	// Groups (0=all groups)
		$this->initVar('disc_cat_cid',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_store_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_product_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_type',XOBJ_DTYPE_INT,null,false);	// Discount Type (grad., amount or percent)
		$this->initVar('disc_price_degress_l1qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l1qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l1total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_price_degress_l2qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l2qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l2total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_price_degress_l3qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l3qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l3total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_price_degress_l4qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l4qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l4total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_price_degress_l5qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l5qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_price_degress_l5total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_price_amount_amount',XOBJ_DTYPE_TXTBOX,null,false);	// Amount of price
		$this->initVar('disc_price_amount_type',XOBJ_DTYPE_INT,null,false);			// Amount or Percent ?
		$this->initVar('disc_price_amount_on',XOBJ_DTYPE_INT,null,false);			// Product on cart ?
		$this->initVar('disc_price_case',XOBJ_DTYPE_INT,null,false);				// When
		$this->initVar('disc_price_case_qty_cond',XOBJ_DTYPE_INT,null,false);		// Superior, Inferior, Equal
		$this->initVar('disc_price_case_qty_value',XOBJ_DTYPE_INT,null,false);		// Product Quantity
		$this->initVar('disc_shipping_type',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_free_morethan',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_shipping_reduce_amount',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_shipping_reduce_cartamount',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_shipping_degress_l1qty1',XOBJ_DTYPE_INT,null,false);  // Discount degressive
		$this->initVar('disc_shipping_degress_l1qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l1total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_shipping_degress_l2qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l2qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l2total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_shipping_degress_l3qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l3qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l3total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_shipping_degress_l4qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l4qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l4total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_shipping_degress_l5qty1',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l5qty2',XOBJ_DTYPE_INT,null,false);
		$this->initVar('disc_shipping_degress_l5total',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('disc_date_from',XOBJ_DTYPE_INT,null,false);	// Date to start promo
		$this->initVar('disc_date_to',XOBJ_DTYPE_INT,null,false);	// Date to end promo
		$this->initVar('disc_description',XOBJ_DTYPE_TXTAREA, null, false);

		// Allow html
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}
}


class MyshopMyshop_discountsHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//						Table					Classe	 			Id		  Label
		parent::__construct($db, 'myshop_discounts', 'myshop_discounts', 'disc_id', 'disc_title');
	}

	private function getDiscountedPrice($price, $discount)
	{
		return $price - ($price * ($discount/100));
	}


	/**
	 * Return rules to apply to a period
	 * @param void
	 * @return array objects myshop_discounts
	 */
	function getRulesForThisPeriod()
	{
		static $buffer = array();
		if(is_array($buffer) && count($buffer) > 0) {
			return $buffer;
		} else {
			$critere = new CriteriaCompo();
			$critere->add(new Criteria('disc_date_from', 0, '='));
			$critere->add(new Criteria('disc_date_to', 0, '='), 'OR');

			$critere2 = new CriteriaCompo();
			$critere2->add(new Criteria('disc_date_from', time(), '>='));
			$critere2->add(new Criteria('disc_date_to', time(), '<='));
			$critere->add($critere2);

			$buffer = $this->getObjects($critere);
		}
		return $buffer;
	}

	/**
	 * Rules of user group
	 *
	 * @return array
	 */
	function getRulesOnEachBook()
	{
		static $buffer = array();
		if(is_array($buffer) && count($buffer) > 0) {

		} else {
			$groups = myshop_utils::getCurrentMemberGroups();
			$critere = new CriteriaCompo();
			$critere->add(new Criteria('disc_on_what', MYSHOP_DISCOUNT_ON3, '='));
			if(count($groups) > 0) {
				$critere->add(new Criteria('disc_group', '('.implode(',', $groups).')', 'IN'));
			}
			$buffer = $this->getObjects($critere);
		}
		return $buffer;
	}


	/**
	 * Rules of product
	 *
	 * @return array
	 */
	function getRulesOnAllProducts()
	{
		static $buffer = array();
		if(is_array($buffer) && count($buffer) > 0) {

		} else {
			$critere = new CriteriaCompo();
			$critere->add(new Criteria('disc_on_what', MYSHOP_DISCOUNT_ON2, '='));
			$tblGroups = myshop_utils::getCurrentMemberGroups();
			$critere->add(new Criteria('disc_group', '('.implode(',', $tblGroups).')', 'IN'));
			$buffer = $this->getObjects($critere);
		}
		return $buffer;
	}


	/**
	 * Rules of shipping
	 *
	 * @return array
	 */
	function getRulesOnShipping()
	{
		static $buffer = array();
		if(is_array($buffer) && count($buffer) > 0) {

		} else {
			$critere = new CriteriaCompo();
			$critere->add(new Criteria('disc_on_what', MYSHOP_DISCOUNT_ON4, '='));
			$tblGroups = myshop_utils::getCurrentMemberGroups();
			$critere->add(new Criteria('disc_group', '('.implode(',', $tblGroups).')', 'IN'));
			$buffer = $this->getObjects($critere);
		}
		return $buffer;
	}


	/**
	 * Rules of shipping options
	 *
	 * @return array
	 */
	function getRulesOnShipping2()
	{
		static $buffer = array();
		if(is_array($buffer) && count($buffer) > 0) {

		} else {
			$critere = new CriteriaCompo();
			$critere->add(new Criteria('disc_on_what', MYSHOP_DISCOUNT_ON5, '='));
			$critere->add(new Criteria('disc_shipping', MYSHOP_DISCOUNT_SHIPPING2, '='));
			$tblGroups = myshop_utils::getCurrentMemberGroups();
			$critere->add(new Criteria('disc_group', '('.implode(',', $tblGroups).')', 'IN'));
			$buffer = $this->getObjects($critere);
		}
		return $buffer;
	}


	/**
	 * Rules of Order
	 *
	 * @return array
	 */
	function getRulesOnCommand()
	{
		static $buffer = array();
		if(is_array($buffer) && count($buffer) > 0) {

		} else {
			$critere = new CriteriaCompo();
			$critere->add(new Criteria('disc_on_what', MYSHOP_DISCOUNT_ON1, '='));
			$tblGroups = myshop_utils::getCurrentMemberGroups();
			$critere->add(new Criteria('disc_group', '('.implode(',', $tblGroups).')', 'IN'));
			$buffer = $this->getObjects($critere);
		}
		return $buffer;
	}


	/**
	 * Discount on Shipping Price
	 *
	 * @param float $montant
	 * @param array $discountsDescription
	 */
	function applyDiscountOnShipping2(&$montantShipping, $commandAmount, &$discountsDescription)
	{
		$tblRules = array();
		$tblRules = $this->getRulesOnShipping2();
		if( count($tblRules) > 0 ) {
			foreach($tblRules as $rule) {
				if($commandAmount > floatval($rule->getVar('disc_if_amount'))) {
					$discountsDescription[] = $rule->getVar('disc_description');
					$montantShipping = 0;
				}
			}
		}
	}


	/**
	 * Discount on Total Order
	 *
	 * @param float $montantHT   Amount without Fee
	 * @param array $discountsDescription
	 */
	function applyDiscountOnCommand(&$montantHT, &$discountsDescription)
	{
		global $h_myshop_commands;
		$tblRules = array();
		$tblRules = $this->getRulesOnCommand();	
		if( count($tblRules) > 0 ) {
			$uid = myshop_utils::getCurrentUserID();
			foreach($tblRules as $rule) {
				switch($rule->getVar('disc_when')) {
					case MYSHOP_DISCOUNT_WHEN1:	
						if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	
							$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
							if($montantHT < 0) {
								$montantHT = 0;
							}
						} else {
							$montantHT -= $rule->getVar('disc_amount');
							if($montantHT < 0 ) {
								$montantHT = 0;
							}
						}
						$discountsDescription[] = $rule->getVar('disc_description');
						break;

					case MYSHOP_DISCOUNT_WHEN2:	
						if($h_myshop_commands->isFirstCommand($uid)) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {
								$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
								if($montantHT < 0) {
									$montantHT = 0;
								}
							} else {	
								$montantHT -= $rule->getVar('disc_amount');
								if($montantHT < 0) {
									$montantHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;
				}
			}
		}
	}

	/**
	 * Discount Shipping
	 *
	 * @param float $montantHT
	 * @param array $discountsDescription
 	 * @param integer $productQty
	 */
	function applyDiscountOnShipping(&$montantHT, &$discountsDescription, $productQty)
	{
		global $h_myshop_commands;
		$tblRules = array();
		$tblRules = $this->getRulesOnShipping();	
		if( count($tblRules) > 0 ) {
			$uid = myshop_utils::getCurrentUserID();
			foreach($tblRules as $rule) {
				switch($rule->getVar('disc_when')) {
					case MYSHOP_DISCOUNT_WHEN1:	
						if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	
							$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
							if($montantHT < 0) {
								$montantHT = 0;
							}
						} else {	
							// Discount x euros
							$montantHT -= $rule->getVar('disc_amount');
							if($montantHT < 0) {
								$montantHT = 0;
							}
						}
						$discountsDescription[] = $rule->getVar('disc_description');
						break;

					case MYSHOP_DISCOUNT_WHEN2:	// First order
						if($h_myshop_commands->isFirstCommand($uid)) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount de x percent
								$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
								if($montantHT < 0) {
									$montantHT = 0;
								}
							} else {	
								// Discount x euros
								$montantHT -= $rule->getVar('disc_amount');
								if($montantHT < 0) {
									$montantHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;

					case MYSHOP_DISCOUNT_WHEN4:	// Quantity is =, >, >=, <, <= to ...
						$qtyDiscount = false;
						switch($rule->getVar('disc_qty_criteria')) {
							case 0:	// =
								if($productQty == $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 1:	// >
								if($productQty > $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 2:	// >=
								if($productQty >= $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 3:	// <
								if($productQty < $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 4:	// <=
								if($productQty <= $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

						}
						if($qtyDiscount) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount x percent
								$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
								if($montantHT < 0) {
									$montantHT = 0;
								}
							} else {	// Discount de x euros
								$montantHT -= $rule->getVar('disc_amount');
								if($montantHT < 0) {
									$montantHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;
				}
			}
		}
	}

	/**
	 * Discount on Product Price without Fee
	 *
	 * @param float $montantHT   Amount without Fee
	 * @param array $discountsDescription
	 * @param integer $productQty
	 */
	function applyDiscountOnAllProducts(&$montantHT, &$discountsDescription, $productQty)
	{
		global $h_myshop_commands;
		$tblRules = array();
		$tblRules = $this->getRulesOnAllProducts();	// Return objects Discounts
		if( count($tblRules) > 0 ) {
			$uid = myshop_utils::getCurrentUserID();
			foreach($tblRules as $rule) {
				switch($rule->getVar('disc_when')) {
					case MYSHOP_DISCOUNT_WHEN1:	// All
						if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount x pourcent
							$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
							if($montantHT < 0) {
								$montantHT = 0;
							}
						} else {	
							// Discount x euros
							$montantHT -= $rule->getVar('disc_amount');
							if($montantHT < 0) {
								$montantHT = 0;
							}
						}
						$discountsDescription[] = $rule->getVar('disc_description');
						break;

					case MYSHOP_DISCOUNT_WHEN2:	// First Order
						if($h_myshop_commands->isFirstCommand($uid)) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount x percent
								$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
								if($montantHT < 0) {
									$montantHT = 0;
								}
							} else {	
								// Discount x euros
								$montantHT -= $rule->getVar('disc_amount');
								if($montantHT < 0) {
									$montantHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;

					case MYSHOP_DISCOUNT_WHEN4:	// if quantity is =, >, >=, <, <= to ...
						$qtyDiscount = false;
						switch($rule->getVar('disc_qty_criteria')) {
							case 0:	// =
								if($productQty == $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 1:	// >
								if($productQty > $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 2:	// >=
								if($productQty >= $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 3:	// <
								if($productQty < $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 4:	// <=
								if($productQty <= $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

						}
						if($qtyDiscount) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	 // Discount x percent
								$montantHT = $this->getDiscountedPrice($montantHT, $rule->getVar('disc_amount'));
								if($montantHT < 0) {
									$montantHT = 0;
								}
							} else {	// Discount de x euros
								$montantHT -= $rule->getVar('disc_amount');
								if($montantHT < 0) {
									$montantHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;
				}
			}
		}
	}


	/**
	 * Calculate Product price with discount and no Fee
	 *
	 * @param integer $produtId
	 * @param float $prixHT  Price without Fee
	 * @param array $discountsDescription 
	 * @param integer $productQty
	 */
	function applyDiscountOnEachProduct($productId, &$prixHT, &$discountsDescription, $productQty)
	{
		global $h_myshop_commands;
		$rules = array();
		$rules = $this->getRulesOnEachProduct();	// Return objects Discounts
		if( count($rules) > 0 ) {
			$uid = myshop_utils::getCurrentUserID();
			foreach($rules as $rule) {
				switch($rule->getVar('disc_when')) {
					case MYSHOP_DISCOUNT_WHEN1:	// All
						if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount x pourcent
							$prixHT = $this->getDiscountedPrice($prixHT, $rule->getVar('disc_amount'));
							if($prixHT < 0) {
								$prixHT = 0;
							}
						} else {	// Discount x euros
							$prixHT -= $rule->getVar('disc_amount');
							if($prixHT < 0) {
								$prixHT = 0;
							}
						}
						$discountsDescription[] = $rule->getVar('disc_description');
						break;

					case MYSHOP_DISCOUNT_WHEN2:	// if first order
						if($h_myshop_commands->isFirstCommand($uid)) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount x percent
								$prixHT = $this->getDiscountedPrice($prixHT, $rule->getVar('disc_amount'));
								if($prixHT < 0) {
									$prixHT = 0;
								}
							} else {	
								// Discount x euros
								$prixHT -= $rule->getVar('disc_amount');
								if($prixHT < 0) {
									$prixHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;

					case MYSHOP_DISCOUNT_WHEN3:	// first sale of product
						if(!$h_myshop_commands->productAlreadyBought($uid, $productId)) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount x percent
								$prixHT = $this->getDiscountedPrice($prixHT, $rule->getVar('disc_amount'));
								if($prixHT < 0) {
									$prixHT = 0;
								}
							} else {	// Discount x euros
								$prixHT -= $rule->getVar('disc_amount');
								if($prixHT < 0) {
									$prixHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;

					case MYSHOP_DISCOUNT_WHEN4:	// if quantity is =, >, >=, <, <= to ...
						$qtyDiscount = false;
						switch($rule->getVar('disc_qty_criteria')) {
							case 0:	// =
								if($productQty == $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 1:	// >
								if($productQty > $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 2:	// >=
								if($productQty >= $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 3:	// <
								if($productQty < $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

							case 4:	// <=
								if($productQty <= $rule->getVar('disc_qty_value')) {
									$qtyDiscount = true;
								}
								break;

						}
						if($qtyDiscount) {
							if($rule->getVar('disc_percent_monney') == MYSHOP_DISCOUNT_TYPE1) {	// Discount x percent
								$prixHT = $this->getDiscountedPrice($prixHT, $rule->getVar('disc_amount'));
								if($prixHT < 0) {
									$prixHT = 0;
								}
							} else {	
								// Discount x euros
								$prixHT -= $rule->getVar('disc_amount');
								if($prixHT < 0) {
									$prixHT = 0;
								}
							}
							$discountsDescription[] = $rule->getVar('disc_description');
						}
						break;
				}
			}
		}
	}
}
?>