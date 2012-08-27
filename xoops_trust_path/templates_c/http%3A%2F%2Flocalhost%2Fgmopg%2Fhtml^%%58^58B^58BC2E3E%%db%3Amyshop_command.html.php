<?php /* Smarty version 2.6.26, created on 2012-08-27 17:53:25
         compiled from db:myshop_command.html */ ?>
<?php echo $this->_tpl_vars['breadcrumb']; ?>

<br />
<?php if ($this->_tpl_vars['global_advert'] != ''): ?>
	<div align='center'><?php echo $this->_tpl_vars['global_advert']; ?>
</div>
	<br />
<?php endif; ?>

<h2><?php echo @_MYSHOP_VALIDATE_CMD; ?>
</h2>
<br />
<?php if ($this->_tpl_vars['text'] != ''): ?>
	<div><?php echo $this->_tpl_vars['text']; ?>
</div>
	<br />
<?php endif; ?>
<?php echo $this->_tpl_vars['form']; ?>

<?php if ($this->_tpl_vars['op'] == 'paypal'): ?>
	<br /><div align="center"><b><?php echo @_MYSHOP_DETAILS_EMAIL; ?>
</b></div><br />
<?php else: ?>
	<br /><b><?php echo @_MYSHOP_REQUIRED; ?>
</b>
<?php endif; ?>