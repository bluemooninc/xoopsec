<?php /* Smarty version 2.6.26, created on 2012-08-27 17:52:09
         compiled from db:myshop_product.html */ ?>
<?php echo $this->_tpl_vars['breadcrumb']; ?>

<br/>


<?php if ($this->_tpl_vars['category']['cat_advertisement'] != ''): ?>
<div id="myshop_publicite-category"><?php echo $this->_tpl_vars['category']['cat_advertisement']; ?>
</div>

<?php elseif ($this->_tpl_vars['mod_pref']['advertisement'] != ''): ?>
<div id="myshop_publicite"><?php echo $this->_tpl_vars['mod_pref']['advertisement']; ?>
</div>
<?php endif; ?>

<br/>


<table cellspacing="0">
    <tr>
        <td colspan="2" class="myshop_producttitle_view-product"><h2>
            <?php echo $this->_tpl_vars['product']['product_recommended_picture']; ?>
<?php echo $this->_tpl_vars['product']['product_title']; ?>
</h2></td>
    </tr>
    <tr>
        <td class="myshop_productthumb-big">
            <?php if ($this->_tpl_vars['product']['product_thumb_full_url'] != ''): ?>
            <a href="javascript:openWithSelfMain('<?php echo @MYSHOP_URL; ?>
media.php?product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
&type=picture', '',<?php echo @MYSHOP_POPUP_MEDIA_WIDTH; ?>
, <?php echo @MYSHOP_POPUP_MEDIA_HEIGHT; ?>
);"
               title="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
">
                <img src="<?php echo $this->_tpl_vars['product']['product_thumb_full_url']; ?>
" alt="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
"/>
            </a>
            <?php endif; ?>
        </td>
        <td>
            <div class="">
                <?php if ($this->_tpl_vars['product']['product_sku'] != ''): ?>
                <span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_NUMBER; ?>
</span>:
                <?php echo $this->_tpl_vars['product']['product_sku']; ?>

                <?php endif; ?>
                <?php if ($this->_tpl_vars['product']['product_extraid'] != ''): ?>
                <?php echo @_MYSHOP_EXTRA_ID; ?>
: <?php echo $this->_tpl_vars['product']['product_extraid']; ?>

                <?php endif; ?>
            </div>
            <?php if ($this->_tpl_vars['product_joined_manufacturers'] != ''): ?>
            <div class="myshop_productauthor_view-product">
                <img src="<?php echo @MYSHOP_IMAGES_URL; ?>
manufacturers.png" alt="" border="0"/>
                <span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_BY; ?>
</span>
                <?php echo $this->_tpl_vars['product_joined_manufacturers']; ?>

            </div>
            <?php endif; ?>
            <!-- Price box -->
            <?php if ($this->_tpl_vars['mod_pref']['use_price']): ?>
            <div class="myshop_productprice_view-product">
                <div class="myshop_view-product_price">
                    <?php if ($this->_tpl_vars['product']['product_stock'] > 0): ?>
                    <span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_PRICE; ?>
</span>:
                    <?php if ($this->_tpl_vars['product']['product_discount_price_ttc'] != ''): ?>
                    <s><?php echo $this->_tpl_vars['product']['product_price_ttc']; ?>
</s> <?php echo $this->_tpl_vars['product']['product_discount_price_ttc']; ?>

                    <?php else: ?>
                    <?php echo $this->_tpl_vars['product']['product_price_ttc']; ?>

                    <?php endif; ?>
                    <a class="btn btn-primary btn-large"
                       href="<?php echo @MYSHOP_URL; ?>
caddy.php?op=addproduct&product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
"
                       title="<?php echo @_MYSHOP_ADD_TO_CART; ?>
">
                        <i class="icon-white icon-shopping-cart"></i>
                        <?php echo @_MYSHOP_ADD_TO_CART; ?>

                    </a>
                    <?php if ($this->_tpl_vars['product']['product_ecotaxe'] != 0): ?>
                    <br/><span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_ECOTAXE; ?>
