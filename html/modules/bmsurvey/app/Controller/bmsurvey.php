<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/17
 * Time: 10:28
 * To change this template use File | Settings | File Templates.
 */

require_once _MY_MODULE_PATH . 'app/View/view.php';
require_once _MY_MODULE_PATH . 'app/Model/Status.class.php';
require_once _MY_MODULE_PATH . 'app/Model/FormTable.class.php';

class Controller_Bmsurvey extends AbstractAction {
	protected $manageObjects;
	protected $formObjects;

	private function _SetControlParameter(){
		$sortby = xoops_getrequest('sortby');
		$order = xoops_getrequest('order');
		$start = xoops_getrequest('start');
		$sid = xoops_getrequest('sid');
		// set from session or default
		$this->manageObjects['sortby']    = isset($_SESSION['bmsurvey']['sortby'   ]) ? $_SESSION['bmsurvey']['sortby'   ] : $sortby;
		$this->manageObjects['order']     = isset($_SESSION['bmsurvey']['order'    ]) ? $_SESSION['bmsurvey']['order'    ] : $order;
		$this->manageObjects['status']    = isset($_SESSION['bmsurvey']['status'   ]) ? $_SESSION['bmsurvey']['status'   ] : "0,1,2,4,8";
		$this->manageObjects['start']     = $start;
		$this->manageObjects['sid']       = $sid;
		// get from usesr
		$this->manageObjects['altorder'] = ($this->manageObjects['order']=='asc') ? 'desc' : 'asc';
		if(!$this->root->mContext->mXoopsUser){
			$this->manageObjects['status'] = 1; // For Guest
		}else{
			if ($this->root->mContext->mXoopsUser->isadmin()){
				$this->manageObjects['manage_on'] = true;
			}
			if (isset($_GET['status'])){
				if( is_array($_GET['status'])){
					$this->manageObjects['status'] = implode($_GET['status'],",");
				}else{
					$this->manageObjects['status'] = isset($_GET['status']) ? htmlspecialchars ( $_GET['status'], ENT_QUOTES ) : '1';
				}
			}
		}
		// stock to session
		$_SESSION['bmsurvey'] = array(
			'sortby' => $this->manageObjects['sortby'],
			'order' => $this->manageObjects['order'],
			'status' => $this->manageObjects['status']
		);
	}
	private function _setTemplateDefault(&$status){
		$this->tpl_vars = array(
			'content' => array(),
			'langs' => array(
				'pagetitle' => BMSURVEY_INDEX_PAGETITLE,
				'pagesubtitle' => $status->statusTitle,
				'form_title' => _MB_LIST_TITLE,
				'form_subtitle' => _MB_LIST_SUBTITLE,
				'form_name' => _MB_LIST_NAME,
				'form_owner' => _MB_LIST_OWNER,
				'form_submitted' => _MB_LIST_SUBMITTED,
				'col_data' => _MB_LIST_COL_DATA,
				'col_results' => _MB_LIST_COL_RESULTS,
				'col_results_analyze' => _MB_LIST_COL_RESULTS_ANALYZE,
				'col_results_respondents' => _MB_LIST_COL_RESULTS_RESPONDENTS,
				'col_results_spreadsheet' => _MB_LIST_COL_RESULTS_SPREADSHEET,
				'col_results_cross' => _MB_LIST_COL_RESULTS_CROSS,
				'col_results_download' => _MB_LIST_COL_RESULTS_DOWNLOAD,
				'col_control' => _MB_LIST_COL_CONTROL,
				'col_control_modify' => _MB_LIST_COL_CONTROL_MODIFY,
				'col_control_status' => _MB_LIST_COL_CONTROL_STATUS,
				'col_control_access' => _MB_LIST_COL_CONTROL_ACCESS,
				'col_control_access_public' => _MB_LIST_COL_CONTROL_ACCESS_PUBLIC,
				'col_control_access_limited' => _MB_LIST_COL_CONTROL_ACCESS_LIMITED,
				'col_control_access_2public' => _MB_LIST_COL_CONTROL_ACCESS_2PUBLIC,
				'col_control_access_2limited' => _MB_LIST_COL_CONTROL_ACCESS_2LIMITED,
				'col_control_access_setperm' => _MB_LIST_COL_CONTROL_ACCESS_SETPERM,
				'col_control_access' => _MB_LIST_COL_CONTROL_ACCESS,
				'col_control_copy' => _MB_LIST_COL_CONTROL_COPY,
				'col_control_edit' => _MB_LIST_COL_CONTROL_EDIT
			),
			'config' => array(
				'listview' => 'simple',
				'formManager'=>$status->formManager,
				'is_mod_admin'=>$status->is_mod_admin
			)
		);
	}
	private function _getFormData($manage_on, $sid, $start, $sortby, $order, $status){
		$formTable = new FormTable($sid);
		$formTable->setPageStart($start);
		$this->formObjects = array();
		if (!$sid){
			if($manage_on){
				//$uid = $fmxStatus->is_mod_admin ? 0 : $xoopsUser->uid();
				$this->formObjects['content']['forms'] = $formTable->get_form_list($sid, FALSE, $sortby, $order, $status);
				$this->formObjects['content']['pagenavi'] = $formTable->pageNavi(10);
			}else{
				$this->formObjects['content']['forms'] = $formTable->get_form_list($sid, FALSE, $sortby, $order, $status);
				$this->formObjects['content']['pagenavi'] = $formTable->pageNavi(10);
			}
			$this->formObjects['content']['sortnavi'] = $formTable->sortNavi();
			$xoopsOption['template_main'] = 'bmsurvey_index.html';
		}else{
			$this->formObjects['content']['form'] = $formTable->formInfo;
			$xoopsOption['template_main'] = 'bmsurvey_controlpanel.html';
		}
	}
	public function action_index(){
		$this->template = 'bmsurvey_index.html';
		$this->_setControlParameter();
		$status = new bmsurveyStatus();
		$this->_setTemplateDefault($status);
		$this->_getFormData(
			$this->manageObjects['manage_on'],
			$this->manageObjects['sid'],
			$this->manageObjects['start'],
			$this->manageObjects['sortby'],
			$this->manageObjects['order'],
			$this->manageObjects['status']
		);
	}
	public function action_view(){
		$view = new View($this->root);
		$view->setTemplate($this->template);
		$view->set('manage_on', $this->manageObjects['manage_on']);
		$view->set('order', $this->manageObjects['altorder']);
		$view->set('bmsurvey', $this->formObjects);
	}
}