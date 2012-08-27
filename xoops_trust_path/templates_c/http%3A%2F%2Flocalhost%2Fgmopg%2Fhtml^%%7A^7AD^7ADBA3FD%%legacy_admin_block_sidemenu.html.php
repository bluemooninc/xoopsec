<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:39
         compiled from blocks/legacy_admin_block_sidemenu.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'theme', 'blocks/legacy_admin_block_sidemenu.html', 7, false),array('modifier', 'xoops_escape', 'blocks/legacy_admin_block_sidemenu.html', 8, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>

<?php $this->assign('mid', $this->_tpl_vars['module']->mXoopsModule->getVar('mid')); ?>
<?php $this->assign('dirname', $this->_tpl_vars['module']->mXoopsModule->getVar('dirname','N')); ?>
  <?php if ($this->_tpl_vars['module']->hasAdminIndex()): ?>
    <div id="t<?php echo $this->_tpl_vars['mid']; ?>
" class="head">
      <a href="javascript:void(0)" onclick="ccToggle(<?php echo $this->_tpl_vars['mid']; ?>
)"><img src="<?php echo ((is_array($_tmp="design/max.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" id="i<?php echo $this->_tpl_vars['mid']; ?>
" /></a>
      <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['module']->getAdminIndex())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'link') : smarty_modifier_xoops_escape($_tmp, 'link')); ?>
"><?php echo $this->_tpl_vars['module']->mXoopsModule->getVar('name'); ?>
</a>
    </div>

    <div id="c<?php echo $this->_tpl_vars['mid']; ?>
" class="submenu">
      <ul>
      <?php if ($this->_tpl_vars['module']->getAdminMenu()): ?>
        <?php $_from = $this->_tpl_vars['module']->getAdminMenu(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
          <?php if ($this->_tpl_vars['menu']['show'] !== false): ?>
            <li><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['menu']['link'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'link') : smarty_modifier_xoops_escape($_tmp, 'link')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['menu']['title'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</a></li>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

          <?php if ($this->_tpl_vars['module']->mXoopsModule->getInfo('blocks') && $this->_tpl_vars['dirname'] != 'legacy' && $this->_tpl_vars['dirname'] != 'altsys' && $this->_tpl_vars['dirname'] != 'system'): ?>
          <li>
          <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockList&amp;dirname=<?php echo $this->_tpl_vars['dirname']; ?>
">
          <img src="<?php echo ((is_array($_tmp="icons/blocks.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;
          <?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>

          </a>
          </li>
          <li>
          <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockInstallList&amp;dirname=<?php echo $this->_tpl_vars['dirname']; ?>
">
          <img src="<?php echo ((is_array($_tmp="icons/block_add.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;
          <?php echo @_MI_LEGACY_MENU_BLOCKINSTALL; ?>

          </a>
          </li>
          <?php endif; ?>
          
          <?php if ($this->_tpl_vars['dirname'] != 'legacyRender' && $this->_tpl_vars['dirname'] != 'altsys' && $this->_tpl_vars['dirname'] != 'system'): ?>
          <?php $_from = $this->_tpl_vars['tplmodules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tplmodule']):
?>
          <?php if ($this->_tpl_vars['dirname'] == $this->_tpl_vars['tplmodule']): ?>			
          <li>
          <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacyRender/admin/index.php?action=TplfileList&amp;tpl_module=<?php echo $this->_tpl_vars['dirname']; ?>
&amp;sort=-9">
          <img src="<?php echo ((is_array($_tmp="icons/templates.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;
          <?php echo @_AD_LEGACY_LANG_TEMPLATE_INFO; ?>

          </a>
          </li>
          <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>
          <?php endif; ?>
          
          <?php if ($this->_tpl_vars['module']->mXoopsModule->getInfo('hasComments')): ?>
          <li>
          <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=CommentList&amp;com_modid=<?php echo $this->_tpl_vars['mid']; ?>
&amp;sort=-8">
          <img src="<?php echo ((is_array($_tmp="icons/comments.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;
          <?php echo @_MI_LEGACY_MENU_COMMENT_MANAGE; ?>

          </a>
          </li>
          <?php endif; ?>
          
          <?php if ($this->_tpl_vars['module']->mXoopsModule->hasNeedUpdate()): ?>
          <li>
          <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleUpdate&amp;dirname=<?php echo $this->_tpl_vars['dirname']; ?>
">
          <img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" title="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" />&nbsp;
          <?php echo @_AD_LEGACY_LANG_UPGRADE; ?>

          </a>
          </li>
          
          <?php else: ?>
          
          <li>
          <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleUpdate&amp;dirname=<?php echo $this->_tpl_vars['dirname']; ?>
">
          <img src="<?php echo ((is_array($_tmp="icons/update.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" title="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" />&nbsp;
          <?php echo @_AD_LEGACY_LANG_UPGRADE; ?>

          </a>
          </li>
          <?php endif; ?>
          
          <li><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleEdit&amp;mid=<?php echo $this->_tpl_vars['mid']; ?>
">
          <img src="<?php echo ((is_array($_tmp="icons/module_edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;
          <?php echo @_EDIT; ?>

          </a>
          </li>
          <li>
          <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleInfo&amp;dirname=<?php echo $this->_tpl_vars['dirname']; ?>
">
          <img src="<?php echo ((is_array($_tmp="icons/info.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;
          <?php echo @_AD_LEGACY_LANG_INFORMATION; ?>

          </a>
          </li>

		  <?php else: ?>
        
          <li>
          <?php echo @_AD_LEGACY_LANG_NO_SETTING; ?>

          </li>
      <?php endif; ?>
      </ul>
    </div>
  <?php endif; ?>

<?php endforeach; endif; unset($_from); ?>