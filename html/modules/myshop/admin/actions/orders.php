<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */


if(!defined("MYSHOP_ADMIN")) exit();
switch($action) {
	case 'default':	
        xoops_cp_header();
        myshop_adminMenu(6);
		myshop_utils::htitle(_MI_MYSHOP_ADMENU5, 4);

		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
		$filter3 = 0;
		if(isset($_POST['filter3'])) {
			$filter3 = intval($_POST['filter3']);
		} elseif(isset($_SESSION['filter3'])) {
			$filter3 = intval($_SESSION['filter3']);
		} else {
			$filter3 = 1;
		}
		$_SESSION['filter3'] = $filter3;
		$selected = array('','','','','','');
		$conditions = array(MYSHOP_STATE_NOINFORMATION, MYSHOP_STATE_VALIDATED, MYSHOP_STATE_PENDING, MYSHOP_STATE_FAILED, MYSHOP_STATE_CANCELED, MYSHOP_STATE_FRAUD);
		$selected[$filter3] = " selected='selected'";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('cmd_id', 0, '<>'));
		$criteria->add(new Criteria('cmd_state', $conditions[$filter3], '='));
		$itemsCount = $h_myshop_commands->getCount($criteria);	
		if($itemsCount > $limit) {
			$pagenav = new XoopsPageNav( $itemsCount, $limit, $start, 'start', 'op=commands');
		}
		$criteria->setSort('cmd_date');
		$criteria->setOrder('DESC');
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$orders = $h_myshop_commands->getObjects($criteria);
		$class = '';
		echo "<table class='outer'>";
		$form ="<form method='post' name='frmfilter' id='frmfilter' action='$baseurl'>". _AM_MYSHOP_LIMIT_TO." <select name='filter3' id='filter3'><option value='0'".$selected[0].">"._MYSHOP_CMD_STATE1."</option><option value='1'".$selected[1].">"._MYSHOP_CMD_STATE2."</option><option value='2'".$selected[2].">"._MYSHOP_CMD_STATE3."</option><option value='3'".$selected[3].">"._MYSHOP_CMD_STATE4."</option><option value='4'".$selected[4].">"._MYSHOP_CMD_STATE5."</option><option value='5'".$selected[5].">"._MYSHOP_CMD_STATE6."</option></select> <input type='hidden' name='op' id='op' value='orders' /><input type='submit' name='btnfilter' id='btnfilter' value='"._AM_MYSHOP_FILTER."' /></form>";
		$confValidateOrder = myshop_utils::javascriptLinkConfirm(_AM_MYSHOP_CONF_VALIDATE);
		echo "<tr><td colspan='2' align='left'>";
		if(isset($pagenav) && is_object($pagenav)) {
			echo $pagenav->renderNav();
		} else {
			echo '&nbsp;';
		}
		$exportFormats = glob(MYSHOP_PATH.'admin/exports/*.php');
		$formats = array();
		foreach($exportFormats as $format) {
			if(strstr($format, 'export.php') === false) {
				$exportName = basename(str_replace('.php', '', $format));
				$formats[] = '<option value="'.$exportName.'">'.$exportName.'</option>';
			}
		}

		echo "</td><td><form method='post' action='$baseurl' name='frmexport' id='frmexport'>"._AM_MYSHOP_CSV_EXPORT."<input type='hidden' name='op' id='op' value='orders' /><input type='hidden' name='action' id='action' value='export' /><input type='hidden' name='cmdtype' id='cmdtype' value='$filter3' /><select name='exportfilter' id='exportfilter' size='1'>".implode("\n", $formats)."</select> <input type='submit' name='btngoexport' id='btngoexport' value='"._AM_MYSHOP_OK."' /></form></td><td align='right' colspan='2'>".$form."</td></tr>\n";
		echo "<tr><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._AM_MYSHOP_DATE."</th><th align='center'>"._AM_MYSHOP_CLIENT."</th><th align='center'>"._AM_MYSHOP_TOTAL_SHIPP."</th><th align='center'>"._AM_MYSHOP_ACTION."</th></tr>";
		foreach ($orders as $item) {
			$id = $item->getVar('cmd_id');
			$class = ($class == 'even') ? 'odd' : 'even';
			$date = formatTimestamp(strtotime($item->getVar('cmd_date')), 's');
			$actions = array();
			$actions[] = "<a target='_blank' href='".MYSHOP_URL."invoice.php?id=".$id."' title='"._MYSHOP_DETAILS."'>".$icones['details'].'</a>';
			$actions[] = "<a href='$baseurl?op=orders&action=delete&id=".$id."' title='"._MYSHOP_DELETE."'".$conf_msg.">".$icones['delete'].'</a>';
			$actions[] = "<a href='$baseurl?op=orders&action=validate&id=".$id."' ".$confValidateOrder." title='"._MYSHOP_VALIDATE_COMMAND."'>".$icones['ok'].'</a>';
			echo "<tr class='".$class."'>\n";
			echo "<td align='right'>".$id."</td><td align='center'>".$date."</td><td align='center'>".$item->getVar('cmd_lastname').' '.$item->getVar('cmd_firstname')."</td><td align='center'>".$myshop_Currency->amountForDisplay($item->getVar('cmd_total')).' / '.$myshop_Currency->amountForDisplay($item->getVar('cmd_shipping'))."</td><td align='center'>".implode(' ', $actions)."</td>\n";
			echo "<tr>\n";
		}
		echo '</table>';
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<div align='right'>".$pagenav->renderNav()."</div>";
		}
		break;

	case 'delete':	
		xoops_cp_header();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'orders';
		$item = $h_myshop_commands->get($id);
		if(is_object($item)) {
			$res = $h_myshop_commands->delete($item, true);
			if($res) {
				$criteria = new Criteria('caddy_cmd_id', $id, '=');
				$h_myshop_caddy->deleteAll($criteria);
				myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect,2);
			} else {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect,5);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect,5);
		}
		break;

	case 'validate':	
		xoops_cp_header();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'orders';
		$item = $h_myshop_commands->get($id);
		if(is_object($item)) {
			$res = $h_myshop_commands->validateOrder($item);
			if($res) {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect, 2);
			} else {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect, 5);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect, 5);
		}
		break;

	case 'export':	
        xoops_cp_header();
        myshop_adminMenu(6);
		myshop_utils::htitle(_MI_MYSHOP_ADMENU5, 4);
		$orderType = intval($_POST['cmdtype']);
		$exportFilter = $_POST['exportfilter'];
		$exportFilename = MYSHOP_PATH.'admin/exports/'.$exportFilter.'.php';
		if(file_exists($exportFilename)) {
			require_once MYSHOP_PATH.'admin/exports/export.php';
			require_once $exportFilename;
			$className = 'myshop_'.$exportFilter.'_export';
			if(class_exists($className)) {
				$export = new $className();
				$export->setOrderType($orderType);
				$result = $export->export();
				if($result === true) {
					echo "<a href='".$export->getDownloadUrl()."'>"._AM_MYSHOP_EXPORT_READY.'</a>';
				}
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_11);
		}
		break;

}
?>