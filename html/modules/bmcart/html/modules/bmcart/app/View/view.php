<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/07/27
 * Time: 19:09
 * To change this template use File | Settings | File Templates.
 */

class View
{
	static private $render;
	static private $root;

	public function View( &$root ){
		self::$root = $root;
		self::$render = self::$root->mContext->mModule->getRenderTarget();
	}

	public function setTemplate($viewTemplate)
	{
		self::$render->setTemplateName($viewTemplate);
	}

	public function set( $name, $object ){
		self::$render->setAttribute($name, $object);
	}

	public function setStylesheet( $name ){
		$headerScript = self::$root->mContext->getAttribute('headerScript');
		$headerScript->addStylesheet($name);
	}
}
