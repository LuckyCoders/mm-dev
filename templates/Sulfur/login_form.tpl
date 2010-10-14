                <center>
                    <script type="text/javascript" src="libs/js/sha1.js"></script>
                    <script type="text/javascript">
{literal}
                    // <![CDATA[
                    function dologin ()
                    {
                        document.form.pass.value = hex_sha1(document.form.user.value.toUpperCase()+":"+document.form.login_pass.value.toUpperCase());
                        document.form.login_pass.value = "0";
                        do_submit();
                    }
                    // ]]>
{/literal}
                    </script>
                    <fieldset class="half_frame">
                        <legend>{$lang_login.login}</legend>
                        <form method="post" action="index.php?page=login&amp;action=dologin" name="form" onsubmit="return dologin()">
                            <input type="hidden" name="pass" value="" maxlength="256" />
                            <table class="hidden">
                                <tr>
                                    <td>
                                        <hr />
                                    </td>
                                </tr>
                                <tr align="right">
                                    <td>{$lang_login.username} : <input type="text" name="user" size="24" maxlength="16" /></td>
                                </tr>
                                <tr align="right">
                                    <td>{$lang_login.password} : <input type="password" name="login_pass" size="24" maxlength="40" /></td>
                                </tr>
{if $multirealm}
                                <tr align="right">
                                    <td>{$lang_login.select_realm} :
                                        {html_options name=realm options=$realms selected=$selectedrealm}
                                    </td>
                                </tr>
{else}
                                <input type="hidden" name="realm" value="{$selectedrealm}" />
{/if}
                                <tr>
                                    <td>
                                    </td>
                                </tr>
                                <tr align="right">
                                    <td>{$lang_login.remember_me} : <input type="checkbox" name="remember" value="1"
{if $remember_me_checked}
                                                                                                                     checked="checked"
{/if}
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
{include file='button.tpl' btext=$lang_login.not_registrated blink='index.php?page=register" type="wrn' bwidth=130}
{include file='button.tpl' btext=$lang_login.login blink='javascript:dologin()" type="def' bwidth=130}
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td><a href="index.php?page=register&action=pass_recovery">{$lang_login.pass_recovery}</a></td>
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