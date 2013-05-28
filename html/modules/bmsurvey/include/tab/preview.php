<?php
# $Id: preview.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $
// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>
$section = isset($_POST['section']) ? intval($_POST['section']) : 1;
$sid = $editForm->editInfo['form_id'];
$rid = isset($editForm->editInfo['response_id']) ? $editForm->editInfo['response_id'] : null;
$sql = "SELECT COUNT(*) FROM ".TABLE_QUESTION." WHERE form_id='${sid}' AND deleted='N' AND type_id='99'";
list($cnt) = $xoopsDB->fetchRow($xoopsDB->query($sql));
$num_sections = 1 + $cnt;
$preview['title'] = _MB_This_is_a_preview;
if($num_sections > 1) { 
	$preview['sectionTitle'] = _MB_Section;
	for($i=0;$i<$num_sections;$i++) {
		$preview['sectionValue'][] = $i+1;
	}
}
$preview['hidden'] = '
	<input type="hidden" name="where" value="tab">
	<input type="hidden" name="old_tab" value="preview">';

/*if ($section > 1) $preview['button'][] = _MB_Previous_Page;
$preview['button'][] = ($section != $num_sections) ? _MB_Next_Page : _MB_Submit_Form;*/
$preview['button'][] = _MB_SaveAsDefault;
// lets make the css style available during the preview.
// this should really go into the head section.....but should still work
$xoops_module_header ='
<script language="javascript">
function other_check(name){
  other = name.split("_");
  var f = document.phpesp_response;
  for (var i=0; i<=f.elements.length; i++) {
    if (f.elements[i].value == "other_"+other[1]) {
      f.elements[i].checked=true;
      break;
    }
  }
}
function uncheckRadio(rbname){
    for(x=0; x<document.phpesp.elements[rbname].length; x++){
        document.phpesp.elements[rbname][x].checked = false;
    }
}
</script>
';
$sql = "SELECT theme FROM ".TABLE_FORM." where id = '${sid}'";
if ($result = $xoopsDB->query($sql)) {
    if ($xoopsDB->getRowsNum($result) > 0) {
        list($css_file) = $xoopsDB->fetchRow($result);
        
        // Set the CSS for the module
        $xoops_module_header .= "<link rel=\"stylesheet\" href=\"".$GLOBALS['FMXCONFIG']['css_url'].$css_file."\"  type=\"text/css\">\n";
    }
}
$xoopsTpl->assign('preview',$preview);
$xoopsTpl->assign('xoops_module_header', $xoopsTpl->get_template_vars('xoops_module_header').$xoops_module_header);
$tpl_vars['content']['tab'] = array(
	'title' => _MB_Preview,
	'name' => 'preview',
	'description' => _MB_This_is_a_preview
);
$_POST['sec'] = $section;
include('./public/handler.php');
?>