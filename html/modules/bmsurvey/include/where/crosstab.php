<?php
// $Id: crosstab.php,v 2.0 2009/02/10 09:00:00 makinosuke Exp $
//  ------------------------------------------------------------------------ //
//                Bluemoon.Multi-Form                                      //
//                    Copyright (c) 2005 Yoshi.Sakai @ Bluemoon inc.         //
//                       <http://www.bluemooninc.biz/>                       //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Original by $Id: crosstab.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $
$xoopsOption['template_main'] = 'bmsurvey_manage.html';

if($sid){

	$sql = "SELECT R.id FROM ".TABLE_RESPONSE." R WHERE R.form_id='${sid}' AND R.complete='Y'";
    
	/* Count Total Response
	*******************************************************************************************/
    if($result = $xoopsDB->query($sql)){
    	if(($total = $xoopsDB->getRowsNum($result)) > 0){
			$qidc = !empty($_POST['qidc']) ? $_POST['qidc'] : '';
			$qidr = !empty($_POST['qidr']) ? $_POST['qidr'] : '';
			$idpv_qids = is_array($qidc) ? $qidc : array($qidc);
			$dpv_qids = is_array($qidr) ? $qidr : array($qidr);
			if (empty($idpv_qids) || empty($dpv_qids)){
				redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/', 2, _MB_Error_cross-tabulating.' '. _MB_Error_column_and_row);
				exit;
			}
			
			require_once(XOOPS_ROOT_PATH . "/modules/bmsurvey/".'/include/function/form_crosstab.php');
			
			$crosstabs = array();
			foreach($idpv_qids as $idpv_qid){
				foreach($dpv_qids as $dpv_qid){
					if($idpv_qid != $dpv_qid){
						// Get crosstab table. (for detail, please see "form_crosstab.php".)
						$crosstabs[] = get_crosstab($sid, $idpv_qid, $dpv_qid);
					}
				}
			}
			$xoopsTpl->assign('crosstabs', $crosstabs);
			$show_formlist = FALSE;
    	}
		
    }
}

?>
