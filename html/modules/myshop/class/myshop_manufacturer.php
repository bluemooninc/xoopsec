<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_manufacturer extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('manu_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('manu_name',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_commercialname',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_email',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_bio',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('manu_url',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_photo1',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_photo2',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_photo3',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_photo4',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('manu_photo5',XOBJ_DTYPE_TXTBOX,null,false);
		// Allow html
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}

	/**
	 * Retourne l'URL d'une des 5 images du fabricant courant
	 *
	 * @param integer	$pictureNumber	Le num�ro (de 1 � 5) de l'image que l'on souhaite r�cup�rer
	 * @return mixed	L'URL	Soit l'url de l'image soit False si l'indice pass� en param�tre n'est pas correct
	 */
	function getPictureUrl($pictureNumber)
	{
		$pictureNumber = intval($pictureNumber);
		if($pictureNumber > 0 && $pictureNumber < 6) {
			return MYSHOP_PICTURES_URL.'/'.$this->getVar('manu_photo'.$pictureNumber);
		} else {
			return false;
		}
	}

	/**
	 * Retourne le chemin de l'une des 5 images du fabricant courant
	 *
	 * @param integer	$pictureNumber	Le num�ro (de 1 � 5) de l'image que l'on souhaite r�cup�rer
	 * @return string	Le chemin
	 */
	function getPicturePath($pictureNumber)
	{
		$pictureNumber = intval($pictureNumber);
		if($pictureNumber > 0 && $pictureNumber < 6) {
			return MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('manu_photo'.$pictureNumber);
		} else {
			return false;
		}
	}

	/**
	 * Indique si une des 5 images du fabricant existe
	 *
	 * @param integer	$pictureNumber	Le num�ro (de 1 � 5) de l'image que l'on souhaite r�cup�rer
	 * @return boolean	Vrai si l'image existe sinon faux
	 */
	function pictureExists($pictureNumber)
	{
		$pictureNumber = intval($pictureNumber);
		$return = false;
		if($pictureNumber > 0 && $pictureNumber < 6) {
			if(xoops_trim($this->getVar('manu_photo'.$pictureNumber)) != '' && file_exists(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('manu_photo'.$pictureNumber))) {
				$return = true;
			}
		}
		return $return;
	}

	/**
	 * Supprime une des 5 images du fabricant
	 *
	 * @param integer	$pictureNumber	Le num�ro (de 1 � 5) de l'image que l'on souhaite r�cup�rer
	 * @return void
	 */
	function deletePicture($pictureNumber)
	{
		$pictureNumber = intval($pictureNumber);
		if($pictureNumber > 0 && $pictureNumber < 6) {
			if($this->pictureExists($pictureNumber)) {
				@unlink(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$this->getVar('manu_photo'.$pictureNumber));
			}
			$this->setVar('manu_photo'.$pictureNumber, '');
		}
	}

	/**
	 * Supprime toutes les images du fabricant (raccourcis)
	 * @return void
	 */
	function deletePictures()
	{
		for($i = 1; $i <= 5; $i++) {
			$this->deletePicture($i);
		}
	}

	/**
	 * Retourne l'url � utiliser pour acc�der � la page d'un fabricant
	 *
	 * @return string
	 */
	function getLink()
	{
		$url = '';
		if(myshop_utils::getModuleOption('urlrewriting') == 1) {	// On utilise l'url rewriting
			$url = MYSHOP_URL.'manufacturer-'.$this->getVar('manu_id').myshop_utils::makeSeoUrl($this->getVar('manu_commercialname').' '.$this->getVar('manu_name')).'.html';
		} else {	// Pas d'utilisation de l'url rewriting
			$url = MYSHOP_URL.'manufacturer.php?manu_id='.$this->getVar('manu_id');
		}
		return $url;
	}

	/**
	 * Rentourne la chaine � envoyer dans une balise <a> pour l'attribut href
	 *
	 * @return string
	 */
	function getHrefTitle()
	{
		return myshop_utils::makeHrefTitle($this->getVar('manu_commercialname').' '.$this->getVar('manu_name'));
	}

	/**
	 * Retourne l'initiale du fabricant (� modifier selon le sens de l'�criture !)
	 * @return string	L'initiale
	 */
	function getInitial()
	{
		return strtoupper(substr($this->getVar('manu_name'), 0, 1));
	}

	/**
	 * Retourne les �l�ments du fabricant format�s pour affichage
	 *
	 * @param string $format	Le format � utiliser
	 * @return array	Les informations format�es
	 */
	function toArray($format = 's')
    {
		$ret = array();
		$ret = parent::toArray($format);
		for($i = 1; $i <= 5; $i++) {
			$ret['manu_photo'.$i.'_url'] = $this->getPictureUrl($i);
		}
		$ret['manu_url_rewrited'] = $this->getLink();
		$ret['manu_href_title'] = $this->getHrefTitle();
		$ret['manu_initial'] = $this->getInitial();
		return $ret;
    }

}


