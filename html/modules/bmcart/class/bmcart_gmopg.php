<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/07/30
 * Time: 3:37
 * To change this template use File | Settings | File Templates.
 */
class Model_gmopg
{
    var $handler = array();
    private $mTable = "payment";
    private $dataObject = NULL;
    private $data = NULL;
    private $setData = NULL;

    function Model_gmopg($tblname)
    {
        $handler = xoops_getmodulehandler($tblname, 'gmopgx');
        if ($handler){
            $this->mTable = $tblname;
            $this->handler = $handler;
        }
    }

    function find($orderId)
    {
        global $xoopsUser;
        $criteria =new CriteriaCompo();
        $criteria->add(new Criteria('uid', $xoopsUser->uid()));
        $criteria->add(new Criteria('orderId', $orderId));
        $this->dataObject = $this->handler->getObjects($criteria);
        return $this->dataObject;
    }

    function success()
    {
        if (isset($data) && is_array($data)) {
            return true;
        } else {
            return false;
        }
    }

    function get($key)
    {
        if ( isset($this->dataObject) && is_array($this->dataObject) && count($this->dataObject) == 1) {
            $ret = $this->dataObject[0]->get($key);
        }
        return $ret;
    }

    function set($data)
    {
        $this->setData = $data;
    }

    function update($id)
    {
        foreach ($this->setData as $key => $val) {
            if (isset($this->data[$key]) && $this->data[$key] != $val) {
                if ($key == "id" || $key == "uid") {
                    break;
                } else {
                    $data[$key] = $val;
                }
            }
        }
        if (isset($data)) {
            $data["id"] = $id;
            $this->handler->update($data);
        }
    }
}