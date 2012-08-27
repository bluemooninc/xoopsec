<?php /* Smarty version 2.6.26, created on 2012-08-27 17:48:10
         compiled from db:legacy_xoopsform_opt_validationjs.html */ ?>
<?php if ($this->_tpl_vars['withtags']): ?>
  <!-- Start Form Vaidation JavaScript //-->
  <script type='text/javascript'>
  <!--//
<?php endif; ?>

function xoopsFormValidate_<?php echo $this->_tpl_vars['form']->getName(); ?>
() {
	myform = window.document.<?php echo $this->_tpl_vars['form']->getName(); ?>
;
	<?php $_from = $this->_tpl_vars['required']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['t_required']):
?>
	  if (myform.<?php echo $this->_tpl_vars['t_required']->getName(); ?>
.value == "") {
	    window.alert("<?php echo $this->_tpl_vars['t_required']->getMessageForJS(); ?>
");
	    myform.<?php echo $this->_tpl_vars['t_required']->getName(); ?>
.focus();
	    return false;
	  }
	<?php endforeach; endif; unset($_from); ?>
	return true;
}

<?php if ($this->_tpl_vars['withtags']): ?>
  //-->
  </script>
  <!-- End Form Vaidation JavaScript //-->
<?php endif; ?>