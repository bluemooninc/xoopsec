<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
/*
 * {Dirname}_{Filename} : Naming convention for Model
 */
class gmopgx_paymentObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('id', XOBJ_DTYPE_INT, 0);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('orderId', XOBJ_DTYPE_STRING, '', true, 27);
        $this->initVar('cardSeq', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('amount', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('tax', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('accessId', XOBJ_DTYPE_STRING, '', true, 32);
        $this->initVar('accessPass', XOBJ_DTYPE_STRING, '', true, 32);
        $this->initVar('utime', XOBJ_DTYPE_INT, time(), true);
        $this->initVar('status', XOBJ_DTYPE_INT, 0);
    }
}

class gmopgx_paymentHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'gmopgx_payment';
    public $mPrimary = 'id';
    public $mClass = 'gmopgx_paymentObject';
    public $id;

    public function __construct(&$db)
    {
        parent::XoopsObjectGenericHandler($db);
    }

    public function getDefaultList($uid = 0, $id = NULL)
    {
        $ret = array();
        $sql = "SELECT u.`uname`, i.* FROM `" . $this->db->prefix('users') . "` u LEFT JOIN ";
        $sql .= $this->mTable . " i ON i.`uid` =  u.`uid` ";
        $sql .= "WHERE i.`uid` = " . $uid;
        if ($id) {
            $sql .= " AND id=" . $id;
        }
        $result = $this->db->query($sql);
        while ($row = $this->db->fetchArray($result)) {
            $ret[] = $row;
        }
        return $ret;
    }
	public function getByOrderId($uid, $orderId,$status=0){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('uid', $uid));
		$criteria->add(new Criteria('orderId', $orderId));
		$criteria->add(new Criteria('status', $status));
		$this->myObjects = parent::getObjects($criteria);
		return $this->myObjects;
	}
    public function getDataById($uid = 0, $id = NULL)
    {
        $ret = array();
        $sql = "SELECT i.* FROM `" . $this->db->prefix('users') . "` u LEFT JOIN ";
        $sql .= $this->mTable . " i ON i.`uid` =  u.`uid` ";
        $sql .= "WHERE i.`uid` = " . $uid;
        if ($id) {
            $sql .= " AND id=" . $id;
        }
        $result = $this->db->query($sql);
        return $this->db->fetchArray($result);
    }

    public function addNew($uid = 0, $rec)
    {
        $sql = "INSERT INTO `" . $this->db->prefix('gmopgx_payment');
        $sql .= sprintf("` (`uid`, `orderId`, `cardSeq`, `amount`, `tax`, `accessId`, `accessPass`, `utime`, `status`) VALUES (%d, '%s', %d, %d, %d, '%s', '%s', %d, %d)"
            , $uid, mysql_real_escape_string($rec['orderId']), $rec['cardSeq'], $rec['amount'], $rec['tax'], mysql_real_escape_string($rec['accessId']), mysql_real_escape_string($rec['accessPass']), time(), 0);
        $result = $this->db->queryF($sql);
        $this->id = $this->db->getInsertId();
        return $result;
    }

    public function update($data)
    {
        $setStrings = "";

        foreach ($data as $key => $val) {
            if ($setStrings) $setStrings .= ",";
            if (is_string($val)) $val = mysql_real_escape_string($val);
            $setStrings .= sprintf('`%s`="%s"', $key, $val );
        }
        $sql = "UPDATE " . $this->db->prefix('gmopgx_payment') . sprintf(" SET %s WHERE id=%d", $setStrings, $data['id']);
        $ret = $this->db->queryF($sql);
        return $ret;
    }

    public function delete($id, $uid)
    {
        $sql = "DELETE FROM " . $this->db->prefix('gmopgx_payment');
        $sql .= sprintf(" WHERE id=%d AND uid=%d", $id, $uid);
        $result = $this->db->queryF($sql);
    }
}
