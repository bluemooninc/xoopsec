<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:36
         compiled from db:legacy_block_usermenu.html */ ?>
<ul id="usermenu">
<li class="userMenuTop"><a class="menuTop" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/user.php"><?php echo @_MB_LEGACY_VACNT; ?>
</a></li>
<li class="userMenuEdit"><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/edituser.php"><?php echo @_MB_LEGACY_EACNT; ?>
</a></li>
<li class="userMenuComments"><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/notifications.php"><?php echo @_MB_LEGACY_NOTIF; ?>
</a></li>
<li class="userMenuLogout"><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/user.php?op=logout"><?php echo @_MB_LEGACY_LOUT; ?>
</a></li>
<?php if ($this->_tpl_vars['block']['flagShowInbox']): ?>
<?php if ($this->_tpl_vars['block']['new_messages'] > 0): ?>
<li class="userMenuEmail"><a class="highlight" href="<?php echo $this->_tpl_vars['block']['inbox_url']; ?>
"><?php echo @_MB_LEGACY_INBOX; ?>
 (<span class="newMessages"><?php echo $this->_tpl_vars['block']['new_messages']; ?>
</span>)</a></li>
<?php else: ?>
<li class="userMenuEmail"><a href="<?php echo $this->_tpl_vars['block']['inbox_url']; ?>
"><?php echo @_MB_LEGACY_INBOX; ?>
</a></li>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['block']['show_adminlink']): ?>
<li class="userMenuAdmin"><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/admin.php"><?php echo @_MB_LEGACY_ADMENU; ?>
</a></li>
<?php endif; ?>
</ul>