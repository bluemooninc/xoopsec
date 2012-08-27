<?php /* Smarty version 2.6.26, created on 2012-08-27 17:53:17
         compiled from db:myshop_block_new.html */ ?>
<table border="0" class="myshop_productindex">
    <?php $_from = $this->_tpl_vars['block']['block_products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
    <tr>
        <td class="myshop_productthumb">
            <?php if ($this->_tpl_vars['product']['product_thumb_url']): ?>
            <a href="<?php echo $this->_tpl_vars['product']['product_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
">
                <img width="100%" src="<?php echo $this->_tpl_vars['product']['product_thumb_full_url']; ?>
" alt="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
"
                     border="0"/>
            </a>
            <?php endif; ?>
        </td>
        <td class="myshop_productssummary">
            <table width="100%" cellspacing="0">
                <tr>
                    <td class="page-curl_01">
                        <div class="myshop_producttitle">
                            <?php echo $this->_tpl_vars['product']['product_recommended_picture']; ?>

                            <a href="<?php echo $this->_tpl_vars['product']['product_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
">
                                <?php echo $this->_tpl_vars['product']['product_title']; ?>

                            </a>
                        </div>
                        <div class="myshop_productauthor">
                            <?php if ($this->_tpl_vars['product']['product_joined_manufacturers'] != ''): ?>
                            <img width="100%" src="<?php echo @MYSHOP_IMAGES_URL; ?>
manufacturers.png" alt=""
                                 border="0"/>
                            <?php echo @_MYSHOP_BY; ?>
 <?php echo $this->_tpl_vars['product']['product_joined_manufacturers']; ?>

                            <?php endif; ?>
                        </div>
                        <div class="myshop_productprice">
                            <br/>
                            <?php if ($this->_tpl_vars['product']['product_stock'] > 0): ?>
                            <?php echo @_MYSHOP_PRICE; ?>

                            <?php if ($this->_tpl_vars['product']['product_discount_price_ttc'] != ''): ?>
                            <s><?php echo $this->_tpl_vars['product']['product_price_ttc']; ?>
</s>
                            <?php echo $this->_tpl_vars['product']['product_discount_price_ttc']; ?>
<?php else: ?><?php echo $this->_tpl_vars['product']['product_price_ttc']; ?>
<?php endif; ?>
                            <a class="btn btn-primary"
                               href="<?php echo @MYSHOP_URL; ?>
caddy.php?op=addproduct&product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
"
                               title="<?php echo @_MYSHOP_ADD_TO_CART; ?>
">
                                <i class="icon-white icon-shopping-cart"></i>
                                <?php echo @_MYSHOP_ADD_TO_CART; ?>

                            </a>
                            <?php else: ?>
                            <?php echo $this->_tpl_vars['block']['nostock_msg']; ?>

                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>