<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class MyshopCommandsObject extends XoopsSimpleObject
{
    function MyshopCommandsObject()
    {
        $this->initVar('cmd_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_uid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_date', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_state', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_ip', XOBJ_DTYPE_STRING, '', false, 32);
        $this->initVar('cmd_lastname', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('cmd_firstname', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('cmd_adress', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('cmd_zip', XOBJ_DTYPE_STRING, '', false, 30);
        $this->initVar('cmd_town', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('cmd_country', XOBJ_DTYPE_STRING, '', false, 3);
        $this->initVar('cmd_telephone', XOBJ_DTYPE_STRING, '', false, 30);
        $this->initVar('cmd_email', XOBJ_DTYPE_STRING, '', false, 255);
        $this->initVar('cmd_articles_count', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_total', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_shipping', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_bill', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('cmd_password', XOBJ_DTYPE_STRING, '', false, 32);
        $this->initVar('cmd_text', XOBJ_DTYPE_TEXT, '', false);
        $this->initVar('cmd_cancel', XOBJ_DTYPE_STRING, '', false, 32);
    }
}

class MyshopCommandsHandler extends XoopsObjectGenericHandler
{
    var $mTable = "commands";
    var $mPrimary = "cmd_id";
    var $mClass = "MyshopCommandsObject";
    /**
     * @var XCube_Delegate
     */
    var $mUpdateSuccess;

    /**
     * @var XCube_Delegate
     */
    var $mDeleteSuccess;

    function insert(&$command, $force = false)
    {
        if (parent::insert($command, $force)) {
            $this->mUpdateSuccess->call($command);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Delete $command and childlen of $command.
     */
    function delete(&$command, $force = false)
    {
        $criteria =new Criteria('com_id', $command->get('com_id'));
        $this->deleteAll($criteria);

        if (parent::delete($command, $force)) {
            $this->mDeleteSuccess->call($command);
            return true;
        }
        else{
            return false;
        }
    }
}

?>
