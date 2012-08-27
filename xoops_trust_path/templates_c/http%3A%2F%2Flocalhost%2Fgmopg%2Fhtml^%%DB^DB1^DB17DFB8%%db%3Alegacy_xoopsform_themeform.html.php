<?php /* Smarty version 2.6.26, created on 2012-08-27 17:48:10
         compiled from db:legacy_xoopsform_themeform.html */ ?>
<form name='<?php echo $this->_tpl_vars['form']->getName(); ?>
' id='<?php echo $this->_tpl_vars['form']->getName(); ?>
' action='<?php echo $this->_tpl_vars['form']->getAction(); ?>
' method='<?php echo $this->_tpl_vars['form']->getMethod(); ?>
' onsubmit='return xoopsFormValidate_<?php echo $this->_tpl_vars['form']->getName(); ?>
();' <?php echo $this->_tpl_vars['form']->getExtra(); ?>
 >
  <table class="outer" style="width:100%;" cellspacing="1">
    <tr>
      <th colspan='2'>
        <?php echo $this->_tpl_vars['form']->getTitle(); ?>

      </th>
    </tr>
    <?php $_from = $this->_tpl_vars['form']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
      <?php if (is_object ( $this->_tpl_vars['element'] )): ?>
        <?php if (! $this->_tpl_vars['element']->isHidden()): ?>
          <?php if (! $this->_tpl_vars['element']->isBreak()): ?>
            <tr>
              <td class='head' style="text-align:left; vertical-align:top;">
                <?php echo $this->_tpl_vars['element']->getCaption(); ?>

                <?php if ($this->_tpl_vars['element']->getDescription() != ''): ?>
                  <br /><br /><span style="font-weight: normal;"><?php echo $this->_tpl_vars['element']->getDescription(); ?>
</span>
                <?php endif; ?>
              </td>
              <td class='even' style="text-align:left; vertical-align:top;">
                <?php echo $this->_tpl_vars['element']->render(); ?>

              </td>
            </tr>
          <?php else: ?>
            <tr><td colspan='2' <?php echo $this->_tpl_vars['element']->getClass(); ?>
><?php echo $this->_tpl_vars['element']->getExtra(); ?>
</td></tr>
          <?php endif; ?>
        <?php endif; ?>
      <?php else: ?>
        <?php echo $this->_tpl_vars['element']; ?>

      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
  </table>
  <?php $_from = $this->_tpl_vars['form']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
    <?php if ($this->_tpl_vars['element']->isHidden()): ?>
      <?php echo $this->_tpl_vars['element']->render(); ?>

    <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>
</form>