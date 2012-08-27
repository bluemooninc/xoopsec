<?php /* Smarty version 2.6.26, created on 2012-08-27 17:48:37
         compiled from db:legacy_xoopsform_file.html */ ?>
<input type='hidden' name='MAX_FILE_SIZE' value='<?php echo $this->_tpl_vars['element']->getMaxFileSize(); ?>
' />
<input type='file' name='<?php echo $this->_tpl_vars['element']->getName(); ?>
' id='<?php echo $this->_tpl_vars['element']->getName(); ?>
' <?php echo $this->_tpl_vars['element']->getExtra(); ?>
 />
<input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='<?php echo $this->_tpl_vars['element']->getName(); ?>
' />