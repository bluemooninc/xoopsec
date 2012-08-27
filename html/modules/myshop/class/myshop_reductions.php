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


class myshop_reductions
{
	// Active Rules
	private $allActiveRules = array();

	// Number of products by category
	private $categoriesProductsCount = array();

	// Products Quantity by category
	private $categoriesProductsQuantities = array();

	/**
	 *  Cart 
	 * 	$cart['number'] = product ref
	 * 	$cart['id'] = product id
	 * 	$cart['qty'] = product quantitY
	 *  $cart['product'] = product object of cart
	 */
	private $cart = array();

	
	// Cart template. Check details from method ComputeCart
	private $cartForTemplate = array();
	
	// Rules to apply
	private $rulesForTheWhole = array();

	// Products quantity before discounts
	private $totalProductsQuantities = 0;
	
	// Order Amount before discounts
	private $totalAmountBeforeDiscounts = 0;

	// Module tables Handlers
	private $handlers;

	// Products Manufacturers
	private $associatedManufacturers = array();
	
	// Products stores
	private $associatedStores = array();
	
	// Products categories
	private $associatedCategories = array();
	
	// Manufacturers by product
	private $associatedManufacturersPerProduct = array();

	
	// handlers and active rules
	
	function __construct()
	{
		$this->initHandlers();
		$this->loadAllActiveRules();
	}

	
	// handlers
	 
	private function initHandlers()
	{
		$this->handlers = myshop_handler::getInstance();
	}


	
	// All active rules
	 
	function loadAllActiveRules()
	{
		$critere = new CriteriaCompo();
		$critere1 = new CriteriaCompo();
		$critere1->add(new Criteria('disc_date_from', 0, '='));
		$critere1->add(new Criteria('disc_date_to', 0, '='));
		$critere->add($critere1);

		$critere2 = new CriteriaCompo();
		$critere2->add(new Criteria('disc_date_from', time(), '<='));
		$critere2->add(new Criteria('disc_date_to', time(), '>='));
		$critere->add($critere2, 'OR');

		$this->allActiveRules = $this->handlers->h_myshop_discounts->getObjects($critere);
	}


	
	 // Products quantity by category
	 
	function computePerCategories(myshop_products $product, $quantity)
	{
		if(isset($this->categoriesProductsCount[$product->product_cid])) {
			$this->categoriesProductsCount[$product->product_cid] += 1;
		} else {
			$this->categoriesProductsCount[$product->product_cid] = 1;
		}

		// Update quantity of categories
		if(isset($this->categoriesProductsQuantities[$product->product_cid])) {
			$this->categoriesProductsQuantities[$product->product_cid] += $quantity;
		} else {
			$this->categoriesProductsQuantities[$product->product_cid] = $quantity;
		}
		$this->totalProductsQuantities += $quantity;	// Quantity of all products
	}

	
	// Add to internal table product manufacturer
	
	private function addAssociatedManufacturers(myshop_products $product)
	{
		if(!isset($this->associatedManufacturers[$product->product_id])) {
			$this->associatedManufacturers[$product->product_id] = $product->product_id;
		}
	}

	// Add to internal table product store
	 
	private function addAssociatedStores(myshop_products $product)
	{
		if(!isset($this->associatedStores[$product->product_store_id])) {
			$this->associatedStores[$product->product_store_id] = $product->product_store_id;
		}
	}

	
	// Add to internal table product category
	 
	private function addAssociatedCategories(myshop_products $product)
	{
		if(!isset($this->associatedCategories[$product->product_cid])) {
			$this->associatedCategories[$product->product_cid] = $product->product_cid;
		}
	}

	
	// Cart products manufacturers
	
