<?php
/**
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 3
 * @author Marijuana
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
class BmSurveyFormObject extends XoopsSimpleObject
{
	public function __construct()
	{
		$this->initVar('id', XOBJ_DTYPE_INT, 0);
		$this->initVar('name', XOBJ_DTYPE_STRING, '', true, 64);
		$this->initVar('owner', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('realm', XOBJ_DTYPE_STRING, '', true, 64);
		$this->initVar('respondents', XOBJ_DTYPE_STRING, '', true, 64);
		$this->initVar('public', XOBJ_DTYPE_STRING,'Y',false);
		$this->initVar('status', XOBJ_DTYPE_INT, 0);
		$this->initVar('title', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('email', XOBJ_DTYPE_STRING, '', true, 64);
		$this->initVar('from_option', XOBJ_DTYPE_INT, 0);
		$this->initVar('subtitle', XOBJ_DTYPE_TEXT, '', true);
		$this->initVar('info', XOBJ_DTYPE_TEXT, '', true);
		$this->initVar('theme', XOBJ_DTYPE_STRING, '', true, 64);
		$this->initVar('thanks_page', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('thank_head', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('thank_body', XOBJ_DTYPE_TEXT, '', true);
		$this->initVar('changed', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('published', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('expired', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('response_id', XOBJ_DTYPE_INT, 0);
	}
	public function setVar($key, $value)
	{
		$this->set($key, $value);
	}
	public function set($key, $value)
	{
		switch ($key) {
			case 'subject':
				$key = 'title';
				break;
			case 'from_userid':
				$key = 'from_uid';
				break;
			case 'msg_text':
				$key = 'message';
				break;
			case 'to_userid':
				$key = 'uid';
				break;
			case 'read_msg':
				$key = 'is_read';
				break;
			case 'msg_time':
				$key = 'utime';
				break;
		}
		$this->assignVar($key, $value);
	}
}

class BmSurveyFormHandler extends XoopsObjectGenericHandler
{
	public $mTable = 'bmsurvey_form';
	public $mPrimary = 'id';
	public $mClass = 'BmSurveyFormObject';

	public function __construct(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
	}

	public function setterInjection(&$object){
		foreach($object->mVars as $key=>$val){
			if (isset($this->myObject->mVars[$key])){
				$this->myObject->set($key,$val['value']);
			}
		}
		die;
	}

	public function getByName($name)
	{
		$ret = array();
		$sql = "SELECT * FROM " . $this->db->prefix('bmsurvey_form');
		$sql .= ' WHERE name = "'.$name.'";';
		$result = $this->db->query($sql);
		while ($row = $this->db->fetchArray($result)) {
			$ret[] = $row;
		}
		return $ret;
	}

	public function getInboxCount($uid)
	{
		$criteria = new CriteriaCompo(new Criteria('uid', $uid));
		return $this->getCount($criteria);
	}

	public function getSendUserList($uid = 0, $fuid = 0)
	{
		$ret = array();
		$sql = "SELECT u.`uname`,u.`uid` FROM `" . $this->db->prefix('users') . "` u, ";
		$sql .= '`' . $this->mTable . "` i ";
		$sql .= "WHERE i.`from_uid` = u.`uid` ";
		$sql .= "AND i.`uid` = " . $uid . " ";
		$sql .= "GROUP BY u.`uname`, u.`uid`";

		$result = $this->db->query($sql);
		while ($row = $this->db->fetchArray($result)) {
			if ($fuid == $row['uid']) {
				$row['select'] = true;
			} else {
				$row['select'] = false;
			}
			$ret[] = $row;
		}
		return $ret;
	}

	public function deleteDays($day, $type)
	{
		if ($day < 1) {
			return;
		}
		$time = time() - ($day * 86400);
		$sql = "DELETE FROM `" . $this->mTable . "` ";
		$sql .= "WHERE `utime` < " . $time . " ";
		if ($type == 0) {
			$sql .= "AND `is_read` = 1 ";
		} else {
			$sql .= "AND `is_read` < 2 ";
		}
		$this->db->queryF($sql);
	}

	public function deleteAllByOutboxId($outbox_id)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('outbox_id', $outbox_id));
		return $this->deleteAll($criteria);
	}

	public function getUtimeByAsc($outbox_id)
	{

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('outbox_id', $outbox_id));
		$criteria->setSort('utime', XOOPS_CRITERIA_ASC);
		$objects = $this->getObjects($criteria, 1);

		return $objects[0];
	}

	public function _makeCriteria4sql($criteria)
	{
		$this->_chane_old($criteria);
		return parent::_makeCriteria4sql($criteria);
	}

	private function _chane_old(&$criteria)
	{
		if (is_a($criteria, 'CriteriaElement')) {
			if ($criteria->hasChildElements()) {
				for ($i = 0; $i < $criteria->getCountChildElements(); $i++) {
					$this->_chane_old($criteria->criteriaElements[$i]);
				}
			} elseif (get_class($criteria) == 'Criteria') {
				switch ($criteria->column) {
					case 'read_msg':
						$criteria->column = 'is_read';
						break;
					case 'to_userid':
						$criteria->column = 'uid';
						break;
					case 'subject':
						$criteria->column = 'title';
						break;
					case 'from_userid':
						$criteria->column = 'from_uid';
						break;
					case 'msg_text':
						$criteria->column = 'message';
						break;
					case 'msg_time':
						$criteria->column = 'utime';
						break;
				}
			}
		}
	}
}

?>
