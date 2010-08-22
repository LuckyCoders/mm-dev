<?php /* Smarty version 2.6.26, created on 2010-08-21 11:01:18
         compiled from motd_add.tpl */ ?>
                <center>
                    <form action="motd.php?action=do_add_motd" method="post" name="form">
                        <table class="top_hidden">
                            <tr>
                                <td colspan="3">
                                    <?php echo $this->_tpl_vars['editor']; ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <textarea id="msg" name="msg" rows="26" cols="97"></textarea>
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