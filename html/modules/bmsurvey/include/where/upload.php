<?php

# $Id: upload.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

// upload.php written by Matthew Gregg
// <greggmc@musc.edu>
// Bulk upload from text files

	$bg1 =& $FMXCONFIG['bgalt_color1'];
	$bg2 =& $FMXCONFIG['bgalt_color2'];
	if(isset($_GET['account_type']))
		$account_type = addslashes($_GET['account_type']);
	else
		$account_type = "respondents";

	$errstr = '';

// End the included form so we can do a multipart/form-data form
?>
</form>
<?php
	if(isset($_POST['submit'])) {
		unset($_POST['submit']);
		if(isset($_POST['account_type']))
			$account_type = addslashes($_POST['account_type']);
		else
			$account_type = "respondents";

		$upload_type	= addslashes($_POST['upload_type']);
			$upload_file	= $HTTP_POST_FILES['upload_file']['tmp_name'];
		$group_acl	= array();


		if($xoopsUser->isAdmin()) {
			$sql = "SELECT name FROM ".TABLE_REALM."";
			$result = $xoopsDB->query($sql);
			while (list($row) = $xoopsDB->fetchRow($result)) {
				array_push($group_acl, $row);
			}
			
		} else {
			$group_acl =& $editForm->accessLevel['pgroup'];
		}

		if(!empty($upload_type) && !empty($account_type) && is_uploaded_file($upload_file)) {
			$file = file($upload_file);
			$exceptions = array();
			$success = account_upload($exceptions, $upload_type, $account_type, $group_acl, $file);
			if($success) {
				unset($_POST['account_type']);
				unset($_POST['submit']);
				include($fmxStatus->esp_where("$account_type"));
                       		return;
			}
			elseif(count($exceptions) > 1) {
				$errstr .= $formRender->mkerror( _MB_An_error_Rows_that_failed );
				$exception_table = ("<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" align=\"center\" bgcolor=".$FMXCONFIG['active_bgcolor']."\">\n");
				$bg = $FMXCONFIG['bgalt_color2'];
	 			$exception_table .= "<tr bgcolor=\"$bg\">\n";
				/* Build  exception rows */
				/* Header row*/
				while (list(, $col) = each ($exceptions[0])) {
					$exception_table .= "<th align=\"left\">$col</th>\n";
				}
				$exception_table .= "</tr>\n";
				/* Data rows*/
				next($exceptions);
				while (list(, $row) = each ($exceptions)) {
					if ($bg == $FMXCONFIG['bgalt_color1'])
	       	       	         		$bg =& $FMXCONFIG['bgalt_color2'];
        		        	else
                       				$bg =& $FMXCONFIG['bgalt_color1'];
					$exception_table .= "<tr valign=\"top\" bgcolor=\"$bg\">\n";
					foreach($row as $col) {
						$exception_table .= "<td>$col</td>\n";

					}
				}
				$exception_table .= "</tr>\n</table>";
			}
			else {
				$errstr .= $formRender->mkerror(_MB_An_error_Please_check_the_format);
			}
		}
		else {
				$errstr .= $formRender->mkerror(_MB_An_error_Please_complete_all_form_fields);
		}
	}
?>
<h2><?php echo(_MB_Upload_Account_Information); ?></h2>
<p><?php echo(_MB_All_fields_are_required) ?></p>
<?php if(!empty($errstr)) echo("<p>$errstr</p>\n"); ?>
<font size="+2">
<a href="<?php echo($GLOBALS['FMXCONFIG']['manage'] ."?where=help"); ?>" target="_blank"><?php echo(_MB_Help); ?></a>
</font>
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>">
<form enctype="multipart/form-data" method="Post" action="<?php echo ($GLOBALS['FMXCONFIG']['manage']); ?>">
<?php
		echo("<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" align=\"center\" bgcolor=\"".$FMXCONFIG['active_bgcolor']."\">\n");
?>
<input type="hidden" name="where" value="upload">
<input type="hidden" name="account_type" value="<?php echo($account_type); ?>">
<?php
		echo("<tr>\n<th bgcolor=\"$bg2\" align=\"right\">". _MB_File_Type ."</th>\n");
		echo("<td bgcolor=\"$bg1\">\n".mkselect('upload_type',array('tab' =>_MB_Tab_Delimited ))."</td>\n</tr>");
		echo("<tr>\n<th bgcolor=\"$bg2\" align=\"right\">". _MB_File_to_upload ."</th>\n");
		echo("<td bgcolor=\"$bg1\">\n".mkfile('upload_file')."\n"."</td>\n</tr>");
?>
<tr>
<th colspan="2" bgcolor="<?php echo($bg2); ?>">
<input type="submit" value="Upload" name="submit">
</th>
</tr>
 </table>
<?php if(!empty($exception_table)) echo("<p>$exception_table</p>\n"); ?>
<?php
echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n");
?>
