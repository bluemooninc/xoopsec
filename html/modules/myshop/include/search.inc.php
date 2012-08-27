<?php

function myshop_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB;
	require XOOPS_ROOT_PATH . '/modules/myshop/include/common.php';
	require_once XOOPS_ROOT_PATH . '/modules/myshop/class/myshop_products.php';

	// Products Search
	$sql = 'SELECT product_id, product_title, product_submitted, product_submitter FROM '.$xoopsDB->prefix('myshop_products').' WHERE (product_online = 1';
	if(myshop_utils::getModuleOption('show_unpublished') == 0) {	
		$sql .= ' AND product_submitted <= '.time();
	}
	if(myshop_utils::getModuleOption('nostock_display') == 0) {	
		$sql .= ' AND product_stock > 0';
	}
	if ( $userid != 0 ) {
		$sql .= '  AND product_submitter = '.$userid;
	}
	$sql .= ') ';

	$tmpObject = new myshop_products();
	$datas = $tmpObject->getVars();
	$tblFields = array();
	$cnt = 0;
	foreach($datas as $key => $value) {
		if($value['data_type'] == XOBJ_DTYPE_TXTBOX || $value['data_type'] == XOBJ_DTYPE_TXTAREA) {
			if($cnt == 0) {
				$tblFields[] = $key;
			} else {
				$tblFields[] = ' OR '.$key;
			}
			$cnt++;
		}
	}

	$count = count($queryarray);
	$more = '';
	if( is_array($queryarray) && $count > 0 ) {
		$cnt = 0;
		$sql .= ' AND (';
		$more = ')';
		foreach($queryarray as $oneQuery) {
			$sql .= '(';
			$cond = " LIKE '%".$oneQuery."%' ";
			$sql .= implode($cond, $tblFields).$cond.')';
			$cnt++;
			if($cnt != $count) {
				$sql .= ' '.$andor.' ';
			}
		}
	}
	$sql .= $more.' ORDER BY product_submitted DESC';
	$i = 0;
	$ret = array();
	$myts =& MyTextSanitizer::getInstance();
	$result = $xoopsDB->query($sql,$limit,$offset);
 	while ($myrow = $xoopsDB->fetchArray($result)) {
		$ret[$i]['image'] = 'images/product.png';
		$ret[$i]['link'] = "product.php?product_id=".$myrow['product_id'];
		$ret[$i]['title'] = $myts->htmlSpecialChars($myrow['product_title']);
		$ret[$i]['time'] = $myrow['product_submitted'];
		$ret[$i]['uid'] = $myrow['product_submitter'];
		$i++;
	}
	return $ret;
}
?>
