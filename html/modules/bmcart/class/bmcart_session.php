<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/02/02
 * Time: 9:41
 * To change this template use File | Settings | File Templates.
 */
class bmcart_session{

	public function clearSession($name){
		unset($_SESSION[$name]);
	}
	public function getObjects($name){
		if(isset($_SESSION[$name])){
			$objects = $_SESSION[$name];
			$myObjects = array();
			foreach($objects as $object){
				if($objects){
					$myObjects[] = unserialize($object);
				}
			}
			return $myObjects;
		}
	}
	public function setObjects($name,$objects,$newObject=null){
		$serialized = $newObject ? array(serialize($newObject)) : array();
		foreach($objects as $object){
			$serialized[] = serialize($object);
		}
		$_SESSION[$name] = $serialized;
	}

	/**
	 * @param $name
	 * @param $key
	 * @param $newObject
	 */
	public function insert($name,$key,$newObject){
		$myObjects = $this->getObjects($name);
		$i = 0;
		if($myObjects){
			foreach($myObjects as $object){
				if ($object->getVar($key) == $newObject->getVar($key)){
					unset($myObjects[$i]);
					break;
				}
				$i++;
			}
		}
		$this->setObjects($name,$myObjects,$newObject);
	}

	/**
	 * @param $checkedItems
	 * @param $uid
	 */
	public function setCheckedItems($checkedItems,$uid){
		$checkedHandler =& xoops_getModuleHandler('checked_items','bmcart');
		foreach($checkedItems as $object){
			$checkedObject = $checkedHandler->get(array($uid,$object->getVar('item_id')));
			if(!$checkedObject){
				$checkedObject = $checkedHandler->create();
			}
			$checkedObject->set('uid',$uid);
			$checkedObject->set('item_id',$object->getVar('item_id'));
			$checkedObject->set('category_id',$object->getVar('category_id'));
			$checkedObject->set('last_update',time());
			$checkedHandler->insert($checkedObject,true);
		}
	}
}