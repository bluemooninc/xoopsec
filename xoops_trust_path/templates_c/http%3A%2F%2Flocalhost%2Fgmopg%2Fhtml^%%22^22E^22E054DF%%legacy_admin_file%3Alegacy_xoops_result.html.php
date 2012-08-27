<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:39
         compiled from file:legacy_xoops_result.html */ ?>
<div class="resultMsg">
  <?php if ($this->_tpl_vars['title']): ?>
    <h4 class="admintitle"><?php echo $this->_tpl_vars['title']; ?>
</h4>
  <?php endif; ?>
  <?php if (is_array ( $this->_tpl_vars['message'] )): ?>
    <?php $_from = $this->_tpl_vars['message']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['msg']):
?>
      <?php echo $this->_tpl_vars['msg']; ?>
<br/>
    <?php endforeach; endif; unset($_from); ?>
  <?php else: ?>
    <?php echo $this->_tpl_vars['message']; ?>

  <?php endif; ?>
</div>