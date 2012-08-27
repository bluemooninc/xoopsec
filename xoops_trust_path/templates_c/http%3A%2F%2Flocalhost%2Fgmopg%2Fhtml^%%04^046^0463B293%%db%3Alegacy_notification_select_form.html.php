<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:59
         compiled from db:legacy_notification_select_form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'db:legacy_notification_select_form.html', 19, false),array('modifier', 'xoops_escape', 'db:legacy_notification_select_form.html', 32, false),)), $this); ?>
<?php if ($this->_tpl_vars['xoops_notification']['show']): ?>
<form name="notification_select" action="<?php echo $this->_tpl_vars['xoops_notification']['target_page']; ?>
" method="post">
<h4 style="text-align:center;"><?php echo @_NOT_ACTIVENOTIFICATIONS; ?>
</h4>
<input type="hidden" name="not_redirect" value="<?php echo $this->_tpl_vars['xoops_notification']['redirect_script']; ?>
" />
<table class="outer">
  <tr><th colspan="3"><?php echo @_NOT_NOTIFICATIONOPTIONS; ?>
</th></tr>
  <tr>
    <td class="head"><?php echo @_NOT_CATEGORY; ?>
</td>
    <td class="head"><input name="allbox" id="allbox" onclick="xoopsCheckAll('notification_select','allbox');" type="checkbox" value="<?php echo @_NOT_CHECKALL; ?>
" /></td>
    <td class="head"><?php echo @_NOT_EVENT; ?>
</td>
  </tr>
  <?php $_from = $this->_tpl_vars['xoops_notification']['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['category']):
        $this->_foreach['outer']['iteration']++;
?>
  <?php $_from = $this->_tpl_vars['category']['events']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['inner'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['inner']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['event']):
        $this->_foreach['inner']['iteration']++;
?>
  <tr>
    <?php if (($this->_foreach['inner']['iteration'] <= 1)): ?>
    <td class="even" rowspan="<?php echo $this->_foreach['inner']['total']; ?>
"><?php echo $this->_tpl_vars['category']['title']; ?>
</td>
    <?php endif; ?>
    <td class="odd">
    <?php echo smarty_function_counter(array('assign' => 'index'), $this);?>

    <input type="hidden" name="not_list[<?php echo $this->_tpl_vars['index']; ?>
][params]" value="<?php echo $this->_tpl_vars['category']['name']; ?>
,<?php echo $this->_tpl_vars['category']['itemid']; ?>
,<?php echo $this->_tpl_vars['event']['name']; ?>
" />
    <input type="checkbox" id="not_list_<?php echo $this->_tpl_vars['category']['itemid']; ?>
_<?php echo $this->_tpl_vars['index']; ?>
" name="not_list[<?php echo $this->_tpl_vars['index']; ?>
][status]" value="1" <?php if ($this->_tpl_vars['event']['subscribed']): ?>checked="checked"<?php endif; ?> />
    </td>
    <td class="odd"><?php echo $this->_tpl_vars['event']['caption']; ?>
</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
  <?php endforeach; endif; unset($_from); ?>
  <tr>
    <td class="foot" colspan="3" align="center"><input type="submit" name="not_submit" value="<?php echo @_NOT_UPDATENOW; ?>
" /></td>
  </tr>
</table>
<div align="center">
<?php echo @_NOT_NOTIFICATIONMETHODIS; ?>
:&nbsp;<?php echo $this->_tpl_vars['user_method']; ?>
&nbsp;&nbsp;[<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['editprofile_url'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'link') : smarty_modifier_xoops_escape($_tmp, 'link')); ?>
"><?php echo @_NOT_CHANGE; ?>
</a>]
</div>
</form>
<?php endif; ?>