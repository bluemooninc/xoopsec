<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_caddy extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('caddy_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('caddy_product_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('caddy_qte',XOBJ_DTYPE_INT,null,false);
		$this->initVar('caddy_price',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('caddy_cmd_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('caddy_shipping',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('caddy_pass',XOBJ_DTYPE_TXTBOX,null,false);
	}

	/**
	 * Return products to display
	 *
	 * @param string $format	
	 * @return array
	 */
	function toArray($format = 's')
	{
		$ret = array();
		$ret = parent::toArray($format);
		$myshop_Currency = myshop_Currency::getInstance();
		$ret['caddy_price_fordisplay'] = $myshop_Currency->amountForDisplay($this->getVar('caddy_price'));
		$ret['caddy_shipping_fordisplay'] = $myshop_Currency->amountForDisplay($this->getVar('caddy_shipping'));
		return $ret;
	}
}


class MyshopMyshop_caddyHandler extends Myshop_XoopsPersistableObjectHandler
{
	const CADDY_NAME =	'myshop_caddie';	// session name

	function __construct($db)
	{	//						  Table				Classe		 	Id
		parent::__construct($db, 'myshop_caddy', 'myshop_caddy', 'caddy_id');
	}

	/**
	 * Check related product
	 *
	 * @param integer $caddy_product_id Related product id
	 * @return integer
	 */
	function getBestWith($caddy_product_id)
	{
		$sql = 'SELECT caddy_product_id, sum(caddy_qte) mv FROM '.$this->table.' WHERE caddy_cmd_id IN (SELECT caddy_cmd_id FROM '.$this->table.' WHERE caddy_product_id='.intval($caddy_product_id).') GROUP BY caddy_product_id ORDER BY mv DESC';
		$result = $this->db->query($sql, 1);
        if (!$result) {
            return 0;
        }
        $myrow = $this->db->fetchArray($result);
        $id = $myrow['caddy_product_id'];
        if($id != $caddy_product_id) {
        	return $id;
        } else {
        	return 0;
        }
	}

	/**
	 * Most Sell by category
	 *
	 * @param integer $product_cid Category
	 * @param integer $start Search
	 * @param integer $limit number to display 
	 * @param boolean $withQuantity display or not
	 * @return array
	 */
	function getMostSoldProducts($start = 0, $limit = 0, $product_cid = 0, $withQuantity=false)
	{
		$ret = array();
		if(is_array($product_cid)) {
			$sql = 'SELECT c.caddy_product_id, sum( c.caddy_qte ) AS mv FROM '.$this->table.' c, '.$this->db->prefix('myshop_products').' b WHERE (c.caddy_product_id = b.product_id) AND b.product_cid IN ('.implode(',', $product_cid).') GROUP BY c.caddy_product_id ORDER BY mv DESC';
		} elseif($product_cid > 0) {
			$sql = 'SELECT c.caddy_product_id, sum( c.caddy_qte ) AS mv FROM '.$this->table.' c, '.$this->db->prefix('myshop_products').' b WHERE (c.caddy_product_id = b.product_id) AND b.product_cid = '.intval($product_cid).' GROUP BY c.caddy_product_id ORDER BY mv DESC';
		} else {
			$sql = 'SELECT caddy_product_id, sum( caddy_qte ) as mv FROM '.$this->table.' GROUP BY caddy_product_id ORDER BY mv DESC';
		}
        $result = $this->db->query($sql, $limit, $start);
        if ($result) {
			while ($myrow = $this->db->fetchArray($result)) {
				if(!$withQuantity) {
					$ret[$myrow['caddy_product_id']] = $myrow['caddy_product_id'];
				} else {
					$ret[$myrow['caddy_product_id']] = $myrow['mv'];
				}
			}
        }
        return $ret;
	}

    function purchased($uid,$cmd_id=NULL)
    {
        $ret = array();
        $sql = 'SELECT c.*,b.* FROM '.$this->table.' c '
            .'LEFT JOIN '.$this->db->prefix('myshop_products').' b ON (c.caddy_product_id = b.product_id) '
            .'LEFT JOIN '.$this->db->prefix('myshop_commands').' o ON (c.caddy_cmd_id = o.cmd_id) '
            .'WHERE o.cmd_uid='.$uid;
        if (!is_null($cmd_id)) $sql .= ' AND c.caddy_cmd_id='.$cmd_id;
        $result = $this->db->query($sql);
        if ($result) {
            while ($myrow = $this->db->fetchArray($result)) {
                $ret[$myrow['caddy_product_id']] = $myrow;
            }
        }
        return $ret;
    }

	/**
	 *
	 * @return boolean empty or not
	 */
	function isCartEmpty()
	{
		if(isset($_SESSION[self::CADDY_NAME])) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Empty Cart
	 */
	function emptyCart()
	{
	    global $xoopsUser, $h_myshop_persistent_cart;
		if(isset($_SESSION[self::CADDY_NAME])) {
			unset($_SESSION[self::CADDY_NAME]);
			if(is_object($xoopsUser)) {
                $h_myshop_persistent_cart->deleteAllUserProducts();
			}
		}
	}

    /**
     * Last cart of user
     * @return void
     */
	function reloadPersistentCart()
    {
        global $xoopsUser, $h_myshop_persistent_cart;
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return false;
	    }
	    if(is_object($xoopsUser)) {
	        $persistent_carts = array();
	        $persistent_carts = $h_myshop_persistent_cart->getUserProducts();
	        foreach($persistent_carts as $persistent_cart) {
	            $this->addProduct($persistent_cart->getVar('persistent_product_id'), $persistent_cart->getVar('persistent_qty'));
	        }
	    }
    }

	/**
	 * Add a Product to Cart
	 *
	 * @param integer $product_id
	 * @param integer $quantity
	 */
	function addProduct($product_id, $quantity)
	{
	    global $xoopsUser, $h_myshop_persistent_cart;
		$tbl_caddie = $tbl_caddie2 = array();
		if(isset($_SESSION[self::CADDY_NAME])) {
			$tbl_caddie = $_SESSION[self::CADDY_NAME];
		}
		$exists = false;
		foreach($tbl_caddie as $produit) {
			if($produit['id'] == $product_id) {
				$exists = true;
				$produit['qty'] += $quantity;
				$newQuantity = $produit['qty'];
			}
			$tbl_caddie2[] = $produit;
		}
		if(!$exists) {
			if(is_object($xoopsUser)) {
			    $h_myshop_persistent_cart->addUserProduct($product_id, $quantity);
			}
			$datas = array();
			$datas['number'] = count($tbl_caddie)+1;
			$datas['id'] = $product_id;
			$datas['qty'] = $quantity;
			$tbl_caddie[] = $datas;
			$_SESSION[self::CADDY_NAME] = $tbl_caddie;
		} else {
			$_SESSION[self::CADDY_NAME] = $tbl_caddie2;
			if(is_object($xoopsUser)) {
			    $h_myshop_persistent_cart->updateUserProductQuantity($product_id, $newQuantity);
			}
		}
	}

	/**
	 * Delete product from Cart
	 *
	 * @param integer $indice
	 */
	function deleteProduct($indice)
	{
	    global $xoopsUser, $h_myshop_persistent_cart;
		$tbl_caddie = array();
		if(isset($_SESSION[self::CADDY_NAME])) {
			$tbl_caddie = $_SESSION[self::CADDY_NAME];
			if(isset($tbl_caddie[$indice])) {
				if(is_object($xoopsUser)) {
			        $datas = array();
				    $datas = $tbl_caddie[$indice];
				    $h_myshop_persistent_cart->deleteUserProduct($datas['id']);
				}
			    unset($tbl_caddie[$indice]);
				if(count($tbl_caddie) > 0) {
					$_SESSION[self::CADDY_NAME] = $tbl_caddie;
				} else {
					unset($_SESSION[self::CADDY_NAME]);
				}
			}
		}
	}

	/**
	 * Update Cart after validation
	 */
	function updateQuantites()
	{
		global $h_myshop_products, $xoopsUser, $h_myshop_persistent_cart;
		$tbl_caddie = $tbl_caddie2 = array();
        $updated = false;
        if(isset($_SESSION[self::CADDY_NAME])) {
			$tbl_caddie = $_SESSION[self::CADDY_NAME];
			foreach($tbl_caddie as $produit) {
				$number = $produit['number'];
				$name = 'qty_'.$number;
                if(isset($_POST[$name])) {
					$valeur = intval($_POST[$name]);
					if($valeur > 0) {
						$product_id = $produit['id'];
						$product = null;
						$product = $h_myshop_products->get($product_id);
						if(is_object($product)) {
							if($product->getVar('product_stock') - $valeur > 0) {
								$produit['qty'] = $valeur;
								$tbl_caddie2[] = $produit;
                                $updated = true;
                            } else {
								$produit['qty'] = $product->getVar('product_stock');
								$tbl_caddie2[] = $produit;
							}
							if(is_object($xoopsUser)) {
							    $h_myshop_persistent_cart->updateUserProductQuantity($product_id, $produit['qty']);
							}
						}
					}
				} else {
				    $tbl_caddie2[] = $produit;
				}
			}
			if(count($tbl_caddie2) > 0 ) {
				$_SESSION[self::CADDY_NAME] = $tbl_caddie2;
			} else {
				unset($_SESSION[self::CADDY_NAME]);
			}
		}
        return $updated;
    }

	/**
	 * Return Order
	 *
	 * @param integer $caddy_cmd_id 
	 * @return array
	 */
	function getCaddyFromCommand($caddy_cmd_id)
	{
		$ret = array();
		$critere = new Criteria('caddy_cmd_id', $caddy_cmd_id, '=');
		$ret = $this->getObjects($critere);
		return $ret;
	}

	/**
	 * Return id Order of product
	 *
	 * @param integer $product_id 
	 * @return array
	 */
	function getCommandIdFromProduct($product_id)
	{
		$ret = array();
		$sql = 'SELECT caddy_cmd_id FROM '.$this->table.' WHERE caddy_product_id='.intval($product_id);
		$result = $this->db->query($sql);
        if (!$result) {
            return $ret;
        }
        while($myrow = $this->db->fetchArray($result)) {
        	$ret[] = $myrow['caddy_cmd_id'];
        }
        return $ret;
	}

	/**
	 * Get cart from password
	 *
	 * @param string $caddy_pass
	 * @return mixed
	 */
	function getCaddyFromPassword($caddy_pass)
	{
		$ret = null;
		$caddies = array();
		$critere = new Criteria('caddy_pass', $caddy_pass, '=');
		$caddies = $this->getObjects($critere);
		if(count($caddies) > 0) {
			$ret = $caddies[0];
		}
		return $ret;
	}

	/**
	 * Set cart as downloaded
	 *
	 * @param myshop_caddy $caddy
	 * @return boolean
	 */
	function markCaddyAsNotDownloadableAnyMore(myshop_caddy $caddy)
	{
		$caddy->setVar('caddy_pass', '');
		return $this->insert($caddy, true);
	}
}
?>