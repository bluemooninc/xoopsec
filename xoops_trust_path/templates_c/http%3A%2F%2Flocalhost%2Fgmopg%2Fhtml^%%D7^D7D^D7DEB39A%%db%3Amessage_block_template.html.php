<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:36
         compiled from db:message_block_template.html */ ?>
<div>
<ul id="privatemessages">
    <li>
    <?php if ($this->_tpl_vars['block'] > 0): ?>
    
    <a class="highlight" href="<?php echo $this->_tpl_vars['message_url']; ?>
?action=index"><img src="<?php echo @XOOPS_MODULE_URL; ?>
/message/images/email_inbox.png" alt="" /> 
    <?php echo @_MD_MESSAGE_TEMPLATE15; ?>
 (<span style="color:#ff0000; font-weight: bold;"><?php echo $this->_tpl_vars['block']; ?>
</span>/<?php echo $this->_tpl_vars['incount']; ?>
)
    </a>
      <?php else: ?>
    <a href="<?php echo $this->_tpl_vars['message_url']; ?>
?action=index"><img src="<?php echo @XOOPS_MODULE_URL; ?>
/message/images/email_inbox.png" alt="" /> <?php echo @_MD_MESSAGE_TEMPLATE15; ?>
 (<?php echo $this->_tpl_vars['incount']; ?>
)</a>
    <?php endif; ?>
    </li>
    <li><a href="<?php echo $this->_tpl_vars['message_url']; ?>
?action=send"><img src="<?php echo @XOOPS_MODULE_URL; ?>
/message/images/email_outbox.png" alt="" /> <?php echo @_MD_MESSAGE_TEMPLATE7; ?>
 (<?php echo $this->_tpl_vars['outcount']; ?>
)</a></li>
    <li><a href="<?php echo $this->_tpl_vars['message_url']; ?>
?action=new"><img src="<?php echo @XOOPS_MODULE_URL; ?>
/message/images/email_add.png" alt="" /> <?php echo @_MD_MESSAGE_TEMPLATE8; ?>
</a></li>
    <li><a href="<?php echo $this->_tpl_vars['message_url']; ?>
?action=settings"><img src="<?php echo @XOOPS_MODULE_URL; ?>
/message/images/email_edit.png" alt="" /> <?php echo @_MI_MESSAGE_SUB_SETTINGS; ?>
</a></li>
    <?php if ($this->_tpl_vars['UserSearch']): ?>
        <li><a href="<?php echo $this->_tpl_vars['message_url']; ?>
?action=search"><img src="<?php echo @XOOPS_MODULE_URL; ?>
/message/images/email_edit.png" alt="" /> <?php echo @_MI_MESSAGE_SUB_SEARCH; ?>
</a></li>
        <li><a href="<?php echo $this->_tpl_vars['message_url']; ?>
?action=favorites"><img src="<?php echo @XOOPS_MODULE_URL; ?>
/message/images/email_edit.png" alt="" /> <?php echo @_MI_MESSAGE_SUB_FAVORITES; ?>
</a></li>
    <?php endif; ?>
</ul>
</div>