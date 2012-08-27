<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:36
         compiled from db:legacy_block_mainmenu.html */ ?>
<ul id="mainmenu">
      <li><a class="menuTop" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/"><?php echo @_MB_LEGACY_HOME; ?>
</a></li>
<?php $_from = $this->_tpl_vars['block']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
      <li><a class="menuMain" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/<?php echo $this->_tpl_vars['module']['directory']; ?>
/"><?php echo $this->_tpl_vars['module']['name']; ?>
</a></li>
<?php $_from = $this->_tpl_vars['module']['sublinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sublink']):
?>
        <li><a class="menuSub" href="<?php echo $this->_tpl_vars['sublink']['url']; ?>
"><?php echo $this->_tpl_vars['sublink']['name']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
</ul>