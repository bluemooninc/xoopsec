<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 11:14
 * To change this template use File | Settings | File Templates.
 */

class View_General
{
	/**
	 * get Instance
	 * @param none
	 * @return object Instance
	 */
	public function &forge()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new View_General();
		}
		return $instance;
	}
	public function &setGeneral(&$htmlRender, $formObject)
	{
		return array(
			"formObject"=>$formObject
		);
	}
}