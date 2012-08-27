<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class Gmopgx_Service extends XCube_Service
{
    public $mServiceName = 'Gmopgx_Service';
    public $mNameSpace = 'Gmopgx';
    public $mClassName = 'Gmopgx_Service';

    public function prepare()
    {
        $this->addFunction(S_PUBLIC_FUNC('int checkOrderStatus(int orderId)'));
    }

    public function checkOrderStatus()
    {
        $ret = false;
        $root = XCube_Root::getSingleton();
        $orderId = $root->mContext->mRequest->getRequest('orderId');
        if ($root->mContext->mUser->isInRole('Site.RegisteredUser')) {
            $uid = $root->mContext->mXoopsUser->get('uid');
            $modHand = xoops_getmodulehandler('payment', 'gmopgx');
            $myrow = $modHand->getDataById($uid, $orderId);
            if ($myrow) {
                if ($myrow['status'] == 1) $ret = true;
            }
        }
        return $ret;
    }
}