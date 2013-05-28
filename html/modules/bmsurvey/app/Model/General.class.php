<?php

class Model_General
{
	var $generalInfo = array();
	var $question = array();
	var $accessLevel = array();
	var $edit_qid = 0;
	protected $form_id;
	protected $formObject;
	protected $questionObject;
	protected $root;
	protected $mHandler;

	function __construct()
	{
		$this->root =& XCube_Root::getSingleton();
		$this->mHandler = xoops_getmodulehandler('form');
	}

	/**
	 * get Instance
	 * @param none
	 * @return object Instance
	 */
	public function &forge()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new Model_General();
		}
		return $instance;
	}

	function Model_General($form_id = 0)
	{
		$this->setAccessLevel();
		$this->editInfo['where'] = 'tab';
		$this->editInfo['form_id'] = $form_id;
		$this->editInfo['new_form'] = 0;
		$this->editInfo['last_tab'] = 'general';
		$this->initGeneralInfo();
		$this->initQuestionInfo();
	}

	function start_editing($newid = 0)
	{
		$this->editInfo['form_id'] = $newid;
		$this->editInfo['last_tab'] = '';
		$this->editInfo['new_form'] = FALSE;
	}

	function start_new()
	{
		$this->initGeneralInfo();
		$this->initQuestionInfo();
		$this->editInfo['where'] = 'tab';
		$this->editInfo['form_id'] = NULL;
		$this->editInfo['response_id'] = '';
		$this->editInfo['new_form'] = TRUE;
		$this->editInfo['last_tab'] = '';
	}

	function isUpdated()
	{
		return $this->editInfo['update'];
	}

	function initQuestionInfo()
	{
		$this->editInfo['curr_qNumber'] = 1;
		$this->editInfo['update'] = 0;
	}

	function initGeneralInfo()
	{
		$this->generalInfo['name'] = NULL;
		$this->generalInfo['title'] = NULL;
		$this->generalInfo['subtitle'] = NULL;
		$this->generalInfo['info'] = NULL;
		$this->generalInfo['expired'] = NULL;
		$this->generalInfo['published'] = NULL;
		$this->generalInfo['thanks_page'] = NULL;
		$this->generalInfo['thank_head'] = NULL;
		$this->generalInfo['thank_body'] = NULL;
		$this->generalInfo['email'] = NULL;
		$this->generalInfo['from_option'] = NULL;
		$this->generalInfo['response_id'] = NULL;
		$this->generalInfo['published_hh'] = "00";
		$this->generalInfo['published_mm'] = "00";
		$this->generalInfo['expired_hh'] = "00";
		$this->generalInfo['expired_mm'] = "00";
	}

	function setGeneralInfo($name, $value)
	{
		$this->generalInfo[$name] = $value;
	}

	public function &get($form_id)
	{
		$this->formObject = $this->mHandler->get($form_id);
		return $this->formObject;
	}

	private function &getFormId()
	{
		return $this->form_id;
	}

	private function &_updateForm()
	{
		if ($this->generalInfo['form_id']) {
			$this->formObject = $this->mHandler->get($this->generalInfo['form_id']);
			$getId = FALSE;
		} else {
			$this->formObject = $this->mHandler->create();
			$this->formObject->set('name', base64_encode(time()));
			$this->formObject->set('title', _MB_LIST_TITLE . date('Y-m-d'));
			$getId = TRUE;
		}
		foreach ($this->generalInfo as $key => $val) {
			if ($key == "form_id") $key = "id";
			$this->formObject->set($key, $val);
		}
		$this->mHandler->insert($this->formObject, TRUE);
		if ($getId) {
			$this->form_id = $this->mHandler->db->getInsertId();
		}
		return $this->formObject;
	}

	public function &addNew(){
		$this->generalInfo = array();
		$this->_updateForm();
		return $this->form_id;
	}

	public function &getFormObject($form_id = NULL)
	{
		$this->mHandler = xoops_getmodulehandler('form');
		if ($form_id) {
			$this->formObject = $this->mHandler->get($form_id);
		} else {
			$this->formObject = $this->mHandler->create();
		}
		return $this->formObject;
	}

	function &setPost()
	{
		$fields = array(
			'form_id', 'name', 'owner', 'realm', 'respondents', 'public', 'status', 'title', 'email', 'form_option', 'subtitle', 'info',
			'theme', 'thanks_page', 'thank_head', 'thank_body',
			'changed', 'published', 'expired', 'response_id'
		);
		foreach ($fields as $f) {
			if (isset($_POST[$f])) {
				if ($f== 'published' || $f=='expired'){
					$this->generalInfo[$f] =strtotime($this->root->mContext->mRequest->getRequest($f));
				}else{
					$this->generalInfo[$f] = $this->root->mContext->mRequest->getRequest($f);
				}
			}
		}
		$this->_updateForm();
		return $this->formObject;
	}

	function post2question($clear = 0)
	{
		global $_POST;
		$myrow = array();
		if ($clear == 0) {
			if (isset($_POST["name"])) $myrow["name"] = "'" . addslashes($_POST["name"]) . "'";
			if (isset($_POST["type_id"])) $myrow["type_id"] = "'" . addslashes($_POST["type_id"]) . "'";
			if (isset($_POST["length"])) $myrow["length"] = "'" . addslashes($_POST["length"]) . "'";
			if (isset($_POST["precise"])) $myrow["precise"] = "'" . addslashes($_POST["precise"]) . "'";
			if (isset($_POST["required"])) $myrow["required"] = "'" . addslashes($_POST["required"]) . "'";
			if (isset($_POST["content"])) $myrow["content"] = "'" . addslashes($_POST["content"]) . "'";
		} else {
			if (isset($_POST["name"])) $myrow["name"] = $_POST["name"] = NULL;
			if (isset($_POST["type_id"])) $myrow["type_id"] = $_POST["type_id"] = NULL;
			if (isset($_POST["length"])) $myrow["length"] = $_POST["length"] = NULL;
			if (isset($_POST["precise"])) $myrow["precise"] = $_POST["precise"] = NULL;
			if (isset($_POST["required"])) $myrow["required"] = $_POST["required"] = NULL;
			if (isset($_POST["content"])) $myrow["content"] = $_POST["content"] = NULL;
		}
		return $myrow;
	}

	function exsistQuestion($edit_qid)
	{
		global $xoopsDB;
		$sql = "SELECT count(*) FROM " . TABLE_QUESTION . " WHERE id='${edit_qid}'";

		$result = $xoopsDB->query($sql);
		list($cnt) = $xoopsDB->fetchRow($result);
		return $cnt;
	}

	function _setDatepicker()
	{
		$year_s = date('Y');
		$headerScript = XCube_Root::getSingleton()->mContext->getAttribute('headerScript');
		$headerScript->addScript('
		$(".datepicker").each(function(){
			$(this).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "' . _JSDATEPICKSTRING . '",
				yearRange: "' . $year_s . ':+5",
			    showButtonPanel: true,
			    beforeShow: function( input ) {
			        setTimeout(function() {
			            var buttonPane = $( input ).datepicker( "widget" ).find( ".ui-datepicker-buttonpane" );

			      $("<button type=\"button\" class=\"ui-datepicker-clean ui-state-default ui-priority-primary ui-corner-all\">Clear</button>").appendTo(buttonPane).click(function(ev) {
			      $.datepicker._clearDate(input);
			      }) ;
			    }, 1 );
			},
			onChangeMonthYear: function( year,month,inst ) {
			        setTimeout(function() {
			        var buttonPane = $( inst ).datepicker( "widget" ).find( ".ui-datepicker-buttonpane" );

			      $("<button type=\"button\" class=\"ui-datepicker-clean ui-state-default ui-priority-primary ui-corner-all\">Clear</button>").appendTo(buttonPane).click(function(ev) {
			      $.datepicker._clearDate(inst.input);
			      }) ;
			        }, 1 );
			    }
			});
		});');
	}

	function isdate($str)
	{
		$format = "c";
		$unixTime = strtotime($str);
		$checkDate = date($format, $unixTime);
		$checkDate = substr($checkDate, 0, 10) . " " . substr($checkDate, 11, 5);
		if ($checkDate == $str || $str == "0000-00-00 00:00") {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function setStatus($form_id, $status)
	{
		$defStatus = "STATUS_" . strtoupper($status);
		echo $defStatus, $$defStatus;
		$this->formObject = $this->mHandler->get($form_id);
		$this->formObject->set('status', constant($defStatus));
		$this->mHandler->insert($this->formObject, TRUE);
	}

}
