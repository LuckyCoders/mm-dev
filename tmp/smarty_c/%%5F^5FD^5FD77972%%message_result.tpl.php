<?php /* Smarty version 2.6.26, created on 2010-08-22 18:35:55
         compiled from message_result.tpl */ ?>
                <div class="top"><h1><?php echo $this->_tpl_vars['lang_message']['message_result']; ?>
</h1></div>
                <center>
                    <table class="top_hidden" width="400">
                        <tr>
                            <td align="center">
                                <br /><?php echo $this->_tpl_vars['mess']; ?>
<br /><br />
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <table align="center" class="hidden">
                                    <tr>
                                        <td>
                                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['back'],'blink' => 'javascript:window.history.back()','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </center