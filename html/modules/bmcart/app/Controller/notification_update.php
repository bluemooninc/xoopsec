<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/02/19
 * Time: 22:44
 * To change this template use File | Settings | File Templates.
 */
class Controller_Notification_update extends AbstractAction {
	public function action_index(){
		$this->template = 'notification_update.html';
		// using core comment code
		$com_itemid = $this->root->mContext->mRequest->getRequest('com_itemid');
		$xoopsUser = $this->root->mContext->mXoopsUser;
		$xoopsModule = $this->root->mContext->mXoopsModule;
		$xoopsModuleConfig = $this->root->mContext->mModuleConfig;
		global $xoopsTpl;
		require_once XOOPS_ROOT_PATH.'/include/notification_update.php';
	}
}