                </div>
                <div id="body_buttom">
{if $isGuest}
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
{/if}
                    <table class="table_buttom">
                        <tr>
                            <td class="table_buttom_left"></td>
                            <td class="table_buttom_middle">
                                {$lang_footer.bugs_to_admin}<a href="mailto:{$admin_mail}">{$lang_footer.site_admin}</a><br />
                                Execute time: {$execution_time}
{if $debug}
                                {$memory}
{/if}
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
{if $debug > 2}
                    <table>
                        <tr>
                            <td align="left">
                                {$debug_defined_vars}
    {if $debug > 3}
                                <pre>
                                    {$debug_globals}
                                </pre>
    {/if}
                            </td>
                        </tr>
                    <table>
{/if}
                </div>
            </div>
        </center>
    </body>
</html>