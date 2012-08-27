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

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_persistent_cart extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('persistent_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('persistent_product_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('persistent_uid',XOBJ_DTYPE_INT,null,false);
		$this->initVar('persistent_date',XOBJ_DTYPE_INT,null,false);
		$this->initVar('persistent_qty',XOBJ_DTYPE_INT,null,false);
	}
}


class MyshopMyshop_persistent_cartHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//						  Table						Classe		 				  Id
		parent::__construct($db, 'myshop_persistent_cart', 'myshop_persistent_cart', 'persistent_id');
	}

	/**
	 * Supprime un produit des paniers enregistr�s
	 *
	 * @param mixed $persistent_product_id	L'ID du produit � supprimer ou un tableau d'identifiants � supprimer
	 * @return boolean
	 */
	function deleteProductForAllCarts($persistent_product_id)
	{
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return true;
	    }
		if(is_array($persistent_product_id)) {
			$criteria = new Criteria('persistent_product_id', '('.implode(',', $persistent_product_id).')', 'IN');
		} else {
			$criteria = new Criteria('persistent_product_id', $persistent_product_id, '=');
		}
		return $this->deleteAll($criteria);
	}

	/**
	 * Purge des produits d'un utilisateur
	 *
	 * @param integer $persistent_uid	L'identifiant de l'utilisateur
	 * @return boolean	Le r�sultat de la suppression
	 */
	function deleteAllUserProducts($persistent_uid = 0)
	{
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return true;
	    }
		$persistent_uid = $persistent_uid == 0 ? myshop_utils::getCurrentUserID() : $persistent_uid;

		$criteria = new Criteria('persistent_uid', $persistent_uid, '=');
		return $this->deleteAll($criteria);
	}

	/**
	 * Supprime UN produit d'un utilisateur
	 *
	 * @param integer $persistent_product_id	L'identifiant du produit
	 * @param integer $persistent_uid	L'identifiant de l'utilisateur
	 * @return boolean	Le r�sultat de la suppression
	 */
	function deleteUserProduct($persistent_product_id, $persistent_uid = 0)
	{
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return true;
	    }
		$persistent_uid = $persistent_uid == 0 ? myshop_utils::getCurrentUserID() : $persistent_uid;
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('persistent_uid', $persistent_uid, '='));
		$criteria->add(new Criteria('persistent_product_id', $persistent_product_id, '='));
		return $this->deleteAll($criteria);
	}

	/**
	 * Ajoute un produit au panier d'un utilisateur
	 *
	 * @param integer $persistent_product_id	L'ID du produit
	 * @param integer $persistent_qty	La quantit� de produits
	 * @param integer $persistent_uid	L'ID de l'utilisateur
	 * @return boolean	Le r�sultat de l'ajout du produit
	 */
	function addUserProduct($persistent_product_id, $persistent_qty, $persistent_uid = 0)
	{
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return true;
	    }
		$persistent_uid = $persistent_uid == 0 ? myshop_utils::getCurrentUserID() : $persistent_uid;
		$persistent_cart = $this->create(true);
		$persistent_cart->setVar('persistent_product_id', $persistent_product_id);
		$persistent_cart->setVar('persistent_uid', $persistent_uid);
		$persistent_cart->setVar('persistent_date', time());
		$persistent_cart->setVar('persistent_qty', $persistent_qty);
		return $this->insert($persistent_cart, true);
	}

    /**
     * Mise � jour de la quantit� de produit d'un utilisateur
     *
     * @param integer $persistent_product_id	L'identifiant du produit
     * @param integer $persistent_qty	La quantit� de produit
     * @param integer $persistent_uid	L'ID de l'utilisateur
     * @return boolean	Le r�sultat de la mise � jour
     */
	function updateUserProductQuantity($persistent_product_id, $persistent_qty, $persistent_uid = 0)
	{
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return true;
	    }
		$persistent_uid = $persistent_uid == 0 ? myshop_utils::getCurrentUserID() : $persistent_uid;
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('persistent_uid', $persistent_uid, '='));
		$criteria->add(new Criteria('persistent_product_id', $persistent_product_id, '='));
		return $this->updateAll('persistent_qty', $persistent_qty, $criteria, true);
	}

    /**
     * Indique s'il existe un panier pour un utilisateur
     *
     * @param integer $persistent_uid	L'id de l'utilisateur
     * @return boolean
     */
	function isCartExists($persistent_uid = 0)
	{
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return false;
	    }
		$persistent_uid = $persistent_uid == 0 ? myshop_utils::getCurrentUserID() : $persistent_uid;
		$criteria = new Criteria('persistent_uid', $persistent_uid, '=');
		return $this->getCount($criteria);
	}

    /**
     * Retourne les produits d'un utilisateur
     *
     * @param integer $persistent_uid	L'ID de l'utilisateur
     * @return array	Tableaux d'objets de type myshop_persistent_cart
     */
	function getUserProducts($persistent_uid = 0)
	{
	    if(myshop_utils::getModuleOption('persistent_cart') ==  0) {
	        return false;
	    }
		$persistent_uid = $persistent_uid == 0 ? myshop_utils::getCurrentUserID() : $persistent_uid;
		$criteria = new Criteria('persistent_uid', $persistent_uid, '=');
		return $this->getObjects($criteria);
	}
}
?>