<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_productsmanu extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('pm_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('pm_product_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('pm_manu_id',XOBJ_DTYPE_INT,null,false);
		// Alllow html
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}
}


class MyshopMyshop_productsmanuHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//							Table					Classe				Id
		parent::__construct($db, 'myshop_productsmanu', 'myshop_productsmanu', 'pm_id');
	}

	/**
	 * Retourne le nombre de produits associ� � un fabricant
	 *
	 * @param integer $pm_manu_id	L'identifiant du fabricant
	 * @return integer	Le nombre de fabricants
	 */
	function getManufacturerProductsCount($pm_manu_id)
	{
		$criteria = new Criteria('pm_manu_id', $pm_manu_id, '=');
		return $this->getCount($criteria);
	}

	/**
	 * Retourne des fabricants de produits en fonction de leur IDs
	 *
	 * @param array $ids	Les identifiants des produits
	 * @return array	Tableau d'objets de type myshop_productsmanu
	 */
	function getFromProductsIds($ids)
	{
		$ret = array();
		if(is_array($ids)) {
			$criteria = new Criteria('pm_product_id', '('.implode(',', $ids).')', 'IN');
			$ret = $this->getObjects($criteria, true, true, '*', false);
		}
		return $ret;
	}

	/**
	 * Retourne les identifiants des produits d'un fabricant
	 *
	 * @param intege $pm_manu_id	L'identifiant du fabricant
	 * @return array	Les ID des produits
	 */
	function getProductsIdsFromManufacturer($pm_manu_id, $start = 0, $limit = 0)
	{
		$ret = array();
		$criteria = new Criteria('pm_manu_id', $pm_manu_id , '=');
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$items = $this->getObjects($criteria, false, false, 'pm_product_id', false);
		if(count($items) > 0) {
			foreach($items as $item) {
				$ret[] = $item['pm_product_id'];
			}
		}
		return $ret;
	}
}
?>