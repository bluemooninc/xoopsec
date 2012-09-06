<?php /* Smarty version 2.6.26, created on 2012-08-28 15:03:13
         compiled from file:imagecategory_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:imagecategory_list.html', 36, false),array('modifier', 'theme', 'file:imagecategory_list.html', 83, false),array('function', 'xoops_token', 'file:imagecategory_list.html', 79, false),array('function', 'cycle', 'file:imagecategory_list.html', 113, false),array('function', 'xoops_pagenavi', 'file:imagecategory_list.html', 145, false),)), $this); ?>
<div class="adminnavi">
  <a href="./index.php"><?php echo @_MI_LEGACY_NAME; ?>
</a>
  &raquo;&raquo; <a href="./index.php?action=ImagecategoryList"><?php echo @_MI_LEGACY_MENU_IMAGE_MANAGE; ?>
</a>
  &raquo;&raquo; <span class="adminnaviTitle"><?php echo @_AD_LEGACY_LANG_IMAGECATEGORY_LIST; ?>
</span>
</div>

<h3 class="admintitle"><?php echo @_AD_LEGACY_LANG_IMAGECATEGORY_LIST; ?>
</h3>

<div class="tips">
<ul>
<li>
<?php echo @_AD_LEGACY_LANG_IMGCAT_TOTAL; ?>
: <?php echo $this->_tpl_vars['ImgcatTotal']; ?>
<br />
<?php echo @_AD_LEGACY_LANG_IMGCAT_FILETYPETOTAL; ?>
: <?php echo $this->_tpl_vars['fileImgcatTotal']; ?>
&nbsp;&nbsp;|&nbsp; <?php echo @_AD_LEGACY_LANG_IMGCAT_DBTYPETOTAL; ?>
: <?php echo $this->_tpl_vars['dbImgcatTotal']; ?>

</li>
<li>
<?php echo @_AD_LEGACY_LANG_IMAGE_TOTAL; ?>
: <?php echo $this->_tpl_vars['ImageTotal']; ?>
<br />
<?php echo @_AD_LEGACY_LANG_IMAGE_DISPLAYTOTAL; ?>
: <?php echo $this->_tpl_vars['displayImageTotal']; ?>
&nbsp;&nbsp;|&nbsp; <?php echo @_AD_LEGACY_LANG_IMAGE_NOTDISPLAYTOTAL; ?>
: <?php echo $this->_tpl_vars['notdisplayImageTotal']; ?>

</li>
<li>
<?php echo @_AD_LEGACY_TIPS_IMGCAT; ?>

</li>
<li><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=Help&amp;dirname=legacy"><?php echo @_HELP; ?>
</a></li>
</ul>
</div>

<ul class="toptab">
<li class="addFolder"><a href="index.php?action=ImagecategoryEdit"><?php echo @_AD_LEGACY_LANG_CREATE_NEW; ?>
</a></li>
<!-- <li class="addImage"><a href="javascript:openWithSelfMain('<?php echo $this->_tpl_vars['xoops_url']; ?>
/common/fckeditor/editor/plugins/kfm/index.php', 'filemanager', 750, 600);">File Manager</a></li> -->
<li class="archive"><a href="index.php?action=ImageUpload"><?php echo @_AD_LEGACY_LANG_IMAGE_UPLOAD; ?>
</a></li>
</ul>

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

<div>
<form action="./index.php" method="get">
  <input type="hidden" name="action" value="ImagecategoryList" />
  <?php echo @_SEARCH; ?>
 : 
  <input type="text" name="search" value="<?php echo $this->_tpl_vars['filterForm']->mKeyword; ?>
" />
  <?php echo @_AD_LEGACY_LANG_IMGCAT_DISPLAY; ?>
 : 
  <select name="option_field">
    <option value="all" <?php if ($this->_tpl_vars['filterForm']->mOptionField == 'all'): ?>selected="selected"<?php endif; ?>><?php echo @_ALL; ?>
</option>
    <option value="visible" <?php if ($this->_tpl_vars['filterForm']->mOptionField == 'visible'): ?>selected="selected"<?php endif; ?>><?php echo @_YES; ?>
</option>
    <option value="invisible" <?php if ($this->_tpl_vars['filterForm']->mOptionField == 'invisible'): ?>selected="selected"<?php endif; ?>><?php echo @_NO; ?>
</option>
  </select>
  <?php echo @_AD_LEGACY_LANG_IMGCAT_STORETYPE; ?>
 : 
  <select name="option_field2">
    <option value="all" <?php if ($this->_tpl_vars['filterForm']->mOptionField2 == 'all'): ?>selected="selected"<?php endif; ?>><?php echo @_ALL; ?>
</option>
    <option value="file" <?php if ($this->_tpl_vars['filterForm']->mOptionField2 == 'file'): ?>selected="selected"<?php endif; ?>>FILE</option>
    <option value="db" <?php if ($this->_tpl_vars['filterForm']->mOptionField2 == 'db'): ?>selected="selected"<?php endif; ?>>DB</option>
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

<form name="imagecategorylistform" method="post" action="./index.php?action=ImagecategoryList">
  <?php echo smarty_function_xoops_token(array('form' => $this->_tpl_vars['actionForm']), $this);?>

<table class="outer">
  <tr>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_ID; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_ID; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_ID; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_NAME; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_NAME; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_NAME; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_MAXSIZE; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_MAXSIZE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_MAXSIZE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_MAXWIDTH; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_MAXWIDTH; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_MAXWIDTH; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_MAXHEIGHT; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_MAXHEIGHT; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_MAXHEIGHT; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_DISPLAY; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_DISPLAY; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_DISPLAY; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_WEIGHT; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_WEIGHT; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_WEIGHT; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMGCAT_STORETYPE; ?>

      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_STORETYPE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/up.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_ASCENDING; ?>
" title="<?php echo @_ASCENDING; ?>
" /></a>
      <a href="<?php echo $this->_tpl_vars['pageNavi']->renderUrlForSort(); ?>
&amp;sort=-<?php echo @IMAGECATEGORY_SORT_KEY_IMGCAT_STORETYPE; ?>
"><img src="<?php echo ((is_array($_tmp="icons/down.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DESCENDING; ?>
" title="<?php echo @_DESCENDING; ?>
" /></a></th>
    <th><?php echo @_AD_LEGACY_LANG_IMAGE_COUNT; ?>
</th>
    <th><?php echo @_DELETE; ?>
<br />
      <input name="allbox" id="allbox" onclick="with(document.imagecategorylistform){for(i=0;i<length;i++){if(elements[i].type=='checkbox'&&elements[i].disabled==false&&elements[i].name.indexOf('delete')>=0){elements[i].checked=this.checked;}}}" type="checkbox" value="Check All" /></th>
    <th><?php echo @_AD_LEGACY_LANG_CONTROL; ?>
</th>
  </tr>
  <?php $_from = $this->_tpl_vars['objects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['obj']):
?>
    <?php if ($this->_tpl_vars['obj']->getShow('imgcat_display') == 1): ?>
      <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
 active">
    <?php else: ?>
      <tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
    <?php endif; ?>
      <td class="legacy_list_id"><?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
</td>
      <td class="legacy_list_title">
        <input type="text" size="12" name="name[<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
]" value="<?php echo $this->_tpl_vars['obj']->getShow('imgcat_name'); ?>
" />
      </td>
      <td class="legacy_list_number"><input type="text" size="6" maxlength="10" name="maxsize[<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
]" value="<?php echo $this->_tpl_vars['obj']->getShow('imgcat_maxsize'); ?>
" class=legacy_list_number /></td>
      <td class="legacy_list_number"><input type="text" size="4" maxlength="6" name="maxwidth[<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
]" value="<?php echo $this->_tpl_vars['obj']->getShow('imgcat_maxwidth'); ?>
" class=legacy_list_number /></td>
      <td class="legacy_list_number"><input type="text" size="4" maxlength="6" name="maxheight[<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
]" value="<?php echo $this->_tpl_vars['obj']->getShow('imgcat_maxheight'); ?>
" class=legacy_list_number /></td>
      <td class="legacy_list_select"><input type="checkbox" name="display[<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
]" value="1" <?php if ($this->_tpl_vars['obj']->getShow('imgcat_display')): ?>checked="checked"<?php endif; ?> /></td>
      <td class="legacy_list_order"><input type="text" size="4" maxlength="6" name="weight[<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
]" value="<?php echo $this->_tpl_vars['obj']->getShow('imgcat_weight'); ?>
" class=legacy_list_number /></td>
      <td class="legacy_list_type"><?php echo $this->_tpl_vars['obj']->getShow('imgcat_storetype'); ?>
</td>
      <td class="legacy_list_number"><?php echo ((is_array($_tmp=$this->_tpl_vars['obj']->getImageCount())) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</td>
      <td class="legacy_list_select"><input type="checkbox" name="delete[<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
]" value="1" /></td>
      <td class="legacy_list_control">
        <a href="./index.php?action=ImageList&amp;imgcat_id=<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/view.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_LIST; ?>
" title="<?php echo @_AD_LEGACY_LANG_LIST; ?>
" /></a>
        <a href="./index.php?action=ImageCreate&amp;imgcat_id=<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/add.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_IMAGE_NEW; ?>
" title="<?php echo @_AD_LEGACY_LANG_IMAGE_NEW; ?>
" /></a>
        <a href="./index.php?action=ImagecategoryEdit&amp;imgcat_id=<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/edit.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_EDIT; ?>
" title="<?php echo @_EDIT; ?>
" /></a>
        <a href="./index.php?action=ImagecategoryDelete&amp;imgcat_id=<?php echo $this->_tpl_vars['obj']->getShow('imgcat_id'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/delete.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_DELETE; ?>
" title="<?php echo @_DELETE; ?>
" /></a>
      </td>
    </tr>
  <?php endforeach; endif; unset($_from); ?>
    <tr>
      <td colspan="11" class="foot">
        <input type="submit" value="<?php echo @_SUBMIT; ?>
" class="formButton" />
      </td>
    </tr>
</table>
</form>

<div class="pagenavi"><?php echo smarty_function_xoops_pagenavi(array('pagenavi' => $this->_tpl_vars['pageNavi']), $this);?>
</div>