</span>
                    : <?php echo $this->_tpl_vars['product']['product_ecotaxe_formated']; ?>

                    <?php endif; ?>
                    <?php else: ?>
                    <?php echo $this->_tpl_vars['mod_pref']['nostock_msg']; ?>

                    <?php endif; ?>
                </div>
                <div class="myshop_view-product_shipping-price">
                    <?php if ($this->_tpl_vars['product']['product_shipping_price'] != 0): ?>
                        <span class="myshop_productdescription-contentTitles">
                            <?php echo @_MYSHOP_SHIPPING_PRICE; ?>

                        </span>: <?php echo $this->_tpl_vars['product']['product_shipping_price_formated']; ?>

                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <br/>
            <?php endif; ?>
            <!-- /Price box -->
            <div class="myshop_productdate">
                <span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_DATE; ?>
</span> :
                <?php echo $this->_tpl_vars['product']['product_date']; ?>

                <?php if ($this->_tpl_vars['product']['product_delivery_time'] > 0): ?>
                <br/><span
                    class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_DELIVERY_TIME; ?>
</span> :
                <?php echo $this->_tpl_vars['product']['product_delivery_time']; ?>
 <?php echo @_MYSHOP_DAYS; ?>

                <?php endif; ?>
            </div>
            <div class="myshop_productlangue"><span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_STORE; ?>
</span>:
                <?php echo $this->_tpl_vars['product']['product_store']['store_name']; ?>

            </div>
            <?php if ($this->_tpl_vars['product']['product_attachment'] != ''): ?>
            <a href="<?php echo @XOOPS_UPLOAD_URL; ?>
/<?php echo $this->_tpl_vars['product']['product_attachment']; ?>
" target="_blank"><img
                    src="<?php echo @MYSHOP_IMAGES_URL; ?>
attach.gif" alt=""/> <?php echo @_MYSHOP_ATTACHED_FILE; ?>
</a>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td colspan='2'>
            <!-- product summary-->
            <?php if ($this->_tpl_vars['product']['product_summary'] != ''): ?>
            <table width="100%" cellspacing="0">

                <tr>
                    <td class="myshop_catdescription">
                        <div class="myshop_productssummary_view-product"><h3><?php echo @_MYSHOP_SUMMARY; ?>
</h3>
                            <?php echo $this->_tpl_vars['product']['product_summary']; ?>

                        </div>
                    </td>
                </tr>

            </table>
            <?php endif; ?>
            <!-- /product summary-->

            <!-- product description -->
            <?php if ($this->_tpl_vars['product']['product_description'] != ''): ?>
            <table width="100%" cellspacing="0">

                <tr>
                    <td class="myshop_catdescription">
                        <div class="myshop_description_view-product"><h3><?php echo @_MYSHOP_DESCRIPTION; ?>
</h3>
                            <?php echo $this->_tpl_vars['product']['product_description']; ?>

                        </div>
                    </td>
                </tr>

            </table>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['product']['product_width'] != '' && $this->_tpl_vars['product']['product_weight'] != 0 && $this->_tpl_vars['product']['product_url'] != ''): ?>
            <div class="myshop_otherinf"><h3><?php echo @_MYSHOP_OTHER_INFORMATIONS; ?>
</h3>

                <div><?php if ($this->_tpl_vars['product']['product_width'] != ''): ?><span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_FORMAT; ?>
</span>:
                    <?php echo $this->_tpl_vars['product']['product_width']; ?>
 x <?php echo $this->_tpl_vars['product']['product_length']; ?>
 <?php echo $this->_tpl_vars['product']['product_unitmeasure1']; ?>
<?php endif; ?>
                </div>
                <div><?php if ($this->_tpl_vars['product']['product_weight'] != 0): ?><span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_WEIGHT; ?>
</span>:
                    <?php echo $this->_tpl_vars['product']['product_weight']; ?>
 <?php echo $this->_tpl_vars['product']['product_unitmeasure2']; ?>
