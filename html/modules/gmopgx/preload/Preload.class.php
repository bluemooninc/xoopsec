<?php
if (!defined('XOOPS_ROOT_PATH')) die();

class Gmopgx_Preload extends XCube_ActionFilter
{
    public function postFilter()
    {
        require_once XOOPS_MODULE_PATH . '/gmopgx/service/Service.class.php';
        $service = new Gmopgx_Service();
        $service->prepare();
        $this->mRoot->mServiceManager->addService('gmoPayment', $service);
    }
}
