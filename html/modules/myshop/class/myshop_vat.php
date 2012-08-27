<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_vat extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('vat_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('vat_rate',XOBJ_DTYPE_TXTBOX,null,false);
	}
}


class MyshopMyshop_vatHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//						Table			Classe		 	Id
		parent::__construct($db, 'myshop_vat', 'myshop_vat', 'vat_id');
	}

	/**
	 * Return All TAX
	 *
	 * @param integer $start Position de d�part
	 * @param integer $limit Nombre total d'enregistrements � renvoyer
	 * @param string $order Champ sur lequel faire le tri
	 * @param string $order Ordre du tri
	 * @param boolean $idaskey Indique si le tableau renvoy� doit avoir pour cl� l'identifiant unique de l'enregistrement
	 * @return array tableau d'objets de type TVA
	 */
	function getAllVats($start = 0, $limit = 0, $sort = 'vat_id', $order='ASC', $idaskey = true)
	{
		$critere = new Criteria('vat_id', 0 ,'<>');
		$critere->setLimit($limit);
		$critere->setStart($start);
		$critere->setSort($sort);
		$critere->setOrder($order);
		$tblVats = array();
		$tblVats = $this->getObjects($critere, $idaskey);
		return $tblVats;
	}

	/**
	 * Suppression d'une TVA
	 *
	 * @param myshop_vat $vat
	 * @return boolean	Le r�sultat de la suppressin
	 */
	function deleteVat(myshop_vat $vat)
	{
		return $this->delete($vat, true);
	}

	/**
	 * Retourne le nombre de produits associ�s � une TVA
	 *
	 * @param integer $vat_id	L'ID de la TVA
	 * @return integer	Le nombre de produits
	 */
	function getVatProductsCount($vat_id)
	{
		global $h_myshop_products;
		return $h_myshop_products->getVatProductsCount($vat_id);
	}
}
?>