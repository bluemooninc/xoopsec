<?php /* Smarty version 2.6.26, created on 2012-08-27 23:07:21
         compiled from db:myshop_thankyou.html */ ?>
<?php echo $this->_tpl_vars['breadcrumb']; ?>

<br />
<?php if ($this->_tpl_vars['global_advert'] != ''): ?>
	<div align='center'><?php echo $this->_tpl_vars['global_advert']; ?>
</div>
	<br />
<?php endif; ?>

<br />
<?php if ($this->_tpl_vars['success']): ?>
	<h3><?php echo @_MYSHOP_THANK_YOU; ?>
</h3>
	<br />
	<br />
	<h4><?php echo @_MYSHOP_TRANSACTION_FINSIHED; ?>
</h4>
<?php else: ?>
	<h3><?php echo @_MYSHOP_PAYPAL_FAILED; ?>
</h3>
<?php endif; ?>
<br />
<br />
<a href="<?php echo @MYSHOP_URL; ?>
"><?php echo @_MYSHOP_CONTINUE_SHOPPING; ?>
</a>