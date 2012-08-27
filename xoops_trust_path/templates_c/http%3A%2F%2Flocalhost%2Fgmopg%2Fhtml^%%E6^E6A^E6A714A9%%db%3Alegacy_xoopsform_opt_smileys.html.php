<?php /* Smarty version 2.6.26, created on 2012-08-27 17:48:37
         compiled from db:legacy_xoopsform_opt_smileys.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'db:legacy_xoopsform_opt_smileys.html', 2, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['smilesArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['smiles']):
?>
  <a href="#" onclick='xoopsCodeSmilie("<?php echo $this->_tpl_vars['element']->getId(); ?>
", "<?php echo $this->_tpl_vars['smiles']->getShow('code'); ?>
"); return false;'><img src='<?php echo @XOOPS_UPLOAD_URL; ?>
/<?php echo $this->_tpl_vars['smiles']->getShow('smile_url'); ?>
' alt='<?php echo ((is_array($_tmp=$this->_tpl_vars['smiles']->mVars['emotion']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' title='<?php echo ((is_array($_tmp=$this->_tpl_vars['smiles']->mVars['emotion']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' /></a>
<?php endforeach; endif; unset($_from); ?>
&nbsp;[<a href='#moresmiley' onclick='javascript:openWithSelfMain("<?php echo $this->_tpl_vars['xoops_url']; ?>
/misc.php?action=showpopups&amp;type=smilies&amp;target=<?php echo $this->_tpl_vars['element']->getId(); ?>
", "smilies", 300, 500);'><?php echo @_MORE; ?>
</a>]