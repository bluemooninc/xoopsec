<?php /* Smarty version 2.6.26, created on 2012-08-27 17:53:21
         compiled from db:myshop_caddy.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'db:myshop_caddy.html', 35, false),)), $this); ?>
<?php echo $this->_tpl_vars['breadcrumb']; ?>

<br/>
<?php if ($this->_tpl_vars['mod_pref']['advertisement'] != ''): ?>
<div id="myshop_publicite"><?php echo $this->_tpl_vars['mod_pref']['advertisement']; ?>
</div><?php endif; ?>

<br/>

<h2><?php echo @_MI_MYSHOP_SMNAME1; ?>
</h2>

<?php if ($this->_tpl_vars['emptyCart']): ?>
<i><?php echo @_MYSHOP_CART_IS_EMPTY; ?>
</i>
<?php if ($this->_tpl_vars['isCartExists']): ?>
<br/><a href="<?php echo @MYSHOP_URL; ?>
caddy.php?op=reload"><?php echo @_MYSHOP_RELOAD_PERSISTENT; ?>
</a>
<?php endif; ?>
<?php else: ?>
<form method="post" name="frmUpdate" id="frmUpdate" action="<?php echo @MYSHOP_URL; ?>
caddy.php"
      style="margin:0; padding:0; border: 0px; display: inline;">

    <table class="outer">
        <tr>
            <th align="center"><?php echo @_MYSHOP_ITEMS; ?>
</th>
            <th align="center"><?php echo @_MYSHOP_UNIT_PRICE; ?>
</th>
            <th align="center"><?php echo @_MYSHOP_QUANTITY; ?>
</th>
            <?php if (! $this->_tpl_vars['purchased']): ?>
            <!--
            <th align="center"><?php echo @_MYSHOP_CART1; ?>
</th>
            <th align="center"><?php echo @_MYSHOP_CART2; ?>
</th>
            -->
            <th align="center"><?php echo @_MYSHOP_CART3; ?>
</th>
            <th align="center"><?php echo @_MYSHOP_SHIPPING_PRICE; ?>
</th>
            <?php endif; ?>
            <th align="center"><?php echo @_MYSHOP_PRICE; ?>
</th>
        </tr>
        <?php $_from = $this->_tpl_vars['caddieProducts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
            <td>
                <a href="<?php echo $this->_tpl_vars['product']['product_url_rewrited']; ?>
" title="<?php echo $this->_tpl_vars['product']['product_href_title']; ?>
">
                    <!-- <?php echo $this->_tpl_vars['product']['number']; ?>
 -->
                    <?php echo $this->_tpl_vars['product']['product_title']; ?>

                    <?php if ($this->_tpl_vars['product']['reduction'] != ''): ?>
                        <sup style="color: #FF0000;">
                            <?php echo $this->_tpl_vars['product']['reduction']; ?>

                        </sup>
                    <?php endif; ?>
                </a>
            </td>
            <td align="right">
                <?php if ($this->_tpl_vars['product']['reduction'] != ''): ?>
                <?php echo $this->_tpl_vars['product']['discountedPriceFormated']; ?>

                <?php else: ?>
                <?php echo $this->_tpl_vars['product']['unitBasePriceFormated']; ?>

                <?php endif; ?>
            </td>
            <?php if ($this->_tpl_vars['purchased']): ?>
            <td align="right">
                <?php echo $this->_tpl_vars['product']['product_qty']; ?>

            </td>
            <?php else: ?>
            <td align="center">
                <input type="text" name="qty_<?php echo $this->_tpl_vars['product']['number']; ?>
" id="qty_<?php echo $this->_tpl_vars['product']['number']; ?>
"
                       value="<?php echo $this->_tpl_vars['product']['product_qty']; ?>
" size="3"/>
            </td>
            <!--
            <td align="right"><?php echo $this->_tpl_vars['product']['discountedPriceWithQuantityFormated']; ?>
</td>
            <td align="right"><?php echo $this->_tpl_vars['product']['vatRate']; ?>
</td>
            -->
            <td align="right"><?php echo $this->_tpl_vars['product']['vatAmountFormated']; ?>
</td>
            <td align="right"><?php echo $this->_tpl_vars['product']['discountedShippingFormated']; ?>
</td>
            <?php endif; ?>
            <td align="right"><?php echo $this->_tpl_vars['product']['totalPriceFormated']; ?>
</td>
            <?php if (! $this->_tpl_vars['purchased']): ?>
            <td>
                <a href="<?php echo @MYSHOP_URL; ?>
caddy.php?op=delete&product_id=<?php echo $this->_tpl_vars['product']['number']; ?>
"
                <?php echo $this->_tpl_vars['confirm_delete_item']; ?>
 title="<?php echo @_MYSHOP_REMOVE_ITEM; ?>
">
                <img src="<?php echo @MYSHOP_IMAGES_URL; ?>
cartdelete.png" alt="<?php echo @_MYSHOP_REMOVE_ITEM; ?>
"
                     border="0"/>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; endif; unset($_from); ?>

        <tr>
            <td colspan="3"><h3><?php echo @_MYSHOP_TOTAL; ?>
</h3></td>
            <!--<td align="right"><?php echo $this->_tpl_vars['commandAmount']; ?>
</td>-->
            <?php if (! $this->_tpl_vars['purchased']): ?>
            <td align="right" valign="middle"><?php echo $this->_tpl_vars['vatAmount']; ?>
</td>
            <td align="right" valign="middle"><?php echo $this->_tpl_vars['shippingAmount']; ?>
</td>
            <td colspan="2" align="right" valign="middle" class="head"><?php echo $this->_tpl_vars['commandAmountTTC']; ?>
</td>
            <?php endif; ?>
        </tr>
        <?php if (! $this->_tpl_vars['purchased']): ?>
        <tr>
            <td colspan="7">
                <?php echo @_MYSHOP_QTE_MODIFIED; ?>

                <input type="hidden" name="op" id="op" value="update"/>
                <input type="submit" name="btnUpdate" id="btnUpdate" value="<?php echo @_MYSHOP_UPDATE; ?>
"/>
</form>

<form method="post" name="frmEmpty" id="frmEmpty"
      action="<?php echo @MYSHOP_URL; ?>
caddy.php" <?php echo $this->_tpl_vars['confEmpty']; ?>
 style="margin:0; padding:0; border: 0px; display: inline;">
<input type="hidden" name="op" id="op" value="empty"/>
<input type="submit" name="btnEmpty" id="btnEmpty" value="<?php echo @_MYSHOP_EMPTY_CART; ?>
"/>
</form>

<form method="post" name="frmGoOn" id="frmGoOn" action="<?php echo $this->_tpl_vars['goOn']; ?>
"
      style="margin:0; padding:0; border: 0px; display: inline;">
    <input type="submit" name="btnGoOn" id="btnGoOn" value="<?php echo @_MYSHOP_GO_ON; ?>
"/>
</form>
<?php if ($this->_tpl_vars['showOrderButton']): ?>
<form method="post" name="frmCheckout" id="frmCheckout" action="<?php echo @MYSHOP_URL; ?>
checkout.php"
      style="margin:0; padding:0; border: 0px; display: inline;">
    <input type="submit" name="btnCheckout" id="btnCheckout" value="<?php echo @_MYSHOP_CHECKOUT; ?>
"/>
</form>
<?php endif; ?>
</td>
</tr>
<?php endif; ?>
</table>

<?php if ($this->_tpl_vars['showRegistredOnly'] && trim ( $this->_tpl_vars['restrict_orders_text'] ) != ''): ?>
<br/>
<div class="myshop_alert">
    <?php echo $this->_tpl_vars['restrict_orders_text']; ?>

</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['discountsCount'] > 0): ?>
<div class="myshop_discounts">
    <h3><?php echo @_MYSHOP_CART4; ?>
</h3>
    <ul>
        <?php $_from = $this->_tpl_vars['caddieProducts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
        <?php if ($this->_tpl_vars['product']['reduction'] != ''): ?>
        <li class="myshop_discount-description"><sup style="color: #FF0000;"><?php echo $this->_tpl_vars['product']['number']; ?>
</sup>
            <?php echo $this->_tpl_vars['product']['reduction']; ?>

        </li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </ul>

    <?php if (count ( $this->_tpl_vars['discountsDescription'] ) > 0): ?>
    <ul>
        <?php $_from = $this->_tpl_vars['discountsDescription']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['discount']):
?>
        <li class="myshop_discount-description"><?php echo $this->_tpl_vars['discount']; ?>
</li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>