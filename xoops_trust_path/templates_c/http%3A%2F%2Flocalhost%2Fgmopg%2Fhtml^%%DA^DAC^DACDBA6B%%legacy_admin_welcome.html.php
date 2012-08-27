<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:39
         compiled from file:/Users/bluemooninc/PhpstormProjects/gmopg/html/modules/legacy/admin/templates/legacy_admin_welcome.html */ ?>
<div class="adminnavi">
  <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/admin.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_CPHOME; ?>
</span>
</div>

<div class="tips">
  <?php if ($this->_tpl_vars['title']): ?>
    <h4 class="admintitle"><b><?php echo $this->_tpl_vars['title']; ?>
</b></h4>
  <?php endif; ?>
  
  <?php if (is_array ( $this->_tpl_vars['messages'] )): ?>
    <?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['msg']):
?>
      <?php echo $this->_tpl_vars['msg']; ?>
<br/>
    <?php endforeach; endif; unset($_from); ?>
  <?php else: ?>
    <?php echo $this->_tpl_vars['messages']; ?>

  <?php endif; ?>

</div>