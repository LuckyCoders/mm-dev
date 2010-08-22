<?php /* Smarty version 2.6.26, created on 2010-08-19 21:49:18
         compiled from banned_add_entry.tpl */ ?>
        <center>
            <fieldset class="half_frame">
                <legend><?php echo $this->_tpl_vars['lang_banned']['ban_entry']; ?>
</legend>
                <form method="get" action="index.php" name="form">
                    <input type="hidden" name="action" value="do_add_entry" />
                    <input type="hidden" name="page" value="banned" />
                    <table class="flat">
                        <tr>
                            <td><?php echo $this->_tpl_vars['lang_banned']['ban_type']; ?>
</td>
                            <td>
                                <select name="ban_type">
                                    <option value="ip_banned" ><?php echo $this->_tpl_vars['lang_banned']['ip']; ?>
</option>
                                    <option value="account_banned" ><?php echo $this->_tpl_vars['lang_banned']['account']; ?>
</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $this->_tpl_vars['lang_banned']['entry']; ?>
</td>
                            <td>
                                <input type="text" name="entry" size="24" maxlength="20" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $this->_tpl_vars['lang_banned']['ban_time']; ?>
</td>
                            <td>
                                <input type="text" name="bantime" size="24" maxlength="40" value="1" />
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $this->_tpl_vars['lang_banned']['banreason']; ?>
</td>
                            <td>
                                <input type="text" name="banreason" size="24" maxlength="255" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_banned']['ban_entry'],'blink' => 'javascript:do_submit()" type="wrn','bwidth' => 180)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            </td>
                            <td>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['back'],'blink' => 'index.php?page=banned" type="def','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </fieldset>
            <br/><br/>
        </center>