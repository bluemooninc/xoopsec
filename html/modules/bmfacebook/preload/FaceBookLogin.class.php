<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/02/18
 * Time: 18:06
 * To change this template use File | Settings | File Templates.
 */
class Bmfacebook_FaceBookLogin extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('Legacy_RenderSystem.BeginRender', array(&$this, 'beginRender'));
	}
	public function beginRender(&$xoopsTpl)
	{
		$href = '<a href="' . XOOPS_URL .'/modules/bmfacebook/"><img src="' . XOOPS_URL .'/modules/bmfacebook/images/facebook.png" /></a>';
		//echo $href;die;
		$xoopsTpl->assign('facbookLogin', $href);
	}
}
