<?php /* Smarty version 2.6.26, created on 2012-08-27 22:47:40
         compiled from db:entryTran_index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_user', 'db:entryTran_index.html', 9, false),)), $this); ?>
<h3><?php echo @_MD_GMOPAYMENT_TITLE_ENTRYTRAN; ?>
</h3>
<p>
    <?php echo @_MD_GMOPAYMENT_DESC_ENTRYTRAN; ?>

</p>

<ul>
    <li>
        <?php echo @_MD_GMOPAYMENT_MEMBERID; ?>
(MemberID)
        ID:<?php echo $this->_tpl_vars['xoops_userid']; ?>
 ( <?php echo ((is_array($_tmp=$this->_tpl_vars['xoops_userid'])) ? $this->_run_mod_handler('xoops_user', true, $_tmp, 'user_name') : smarty_modifier_xoops_user($_tmp, 'user_name')); ?>
 )
    </li>
</ul>

<form id="list" name="list" method="post" action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/entryTran/submit">

    <table class="outer">
        <tr>
            <th><?php echo @_MD_GMOPAYMENT_CARDSEQ; ?>
</th>
            <th><?php echo @_MD_GMOPAYMENT_CARDNAME; ?>
</th>
            <th><?php echo @_MD_GMOPAYMENT_CARDNO; ?>
</th>
            <th><?php echo @_MD_GMOPAYMENT_EXPIRE; ?>
</th>
            <th><?php echo @_MD_GMOPAYMENT_HOLDERNAME; ?>
</th>
            <!-- <th><?php echo @_MD_GMOPAYMENT_DEFAULTFLAG; ?>
</th> -->
        </tr>
        <?php $_from = $this->_tpl_vars['ListData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
            <th>
                <input id="CardSeq_<?php echo $this->_tpl_vars['val']['CardSeq']; ?>
" type="radio" value="<?php echo $this->_tpl_vars['val']['CardSeq']; ?>
" name="CardSeq" <?php if ($this->_tpl_vars['val']['DefaultFlag'] == 1): ?>checked="checked"<?php endif; ?> />
            </th>
            <td><?php echo $this->_tpl_vars['val']['CardName']; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['CardNo']; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['Expire']; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['HolderName']; ?>
</td>
            <!--
            <td><?php echo $this->_tpl_vars['val']['CardSeq']; ?>
</td>
            <td><?php echo $this->_tpl_vars['val']['DefaultFlag']; ?>
</td>
            -->
        </tr>
        <?php endforeach; endif; unset($_from); ?>
    </table>
    <br />
    <table class="outer">
        <tr>
            <th>
                <?php echo @_MD_GMOPAYMENT_ORDERID; ?>
(OrderID
            </th>
            <td>
                <input name="OrderID" type="hidden" value="<?php echo $this->_tpl_vars['OrderID']; ?>
"/>
                <input name="JobCd" type="hidden" value="CAPTURE"/>
                <?php echo $this->_tpl_vars['OrderID']; ?>

            </td>
        </tr>
    <!--
         <tr>
           <th>
             <?php echo @_MD_GMOPAYMENT_JOBCD; ?>
(JobCd)
           <td>
             <select name="JobCd" tabindex="12">
               <option value="AUTH"><?php echo @_MD_GMOPAYMENT_JOBCD_AUTH; ?>
</option>
               <option value="CHECK"><?php echo @_MD_GMOPAYMENT_JOBCD_CHECK; ?>
</option>
               <option value="CAPTURE"><?php echo @_MD_GMOPAYMENT_JOBCD_CAPTURE; ?>
</option>
             </select>
           </td>
         </tr>
         <tr>
           <th>
             <?php echo @_MD_GMOPAYMENT_ITEMCODE; ?>
(ItemCode)
           </th>
           <td>
             <input name="ItemCode" type="text" maxlength="7" size="10" tabindex="13" />
           </td>
         </tr>
        -->
        <tr>
            <th>
                <?php echo @_MD_GMOPAYMENT_AMOUNT; ?>
(Amount)
            </th>
            <td>
                <input name="Amount" type="hidden" value="<?php echo $this->_tpl_vars['PayAmount']; ?>
"/>
                <?php echo $this->_tpl_vars['PayAmount']; ?>

            </td>
        </tr>
        <!--
        <tr>
          <th>
            <?php echo @_MD_GMOPAYMENT_TAX; ?>
(Tax)
          </th>
          <td>
            <input name="Tax" type="text" maxlength="7" size="10" tabindex="15" class="num" />
          </td>
        </tr>
        <tr>
          <th>
            <?php echo @_MD_GMOPAYMENT_TDFLAG; ?>
(TdFlag)
          </th>
          <td>
            <label for="isSecure">
              <input name="TdFlag" type="radio" value="1" id="isSecure" tabindex="16" /><?php echo @_MD_GMOPAYMENT_TDFLAG_SECURE; ?>

            </label>
            <label for="isNotSecure">
              <input name="TdFlag" type="radio" value="0" id="isNotSecure" checked="checked" tabindex="17" /><?php echo @_MD_GMOPAYMENT_TDFLAG_NOSECURE; ?>

            </label>
          </td>
        </tr>
        <tr>
          <th>
            <?php echo @_MD_GMOPAYMENT_TDTENANTNAME; ?>
(TdTenantName)
          </th>
          <td>
            <input name="TdTenantName" type="text" tabindex="18" />
          </td>
        </tr>
        -->
        <tr>
            <td colspan="2" class="foot" align="center">
                <input id="button1" type="button" value="<?php echo @_MD_GMOPAYMENT_SUBMIT; ?>
"/>
            </td>
        </tr>
    </table>
    <input type="hidden" name="method" value="submit"/>
</form>
<a href="saveCard"><?php echo @_MD_GMOPAYMENT_TITLE_ADDCARD; ?>
</a>
<script>
    $(function () {
        $('#button1').click(function () {
            $('#list').attr('action', '<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/entryTran/submit');
            $('#list').submit();
        });
    });
</script>