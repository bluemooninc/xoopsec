<?php

# $Id: merge.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by Romans Jasins
// <roma@latnet.lv>

	// see if forms have been selected
	if(!empty($_GET['sids'])) {
		$sid = intval($_GET['sids']);
		if($_GET['test']) {
			echo("<p><b>". _MB_Testing_Form .'</b> ('. _MB_SIDS ." = ". $_GET['sids'] .")</p>\n");
		}

		/* check ACLs for permissions ...
		 * XXX only check the first of the SIDS for ownership */
		if($xoopsUser->isAdmin() ||
				$formTable->auth_is_owner($sid, $xoopsUser->uid()) ||
				($_GET['test'] &&
					$editForm->accessLevel['seeall'] == 'Y') ||
				$formTable->auth_no_access('to access this form')) {
?>
<table bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" border="1" width="95%"><tr><td>
<?php
			$ret = form_merge(split(" ",$_GET['sids']),$_GET['precision'],$_GET['totals']);
			if(!empty($ret))
				echo("<font color=\"". $FMXCONFIG['error_color'] ."\">$ret</font>\n");
?>
</td></tr></table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
<?php
		}
		return;
	}

	// otherwise:
	// build a table of forms to choose from ...
	/* check with ACL for allowed forms */
	$statusok = (STATUS_ACTIVE | STATUS_DONE & ~STATUS_DELETED);
	if($xoopsUser->isAdmin() ||
		$editForm->accessLevel['seeall'] == 'Y')
		$sql = "SELECT id,name,title,owner FROM ".TABLE_FORM."
			WHERE (status & $statusok)
			ORDER BY id DESC";
	else
		$sql = "SELECT id,name,title,owner FROM ".TABLE_FORM." WHERE owner='".
			$xoopsUser->uid() ."'
			AND (status & $statusok)
			ORDER BY id DESC";
	$result = $xoopsDB->query($sql);

?>
<SCRIPT LANGUAGE="JavaScript">
<!-- // Begin // This should really go into <HEAD> tag

function windowOpener(windowTitle,errMsg) {
  msgWindow=window.open("","displayWindow","menubar=no,alwaysRaised=yes,dependent=yes,width=300,height=200,scrollbars=yes,resizable=no");
  msgWindow.document.write
      ("<HTML><HEAD><TITLE>"+windowTitle+"</TITLE></HEAD>");
  msgWindow.document.write
      ("<BODY><CENTER><BIG><B>"+errMsg+"</B></BIG></CENTER></BODY></HTML>");
}

function merge(box) {
	if(box.options.length >= 2){
		ml = new Array();
		for(var i=0; i<box.options.length; i++) {
			ml[i] = box.options[i].value;
			sidsArray=ml;
		}
		sids = sidsArray.join("+");
		location.href = "<?php echo("". $GLOBALS['FMXCONFIG']['manage'] ."?where=merge"); ?>&sids="+sids;
	} else {
		windowTitle="<?php echo(_MB_Error); ?>";
		errMsg="<?php echo(_MB_You_need_to_select_at_least_two_forms); ?>";
		windowOpener(windowTitle,errMsg);
	}
}

function move(fbox,tbox) {
	for(var i=0; i<fbox.options.length; i++) {
		if(fbox.options[i].selected && fbox.options[i].value != "") {
			var no = new Option();
			no.value = fbox.options[i].value;
			no.text = fbox.options[i].text;
			tbox.options[tbox.options.length] = no;
			fbox.options[i].value = "";
			fbox.options[i].text = "";
		}
	}
	BumpUp(fbox);
}

function BumpUp(box)  {
	for(var i=0; i<box.options.length; i++) {
		if(box.options[i].value == "")  {
			for(var j=i; j<box.options.length-1; j++)  {
				box.options[j].value = box.options[j+1].value;
				box.options[j].text = box.options[j+1].text;
			}
			var ln = i;
			break;
		}
	}
	if(ln < box.options.length)  {
		box.options.length -= 1;
		BumpUp(box);
	}
}
// End -->
</SCRIPT>
<h2><?php echo(_MB_Merge_Form_Results); ?></h2>
<?php echo(_MB_Pick_Forms_to_Merge); ?>
<table border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="<?php echo($FMXCONFIG['active_bgcolor']); ?>" width="95%">
	<tr bgcolor="#dddddd">
		<th width="33%"><?php echo(_MB_List_of_Forms); ?></th>
		<th width="34%">&nbsp;</th>
		<th width="33%"><?php echo(_MB_Forms_to_Merge); ?></th>
	</tr>
	<tr>
		<td align="center">
		<select multiple size="10" name="list1">
			<?php while(list($sid, $name, $title, $owner) = $xoopsDB->fetchRow($result)) { ?>
			<option value="<?php echo($sid); ?>"><?php echo($name); ?></option>
			<?php }  ?>
		</select>
		</td>
		<td align="center">
<input type="button" value="   &gt;&gt;   " onclick="move(this.form.list1,this.form.list2)" name="B1"><br>
<input type="button" value="   &lt;&lt;   " onclick="move(this.form.list2,this.form.list1)" name="B2"><br>
<input type="button" value="Merge" onclick="merge(this.form.list2)" name="B3">
		</td>
		<td align="center">
		<select multiple size="10" name="list2">
		</select>
		</td>
	</tr>
</table>
<?php echo("<a href=\"". $GLOBALS['FMXCONFIG']['manage'] ."?where=manage\">" . _MB_Go_back_to_Management_Interface . "</a>\n"); ?>
