<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

class User_BringSessionLogin extends XCube_ActionFilter
{
	function preFilter()
	{
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add("Site.CheckLogin", array( &$this , 'checkLogin'),XCUBE_DELEGATE_PRIORITY_NORMAL-1 ) ;
	}

	function checkLogin(&$xoopsUser)
	{
		if (is_object($xoopsUser)) {
			return;
		}
		$root =& XCube_Root::getSingleton();
		$root->mLanguageManager->loadModuleMessageCatalog('user');

		$userHandler =& xoops_getmodulehandler('users', 'user');

		$criteria =& new CriteriaCompo(new Criteria('uname', xoops_getrequest('uname')));
		$criteria->add(new Criteria('pass', md5(xoops_getrequest('pass'))));
		$userArr =& $userHandler->getObjects($criteria);

		if (count($userArr) != 1) {
			return;
		}
		
		if ($userArr[0]->get('level') == 0) {
			// TODO We should use message "_MD_USER_LANG_NOACTTPADM"
			return;
		}
		
		$handler =& xoops_gethandler('user');
		$user =& $handler->get($userArr[0]->get('uid'));
		
		$xoopsUser = $user;
	
		//
		// Regist to session
		//
		if($_SESSION['cartObjects']) $cartObjects = $_SESSION['cartObjects'];
		if($_SESSION['checkedItems']) $checkedItems = $_SESSION['checkedItems'];
		$root->mSession->regenerate();
		$_SESSION = array();
		$_SESSION['xoopsUserId'] = $xoopsUser->get('uid');
		$_SESSION['xoopsUserGroups'] = $xoopsUser->getGroups();
		if (isset($cartObjects)) $_SESSION['cartObjects'] = $cartObjects;
		if (isset($checkedItems)) $_SESSION['checkedItems'] = $checkedItems;
	}
}
