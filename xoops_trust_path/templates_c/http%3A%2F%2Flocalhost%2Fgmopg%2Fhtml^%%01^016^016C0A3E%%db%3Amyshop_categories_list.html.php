<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:59
         compiled from db:myshop_categories_list.html */ ?>
<?php if (count ( $this->_tpl_vars['categories'] ) > 0): ?>
	<table width="100%" cellspacing="0">
  	<tr>
    	<td class="category-list">
			<table border='0' cellspacing='5' cellpadding='0' align='center' class="myshop_categorylist">
			<tr>
				<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category']):
?>
					<td valign="top">
						<a href="<?php echo $this->_tpl_vars['category']['cat_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['category']['cat_href_title']; ?>
">
                            <?php if ($this->_tpl_vars['category']['cat_imgurl'] != ''): ?>
                                <img src="<?php echo $this->_tpl_vars['category']['cat_full_imgurl']; ?>
" width="100%" border="0" alt="" />
                            <?php else: ?>
                                <img src="<?php echo @MYSHOP_IMAGES_URL; ?>
icon-cat.png" alt="" />
                            <?php endif; ?>
						<b><?php echo $this->_tpl_vars['category']['cat_title']; ?>
</b></a>
	    			</td>
    				<?php if (!($this->_tpl_vars['category']['count'] % 3)): ?>
	    				</tr><tr>
	    			<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
			</tr>
			</table>
			<?php if (isset ( $this->_tpl_vars['total_products_count'] ) && total_products_count > 0): ?>
				<br /><br />
				<?php echo $this->_tpl_vars['total_products_count']; ?>

			<?php endif; ?>
		</td>
  	</tr>
  	
	</table>
<?php endif; ?>