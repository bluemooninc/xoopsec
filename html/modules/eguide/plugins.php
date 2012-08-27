<?php
global $hooked_function;
$hooked_function = array('check'=>array(), 'reserve'=>array(), 'cancel'=>array());
$dir = EGUIDE_PATH.'/plugins';
$basename = basename(__FILE__);

// read plugin language file
function eguide_plugin_language($file) {
    global $xoopsConfig;
    $lang = dirname(__FILE__).'/plugins/language';
    $nlang = $lang.'/'.$xoopsConfig['language'].'/'.$file;
    if (file_exists($nlang)) return include_once $nlang;
    $nlang = $lang.'/english/'.$file; // fallback
    return include_once $nlang;
}

// register plugin functions
function eguide_plugin_register($name) {
    global $hooked_function;
    foreach (array('check', 'reserve', 'cancel') as $act) {
	$func = 'eguide_'.$name.'_'.$act;
	if (function_exists($func)) {
	    $hooked_function[$act][] = $func;
	}
    }    
}

if ($xoopsModuleConfig['use_plugins'] && is_dir($dir)) {
    $plugins = eguide_form_options('eguide_plugins', '');
    if ($plugins) {
	foreach (explode(',', $plugins) as $name) {
	    $file = "$name.php";
	    if (include ("$dir/$file")) {
		eguide_plugin_language($file);
		eguide_plugin_register($name);
	    }
	}
    } else {	// search module control plugins
	$dh = opendir($dir);
	while ($file = readdir($dh)) {
	    if (preg_match('/^([\w\d]+)\.php$/', $file, $d)) {
		$name = $d[1];
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($name);

		if ($module && $module->getVar('isactive') && include ("$dir/$file")) {
		    eguide_plugin_language($file);		    
		    eguide_plugin_register($name);		    
		    // register hook

		}
	    }
	}
    }
}
?>