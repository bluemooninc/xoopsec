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


class myshop_dbase_export extends myshop_export
{
    function __construct($parameters = '')
    {
        if(!is_array($parameters)) {
            $this->filename = 'myshop.dbf';
            $this->folder = MYSHOP_CSV_PATH;
            $this->url = MYSHOP_CSV_URL;
            $this->orderType = MYSHOP_STATE_VALIDATED;
        }
        parent::__construct($parameters);
    }

	/**
	 * Export  data
	 * @return boolean
	 */
    function export()
    {
		$def = array(
			array('o_id', 'N', 10, 0),
			array('o_uid', 'N', 10, 0),
			array('o_date', 'D'),
			array('o_state', 'N', 1, 0),
			array('o_ip', 'C', 32),
			array('o_lastname', 'C', 155),
			array('o_firstnam', 'C', 155),
			array('o_adress', 'C', 155),
			array('o_zip', 'C', 30),
			array('o_town', 'C', 155),
			array('o_country', 'C', 3),
			array('o_telephon', 'C', 30),
			array('o_email', 'C', 155),
			array('o_articles', 'N', 10, 0),
			array('o_total', 'N', 10, 2),
			array('o_shipping', 'N', 10, 2),
			array('o_bill', 'L'),
			array('o_password', 'C', 155),
			array('o_text', 'C', 155),
			array('o_cancel', 'C', 155),
			array('c_id', 'N', 10, 0),
			array('c_prod_id', 'N', 10, 0),
			array('c_qte', 'N', 10, 0),
			array('c_price', 'N', 10, 2),
			array('c_o_id', 'N', 10, 0),
			array('c_shipping', 'N', 10, 2),
			array('c_pass', 'C', 155)
		);
		/*
		 * Correspondances
		 * cmd_id				   o_id
		 * cmd_uid                 o_uid
		 * cmd_date                o_date
		 * cmd_state               o_state
		 * cmd_ip                  o_ip
		 * cmd_lastname            o_lastname
		 * cmd_firstname           o_firstnam
		 * cmd_adress              o_adress
		 * cmd_zip                 o_zip
		 * cmd_town                o_town
		 * cmd_country             o_country
		 * cmd_telephone           o_telephon
		 * cmd_email               o_email
		 * cmd_articles_count      o_articles
		 * cmd_total               o_total
		 * cmd_shipping            o_shipping
		 * cmd_bill                o_bill
		 * cmd_password            o_password
		 * cmd_text                o_text
		 * cmd_cancel              o_cancel
		 * caddy_id                c_id
		 * caddy_product_id        c_prod_id
		 * caddy_qte               c_qte
		 * caddy_price             c_price
		 * caddy_cmd_id            c_o_id
		 * caddy_shipping          c_shipping
		 * caddy_pass              c_pass
		 */
		if (!dbase_create($this->folder.DIRECTORY_SEPARATOR.$this->filename, $def)) {
		    $this->success = false;
		    return false;
		}
		$dbf = dbase_open($this->folder.DIRECTORY_SEPARATOR.$this->filename, 2);
		if($dbf === false) {
		    $this->success = false;
		    return false;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('cmd_id', 0, '<>'));
		$criteria->add(new Criteria('cmd_state', $this->orderType, '='));
		$criteria->setSort('cmd_date');
		$criteria->setOrder('DESC');
		$orders = $this->handlers->h_myshop_commands->getObjects($criteria);
		foreach($orders as $order) {
			$carts = array();
			$carts = $this->handlers->h_myshop_caddy->getObjects(new Criteria('caddy_cmd_id', $order->getVar('cmd_id'), '='));
			foreach($carts as $cart) {
				dbase_add_record($dbf, array(
					$order->getVar('cmd_id'),
					$order->getVar('cmd_uid'),
					date('Ymd', strtotime($order->getVar('cmd_date'))),
					$order->getVar('cmd_state'),
					$order->getVar('cmd_ip'),
					$order->getVar('cmd_lastname'),
					$order->getVar('cmd_firstname'),
					$order->getVar('cmd_adress'),
					$order->getVar('cmd_zip'),
					$order->getVar('cmd_town'),
					$order->getVar('cmd_country'),
					$order->getVar('cmd_telephone'),
					$order->getVar('cmd_email'),
					$order->getVar('cmd_articles_count'),
					$order->getVar('cmd_total'),
					$order->getVar('cmd_shipping'),
					$order->getVar('cmd_bill'),
					$order->getVar('cmd_password'),
					$order->getVar('cmd_text'),
					$order->getVar('cmd_cancel'),
					$cart->getVar('caddy_id'),
					$cart->getVar('caddy_product_id'),
					$cart->getVar('caddy_qte'),
					$cart->getVar('caddy_price'),
					$cart->getVar('caddy_cmd_id'),
					$cart->getVar('caddy_shipping'),
					$cart->getVar('caddy_pass')
					));
			}
		}
		dbase_close($dbf);
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
