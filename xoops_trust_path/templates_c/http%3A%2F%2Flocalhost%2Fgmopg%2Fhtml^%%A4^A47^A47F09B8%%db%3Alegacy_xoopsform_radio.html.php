<?php /* Smarty version 2.6.26, created on 2012-08-27 17:49:18
         compiled from db:legacy_xoopsform_radio.html */ ?>
<?php $_from = $this->_tpl_vars['element']->getOptions(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['name']):
?>
  <label><input type='radio' id='<?php echo $this->_tpl_vars['element']->getName(); ?>
_<?php echo $this->_tpl_vars['value']; ?>
' name='<?php echo $this->_tpl_vars['element']->getName(); ?>
' value='<?php echo $this->_tpl_vars['value']; ?>
' <?php if ($this->_tpl_vars['element']->getValue() !== null && $this->_tpl_vars['element']->getValue() == $this->_tpl_vars['value']): ?> checked='checked'<?php endif; ?> <?php echo $this->_tpl_vars['element']->getExtra(); ?>
 /><?php echo $this->_tpl_vars['name']; ?>
</label>
<?php endforeach; endif; unset($_from); ?>