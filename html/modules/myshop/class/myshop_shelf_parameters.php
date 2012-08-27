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
 * Utilisé comme paramètre dans la façcade myshop_shelf
 */
class myshop_shelf_parameters
{
	private $parameters = array();

	function __construct()
	{
		$this->resetDefaultValues();
	}

	function resetDefaultValues()
	{
		$this->parameters['start'] = 0;
		$this->parameters['limit'] = 0;
		$this->parameters['category'] = 0;
		$this->parameters['sort'] = 'product_submitted DESC, product_title';
		$this->parameters['order'] = 'ASC';
		$this->parameters['excluded'] = 0;
		$this->parameters['withXoopsUser'] = false;
		$this->parameters['withRelatedProducts'] = false;
		$this->parameters['withQuantity'] = false;
		$this->parameters['thisMonthOnly'] = false;
		$this->parameters['productsType'] = '';
		return $this;
	}

	function getParameters()
	{
		return $this->parameters;
	}

	function setStart($value)
	{
		$this->parameters['start'] = intval($value);
		return $this;
	}

	function setLimit($value)
	{
		$this->parameters['limit'] = intval($value);
		return $this;
	}

	function setCategory($value)
	{
		$this->parameters['category'] = $value;
		return $this;
	}

	function setSort($value)
	{
		$this->parameters['sort'] = $value;
		return $this;
	}

	function setOrder($value)
	{
		$this->parameters['order'] = $value;
		return $this;
	}

	function setExcluded($value)
	{
		$this->parameters['excluded'] = $value;
		return $this;
	}

	function setWithXoopsUser($value)
	{
		$this->parameters['withXoopsUser'] = $value;
		return $this;
	}

	function setWithRelatedProducts($value)
	{
		$this->parameters['withRelatedProducts'] = $value;
		return $this;
	}

	function setWithQuantity($value)
	{
		$this->parameters['withQuantity'] = $value;
		return $this;
	}

	function setProductsType($value)
	{
		$this->parameters['productsType'] = $value;
		return $this;
	}

	function setThisMonthOnly($value)
	{
		$this->parameters['thisMonthOnly'] = $value;
		return $this;
	}
}
?>