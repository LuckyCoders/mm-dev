<?php /* Smarty version 2.6.26, created on 2010-08-03 12:58:08
         compiled from footer.tpl */ ?>
                </div>
                <div id="body_buttom">
<?php if ($this->_tpl_vars['isGuest']): ?>
                    <center>
                        <table>
                            <tr>
                                <td>
                                    <a class="button" style="width:130px;" href="register.php">Register</a>
                                    <a class="button" style="width:130px;" href="login.php">Login</a>
                                </td>
                            </tr>
                        </table>
                        <br />
                    </center>
<?php endif; ?>
                    <table class="table_buttom">
                        <tr>
                            <td class="table_buttom_left"></td>
                            <td class="table_buttom_middle">
                                <?php echo $this->_tpl_vars['lang_footer']['bugs_to_admin']; ?>
<a href="mailto:<?php echo $this->_tpl_vars['admin_mail']; ?>
"><?php echo $this->_tpl_vars['lang_footer']['site_admin']; ?>
</a><br />
                                Execute time: <?php echo $this->_tpl_vars['execution_time']; ?>

<?php if ($this->_tpl_vars['debug']): ?>
                                <?php echo $this->_tpl_vars['memory']; ?>

<?php endif; ?>
                                <p>
                                    <a href="http://www.trinitycore.org/" target="_blank"><img src="img/logo-trinity.png" class="logo_border" alt="trinity" /></a>
                                    <a href="http://www.php.net/" target="_blank"><img src="img/logo-php.png" class="logo_border" alt="php" /></a>
                                    <a href="http://www.mysql.com/" target="_blank"><img src="img/logo-mysql.png" class="logo_border" alt="mysql" /></a>
                                    <a href="http://validator.w3.org/check?uri=referer" target="_blank"><img src="img/logo-css.png" class="logo_border" alt="w3" /></a>
                                    <a href="http://www.spreadfirefox.com" target="_blank"><img src="img/logo-firefox.png" class="logo_border" alt="firefox" /></a>
                                    <a href="http://www.opera.com/" target="_blank"><img src="img/logo-opera.png" class="logo_border" alt="opera" /></a>
                                </p>
                            </td>
                            <td class="table_buttom_right"></td>
                        </tr>
                    </table>
                    <br />
<?php if ($this->_tpl_vars['debug'] > 2): ?>
                    <table>
                        <tr>
                            <td align="left">
                                <?php echo $this->_tpl_vars['debug_defined_vars']; ?>

    <?php if ($this->_tpl_vars['debug'] > 3): ?>
                                <pre>
                                    <?php echo $this->_tpl_vars['debug_globals']; ?>

                                </pre>
    <?php endif; ?>
                            </td>
                        </tr>
                    <table>
<?php endif; ?>
                </div>
            </div>
        </center>
    </body>
</html>