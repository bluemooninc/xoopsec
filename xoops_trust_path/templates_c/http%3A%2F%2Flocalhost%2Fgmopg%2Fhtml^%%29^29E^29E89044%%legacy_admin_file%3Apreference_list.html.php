<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:54
         compiled from file:preference_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'file:preference_list.html', 15, false),array('modifier', 'xoops_escape', 'file:preference_list.html', 17, false),array('modifier', 'theme', 'file:preference_list.html', 19, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>
</span>
</div>

<h3 class="admintitle"><?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>
</h3>

<table class="outer">
  <tr>
    <th><?php echo @_AD_LEGACY_LANG_CONFCAT_ID; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_CONFCAT_NAME; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_CONTROL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['objects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['obj']):
?>
    <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
      <td class="legacy_list_id"><?php echo $this->_tpl_vars['obj']->getVar('confcat_id'); ?>
</td>
      <td class="legacy_list_title"><?php echo ((is_array($_tmp=$this->_tpl_vars['obj']->getName())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
      <td class="legacy_list_control">
        <a href="./index.php?action=PreferenceEdit&amp;confcat_id=<?php echo $this->_tpl_vars['obj']->getVar('confcat_id'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_EDIT; ?>
" title="<?php echo @_EDIT; ?>
" /></a>
      </td>
    </tr>
  <?php endforeach; endif; unset($_from); ?>
  
  <!-- 2008-12-7 Gigamaster, Test Accessibility-->
  <tfoot>
  <tr class="odd">
  <td class="legacy_list_id">-</td>
  <td class="legacy_list_title">User</td>
      <td class="legacy_list_control">
        <a href="./index.php?action=PreferenceEdit&confmod_id=4"><img src="<?php echo ((is_array($_tmp="icons/edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_EDIT; ?>
" title="<?php echo @_EDIT; ?>
" /></a>
      </td>
      </tr>
  <tr class="even">
  <td class="legacy_list_id">-</td>
  <td class="legacy_list_title">Meta Keywords</td>
      <td class="legacy_list_control">
        <a href="./index.php?action=PreferenceEdit&confmod_id=3"><img src="<?php echo ((is_array($_tmp="icons/edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_EDIT; ?>
" title="<?php echo @_EDIT; ?>
" /></a>
      </td>
      </tr>
    </tfoot>
</table>