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

/**
 * Chargement des handlers utilisés par le module
 */
class myshop_handler
{
	public $h_myshop_manufacturer = null;
	public $h_myshop_products = null;
	public $h_myshop_productsmanu = null;
	public $h_myshop_caddy = null;
	public $h_myshop_cat = null;
	public $h_myshop_commands = null;
	public $h_myshop_related = null;
	public $h_myshop_vat = null;
	public $h_myshop_votedata = null;
	public $h_myshop_discounts = null;
	public $h_myshop_stores = null;
	public $h_myshop_files = null;
	public $h_myshop_persistent_cart = null;
	private static $instance = false;

	private function __construct()
	{
		$handlersNames = array('myshop_manufacturer','myshop_products','myshop_productsmanu','myshop_caddy','myshop_cat','myshop_commands','myshop_related','myshop_vat','myshop_votedata','myshop_discounts','myshop_stores','myshop_files','myshop_persistent_cart');
		foreach($handlersNames as $handlerName) {
			$internalName = 'h_'.$handlerName;
			$this->$internalName = xoops_getmodulehandler($handlerName, MYSHOP_DIRNAME);
		}
	}

	public static function getInstance()
	{
		if (!self::$instance instanceof self) {
      		self::$instance = new self;
		}
		return self::$instance;
	}
}
?>