<?php endif; ?>
                </div>
                <div><?php if ($this->_tpl_vars['product']['product_url'] != ''): ?><span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_SITEURL; ?>
</span>:
                    <a href="<?php echo $this->_tpl_vars['product']['product_url']; ?>
" target="_blank"><?php echo @_MYSHOP_URL; ?>
</a><?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (count ( $this->_tpl_vars['product']['attached_files'] ) > 0): ?>
            <div class="myshop_otherinf"><h3><?php echo @_MYSHOP_ATTACHED_FILES; ?>
</h3>
                <?php if ($this->_tpl_vars['product']['attached_mp3_count'] > 0): ?>
                <div><span class="myshop_productdescription-contentTitles"><?php echo @_MYSHOP_MUSIC; ?>
</span>
                    <?php echo $this->_tpl_vars['product']['attached_mp3_html_code']; ?>

                </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['product']['attached_non_mp3_count'] > 0): ?>
                <br/>

                <div>
                    <?php $_from = $this->_tpl_vars['product']['attached_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attachedFile']):
?>
                    <?php if (! $this->_tpl_vars['attachedFile']['file_is_mp3']): ?>
                    <span class="myshop_productdescription-contentTitles"><a
                            href="javascript:openWithSelfMain('<?php echo @MYSHOP_URL; ?>
media.php?product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
&type=attachment&file_id=<?php echo $this->_tpl_vars['attachedFile']['file_id']; ?>
', '',<?php echo @MYSHOP_POPUP_MEDIA_WIDTH; ?>
, <?php echo @MYSHOP_POPUP_MEDIA_HEIGHT; ?>
);"
                            rel="nofollow"><?php echo $this->_tpl_vars['attachedFile']['file_description']; ?>
</a></span><br/>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </td>
    </tr>
</table>


<?php if (count ( $this->_tpl_vars['product_related_products'] ) > 0): ?>
<div id="myshop_related">
    <h2><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
box.png" alt="<?php echo @_MYSHOP_CART; ?>
" border="0"/><?php echo @_MYSHOP_RELATED_PRODUCTS; ?>

    </h2>

    <table align='center' class="myshop_categorylist">
        <tr>
            <?php $_from = $this->_tpl_vars['product_related_products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oneitem']):
?>
            <td valign="top" align="center">
                <div class="myshop_productthumb"><a href="<?php echo $this->_tpl_vars['oneitem']['product_url_rewrited']; ?>
"
                                                    title="<?php echo $this->_tpl_vars['oneitem']['product_href_title']; ?>
"><?php if ($this->_tpl_vars['oneitem']['product_thumb_url']): ?><img src="<?php echo $this->_tpl_vars['oneitem']['product_thumb_full_url']; ?>
"
                                                     alt="<?php echo $this->_tpl_vars['oneitem']['product_href_title']; ?>
"/></a><?php endif; ?>
                </div>
                <a href="<?php echo $this->_tpl_vars['oneitem']['product_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['oneitem']['product_href_title']; ?>
"><?php echo $this->_tpl_vars['product']['product_recommended_picture']; ?>
<b><?php echo $this->_tpl_vars['oneitem']['product_title']; ?>
</b></a>

                <div class="myshop_productprice"><?php echo @_MYSHOP_PRICE; ?>
: <a
                        href="<?php echo @MYSHOP_URL; ?>
caddy.php?op=addproduct&product_id=<?php echo $this->_tpl_vars['oneitem']['product_id']; ?>
"
                        title="<?php echo @_MYSHOP_ADD_TO_CART; ?>
"><?php if ($this->_tpl_vars['oneitem']['product_discount_price_ttc'] != ''): ?><?php echo $this->_tpl_vars['oneitem']['product_discount_price_ttc']; ?>
<?php else: ?><?php echo $this->_tpl_vars['oneitem']['product_price_ttc']; ?>
<?php endif; ?>
                    <?php echo @_MYSHOP_ADD_TO_CART; ?>

                </a></div>
            </td>
            <?php if (!($this->_tpl_vars['oneitem']['count'] % 4)): ?>
        </tr>
        <tr>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </tr>
    </table>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['showprevnextlink'] || $this->_tpl_vars['summarylast'] > 0 || $this->_tpl_vars['summarycategory'] > 0 || $this->_tpl_vars['better_together'] > 0): ?>
