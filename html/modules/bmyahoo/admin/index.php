<?php
require_once "../../../mainfile.php";
require_once XOOPS_ROOT_PATH . "/header.php";

$root = XCube_Root::getSingleton();

$actionName = xoops_getrequest('action') ? xoops_getrequest('action') : "";
/*
 * TODO : do something on the future
 *
$moduleRunner = new bmyahoo_ActionFrame(true);
$moduleRunner->setActionName($actionName);

$root->mController->mExecute->add(array(&$moduleRunner, 'execute'));

$root->mController->execute();
*/
require_once XOOPS_ROOT_PATH . "/footer.php";