	private function loadAssociatedManufacturers()
	{
		if(count($this->associatedManufacturers) > 0) {
			sort($this->associatedManufacturers);
			$productsIds = $this->associatedManufacturers;
			$this->associatedManufacturers = array();	// to avoid any error
			$productsManufacturers = $manufacturersIds = array();
			$productsManufacturers = $this->handlers->h_myshop_productsmanu->getFromProductsIds($productsIds);
			if(count($productsManufacturers) > 0) {
				foreach($productsManufacturers as $productManufacturer) {
					if(!isset($manufacturersIds[$productManufacturer->pm_manu_id])) {
						$manufacturersIds[$productManufacturer->pm_manu_id] = $productManufacturer->pm_manu_id;
					}
					$this->associatedManufacturersPerProduct[$productManufacturer->pm_product_id][] = $productManufacturer->pm_manu_id;
				}
				if(count($manufacturersIds) > 0) {
					sort($manufacturersIds);
					$this->associatedManufacturers = $this->handlers->h_myshop_manufacturer->getManufacturersFromIds($manufacturersIds);
				}
			}
		}
	}

	
	// Load products stores
	
	private function loadAssociatedStores()
	{
		if(count($this->associatedStores) > 0) {
			sort($this->associatedStores);
			$ids = $this->associatedStores;
			$this->associatedStores = $this->handlers->h_myshop_stores->getStoresFromIds($ids);
		}
	}

	
	// Load products categories
	
	private function loadAssociatedCategories()
	{
		if(count($this->associatedCategories) > 0) {
			sort($this->associatedCategories);
			$ids = $this->associatedCategories;
			$this->associatedCategories = $this->handlers->h_myshop_cat->getCategoriesFromIds($ids);
		}
	}

	
	// Search product manufacturer, category and store
	
	function loadElementsAssociatedToProducts()
	{
		$this->loadAssociatedManufacturers();
		$this->loadAssociatedStores();
		$this->loadAssociatedCategories();
	}

	
	// Search product objects of cart to calculate quantity
	
	function loadProductsAssociatedToCart()
	{
		$newCart = array();
		foreach($this->cart as $cartProduct) {
			$data = array();
			$data['id'] = $cartProduct['id'];
			$data['number'] = $cartProduct['number'];
			$data['qty'] = $cartProduct['qty'];

			$product = null;
			$product = $this->handlers->h_myshop_products->get($data['id']);
			if(!is_object($product)) {
				trigger_error(_MYSHOP_ERROR9);
				exit(_MYSHOP_ERROR9);
			}
			$data['product'] = $product;
			// Update categories
			$this->computePerCategories($product, $data['qty']);
			// Searc product manufacturer, store, category
			$this->addAssociatedManufacturers($product);
			$this->addAssociatedStores($product);
			$this->addAssociatedCategories($product);

			// Order amount and discount
            $productPrice = floatval($product->getVar('product_price'));
/*            if($product->getVar('product_discount_price') > 0) {
				$productPrice = floatval($product->getVar('product_discount_price'));
			} else {
				$productPrice = floatval($product->getVar('product_price'));
			}*/
			$this->totalAmountBeforeDiscounts += ($data['qty'] * $productPrice);

			$newCart[] = $data;
		}
		$this->loadElementsAssociatedToProducts();
		$this->cart = $newCart;
	}

	/**
	 * Calculate amount without fee to apply discount percent
	 *
	 * @param float $price	
	 * @param integer $discount	
	 * @return floa
	 */
	private function getDiscountedPrice($price, $discount)
	{
		return $price - ($price * ($discount/100));
	}

	
	// Initialize
	
	private function initializePrivateData()
	{
		$this->totalProductsQuantities = 0;
		$this->totalAmountBeforeDiscounts = 0;
		$this->rulesForTheWhole = array();
		$this->cartForTemplate = array();
		$this->associatedManufacturers = array();
		$this->associatedStores = array();
		$this->associatedCategories = array();
		$this->associatedManufacturersPerProduct = array();
	}

