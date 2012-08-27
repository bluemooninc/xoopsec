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
        
		myshop_adminMenu(0);
		myshop_utils::htitle(_MI_MYSHOP_ADMENU10, 4);
		
		$itemsCount = 5;	
		$cssclass = '';
		if($h_myshop_products->getCount() > 0) {
			echo "<hr /><br />";
			echo "<table>";
			echo "<tr>\n";
			echo "<td valign='top' width='50%' align='center'><b>"._AM_MYSHOP_LAST_ORDERS."</b>";
			$tblTmp = array();
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('cmd_id', 0, '<>'));
			$criteria->setSort('cmd_date');
			$criteria->setOrder('DESC');
			$criteria->setLimit($itemsCount);
			$criteria->setStart(0);
			$tblTmp = $h_myshop_commands->getObjects($criteria);
			echo "<table class='outer'>";
			echo "<tr><th align='center'>"._AM_MYSHOP_DATE."</th><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._MYSHOP_TOTAL."</th></tr>\n";
			foreach($tblTmp as $item) {
				$date = formatTimestamp(strtotime($item->getVar('cmd_date')), 's');
				$cssclass = ($cssclass == 'even') ? 'odd' : 'even';

				echo "<tr class='".$cssclass."'><td align='center'>".$date."</td><td align='center'>".$item->getVar('cmd_id')."</td><td align='right'>".$myshop_Currency->amountForDisplay($item->getVar('cmd_total'))."</td></tr>";
			}
			echo "</table>";

			// Stocks 
			echo "</td><td valign='top' width='50%' align='center'><b>"._MI_MYSHOP_ADMENU9."</b>";
			$tblTmp = array();
			$tblTmp = $h_myshop_products->getLowStocks(0, $itemsCount);
			echo "<table class='outer' style='width:90%'>";
			echo "<tr><th align='center'>"._MYSHOP_TITLE."</th><th align='center'>"._MYSHOP_STOCK_QUANTITY."</th></tr>\n";
			foreach($tblTmp as $item) {
				$cssclass = ($cssclass == 'even') ? 'odd' : 'even';
				$link = "<a href='".MYSHOP_URL."product.php?product_id=".$item->getVar('product_id')."'>".$item->getVar('product_title').'</a>';
				echo "<tr class='".$cssclass."'><td>".$link."</td><td align='right'>".$item->getVar('product_stock')."</td></tr>";
			}
			echo "</table>";
			echo "</td></tr>";

			echo "<tr><td colspan='2'>&nbsp;</td></tr>";

			// Most Sold Products
			echo "<td valign='top' width='50%' align='center'><b>"._MI_MYSHOP_BNAME4."</b>";
			if($h_myshop_commands->getCount() > 0) {
				$tblTmp = $tblTmp2 = array();
				$tblTmp2 = $h_myshop_caddy->getMostSoldProducts(0, $itemsCount, 0, true);

				$tblTmp = $h_myshop_products->getObjects(new Criteria('product_id', '('.implode(',', array_keys($tblTmp2)).')', 'IN'), true);
			echo "<table class='outer'>";
				echo "<tr><th align='center'>"._MYSHOP_TITLE."</th><th align='center'>"._MYSHOP_QUANTITY."</th></tr>\n";
				foreach($tblTmp2 as $key => $value) {
					$item = $tblTmp[$key];
					$link = "<a href='".MYSHOP_URL."product.php?product_id=".$item->getVar('product_id')."'>".$item->getVar('product_title').'</a>';
					echo "<tr><td>".$link."</td><td align='right'>".$value."</td></tr>";
				}
				echo "</table>";
			}
			// Most Viewed Products
			$tblTmp = array();
			$tblTmp = $h_myshop_products->getMostViewedProducts(0, $itemsCount);
			echo "</td><td valign='top' width='50%' align='center'><b>"._MI_MYSHOP_BNAME2."</b>";
			echo "<table class='outer' style='width:90%'>";
			echo "<tr><th align='center'>"._MYSHOP_TITLE."</th><th align='center'>"._MYSHOP_HITS."</th></tr>\n";
			foreach($tblTmp as $item) {
				$link = "<a href='".MYSHOP_URL."product.php?product_id=".$item->getVar('product_id')."'>".$item->getVar('product_title').'</a>';
				echo "<tr><td>".$link."</td><td align='right'>".$item->getVar('product_hits')."</td></tr>";
			}
			echo "</table>";
			echo "</td></tr>";

			echo "<tr><td colspan='2'>&nbsp;</td></tr>";

			// Last Votes
			echo "</td><td colspan='2' valign='top' align='center'><b>"._AM_MYSHOP_LAST_VOTES."</b>";
			if($h_myshop_votedata->getCount() > 0) {
				$tblTmp = $tblTmp2 = $tblTmp3 = array();
				$tblTmp3 = $h_myshop_votedata->getLastVotes(0, $itemsCount);
				foreach($tblTmp3 as $item) {
					$tblTmp2[] = $item->getVar('vote_product_id');
				}
				$tblTmp = $h_myshop_products->getObjects(new Criteria('product_id', '('.implode(',', $tblTmp2).')', 'IN'), true);
				echo "<table border='0' cellpadding='2' cellspacing='2' width='100%'>";
				echo "<tr><th align='center'>"._MYSHOP_TITLE."</th><th align='center'>"._AM_MYSHOP_DATE."</th><th colspan='2' align='center'>"._AM_MYSHOP_NOTE."</th></tr>";
				foreach($tblTmp3 as $vote) {
					$item = $tblTmp[$vote->getVar('vote_product_id')];
					$link = "<a href='".MYSHOP_URL."product.php?product_id=".$item->getVar('product_id')."'>".$item->getVar('product_title').'</a>';
					$action_delete = "<a href='$baseurl?op=dashboard&action=deleterating&id=".$vote->getVar('vote_ratingid')."' title='"._MYSHOP_DELETE."'".$conf_msg.">".$icones['delete'].'</a>';
					echo "<tr><td>".$link."</td><td align='center'>".formatTimestamp($vote->getVar('vote_ratingtimestamp'), 's')."</td><td align='right'>".$vote->getVar('vote_rating')."</td><td>".$action_delete."</td></tr>";
				}
				echo "</table>\n";
			}
			echo "</td></tr>\n";
			echo "</table>\n";
		}
		break;


	case 'deleterating':	
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'dashboard';
		$item = $h_myshop_votedata->get($id);
		if(is_object($item)) {
			$res = $h_myshop_votedata->delete($item, true);
			if($res) {
				$product_id = $item->getVar('vote_product_id');
				$product = null;
				$product = $h_myshop_products->get($product_id);
				if(is_object($product)) {	// Update Product's rating
					$totalVotes = $sumRating = $ret = $finalrating = 0;
					$ret = $h_myshop_votedata->getCountRecordSumRating($product->getVar('product_id'), $totalVotes, $sumRating);
					if($totalVotes > 0 ) {
						$finalrating = $sumRating / $totalVotes;
						$finalrating = number_format($finalrating, 4);
					}
					$h_myshop_products->updateRating($product_id, $finalrating, $totalVotes);
				}
				myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect,2);
			} else {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect,5);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect,5);
		}
		break;
}
?>