<?php
# $Id: debug.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

	$arr = array();
	
	array_push($arr, array('SID', session_id()));
	if (@file_exists(session_save_path()."/sess_".session_id()))
		array_push($arr, array('SESSION', implode('', @file(session_save_path()."/sess_".session_id()))));
	
	if(isset($editForm->accessLevel)) {
		$arr[] = 'ACL';
		foreach ($editForm->accessLevel as $key => $val) {
			if(is_array($val))
				$val = '[ '. implode(' ', $val) .' ]';
			array_push($arr, array($key, $val));
		}
	}
	
	foreach (array(
		'HTTP_SESSION_VARS', 'FMXCONFIG', '_GET',
		'_POST', 'HTTP_SERVER_VARS', 'HTTP_ENV_VARS') as $v) {
		if(isset($$v)) {
			array_push($arr, $v);
			foreach ($$v as $key => $val) {
				if(is_array($val))
					$val = '[ '. @implode(' ', $val) .' ]';
				array_push($arr, array($key, $val));
			}
		}
	}
	
	$str = "<table cellspacing=\"0\" cellpadding=\"0\" width=\"590\">\n";
	foreach ($arr as $key) {
		if (is_array($key)) {
			$str .= '<tr><td bgcolor="#ccccff">' .
					htmlspecialchars($key[0]) . '</td>';
			$str .= '<td bgcolor="#cccccc">' .
					@htmlspecialchars($key[1]) . "</td></tr>\n";
		} else {
			$str .= '<tr><th align="left" colspan="2" bgcolor="#ccccff">' .
					htmlspecialchars($key) . "</th></tr>\n";
		}
	}
	$str .= "</table>\n";
?>
<script language="JavaScript">
<!-- // Begin <?php // This should really go into <head> tag ?>

function windowOpener(title,msg) {
  msgWindow=window.open("","displayWindow","menubar=no,alwaysRaised=yes,dependent=yes,width=600,height=500,scrollbars=yes,resizable=yes");
  msgWindow.document.write("<html><head><title>"+title+"</title></head>");
  msgWindow.document.write("<body>"+msg+"</body></html>");
}

function debugWindow () {
 title="Debug Window";
 msg="<?php echo(addcslashes($str, "\0..\31\\\"")); ?>";
 windowOpener(title, msg);
}
// End -->
</script>
<form name="debug"><input type="button" value="debug" onClick="debugWindow()"></form>
