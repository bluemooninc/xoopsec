<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

/**
 * Export CSV
 */
class myshop_csv_export extends myshop_export
{
    function __construct($parameters = '')
    {
        if(!is_array($parameters)) {
            $this->separator = MYSHOP_CSV_SEP;
            $this->filename = 'myshop.csv';
            $this->folder = MYSHOP_CSV_PATH;
            $this->url = MYSHOP_CSV_URL;
            $this->orderType = MYSHOP_STATE_VALIDATED;
        }
        parent::__construct($parameters);
    }

	/**
	 * Export data
	 * @return boolean
	 */
    function export()
    {
		$fp = fopen($this->folder.DIRECTORY_SEPARATOR.$this->filename, 'w');
		if(!$fp) {
		    $this->success = false;
		    return false;
		}

		// Creation of file header
		$entete1 = $entete2 = array();
		$s = $this->separator;
		$cmd = new myshop_commands();
		foreach($cmd->getVars() as $fieldName => $properties) {
			$entete1[] = $fieldName;
		}
		// Addcart info
		$cart = new myshop_caddy();
		foreach($cart->getVars() as $fieldName => $properties) {
			$entete2[] = $fieldName;
		}
		fwrite($fp, implode($s, array_merge($entete1, $entete2))."\n");

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('cmd_id', 0, '<>'));
		$criteria->add(new Criteria('cmd_state', $this->orderType, '='));
		$criteria->setSort('cmd_date');
		$criteria->setOrder('DESC');
		$orders = $this->handlers->h_myshop_commands->getObjects($criteria);
		foreach($orders as $order) {
			$carts = array();
			$carts = $this->handlers->h_myshop_caddy->getObjects(new Criteria('caddy_cmd_id', $order->getVar('cmd_id'), '='));
			$ligne = array();
			foreach($carts as $cart) {
				foreach($entete1 as $commandField) {
					$ligne[] = $order->getVar($commandField);
				}
				foreach($entete2 as $cartField) {
					$ligne[] = $cart->getVar($cartField);
				}
			}
			fwrite($fp, implode($s, $ligne)."\n");
		}
		fclose($fp);
		$this->success = true;
		return true;
    }

	/**
	 * Return link to download
	 * @return string
	 */
    function getDownloadUrl()
    {
        if($this->success) {
            return $this->url.'/'.$this->filename;
        } else {
            return false;
        }
    }

    function getDownloadPath()
    {
        if($this->success) {
            return $this->folder.DIRECTORY_SEPARATOR.$this->filename;
        } else {
            return false;
        }
    }
}
?>