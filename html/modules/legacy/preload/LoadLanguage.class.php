<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/09/17
 * Time: 22:35
 * To change this template use File | Settings | File Templates.
 */
class Legacy_LoadLanguage extends XCube_ActionFilter
{
	/**
	 * @var XCube_Delegate
	 */
	private $xoopsConfig;
	function Legacy_LoadLanguage(&$controller)
	{
		$this->xoopsConfig = $controller->mRoot->mContext->mXoopsConfig;
	}
	function preBlockFilter()
	{
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy_RenderSystem.SetupXoopsTpl' , array( $this , 'hook' ) ) ;
	}
	function hook( &$xoopsTpl )
	{
		$mylang_unique_path = XOOPS_ROOT_PATH.'/modules/legacy/language/'.$this->xoopsConfig['language'].'/blocks.php' ;
		include_once($mylang_unique_path);
	}
}