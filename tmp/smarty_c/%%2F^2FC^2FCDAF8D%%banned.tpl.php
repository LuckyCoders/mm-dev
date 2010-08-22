<?php /* Smarty version 2.6.26, created on 2010-08-12 21:55:15
         compiled from banned.tpl */ ?>
        <center>
            <table class="top_hidden">
                <tr>
                    <td>
<?php if ($this->_tpl_vars['hasInsertPermission']): ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_banned']['add_to_banned'],'blink' => 'index.php?page=banned&action=add_entry" type="wrn','bwidth' => 180)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['ban_selection_text'],'blink' => $this->_tpl_vars['ban_selection_link'],'bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['back'],'blink' => 'javascript:window.history.back()" type="def','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </td>
                    <td align="right"><?php echo $this->_tpl_vars['ban_pagination']; ?>
</td>
                </tr>
            </table>
            <script type="text/javascript">
                answerbox.btn_ok='<?php echo $this->_tpl_vars['lang_global']['yes_low']; ?>
';
                answerbox.btn_cancel='<?php echo $this->_tpl_vars['lang_global']['no']; ?>
';
                var del_banned = '<?php echo $this->_tpl_vars['ban_js_delbanned']; ?>
';
            </script>
            <table class="lined">
                <tr>
                    <th width="5%"><?php echo $this->_tpl_vars['lang_global']['delete_short']; ?>
</th>
<?php $_from = $this->_tpl_vars['ban_thcolumn_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['th_column']):
?>
                    <th width="<?php echo $this->_tpl_vars['th_column']['width']; ?>
"><a href="<?php echo $this->_tpl_vars['th_column']['link']; ?>
" <?php echo $this->_tpl_vars['th_column']['class']; ?>
><?php echo $this->_tpl_vars['th_column']['text']; ?>
</a></th>
<?php endforeach; endif; unset($_from); ?>
                </tr>
<?php $_from = $this->_tpl_vars['ban_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ban']):
?>
                <tr>
                    <td>
                        <img src="img/aff_cross.png" onclick="answerBox('<?php echo $this->_tpl_vars['lang_global']['delete']; ?>
: <font color=white><?php echo $this->_tpl_vars['ban']['accnameout_specialchars']; ?>
</font><br /><?php echo $this->_tpl_vars['lang_global']['are_you_sure']; ?>
', del_banned + '<?php echo $this->_tpl_vars['ban']['id']; ?>
');" style="cursor:pointer;" alt="" />
                    </td>
                    <td><?php echo $this->_tpl_vars['ban']['accnameout']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['ban']['bandate']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['ban']['unbandate']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['ban']['bannedby']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['ban']['banreason']; ?>
</td>
                </tr>
<?php endforeach; endif; unset($_from); ?>
                <tr>
                    <td colspan="6" align="right" class="hidden"><?php echo $this->_tpl_vars['lang_banned']['tot_banned']; ?>
 : <?php echo $this->_tpl_vars['ban_count']; ?>
</td>
                </tr>
            </table>
            <br/>
        </center