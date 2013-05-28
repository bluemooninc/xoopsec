<?php

# $Id: order.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

$url = $FMXCONFIG['manage'] .'?where=tab&tab=order';

if(isset($_POST['src']))
	$src = intval($_POST['src']);
else
    $src = 0;
if (isset($_POST['dst']))
	$dst = intval($_POST['dst']);
else
    $dst = 0;
$sid = $editForm->editInfo['form_id'];

if(isset($_POST['addbreak'])) {
	$sql = "SELECT MAX(position)+1 FROM ".TABLE_QUESTION." WHERE form_id='$sid'";
	list($pos) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	

	$sql = "INSERT INTO ".TABLE_QUESTION." (form_id,type_id,position,content) VALUES ('$sid', 99, '$pos', 'break')";
	$xoopsDB->query($sql);
} elseif ($src > 0) {
	--$src;
	--$dst;

	$sql = "SELECT id,position FROM ".TABLE_QUESTION." WHERE form_id='$sid' AND deleted='N' ORDER BY position";
	$result = $xoopsDB->query($sql);

	$max = $xoopsDB->getRowsNum($result);

	while ($arr[] = $xoopsDB->fetchArray($result));

	if ($src < $max) {
		$qid = $arr[$src]["id"];

		if ($dst < 0) {
			// remove
			$sql = "UPDATE ".TABLE_QUESTION." SET deleted='Y' WHERE id='$qid' AND form_id='$sid'";
			$xoopsDB->query($sql);
		} elseif (0 <= $dst && $dst < $max && $src != $dst) {
			// move
			if ($max - 1 > $dst) {
				if ($src < $dst)
					// move down
					++$dst;
				$dst = $arr[$dst]['position'];
				$sql = "UPDATE ".TABLE_QUESTION." SET position=position+1 WHERE form_id='$sid' AND position >= '$dst'";
				$xoopsDB->query($sql);
			} else {
				$dst = $arr[$max-1]['position'] + 1;
			}
			$sql = "UPDATE ".TABLE_QUESTION." SET position='$dst' WHERE id='$qid' AND form_id='$sid'";
			$xoopsDB->query($sql);
		}
	}
	
}

$sql = "SELECT id, type FROM ".TABLE_QUESTION_TYPE." WHERE id != 99";
$result = $xoopsDB->query($sql);
$typeArr = array();
while(list($key, $val) = $xoopsDB->fetchRow($result)) {
	$typeArr["$key"] = $val;
}


$sql = "SELECT id,name,type_id,position,content FROM ".TABLE_QUESTION."
		WHERE form_id='$sid' AND deleted='N'
		ORDER BY position";
$result = $xoopsDB->query($sql);
$max = $xoopsDB->getRowsNum($result);
$sec = $num = 0;
$selectPosition = '';
$order['max'] = $max+1;
while( list($qid, $qname, $tid, $pos, $content) = $xoopsDB->fetchRow($result)) {
	$num++;
	if ($tid == 99) ++$sec;
	$row = array(
		'tid' => $tid,
		'name' => $qname,
		'typeName' => $tid != 99 ? $typeArr[$tid] : null,
		'content'=> $tid != 99 ? $content : null,
		'num'=> $num,
		'editq'=> $tid != 99 ? $num-$sec : null
	);
	$order['contents'][] = $row;
}

$xoopsTpl->assign('order',$order);

$xoops_module_header ='
<script language="javascript">
<!-- // comment
  function swap(src, dst) {
    document.phpesp.src.value=src;
    document.phpesp.dst.value=dst+1;
    document.phpesp.submit();
  }
  function remove(src) {
    document.phpesp.src.value=src;
    document.phpesp.dst.value=-1;
    document.phpesp.submit();
  }
  function editq(num) {
    if (document.phpesp.elements[1].name == "tab") {
        document.phpesp.elements[1].value="Questions";
    }
    else {
      for (i = 1; i <= document.phpesp.elements.length; i++) {
	if (document.phpesp.elements[i].name == "tab") {
	  document.phpesp.elements[i].value="Questions";
	  break;
	}
      }
    }
    document.phpesp.q.value=num;
    document.phpesp.submit();
	return false;
  }
// comment -->
</script>
';
$xoopsTpl->assign('xoops_module_header', $xoopsTpl->get_template_vars('xoops_module_header').$xoops_module_header);

$tpl_vars['content']['tab'] = array(
	'title' => _MB_Order,
	'name' => 'order',
	'description' => _MB_Change_the_order
);
$tpl_vars['content']['questions'] = $order['contents'];
$tpl_vars['content']['questionsLength'] = $max;
$tpl_vars['langs']['col_name_type'] = BMSURVEY_TABS_ORDER_COL_NAME_TYPE;
$tpl_vars['langs']['col_edit'] = BMSURVEY_TABS_ORDER_COL_EDIT;
$tpl_vars['langs']['col_move'] = BMSURVEY_TABS_ORDER_COL_MOVE;
$tpl_vars['langs']['col_remove'] = BMSURVEY_TABS_ORDER_COL_REMOVE;
$tpl_vars['langs']['remove_field'] = _MB_Remove;
$tpl_vars['langs']['edit_field'] = _MB_Edit;
$tpl_vars['langs']['section_break'] = _MB_Section_Break;
$tpl_vars['langs']['add_section_break'] = _MB_Add_Section_Break;

?>