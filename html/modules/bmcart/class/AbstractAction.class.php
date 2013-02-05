<?php
/**
 * @file
 * @package profile
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Gmopg_AbstractAction
{
	var $mRoot = null;
	var $mModule = null;
	var $mAsset = null;

	/**
	 * @public
	 */
	function &_getHandler(){
	}
	function Gmopg_AbstractAction(){
		$this->mRoot =& XCube_Root::getSingleton();
		$this->mModule =& $this->mRoot->mContext->mModule;
		$this->mAsset =& $this->mModule->mAssetManager;
	}
	function isMemberOnly(){
		return false;
	}
	function isAdminOnly(){
		return false;
	}
	function prepare(){
		return true;
	}

	function hasPermission(){
		return true;
	}

	function getDefaultView(){
		return BMCART_FRAME_VIEW_NONE;
	}

	function execute(){
		return BMCART_FRAME_VIEW_NONE;
	}

	function executeViewSuccess(&$controller,&$render){
	}

	function executeViewError(&$render){
	}

	function executeViewIndex(&$render){
	}

	function executeViewInput(&$render){
	}

	function executeViewPreview(&$render){
	}

	function executeViewCancel(&$render){
	}

}

?>
