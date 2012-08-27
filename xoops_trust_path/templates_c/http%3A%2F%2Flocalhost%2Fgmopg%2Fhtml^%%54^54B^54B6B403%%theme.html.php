<?php /* Smarty version 2.6.26, created on 2012-08-27 17:43:36
         compiled from legacy_default/theme.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->_tpl_vars['xoops_charset']; ?>
" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-language" content="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" />
<meta name="robots" content="<?php echo $this->_tpl_vars['xoops_meta_robots']; ?>
" />
<meta name="keywords" content="<?php echo $this->_tpl_vars['xoops_meta_keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['xoops_meta_description']; ?>
" />
<meta name="rating" content="<?php echo $this->_tpl_vars['xoops_meta_rating']; ?>
" />
<meta name="author" content="<?php echo $this->_tpl_vars['xoops_meta_author']; ?>
" />
<meta name="copyright" content="<?php echo $this->_tpl_vars['xoops_meta_copyright']; ?>
" />
<meta name="generator" content="XOOPS Cube" />
<title><?php echo $this->_tpl_vars['xoops_sitename']; ?>
 - <?php echo $this->_tpl_vars['xoops_pagetitle']; ?>
</title>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->_tpl_vars['xoops_themecss']; ?>
" />

<!-- RMV: added module header -->
<?php echo $this->_tpl_vars['xoops_module_header']; ?>

<script type="text/javascript">
<!--
<?php echo $this->_tpl_vars['xoops_js']; ?>

// -->
</script>
<!--[if IE]>
<style type="text/css">
    #side{ width: 240px;}
    #content {width:690px;}
    #container { zoom: 1; padding-top: 10px; }
    .centerCcolumn { zoom: 1;}
    input {
    border-width: expression(this.type=="submit" ?'1px':'');
    border-style: expression(this.type=="submit" ?'outset':''); <br>
    border-color: expression(this.type=="submit" ?'#ccc #666 #666 #ccc':'');
    font-family: expression(this.type=="submit" ?'verdana arial':'');
    font-size: expression(this.type=="submit" ?'11px':'');
    font-weight: expression(this.type=="submit" ?'bold':'');
    color: expression(this.type=="submit" ?'#444':'');
    background-color: expression(this.type=="submit" ?'#f4f4f4':'');
    cursor: expression(this.type=="submit" ?'hand':'');
    }
</style>
<![endif]-->
</head>
<body>
<div id="layout">
<a name="top" id="top"></a>

<div id="header">
<div class="headerlogo">
<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
images/logo.png" alt="<?php echo $this->_tpl_vars['xoops_sitename']; ?>
" title="<?php echo $this->_tpl_vars['xoops_sitename']; ?>
" /></a>
</div>

    <div class="headersearch">
    <form action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/search.php" method="get">
    <input type="text" name="query" size="22" class="headerSearchField" />
    <input type="hidden" name="action" value="results" />
    <button name="submit" type="submit" value="search" accesskey="F">Search</button>
    </form>
    </div>
    </div>

<!--<div class="headerbar">

<ul id="navigation">
<li><a href="http://xoopscube.org/index.php"><span>Welcome</span></a></li>
<li><a href="http://xoopscube.org/modules/news/"><span>News</span></a></li>
<li><a href="http://xoopscube.org/modules/features/"><span>Features</span></a></li>
<li><a href="http://xoopscube.org/modules/pukiwiki"><span>Documentation</span></a></li>
<li><a href="http://xoopscube.org/modules/xhnewbb/"><span>Forum</span></a></li>
<li><a href="http://xoopscube.org/modules/workshop/"><span>Workshop</span></a></li>
</ul>
<div class="floatClear"></div>
</div>-->


<div id="container" class="clearfix">


<div id="main2columns">


    <!-- BLOCK Center-Center -->
    <?php if ($this->_tpl_vars['xoops_showcblock'] == 1): ?>
    <div class="centerCcolumn">

    <?php $_from = $this->_tpl_vars['xoops_ccblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
    <div class="centerCblock">
        <div class="centerCblockTitle">
        <?php if ($this->_tpl_vars['xoops_isadmin']): ?>
        <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockEdit&amp;bid=<?php echo $this->_tpl_vars['block']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
images/edit.png" /></a>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['block']['title']; ?>

        </div>
    <div class="centerCblockContent"><?php echo $this->_tpl_vars['block']['content']; ?>
</div>
    </div>
    <?php endforeach; endif; unset($_from); ?>

    </div>
    <?php endif; ?>

	<!-- Module Content -->
    <?php if (! empty ( $this->_tpl_vars['xoops_contents'] )): ?>
    <div id="content"><?php echo $this->_tpl_vars['xoops_contents']; ?>
</div>
    <?php endif; ?>

</div><!-- End main2columns -->


<div id="side">
    <div class="sidecolumn">

    <?php if ($this->_tpl_vars['xoops_showlblock'] == 1): ?>
    <?php $_from = $this->_tpl_vars['xoops_lblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
    <div class="leftblock">
        <div class="leftblockTitle">
        <?php if ($this->_tpl_vars['xoops_isadmin']): ?>
        <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockEdit&amp;bid=<?php echo $this->_tpl_vars['block']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
images/edit.png" /></a>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['block']['title']; ?>

        </div>
        <div class="leftblockContent"><?php echo $this->_tpl_vars['block']['content']; ?>
</div>
    </div>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>

    <br />

    <?php if ($this->_tpl_vars['xoops_showrblock'] == 1): ?>
    <?php $_from = $this->_tpl_vars['xoops_rblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
    <div class="rightblock">
        <div class="rightblockTitle">
        <?php if ($this->_tpl_vars['xoops_isadmin']): ?>
        <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockEdit&amp;bid=<?php echo $this->_tpl_vars['block']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
images/edit.png" /></a>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['block']['title']; ?>

        </div>
    	<div class="rightblockContent"><?php echo $this->_tpl_vars['block']['content']; ?>
</div>
    </div>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>

   </div><!-- End sidecolumn -->
</div><!--End Side -->

</div>
</div>


<?php if ($this->_tpl_vars['xoops_showcblock'] == 1): ?>
<div id="centerBlocks">
	<div id="centerBlocksContainer">

    <div class="centerLcolumn">
        <?php $_from = $this->_tpl_vars['xoops_clblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
        <div class="centerLblock">
        <div class="centerLblockTitle">
        <?php if ($this->_tpl_vars['xoops_isadmin']): ?>
        <a
        href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockEdit&amp;bid=<?php echo $this->_tpl_vars['block']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
images/edit.png" /></a>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['block']['title']; ?>
</div>
        <div class="centerLblockContent"><?php echo $this->_tpl_vars['block']['content']; ?>
</div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>

    <div class="centerRcolumn">
        <?php $_from = $this->_tpl_vars['xoops_crblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
        <div class="centerRblock">
        <div class="centerRblockTitle">
        <?php if ($this->_tpl_vars['xoops_isadmin']): ?>
        <a
        href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/legacy/admin/index.php?action=BlockEdit&amp;bid=<?php echo $this->_tpl_vars['block']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
images/edit.png" /></a>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['block']['title']; ?>
</div>
        <div class="centerRblockContent"><?php echo $this->_tpl_vars['block']['content']; ?>
</div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
     </div>

<div class="floatClear" /></div>

	</div>
</div><!-- End Block Center-Left and Center-Right -->
<?php endif; ?>

<br class="floatClear" />

<div id="footerbar">
<a href="http://xoops.net.br/">Portuguese</a> | <a href="http://xoopscube.org/">English</a> | <a href="http://www.xoopscube.de/">German</a> | <a href="http://www.xoopscube.gr/">Greek</a> | <a href="http://xoopscube.sourceforge.net/ja/">Japanese</a> | <a href="http://www.xoops.ne.kr/xoopscube/">Korean</a> | <a href="http://www.xoopscube.ru/">Russian</a> | <a href="http://www.xoopscube.tw/">T-Chinese</a>
<span><a href="#top"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
images/top.gif" alt="top" title="top" hspace="15" /></a></span>
<br />
<?php echo $this->_tpl_vars['xoops_footer']; ?>

</div>

</body>
</html>