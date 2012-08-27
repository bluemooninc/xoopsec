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

/**
 * Display Media Product
 */

require 'header.php';
$type =  isset($_GET['type']) ? strtolower($_GET['type']) : 'picture';
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if($product_id > 0) {
	$product = null;
	$product = $h_myshop_products->get($product_id);
	if(!is_object($product)) {
		exit(_MYSHOP_ERROR1);
	}

	if($product->getVar('product_online') == 0) {
		exit(_MYSHOP_ERROR2);
	}

	if(myshop_utils::getModuleOption('show_unpublished') == 0 && $product->getVar('product_submitted') > time()) {
		exit(_MYSHOP_ERROR3);
	}
} else {
	exit(_ERRORS);
}

switch($type) {
	case 'attachment':
		$file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;
		if($file_id == 0) {
			exit(_MYSHOP_ERROR13);
		}
		$attachedFile = null;
		$attachedFile = $h_myshop_files->get($file_id);
		if(!is_object($attachedFile)) {
			exit(_MYSHOP_ERROR19);
		}
		header("Content-Type: ".$attachedFile->getVar('file_mimetype'));
		header('Content-disposition: inline; filename="'.$attachedFile->getVar('file_filename').'"');
		readfile($attachedFile->getPath());
		break;

	case 'picture':
		xoops_header(true);
		echo "<div align='center' style='font-weight: bold;'><a href=\"javascript:self.close();\" title=\""._CLOSE."\">";
		if($product->pictureExists()) {
			echo "<img src='".$product->getPictureUrl()."' alt='' />";
		} else {
			echo _MYSHOP_SORRY_NOPICTURE;
		}
?>
		</a></div><br />
		<br />
		<div align='center'><input value="<?php echo _CLOSE ?>" type="button" onclick="javascript:window.close();" /></div>
<?php
		xoops_footer();
		break;
}
?>