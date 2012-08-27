<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */


if(!defined("MYSHOP_ADMIN")) exit();
switch($action) {
	case 'default':	
        xoops_cp_header();
        myshop_adminMenu(5);

		$products = $categories = array();

		$categories = $h_myshop_cat->getAllCategories(0, 0, 'cat_title', 'ASC', true);

		$mytree = new XoopsObjectTree($categories, 'cat_cid', 'cat_pid');
		$select_categ = $mytree->makeSelBox('id', 'cat_title');
		$form = "<form method='post' action='$baseurl' name='frmadddproduct' id='frmadddproduct'><input type='hidden' name='op' id='op' value='products' /><input type='hidden' name='action' id='action' value='add' /><input type='submit' name='btngo' id='btngo' value='"._AM_MYSHOP_ADD_ITEM."' /></form>";
		echo $form;
		echo "<br /><form method='get' action='$baseurl' name='frmaddeditproduct' id='frmaddeditproduct'>"._MYSHOP_PRODUCT_ID." <input type='text' name='id' id='id' value='' size='4'/> <input type='hidden' name='op' id='op' value='products' /><input type='radio' name='action' id='action' value='edit' />"._MYSHOP_EDIT." <input type='radio' name='action' id='action' value='confdelete' />"._MYSHOP_DELETE." <input type='submit' name='btngo' id='btngo' value='"._GO."' /></form>";
		myshop_utils::htitle(_MI_MYSHOP_ADMENU4, 4);

		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
		$filter = $filter2 = 0;
		if(isset($_POST['filter2'])) {
			$filter2 = intval($_POST['filter2']);
		} elseif(isset($_SESSION['filter2'])) {
			$filter2 = intval($_SESSION['filter2']);
		}
		$_SESSION['filter2'] = $filter2;
		$selected = array('','','','');
		$selected[$filter2] = " selected='selected'";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('product_id', 0, '<>'));

		$itemsCount = $h_myshop_products->getCount($criteria);	
		if($itemsCount > $limit) {
			require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
			$pagenav = new XoopsPageNav( $itemsCount, $limit, $start, 'start', 'op=products');
		}

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort('product_title');

		$vats = array();
		$vats = $h_myshop_vat->getAllVats();
		$products = $h_myshop_products->getObjects($criteria);
		$class = '';
		$span = 8;
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<div align='left'>".$pagenav->renderNav().'</div>';
		}
		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._MYSHOP_TITLE."</th><th align='center'>"._MYSHOP_CATEGORY."</th><th align='center'>"._MYSHOP_NUMBER.'<br />'._MYSHOP_EXTRA_ID."</th><th align='center'>"._AM_MYSHOP_RECOMMENDED."</th><th align='center'>"._MYSHOP_ONLINE."</th><th align='center'>"._MYSHOP_DATE."</th>";
		if(myshop_utils::getModuleOption('use_price')) {
			echo "<th align='center'>"._MYSHOP_PRICE."</th>";
			$span = 9;
		}
		echo "<th align='center'>"._AM_MYSHOP_ACTION."</th></tr>";
		foreach ($products as $item) {
			$class = ($class == 'even') ? 'odd' : 'even';
			$id = $item->getVar('product_id');
			$actions = array();
			$actions[] = "<a href='$baseurl?op=products&action=edit&id=".$id."' title='"._MYSHOP_EDIT."'>".$icones['edit'].'</a>';
			$actions[] = "<a href='$baseurl?op=products&action=copy&id=".$id."' title='"._MYSHOP_DUPLICATE_PRODUCT."'>".$icones['copy'].'</a>';
			$actions[] = "<a href='$baseurl?op=products&action=confdelete&id=".$id."' title='"._MYSHOP_DELETE."'>".$icones['delete'].'</a>';
			$online = $item->getVar('product_online') == 1 ? _YES : _NO;
			echo "<tr class='".$class."'>\n";
			if(isset($categories[$item->getVar('product_cid')])) {
				$productCategory = $categories[$item->getVar('product_cid')]->getVar('cat_title');
			} else {
				$productCategory = '';
			}
			$productLink = "<a href='".$item->getLink()."' target='blank'>".$item->getVar('product_title').'</a>';
			if(floatval($item->getVar('product_discount_price')) > 0) {
				$priceLine = '<s>'.$myshop_Currency->amountForDisplay($item->getVar('product_price')).'</s>  '.$myshop_Currency->amountForDisplay($item->getVar('product_discount_price'));
			} else {
				$priceLine = $myshop_Currency->amountForDisplay($item->getVar('product_price'));
			}
			$recommended = '';
			if($item->isRecommended()) {	
				$recommended = "<a href='".$baseurl."?op=products&action=unrecommend&product_id=".$id."' title='"._AM_MYSHOP_DONOTRECOMMEND_IT."'><img alt='"._AM_MYSHOP_DONOTRECOMMEND_IT."' src='".MYSHOP_IMAGES_URL."star_on.png' alt='' /></a>";
			} else {	
				$recommended = "<a href='".$baseurl."?op=products&action=recommend&product_id=".$id."' title='"._AM_MYSHOP_RECOMMEND_IT."'><img alt='"._AM_MYSHOP_RECOMMEND_IT."' src='".MYSHOP_IMAGES_URL."star_off.png' alt='' /></a>";
			}

			echo "<td align='center'>".$id."</td><td align ='left'>".$productLink."</td><td align='left'>".$productCategory."</td><td align='center'>".$item->getVar('product_sku').' / '.$item->getVar('product_extraid')."</td><td align='center'>".$recommended."</td><td align='center'>".$online."</td><td align='center'>".$item->getVar('product_date')."</td>";
			if(myshop_utils::getModuleOption('use_price')) {
				echo "<td align='right'>".$priceLine."</td>";
			}
			echo "<td align='center'>".implode(' ', $actions)."</td>\n";
			echo "<tr>\n";
		}
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'>\n";
		echo "<td colspan='$span' align='center' class='foot'>".$form."</td>\n";
		echo "</tr>\n";
		echo '</table>';
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<div align='right'>".$pagenav->renderNav()."</div>";
		}
		break;

	case 'unrecommend':
		$opRedirect = '?op=products';
		if(isset($_GET['product_id'])) {
			$product_id = intval($_GET['product_id']);
			$product = null;
			$product = $h_myshop_products->get($product_id);
			if(is_object($product)) {
				$product->unsetRecommended();
				if($h_myshop_products->insert($product, true)) {
					myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.$opRedirect, 1);
				} else {
					myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.$opRedirect, 4);
				}
			} else {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.$opRedirect, 4);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl.$opRedirect, 4);
		}
		break;


	case 'recommend':	
		$opRedirect = '?op=products';
		if(isset($_GET['product_id'])) {
			$product_id = intval($_GET['product_id']);
			$product = null;
			$product = $h_myshop_products->get($product_id);
			if(is_object($product)) {
				$product->setRecommended();
				if($h_myshop_products->insert($product, true)) {
					myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.$opRedirect, 1);
				} else {
					myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.$opRedirect, 4);
				}
			} else {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.$opRedirect, 4);
			}
		} else {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl.$opRedirect, 4);
		}
		break;


	case 'add':	
	case 'edit':
        xoops_cp_header();
        myshop_adminMenu(5);
        global $xoopsUser;

        if($action == 'edit') {
			$title = _AM_MYSHOP_EDIT_PRODUCT;
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if(empty($id)) {
				myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
			}
			// Item exits ?
			$item = null;
			$item = $h_myshop_products->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$edit = true;
			$label_submit = _AM_MYSHOP_MODIFY;
		} else {
			$title = _AM_MYSHOP_ADD_PRODUCT;
			$item = $h_myshop_products->create(true);
			$item->setVar('product_online', 1);
			$label_submit = _AM_MYSHOP_ADD;
			$edit = false;
		}

		$categories = $h_myshop_cat->getAllCategories(0, 0, 'cat_title', 'ASC', true);
		if(count($categories) == 0) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_8, $baseurl, 5);
		}
		// VAT
		$vats = $vatsForDisplay = array();
		$vats = $h_myshop_vat->getAllVats(0, 0);
		if(count($vats) == 0) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_9, $baseurl, 5);
		}
		foreach($vats as $onevat) {
			$vatsForDisplay[$onevat->getVar('vat_id')] = $onevat->getVar('vat_rate');
		}

		$mytree = new XoopsObjectTree($categories, 'cat_cid', 'cat_pid');
		$select_categ = $mytree->makeSelBox('product_cid', 'cat_title', '-', $item->getVar('product_cid'));

		$sform = new XoopsThemeForm($title, 'frmproduct', $baseurl);
		$sform->setExtra('enctype="multipart/form-data"');
		$sform->addElement(new XoopsFormHidden('op', 'products'));
		$sform->addElement(new XoopsFormHidden('action', 'saveedit'));
		$sform->addElement(new XoopsFormHidden('product_id', $item->getVar('product_id')));
		$sform->addElement(new XoopsFormHidden('product_submitter', $xoopsUser->getVar('uid')));

		$sform->addElement(new XoopsFormText(_MYSHOP_TITLE,'product_title',50,255, $item->getVar('product_title','e')), true);

		// Stores 
		$stores = $storesForDisplay = array();
		$stores = $h_myshop_stores->getAllStores();
		foreach($stores as $oneStore) {
			$storesForDisplay[$oneStore->getVar('store_id')] = $oneStore->getVar('store_name');
		}
		$storesSelect = new XoopsFormSelect(_MYSHOP_STORE, 'product_store_id', $item->getVar('product_store_id'));
		$storesSelect->addOptionArray($storesForDisplay);
		$sform->addElement($storesSelect, true);

		$sform->addElement(new XoopsFormLabel(_AM_MYSHOP_CATEG_HLP, $select_categ), true);

		$deliveryTime = new XoopsFormText(_MYSHOP_DELIVERY_TIME,'product_delivery_time',5,5, $item->getVar('product_delivery_time','e'));
		$deliveryTime->setDescription(_MYSHOP_IN_DAYS);
		$sform->addElement($deliveryTime, false);

		$sform->addElement(new XoopsFormText(_MYSHOP_NUMBER,'product_sku',10,60, $item->getVar('product_sku','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_EXTRA_ID,'product_extraid',10,50, $item->getVar('product_extraid','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_LENGTH,'product_length',10,50, $item->getVar('product_length','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_WIDTH,'product_width',10,50, $item->getVar('product_width','e')), false);

		$sform->addElement(new XoopsFormText(_MYSHOP_MEASURE1,'product_unitmeasure1',10,20, $item->getVar('product_unitmeasure1','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_WEIGHT,'product_weight',10,20, $item->getVar('product_weight','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_MEASURE2,'product_unitmeasure2',10,20, $item->getVar('product_unitmeasure2','e')), false);
		$sform->addElement(new XoopsFormText(_MYSHOP_DOWNLOAD_URL,'product_download_url',50,255, $item->getVar('product_download_url','e')), false);
		$sform->addElement(new XoopsFormText(_AM_MYSHOP_URL_HLP,'product_url',50,255, $item->getVar('product_url','e')), false);

		// Images
		if( $action == 'edit' && $item->pictureExists() ) {
			$pictureTray = new XoopsFormElementTray(_AM_MYSHOP_IMAGE1_HELP ,'<br />');
			$pictureTray->addElement(new XoopsFormLabel('', "<img src='".$item->getPictureUrl()."' alt='' border='0' />"));
			$deleteCheckbox = new XoopsFormCheckBox('', 'delpicture1');
			$deleteCheckbox->addOption(1, _DELETE);
			$pictureTray->addElement($deleteCheckbox);
			$sform->addElement($pictureTray);
			unset($pictureTray, $deleteCheckbox);
		}
		$sform->addElement(new XoopsFormFile(_AM_MYSHOP_IMAGE1_CHANGE , 'attachedfile1', myshop_utils::getModuleOption('maxuploadsize')), false);

		if(!myshop_utils::getModuleOption('create_thumbs')) {	
			if( $action == 'edit' && $item->thumbExists() ) {
				$pictureTray = new XoopsFormElementTray(_AM_MYSHOP_IMAGE2_HELP ,'<br />');
				$pictureTray->addElement(new XoopsFormLabel('', "<img src='".$item->getThumbUrl()."' alt='' border='0' />"));
				$deleteCheckbox = new XoopsFormCheckBox('', 'delpicture2');
				$deleteCheckbox->addOption(1, _DELETE);
				$pictureTray->addElement($deleteCheckbox);
				$sform->addElement($pictureTray);
				unset($pictureTray, $deleteCheckbox);
			}
			$sform->addElement(new XoopsFormFile(_AM_MYSHOP_IMAGE2_CHANGE, 'attachedfile2', myshop_utils::getModuleOption('maxuploadsize')), false);
		}

		// on-line
		$sform->addElement(new XoopsFormRadioYN(_MYSHOP_ONLINE_HLP,'product_online', $item->getVar('product_online')), true);
		$sform->addElement(new XoopsFormText(_MYSHOP_DATE,'product_date',50,255, $item->getVar('product_date','e')), false);

		$date_submit = new XoopsFormTextDateSelect(_MYSHOP_DATE_SUBMIT, 'product_submitted', 15, $item->getVar('product_submitted','e'));
		$date_submit->setDescription(_AM_MYSHOP_SUBDATE_HELP);
		$sform->addElement($date_submit, false);

		$sform->addElement(new XoopsFormHidden('product_hits',$item->getVar('product_hits')));
		$sform->addElement(new XoopsFormHidden('product_rating',$item->getVar('product_rating')));
		$sform->addElement(new XoopsFormHidden('product_votes',$item->getVar('product_votes')));
		$sform->addElement(new XoopsFormHidden('product_comments',$item->getVar('product_comments')));

		// manufacturers
		$manufacturers = $productsManufacturers = $manufacturers_d = $productsManufacturers_d = array();
		// search
		$criteria = new Criteria('manu_id', 0, '<>');
		$criteria->setSort('manu_name');
		$manufacturers = $h_myshop_manufacturer->getObjects($criteria);
		foreach($manufacturers as $oneitem) {
			$manufacturers_d[$oneitem->getVar('manu_id')] = xoops_trim($oneitem->getVar('manu_name')).' '. xoops_trim($oneitem->getVar('manu_commercialname'));
		}
		if($edit) {
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('pm_product_id', $item->getVar('product_id'), '='));
			$productsManufacturers = $h_myshop_productsmanu->getObjects($criteria);
			foreach($productsManufacturers as $oneproduct) {
				$productsManufacturers_d[] = $oneproduct->getVar('pm_manu_id');
			}
		}
		$manufacturersSelect = new XoopsFormSelect(_MYSHOP_MANUFACTURER, 'manufacturers', $productsManufacturers_d, 5, true);
		$manufacturersSelect->addOptionArray($manufacturers_d);
		$manufacturersSelect->setDescription(_AM_MYSHOP_SELECT_HLP);
		$sform->addElement($manufacturersSelect, true);

		// Related Products
		$relatedProducts = $productRelated = $relatedProducts_d = $productRelated_d = array();
		$criteria = new Criteria('product_id', $item->getVar('product_id'), '<>');
		$criteria->setSort('product_title');
		$relatedProducts = $h_myshop_products->getObjects($criteria);
		foreach($relatedProducts as $oneitem) {
			$relatedProducts_d[$oneitem->getVar('product_id')] = xoops_trim($oneitem->getVar('product_title'));
		}
		if($edit) {
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('related_product_id', $item->getVar('product_id'), '='));
			$productRelated = $h_myshop_related->getObjects($criteria);
			foreach($productRelated as $oneproduct) {
				$productRelated_d[] = $oneproduct->getVar('related_product_related');
			}
		}
		$related_select = new XoopsFormSelect(_MYSHOP_RELATED_PRODUCTS, 'relatedproducts', $productRelated_d, 5, true);
		$related_select->setDescription(_AM_MYSHOP_RELATED_HELP.'<br />'._AM_MYSHOP_SELECT_HLP);
		$related_select->addOptionArray($relatedProducts_d);
		$sform->addElement($related_select, false);

		if(myshop_utils::getModuleOption('use_price')) {
			// VAT
			$vatSelect = new XoopsFormSelect(_MYSHOP_VAT, 'product_vat_id', $item->getVar('product_vat_id'));
			$vatSelect->addOptionArray($vatsForDisplay);
			$sform->addElement($vatSelect, true);

			$sform->addElement(new XoopsFormText(_MYSHOP_PRICE,'product_price',20,20, $item->getVar('product_price','e')), true);
			$sform->addElement(new XoopsFormText(_AM_MYSHOP_DISCOUNT_HLP,'product_discount_price',20,20, $item->getVar('product_discount_price','e')), false);

			$sform->addElement(new XoopsFormText(_MYSHOP_SHIPPING_PRICE,'product_shipping_price',20,20, $item->getVar('product_shipping_price','e')), false);
			$sform->addElement(new XoopsFormText(_MYSHOP_ECOTAXE, 'product_ecotaxe', 10, 10, $item->getVar('product_ecotaxe','e')), false);
		}
		$sform->addElement(new XoopsFormText(_MYSHOP_STOCK_QUANTITY,'product_stock',10,10, $item->getVar('product_stock','e')), false);

		$alertStock = new XoopsFormText(_MYSHOP_STOCK_ALERT,'product_alert_stock',10,10, $item->getVar('product_alert_stock','e'));
		$alertStock->setDescription(_AM_MYSHOP_STOCK_HLP);
		$sform->addElement($alertStock, false);

		$editor2 = myshop_utils::getWysiwygForm(_MYSHOP_SUMMARY,'product_summary', $item->getVar('product_summary','e'), 15, 60, 'summary_hidden');
		if($editor2) {
			$sform->addElement($editor2, false);
		}

		$editor = myshop_utils::getWysiwygForm(_MYSHOP_DESCRIPTION,'product_description', $item->getVar('product_description','e'), 15, 60, 'description_hidden');
		if($editor) {
			$sform->addElement($editor, false);
		}

		// META Data
		if($manual_meta) {
			$sform->addElement(new XoopsFormText(_AM_MYSHOP_META_KEYWORDS,'product_metakeywords',50,255, $item->getVar('product_metakeywords','e')), false);
			$sform->addElement(new XoopsFormText(_AM_MYSHOP_META_DESCRIPTION,'product_metadescription',50,255, $item->getVar('product_metadescription','e')), false);
			$sform->addElement(new XoopsFormText(_AM_MYSHOP_META_PAGETITLE,'product_metatitle',50,255, $item->getVar('product_metatitle','e')), false);
		}
		// Attachement
		if( $action == 'edit' && trim($item->getVar('product_attachment')) != '' && file_exists(XOOPS_UPLOAD_PATH.DIRECTORY_SEPARATOR.trim($item->getVar('product_attachment'))) ) {
			$pictureTray = new XoopsFormElementTray(_MYSHOP_ATTACHED_FILE ,'<br />');
			$pictureTray->addElement(new XoopsFormLabel('', "<a href='".XOOPS_UPLOAD_URL.'/'.$item->getVar('product_attachment')."' target='_blank'>".XOOPS_UPLOAD_URL.'/'.$item->getVar('product_attachment')."</a>"));
			$deleteCheckbox = new XoopsFormCheckBox('', 'delpicture3');
			$deleteCheckbox->addOption(1, _DELETE);
			$pictureTray->addElement($deleteCheckbox);
			$sform->addElement($pictureTray);
			unset($pictureTray, $deleteCheckbox);
		}
		$downloadFile = new XoopsFormFile(_MYSHOP_ATTACHED_FILE , 'attachedfile3', myshop_utils::getModuleOption('maxuploadsize'));
		$downloadFile->setDescription(_AM_MYSHOP_ATTACHED_HLP);
		$sform->addElement($downloadFile, false);

		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', $label_submit, 'submit');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);

		$sform = myshop_utils::formMarkRequiredFields($sform);
		$sform->display();
		break;


	case 'saveedit':	
		xoops_cp_header();
		$id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
		if($id > 0) {
			$edit = true;
			$item = $h_myshop_products->get($id);
			if(!is_object($item)) {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
			}
			$item->unsetNew();
			$add = false;
		} else {
			$item = $h_myshop_products->create(true);
			$edit = false;
			$add = true;
		}
		$opRedirect = 'products';
		$item->setVars($_POST);
		$item->setVar('product_submitted', strtotime($_POST['product_submitted']));

		if(isset($_POST['delpicture1']) && intval($_POST['delpicture1']) == 1) {
			$item->deletePicture();
		}

		if(isset($_POST['delpicture2']) && intval($_POST['delpicture2']) == 1) {
			$item->deleteThumb();
		}
		if(isset($_POST['delpicture3']) && intval($_POST['delpicture3']) == 1) {
			$item->deleteAttachment();
		}

		$destname = '';
		$mainPicture = '';
		$res1 = myshop_utils::uploadFile(0, MYSHOP_PICTURES_PATH);
		if($res1 === true) {
			$mainPicture = $destname;
			if(myshop_utils::getModuleOption('resize_main')) {	
				myshop_utils::resizePicture(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$destname, MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$destname, myshop_utils::getModuleOption('images_width'), myshop_utils::getModuleOption('images_height'), true);
			}
			$item->setVar('product_image_url', basename($destname));
   		} else {
   			if($res1 !== false) {
   				echo $res1;
   			}
   		}

   		$indiceAttached = 2;
		if(!myshop_utils::getModuleOption('create_thumbs')) {	
			$destname = '';
			$res2 = myshop_utils::uploadFile(1, MYSHOP_PICTURES_PATH);
			if($res2 === true) {
				$item->setVar('product_thumb_url', basename($destname));
   			} else {
	   			if($res2 !== false) {
   					echo $res2;
   				}
   			}
		} else {		
			$indiceAttached = 1;
			if(xoops_trim($mainPicture) != '') {
				$thumbName = MYSHOP_THUMBS_PREFIX.$mainPicture;
				myshop_utils::resizePicture(MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$mainPicture, MYSHOP_PICTURES_PATH.DIRECTORY_SEPARATOR.$thumbName, myshop_utils::getModuleOption('thumbs_width'), myshop_utils::getModuleOption('thumbs_height'), true);
				$item->setVar('product_thumb_url', $thumbName);
			}
		}


		// Download
		$destname = '';
		$res3 = myshop_utils::uploadFile($indiceAttached, MYSHOP_ATTACHED_FILES_PATH);
		if($res3 === true) {
			$item->setVar('product_attachment', basename($destname));
   		} else {
   			if($res3 !== false) {
   				echo $res3;
   			}
   		}

		$res = $h_myshop_products->insert($item);
		if($res) {
			$id = $item->getVar('product_id');
			// Notifications
			if($add == true) {
				if(intval($item->getVar('product_online')) == 1) {
					$notification_handler =& xoops_gethandler('notification');
					$tags['PRODUCT_NAME'] = $item->getVar('product_title');
					$tags['PRODUCT_SUMMARY'] = strip_tags($item->getVar('product_summary'));
					$tags['PRODUCT_URL'] = $item->getLink();
					$notification_handler->triggerEvent('global', 0, 'new_product', $tags);
				}
			}
			if($edit) {
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('pm_product_id', $id, '='));
				$h_myshop_productsmanu->deleteAll($criteria);
			}
			if(isset($_POST['manufacturers'])) {
				foreach ($_POST['manufacturers'] as $id2) {
					$item2 = $h_myshop_productsmanu->create(true);
					$item2->setVar('pm_product_id', $id);
					$item2->setVar('pm_manu_id', intval($id2));
					$res = $h_myshop_productsmanu->insert($item2);
				}
			}

			if($edit) {
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('related_product_id', $id, '='));
				$h_myshop_related->deleteAll($criteria);
			}
			if(isset($_POST['relatedproducts'])) {
				foreach ($_POST['relatedproducts'] as $id2) {
					$item2 = $h_myshop_related->create(true);
					$item2->setVar('related_product_id', $id);
					$item2->setVar('related_product_related', intval($id2));
					$res = $h_myshop_related->insert($item2);
				}
			}
			myshop_utils::updateCache();
			myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect, 2);
		} else {
			myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect, 5);
		}
		break;


	case 'copy':
        xoops_cp_header();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'products';
		$product = null;
		$product = $h_myshop_products->get($id);
		if(is_object($product)) {
			$newProduct = $product->xoopsClone();
			$newProduct->setVar('product_title', $product->getvar('product_title').' '._AM_MYSHOP_DUPLICATED);
			$newProduct->setVar('product_id', 0);
			$newProduct->setNew();
			$res = $h_myshop_products->insert($newProduct, true);
			if($res) {
				$newProductId = $newProduct->getVar('product_id');
				$tblTmp = array();
				$criteria  = new Criteria('pm_product_id', $product->getVar('product_id'), '=');
				$tblTmp = $h_myshop_productsmanu->getObjects($criteria);
				foreach($tblTmp as $productAuthor) {
					$newProductAuthor = $productAuthor->xoopsClone();
					$newProductAuthor->setVar('pm_product_id', $newProductId);
					$newProductAuthor->setVar('pm_id', 0);
					$newProductAuthor->setNew();
					$h_myshop_productsmanu->insert($newProductAuthor, true);
				}
				$tblTmp = array();
				$criteria  = new Criteria('related_product_id', $product->getVar('product_id'), '=');
				$tblTmp = $h_myshop_related->getObjects($criteria);
				foreach($tblTmp as $related) {
					$newRelated = $related->xoopsClone();
					$newRelated->setVar('related_product_id', $newProductId);
					$newRelated->setVar('related_id', 0);
					$newRelated->setNew();
					$h_myshop_related->insert($newRelated, true);
				}
				myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect,2);
			} else {
				myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect,5);
			}
		}
		break;


	case 'confdelete':
        xoops_cp_header();
        myshop_adminMenu(5);

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if($id == 0) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$item = $h_myshop_products->get($id);
		if(!is_object($item)) {
			myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl, 5);
		}
		xoops_confirm(array( 'op' => 'products', 'action' => 'delete', 'id' => $id), 'index.php', _AM_MYSHOP_CONF_DELITEM.'<br />'.$item->getVar('product_title'));
		break;


	case 'delete':	
        xoops_cp_header();
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		if($id == 0) {
			myshop_utils::redirect(_AM_MYSHOP_ERROR_1, $baseurl, 5);
		}
		$opRedirect = 'products';
		$tblTmp = array();
		$tblTmp = $h_myshop_caddy->getCommandIdFromProduct($id);
		if(count($tblTmp) == 0) {
			$item = null;
			$item = $h_myshop_products->get($id);
			if(is_object($item)) {
				$res = $myshop_shelf->deleteProduct($item, true);
				if($res) {
					myshop_utils::updateCache();
					xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'new_product', $id);
					myshop_utils::redirect(_AM_MYSHOP_SAVE_OK, $baseurl.'?op='.$opRedirect, 2);
				} else {
					myshop_utils::redirect(_AM_MYSHOP_SAVE_PB, $baseurl.'?op='.$opRedirect, 5);
				}
			} else {
				myshop_utils::redirect(_AM_MYSHOP_NOT_FOUND, $baseurl.'?op='.$opRedirect, 5);
			}
		} else {
        	myshop_adminMenu(5);
			myshop_utils::htitle(_AM_MYSHOP_SORRY_NOREMOVE, 4);
			$tblTmp2 = array();
			$tblTmp2 = $h_myshop_commands->getObjects(new Criteria('cmd_id', '('.implode(',', $tblTmp).')', 'IN'), true);
			echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
			$class = '';
			echo "<tr><th align='center'>"._AM_MYSHOP_ID."</th><th align='center'>"._AM_MYSHOP_DATE."</th><th align='center'>"._AM_MYSHOP_CLIENT."</th><th align='center'>"._AM_MYSHOP_TOTAL_SHIPP."</th></tr>";
			foreach ($tblTmp2 as $item) {
				$class = ($class == 'even') ? 'odd' : 'even';
				$date = formatTimestamp(strtotime($item->getVar('cmd_date')), 's');
				echo "<tr class='".$class."'>\n";
				echo "<td align='right'>".$item->getVar('cmd_id')."</td><td align='center'>".$date."</td><td align='center'>".$item->getVar('cmd_lastname').' '.$item->getVar('cmd_firstname')."</td><td align='center'>".$item->getVar('cmd_total').' '.myshop_utils::getModuleOption('money_short').' / '.$item->getVar('cmd_shipping').' '.myshop_utils::getModuleOption('money_short')."</td>\n";
				echo "<tr>\n";
			}
			echo '</table>';
		}
		break;
}
?>