class MyshopMyshop_manufacturerHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//							Table					Classe				 Id            Identifiant
		parent::__construct($db, 'myshop_manufacturer', 'myshop_manufacturer', 'manu_id', 'manu_commercialname');
	}

	/**
	 * Renvoie l'alphabet � partir de la premi�re lettre du nom des fabricants
	 *
	 * @return array l'alphabet des lettres utilis�es !
	 */
	 function getAlphabet()
	 {
		global $myts;
		$ret = array();
		$sql = 'SELECT DISTINCT (UPPER(SUBSTRING(manu_name, 1, 1))) as oneletter FROM '.$this->table;
        $result = $this->db->query($sql);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
        	$ret[] = $myts->htmlSpecialChars($myrow['oneletter']);
        }
        return $ret;
	 }

	/**
	 * Supprime un fabricant et tout ce qui est relatif
	 *
	 * @param myshop_manufacturer $manufacturer
	 * @return boolean	Le r�sultat de la suppression
	 */
	 function deleteManufacturer(myshop_manufacturer $manufacturer)
	 {
	 	$manufacturer->deletePictures();
	 	return $this->delete($manufacturer, true);
	 }

	/**
	 * Retourne le nombre de produits associ�s � un fabricant
	 *
	 * @param integer $manu_id	L'identifiant du fabricant
	 * @return integer	Le nombre de produis associ�s � un fabricant
	 */
	 function getManufacturerProductsCount($manu_id)
	 {
	 	global $h_myshop_productsmanu;
	 	return $h_myshop_productsmanu->getManufacturerProductsCount($manu_id);
	 }

	/**
	 * Retourne des fabricants en fonction de leur IDs
	 *
	 * @param array $ids	Les identifiants des produits
	 * @return array	Tableau d'objets de type myshop_productsmanu
	 */
	 function getManufacturersFromIds($ids)
	 {
		$ret = array();
		if(is_array($ids) && count($ids) > 0) {
			$criteria = new Criteria('manu_id', '('.implode(',', $ids).')', 'IN');
			$ret = $this->getObjects($criteria, true, true, '*', false);
		}
		return $ret;
	 }

	/**
	 * Retourne les produits d'un fabricant (note, ce code serait mieux dans une facade)
	 *
	 * @param integer	$manu_id	Le fabricant dont on veut r�cup�rer les produits
	 * @param integer	$start		Position de d�part
	 * @param integer	$limit		Nombre maximum d'enregistrements � renvoyer
	 * @return array	Objects de type myshop_products
	 */
	 function getManufacturerProducts($manu_id, $start = 0, $limit = 0)
	 {
	 	$ret = $productsIds = array();
		global $h_myshop_productsmanu, $h_myshop_products;
		// On commence par r�cup�rer les ID des produits
		$productsIds = $h_myshop_productsmanu->getProductsIdsFromManufacturer($manu_id, $start, $limit);
		// Puis les produits eux m�me
		$ret = $h_myshop_products->getProductsFromIDs($productsIds);
		return $ret;
	 }
}
?>