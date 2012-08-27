<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:39
         compiled from file:legacy_xoops_error.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:legacy_xoops_error.html', 7, false),)), $this); ?>
<div class="error">
  <?php if ($this->_tpl_vars['title']): ?>
    <h4 class="admintitle"><?php echo $this->_tpl_vars['title']; ?>
</h4>
  <?php endif; ?>
  <?php if (is_array ( $this->_tpl_vars['message'] )): ?>
    <?php $_from = $this->_tpl_vars['message']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['msg']):
?>
      <?php echo ((is_array($_tmp=$this->_tpl_vars['msg'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
<br/>
    <?php endforeach; endif; unset($_from); ?>
  <?php else: ?>
    <?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

  <?php endif; ?>
</div>