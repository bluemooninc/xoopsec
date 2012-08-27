<?php /* Smarty version 2.6.26, created on 2012-08-27 23:23:46
         compiled from file:block_uninstall.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'xoops_token', 'file:block_uninstall.html', 20, false),array('function', 'xoops_input', 'file:block_uninstall.html', 21, false),array('function', 'cycle', 'file:block_uninstall.html', 28, false),array('modifier', 'xoops_formattimestamp', 'file:block_uninstall.html', 120, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <a href="./index.php?action=BlockList"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_AD_LEGACY_LANG_BLOCK_UNINSTALL; ?>
</span>
</div>

<h3 class="admintitle"><?php echo @_AD_LEGACY_LANG_BLOCK_UNINSTALL; ?>
</h3>

<div class="confirm"><?php echo @_AD_LEGACY_MESSAGE_CONFIRM_DELETE; ?>
</div>

<div class="tips">
  <?php if ($this->_tpl_vars['object']->get('block_type') == 'C'): ?>
    <?php echo @_AD_LEGACY_TIPS_CUSTOM_BLOCK_UNINSTALL; ?>

  <?php else: ?>
    <?php echo @_AD_LEGACY_TIPS_BLOCK_UNINSTALL; ?>

  <?php endif; ?>
</div>

<form method="post" action="./index.php?action=BlockUninstall">
<?php echo smarty_function_xoops_token(array('form' => $this->_tpl_vars['actionForm']), $this);?>

<?php echo smarty_function_xoops_input(array('type' => 'hidden','name' => 'bid','value' => $this->_tpl_vars['actionForm']->get('bid')), $this);?>

<table class="outer">
  <tr>
    <th colspan="2"><?php echo @_AD_LEGACY_LANG_BLOCK_UNINSTALL; ?>
</th>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_BID; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('bid'); ?>
</td>
  </tr>
  <tr>
  <td class="head"><?php echo @_AD_LEGACY_LANG_BLOCK_MOD; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('mid'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_FUNC_NUM; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('func_num'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_OPTIONS; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('options'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_NAME; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('name'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_TITLE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('title'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_CONTENT; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('content'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_SIDE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
      <?php if ($this->_tpl_vars['object']->mColumn): ?><?php echo $this->_tpl_vars['object']->mColumn->getShow('name'); ?>
<?php endif; ?>
    </td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_WEIGHT; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('weight'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_VISIBLE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
      <?php if ($this->_tpl_vars['object']->getShow('visible') == 1): ?>
        <?php echo @_YES; ?>

      <?php else: ?>
        <?php echo @_YES; ?>

      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_BLOCK_TYPE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('block_type'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_C_TYPE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('c_type'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_ISACTIVE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
      <?php if ($this->_tpl_vars['object']->getShow('isactive') == 1): ?>
        <?php echo @_YES; ?>

      <?php else: ?>
        <?php echo @_YES; ?>

      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_DIRNAME; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('dirname'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_FUNC_FILE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('func_file'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_SHOW_FUNC; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('show_func'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_EDIT_FUNC; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('edit_func'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_TEMPLATE; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo $this->_tpl_vars['object']->getShow('template'); ?>
</td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_BCACHETIME; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
      <?php if ($this->_tpl_vars['object']->mCachetime): ?><?php echo $this->_tpl_vars['object']->mCachetime->getShow('label'); ?>
<?php endif; ?>
    </td>
  </tr>
  <tr>
    <td class="head"><?php echo @_AD_LEGACY_LANG_LAST_MODIFIED; ?>
</td>
    <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['object']->get('last_modified'))) ? $this->_run_mod_handler('xoops_formattimestamp', true, $_tmp, 'l') : smarty_modifier_xoops_formattimestamp($_tmp, 'l')); ?>
</td>
  </tr>
  <tr>
    <td class="foot" colspan="2">
        <input class="formButton" type="submit" value="<?php echo @_DELETE; ?>
" />
        <input class="formButton" type="submit" value="<?php echo @_BACK; ?>
" name="_form_control_cancel" />
    </td>
  </tr>
</table>
</form>