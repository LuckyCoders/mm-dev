<?php /* Smarty version 2.6.26, created on 2010-08-22 18:35:12
         compiled from message_form.tpl */ ?>
                <div class="top"><h1><?php echo $this->_tpl_vars['lang_message']['main']; ?>
</h1></div>
                <center>
                    <form action="index.php?page=message&action=send" method="post" name="form">
                        <table class="top_hidden">
                            <tr>
                                <td align="center">
                                    Send :
                                    <select name="type">
                                        <option value="1" selected="selected"><?php echo $this->_tpl_vars['lang_message']['announcement']; ?>
</option>
                                        <option value="2"><?php echo $this->_tpl_vars['lang_message']['notification']; ?>
</option>
                                        <option value="3"><?php echo $this->_tpl_vars['lang_message']['both']; ?>
</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <textarea id="msg" name="msg" rows="26" cols="80"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table align="center" class="hidden">
                                        <tr>
                                            <td>
                                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_message']['send'],'blink' => 'javascript:do_submit()" type="wrn','bwidth' => 130)));
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
                                </td>
                            </tr>
                        </table>
                    </form>
                </center>