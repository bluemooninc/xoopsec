<?php
/*********************************************************************************************
 * Achtungbaby Flamework
 ********************************** License: GPLv3 *******************************************
 * Copyright (C) 2012 Yoshi Sakai (A.K.A. bluemooninc)
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  any later version.
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *********************************************************************************************/
require_once '../../../../mainfile.php'; // Load XOOPS Config
function errorMessage($errorMessage)
{
	echo("<h1>" . $errorMessage[0] . "</h1>");
	echo("<h2>Error: " . $errorMessage[1] . "</h2>");
	echo("<h2>Error: " . $errorMessage[2] . "</h2>");
	echo $errorMessage[3] . "<br />";
	echo "<b>" . $errorMessage[4] . "</b><br />";
	echo $errorMessage[5] . "<hr />";
}

/*********************************************************************************************
 * Config Section
 *********************************************************************************************/
//$mydirname = basename(dirname(preg_replace("/\/app\/webroot/", "", __FILE__)));
$mydirname = basename(dirname(preg_replace("/\/app\/webroot/", "", preg_replace("/\\\\/", "/", __FILE__))));
define ('_MY_MODULE_PATH', XOOPS_MODULE_PATH . '/' . $mydirname . '/');
define ('_MY_MODULE_URL', XOOPS_MODULE_URL . '/' . $mydirname . '/');

$controllerAppPath = "app/Controller/";
$modelAppPath = "app/Model/";
$ext = ".php";
foreach ($_GET as $key => $val) {
	$_key = htmlspecialchars($key, ENT_QUOTES, _CHARSET);
	$_val = htmlspecialchars($val, ENT_QUOTES, _CHARSET);
	if (substr($_key, 0, 1) == "/") {
		$params[] = explode("/", $_key);
	}
}
/*********************************************************************************************
 * Controller Section
 *********************************************************************************************/
/*
 * Loading
 */
$parameters = null;
$controller_name = isset($params[0][1]) ? $params[0][1] : $mydirname;
$controller_name = preg_replace("/_php$/i","",$controller_name);
$method = isset($params[0][2]) ? $params[0][2] : "index";
if (isset($params) && count($params[0]) > 3) {
	for ($i = 3; $i < count($params[0]); $i++) {
		$parameters[] = isset($params[0][$i]) ? addslashes(htmlspecialchars($params[0][$i], ENT_QUOTES)) : "";
	}
}
$method_name = "action_" . $method;
if (preg_match('/^[0-9a-zA-Z\._-]+$/', $controller_name)) {
	$controllerClass = "Controller_" . ucFirst($controller_name);
} else {
	die("controller_name must be alpha numerics characters!");
}
$controllerFileName = $controller_name . $ext;
$controllerFullPath = _MY_MODULE_PATH . $controllerAppPath . $controllerFileName;
require_once _MY_MODULE_PATH . $controllerAppPath . 'AbstractAction.class.php';
require_once _MY_MODULE_PATH . $modelAppPath . 'AbstractModel.class.php';
//require_once _MY_MODULE_PATH . $controllerAppPath . 'ErrorMessageHandler.php';

$errorMessage[3] = "class " . $controllerClass . " extends AbstractAction {";
$errorMessage[5] = "}";
//echo $controllerFullPath;die;
if (!file_exists($controllerFullPath)) {
	$errorMessage[0] = "Missing Controller";
	$errorMessage[1] = $controllerClass . " could not be found.";
	$errorMessage[2] = "Create the class " . $controllerClass . " below in file: " . $controllerAppPath . $controllerFileName;
	errorMessage($errorMessage);
}
include_once $controllerFullPath;
/*
 * Execute
 */
$root = XCube_Root::getSingleton();
$handler = new $controllerClass($root);
if (!method_exists($handler, $method_name)) {
	$errorMessage[0] = "Missing method in " . $controllerClass;
	$errorMessage[1] = "The action '" . $method_name . "' is not defined in controller " . $controllerClass;
	$errorMessage[2] = "Create  " . $controllerClass . "::" . $method_name . "() in file: " . $controllerAppPath . $controllerFileName;
	$errorMessage[4] = "&nbsp;&nbsp;&nbsp;&nbsp;public function " . $method_name . "(){<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;}";
	errorMessage($errorMessage);
}
//$handler->setMethod($method_name);
$handler->setDirname($mydirname);
$handler->setParams($parameters);
$root->mController->mExecute->add(array(&$handler, $method_name));
$root->mController->execute();
/*********************************************************************************************
 * View Section
 *********************************************************************************************/
$root->mController->executeHeader();
$templatePath = _MY_MODULE_PATH . "templates/" . $handler->template;
$errorMessage[3] = '';
$errorMessage[4] = '';
$errorMessage[5] = '';
/*
if (!file_exists($viewFullPath)){
	$errorMessage[0] = 'Missing View';
	$errorMessage[1] = 'The view for '. $controllerClass .'::' . $method_name.'() was not found.';
	$errorMessage[2] = 'Confirm you have created the file: ' . $viewFullPath;
	errorMessage($errorMessage);
	die;
}*/
if (!file_exists($templatePath) || is_null($handler->template)) {
	$errorMessage[0] = 'Missing Template';
	$errorMessage[1] = 'The template for ' . $controllerClass . '::' . $method_name . '() was not found.';
	if (is_null($handler->template)){
		$errorMessage[2] = 'Set template file on '.$method_name;
		$errorMessage[4] = "public function " . $method_name . "(){<br />&nbsp;&nbsp;&#36;this->template = '".$controller_name.".html';&nbsp;&nbsp;<br />}";
	} else {
		$errorMessage[2] = 'Confirm you have created the file: ' . $templatePath;
	}
	errorMessage($errorMessage);
	die;
}
$handler->action_view();
$root->mController->executeView();
