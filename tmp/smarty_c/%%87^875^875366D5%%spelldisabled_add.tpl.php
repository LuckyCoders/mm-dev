<?php /* Smarty version 2.6.26, created on 2010-08-21 17:57:05
         compiled from spelldisabled_add.tpl */ ?>
                <center>
                    <fieldset style="width: 550px;">
                        <legend><?php echo $this->_tpl_vars['lang_spelld']['add_new_spell']; ?>
</legend>
                        <form method="get" action="index.php" name="form">
                            <input type="hidden" name="action" value="doadd_new" />
                            <input type="hidden" name="page" value="spelldisabled" />
                            <table class="flat">
                                <tr>
                                    <td><?php echo $this->_tpl_vars['lang_spelld']['entry2']; ?>
</td>
                                    <td><input type="text" name="entry" size="24" maxlength="11" value="" /></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['lang_spelld']['flags2']; ?>
</td>
                                    <td><input type="text" name="flags" size="24" maxlength="8" value="" /></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['lang_spelld']['comment2']; ?>
</td>
                                    <td><input type="text" name="comment" size="24" maxlength="64" value="" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_spelld']['add_spell'],'blink' => 'javascript:do_submit()" type="wrn','bwidth' => 130)));
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
                    </fieldset>
                    <fieldset style="width: 440px;">
                        <table class="hidden">
                            <tr>
                                <td>
                                    <?php echo $this->_tpl_vars['lang_spelld']['dm_exp']; ?>

                                </td>
                            </tr>
                        </table>
                        <br />
                        <table class="flat" border="2" cellpadding="4" cellspacing="2">
                            <tr>
                                <th><?php echo $this->_tpl_vars['lang_spelld']['value']; ?>
</th>
                                <th><?php echo $this->_tpl_vars['lang_spelld']['type']; ?>
</th>
                            </tr>
                            <tr>
                                <td align="center">0</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['enabled']; ?>
</td>
                            </tr>
                            <tr>
                                <td align="center">1</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['disabled_p']; ?>
</td>
                            </tr>
                            <tr>
                                <td align="center">2</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['disabled_crea_npc']; ?>
</td>
                            </tr>
                            <tr>
                                <td align="center">4</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['disabled_pets']; ?>
</td>
                            </tr>
                        </table>
                        <table class="hidden">
                            <tr>
                                <td>
                                <br />
                                    <?php echo $this->_tpl_vars['lang_spelld']['combinations_hint']; ?>

                                </td>
                            </tr>
                        </table>
                        <table class="flat" border="2" cellpadding="4" cellspacing="2">
                            <tr>
                                <th><?php echo $this->_tpl_vars['lang_spelld']['value']; ?>
</th>
                                <th><?php echo $this->_tpl_vars['lang_spelld']['type']; ?>
</th>
                            </tr>
                            <tr>
                                <td align="center">3</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['disabled_p_crea_npc']; ?>
</td>
                            </tr>
                            <tr>
                                <td align="center">5</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['disabled_p_pets']; ?>
</td>
                            </tr>
                            <tr>
                                <td align="center">6</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['disabled_crea_npc_pets']; ?>
</td>
                            </tr>
                            <tr>
                                <td align="center">7</td>
                                <td><?php echo $this->_tpl_vars['lang_spelld']['disabled_p_crea_npc_pets']; ?>
</td>
                            </tr>
                        </table>
                    </fieldset>
                    <br />
                </center>