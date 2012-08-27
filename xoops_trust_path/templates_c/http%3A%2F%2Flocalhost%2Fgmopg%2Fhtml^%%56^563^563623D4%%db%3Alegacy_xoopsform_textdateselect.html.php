<?php /* Smarty version 2.6.26, created on 2012-08-27 17:49:18
         compiled from db:legacy_xoopsform_textdateselect.html */ ?>
<input type='text' name='<?php echo $this->_tpl_vars['element']->getName(); ?>
' id='<?php echo $this->_tpl_vars['element']->getId(); ?>
' size='<?php echo $this->_tpl_vars['element']->getSize(); ?>
' maxlength='<?php echo $this->_tpl_vars['element']->getMaxlength(); ?>
' value='<?php echo $this->_tpl_vars['date']; ?>
' <?php echo $this->_tpl_vars['element']->getExtra(); ?>
 />
<input type='reset' value=' ... ' onclick='return showCalendar("<?php echo $this->_tpl_vars['element']->getName(); ?>
");' />