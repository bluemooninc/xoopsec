<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
/*
 * {Dirname}_{Filename} : Naming convention for Model
 */
class bmcart_cartObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('cart_id', XOBJ_DTYPE_INT, 0);
	    $this->initVar('item_id', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('sku_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('qty', XOBJ_DTYPE_INT, 0, true);
	    $this->initVar('last_update', XOBJ_DTYPE_INT, 0);
    }
}

class bmcart_cartHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'bmcart_cart';
    public $mPrimary = 'cart_id';
    public $mClass = 'bmcart_cartObject';
    public $id;
	private $myHandler;

    public function __construct(&$db)
    {
        parent::XoopsObjectGenericHandler($db);
    }
	public function &getItems(){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('uid', Legacy_Utils::getUid()));
		$this->myHandler = xoops_getModuleHandler('cart');
		$objects = $this->myHandler->getObjects($criteria);
		return $objects;
	}

	public function &getByItemId($item_id)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_id', $item_id));
		$criteria->add(new Criteria('uid', Legacy_Utils::getUid()));
		$this->myHandler = xoops_getModuleHandler('cart');
		$objects = $this->myHandler->getObjects($criteria);
		if (!is_array($objects)){
			return null;
		}
		return $objects[0];
	}
	public function addToCart($item_id,$sku_id=null)
	{
		$cartObject = $this->getByItemId($item_id);
		if(is_null($cartObject)){
			$cartObject = $this->myHandler->create();
			$cartObject->set('item_id',$item_id);
			$cartObject->set('sku_id',$sku_id);
			$cartObject->set('uid',Legacy_Utils::getUid());
			$cartObject->set('qty',1);
		}else{
			$cartObject->set('qty',$cartObject->getVar('qty')+1);
		}
		$cartObject->set('last_update',time());
		$root = XCube_Root::getSingleton();
		if($root->mContext->mXoopsUser){
			$this->myHandler->insert($cartObject,true);
		}else{
			$_SESSION[cartObjects][]=serialize($cartObject);
		}
	}
}