<div id="myshop_otherproducts">
    <?php if ($this->_tpl_vars['previous_product_id'] != 0 || $this->_tpl_vars['next_product_id'] != 0): ?>
    <h2><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
box.png" alt="" border="0"/><?php echo @_MYSHOP_OTHER_PRODUCTS; ?>

    </h2>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['previous_product_id'] != 0): ?>
    <br/><a href="<?php echo $this->_tpl_vars['previous_product_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['previous_product_href_title']; ?>
"><img
        src="<?php echo @MYSHOP_IMAGES_URL; ?>
go-previous.png" alt="" border="0"/>
    <?php echo @_MYSHOP_PREVIOUS_PRODUCT; ?>
: <?php echo $this->_tpl_vars['previous_product_title']; ?>
</a>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['next_product_id'] != 0): ?>
    <br/><a href="<?php echo $this->_tpl_vars['next_product_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['next_product_href_title']; ?>
"><img
        src="<?php echo @MYSHOP_IMAGES_URL; ?>
go-next.png" alt="" border="0"/> <?php echo @_MYSHOP_NEXT_PRODUCT; ?>
:
    <?php echo $this->_tpl_vars['next_product_title']; ?>
</a>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['better_together'] > 0 && $this->_tpl_vars['bestwith']): ?>
    <br/><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
star_on.png" alt="" border="0"/>
    <?php echo @_MYSHOP_BEST_WITH; ?>
 <a href="<?php echo $this->_tpl_vars['bestwith']['product_url_rewrited']; ?>
"
                                           title="<?php echo $this->_tpl_vars['bestwith']['product_href_title']; ?>
"><?php echo $this->_tpl_vars['bestwith']['product_title']; ?>
</a>
    <?php endif; ?>

    <?php if (count ( $this->_tpl_vars['product_all_categs'] ) > 0): ?>
    <h2><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
box.png" alt="" border="0"/><?php echo @_MYSHOP_RECENT_CATEGS; ?>

    </h2>
    <table border='0' cellspacing='5' cellpadding='0' align='center' class="myshop_lastproducts">
        <?php $_from = $this->_tpl_vars['product_all_categs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oneitem']):
?>
        <tr>
            <td><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
arrow-black2.png" alt="" border="0"/><a
                    href="<?php echo $this->_tpl_vars['oneitem']['last_categs_product_url_rewrited']; ?>
"
                    title="<?php echo $this->_tpl_vars['oneitem']['last_categs_product_href_title']; ?>
"><?php echo $this->_tpl_vars['oneitem']['last_categs_product_title']; ?>
</a></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tr>
    </table>
    <?php endif; ?>

    <?php if (count ( $this->_tpl_vars['product_current_categ'] ) > 0): ?>
    <h2><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
box.png" alt="" border="0"/><?php echo @_MYSHOP_RECENT_CATEG; ?>

    </h2>
    <table border='0' cellspacing='5' cellpadding='0' align='center' class="myshop_lastproducts">
        <?php $_from = $this->_tpl_vars['product_current_categ']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oneitem']):
?>
        <tr>
            <td><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
arrow-black2.png" alt="" border="0" width="13" height="7"/><a
                    href="<?php echo $this->_tpl_vars['oneitem']['last_categ_product_url_rewrited']; ?>
"
                    title="<?php echo $this->_tpl_vars['oneitem']['last_categ_product_href_title']; ?>
"><?php echo $this->_tpl_vars['oneitem']['last_categ_product_title']; ?>
</a></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tr>
    </table>
    <?php endif; ?>
</div>
<?php endif; ?>


