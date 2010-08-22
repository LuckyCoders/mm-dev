<?php /* Smarty version 2.6.26, created on 2010-08-03 12:56:04
         compiled from mainbody.tpl */ ?>
    <body onload="dynamicLayout();">
        <center>
            <table class="table_top">
                <tr>
                    <td class="table_top_left" valign="top">
<?php if ($this->_tpl_vars['isLoggedIn']): ?>
                            <div id="menuwrapper">
                            <ul id="menubar">
    <?php $_from = $this->_tpl_vars['topmenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['branch']):
?>
                                <li><a href="<?php echo $this->_tpl_vars['branch']['link']; ?>
"><?php echo $this->_tpl_vars['branch']['name']; ?>
</a>
                                    <ul>
        <?php $_from = $this->_tpl_vars['branch']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                                        <li><a href="<?php echo $this->_tpl_vars['item']['filename']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></li>
        <?php endforeach; endif; unset($_from); ?>
                                    </ul>
                                </li>
    <?php endforeach; endif; unset($_from); ?>
                            </ul>
                            <br class="clearit" />
                        </div>
                    </td>
                    <td class="table_top_middle">
                        <div id="username"><?php echo $this->_tpl_vars['user_name']; ?>
&nbsp;.:<?php echo $this->_tpl_vars['user_lvl_name']; ?>
&#039;s <?php echo $this->_tpl_vars['lang_header_menu']; ?>
:.</div>
                    </td>
                    <td class="table_top_right"></td>
                </tr>
            </table>
    <?php if ($this->_tpl_vars['showVersion']): ?>
        <div id="version"><?php echo $this->_tpl_vars['version']; ?>
</div>
    <?php endif; ?>
<?php else: ?>
                    </td>
                    <td class="table_top_middle"></td>
                    <td class="table_top_right"></td>
                </tr>
            </table>
<?php endif; ?>
        <div id="body_main">
            <div class="bubble">