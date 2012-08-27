<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:39
         compiled from file:admin_theme.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'xoops_escape', 'file:admin_theme.html', 8, false),array('modifier', 'theme', 'file:admin_theme.html', 24, false),array('function', 'stylesheet', 'file:admin_theme.html', 11, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->_tpl_vars['xoops_charset']; ?>
" />
<meta http-equiv="content-language" content="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<title><?php echo ((is_array($_tmp=$this->_tpl_vars['legacy_sitename'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
 : <?php echo @_CPHOME; ?>
 : <?php echo ((is_array($_tmp=$this->_tpl_vars['legacy_pagetitle'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</title>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/include/xoops.js"></script>

<?php echo Legacy_function_stylesheet(array('file' => "style.css",'static' => true), $this);?>

<?php echo Legacy_function_stylesheet(array('file' => "module.css",'static' => true), $this);?>


<script type="text/javascript">
<!-- <![CDATA[
   
var cid = <?php if ($_GET['fct'] == 'preferences' && $_GET['mod'] > 0): ?><?php echo $_GET['mod']; ?>
<?php else: ?><?php echo $this->_tpl_vars['currentModule']->mXoopsModule->get('mid'); ?>
<?php endif; ?>;
function ccToggle(id)
{
	var el = xoopsGetElementById('c'+id).style;
	if (el.display == 'block') {
		el.display = 'none';
		xoopsGetElementById('t'+id).className = 'head';
		xoopsGetElementById('i'+id).src = '<?php echo ((is_array($_tmp="design/max.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
';
	} else {
		el.display = 'block';
		xoopsGetElementById('t'+id).className = 'head2';
		xoopsGetElementById('i'+id).src = '<?php echo ((is_array($_tmp="design/min.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
';
	}
}


function ccOpenAll()
{
       var divs = document.getElementsByTagName('div');
       for (var i=0;i<divs.length;i++) {
	if (divs[i].className == 'head') {
	var divid = divs[i].id; 
	var divcid = divid.replace(/t/i, 'c');
	var cidel = xoopsGetElementById(divcid); 
	if ( cidel.className == 'submenu' ) {
		cidel.style.display = 'block';
		divs[i].className = 'head2';
		var imgid = divid.replace(/t/i, 'i');
		xoopsGetElementById(imgid).src = '<?php echo ((is_array($_tmp="design/min.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
';	
	}
	}
	}
}


function ccCloseAll()
{
       var divs = document.getElementsByTagName('div');
       for (var i=0;i<divs.length;i++) {
	if (divs[i].className == 'head2') {
	var divid = divs[i].id; 
	var divcid = divid.replace(/t/i, 'c');
	var cidel = xoopsGetElementById(divcid); 
	if ( cidel.className == 'submenu' ) {
		cidel.style.display = 'none';
		divs[i].className = 'head';
		var imgid = divid.replace(/t/i, 'i');
		xoopsGetElementById(imgid).src = '<?php echo ((is_array($_tmp="design/max.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
';	
	}
	}
	}
}

function ccOpenCid()
{
	ccCloseAll();
	ccToggle(cid);
}

   var startwidth = '0px';

       function setEffectCookie(name, value, expiredays)
    {
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; expires=" + todayDate.toGMTString() + "; path=/;"
      }

      function getEffectCookie(name)
     {
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie )
		{
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
			endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
		break;
	}
	return "";
      }

   function toggleEffect(target, resizetarget, toggleimg) {
    var targetstyle = xoopsGetElementById(target).style;
    var elestyle = xoopsGetElementById(resizetarget).style;
    var imgele = xoopsGetElementById(toggleimg);

    if (elestyle.display == "block") {
        elestyle.display = "none";
          startwidth = targetstyle.width;
        targetstyle.width = '20px';
         imgele.src = '<?php echo ((is_array($_tmp="design/menu_restore.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
';
         imgele.alt = 'Click me if you want to restore this left-column';
         imgele.title = 'Click me if you want to restore this left-column';
	setEffectCookie( 'effect', 'yes', 1 );
	xoopsGetElementById('toggleall').style.display = "none";
      }
      else {
        elestyle.display = "block";
        targetstyle.width = startwidth;
         imgele.src = '<?php echo ((is_array($_tmp="design/menu_minimize.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
';
         imgele.alt = 'Click me if you want to minimize this left-column';
         imgele.title = 'Click me if you want to minimize this left-column';
	setEffectCookie( 'effect', 'no', 1 );
	xoopsGetElementById('toggleall').style.display = "";
      }
   }

   function onloadEffect(target, resizetarget, toggleimg) {
	if ( getEffectCookie("effect") == "yes" ){
        xoopsGetElementById(resizetarget).style.display = "none";
          startwidth = xoopsGetElementById(target).style.width;
        xoopsGetElementById(target).style.width = '20px';
         xoopsGetElementById(toggleimg).src = '<?php echo ((is_array($_tmp="design/menu_restore.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
';
         xoopsGetElementById(toggleimg).alt = 'Click me if you want to restore this left-column';
         xoopsGetElementById(toggleimg).title = 'Click me if you want to restore this left-column';
	xoopsGetElementById('toggleall').style.display = "none";
      }
     }	

// ]]> -->
</script>
<?php echo $this->_tpl_vars['xoops_module_header']; ?>

</head>
<body onload="ccToggle(cid);onloadEffect('leftcolumn', 'minimizelc', 'lcimage');">


<div id="container">

<div id="header">

<div class="logo"><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/admin.php">XOOPS Cube Administration</a></div>

<div class="headerSearch">
<form action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=actSearch" method="post" class="headerSearchForm">
<input type="text" size="40" name="keywords" />
<input type="submit" value="Search" />
</form>
</div>

<div class="topnav">
<!-- 2008-12-07 Gigamaster, Test Accessibility -->
<span class="linkadmin">
<img src="<?php echo ((is_array($_tmp="icons/tool.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=PreferenceList"><?php echo @_MI_LEGACY_MENU_PREFERENCE; ?>
</a> 
<img src="<?php echo ((is_array($_tmp="icons/theme.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ThemeList"><?php echo @_MI_LEGACY_BLOCK_THEMES_NAME; ?>
</a> 
<img src="<?php echo ((is_array($_tmp="icons/module.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleList"><?php echo @_AD_LEGACY_LANG_BLOCK_MOD; ?>
</a> 
<img src="<?php echo ((is_array($_tmp="icons/blocks.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockList"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</a>
<!--<img src="<?php echo ((is_array($_tmp="icons/folder_explore.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="javascript:openWithSelfMain('<?php echo $this->_tpl_vars['xoops_url']; ?>
/common/fckeditor/editor/plugins/kfm/index.php', 'filemanager', 750, 600);"><?php echo @_IMGMANAGER; ?>
</a>-->
<img src="<?php echo ((is_array($_tmp="icons/group.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/user/admin/index.php"><?php echo @_MEMBERS; ?>
</a> 
<img src="<?php echo ((is_array($_tmp="icons/comments.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=CommentList"><?php echo @_COMMENTS; ?>
</a>
</span> 

<span class="linksite"><img src="<?php echo ((is_array($_tmp="icons/home.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/"><?php echo @_YOURHOME; ?>
</a>  
 <img src="<?php echo ((is_array($_tmp="icons/logout.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" /> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/user.php?op=logout"><?php echo @_LOGOUT; ?>
</a></span> 
</div>
</div>

<div id="admincontent">
<table cellspacing="0">
<tr>
<td id="leftcolumn">
   <span id="toggleall" style="padding:0px 10px;">
   <a href="javascript:void(0)" onclick="ccOpenAll()"><img src="<?php echo ((is_array($_tmp="design/menu_openall.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="Click me if you want to open all sidemenu!"  title="Click me if you want to open all sidemenu!" /></a>&nbsp;
   <a href="javascript:void(0)" onclick="ccCloseAll()"><img src="<?php echo ((is_array($_tmp="design/menu_closeall.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="Click me if you want to close all sidemenu!" title="Click me if you want to close all sidemenu!"/></a>&nbsp;
   <a href="javascript:void(0)" onclick="ccOpenCid()"><img src="<?php echo ((is_array($_tmp="design/menu_openactive.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="Click me if you want to open only the sidemenu of current module!" title="Click me if you want to open only the sidemenu of current module!"/></a>&nbsp;
   <a href="#contentBottom"><img src="<?php echo ((is_array($_tmp="design/menu_bottom.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="Go to Bottom" title="Go to Bottom"/></a>&nbsp;
   <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=Help&amp;dirname=legacy"><img src="<?php echo ((is_array($_tmp="design/menu_help.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="Help" title="Help"/></a>&nbsp;
   </span>
   <a href="javascript:void(0)" onclick="toggleEffect('leftcolumn', 'minimizelc', 'lcimage')"><img id="lcimage" src="<?php echo ((is_array($_tmp="design/menu_minimize.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="Click me if you want to minimize this left-column" title="Click me if you want to minimize this left-column" /></a>
  <div id="minimizelc" style="display: block;">
  <?php echo $this->_tpl_vars['xoops_lblocks']['sidemenu']['content']; ?>


  <?php $_from = $this->_tpl_vars['xoops_lblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['lblock'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['lblock']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['block']):
        $this->_foreach['lblock']['iteration']++;
?>
  <?php if ($this->_tpl_vars['block']['name'] != 'action_search' && $this->_tpl_vars['block']['name'] != 'sidemenu'): ?>
  <?php echo $this->_tpl_vars['block']['content']; ?>

  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>
   </div>
</td>
<td id="centercolumn">

<noscript>
  <div id="menunavi">
  <h2><?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('name'); ?>
</h2>
  <?php if ($this->_tpl_vars['currentModule']->getAdminMenu()): ?>
    <ul class="submenunavi">
      <?php $_from = $this->_tpl_vars['currentModule']->getAdminMenu(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
        <?php if ($this->_tpl_vars['menu']['show'] !== false): ?>
          <li><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['menu']['link'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp, 'link') : smarty_modifier_xoops_escape($_tmp, 'link')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['menu']['title'])) ? $this->_run_mod_handler('xoops_escape', true, $_tmp) : smarty_modifier_xoops_escape($_tmp)); ?>
</a></li>
        <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>

          <?php if ($this->_tpl_vars['currentModule']->mXoopsModule->getInfo('blocks') && $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N') != 'legacy' && $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N') != 'altsys' && $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N') != 'system'): ?>
          <li><img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockList&amp;dirname=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N'); ?>
"><?php echo @_MI_LEGACY_MENU_BLOCKLIST; ?>
</a></li>
          <li><img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockInstallList&amp;dirname=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N'); ?>
"><?php echo @_MI_LEGACY_MENU_BLOCKINSTALL; ?>
</a></li>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['currentModule']->mXoopsModule->getInfo('templates') && $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N') != 'legacyRender' && $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N') != 'altsys' && $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N') != 'system'): ?>
          <li><img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacyRender/admin/index.php?action=TplfileList&amp;tpl_module=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N'); ?>
&amp;sort=-9"><?php echo @_AD_LEGACY_LANG_TEMPLATE_INFO; ?>
</a></li>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['currentModule']->mXoopsModule->getInfo('hasComments')): ?>
          <li><img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=CommentList&amp;com_modid=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('mid'); ?>
&amp;sort=-8"><?php echo @_MI_LEGACY_MENU_COMMENT_MANAGE; ?>
</a></li>
          <?php endif; ?>
        <?php if ($this->_tpl_vars['currentModule']->mXoopsModule->hasNeedUpdate()): ?>
          <li><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleUpdate&amp;dirname=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N'); ?>
"><?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
&nbsp;<img src="<?php echo ((is_array($_tmp="icons/update.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" title="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" /></a></li>
        <?php else: ?>
          <li><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleUpdate&amp;dirname=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N'); ?>
"><img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" title="<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
" />&nbsp;<?php echo @_AD_LEGACY_LANG_UPGRADE; ?>
</a></li>
        <?php endif; ?>
          <li><img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleEdit&amp;mid=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('mid'); ?>
"><?php echo @_EDIT; ?>
</a></li>
          <li><img src="<?php echo ((is_array($_tmp="icons/upgrade.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="" title="" />&nbsp;<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=ModuleInfo&amp;dirname=<?php echo $this->_tpl_vars['currentModule']->mXoopsModule->getVar('dirname','N'); ?>
"><?php echo @_AD_LEGACY_LANG_INFORMATION; ?>
</a></li>
    </ul>
  <?php endif; ?>
  </div>
</noscript>

  <div id="contentBody"><?php echo $this->_tpl_vars['xoops_contents']; ?>
</div>
  <div id="contentBottom" class="return_top"><a href="#container"><?php echo @_RETURN_TOP; ?>
</a></div>
  
</td>
</tr>
</table>
</div>

<div id="footer">Powered by&nbsp;<?php echo @XOOPS_VERSION; ?>
 &copy; 2001-2012 <a href="http://sourceforge.net/projects/xoopscube/" rel="external">The XOOPS Cube Project<br />
</a>Help Us to Improve <a href="http://xoopscube.org/" rel="external">XOOPS Cube</a> - Report All Bugs to: <a href="http://sourceforge.net/tracker/?group_id=159211"> Project Bug Tracker <img src="<?php echo ((is_array($_tmp="icons/bug.png")) ? $this->_run_mod_handler('theme', true, $_tmp) : Legacy_modifier_theme($_tmp)); ?>
" alt="Bug report" /></a></div>

</div>
</body>
</html>
<?php echo $this->_tpl_vars['stdout_buffer']; ?>
