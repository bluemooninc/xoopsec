<?php /* Smarty version 2.6.26, created on 2012-08-27 23:07:11
         compiled from db:execTran_index.html */ ?>
<h3><?php echo @_MD_GMOPAYMENT_TITLE_EXECTRAN; ?>
</h3>
<p>
    <?php echo @_MD_GMOPAYMENT_DESC_EXECTRAN; ?>

</p>

<form id="list" name="list" method="post" action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/execTran/submit">

    <!--
    <?php echo @_MD_GMOPAYMENT_ACCESSID; ?>
(AccessID)
    <?php echo @_MD_GMOPAYMENT_ACCESSPASS; ?>
(AccessPass)
    <?php echo @_MD_GMOPAYMENT_ORDERID; ?>
(OrderID)
    <?php echo @_MD_GMOPAYMENT_CARDSEQ; ?>
(CardSeq)
    <?php echo @_MD_GMOPAYMENT_CLIENTFIELD1; ?>
(ClientField1)
    <?php echo @_MD_GMOPAYMENT_CLIENTFIELD2; ?>
(ClientField2)
    <?php echo @_MD_GMOPAYMENT_CLIENTFIELD3; ?>
(ClientField3)
    <input name="ClientField1" type="text" maxlength="100" tabindex="16"/>
    <input name="ClientField2" type="text" maxlength="100" tabindex="16"/>
    <input name="ClientField2" type="text" maxlength="100" tabindex="16"/>
    -->
    <input name="id" type="hidden" value="<?php echo $this->_tpl_vars['id']; ?>
"/>
    <table class="outer">
        <tr>
            <th>
                <?php echo @_MD_GMOPAYMENT_PAYMETHOD; ?>

            </th>
            <td>
                <select name="PayMethod" tabindex="14">
                    <option value="1"><?php echo @_MD_GMOPAYMENT_PAYMETHOD1; ?>
</option>
                    <option value="2"><?php echo @_MD_GMOPAYMENT_PAYMETHOD2; ?>
</option>
                    <option value="3"><?php echo @_MD_GMOPAYMENT_PAYMETHOD3; ?>
</option>
                    <option value="4"><?php echo @_MD_GMOPAYMENT_PAYMETHOD4; ?>
</option>
                    <option value="5"><?php echo @_MD_GMOPAYMENT_PAYMETHOD5; ?>
</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo @_MD_GMOPAYMENT_PAYTIMES; ?>

            </th>
            <td>
                <input name="PayTimes" type="text" value="1" maxlength="3" class="num" size="5" tabindex="15"/>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="foot" align="center">
                <input id="button1" type="button" value="<?php echo @_MD_GMOPAYMENT_RESISTER; ?>
"/>
            </td>
        </tr>
    </table>
    <input type="hidden" name="method" value="submit"/>
</form>
<script>
    $(function () {
        $('#button1').click(function () {
            $('#list').attr('action', '<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/execTran/submit');
            $('#list').submit();
        });
    });
</script>