<div id="myshop_caddy" align="right">
    <br/>
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
" border="0"/></a>&nbsp;
    <?php endif; ?>
    <a href="<?php echo $this->_tpl_vars['baseurl']; ?>
&op=print" rel="nofollow" target="_blank" title="<?php echo @_MYSHOP_PRINT_VERSION; ?>
"><img
            src="<?php echo @MYSHOP_IMAGES_URL; ?>
print.png" alt="<?php echo @_MYSHOP_PRINT_VERSION; ?>
"
            border="0"/></a>&nbsp;
    <a href="<?php echo $this->_tpl_vars['mail_link']; ?>
" rel="nofollow" target="_blank" title="<?php echo @_MYSHOP_TELLAFRIEND; ?>
"><img
            src="<?php echo @MYSHOP_IMAGES_URL; ?>
email_send.png" alt="<?php echo @_MYSHOP_TELLAFRIEND; ?>
"
            border="0"/></a>&nbsp;
    <?php if ($this->_tpl_vars['mod_pref']['isAdmin']): ?>
    <a href="<?php echo @MYSHOP_URL; ?>
admin/index.php?op=products&action=edit&id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
"
       target="_blank" title="<?php echo @_EDIT; ?>
"><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
edit.png"
                                                            alt="<?php echo @_EDIT; ?>
"/></a>
    &nbsp;<a href="<?php echo @MYSHOP_URL; ?>
admin/index.php?op=products&action=confdelete&id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
"
             title="<?php echo @_DELETE; ?>
"><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
delete.png"
                                                    alt="<?php echo @_DELETE; ?>
"/></a>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['canChangeQuantity']): ?><a href="<?php echo $this->_tpl_vars['baseurl']; ?>
&stock=add" title="<?php echo $this->_tpl_vars['ProductStockQuantity']; ?>
"><img
        src="<?php echo @MYSHOP_IMAGES_URL; ?>
product_add.png" alt="<?php echo $this->_tpl_vars['ProductStockQuantity']; ?>
"/></a> <?php if ($this->_tpl_vars['product']['product_stock'] -1 > 0): ?><a href="<?php echo $this->_tpl_vars['baseurl']; ?>
&stock=substract" title="<?php echo $this->_tpl_vars['ProductStockQuantity']; ?>
"><img
        src="<?php echo @MYSHOP_IMAGES_URL; ?>
product_delete.png" alt="<?php echo $this->_tpl_vars['ProductStockQuantity']; ?>
"/></a><?php endif; ?><?php endif; ?>
</div>
<br/>


<?php if ($this->_tpl_vars['canRateProducts']): ?>
<div class="myshop_rating">
    <?php echo @_MYSHOP_RATINGC; ?>
 <?php echo $this->_tpl_vars['product']['product_rating_formated']; ?>
 (<?php echo $this->_tpl_vars['product']['product_votes_count']; ?>
)
    <?php if ($this->_tpl_vars['userCanRate']): ?>
    - <a href="<?php echo @MYSHOP_URL; ?>
rate-product.php?product_id=<?php echo $this->_tpl_vars['product']['product_id']; ?>
"
         title="<?php echo @_MYSHOP_RATETHISPRODUCT; ?>
"><?php echo @_MYSHOP_RATETHISPRODUCT; ?>
</a>
    <?php endif; ?>
</div>
<?php endif; ?>



<div style="text-align: center; padding: 3px; margin:3px;">
    <?php echo $this->_tpl_vars['commentsnav']; ?>

    <?php echo $this->_tpl_vars['lang_notice']; ?>

</div>

<div style="margin:3px; padding: 3px;">
    <?php if ($this->_tpl_vars['comment_mode'] == 'flat'): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:legacy_comments_flat.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php elseif ($this->_tpl_vars['comment_mode'] == 'thread'): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:legacy_comments_thread.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php elseif ($this->_tpl_vars['comment_mode'] == 'nest'): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:legacy_comments_nest.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'db:legacy_notification_select.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>