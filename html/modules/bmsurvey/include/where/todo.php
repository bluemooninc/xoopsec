<?php

# $Id: todo.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

?>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
<?php if (file_exists("./include/../../TODO")) { ?>
<table bgcolor="#ffffff" border="0"><tr><td><pre>
<?php include("./include/../../TODO"); ?>
</pre></td></tr></table>
<?php
	} else {
		echo('<p>' . $formRender->mkwarn(_MB_Todo_list_not_found) . "</p>\n");
	}
?>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
?>