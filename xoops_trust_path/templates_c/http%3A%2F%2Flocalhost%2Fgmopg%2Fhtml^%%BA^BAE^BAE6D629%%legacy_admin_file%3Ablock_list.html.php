<?php /* Smarty version 2.6.26, created on 2012-08-27 23:23:03
         compiled from file:block_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:block_list.html', 99, false),array('modifier', 'theme', 'file:block_list.html', 111, false),array('modifier', 'xoops_formattimestamp', 'file:block_list.html', 257, false),array('function', 'xoops_token', 'file:block_list.html', 106, false),array('function', 'cycle', 'file:block_list.html', 167, false),array('function', 'xoops_input', 'file:block_list.html', 182, false),array('function', 'xoops_optionsArray', 'file:block_list.html', 253, false),array('function', 'xoops_pagenavi', 'file:block_list.html', 282, false),)), $this); ?>
<div class="adminnavi">
    <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
    &raquo;&raquo; <span class="adminnaviTitle"><a href="./index.php?action=BlockList"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</a></span>
</div>

<h3 class="admintitle"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</h3>

<div class="tips">
    <ul>
        <li>
            <?php echo @_AD_LEGACY_LANG_BLOCK_TOTAL; ?>
: <?php echo $this->_tpl_vars['BlockTotal']; ?>
<br/>
            <?php echo @_AD_LEGACY_LANG_BLOCK_ACTIVETOTAL; ?>
: <?php echo $this->_tpl_vars['ActiveBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp;
            <?php echo @_AD_LEGACY_LANG_BLOCK_INSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['ActiveInstalledBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp;
            <?php echo @_AD_LEGACY_LANG_BLOCK_UNINSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['ActiveUninstalledBlockTotal']; ?>
<br/>
            <?php echo @_AD_LEGACY_LANG_BLOCK_INACTIVETOTAL; ?>
: <?php echo $this->_tpl_vars['InactiveBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp;
            <?php echo @_AD_LEGACY_LANG_BLOCK_INSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['InactiveInstalledBlockTotal']; ?>
&nbsp;&nbsp;|&nbsp;
            <?php echo @_AD_LEGACY_LANG_BLOCK_UNINSTALLEDTOTAL; ?>
: <?php echo $this->_tpl_vars['InactiveUninstalledBlockTotal']; ?>

        </li>
        <li>
            <?php echo @_AD_LEGACY_TIPS_ADD_CUSTOM_BLOCK; ?>

        </li>
        <li>
            <?php echo @_AD_LEGACY_TIPS_BLOCK; ?>

        </li>
        <li><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=Help&amp;dirname=legacy"><?php echo @_HELP; ?>
</a>
        </li>
    </ul>
</div>

<ul class="toptab">
    <li class="addBlock"><a href="index.php?action=BlockInstallList"><?php echo @_AD_LEGACY_LANG_BLOCK_INSTALL; ?>
</a>
    </li>
    <li class="addBlockCustom"><a href="index.php?action=CustomBlockEdit"><?php echo @_AD_LEGACY_LANG_ADD_CUSTOM_BLOCK; ?>
</a>
    </li>
</ul>

<div>
    <form action="./index.php" method="get">
        <input type="hidden" name="action" value="BlockList"/>
        <?php echo @_SEARCH; ?>
 :
        <input type="text" name="search" value="<?php echo $this->_tpl_vars['filterForm']->mKeyword; ?>
"/>
        <?php echo @_AD_LEGACY_LANG_MOD_NAME; ?>
 :
        <select name="dirname">
            <option value="0"><?php echo @_ALL; ?>
</option>
            <?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
            <?php if (is_object ( $this->_tpl_vars['filterForm']->mModule )): ?>
            <option value="<?php echo $this->_tpl_vars['module']->getVar('dirname'); ?>
"
            <?php if ($this->_tpl_vars['filterForm']->mModule->getVar('dirname') == $this->_tpl_vars['module']->getVar('dirname')): ?>selected="selected"<?php endif; ?> >
            <?php echo $this->_tpl_vars['module']->getVar('name'); ?>
</option>
            <?php else: ?>
            <option value="<?php echo $this->_tpl_vars['module']->getVar('dirname'); ?>
">
                <?php echo $this->_tpl_vars['module']->getVar('name'); ?>

            </option>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            <option value="-1"
            <?php if ($this->_tpl_vars['filterForm']->mModule == 'cblock'): ?>selected="selected"<?php endif; ?>><?php echo @_AD_LEGACY_LANG_CUSTOMBLOCK_EDIT; ?>
</option>
        </select>
        <?php echo @_AD_LEGACY_LANG_SIDE; ?>
 :
        <select name="option_field">
            <?php if ($this->_tpl_vars['filterForm']->mOptionField == 'all'): ?>
            <option value="all" selected="selected"><?php echo @_ALL; ?>
</option>
            <?php $_from = $this->_tpl_vars['columnSideArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['columnSide']):
?>
            <option value="<?php echo $this->_tpl_vars['columnSide']->getShow('id'); ?>
"> <?php echo $this->_tpl_vars['columnSide']->getShow('name'); ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
            <?php else: ?>
            <option value="all"><?php echo @_ALL; ?>
</option>
            <?php $_from = $this->_tpl_vars['columnSideArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['columnSide']):
?>
            <option value="<?php echo $this->_tpl_vars['columnSide']->getShow('id'); ?>
"
            <?php if ($this->_tpl_vars['filterForm']->mOptionField == $this->_tpl_vars['columnSide']->getShow('id')): ?>selected="selected"<?php endif; ?> >
            <?php echo $this->_tpl_vars['columnSide']->getShow('name'); ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
            <?php endif; ?>
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
"/>
    </form>
</div>

<?php if ($this->_tpl_vars['actionForm']->hasError()): ?>
<div class="error">
    <ul>
        <?php $_from = $this->_tpl_vars['actionForm']->getErrorMessages(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
        <li><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</div>
<?php endif; ?>

<form name="blockform" method="post" action="./index.php?action=BlockList">
    <?php echo smarty_function_xoops_token(array('form' => $this->_tpl_vars['actionForm']), $this);?>

    <table class="outer">
        <tr>
            <th><?php echo @_AD_LEGACY_LANG_BID; ?>

                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_BID; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
"
                    title="<?php echo @_ASCENDING; ?>
" /></a>
                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_BID; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
"
                    title="<?php echo @_DESCENDING; ?>
" /></a></th>
            <th><?php echo @_AD_LEGACY_LANG_BLOCK_MOD; ?>

                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_MID; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
"
                    title="<?php echo @_ASCENDING; ?>
" /></a>
                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_MID; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
"
                    title="<?php echo @_DESCENDING; ?>
" /></a></th>
            <th><?php echo @_AD_LEGACY_LANG_TITLE; ?>

                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_TITLE; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
"
                    title="<?php echo @_ASCENDING; ?>
" /></a>
                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_TITLE; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
"
                    title="<?php echo @_DESCENDING; ?>
" /></a></th>
            <th><?php echo @_AD_LEGACY_LANG_SIDE; ?>

                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_SIDE; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
"
                    title="<?php echo @_ASCENDING; ?>
" /></a>
                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_SIDE; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
"
                    title="<?php echo @_DESCENDING; ?>
" /></a><br/>
                <?php echo @_AD_LEGACY_LANG_LCR; ?>

            </th>
            <th><?php echo @_AD_LEGACY_LANG_WEIGHT; ?>

                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_WEIGHT; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
"
                    title="<?php echo @_ASCENDING; ?>
" /></a>
                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_WEIGHT; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
"
                    title="<?php echo @_DESCENDING; ?>
" /></a></th>
            <th><?php echo @_AD_LEGACY_LANG_BCACHETIME; ?>

                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_BCACHETIME; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
"
                    title="<?php echo @_ASCENDING; ?>
" /></a>
                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_BCACHETIME; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
"
                    title="<?php echo @_DESCENDING; ?>
" /></a></th>
            <th><?php echo @_AD_LEGACY_LANG_LAST_MODIFIED; ?>

                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @NEWBLOCKS_SORT_KEY_LAST_MODIFIED; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
"
                    title="<?php echo @_ASCENDING; ?>
" /></a>
                <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @NEWBLOCKS_SORT_KEY_LAST_MODIFIED; ?>
"><img
                        src="<?php echo ((is_array($_tmp=" icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
"
                    title="<?php echo @_DESCENDING; ?>
" /></a></th>
            <th><?php echo @_AD_LEGACY_LANG_UNINSTALL; ?>
<br/>
                <input name="allbox" id="allbox"
                       onclick="with(document.blockform){for(i=0;i<length;i++){if(elements[i].type=='checkbox'&&elements[i].disabled==false&&elements[i].name.indexOf('uninstall')>=0){elements[i].checked=this.checked;}}}"
                       type="checkbox" value="Check All"/></th>
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
                <span class="legacy_blocktype_module"><?php echo $this->_tpl_vars['obj']->mModule->getVar('name'); ?>
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
            <td class="legacy_list_title"><?php echo smarty_function_xoops_input(array('type' => 'text','name' => 'title','key' => $this->_tpl_vars['obj']->get('bid'),'value' => $this->_tpl_vars['obj']->get('title'),'size' => 14,'maxlength' => 255), $this);?>

            </td>
            <td class="legacy_blockside">
                <?php echo ''; ?><?php if ($this->_tpl_vars['obj']->get('side') == 25): ?><?php echo '<div class="legacy_blocksideInput active">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 25,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php else: ?><?php echo '<div class="legacy_blocksideInput inactive">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 25,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php endif; ?><?php echo '<div class="legacy_blockside_separator">:</div>'; ?><?php if ($this->_tpl_vars['obj']->get('side') == 0): ?><?php echo '<div class="legacy_blocksideInput active">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 0,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php else: ?><?php echo '<div class="legacy_blocksideInput inactive">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 0,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php endif; ?><?php echo '<div class="legacy_blockside_separator">-</div>'; ?><?php if ($this->_tpl_vars['obj']->get('side') == 3): ?><?php echo '<div class="legacy_blocksideInput active">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 3,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php else: ?><?php echo '<div class="legacy_blocksideInput inactive">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 3,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['obj']->get('side') == 5): ?><?php echo '<div class="legacy_blocksideInput active">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 5,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php else: ?><?php echo '<div class="legacy_blocksideInput inactive">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 5,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['obj']->get('side') == 4): ?><?php echo '<div class="legacy_blocksideInput active">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 4,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php else: ?><?php echo '<div class="legacy_blocksideInput inactive">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 4,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php endif; ?><?php echo '<div class="legacy_blockside_separator">-</div>'; ?><?php if ($this->_tpl_vars['obj']->get('side') == 1): ?><?php echo '<div class="legacy_blocksideInput active">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 1,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php else: ?><?php echo '<div class="legacy_blocksideInput inactive">'; ?><?php echo smarty_function_xoops_input(array('type' => 'radio','name' => 'side','key' => $this->_tpl_vars['obj']->get('bid'),'value' => 1,'default' => $this->_tpl_vars['obj']->get('side')), $this);?><?php echo '</div>'; ?><?php endif; ?><?php echo ''; ?>

            </td>
            <td class="legacy_list_select">
                <?php echo smarty_function_xoops_input(array('type' => 'text','name' => 'weight','size' => 4,'key' => $this->_tpl_vars['obj']->get('bid'),'value' => $this->_tpl_vars['obj']->get('weight'),'class' => 'legacy_list_number'), $this);?>

            </td>
            <td class="legacy_list_select">
                <select name="bcachetime[<?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
]">
                    <?php $this->assign('bid', $this->_tpl_vars['obj']->getShow('bid')); ?>
                    <?php echo smarty_function_xoops_optionsArray(array('id' => "bcachetime[".($this->_tpl_vars['bid'])."]",'from' => $this->_tpl_vars['cachetimeArr'],'value' => 'cachetime','label' => 'label','default' => $this->_tpl_vars['obj']->get('bcachetime')), $this);?>

                </select>
            </td>
            <td class="legacy_list_date"><?php echo ((is_array($_tmp=$this->_tpl_vars['obj']->getShow('last_modified'))) ? $this->_run_mod_handler('xoops_formattimestamp', true, $_tmp, 'l') : smarty_modifier_xoops_formattimestamp($_tmp, 'l')); ?>
</td>
            <td class="legacy_list_select"><input type="checkbox" name="uninstall[<?php echo $this->_tpl_vars['obj']->get('bid'); ?>
]" value="1"/>
            </td>
            <td class="legacy_list_control">
                <?php if ($this->_tpl_vars['obj']->get('block_type') == 'C'): ?>
                <a href="./index.php?action=CustomBlockEdit&amp;bid=<?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
"><img src="<?php echo ((is_array($_tmp=" icons/block_edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
"
                    alt="<?php echo @_EDIT; ?>
" title="<?php echo @_EDIT; ?>
" /></a>
                <?php else: ?>
                <a href="./index.php?action=BlockEdit&amp;bid=<?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
"><img src="<?php echo ((is_array($_tmp=" icons/block_edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
"
                    alt="<?php echo @_EDIT; ?>
" title="<?php echo @_EDIT; ?>
" /></a>
                <?php endif; ?>
                <a href="./index.php?action=BlockUninstall&amp;bid=<?php echo $this->_tpl_vars['obj']->getShow('bid'); ?>
"><img src="<?php echo ((is_array($_tmp=" icons/block_remove.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
"
                    alt="<?php echo @_AD_LEGACY_LANG_UNINSTALL; ?>
"
                    title="<?php echo @_AD_LEGACY_LANG_UNINSTALL; ?>
" /></a>
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
            <td colspan="11" class="foot">
                <input type="submit" value="<?php echo @_SUBMIT; ?>
" class="formButton"/>
            </td>
        </tr>
    </table>
</form>

<div class="pagenavi"><?php echo smarty_function_xoops_pagenavi(array('pagenavi' => $this->_tpl_vars['pageNavi']), $this);?>
</div>