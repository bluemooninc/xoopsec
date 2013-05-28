<?php

# $Id: guide.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

?>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
<?php if (file_exists(ESP_BASE . '/docs/GUIDE')) { ?>
<table bgcolor="#ffffff" border="0"><tr><td><pre>
<?php include(ESP_BASE . '/docs/GUIDE'); ?>
</pre></td></tr></table>
<?php
	} else {
		echo('<p>' . $formRender->mkwarn(_MB_Users_guide_not_found) . "</p>\n");
	}
?>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>