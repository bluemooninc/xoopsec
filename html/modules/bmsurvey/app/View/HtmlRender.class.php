<?php
# $Id: esphtml.forms.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $
// First written by James Flemer For eGrad2000.com <jflemer@alum.rpi.edu>
// string	mkwarn(char *warning);
// string	mkerror(char *error);
// string	mkradio(char *name, char *value);
// string	mkcheckbox(char *name, char *value);
// string	mktext(char *name);
// string	mktextarea(char *name, int rows, int cols, char *wordwrap);
// string	mkselect(char *name, char *options[]);
// string	mkfile(char *name);
include_once _MY_MODULE_PATH . 'app/Model/ResponseLoader.class.php';
require_once _MY_MODULE_PATH . 'app/Model/Question.class.php';

class bmsurveyHtmlRender extends ResponseLoader
{
	var $htmlTag;
	var $has_required = FALSE;
	var $questions = array();
	var $sections = array();
	var $pages = 1;

	function bmsurveyHtmlRender()
	{
		$this->htmlTag = array();
	}

	function getHtmlTag()
	{
		$ret = $this->htmlTag;
		$this->htmlTag = array();
		return $ret;
	}

	function mkerror($msg)
	{
		return ("<font color=\"" . $GLOBALS['FMXCONFIG']['error_color'] . "\" size=\"+1\">[ ${msg} ]</font>\n");
	}

	function mkwarn($msg)
	{
		return ("<font color=\"" . $GLOBALS['FMXCONFIG']['warn_color'] . "\" size=\"+1\">${msg}</font>\n");
	}

	function mkother($_name, $value)
	{
		return array(
			'type' => "text",
			'name' => htmlspecialchars($_name),
			'value' => htmlspecialchars($value),
			'onKeyPress' => "other_check(this.name)",
		);
	}

	function mkrankTitle($_name, $value)
	{
		return array(
			'type' => NULL,
			'name' => htmlspecialchars($_name),
			'value' => htmlspecialchars($value),
		);
	}

	function mkradio($_name, $value, $varr = NULL, $message = NULL)
	{
		$checked = FALSE;
		if (is_array($varr)) {
			if ((isset($varr[$_name])) && (in_array($value, $varr))) {
				$checked = TRUE;
			}
		} else {
			if (strcmp($value, $varr) == 0) $checked = TRUE;
		}
		return array(
			'type' => "radio",
			'name' => htmlspecialchars($_name),
			'value' => htmlspecialchars($value),
			'checked' => $checked,
			'message' => $message
		);
	}

	function mkradioCancel($_name, $value)
	{
		return array(
			'type' => "button",
			'name' => "Button",
			'value' => htmlspecialchars($value),
			'onclick' => 'uncheckRadio(\'' . $_name . '\')'
		);
	}

	function mkcheckbox($_name, $value, $varr = NULL, $message = NULL)
	{
		if ($varr == NULL) $varr =& $_POST;
		$checked = FALSE;
		if ((in_array($value, $varr))) {
			$checked = TRUE;
		}
		return array(
			'type' => "checkbox",
			'name' => htmlspecialchars($_name),
			'value' => htmlspecialchars($value),
			'checked' => $checked,
			'message' => $message
		);
	}

	function mktext($_name, $size = 20, $max = 0, $value = NULL, $class = NULL)
	{
		$size = intval($size);
		$max = intval($max);
		return array(
			'type' => "text",
			'name' => htmlspecialchars($_name),
			'value' => $value
		);
	}

	function mktextarea($_name, $rows, $cols, $wrap, $value = NULL)
	{
		return array(
			'type' => "textarea",
			'name' => htmlspecialchars($_name),
			'rows' => $rows,
			'cols' => $cols,
			'value' => $value,
			'wrap' => $wrap
		);
	}

	function &mkselect($_name, $options, $varr = NULL)
	{
		$opt = array();
		while (list($cid, $content) = each($options)) {
			$checked = '';
			if (is_array($varr)) {
				if (isset($varr[$_name])) {
					if (is_array($varr[$_name]))
						$nm = $varr[$_name][0];
					else
						$nm = $varr[$_name];
					if ($nm == $cid) $checked = ' selected';
				}
			} else {
				if (strcmp($cid, $varr) == 0) $checked = ' selected';
			}
			$opt[] = array(
				'value' => $cid,
				'checked' => $checked,
				'content' => $content
			);
		}
		return array(
			'type' => "select",
			'name' => htmlspecialchars($_name),
			'value' => $opt
		);
	}

	function other_text($content)
	{
		return preg_replace(array("/^!other=/", "/^!other/"), array('', _MD_QUESTION_OTHER), $content);
	}

