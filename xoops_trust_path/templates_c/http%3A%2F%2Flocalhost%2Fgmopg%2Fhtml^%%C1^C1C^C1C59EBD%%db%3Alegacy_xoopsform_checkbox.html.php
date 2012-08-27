<?php /* Smarty version 2.6.26, created on 2012-08-27 17:51:09
         compiled from db:legacy_xoopsform_checkbox.html */ ?>
<?php $_from = $this->_tpl_vars['element']->getOptions(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['name']):
?>
  <label><input type='checkbox' name='<?php echo $this->_tpl_vars['element']->getName(); ?>
' id='<?php echo $this->_tpl_vars['element']->getName(); ?>
_<?php echo $this->_tpl_vars['value']; ?>
' value='<?php echo $this->_tpl_vars['value']; ?>
' <?php if (( count ( $this->_tpl_vars['element']->getValue() ) > 0 && in_array ( $this->_tpl_vars['value'] , $this->_tpl_vars['element']->getValue() ) )): ?>checked="checked"<?php endif; ?> <?php echo $this->_tpl_vars['element']->getExtra(); ?>
 /><?php echo $this->_tpl_vars['name']; ?>
</label>
<?php endforeach; endif; unset($_from); ?>