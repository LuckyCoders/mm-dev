<?php /* Smarty version 2.6.26, created on 2010-08-21 16:43:14
         compiled from login_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'login_form.tpl', 34, false),)), $this); ?>
                <center>
                    <script type="text/javascript" src="libs/js/sha1.js"></script>
                    <script type="text/javascript">
<?php echo '
                    // <![CDATA[
                    function dologin ()
                    {
                        document.form.pass.value = hex_sha1(document.form.user.value.toUpperCase()+":"+document.form.login_pass.value.toUpperCase());
                        document.form.login_pass.value = "0";
                        do_submit();
                    }
                    // ]]>
'; ?>

                    </script>
                    <fieldset class="half_frame">
                        <legend><?php echo $this->_tpl_vars['lang_login']['login']; ?>
</legend>
                        <form method="post" action="index.php?page=login&amp;action=dologin" name="form" onsubmit="return dologin()">
                            <input type="hidden" name="pass" value="" maxlength="256" />
                            <table class="hidden">
                                <tr>
                                    <td>
                                        <hr />
                                    </td>
                                </tr>
                                <tr align="right">
                                    <td><?php echo $this->_tpl_vars['lang_login']['username']; ?>
 : <input type="text" name="user" size="24" maxlength="16" /></td>
                                </tr>
                                <tr align="right">
                                    <td><?php echo $this->_tpl_vars['lang_login']['password']; ?>
 : <input type="password" name="login_pass" size="24" maxlength="40" /></td>
                                </tr>
<?php if ($this->_tpl_vars['multirealm']): ?>
                                <tr align="right">
                                    <td><?php echo $this->_tpl_vars['lang_login']['select_realm']; ?>
 :
                                        <?php echo smarty_function_html_options(array('name' => 'realm','options' => $this->_tpl_vars['realms'],'selected' => $this->_tpl_vars['selectedrealm']), $this);?>

                                    </td>
                                </tr>
<?php else: ?>
                                <input type="hidden" name="realm" value="<?php echo $this->_tpl_vars['selectedrealm']; ?>
" />
<?php endif; ?>
                                <tr>
                                    <td>
                                    </td>
                                </tr>
                                <tr align="right">
                                    <td><?php echo $this->_tpl_vars['lang_login']['remember_me']; ?>
 : <input type="checkbox" name="remember" value="1"
<?php if ($this->_tpl_vars['remember_me_checked']): ?>
                                                                                                                     checked="checked"
<?php endif; ?>
                                                                                                                    />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                </tr>
                                <tr align="right">
                                    <td width="290">
                                        <input type="submit" value="" style="display:none" />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_login']['not_registrated'],'blink' => 'index.php?page=register" type="wrn','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_login']['login'],'blink' => 'javascript:dologin()" type="def','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td><a href="register.php?action=pass_recovery"><?php echo $this->_tpl_vars['lang_login']['pass_recovery']; ?>
</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <hr />
                                    </td>
                                </tr>
                            </table>
                            <script type="text/javascript">
                            // <![CDATA[
                                document.form.user.focus();
                            // ]]>
                            </script>
                        </form>
                        <br />
                    </fieldset>
                    <br /><br />
                </center>