<?php /* Smarty version 2.6.26, created on 2012-08-27 17:52:09
         compiled from db:legacy_comment_navi.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'db:legacy_comment_navi.html', 5, false),array('function', 'xoops_input', 'db:legacy_comment_navi.html', 10, false),array('modifier', 'xoops_escape', 'db:legacy_comment_navi.html', 13, false),)), $this); ?>
<form method="get" action="<?php echo $this->_tpl_vars['pageName']; ?>
">
  <table width="95%" class="outer" cellspacing="1">
    <tr>
      <td class="even" align="center">
        <?php echo smarty_function_html_options(array('name' => 'com_mode','options' => $this->_tpl_vars['modeOptions'],'selected' => $this->_tpl_vars['com_mode']), $this);?>

        <?php echo smarty_function_html_options(array('name' => 'com_order','options' => $this->_tpl_vars['orderOptions'],'selected' => $this->_tpl_vars['com_order']), $this);?>

        <input type="hidden" name="<?php echo $this->_tpl_vars['itemName']; ?>
" value="<?php echo $this->_tpl_vars['com_itemid']; ?>
" />
        <input type="submit" value="<?php echo @_CM_REFRESH; ?>
" class="formButton" />
        <?php $_from = $this->_tpl_vars['extraParams']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
          <?php echo smarty_function_xoops_input(array('type' => 'hidden','name' => $this->_tpl_vars['key'],'value' => $this->_tpl_vars['value']), $this);?>

        <?php endforeach; endif; unset($_from); ?>
		<?php if ($this->_tpl_vars['postcomment_link']): ?>
          <input type="button" onclick="self.location.href='<?php echo ((is_array($_tmp=$this->_tpl_vars['postcomment_link'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'link') : smarty_modifier_xoops_escape($_tmp, 'link')); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['link_extra'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'link') : smarty_modifier_xoops_escape($_tmp, 'link')); ?>
'" class="formButton" value="<?php echo @_CM_POSTCOMMENT; ?>
" />
        <?php endif; ?>
    </td>
  </tr>
</table>
</form>