<?php /* Smarty version 2.6.26, created on 2012-08-27 17:52:09
         compiled from db:legacy_comments_thread.html */ ?>
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['comments']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
<br />
<table cellspacing="1" class="outer">
  <tr>
    <th width="20%"><?php echo $this->_tpl_vars['lang_poster']; ?>
</th>
    <th><?php echo $this->_tpl_vars['lang_thread']; ?>
</th>
  </tr>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:legacy_comment.html", 'smarty_include_vars' => array('comment' => $this->_tpl_vars['comments'][$this->_sections['i']['index']])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</table>

<?php if ($this->_tpl_vars['show_threadnav'] == true): ?>
<div style="text-align:left; margin:3px; padding: 5px;">
<a href="<?php echo $this->_tpl_vars['comment_url']; ?>
"><?php echo $this->_tpl_vars['lang_top']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['comment_url']; ?>
&amp;com_id=<?php echo $this->_tpl_vars['comments'][$this->_sections['i']['index']]['pid']; ?>
&amp;com_rootid=<?php echo $this->_tpl_vars['comments'][$this->_sections['i']['index']]['rootid']; ?>
#newscomment<?php echo $this->_tpl_vars['comments'][$this->_sections['i']['index']]['pid']; ?>
"><?php echo $this->_tpl_vars['lang_parent']; ?>
</a>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['comments'][$this->_sections['i']['index']]['show_replies'] == true): ?>
<!-- start comment tree -->
<br />
<table cellspacing="1" class="outer">
  <tr>
    <th width="50%"><?php echo $this->_tpl_vars['lang_subject']; ?>
</th>
    <th width="20%" align="center"><?php echo $this->_tpl_vars['lang_poster']; ?>
</th>
    <th align="right"><?php echo $this->_tpl_vars['lang_posted']; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['comments'][$this->_sections['i']['index']]['replies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['reply']):
?>
  <tr>
    <td class="even"><?php echo $this->_tpl_vars['reply']['prefix']; ?>
 <a href="<?php echo $this->_tpl_vars['comment_url']; ?>
&amp;com_id=<?php echo $this->_tpl_vars['reply']['id']; ?>
&amp;com_rootid=<?php echo $this->_tpl_vars['reply']['root_id']; ?>
"><?php echo $this->_tpl_vars['reply']['title']; ?>
</a></td>
    <td class="odd" align="center"><?php echo $this->_tpl_vars['reply']['poster']['uname']; ?>
</td>
    <td class="even" align="right"><?php echo $this->_tpl_vars['reply']['date_posted']; ?>
</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
<!-- end comment tree -->
<?php endif; ?>

<?php endfor; endif; ?>