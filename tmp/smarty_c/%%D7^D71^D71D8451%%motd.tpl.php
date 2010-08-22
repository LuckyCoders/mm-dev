<?php /* Smarty version 2.6.26, created on 2010-08-21 11:46:54
         compiled from motd.tpl */ ?>
                <center>
<?php if ($this->_tpl_vars['msg']): ?>                     <form action="index.php?page=motd&action=do_edit_motd" method="post" name="form">
                        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
<?php else: ?>
                    <form action="index.php?page=motd&action=do_add_motd" method="post" name="form">
<?php endif; ?>
                        <table class="top_hidden">
                            <tr>
                                <td colspan="3">
                                    <?php echo $this->_tpl_vars['editor']; ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
<?php if ($this->_tpl_vars['msg']): ?>
                                    <textarea id="msg" name="msg" rows="26" cols="97"><?php echo $this->_tpl_vars['msg']; ?>
</textarea>
<?php else: ?>
                                    <textarea id="msg" name="msg" rows="26" cols="97"></textarea>
<?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $this->_tpl_vars['lang_motd']['post_rules']; ?>
</td>
                                <td>
                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_motd']['post_motd'],'blink' => 'javascript:do_submit()" type="wrn','bwidth' => 230)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                </td>
                                <td>
                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['back'],'blink' => 'javascript:window.history.back()" type="def','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                <br />
                </center>