	public function generateHtml(&$questionObject, &$choiceObjects = NULL)
	{
		$cancelButton = $this->root->mContext->mModuleConfig['RESET_RB'];
		$defaultValue = $defaultValueArray = NULL;
		$qname = "Q" . $questionObject->getVar('id');
		$htmlTag = array();
		switch ($questionObject->getVar('type_id')) {
			case '1': // Yes/No
				$htmlTag[] = $this->mkradio($qname, 'Y', $defaultValue, _MB_Yes);
				$htmlTag[] = $this->mkradio($qname, 'N', $defaultValue, _MB_No);
				if ($cancelButton) $htmlTag[] = $this->mkradioCancel($qname, _MD_BMSURVEY_CHECKRESET);
				break;
			case '2': // single text line
				$htmlTag[] = $this->mktext($qname, $questionObject->getVar('length'), $questionObject->getVar('precise'), $defaultValue);
				break;
			case '3': // essay
				$htmlTag[] = $this->mktextarea($qname, $questionObject->getVar('precise'), $questionObject->getVar('length'), 'VIRTUAL', $defaultValue);
				break;
			case '4': // radio
				foreach ($choiceObjects as $choiceObject) {
					$choice_id = $choiceObject->getVar('id');
					$content = $choiceObject->getVar('value');
					if (preg_match("/!other/", $content)) {
						$htmlTag[] = $this->mkradio($qname, "other_${$choice_id}", $defaultValueArray, $this->other_text($content));
						$htmlTag[] = $this->mkother($qname . "_${$choice_id}", NULL);
					} else {
						$htmlTag[] = $this->mkradio($qname, $choice_id, $defaultValueArray, $content);
					}
				}
				if ($cancelButton) $htmlTag[] = $this->mkradioCancel($qname, _MD_BMSURVEY_CHECKRESET);
				break;
			case '5': // check boxes
				foreach ($choiceObjects as $choiceObject) {
					$choice_id = $choiceObject->getVar('id');
					$content = $choiceObject->getVar('value');
					if (preg_match("/!other/", $content)) {
						$htmlTag[] = $this->mkcheckbox($qname, "other_${$choice_id}", $defaultValueArray, $this->other_text($content));
						$htmlTag[] = $this->mkother($qname . "_${$choice_id}", NULL);
					} else {
						$htmlTag[] = $this->mkcheckbox($qname, $choice_id, $defaultValueArray, $content);
					}
				}
				break;
			case '6': // dropdown box
				$options = array();
				foreach ($choiceObjects as $choiceObject) {
					$choice_id = $choiceObject->getVar('id');
					$content = $choiceObject->getVar('value');
					$options[$choice_id] = $content;
				}
				$htmlTag[] = $this->mkselect($qname, $options, $defaultValueArray);
				break;
			case '9': // date
				$varr[$qname] = date(_SHORTDATESTRING, time());
				$htmlTag[] = $this->mktext($qname, 10, 10, $defaultValue);
				break;
			case '99': // Page Break
				$this->pages++;
				$question['content'] = NULL;
				break;
			case '100': // Section Text
				//if ($section_id=="") $question['section_top'] = 1;
				//$section_id = 'tab-'.$question['id'];
				$question['section_id'] = 'tab-' . $questionObject->getVar('id');
				break;
		}
		return array(
			'id' => $questionObject->getVar('id'),
			'name' => $questionObject->getVar('name'),
			'content' => $questionObject->getVar('content'),
			'tag' => $htmlTag
		);
	}

	function formRender_smarty(&$questionObjects, $pageNumber = 1)
	{
		global $_POST, $xoopsModuleConfig;

		$has_choices = $this->esp_type_has_choices();
		$qnum = 1;
		$formRender_smarty = array();
		$section_id = "";
		$section = array();
		$question = array();
		$questionHandler = Model_Question::forge();
		foreach ($questionObjects as $questionObject) {
			$question['section_top'] = 0;
			$question['type_id'] = $questionObject->getVar('type_id');
			$question['id'] = $questionObject->getVar('id');
			$question['required'] = $questionObject->getVar('required');
			$question['length'] = $questionObject->getVar('length');
			$question['precise'] = $questionObject->getVar('precise');
			if ($question['required'] == 'Y') {
				$this->has_required = TRUE;
			}
			if ($pageNumber > $this->pages) {
				// Page Break
				if ($question['type_id'] < 99) $qnum++;
				if ($question['type_id'] == '99') $this->pages++;
				continue; // Skip to pageNumber
			}
			if ($pageNumber < $this->pages) break; // Stop over the pageNumber
			// process each question
			$choiceObjects = NULL;
			if ($has_choices[$question['type_id']]) {
				$choiceObjects = $questionHandler->getChoice($question['id']);
			}
			$this->generateHtml(
				$question['id'],
				$question['type_id'],
				$xoopsModuleConfig['RESET_RB'],
				$question['precise'],
				$question['length'],
				$choiceObjects
			);
			$question['qnum'] = $qnum;
			$question['section_id'] = $section_id;
			$formRender_smarty[$question['id']] = $question;
			$formRender_smarty[$question['id']]['htmlTag'] = $this->getHtmlTag();
			if ($question['type_id'] < 99) $qnum++;
			if ($question['type_id'] == 100) $section[$question['id']] = $question;
		}
		$this->sections = $section;
		return $formRender_smarty;
	}
}
