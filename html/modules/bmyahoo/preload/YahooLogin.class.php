<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/02/18
 * Time: 18:06
 * To change this template use File | Settings | File Templates.
 */
class bmyahoo_YahooLogin extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('Legacy_RenderSystem.BeginRender', array(&$this, 'beginRender'));
	}
	public function beginRender(&$xoopsTpl)
	{
		$href = '<a href="' . XOOPS_URL .'/modules/bmyahoo/"><img src="' . XOOPS_URL .'/modules/bmyahoo/images/yahoo.png" /></a>';
		//echo $href;die;
		$xoopsTpl->assign('yahooLogin', $href);
	}
}
