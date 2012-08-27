<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:45
         compiled from file:preference_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:preference_edit.html', 3, false),array('function', 'xoops_token', 'file:preference_edit.html', 36, false),array('function', 'xoops_input', 'file:preference_edit.html', 37, false),array('function', 'cycle', 'file:preference_edit.html', 60, false),array('function', 'xoops_textarea', 'file:preference_edit.html', 62, false),array('function', 'xoops_optionsArray', 'file:preference_edit.html', 101, false),)), $this); ?>
<div class="adminnavi">
  <?php if ($this->_tpl_vars['module'] != null): ?>
    <a href="<?php echo @XOOPS_URL; ?>
/modules/<?php echo $this->_tpl_vars['module']->getVar('dirname'); ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['module']->getInfo('adminindex'))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['module']->getVar('name'); ?>
</a>
    <?php if ($this->_tpl_vars['category'] != null): ?>
      &raquo;&raquo; <a href="<?php echo @XOOPS_URL; ?>
/modules/<?php echo $this->_tpl_vars['module']->getVar('dirname'); ?>
/admin/index.php?action=PreferenceList"><?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>
</a>
      &raquo;&raquo; <?php echo ((is_array($_tmp=$this->_tpl_vars['category']->getName())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

    <?php else: ?>
      &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>
</span>
    <?php endif; ?>
  <?php else: ?>
    <a href="<?php echo @XOOPS_URL; ?>
/modules/legacy/admin/index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
    &raquo;&raquo; <a href="./index.php?action=PreferenceList"><?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>
</a>
    &raquo;&raquo; <span class="adminnaviTitle"><?php echo ((is_array($_tmp=$this->_tpl_vars['category']->getName())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</span>
  <?php endif; ?>
</div>

<h3 class="admintitle">
  <?php if ($this->_tpl_vars['category'] != null): ?>
    <?php echo ((is_array($_tmp=$this->_tpl_vars['category']->getName())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

  <?php else: ?>
    <?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>

  <?php endif; ?>
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

<form action="./index.php?action=PreferenceEdit" method="post">
  <?php echo smarty_function_xoops_token(array('form' => $this->_tpl_vars['actionForm']), $this);?>

  <?php echo smarty_function_xoops_input(array('type' => 'hidden','name' => $this->_tpl_vars['actionForm']->mKeyName,'value' => $this->_tpl_vars['actionForm']->mKeyValue), $this);?>

  <table class="outer">
    <tr>
      <th colspan="2">
        <?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>

        <?php if ($this->_tpl_vars['category'] != null): ?>
           - <?php echo ((is_array($_tmp=$this->_tpl_vars['category']->getName())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>

        <?php endif; ?>
      </th>
    </tr>

    <?php $_from = $this->_tpl_vars['objectArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['config']):
?>
      <?php $this->assign('conf_name', $this->_tpl_vars['config']->getVar('conf_name')); ?>
      <?php $this->assign('rconf_name', $this->_tpl_vars['config']->get('conf_name')); ?>
      <?php $this->assign('conf_formtype', $this->_tpl_vars['config']->get('conf_formtype')); ?>
      <tr>
        <td class="head">
          <div class="legacy_list_title"><?php echo $this->_tpl_vars['config']->getTitle(); ?>

          <?php if ($this->_tpl_vars['config']->get('conf_desc') != null): ?>
            <p class="legacy_list_description"><?php echo $this->_tpl_vars['config']->getDesc(); ?>
</p>
          <?php endif; ?>
          </div>
        </td>
        <td class="<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
">
          <?php if ($this->_tpl_vars['conf_formtype'] == 'textarea'): ?>
            <?php echo smarty_function_xoops_textarea(array('name' => $this->_tpl_vars['conf_name'],'rows' => 5,'cols' => 50,'value' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>



          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'server_module'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php $_from = $this->_tpl_vars['config']->getRoledModuleList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
                <option value='<?php echo $this->_tpl_vars['option']; ?>
' <?php if ($this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name']) == $this->_tpl_vars['option']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['option']; ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'select'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php $_from = $this->_tpl_vars['config']->getOptionItems(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
                <option value='<?php echo ((is_array($_tmp=$this->_tpl_vars['option']->getOptionKey())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
' <?php if ($this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name']) == $this->_tpl_vars['option']->getOptionKey()): ?>selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['option']->getOptionLabel())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'select_multi'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
[]' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
' size='5' multiple="multiple">
              <?php $_from = $this->_tpl_vars['config']->getOptionItems(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
                <?php $this->assign('flag', 0); ?>
                <?php $_from = $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['selected']):
?>
                  <?php if ($this->_tpl_vars['option']->getOptionKey() == $this->_tpl_vars['selected']): ?><?php $this->assign('flag', 1); ?><?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['option']->getOptionKey())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['flag']): ?>selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['option']->getOptionLabel())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'yesno'): ?>
                        <label><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => $this->_tpl_vars['rconf_name'],'value' => 1,'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>
<?php echo @_YES; ?>
</label>
            <label><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => $this->_tpl_vars['rconf_name'],'value' => 0,'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>
<?php echo @_NO; ?>
</label>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'theme'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php echo smarty_function_xoops_optionsArray(array('id' => $this->_tpl_vars['conf_name'],'value' => 'dirname','label' => 'dirname','from' => $this->_tpl_vars['themeArr'],'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>

            </select>

            
          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'theme_multi'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
[]' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
' size='5' multiple="multiple">
              <?php echo smarty_function_xoops_optionsArray(array('id' => $this->_tpl_vars['conf_name'],'value' => 'dirname','label' => 'dirname','from' => $this->_tpl_vars['themeArr'],'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>

            </select>
            
            
          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'tplset'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php echo smarty_function_xoops_optionsArray(array('id' => $this->_tpl_vars['conf_name'],'value' => 'tplset_name','label' => 'tplset_name','from' => $this->_tpl_vars['tplsetArr'],'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>

            </select>
            
            
          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'timezone'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php echo smarty_function_xoops_optionsArray(array('id' => $this->_tpl_vars['conf_name'],'value' => 'offset','label' => 'zone_name','from' => $this->_tpl_vars['timezoneArr'],'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>

            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'language'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php $_from = $this->_tpl_vars['languageArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['language']):
?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['language'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name']) == $this->_tpl_vars['language']): ?>selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['language'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'startpage'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <option value="--"><?php echo @_AD_LEGACY_LANG_NONE; ?>
</option>
              <?php echo smarty_function_xoops_optionsArray(array('id' => $this->_tpl_vars['conf_name'],'value' => 'mid','label' => 'name','from' => $this->_tpl_vars['moduleArr'],'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>

            </select>
            
            
          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'group'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php echo smarty_function_xoops_optionsArray(array('id' => $this->_tpl_vars['conf_name'],'value' => 'groupid','label' => 'name','from' => $this->_tpl_vars['groupArr'],'default' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>

            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'group_multi'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
[]' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
' size='3' multiple="multiple">
              <?php $_from = $this->_tpl_vars['groupArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group']):
?>
                <?php $this->assign('flag', 0); ?>
                <?php $_from = $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['selected']):
?>
                  <?php if ($this->_tpl_vars['group']->get('groupid') == $this->_tpl_vars['selected']): ?><?php $this->assign('flag', 1); ?><?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <option value="<?php echo $this->_tpl_vars['group']->getVar('groupid'); ?>
" <?php if ($this->_tpl_vars['flag']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['group']->getVar('name'); ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'user'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
'>
              <?php $_from = $this->_tpl_vars['userArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['label']):
?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['value'] == $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'user_multi'): ?>
            <select name='<?php echo $this->_tpl_vars['conf_name']; ?>
[]' id='legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
' size='3' multiple="multiple">
              <?php $_from = $this->_tpl_vars['userArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['label']):
?>
                <?php $this->assign('flag', 0); ?>
                <?php $_from = $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['selected']):
?>
                  <?php if ($this->_tpl_vars['value'] == $this->_tpl_vars['selected']): ?><?php $this->assign('flag', 1); ?><?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['flag']): ?>selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['label'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'module_cache'): ?>
            <?php $_from = $this->_tpl_vars['moduleArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
			  <?php $this->assign('mcachetime', $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'],$this->_tpl_vars['module']->get('mid'))); ?>
              <?php echo $this->_tpl_vars['module']->getVar('name'); ?>

                <select name="<?php echo $this->_tpl_vars['conf_name']; ?>
[<?php echo $this->_tpl_vars['module']->get('mid'); ?>
]" id="legacy_xoopsform_<?php echo $this->_tpl_vars['conf_name']; ?>
_<?php echo $this->_tpl_vars['module']->get('mid'); ?>
">
                  <?php $_from = $this->_tpl_vars['cachetimeArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cachetime']):
?>
                    <?php if ($this->_tpl_vars['mcachetime'] == $this->_tpl_vars['cachetime']->get('cachetime')): ?>
                      <option value="<?php echo $this->_tpl_vars['cachetime']->get('cachetime'); ?>
" selected="selected"><?php echo $this->_tpl_vars['cachetime']->getVar('label'); ?>
</option>
                    <?php else: ?>
                      <option value="<?php echo $this->_tpl_vars['cachetime']->get('cachetime'); ?>
"><?php echo $this->_tpl_vars['cachetime']->getVar('label'); ?>
</option>
                    <?php endif; ?>
                  <?php endforeach; endif; unset($_from); ?>
                </select>
              <br/>
            <?php endforeach; endif; unset($_from); ?>
            
            
          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'password'): ?>
            <?php echo smarty_function_xoops_input(array('type' => 'password','name' => $this->_tpl_vars['rconf_name'],'size' => 50,'maxlength' => 255,'value' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>



          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'textbox'): ?>
            <?php echo smarty_function_xoops_input(array('type' => 'text','name' => $this->_tpl_vars['rconf_name'],'size' => 50,'maxlength' => 255,'value' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>


          <?php elseif ($this->_tpl_vars['conf_formtype'] == 'text'): ?>             <?php echo smarty_function_xoops_input(array('type' => 'text','name' => $this->_tpl_vars['rconf_name'],'size' => 50,'maxlength' => 255,'value' => $this->_tpl_vars['actionForm']->get($this->_tpl_vars['rconf_name'])), $this);?>


          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr>
      <td colspan="2" class="foot">
        <input class="formButton" type="submit" value="<?php echo @_SUBMIT; ?>
" />
        <input class="formButton" type="submit" value="<?php echo @_BACK; ?>
" name="_form_control_cancel" />
      </td>
    </tr>
  </table>
</form>