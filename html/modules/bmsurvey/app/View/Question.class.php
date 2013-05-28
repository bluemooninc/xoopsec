<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/18
 * Time: 11:14
 * To change this template use File | Settings | File Templates.
 */

class View_Question
{
	protected $typeIdArr = array();

	/**
	 * get Instance
	 * @param none
	 * @return object Instance
	 */
	public function &forge()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new View_Question();
		}
		return $instance;
	}

	public function &getQuestionOption(&$formQuestion){
		/*
		 *   extraChoices options add or new
		 */
		$formQuestion->questionHasChoices($editQuestion["type_id"]);
		if( $formQuestion->has_choices=='Y' ){
			$formQuestion->questionChoice($updated,$curr_qNumber,$edit_qid);
			$tpl_vars['content']['currentQuestion']['num_choices'] = $formQuestion->questions_option['num_choices'];
			$tpl_vars['content']['currentQuestion']['choicesInfos'] = $formQuestion->questions_option['choices'];
		}
	}

	private function &_setTypeIdArray(){
		$qTypeHandler = xoops_getmodulehandler('question_type');
		$crireteria = new Criteria('id',99,"!=");
		$qTypeObjects = $qTypeHandler->getObjects($crireteria);
		if ( !defined( BMSURVEY_QTYPE_1) ){
			$lang_typeId = array(
				1   => BMSURVEY_QTYPE_1,
				2   => BMSURVEY_QTYPE_2,
				3   => BMSURVEY_QTYPE_3,
				4   => BMSURVEY_QTYPE_4,
				5   => BMSURVEY_QTYPE_5,
				6   => BMSURVEY_QTYPE_6,
				9   => BMSURVEY_QTYPE_9,
				10  => BMSURVEY_QTYPE_10,
				99  => BMSURVEY_QTYPE_99,
				100 => BMSURVEY_QTYPE_100
			);
		}
		foreach($qTypeObjects as $qTypeObj){
			$id = $qTypeObj->getVar('id');
			$type = $qTypeObj->getVar('type');
			if ( isset( $lang_typeId[$id] ) ){
				$this->typeIdArr[$id] = $lang_typeId[$id];
			}else{
				$this->typeIdArr[$id] = $type;
			}
		}
		return $this->typeIdArr;
	}
	private function &_makeQuestionNav(&$questionObjects,&$currentObject){
		if (!$currentObject) return null;
		$questionNav = array();
		$currentId = $currentObject->getVar('id');
		foreach($questionObjects as $questionObject){
			$questionNav[] = array(
				'id' => $questionObject->getVar('id'),
				'isCurrent' => $questionObject->getVar('id') == $currentId ? 1 : 0,
				'name' => $questionObject->getVar('name'),
				'typeId' => $questionObject->getVar('type_id'),
				'typeName' => isset($this->typeIdArr[$questionObject->getVar('type_id')]) ? $this->typeIdArr[$questionObject->getVar('type_id')] : ''
			);
		}
		return $questionNav;
	}
	public function &generatePreview(&$htmlRender,&$questionObjects){
		$Model_Question = Model_Question::forge();
		$preview = array();
		foreach($questionObjects as $questionObject){
			$choiceObjects = $Model_Question->getChoice( $questionObject->getVar('id') );
			$preview[] = $htmlRender->generateHtml($questionObject,$choiceObjects);
		}
		return $preview;
	}
	public function &setQuestions(&$htmlRender,&$questionObjects,&$currentObject,&$choiceObjects)
	{
		if (!$currentObject) return null;
		$this->_setTypeIdArray();
		$questionNav = $this->_makeQuestionNav($questionObjects,$currentObject);
		return array(
			'id' => $currentObject->getVar('id'),
			'preview' => $this->generatePreview($htmlRender,$questionObjects),
			'currentObject' => $currentObject,
			'edit' => array(
				'type_id' => array(
					'tag' => $htmlRender->mkselect('type_id', self::_setTypeIdArray(), $currentObject->getVar("type_id")),
					'label' => _MB_Type
				),
				'required' => array(
					'tag' => $htmlRender->mkselect("required", array("Y" => _MB_Yes, "N" => _MB_No), $currentObject->getVar("required"), 0),
					'label' => _MB_Required
				),
			),
			'choiceObjects'=>$choiceObjects
		);
	}
}