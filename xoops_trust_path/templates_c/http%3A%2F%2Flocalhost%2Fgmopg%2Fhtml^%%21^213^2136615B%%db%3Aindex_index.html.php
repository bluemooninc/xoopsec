<?php /* Smarty version 2.6.26, created on 2012-08-28 14:03:07
         compiled from db:index_index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'db:index_index.html', 17, false),array('modifier', 'number_format', 'db:index_index.html', 37, false),array('modifier', 'xoops_formattimestamp', 'db:index_index.html', 39, false),array('function', 'xoops_pagenavi', 'db:index_index.html', 55, false),)), $this); ?>
<h3><?php echo @_MD_GMOPGX_MODULE_TITLE; ?>
</h3>

<form method="post" action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/default/search">
    <div align="right">
        <?php echo @_MD_GMOPGX_TABLE_STATUS; ?>

        <select name="status">
            <option value="">---</option>
            <option value="0"
            <?php if ($this->_tpl_vars['status'] === 0): ?> selected="selected"<?php endif; ?>><?php echo @_MD_GMOPGX_TABLE_STATUS_0; ?>
</option>
            <option value="1"
            <?php if ($this->_tpl_vars['status'] == 1): ?> selected="selected"<?php endif; ?>><?php echo @_MD_GMOPGX_TABLE_STATUS_1; ?>
</option>
            <option value="2"
            <?php if ($this->_tpl_vars['status'] == 2): ?> selected="selected"<?php endif; ?>><?php echo @_MD_GMOPGX_TABLE_STATUS_2; ?>
</option>
        </select>
        &nbsp;
        <?php echo @_MD_GMOPGX_TABLE_TITLE; ?>

        <input type="text" name="subject" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['subject'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
"/>
        &nbsp;
        <input type="submit" name="subbtn" value="<?php echo @_SEARCH; ?>
"/>
</form>
</div>
<br/>
<form id="list" name="list" method="post" action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/dafault/index">

    <table class="outer">
        <tr>
            <th><?php echo @_MD_GMOPAYMENT_ORDERID; ?>
</th>
            <th><?php echo @_MD_GMOPAYMENT_AMOUNT; ?>
</th>
            <!--<th><?php echo @_MD_GMOPAYMENT_TAX; ?>
</th>-->
            <th><?php echo @_MD_GMOPGX_TABLE_DATE; ?>
</th>
            <th><?php echo @_MD_GMOPGX_TABLE_STATUS; ?>
</th>
        </tr>
        <?php $_from = $this->_tpl_vars['ListData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
            <td class="even"><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/default/detail/<?php echo $this->_tpl_vars['val']['id']; ?>
"><?php echo $this->_tpl_vars['val']['orderId']; ?>
</a>
            </td>
            <td class="even">&yen;<?php echo ((is_array($_tmp=$this->_tpl_vars['val']['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
            <!--<td class="even"><?php echo $this->_tpl_vars['val']['tax']; ?>
</td>-->
            <td class="even"><?php echo ((is_array($_tmp=$this->_tpl_vars['val']['utime'])) ? $this->_run_mod_handler('xoops_formattimestamp', true, $_tmp, 'l') : smarty_modifier_xoops_formattimestamp($_tmp, 'l')); ?>
</td>
            <td class="odd" align="center">
                <?php if ($this->_tpl_vars['val']['status'] == 0): ?>
                <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/execTran/index/<?php echo $this->_tpl_vars['val']['id']; ?>
">
                    <?php echo @_MD_GMOPAYMENT_EXECTRAN; ?>
</a>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['val']['status'] == 1): ?>
                <!--<input type="checkbox" name="delmsg[]" value="<?php echo $this->_tpl_vars['val']['inbox_id']; ?>
"/>-->
                    <?php echo @_MD_GMOPAYMENT_DONETRAN; ?>

                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
    </table>
    <input type="hidden" name="inout" value="in"/>
</form>
<div class="pagenavi" align="center"><?php echo smarty_function_xoops_pagenavi(array('pagenavi' => $this->_tpl_vars['pageNavi']), $this);?>
</div>
<script>
    $(function () {
        $('#button1').click(function () {
            $('#list').attr('action', '<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/default/index');
            $('#list').submit();
        });
        $('#button2').click(function () {
            $('#list').attr('action', '<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/gmopgx/default/edit');
            $('#list').submit();
        });
    });
</script>