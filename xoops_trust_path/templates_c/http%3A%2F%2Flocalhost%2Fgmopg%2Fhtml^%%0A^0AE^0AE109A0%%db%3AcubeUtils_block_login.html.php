<?php /* Smarty version 2.6.26, created on 2012-08-28 13:54:24
         compiled from db:cubeUtils_block_login.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'xoops_input', 'db:cubeUtils_block_login.html', 3, false),)), $this); ?>
<form action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/user.php" method="post" style="margin-top: 0px;">
    <?php echo $this->_tpl_vars['block']['lang_username']; ?>
<br />
    <?php echo smarty_function_xoops_input(array('type' => 'text','name' => 'uname','size' => 12,'value' => $this->_tpl_vars['block']['unamevalue'],'maxlength' => 25,'id' => (@XOOPS_INPUT_DEFID_PREFIX)."block_uname"), $this);?>
<br />
    <?php echo $this->_tpl_vars['block']['lang_password']; ?>
<br />
    <?php echo smarty_function_xoops_input(array('type' => 'password','name' => 'pass','size' => 12,'maxlength' => 32,'id' => (@XOOPS_INPUT_DEFID_PREFIX)."block_pass"), $this);?>
<br />
    <label><?php echo smarty_function_xoops_input(array('type' => 'checkbox','name' => 'rememberme','value' => 'On','class' => 'formButton'), $this);?>
<?php echo $this->_tpl_vars['block']['lang_rememberme']; ?>
</label><br />
    <input type="hidden" name="xoops_redirect" value="<?php echo $this->_tpl_vars['xoops_requesturi']; ?>
" />
    <?php echo smarty_function_xoops_input(array('type' => 'hidden','name' => 'op','value' => 'login','id' => (@XOOPS_INPUT_DEFID_PREFIX)."block_op"), $this);?>

    <?php echo smarty_function_xoops_input(array('type' => 'submit','name' => 'submit','value' => $this->_tpl_vars['block']['lang_login'],'id' => (@XOOPS_INPUT_DEFID_PREFIX)."block_submit"), $this);?>
<br />
</form>
<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/lostpass.php"><?php echo $this->_tpl_vars['block']['lang_lostpass']; ?>
</a>
<br /><br />
<?php if ($this->_tpl_vars['block']['allow_register'] == '1'): ?>
  <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/register.php"><?php echo $this->_tpl_vars['block']['lang_registernow']; ?>
</a>
<?php endif; ?>