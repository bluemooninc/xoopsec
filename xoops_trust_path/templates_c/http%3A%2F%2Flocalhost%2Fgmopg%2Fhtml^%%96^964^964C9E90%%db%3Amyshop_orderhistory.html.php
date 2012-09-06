<?php /* Smarty version 2.6.26, created on 2012-08-28 13:55:14
         compiled from db:myshop_orderhistory.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'db:myshop_orderhistory.html', 24, false),)), $this); ?>
<?php echo $this->_tpl_vars['breadcrumb']; ?>

<br/>


<?php if ($this->_tpl_vars['mod_pref']['advertisement'] != ''): ?>
<div id="myshop_publicite"><?php echo $this->_tpl_vars['mod_pref']['advertisement']; ?>
</div>
<?php endif; ?>

<br/>

<h2><img src="<?php echo @MYSHOP_IMAGES_URL; ?>
box.png" alt="" border="0"/><?php echo @_MI_MYSHOP_SMNAME1_2; ?>
</h2>
<div class="myshop_alphabet"><?php $_from = $this->_tpl_vars['alphabet']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['letter']):
?><a href="#<?php echo $this->_tpl_vars['letter']; ?>
"><?php echo $this->_tpl_vars['letter']; ?>
</a> <?php endforeach; endif; unset($_from); ?>
</div>
<table>
    <th><?php echo @_MYSHOP_CMD_ID; ?>
</th>
    <th><?php echo @_MYSHOP_CMD_DATE; ?>
</th>
    <th><?php echo @_MYSHOP_PRICE; ?>
</th>
    <th><?php echo @_MYSHOP_DETAILS; ?>
</th>
    <?php $_from = $this->_tpl_vars['orderList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['initiale'] => $this->_tpl_vars['ol']):
?>
    <tr>
        <td align="right"><a href="caddy.php?op=purchased&amp;cmd_id=<?php echo $this->_tpl_vars['ol']['id']; ?>
"><?php echo $this->_tpl_vars['ol']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['ol']['date']; ?>
</td>
        <td align="right">&yen;<?php echo ((is_array($_tmp=$this->_tpl_vars['ol']['total'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td><?php echo $this->_tpl_vars['ol']['state']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>