<?php /* Smarty version 2.6.26, created on 2012-08-27 17:53:02
         compiled from file:blockinstall_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'theme', 'file:blockinstall_list.html', 71, false),array('modifier', 'xoops_escape', 'file:blockinstall_list.html', 103, false),array('function', 'cycle', 'file:blockinstall_list.html', 85, false),array('function', 'xoops_pagenavi', 'file:blockinstall_list.html', 118, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <a href="./index.php?action=BlockList"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_MI_LEGACY_MENU_BLOCKINSTALL; ?>
</span>
</div>

<h3 class="admintitle"><?php echo @_MI_LEGACY_MENU_BLOCKINSTALL; ?>
</h3>

<div class="tips">
<ul>
<li>
<?php echo @_AD_LEGACY_LANG_BLOCK_TOTAL; ?>
: <?php echo $this->_tpl_vars['BlockTotal']; ?>
<br />
<?php echo @_AD_LEGACY_LANG_BLOCK_ACTIVETOTAL; ?>
: <?php echo $this->_tpl_vars['ActiveBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp; <?php echo @_AD_LEGACY_LANG_BLOCK_INSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['ActiveInstalledBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp; <?php echo @_AD_LEGACY_LANG_BLOCK_UNINSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['ActiveUninstalledBlockTotal']; ?>
<br />
<?php echo @_AD_LEGACY_LANG_BLOCK_INACTIVETOTAL; ?>
: <?php echo $this->_tpl_vars['InactiveBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp; <?php echo @_AD_LEGACY_LANG_BLOCK_INSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['InactiveInstalledBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp; <?php echo @_AD_LEGACY_LANG_BLOCK_UNINSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['InactiveUninstalledBlockTotal']; ?>

</li>
<li>
<?php echo @_AD_LEGACY_TIPS_INSTALL_BLOCK; ?>

</li>
<li>
<?php echo @_AD_LEGACY_TIPS_BLOCK2; ?>

</li>
<li><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=Help&amp;dirname=legacy"><?php echo @_HELP; ?>
</a></li>
</ul>
</div>

<ul class="toptab">
  <li class="addBlockCustom"><a href="index.php?action=CustomBlockEdit"><?php echo @_AD_LEGACY_LANG_ADD_CUSTOM_BLOCK; ?>
</a></li>
</ul>

<div>
<form action="./index.php" method="get">
  <input type="hidden" name="action" value="BlockInstallList" />
  <?php echo @_SEARCH; ?>
 : 
  <input type="text" name="search" value="<?php echo $this->_tpl_vars['filterForm']->mKeyword; ?>
" />
  <?php echo @_AD_LEGACY_LANG_MOD_NAME; ?>
 : 
  <select name="dirname">
    <option value="0"><?php echo @_ALL; ?>
</option>
    <?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
      <?php if (is_object ( $this->_tpl_vars['filterForm']->mModule )): ?>
        <option value="<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
" <?php if ($this->_tpl_vars['filterForm']->mModule->get('dirname') == $this->_tpl_vars['module']->get('dirname')): ?>selected="selected"<?php endif; ?> >
        <?php echo $this->_tpl_vars['module']->getShow('name'); ?>
</option>
      <?php else: ?>
        <option value="<?php echo $this->_tpl_vars['module']->getShow('dirname'); ?>
">
        <?php echo $this->_tpl_vars['module']->getShow('name'); ?>
</option>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
     <option value="-1"  <?php if ($this->_tpl_vars['filterForm']->mModule == 'cblock'): ?>selected="selected"<?php endif; ?>><?php echo @_AD_LEGACY_LANG_CUSTOMBLOCK_EDIT; ?>
</option>
  </select>
  <?php echo @_VIEW; ?>
 : 
  <select name="perpage">
    <option value="<?php echo @XCUBE_PAGENAVI_DEFAULT_PERPAGE; ?>
"><?php echo @_SELECT; ?>
</option>
    <?php $_from = $this->_tpl_vars['pageArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
      <?php if ($this->_tpl_vars['pageNavi']->mPerpage == $this->_tpl_vars['page'] && $this->_tpl_vars['page'] != 0): ?>
        <option value="<?php echo $this->_tpl_vars['page']; ?>
" selected="selected"><?php echo $this->_tpl_vars['page']; ?>
</option>
      <?php elseif ($this->_tpl_vars['pageNavi']->mPerpage == $this->_tpl_vars['page'] && $this->_tpl_vars['page'] == 0): ?>
        <option value="<?php echo $this->_tpl_vars['page']; ?>
" selected="selected"><?php echo @_ALL; ?>
</option>
      <?php elseif ($this->_tpl_vars['pageNavi']->mPerpage != $this->_tpl_vars['page'] && $this->_tpl_vars['page'] == 0): ?>
        <option value="<?php echo $this->_tpl_vars['page']; ?>
"><?php echo @_ALL; ?>
</option>
      <?php else: ?>
        <option value="<?php echo $this->_tpl_vars['page']; ?>
"><?php echo $this->_tpl_vars['page']; ?>
</option>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
  </select>
  <input class="formButton" type="submit" value="<?php echo @_SUBMIT; ?>
" />
</form>
</div>

<table class="outer">
  <tr>
    <th><?php echo @_AD_LEGACY_LANG_BID; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_BID; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_BID; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_BLOCK_MOD; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_MID; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_MID; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_TITLE; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_TITLE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_TITLE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_TEMPLATE; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_TEMPLATE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_TEMPLATE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_CONTROL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['objects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['obj']):
?>
    <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
      <td class="legacy_list_id"><?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
</td>
      <td class="legacy_list_name">
        <?php if ($this->_tpl_vars['obj']->mModule): ?>
          <span class="legacy_blocktype_module"><?php echo $this->_tpl_vars['obj']->mModule->getShow('name'); ?>
</span>
        <?php else: ?>
          <span class="legacy_blocktype_custom">
          <?php if ($this->_tpl_vars['obj']->get('c_type') == 'H'): ?><?php echo @_AD_LEGACY_LANG_CUSTOM_HTML; ?>

          <?php elseif ($this->_tpl_vars['obj']->get('c_type') == 'P'): ?><?php echo @_AD_LEGACY_LANG_CUSTOM_PHP; ?>

          <?php elseif ($this->_tpl_vars['obj']->get('c_type') == 'S'): ?><?php echo @_AD_LEGACY_LANG_CUSTOM_WITH_SMILIES; ?>

          <?php elseif ($this->_tpl_vars['obj']->get('c_type') == 'T'): ?><?php echo @_AD_LEGACY_LANG_CUSTOM_WITHOUT_SMILIES; ?>

          <?php endif; ?>
          </span>
        <?php endif; ?>
      </td>
      <td class="legacy_list_title"><?php echo $this->_tpl_vars['obj']->getShow('title'); ?>
</td>
      <td class="legacy_list_text">
        <?php if ($this->_tpl_vars['obj']->getShow('template')): ?>
        <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacyRender/admin/index.php?action=TplfileList&amp;tpl_file=<?php echo $this->_tpl_vars['obj']->getShow('template'); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['obj']->getShow('template'))) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</a>
        <?php endif; ?>
      </td>
      <td class="legacy_list_control">
        <?php if ($this->_tpl_vars['obj']->get('block_type') == 'C'): ?>
          <a href="./index.php?action=CustomBlockEdit&amp;bid=<?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/block_edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_INSTALL; ?>
" title="<?php echo @_AD_LEGACY_LANG_INSTALL; ?>
" /></a>
          <a href="./index.php?action=CustomBlockDelete&amp;bid=<?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/block_remove.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DELETE; ?>
" title="<?php echo @_DELETE; ?>
" /></a>
        <?php else: ?>
          <a href="./index.php?action=BlockInstallEdit&amp;bid=<?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/block_install.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_INSTALL; ?>
"title="<?php echo @_AD_LEGACY_LANG_INSTALL; ?>
" /></a>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>

<div class="pagenavi"><?php echo smarty_function_xoops_pagenavi(array('pagenavi' => $this->_tpl_vars['pageNavi']), $this);?>
</div>