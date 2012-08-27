<?php /* Smarty version 2.6.26, created on 2012-08-27 22:47:15
         compiled from db:myshop_block_cart.html */ ?>
<!-- Created by Instant Zero (http://www.instant-zero.com) -->
<link href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/myshop/include/myshop.css" rel="stylesheet" type="text/css"/>
<ul>
    <?php $_from = $this->_tpl_vars['block']['block_caddieProducts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
    <li><a href="<?php echo $this->_tpl_vars['product']['product_url_rewrited']; ?>
"
           title="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
"><?php echo $this->_tpl_vars['product']['product_title']; ?>
</a></li>
    <?php endforeach; endif; unset($_from); ?>
</ul>
<hr />

<table align="center">
    <tr>
    <td><?php echo @_MYSHOP_PURCHASE_PRICE; ?>
 : </td><td align="right"><?php echo $this->_tpl_vars['block']['block_commandAmountWithTax']; ?>
</td>
    </tr>
    <tr>
        <td><?php echo @_MYSHOP_SHIPPING_PRICE; ?>
 : </td><td align="right"><?php echo $this->_tpl_vars['block']['block_shippingAmount']; ?>
</td>
    </tr>
    <tr>
        <td><b><?php echo @_MYSHOP_TOTAL; ?>
 : </b></td><td align="right"><b><?php echo $this->_tpl_vars['block']['block_commandAmountTTC']; ?>
</b></td>
    </tr>
</table>
<br/>
<div class="pagination-centered">
    <a class="btn btn-info" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/myshop/caddy.php">
    <i class="icon-white icon-shopping-cart"></i><?php echo @_MYSHOP_CART; ?>

    </a>
</div>