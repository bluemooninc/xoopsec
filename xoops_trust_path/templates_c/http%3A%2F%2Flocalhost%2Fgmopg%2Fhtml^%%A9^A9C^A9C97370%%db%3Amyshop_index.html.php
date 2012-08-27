<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:59
         compiled from db:myshop_index.html */ ?>
<?php if ($this->_tpl_vars['welcome_msg'] != ''): ?>
<div id="myshop_welcome"><?php echo $this->_tpl_vars['welcome_msg']; ?>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['mod_pref']['advertisement'] != ''): ?>
<div id="myshop_publicite"><?php echo $this->_tpl_vars['mod_pref']['advertisement']; ?>
</div><?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:myshop_categories_list.html", 'smarty_include_vars' => array('categories' => $this->_tpl_vars['categories'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="myshop_caddy" align="right">
    <a href="<?php echo @MYSHOP_URL; ?>
caddy.php" title="<?php echo @_MYSHOP_CART; ?>
"><img
            src="<?php echo @MYSHOP_IMAGES_URL; ?>
cart.png" alt="<?php echo @_MYSHOP_CART; ?>
" border="0"/></a>&nbsp;
    <?php if ($this->_tpl_vars['mod_pref']['rss']): ?>
    <a href="<?php echo @MYSHOP_URL; ?>
rss.php" title="<?php echo @_MYSHOP_RSS_FEED; ?>
"><img
            src="<?php echo @MYSHOP_IMAGES_URL; ?>
feed.png" alt="<?php echo @_MYSHOP_RSS_FEED; ?>
" border="0"/></a>
    <?php endif; ?>
</div>



<?php if (count ( $this->_tpl_vars['products'] ) > 0): ?>
<h2><?php echo @_MYSHOP_MOST_RECENT; ?>
</h2>
<table border="0" class="myshop_productindex">
    <?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
    <tr>
        <td class="myshop_productthumb">
            <?php if ($this->_tpl_vars['product']['product_thumb_url']): ?>
            <a href="<?php echo $this->_tpl_vars['product']['product_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
">
                <img src="<?php echo $this->_tpl_vars['product']['product_thumb_full_url']; ?>
" alt="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
" border="0"/>
            </a>
            <?php endif; ?>
        </td>
        <td class="myshop_productssummary">

            <table width="100%" cellspacing="0">
                <tr>
                    <td>
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
                            <img src="<?php echo @MYSHOP_IMAGES_URL; ?>
manufacturers.png" alt="" border="0"/>
                            <?php echo @_MYSHOP_BY; ?>
 <?php echo $this->_tpl_vars['product']['product_joined_manufacturers']; ?>

                            <?php endif; ?>
                        </div>
                        <?php if ($this->_tpl_vars['mod_pref']['use_price']): ?>
                        <div class="myshop_productprice">
                            <?php if ($this->_tpl_vars['product']['product_stock'] > 0): ?>
                                <p>
                                <?php echo @_MYSHOP_PRICE; ?>

                                <?php if ($this->_tpl_vars['product']['product_discount_price_ttc'] != ''): ?>
                                    <s><?php echo $this->_tpl_vars['product']['product_price_ttc']; ?>
</s>
                                    <?php echo $this->_tpl_vars['product']['product_discount_price_ttc']; ?>

                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['product']['product_price_ttc']; ?>

                                <?php endif; ?>
                                </p>
                            <a class="btn btn-primary btn-large"
                               href="<?php echo @MYSHOP_URL; ?>
caddy.php?op=addproduct&product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
"
                               title="<?php echo @_MYSHOP_ADD_TO_CART; ?>
">
                                <i class="icon-white icon-shopping-cart"></i>
                                <?php echo @_MYSHOP_ADD_TO_CART; ?>

                            </a>
                            <?php else: ?>
                            <?php echo $this->_tpl_vars['mod_pref']['nostock_msg']; ?>

                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<?php if ($this->_tpl_vars['pagenav'] != ''): ?>
<br/>
<div align="center"><?php echo $this->_tpl_vars['pagenav']; ?>
</div>
<?php endif; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'db:legacy_notification_select.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>