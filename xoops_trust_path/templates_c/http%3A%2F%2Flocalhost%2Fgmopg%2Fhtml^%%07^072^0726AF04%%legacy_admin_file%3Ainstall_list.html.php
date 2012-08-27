<?php /* Smarty version 2.6.26, created on 2012-08-27 17:54:40
         compiled from file:install_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'file:install_list.html', 18, false),array('modifier', 'theme', 'file:install_list.html', 25, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <a href="./index.php?action=ModuleList"><?php echo @_MI_LEGACY_MENU_MODULELIST; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><a href="./index.php?action=InstallList"><?php echo @_AD_LEGACY_LANG_MODINSTALL; ?>
</a></span>
</div>

<h3 class="admintitle"><?php echo @_AD_LEGACY_LANG_MODINSTALL; ?>
</h3>

<div class="tips"><?php echo @_AD_LEGACY_LANG_MODINSTALL_LIST_ADVICE; ?>
</div>

<table class="outer">
  <tr>
    <th><?php echo @_AD_LEGACY_LANG_MOD_NAME; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_VERSION; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_CONTROL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['moduleObjects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
    <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
      <td class="legacy_list_image">
        <img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
/<?php echo $this->_tpl_vars['module']->modinfo['image']; ?>
" alt="<?php echo $this->_tpl_vars['module']->getShow('name','e'); ?>
" title="<?php echo $this->_tpl_vars['module']->getShow('name','e'); ?>
" />
        <div class="legacy_list_imagetitle"><?php echo $this->_tpl_vars['module']->getShow('name'); ?>
</div>
      </td>
      <td class="legacy_list_order"><?php echo $this->_tpl_vars['module']->getRenderedVersion(); ?>
</td>
      <td class="legacy_list_control">
        <a href="index.php?action=ModuleInstall&amp;dirname=<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/module_add.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_INSTALL; ?>
" title="<?php echo @_AD_LEGACY_LANG_INSTALL; ?>
" /></a>
        <a href="index.php?action=ModuleInfo&amp;dirname=<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/info.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_INFORMATION; ?>
" title="<?php echo @_AD_LEGACY_LANG_INFORMATION; ?>
" /></a>
      </td>
    </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>