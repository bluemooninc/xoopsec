<?php /* Smarty version 2.6.26, created on 2012-08-27 17:48:05
         compiled from db:altsys_inc_mymenu.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'db:altsys_inc_mymenu.html', 4, false),)), $this); ?>
<div class="altsys_mymenu" style="text-align:<?php echo @_GLOBAL_LEFT; ?>
;width:98%;">
	<?php $_from = $this->_tpl_vars['adminmenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menuitem']):
?>
		<div style="float:<?php echo @_GLOBAL_LEFT; ?>
;height:1.5em;">
			<nobr><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['menuitem']['link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" style="background-color:<?php if ($this->_tpl_vars['menuitem']['selected']): ?>#ffcccc<?php else: ?>#dddddd<?php endif; ?>; font: normal normal bold 9pt/12pt;"><?php echo ((is_array($_tmp=$this->_tpl_vars['menuitem']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a> | </nobr>
		</div>
	<?php endforeach; endif; unset($_from); ?>
</div>
<hr class="altsys_mymenu_separator" style="clear:<?php echo @_GLOBAL_LEFT; ?>
;display:block;" />