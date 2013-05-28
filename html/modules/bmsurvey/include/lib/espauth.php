<?php

# $Id: espauth.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

//  phpESP Authentication Library Chooser
//  By: James Flemer <jflemer@alum.rpi.edu>

	$auth_type = isset($GLOBALS['FMXCONFIG']['auth_type']) ? $GLOBALS['FMXCONFIG']['auth_type'] : "default";

	if (!file_exists("./include/lib/espauth-$auth_type.php")) {
		echo("<b>FATAL: Unable to set up authentication for type $auth_type. Aborting.</b>");
		exit;
	}

	require("./include/lib/espauth-$auth_type.php");

?>
