<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/07/28
 * Time: 11:06
 * To change this template use File | Settings | File Templates.
 */
class model
{
    protected static $_table_name = 'payment';
    protected static $_primaryId = 'id';
    protected static $primaryId = NULL;
    protected $mHandler = null;
    var $setTrans = array();
    protected $root;

    public function __construct()
    {
        $this->root = XCube_Root::getSingleton();
    }

    public function setTable($modelName)
    {
        $this->mHandler = xoops_getmodulehandler($modelName);
    }

    public function getLinkUnameFromId($uid, $uname = "")
    {
        $uid = intval($uid);

        if ($uid > 0) {
            if (isset($this->unamelink[$uid])) {
                return $this->unamelink[$uid];
            }
            $mhandler = xoops_gethandler('member');
            $user = $mhandler->getUser($uid);
            if (is_object($user)) {
                $this->unamelink[$uid] = '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $uid . '">' . $user->getVar('uname') . '</a>';
                return $this->unamelink[$uid];
            }
            return $this->root->mContext->mXoopsConfig['anonymous'];
        } else {
            return $uname;
        }
    }
    public function id()
    {
        return $this->mHandler->id;
    }

    public function save($uid)
    {
        $id = $this->setTrans['id'];
        if (is_null($id)){
            $ret = $this->mHandler->addNew($uid, $this->setTrans);
        }else{
            $ret = $this->mHandler->update($this->setTrans);
        }
        return $ret;
    }
    public function find($id=NULL){
        global $xoopsUser;

        if (is_null($id)) return null;
        $this->setTrans = $this->mHandler->getDataById($xoopsUser->uid(), $id);
        $this->primaryId = $this->setTrans[$this->_primaryId];
        return $this->setTrans;
    }
    public function get($key){
        return $this->setTrans[$key];
    }
    public function setValue($setTrans){
        if (is_null($setTrans)) return null;
        foreach($setTrans as $key=>$val){
            if (isset($this->setTrans[$key])) $this->setTrans[$key]=$val;
        }
    }
    public function forge($setTrans)
    {
        if(!is_null($setTrans[$this->_primaryId])){
            $this->find($setTrans[$this->_primaryId]);
        }
        $this->setTrans = $setTrans;
    }
}
