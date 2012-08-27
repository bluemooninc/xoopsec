<?php /* Smarty version 2.6.26, created on 2012-08-27 17:48:10
         compiled from db:legacy_xoopsform_elementtray.html */ ?>
<?php $_from = $this->_tpl_vars['tray']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
  <?php if ($this->_tpl_vars['flag']): ?>
    <?php echo $this->_tpl_vars['tray']->getDelimeter(); ?>

  <?php endif; ?>
  <?php if (is_object ( $this->_tpl_vars['element'] )): ?>
    <?php if ($this->_tpl_vars['element']->getCaption() != ''): ?>
      <?php echo $this->_tpl_vars['element']->getCaption(); ?>
&nbsp;
    <?php endif; ?>
    <?php echo $this->_tpl_vars['element']->render(); ?>

    <?php if (! $this->_tpl_vars['element']->isHidden()): ?>
      <?php $this->assign('flag', true); ?>
    <?php endif; ?>
  <?php else: ?>
    <?php echo $this->_tpl_vars['element']; ?>

    <?php $this->assign('flag', true); ?>
  <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>