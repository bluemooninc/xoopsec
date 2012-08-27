<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}


class myshop_Currency
{
	protected $_decimalsCount;
	protected $_thousandsSep;
	protected $_decimalSep;
	protected $_moneyFull;
	protected $_moneyShort;
	protected $_monnaiePlace;

	function __construct()
	{
		// Get the module's preferences
		$this->_decimalsCount = myshop_utils::getModuleOption('decimals_count');
		$this->_thousandsSep = myshop_utils::getModuleOption('thousands_sep');
		$this->_decimalSep = myshop_utils::getModuleOption('decimal_sep');
		$this->_moneyFull = myshop_utils::getModuleOption('money_full');
		$this->_moneyShort = myshop_utils::getModuleOption('money_short');
		$this->_monnaiePlace = myshop_utils::getModuleOption('monnaie_place');

		$this->_thousandsSep = str_replace('[space]', ' ', $this->_thousandsSep);
		$this->_decimalSep = str_replace('[space]', ' ', $this->_decimalSep);
	}


	/**
	 * Access the only instance of this class
     *
     * @return	object
     *
     * @static
     * @staticvar   object
	 */
	function &getInstance()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new myshop_Currency();
		}
		return $instance;
	}

	/**
	 * Returns an amount according to the currency's preferences (defined in the module's options)
	 *
	 * @param float $amount The amount to work on
	 * @return string The amount formated according to the currency
	 */
	function amountInCurrency($amount = 0)
	{
		return number_format($amount, $this->_decimalsCount, $this->_decimalSep, $this->_thousandsSep);
	}


	/**
	 * Format an amount for display according to module's preferences
	 *
	 * @param float $amount The amount to format
	 * @param string $format Format to use, 's' for Short and 'l' for Long
	 * @return string The amount formated
	 */
    function amountForDisplay($amount, $format = 's')
    {
        $amount = $this->amountInCurrency($amount);
		$monnaieLeft = $monnaieRight = $monnaieSleft = $monnaieSright = '';
		if($this->_monnaiePlace == 1) {	// To the right
			$monnaieRight = ' '.$this->_moneyFull;		// Long version
			$monnaieSright = ' '.$this->_moneyShort;	// Short version
		} else {	// To the left
			$monnaieLeft = $this->_moneyFull.' ';	// Long version
			$monnaieSleft = $this->_moneyShort.' ';	// Short version
		}
		if($format != 's') {
			return $monnaieLeft.$amount.$monnaieRight;
		} else {
			return $monnaieSleft.$amount.$monnaieSright;
		}
    }


}
?>