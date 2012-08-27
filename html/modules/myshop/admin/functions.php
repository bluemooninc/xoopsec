<?php

function myshop_adminMenu($currentoption = 0, $breadcrumb = '')
{
	global $xoopsConfig, $xoopsModule;
	if(file_exists(XOOPS_ROOT_PATH.'/modules/myshop/language/'.$xoopsConfig['language'].'/modinfo.php')) {
		require_once XOOPS_ROOT_PATH.'/modules/myshop/language/'.$xoopsConfig['language'].'/modinfo.php';
	} else {
		require_once XOOPS_ROOT_PATH . '/modules/myshop/language/english/modinfo.php';
	}
	
include dirname(__FILE__) . '/menu.php';

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

$mymenu_uri = empty( $mymenu_fake_uri ) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri ;
$mymenu_link = substr( strstr( $mymenu_uri , '/admin/' ) , 1 ) ;
	


// highlight
foreach( array_keys( $adminmenu ) as $i ) {
	if( $mymenu_link == $adminmenu[$i]['link'] ) {
		$adminmenu[$i]['selected'] = true ;
		$adminmenu_hilighted = true ;
		$GLOBALS['altsysAdminPageTitle'] = $adminmenu[$i]['title'] ;
	} else {
		$adminmenu[$i]['selected'] = false ;
	}
}
if( empty( $adminmenu_hilighted ) ) {
	foreach( array_keys( $adminmenu ) as $i ) {
		if( stristr( $mymenu_uri , $adminmenu[$i]['link'] ) ) {
			$adminmenu[$i]['selected'] = true ;
			$GLOBALS['altsysAdminPageTitle'] = $adminmenu[$i]['title'] ;
			break ;
		}
	}
}

// link conversion from relative to absolute
foreach( array_keys( $adminmenu ) as $i ) {
	if( stristr( $adminmenu[$i]['link'] , XOOPS_URL ) === false ) {
		$adminmenu[$i]['link'] = XOOPS_URL."/modules/$mydirname/" . $adminmenu[$i]['link'] ;
	}
}

// display
require_once XOOPS_ROOT_PATH . '/class/template.php';
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'adminmenu' => $adminmenu ,
) ) ;
$tpl->display( 'db:altsys_inc_mymenu.html' ) ;

}

/**
 * Internal function
 */
function myshop_get_mid() {
	global $xoopsModule;
	return $xoopsModule->getVar('mid');

}

/**
 * Internal function
 */
function myshop_get_config_handler()
{
	$config_handler = null;
	$config_handler =& xoops_gethandler('config');
	if(!is_object($config_handler)) {
		trigger_error("Error, unable to get and handler on the Config object");
		exit;
	} else {
		return $config_handler;
	}

}

/**
 * Returns a module option
 *
 * @param string	$option_name	The module's option
 * @return object	The requested module's option
 */
function myshop_get_module_option($optionName = '')
{
	$ret = null;
	$tbl_options = array();
	$mid = myshop_get_mid();
	$config_handler = myshop_get_config_handler();
	$critere = new CriteriaCompo();
	$critere->add(new Criteria('conf_modid', $mid, '='));
	$critere->add(new Criteria('conf_name', $optionName, '='));
	$tbl_options = $config_handler->getConfigs($critere, false, false);
	if(count($tbl_options) >0 ) {
		$option = $tbl_options[0];
		$ret = $option;
	}
	return $ret;
}


/**
 * Set a module's option
 */
function myshop_set_module_option($optionName = '', $optionValue = '')
{
	$config_handler = myshop_get_config_handler();
	$option = myshop_get_module_option($optionName, true);
	$option->setVar('conf_value', $optionValue);
	$retval = $config_handler->insertConfig($option, true);
	return $retval;
}

?>