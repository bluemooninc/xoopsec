<?php
class Model_Question
{
	protected $rows = array();
	protected $num_sections = 1;
	protected $totalRow;
	protected $questions_option;
	protected $has_choices;
	protected $questionObjects;
	protected $currentObject;
	protected $root;
	protected $mHandler;
	protected $choice;

	function __construct()
	{
		$this->root = XCube_Root::getSingleton();
		$this->mHandler = xoops_getmodulehandler('question');
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
			$instance = new Model_Question();
		}
		return $instance;
	}

	function &getObjectsOnForm($form_id)
	{
		$this->mHandler = xoops_getmodulehandler('question');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('form_id', $form_id));
		$criteria->add(new Criteria('deleted', 'N'));
		$criteria->add(new Criteria('type_id', '99', '!='));
		$criteria->addSort('position');
		$this->questionObjects = $this->mHandler->getObjects($criteria);
		$this->totalRow = $this->mHandler->getCount($criteria);
		return $this->questionObjects;
	}

	function is_rows()
	{
		return count($this->rows);
	}

	/* {{{ proto array esp_type_has_choices()
   Returns an associative array of bools indicating if each
   question type has answer choices. */
	function esp_type_has_choices()
	{
		global $xoopsDB;
		$has_choices = array();
		$sql = "SELECT id, has_choices FROM " . TABLE_QUESTION_TYPE . " ORDER BY id";
		$result = $xoopsDB->query($sql);
		while (list($tid, $answ) = $xoopsDB->fetchRow($result)) {
			if ($answ == 'Y')
				$has_choices[$tid] = 1;
			else
				$has_choices[$tid] = 0;
		}

		return ($has_choices);
	}

	function questionHasChoices($type_id)
	{
		global $xoopsDB;
		$sql = "SELECT has_choices FROM " . TABLE_QUESTION_TYPE . " WHERE id='" . $type_id . "'";
		list($this->has_choices) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	}
	public function addChoice($question_id){
		$choiceHandler = xoops_getmodulehandler('question_choice');
		$choiceObject = $choiceHandler->create();
		$choiceObject->set('question_id',$question_id);
		$choiceHandler->insert($choiceObject,true);
	}
	public function &getChoice($question_id){
		$choiceHandler = xoops_getmodulehandler('question_choice');
		$criteria = new Criteria('question_id',$question_id);
		return $choiceHandler->getObjects($criteria);
	}
	function questionChoice($updated, $curr_qNumber, $edit_qid)
	{
		global $xoopsDB;
		if ($edit_qid) {
			$sql = "SELECT id,content FROM " . TABLE_QUESTION_CHOICE . " WHERE question_id='${edit_qid}' ORDER BY id";
			$result = $xoopsDB->query($sql);
			$c = $xoopsDB->getRowsNum($result);
		} else {
			if (isset($_POST['num_choices']))
				$c = intval($_POST['num_choices']);
			else
				$c = $GLOBALS['FMXCONFIG']['default_num_choices'];
		}
		if (isset($_POST['extra_choices']))
			$num_choices = max($c, $_POST['num_choices']) + 1;
		else
			$num_choices = $c;
		$this->questions_option['num_choices'] = $num_choices;
		$this->questions_option['choices'] = array();
		for ($i = 1; $i < $num_choices + 1; ++$i) {
			if ($edit_qid) {
				list($choice_id, $choice_content) = $xoopsDB->fetchRow($result);
			} else {
				if ($curr_qNumber && isset($_POST["choice_id_$i"])) {
					$choice_id = intval($_POST["choice_id_$i"]);
				} else {
					$choice_id = 0;
				}
				if (isset($_POST["choice_content_$i"]))
					$choice_content = htmlspecialchars($_POST["choice_content_$i"], ENT_QUOTES);
			}
			$this->questions_option['choices'][] = array(
				"numbered" => $i,
				"choice_id" => $choice_id,
				"name" => "choice_content_" . $i,
				"value" => isset($choice_content) ? $choice_content : ''
			);
		}
	}

	function cnv_mbstr($str, $encto)
	{
		// _CHARSET is XOOPS defined char setting
		if (extension_loaded('mbstring')) {
			return mb_convert_encoding($str, $encto, _CHARSET);
		} else {
			return $str;
		}
	}
	public function deleteChoice($id){
		$choiceHandler = xoops_getmodulehandler('question_choice');
		$choiceObject = $choiceHandler->get($id);
		$choiceHandler->delete($choiceObject,true);
		return $choiceObject->getVar('question_id');
	}
	public function add($form_id){
		$criteria = new Criteria("form_id",$form_id);
		$currentObject = $this->mHandler->create();
		$currentObject->set('form_id',$form_id);
		$currentObject->set("position",$this->mHandler->getCount($criteria));
		$this->mHandler->insert($currentObject,true);
		return $this->mHandler->db->getInsertId();
	}
	public function delete($question_id){
		$choiceHandler = xoops_getmodulehandler('question_choice');
		$criteria = new Criteria('question_id',$question_id);
		$choiceHandler->deleteAll($criteria,true);
		$currentObject = $this->mHandler->get($question_id);
		$this->mHandler->delete($currentObject,true);
		return $currentObject->getVar('form_id');
	}
	public function deleteAll($form_id,$force){
		$criteria = new Criteria('form_id',$form_id);
		$this->mHandler->deleteAll($criteria,$force);
	}
	public function position($question_id,$add){
		$this->currentObject = $this->mHandler->get($question_id);
		$position = $this->currentObject->getVar('position');
		$form_id = $this->currentObject->getVar('form_id');
		$criteria = new Criteria('form_id',$form_id);
		if ( $add>0 && $this->mHandler->getCount($criteria)>$position){
			$position += $add;
		}elseif ( $add<0 && $position>0) {
			$position += $add;
		}
		$this->currentObject->set('position',$position);
		$this->mHandler->insert($this->currentObject,true);
		return $question_id;
	}

	public function &get($getQuestionId){
		$this->currentObject = $this->mHandler->get($getQuestionId);
		return $this->currentObject;
	}
	public function form_id(){
		return $this->currentObject->getVar('form_id');
	}

	private function &_updateQuestion(){
		if ($this->question['id']){
			$questionObject = $this->mHandler->get($this->question['id']);
		}else{
			$questionObject =$this->mHandler->create();
		}
		foreach($this->question as $key=>$val){
			$questionObject->set($key,$val);
		}
		$this->mHandler->insert($questionObject);
		return $questionObject;
	}
	private function _updateChoice($question_id){
		$choiceHandler = xoops_getmodulehandler('question_choice');
		$criteria = new Criteria('question_id',$question_id);
		$choiceObjects = $choiceHandler->getObjects($criteria);
		foreach($choiceObjects as $choiceObject){
			$cid = 'choiceId_'.$choiceObject->getVar('id');
			if (isset($_POST[$cid])) {
				$choiceObject->set('value', $this->root->mContext->mRequest->getRequest($cid));
			}
			$choiceHandler->insert($choiceObject);
		}
	}
	public function setPost()
	{
		$ret = false;
		$tab = $this->root->mContext->mRequest->getRequest('tab');
		$getQuestionId = NULL;
		$this->choice = array();
		if ($tab == 'questions') {
			$fields = array('id', 'form_id', 'name', 'type_id', 'result_id', 'length', 'precise', 'position', 'content', 'required', 'deleted', 'public');
			foreach ($fields as $f) {
				if (isset($_POST[$f])) {
					$this->question[$f] = $this->root->mContext->mRequest->getRequest($f);
				}
			}
			if (!empty($this->question['type_id']) && !empty($this->question['content'])) {
				$this->_updateQuestion();
				$ret = true;
			}
			$this->_updateChoice($this->question['id']);
		}
		return $ret;
	}

}

?>