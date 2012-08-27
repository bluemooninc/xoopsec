<?php

/**
 * Advanced Search
 */
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$sform = new XoopsThemeForm(myshop_utils::getModuleName().' - '._MYSHOP_SEARCHFOR, 'productsSearchForm', MYSHOP_URL.'search.php','post');
$sform->addElement(new XoopsFormText(_MYSHOP_TEXT,'product_text',50,255, ''), false);
$sform->addElement(new XoopsFormSelectMatchOption(_MYSHOP_TYPE, 'search_type', 3), false);


// Select categories
$categorySelect = new XoopsFormSelect(_MYSHOP_CATEGORY, 'product_category', 0);
$mytree = new Myshop_XoopsObjectTree($categories, 'cat_cid', 'cat_pid');
$select_categ = $mytree->makeSelBox('cat_pid', 'cat_title', '-');
$select_categ = str_replace("<select id='cat_pid[]' name='cat_pid[]' size='5' multiple='multipe'>", '', $select_categ);
$select_categ = str_replace('</select>', '', $select_categ);
$select_categ = explode("</option>",$select_categ);
$tblTmp = array();
//$tblTmp[0] = _MYSHOP_ALL_CATEGORIES;
foreach($select_categ as $item) {
	$array = array();
	// TODO : Simplify
	preg_match("/<option value=\'([0-9]*)\'>/", $item, $array);	// Get each category ID
	$label = preg_replace("/<option value=\'([0-9]*)\'>/", '', $item);	// Keep label only
	if(isset($array[1])) {
		$catId = intval($array[1]);
		$tblTmp[$catId] = $label;
	}
}
$categorySelect->addOptionArray($tblTmp);
$sform->addElement($categorySelect, false);


// Select manufacturers
$authorSelect = new XoopsFormSelect(_MYSHOP_MANUFACTURER, 'product_manufacturers', 0, 5, true);
$tblTmp = array();
$tblTmp[0] = _MYSHOP_ALL_MANUFACTURERS;
foreach($manufacturers as $item) {
	$tblTmp[$item->getVar('manu_id')] = $item->getVar('manu_commercialname').' '.$item->getVar('manu_name');
}
$authorSelect->addOptionArray($tblTmp);
$sform->addElement($authorSelect, false);


// Select stores
$storeSelect = new XoopsFormSelect(_MYSHOP_STORE, 'product_stores', 0, 1, false);
$tblTmp = array();
$tblTmp[0] = _MYSHOP_ALL_STORES;


foreach($stores as $item) {
	$tblTmp[$item->getVar('store_id')] = $item->getVar('store_name');
}
$storeSelect->addOptionArray($tblTmp);
$sform->addElement($storeSelect, false);


$sform->addElement(new XoopsFormHidden('op', 'go'));

$button_tray = new XoopsFormElementTray('' ,'');
$submit_btn = new XoopsFormButton('', 'post', _SUBMIT, 'submit');
$button_tray->addElement($submit_btn);
$sform->addElement($button_tray);
?>