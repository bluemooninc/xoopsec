<?php

# $Id: form_render.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

// Modify by Yoshi Sakai
// For Attach File
// <webmaster@bluemooninc.biz>
// 2004/05/23 Change form style more compact.
// 2004/05/26 Add Attach File.


/******************************************************************************
** For email
******************************************************************************/
function form_render_email($sid, $section = 1, $message = '', $hide_question = 0) {
	global $_POST,$maxfilesize;
	@reset($_POST);
	$body='';

	if(empty($section)) $section = 1;

	$has_choices = esp_type_has_choices();

// load form title (and other globals)
	$sql = "SELECT * FROM ".TABLE_FORM." WHERE id='${sid}'";
	$result = $xoopsDB->query($sql);
	if($xoopsDB->getRowsNum($result) != 1)
		return(false);
	$form = $xoopsDB->fetchArray($result);
	

	$sections = form_get_sections($sid);
	$num_sections = count($sections);
	if($section-- > $num_sections)
		return(false);	// invalid section


// load form questions
	$sec_sql = array_to_insql($sections[$section]);
	$sql = "SELECT * FROM ".TABLE_QUESTION." WHERE id $sec_sql ORDER BY position,id";
	$questions_result = $xoopsDB->query($sql);
	if($xoopsDB->getRowsNum($questions_result) < 1)
		return(false);

// check to see if there are required questions
	$sql = "SELECT COUNT(*) FROM ".TABLE_QUESTION." WHERE id $sec_sql AND required='Y'";
	list($has_required) = $xoopsDB->fetchRow($xoopsDB->query($sql));

// find out what question number we are on $i
	$i=0;
	$title = $form["title"];
	if ($form["subtitle"]){
		$title .=" ".$form["subtitle"];
	}
	if ($form["info"] || $message){
		$title .= "\n".$form["info"]." ".$message;
	}
/*
	if($has_required) {
	   	$title .= "\n"._MD_ASTERISK_REQUIRED;
	}
*/
	$body = "";
	//$i = $qnum = 1;
	while($question = $xoopsDB->fetchArray($questions_result)) {
		// process each question
		$qnum = &$question['position'];
		$qid  = &$question['id'];
		$tid  = &$question['type_id'];
		$size = &$question['length'];
		$prec = &$question['precise'];
		if ($tid == 100) {
			$body.= "// " . $question['content'] . "\r\n";
			continue;
		}
		++$i;
		if($has_choices[$tid]) {
			$sql = "SELECT * FROM ".TABLE_QUESTION_CHOICE." WHERE question_id='$qid' AND content NOT LIKE '!other%' ORDER BY id";
			$choices_result = $xoopsDB->query($sql);
			$sql = "SELECT * FROM ".TABLE_QUESTION_CHOICE." WHERE question_id='$qid' AND content LIKE '!other%' ORDER BY id";
			$others_result = $xoopsDB->query($sql);
			$others = $xoopsDB->getRowsNum($others_result);
		} else {
			$choices_result = '';
		}
		if($question['required']=='Y') { 
			$body.='[*]'; 
		}
		if ($hide_question==0)
			$content = $question['content'];
		else
			$content = '';
		//'Q'.  $qnum + 1 . ':' . $question['content'];	//$qid 
		$body .= sprintf("Q%u:%s",$qnum+1 ,$content);
		switch($tid) {
			case '1':	// Yes/No
				$body.=" 1.()Yes";
				$body.=" 2.()No";
				break;
			case '2':	// single text line
				$body .= sprintf(" []M%uL%u",$size,$prec);
				break;
			case '3':	// essay
				$body .= sprintf(" []R%uC%u",$size,$prec);
				break;
			case '4':	// radio
				$j=1;
				while($choice = $xoopsDB->fetchArray($choices_result)) {
					$body.=' '.$choice['id'].'.()';	//(mkradio($qid,$choice['id']));
					$body.=$choice['content'];
					$j++;
				}
				$j=0;
				while($other = $xoopsDB->fetchArray($others_result)) {
					$cid = $other['id'];
					$other_text = preg_replace(
						array("/^!other=/","/^!other/"),
						array('',_MD_QUESTION_OTHER),
						$other['content']);	//'Other:'
					$body.= "\r\n   o_${cid}:${other_text}[]";	//${qid}
//					$body.=mkradio($qid,"other_$cid");
//                    $cid = "${qid}_${cid}";
                    //$body.="$other_text <input type=\"text\" size=\"20\" name=\"$cid\" onKeyPress=\"other_check(this.name)\"";
//                	if (isset($GLOBALS['_POST'][$cid]))
//                        $body.=(' value="'. htmlspecialchars($GLOBALS['_POST'][$cid]) .'"');
//                    $body.=(" />");
					$j++;
				}
				break;
			case '5':	// check boxes
				$num=0;
				while($choice = $xoopsDB->fetchArray($choices_result)) {	
					$num++;
					//$body.=(mkcheckbox($qid,$choice['id'])); 
					$body.=' '.$choice['id'].'.[]';
					$body.=$choice['content'];
				}
				$j=0;
				while($other = $xoopsDB->fetchArray($others_result)) {
					$cid = $other['id'];
					$other_text = preg_replace(
						array("/^!other=/","/^!other/"),
						array('',_MD_QUESTION_OTHER),
					$other['content']);
					$body.= "\r\n   o_${cid}:${other_text}[]";	//${qid}
/*
					$body.=(mkcheckbox($qid,"other_$cid"));
                    $cid = "${qid}_${cid}";
                    $body.=("$other_text <input type=\"text\" size=\"20\" name=\"$cid\" onKeyPress=\"other_check(this.name)\"");
                	if (isset($GLOBALS['_POST'][$cid]))
                        $body.=(' value="'. htmlspecialchars($GLOBALS['_POST'][$cid]) .'"');
                    $body.=(" />");
*/
					$j++;
				}
				break;
			case '6':	// dropdown box
				$options = array();
				while($choice = $xoopsDB->fetchArray($choices_result)) {
//					$options[$choice['id']] = $choice['content'];
					$body.= ' '.$choice['id'].'.()';
					$body.= $choice['content'];
				}
				//$body.=(mkselect($qid,$options));
				break;
			case '7':	// rating
				$body.='[]1[]2[]3[]4[]5';
				$body.=('N/A');
				break;
			case '8':	// ranking
				while($choice = $xoopsDB->fetchArray($choices_result)) {
					$cid = $choice['id'];
					$body.="\r\n${qid}_${cid}:";
					$body.=$choice['content'];
					if ($prec) {
						$body .= 'N/A';
					}else{
						for ($j = 0; $j < $size; $j++) {
							$body .= sprintf(' %u.()',$j+1);
						}
					}
				}
				break;
			case '9':	// date
				$body .= sprintf(" [%s]M%uL%uN",date(_SHORTDATESTRING, time()),$size,$prec);
				break;
			case '10':	// numeric
				$body .= sprintf(" []M%uL%uN",$size,$prec);
				break;
			case '40':	// Attache
				break;
		}
		// end of select
		$body .= "\r\n";
	}
	// end of questions
	$myts =& MyTextSanitizer::getInstance();
	$ret['title']=$title;
	$ret['body']=$myts->stripSlashesGPC($body);
	return $ret;
	//return $body;
}
?>