<?php /* Smarty version 2.6.26, created on 2012-08-27 17:48:33
         compiled from db:legacy_xoopsform_select.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'db:legacy_xoopsform_select.html', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['element']->isMultiple() != false): ?>
  <select size='<?php echo $this->_tpl_vars['element']->getSize(); ?>
' name='<?php echo $this->_tpl_vars['element']->getName(); ?>
[]' id='<?php echo $this->_tpl_vars['element']->getName(); ?>
' multiple='multiple' <?php echo $this->_tpl_vars['element']->getExtra(); ?>
>
<?php else: ?>
   <select size='<?php echo $this->_tpl_vars['element']->getSize(); ?>
' name='<?php echo $this->_tpl_vars['element']->getName(); ?>
' id='<?php echo $this->_tpl_vars['element']->getName(); ?>
' <?php echo $this->_tpl_vars['element']->getExtra(); ?>
>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['element']->getOptions(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['name']):
?>
  <option id='<?php echo $this->_tpl_vars['element']->getName(); ?>
_<?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
' <?php if (count ( $this->_tpl_vars['element']->getValue() ) > 0 && in_array ( $this->_tpl_vars['value'] , $this->_tpl_vars['element']->getValue() )): ?> selected='selected'<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select>