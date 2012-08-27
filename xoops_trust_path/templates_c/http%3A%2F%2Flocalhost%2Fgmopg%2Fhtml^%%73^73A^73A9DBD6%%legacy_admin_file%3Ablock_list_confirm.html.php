<?php /* Smarty version 2.6.26, created on 2012-08-27 23:23:38
         compiled from file:block_list_confirm.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:block_list_confirm.html', 15, false),array('function', 'xoops_token', 'file:block_list_confirm.html', 22, false),array('function', 'xoops_input', 'file:block_list_confirm.html', 23, false),array('function', 'cycle', 'file:block_list_confirm.html', 35, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <a href="./index.php?action=BlockList"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_AD_LEGACY_LANG_BLOCK_UPDATECONF; ?>
</span>
</div>

<h3 class="admintitle"><?php echo @_AD_LEGACY_LANG_BLOCK_UPDATECONF; ?>
</h3>

<div class="confirm"><?php echo @_AD_LEGACY_MESSAGE_CONFIRM_UPDATE_BLOCK; ?>
</div>

<?php if ($this->_tpl_vars['actionForm']->hasError() && $this->_tpl_vars['actionForm']->get('confirm')): ?>
<div class="error">
  <ul>
    <?php $_from = $this->_tpl_vars['actionForm']->getErrorMessages(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
      <li><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</li>
    <?php endforeach; endif; unset($_from); ?>
  </ul>
</div>
<?php endif; ?>

<form method="post"  action="./index.php?action=BlockList">
  <?php echo smarty_function_xoops_token(array('form' => $this->_tpl_vars['actionForm']), $this);?>

  <?php echo smarty_function_xoops_input(array('type' => 'hidden','name' => 'confirm','value' => 1), $this);?>

<table class="outer">
  <tr>
    <th><?php echo @_AD_LEGACY_LANG_BID; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_TITLE; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_SIDE; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_WEIGHT; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_BCACHETIME; ?>
</th>
    <th><?php echo @_AD_LEGACY_LANG_UNINSTALL; ?>
</th>
  </tr>

<?php $_from = $this->_tpl_vars['bids']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bid']):
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
    <td class="legacy_list_id"><?php echo $this->_tpl_vars['bid']; ?>
</td>
    <td class="legacy_list_name">
      <?php if ($this->_tpl_vars['actionForm']->get('title',$this->_tpl_vars['bid']) == $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->get('title')): ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('title',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

      <?php else: ?>
         (<?php echo $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->getShow('title'); ?>
) &raquo; <b  class="legacy_module_error"><?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('title',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</b>
      <?php endif; ?>
    </td>
    <td class="legacy_list_name">
      <?php $this->assign('formside', $this->_tpl_vars['actionForm']->get('side',$this->_tpl_vars['bid'])); ?>
      <?php $this->assign('formside_obj', $this->_tpl_vars['columnSideArr'][$this->_tpl_vars['formside']]); ?>
      <?php if ($this->_tpl_vars['actionForm']->get('side',$this->_tpl_vars['bid']) == $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->get('side')): ?>
        <?php echo $this->_tpl_vars['formside_obj']->getShow('name'); ?>

      <?php else: ?>
         (<?php echo $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->mColumn->getShow('name'); ?>
) &raquo; <br />
        <b  class="legacy_module_error"><?php echo $this->_tpl_vars['formside_obj']->getShow('name'); ?>
</b>
      <?php endif; ?>
    </td>
    <td class="legacy_list_order">
      <?php if ($this->_tpl_vars['actionForm']->get('weight',$this->_tpl_vars['bid']) == $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->get('weight')): ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('weight',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

      <?php else: ?>
         (<?php echo $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->getShow('weight'); ?>
) &raquo; <b  class="legacy_module_error"><?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('weight',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</b>
      <?php endif; ?>
    </td>
    <td class="legacy_list_name">
      <?php $this->assign('formcache', $this->_tpl_vars['actionForm']->get('bcachetime',$this->_tpl_vars['bid'])); ?>
      <?php $this->assign('formcache_obj', $this->_tpl_vars['cachetimeArr'][$this->_tpl_vars['formcache']]); ?>
      <?php if ($this->_tpl_vars['actionForm']->get('bcachetime',$this->_tpl_vars['bid']) == $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->get('bcachetime')): ?>
        <?php echo $this->_tpl_vars['formcache_obj']->getShow('label'); ?>

      <?php else: ?>
         (<?php echo $this->_tpl_vars['blockObjects'][$this->_tpl_vars['bid']]->mCachetime->getShow('label'); ?>
) &raquo; <br /><b  class="legacy_module_error"><?php echo $this->_tpl_vars['formcache_obj']->getShow('label'); ?>
</b>
      <?php endif; ?>
      <input type="hidden" name="title[<?php echo $this->_tpl_vars['bid']; ?>
]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('title',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'edit') : smarty_modifier_xoops_escape($_tmp, 'edit')); ?>
" />
      <input type="hidden" name="side[<?php echo $this->_tpl_vars['bid']; ?>
]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('side',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'edit') : smarty_modifier_xoops_escape($_tmp, 'edit')); ?>
" />
      <input type="hidden" name="weight[<?php echo $this->_tpl_vars['bid']; ?>
]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('weight',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'edit') : smarty_modifier_xoops_escape($_tmp, 'edit')); ?>
" />
      <input type="hidden" name="bcachetime[<?php echo $this->_tpl_vars['bid']; ?>
]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['actionForm']->get('bcachetime',$this->_tpl_vars['bid']))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'edit') : smarty_modifier_xoops_escape($_tmp, 'edit')); ?>
" />
    </td>
    <td class="legacy_list_select">
        
        <?php if ($this->_tpl_vars['actionForm']->get('uninstall',$this->_tpl_vars['bid']) == 1): ?>
        <b class="legacy_module_error">
          <?php echo @_YES; ?>

        <?php else: ?>
        <b class="legacy_module_warning">
          <?php echo @_NO; ?>

        <?php endif; ?></b>
      <?php if ($this->_tpl_vars['actionForm']->get('uninstall',$this->_tpl_vars['bid'])): ?>
        <input type="hidden" name="uninstall[<?php echo $this->_tpl_vars['bid']; ?>
]" value="1" />
      <?php else: ?>
        <input type="hidden" name="uninstall[<?php echo $this->_tpl_vars['bid']; ?>
]" value="0" />
      <?php endif; ?>
    </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
  <tr>
    <td class="foot" colspan="6">
      <input type="submit" value="<?php echo @_AD_LEGACY_LANG_UPDATE; ?>
" class="formButton" />
      <input class="formButton" type="submit" value="<?php echo @_BACK; ?>
" name="_form_control_cancel" />
    </td>
  </tr>
</table>
</form>