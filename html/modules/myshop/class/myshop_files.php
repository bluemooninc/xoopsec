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

/**
 * Gestion des fichies attach�s aux produits
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
	include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_files extends Myshop_Object
{
	function __construct()
	{
		$this->initVar('file_id', XOBJ_DTYPE_INT ,null, false);
		$this->initVar('file_product_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('file_filename', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('file_description', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('file_mimetype', XOBJ_DTYPE_TXTBOX, null, false);
	}

	/**
	 * Supprime un fichier
	 */
	function deleteAttachedFile()
	{
		if( !defined("MYSHOP_ATTACHED_FILES_PATH") ) {
			include MYSHOP_PATH.'config.php';
		}
		@unlink(MYSHOP_ATTACHED_FILES_PATH.DIRECTORY_SEPARATOR.$this->getVar('file_filename'));
	}

	/**
	 * Indique si le fichier courant est un fichier MP3
	 * @return boolean
	 */
	function isMP3()
	{
		return strtolower($this->getVar('file_mimetype')) == 'audio/mpeg' ? true : false;
	}

	/**
	 * Indique si le fichier attach� existe physiquement sur le site
	 * @return boolean
	 */
	function fileExists()
	{
		if( !defined("MYSHOP_ATTACHED_FILES_PATH") ) {
			include MYSHOP_PATH.'config.php';
		}
		return file_exists(MYSHOP_ATTACHED_FILES_PATH.DIRECTORY_SEPARATOR.$this->getVar('file_filename'));
	}

	/**
	 * Retourne l'url pour acc�der au fichier
	 * @return string
	 */
	function getURL()
	{
		if( !defined("MYSHOP_ATTACHED_FILES_URL") ) {
			include MYSHOP_PATH.'config.php';
		}
		return MYSHOP_ATTACHED_FILES_URL.'/'.$this->getVar('file_filename');
	}

	/**
	 * Retourne le chemin physique pour acc�der au fichier
	 * @return string
	 */
	function getPath()
	{
		if( !defined("MYSHOP_ATTACHED_FILES_URL") ) {
			include MYSHOP_PATH.'config.php';
		}
		return MYSHOP_ATTACHED_FILES_PATH.DIRECTORY_SEPARATOR.$this->getVar('file_filename');
	}

    function toArray($format = 's')
    {
		$ret = parent::toArray($format);
		$ret['file_is_mp3'] = $this->isMP3();
		$ret['file_download_url'] = $this->getURL();
		return $ret;
    }
}


class MyshopMyshop_filesHandler extends Myshop_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//							Table			Classe		 	Id			Libell�
		parent::__construct($db, 'myshop_files', 'myshop_files', 'file_id', 'file_filename');
	}

	/**
	 * Supprime un fichier (son fichier joint ET l'enregistrement dans la base de donn�es)
	 *
	 * @param myshop_files $file
	 * @return boolean	Le r�sultat de la suppression
	 */
	function deleteAttachedFile(myshop_files $file)
	{
		if($file->fileExists()) {
			$file->deleteAttachedFile();
		}
		return $this->delete($file, true);
	}

	/**
	 * Retourne les fichiers attach�s � un produit
	 *
	 * @param integer $file_product_id	L'Id du produit
	 * @param integer $start	Position de d�part
	 * @param integer $limit	Nombre maxi de produits � retourner
	 * @return array	tableau d'objets de type myshop_files
	 */
	function getProductFiles($file_product_id, $start=0, $limit=0)
	{
		$criteria = new Criteria('file_product_id', $file_product_id, '=');
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		return $this->getObjects($criteria);
	}

	/**
	 * Retourne le nombre de fichiers attach�s � un produit qui sont des MP3
	 *
	 * @param integer $file_product_id	L'Id du produit
	 * @return integer	le nombre de fichiers MP3
	 */
	function getProductMP3Count($file_product_id)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('file_product_id', $file_product_id, '='));
		$criteria->add(new Criteria('file_mimetype', 'audio/mpeg', '='));
		return $this->getCount($criteria);
	}

	/**
	 * Retourne le nombre de fichiers attach�s � un produit
	 *
	 * @param integer $file_product_id	L'Id du produit
	 * @return integer	le nombre de fichiers
	 */
	function getProductFilesCount($file_product_id)
	{
		$criteria = new Criteria('file_product_id', $file_product_id, '=');
		return $this->getCount($criteria);
	}

	/**
	 * Retourne le code HTML � utiliser pour affiche le lecteur de fichiers MP3
	 * @param array	$attachedFiles	La liste des fichiers MP3
	 */
	function getHtmlCodeForDewplayer($attachedFiles)
	{
		if(count($attachedFiles) > 1) {
			$dewPlayer = 'dewplayer-multi.swf';
		} else {
			$dewPlayer = 'dewplayer.swf';
		}
		$mp3List = implode('|', $attachedFiles);
		$ret = '';
		$ret .= "<div align='center' id='DewPlayerContainer'></div>\n";
		$ret .= "<script type=\"text/javascript\">\n";
		$ret .= "var flashvars = {\n";
		$ret .= "mp3: \"".$mp3List."\"\n";
		$ret .= "};\n";
		$ret .= "var params = {\n";
		$ret .= "wmode: \"transparent\"\n";
		$ret .= "};\n";
		$ret .= "swfobject.embedSWF(\"".MYSHOP_URL."dewplayer/".$dewPlayer."\", \"DewPlayerContainer\", \"".MYSHOP_DEWPLAYER_WIDTH."\", \"".MYSHOP_DEWPLAYER_HEIGHT."\", \"9\", true, flashvars, params);\n";
		$ret .= "</script>\n";
		return $ret;
	}

	/**
	 * Supprime les fichiers attach�s � un produit
	 *
	 * @param integer $file_product_id	L'Id du produit
	 * @return void
	 */
	function deleteProductFiles($file_product_id)
	{
		$files = array();
		$criteria = new Criteria('file_product_id', $file_product_id, '=');
		$files = $this->getObjects($criteria);
		if(count($files) > 0) {
			foreach($files as $file) {
				$file->deleteAttachedFile();
				$this->delete($file, true);
			}
		}
	}
}
?>