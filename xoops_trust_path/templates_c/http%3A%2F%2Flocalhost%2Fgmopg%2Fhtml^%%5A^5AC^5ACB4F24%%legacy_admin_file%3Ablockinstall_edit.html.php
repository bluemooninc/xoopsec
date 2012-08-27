<?php /* Smarty version 2.6.26, created on 2012-08-27 17:53:07
         compiled from file:blockinstall_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:blockinstall_edit.html', 13, false),array('function', 'xoops_token', 'file:blockinstall_edit.html', 20, false),array('function', 'xoops_input', 'file:blockinstall_edit.html', 21, false),array('function', 'cycle', 'file:blockinstall_edit.html', 31, false),array('function', 'xoops_optionsArray', 'file:blockinstall_edit.html', 39, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <a href="./index.php?action=BlockList"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_AD_LEGACY_LANG_BLOCK_INSTALL; ?>
</span>
</div>

<h3 class="admintitle"><?php echo @_AD_LEGACY_LANG_BLOCK_INSTALL; ?>
</h3>

<?php if ($this->_tpl_vars['actionForm']->hasError()): ?>
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

<form action="index.php?action=BlockInstallEdit" method="post">
  <?php echo smarty_function_xoops_token(array('form' => $this->_tpl_vars['actionForm']), $this);?>

  <?php echo smarty_function_xoops_input(array('type' => 'hidden','name' => 'bid','value' => $this->_tpl_vars['actionForm']->get('bid')), $this);?>

  <?php if (! $this->_tpl_vars['hasVisibleOptionForm'] && $this->_tpl_vars['optionForm'] != null): ?>
    <?php echo $this->_tpl_vars['optionForm']; ?>

  <?php endif; ?>
  <table class="outer">
    <tr>
      <th colspan="2"><?php echo @_AD_LEGACY_LANG_BLOCK_INSTALL; ?>
</th>
    </tr>
    <tr>
      <td class="head"><?php echo @_AD_LEGACY_LANG_TITLE; ?>
</td>
      <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
        <?php echo smarty_function_xoops_input(array('type' => 'text','name' => 'title','value' => $this->_tpl_vars['actionForm']->get('title'),'size' => 50,'maxlength' => 255), $this);?>

      </td>
    </tr>
    <tr>
      <td class="head"><?php echo @_AD_LEGACY_LANG_SIDE; ?>
</td>
      <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
        <select name="side">
          <?php echo smarty_function_xoops_optionsArray(array('id' => 'side','from' => $this->_tpl_vars['columnSideArr'],'value' => 'id','label' => 'name','default' => $this->_tpl_vars['actionForm']->get('side')), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="head"><?php echo @_AD_LEGACY_LANG_WEIGHT; ?>
</td>
      <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
        <?php echo smarty_function_xoops_input(array('type' => 'text','name' => 'weight','value' => $this->_tpl_vars['actionForm']->get('weight'),'size' => 5,'class' => 'legacy_list_number'), $this);?>

      </td>
    </tr>
    <tr>
      <td class="head"><?php echo @_AD_LEGACY_LANG_BCACHETIME; ?>
</td>
      <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
        <select name='bcachetime'>
          <?php echo smarty_function_xoops_optionsArray(array('id' => 'bcachetime','from' => $this->_tpl_vars['cachetimeArr'],'value' => 'cachetime','label' => 'label','default' => $this->_tpl_vars['actionForm']->get('bcachetime')), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="head"><?php echo @_AD_LEGACY_LANG_TARGET_MODULES; ?>
</td>
      <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
        <select  size='5' name='bmodule[]' multiple='multiple'>
          <?php echo smarty_function_xoops_optionsArray(array('id' => "bmodule[]",'label' => 'name','value' => 'mid','from' => $this->_tpl_vars['moduleArr'],'default' => $this->_tpl_vars['actionForm']->get('bmodule')), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="head"><?php echo @_AD_LEGACY_LANG_TARGET_GROUPS; ?>
</td>
      <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
        <select  size='5' name='groupid[]' multiple='multiple'>
          <?php echo smarty_function_xoops_optionsArray(array('id' => "groupid[]",'label' => 'name','value' => 'groupid','from' => $this->_tpl_vars['groupArr'],'default' => $this->_tpl_vars['actionForm']->get('groupid')), $this);?>

        </select>
      </td>
    </tr>
    <?php if ($this->_tpl_vars['hasVisibleOptionForm'] && $this->_tpl_vars['optionForm'] != null): ?>
      <tr>
        <td class="head"><?php echo @_AD_LEGACY_LANG_OPTIONS; ?>
</td>
        <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
          <?php echo $this->_tpl_vars['optionForm']; ?>

        </td>
      </tr>
    <?php endif; ?>
    <tr>
      <td colspan="2" class="foot">
        <input class="formButton" type="submit" value="<?php echo @_INSTALL; ?>
" />
        <input class="formButton" type="submit" value="<?php echo @_BACK; ?>
" name="_form_control_cancel" />
      </td>
    </tr>
  </table>
</form>