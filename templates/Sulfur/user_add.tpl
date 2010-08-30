                <center>
                    <script type="text/javascript" src="libs/js/sha1.js"></script>
{literal}
                    <script type="text/javascript">
                        // <![CDATA[
                          function do_submit_data ()
                          {
                            if (document.form.new_pass1.value != document.form.new_pass2.value)
                            {
                              alert('{$lang_user.nonidentical_passes}');
                              return;
                            }
                            else
                            {
                              document.form.pass.value = hex_sha1(document.form.new_user.value.toUpperCase()+':'+document.form.new_pass1.value.toUpperCase());
                              document.form.new_pass1.value = '0';
                              document.form.new_pass2.value = '0';
                              do_submit();
                            }
                          }
                        // ]]>
                    </script>
{/literal}
                    <fieldset style="width: 550px;">
                        <legend>{$lang_user.create_new_acc}</legend>
                        <form method="get" action="index.php" name="form">
                            <input type="hidden" name="page" value="user" maxlength="256" />
                            <input type="hidden" name="pass" value="" maxlength="256" />
                            <input type="hidden" name="action" value="doadd_new" />
                            <table class="flat">
                                <tr>
                                    <td>{$lang_user.username}</td>
                                    <td><input type="text" name="new_user" size="24" maxlength="15" value="New_Account" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.password}</td>
                                    <td><input type="text" name="new_pass1" size="24" maxlength="25" value="123456" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.confirm}</td>
                                    <td><input type="text" name="new_pass2" size="24" maxlength="25" value="123456" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.email}</td>
                                    <td><input type="text" name="new_mail" size="24" maxlength="225" value="none@mail.com" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.locked}</td>
                                    <td><input type="checkbox" name="new_locked" value="1" /></td>
                                </tr>
{if $expansion_select}
                                <tr>
                                    <td>{$lang_user.expansion_account}</td>
                                    <td>
                                        <select name="new_expansion">
                                            <option value="2">{$lang_user.wotlk}</option>
                                            <option value="1">{$lang_user.tbc}</option>
                                            <option value="0">{$lang_user.classic}</option>
                                        </select>
                                    </td>
                                </tr>
{/if}
                                <tr>
                                    <td>
                                        {include file='button.tpl' btext=$lang_user.create_acc blink='javascript:do_submit_data()" type="wrn' bwidth=130}
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <br /><br />
                </center>