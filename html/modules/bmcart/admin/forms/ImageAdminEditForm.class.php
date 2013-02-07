<?php
/**
 * @package user
 * @version $Id: ImageAdminEditForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class bmcart_ImageAdminEditForm extends XCube_ActionForm
{
	var $mOldFileName = null;
	var $_mIsNew = false;
	var $mFormFile = null;
	var $mUploadDir;

	function getTokenName()
	{
		return "module.bmcart.ImageAdminEditForm.TOKEN" . $this->get('image_id');
	}

	/**
	 * For displaying the confirm-page, don't show CSRF error.
	 * Always return null.
	 */
	function getTokenErrorMessage()
	{
		return null;
	}

	function prepare()
	{
		$this->mUploadDir = XOOPS_ROOT_PATH . "/uploads/";
		//
		// Set form properties
		//
		$this->mFormProperties['image_id'] = new XCube_IntProperty('image_id');
		$this->mFormProperties['item_id'] = new XCube_IntProperty('item_id');
		$this->mFormProperties['image_filename'] = new XCube_StringProperty('image_filename');
		$this->mFormProperties['upload_filename'] = new XCube_FileProperty('upload_filename');
		$this->mFormProperties['weight'] = new XCube_IntProperty('weight');

		//
		// Set field properties
		//
		$this->mFieldProperties['item_id'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['item_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['item_id']->addMessage('required', _MD_BMCART_ERROR_REQUIRED, _MD_BMCART_ITEMID);

	}

	function load(&$obj)
	{
		if (xoops_getrequest('item_id') && !$obj->get('item_id')){
			$this->set('item_id', xoops_getrequest('item_id'));
		}else{
			$this->set('item_id', $obj->get('item_id'));
		}
		$this->set('image_id', $obj->get('image_id'));
		$this->set('image_filename', $obj->get('image_filename'));
		$this->set('weight', $obj->get('weight'));
	}

	function update(&$obj)
	{
		$obj->set('image_id', $this->get('image_id'));
		$obj->set('item_id', $this->get('item_id'));
		$upload_filename = $this->_getUploadFile();
		if ($upload_filename) {
			$obj->set('image_filename', $upload_filename);
		} else {
			$obj->set('image_filename', $this->get('image_filename'));
		}
		$obj->set('weight', $this->get('weight'));
	}

	private function _makeThumbnail($prefix, $size, $filename)
	{
		//resize requires GD library
		if (!function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng') || !function_exists('imagecreatefromgif')) return;
		$filePath = $this->mUploadDir . '/' . $filename;
		list($width, $height, $type, $attr) = getimagesize($filePath);
		if ($width > $height) {
			$percent = $size / $width;
			$width_size = $size;
			$height_size = intval($height * $percent);
			$position_x = 0;
			$position_y = intval($size - $height_size)/2;
		} else {
			$percent = $size / $height;
			$width_size = intval($height * $percent);
			$height_size = $size;
			$position_x = intval($size - $width_size)/2;
			$position_y = 0;
		}
		switch ($type) {
			case 2:
				$source = imagecreatefromjpeg($filePath);
				break;
			case 1:
				$source = imagecreatefromgif($filePath);
				break;
			case 3:
				$source = imagecreatefrompng($filePath);
				break;
		}
		$destination = function_exists(ImageCreateTrueColor) ? ImageCreateTrueColor($size, $size) : ImageCreate($size, $size);
		imagefill($destination, 0, 0, 0xffffff);
		ImageCopyResampled($destination, $source, $position_x, $position_y, 0, 0, $width_size, $height_size, $width, $height);
		$filePath = $this->mUploadDir . '/' . $prefix . $filename;
		switch ($type) {
			case 2:
				imagejpeg($destination, $filePath);
				break;
			case 1:
				imagegif($destination, $filePath);
				break;
			case 3:
				imagepng($destination, $filePath);
				break;
		}
	}

	private function _getUploadFile()
	{
		$imageUploader = new XCube_FormImageFile('upload_filename');
		$imageUploader->fetch();
		if ($imageUploader->hasUploadFile()) {
			$fname = sprintf("bmcart%d_",$this->get('item_id'));
			$imageUploader->saveAsRandBody($this->mUploadDir, $fname);
			$this->_makeThumbnail("s_", 40, $imageUploader->getFileName());
			$this->_makeThumbnail("m_", 300, $imageUploader->getFileName());
			return $imageUploader->getFileName();
		}
		return null;
	}

}

?>