	/**
	 * Calculate cart order
	 * Content of cart session :
	 *
	 * 	$datas['number'] = product ref.
	 * 	$datas['id'] = product id.
	 * 	$datas['qty'] = quantity
	 *
	 *  Private var of $cart is similar + object 'myshop_products' in key 'product'
	 *
	 * @param array $cartForTemplate 
	 * @param boolean emptyCart 
	 * @param float $shippingAmount
	 * @param float $commandAmount 
	 * @param float $vatAmount
	 * @param string $goOn      Link to last visited category 
	 * @param float $commandAmountTTC   Amount with All Fee
	 * @param array $discountsDescription 
	 * @param integer $discountsCount	
	 */
	function computeCart(&$cartForTemplate, &$emptyCart, &$shippingAmount, &$commandAmount, &$vatAmount, &$goOn, &$commandAmountTTC, &$discountsDescription, &$discountsCount)
	{
		$emptyCart = false;
		$goOn = '';
		$vats = array();
		$cpt = 0;
		$discountsCount = 0;
		$this->cart = isset($_SESSION[MyshopMyshop_caddyHandler::CADDY_NAME]) ? $_SESSION[MyshopMyshop_caddyHandler::CADDY_NAME] : array();
		$cartCount = count($this->cart);
		if( $cartCount < 0 ) {
			$emptyCart = true;
			return true;
		}
		// Initialize Private Data
		$this->initializePrivateData();
		
		// Load related products and calculate categories quantity
		$this->loadProductsAssociatedToCart();
		
		// VAT
		$vats = $this->handlers->h_myshop_vat->getAllVats();
		$myshop_Currency = & myshop_Currency::getInstance();
		$caddyCount = count($this->cart);

		// Initialize total of ht=without VAT, tva= VAT, and shipping
		$totalHT = $totalVAT = $totalShipping = 0;

		// Check each product and discount rule 
		foreach($this->cart as $cartProduct) {
            $vatId = $cartProduct['product']->getVar('product_vat_id');

            if (count($vats)==0) break;
            $vatRate = $vats[$vatId]->getVar('vat_rate');

/*            if($cartProduct['product']->getVar('product_discount_price') > 0) {
				$productPrice = floatval($cartProduct['product']->getVar('product_discount_price'));
			} else {
				$productPrice = floatval($cartProduct['product']->getVar('product_price'));
			}*/
            $productPrice = floatval($cartProduct['product']->getVar('product_price'));
            $discountedPrice = floatval($cartProduct['product']->getVar('product_discount_price'));
			$quantity = $cartProduct['qty'];

			if(myshop_utils::getModuleOption('shipping_quantity')) {
				$discountedShipping = $cartProduct['product']->getVar('product_shipping_price') * $quantity;
			} else {
				$discountedShipping = $cartProduct['product']->getVar('product_shipping_price');
			}
            $totalPrice = 0;
			$reduction = $discountedPrice ? _MYSHOP_FORSALE : '';

            $cpt++;
			if(($cpt == $caddyCount)) {
				$category = null;
				$category = $this->handlers->h_myshop_cat->get($cartProduct['product']->getVar('product_cid'));
				if(is_object($category)) {
					$goOn = $category->getLink();
				}
			}

			// Check All Active Rules
			foreach($this->allActiveRules as $rule) {
				$applyRule = false;
				if( ($rule->disc_group != 0 && myshop_utils::isMemberOfGroup($rule->disc_group)) || $rule->disc_group == 0) {
					if( ($rule->disc_cat_cid != 0 && $cartProduct['product']->getVar('product_cid') == $rule->disc_cat_cid) || $rule->disc_cat_cid ==0) {
						if( ($rule->disc_store_id != 0 && $cartProduct['product']->getVar('disc_store_id') == $rule->disc_store_id) || $rule->disc_store_id ==0) {
							if( ($rule->disc_product_id != 0 && $cartProduct['product']->getVar('product_id') == $rule->disc_product_id) || $rule->disc_product_id ==0) {
								// When to apply
								switch($rule->disc_price_case) {
									case MYSHOP_DISCOUNT_PRICE_CASE_ALL:	// All
										$applyRule = true;
										break;
									case MYSHOP_DISCOUNT_PRICE_CASE_FIRST_BUY:	// Fist Order
										if($this->handlers->h_myshop_commands->isFirstCommand()) {
											$applyRule = true;
										}
										break;
									case MYSHOP_DISCOUNT_PRICE_CASE_PRODUCT_NEVER:	// Firs time user buy the product
										if(!$this->handlers->h_myshop_commands->productAlreadyBought(0, $cartProduct['product']->getVar('product_id'))) {
											$applyRule = true;
										}
										break;
									case MYSHOP_DISCOUNT_PRICE_CASE_QTY_IS:	// if quantity of product is...
										switch($rule->disc_price_case_qty_cond) {
											case MYSHOP_DISCOUNT_PRICE_QTY_COND1:	// >
												if($cartProduct['qty'] > $rule->disc_price_case_qty_value) {
													$applyRule = true;
												}
												break;
											case MYSHOP_DISCOUNT_PRICE_QTY_COND2:	// >=
												if($cartProduct['qty'] >= $rule->disc_price_case_qty_value) {
													$applyRule = true;
												}
												break;
											case MYSHOP_DISCOUNT_PRICE_QTY_COND3:	// <
												if($cartProduct['qty'] < $rule->disc_price_case_qty_value) {
													$applyRule = true;
												}
												break;
											case MYSHOP_DISCOUNT_PRICE_QTY_COND4:	// <=
												if($cartProduct['qty'] <= $rule->disc_price_case_qty_value) {
													$applyRule = true;
												}
												break;
											case MYSHOP_DISCOUNT_PRICE_QTY_COND5:	// ==
												if($cartProduct['qty'] == $rule->disc_price_case_qty_value) {
													$applyRule = true;
												}
												break;
										}
								}
							}
						}
					}
				}
				if($applyRule) {	// Apply rule
					// Calculate product price without fee
					switch($rule->disc_price_type) {
						case MYSHOP_DISCOUNT_PRICE_TYPE1:	// Amount related to quantity
							if($quantity >= $rule->disc_price_degress_l1qty1 && $quantity <= $rule->disc_price_degress_l1qty2) {
								$discountedPrice = $rule->disc_price_degress_l1total;
							}
							if($quantity >= $rule->disc_price_degress_l2qty1 && $quantity <= $rule->disc_price_degress_l2qty2) {
								$discountedPrice = $rule->disc_price_degress_l2total;
							}
							if($quantity >= $rule->disc_price_degress_l3qty1 && $quantity <= $rule->disc_price_degress_l3qty2) {
								$discountedPrice = $rule->disc_price_degress_l3total;
							}
							if($quantity >= $rule->disc_price_degress_l4qty1 && $quantity <= $rule->disc_price_degress_l4qty2) {
								$discountedPrice = $rule->disc_price_degress_l4total;
							}
							if($quantity >= $rule->disc_price_degress_l5qty1 && $quantity <= $rule->disc_price_degress_l5qty2) {
								$discountedPrice = $rule->disc_price_degress_l5total;
							}
							$reduction = $rule->disc_description;
							$discountsCount++;
							break;

						case MYSHOP_DISCOUNT_PRICE_TYPE2:	// Discount amount or percentage
							if($rule->disc_price_amount_on == MYSHOP_DISCOUNT_PRICE_AMOUNT_ON_PRODUCT) {	// Discount on product
								if($rule->disc_price_amount_type == MYSHOP_DISCOUNT_PRICE_REDUCE_PERCENT) {	// Discount percentage
									$discountedPrice = $this->getDiscountedPrice($discountedPrice, $rule->getVar('disc_price_amount_amount'));
								} elseif($rule->disc_price_amount_type == MYSHOP_DISCOUNT_PRICE_REDUCE_MONEY) {	// Discount amount
									$discountedPrice -= floatval($rule->getVar('disc_price_amount_amount'));
								}

								// No negative value
								if($discountedPrice < 0 ) {
									$discountedPrice = 0;
								}
								$reduction = $rule->disc_description;
								$discountsCount++;
							} elseif($rule->disc_price_amount_on == MYSHOP_DISCOUNT_PRICE_AMOUNT_ON_CART) {	// Rule to apply to cart
								if(!isset($this->rulesForTheWhole[$rule->disc_id])) {
									$this->rulesForTheWhole[$rule->disc_id] = $rule;
								}
							}
							break;
					}

					// Shipping Fee
					switch($rule->disc_shipping_type) {
						case MYSHOP_DISCOUNT_SHIPPING_TYPE1:	// Fee
							break;
						case MYSHOP_DISCOUNT_SHIPPING_TYPE2:	// Free if user order is more than X euros
							if($this->totalAmountBeforeDiscounts > $rule->disc_shipping_free_morethan) {
								$discountedShipping = 0;
							}
							break;
						case MYSHOP_DISCOUNT_SHIPPING_TYPE3:	// Discount on shipping fee of X euros if order is > x
							if($this->totalAmountBeforeDiscounts > $rule->disc_shipping_reduce_cartamount) {
								$discountedShipping -= floatval($rule->disc_shipping_reduce_amount);
							}
							// No negative value
							if($discountedShipping < 0) {
								$discountedShipping = 0;
							}
							break;
						case MYSHOP_DISCOUNT_SHIPPING_TYPE4:	// Shipping fee degressive
							if($quantity >= $rule->disc_shipping_degress_l1qty1 && $quantity <= $rule->disc_shipping_degress_l1qty2) {
								$discountedShipping = $rule->disc_shipping_degress_l1total;
							}
							if($quantity >= $rule->disc_shipping_degress_l2qty1 && $quantity <= $rule->disc_shipping_degress_l2qty2) {
								$discountedShipping = $rule->disc_shipping_degress_l2total;
							}
							if($quantity >= $rule->disc_shipping_degress_l3qty1 && $quantity <= $rule->disc_shipping_degress_l3qty2) {
								$discountedShipping = $rule->disc_shipping_degress_l3total;
							}
							if($quantity >= $rule->disc_shipping_degress_l4qty1 && $quantity <= $rule->disc_shipping_degress_l4qty2) {
								$discountedShipping = $rule->disc_shipping_degress_l4total;
							}
							if($quantity >= $rule->disc_shipping_degress_l5qty1 && $quantity <= $rule->disc_shipping_degress_l5qty2) {
								$discountedShipping = $rule->disc_shipping_degress_l5total;
							}
							break;
					}	// Discount rule for shipping fee
				}	// Apply discount rule
			}	// Check discounts

			// Calculate product VAT
            if ($discountedPrice){
                $vatAmount = myshop_utils::getVAT(($discountedPrice * $quantity), $vatRate);
                $discountedPrice += $discountedPrice * (($vatRate)/100);
                $totalPrice = ($discountedPrice * $quantity) + $discountedShipping;
            }else{
                $vatAmount = myshop_utils::getVAT(($productPrice * $quantity), $vatRate);
                $productPrice += $productPrice * (($vatRate)/100);
                $totalPrice = ($productPrice * $quantity) + $discountedShipping;
            }
			// Calculate product all fee ((ht * qte) + vat + shipping)

			// Total
			$totalHT += $totalPrice;
			$totalVAT += $vatAmount;
			$totalShipping += $discountedShipping;

			// Product related
			$associatedStore = $associatedCategory = $associatedManufacturers = array();
			$manufacturersJoinList = '';
			// store
			if(isset($this->associatedStores[$cartProduct['product']->product_store_id])) {
				$associatedStore = $this->associatedStores[$cartProduct['product']->product_store_id]->toArray();
			}

			// Cat�egory
			if(isset($this->associatedCategories[$cartProduct['product']->product_cid])) {
				$associatedCategory = $this->associatedCategories[$cartProduct['product']->product_cid]->toArray();
			}

			// Manufacturers
			$product_id = $cartProduct['product']->product_id;
			if(isset($this->associatedManufacturersPerProduct[$product_id])) {
				$manufacturers = $this->associatedManufacturersPerProduct[$product_id];
				$manufacturersList = array();
				foreach($manufacturers as $manufacturer_id) {
					if(isset($this->associatedManufacturers[$manufacturer_id]))
						$associatedManufacturers[] = $this->associatedManufacturers[$manufacturer_id]->toArray();
						$manufacturersList[] = $this->associatedManufacturers[$manufacturer_id]->manu_commercialname.' '.$this->associatedManufacturers[$manufacturer_id]->manu_name;
				}
				$manufacturersJoinList = implode(MYSHOP_STRING_TO_JOIN_MANUFACTURERS, $manufacturersList);

			}
			$productTemplate = array();
			$productTemplate = $cartProduct['product']->toArray();
			$productTemplate['number'] = $cartProduct['number'];
			$productTemplate['id'] = $cartProduct['id'];
			$productTemplate['product_qty'] = $cartProduct['qty'];

			$productTemplate['unitBasePrice'] = $productPrice;				// Unity price HT (without vat) WITHOUT discount r�duction
			$productTemplate['discountedPrice'] = $discountedPrice;	// Unity price HT (without vat) WITH discount
			$productTemplate['discountedPriceWithQuantity'] = $discountedPrice * $quantity;	// Price HT (without vat) WITH discount and quantity
			// Formated prices
            $discountedPriceFormated = ($discountedPrice) * (100+$vatRate)/100;
			$productTemplate['unitBasePriceFormated'] = $myshop_Currency->amountForDisplay($productPrice);				
			$productTemplate['discountedPriceFormated'] = $myshop_Currency->amountForDisplay( $discountedPriceFormated );
			$productTemplate['discountedPriceWithQuantityFormated'] = $myshop_Currency->amountForDisplay($discountedPrice * $quantity);

			$productTemplate['vatRate'] = $myshop_Currency->amountInCurrency($vatRate);
			$productTemplate['vatAmount'] = $vatAmount;
			$productTemplate['normalShipping'] = $cartProduct['product']->getVar('product_shipping_price');
			$productTemplate['discountedShipping'] = $discountedShipping;
			$productTemplate['totalPrice'] = $totalPrice;
			$productTemplate['reduction'] = $reduction;
			$productTemplate['templateProduct'] = $cartProduct['product']->toArray();

			$productTemplate['vatAmountFormated'] = $myshop_Currency->amountForDisplay($vatAmount);
			$productTemplate['normalShippingFormated'] = $myshop_Currency->amountForDisplay($cartProduct['product']->getVar('product_shipping_price'));
			$productTemplate['discountedShippingFormated'] = $myshop_Currency->amountForDisplay($discountedShipping);
			$productTemplate['totalPriceFormated'] = $myshop_Currency->amountForDisplay($totalPrice);
			$productTemplate['templateCategory'] = $associatedCategory;
			$productTemplate['templateStore'] = $associatedStore;
			$productTemplate['templateManufacturers'] = $associatedManufacturers;
			$productTemplate['manufacturersJoinList'] = $manufacturersJoinList;
			$this->cartForTemplate[] = $productTemplate;
		}	// foreach product in cart

		// Rules if any
		if(count($this->rulesForTheWhole) > 0) {
			// $discountsDescription
			foreach($this->rulesForTheWhole as $rule) {
				switch($rule->disc_price_type) {
					case MYSHOP_DISCOUNT_PRICE_TYPE2:	// Amount or percentage
						if($rule->disc_price_amount_on == MYSHOP_DISCOUNT_PRICE_AMOUNT_ON_CART) {	// Rule to apply to cart
							if($rule->disc_price_amount_type == MYSHOP_DISCOUNT_PRICE_REDUCE_PERCENT) {	// Discount pourcentage
								$totalHT = $this->getDiscountedPrice($totalHT, $rule->getVar('disc_price_amount_amount'));
								$totalVAT = $this->getDiscountedPrice($totalVAT, $rule->getVar('disc_price_amount_amount'));
							} elseif($rule->disc_price_amount_type == MYSHOP_DISCOUNT_PRICE_REDUCE_MONEY) {	// Discount amount
								$totalHT -= floatval($rule->getVar('disc_price_amount_amount'));
								$totalVAT -= floatval($rule->getVar('disc_price_amount_amount'));
							}

							// No negative value
							if($totalHT < 0 ) {
								$totalHT = 0;
							}
							if($totalVAT < 0) {
								$totalVAT = 0;
							}
							$discountsDescription[] = $rule->disc_description;
							$discountsCount++;
						}	// Rule to apply to cart
						break;
				}	// Switch
			}	// Foreach
		}	// if any global rule
		// return total
		$shippingAmount = $totalShipping;
		$commandAmount = $totalHT;
		$vatAmount = $totalVAT;
		$commandAmountTTC = $totalHT;
		$cartForTemplate = $this->cartForTemplate;
		$emptyCart = false;
		return true;
	}
}
?>