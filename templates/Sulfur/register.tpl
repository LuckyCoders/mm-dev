{if $action eq 'register'}
                <center>
                    <script type="text/javascript" src="libs/js/sha1.js"></script>
                    <script type="text/javascript">
    {literal}
                        function do_submit_data () {
                            if (document.form.pass1.value != document.form.pass2.value){
    {/literal}
                                alert('{$lang_register.diff_pass_entered}');
                                return;
    {literal}
                            } else if (document.form.pass1.value.length > 225){
    {/literal}
                                alert('{$lang_register.pass_too_long}');
                                return;
    {literal}
                            } else {
                                document.form.pass.value = hex_sha1(document.form.username.value.toUpperCase()+':'+document.form.pass1.value.toUpperCase());
                                document.form.pass2.value = '0';
                                do_submit();
                            }
                        }
    {/literal}
                        answerbox.btn_ok='{$lang_register.i_agree}';
                        answerbox.btn_cancel='{$lang_register.i_dont_agree}';
                        answerbox.btn_icon='';
                    </script>
                    <fieldset class="half_frame">
                        <legend>{$lang_register.create_acc}</legend>
                        <form method="post" action="index.php?page=register&action=doregister" name="form">
                            <input type="hidden" name="pass" value="" maxlength="256" />
                            <table class="flat">
                                <tr>
                                    <td valign="top">{$lang_register.username}:</td>
                                    <td>
                                        <input type="text" name="username" size="45" maxlength="14" /><br />
                                        {$lang_register.use_eng_chars_limited_len}<br />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">{$lang_register.password}:</td>
                                    <td><input type="password" name="pass1" size="45" maxlength="25" /></td>
                                </tr>
                                <tr>
                                    <td valign="top">{$lang_register.confirm_password}:</td>
                                    <td>
                                        <input type="password" name="pass2" size="45"  maxlength="25" /><br />
                                        {$lang_register.min_pass_len}
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">{$lang_register.email}:</td>
                                    <td>
                                        <input type="text" name="email" size="45" maxlength="225" /><br />
                                        {$lang_register.use_valid_mail}</td>
                                </tr>
    {if $enable_captcha}
                                <tr>
                                    <td></td>
                                    <td><img src="libs/captcha/CaptchaSecurityImages.php?width=300&height=80&characters=6" /><br /><br /></td>
                                </tr>
                                <tr>
                                    <td valign="top">{$lang_captcha.security_code}:</td>
                                    <td>
                                        <input type="text" name="security_code" size="45" /><br />
                                    </td>
                                </tr>
    {/if}
    {if $expansion_select}
                                <tr>
                                    <td valign="top">{$lang_register.acc_type}:</td>
                                    <td>
                                        <select name="expansion">
                                            <option value="2">{$lang_register.wotlk}</option>
                                            <option value="1">{$lang_register.tbc}</option>
                                            <option value="0">{$lang_register.classic}</option>
                                        </select>
                                        - {$lang_register.acc_type_desc}
                                    </td>
                                </tr>
    {/if}
                            </table>
                            <table class="flat">
                                <tr>
                                    <td colspan="2"><hr /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">{$lang_register.read_terms}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><hr /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <textarea rows="18" cols="80" readonly="readonly">{$textarea_data}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <table class="flat">
                                <tr>
                                    <td>
                                        {include file='button.tpl' btext=$lang_register.create_acc_button blink='javascript:answerBox(\''|cat:$lang_register.terms|cat:'<br />'|cat:$textarea_data|cat:'\', \'javascript:do_submit_data()\')' bwidth=150}
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_global.back blink='index.php?page=login' bwidth=130}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <br /><br />
                </center>
{elseif $action eq 'recovery'}
                <center>
                    <fieldset class="half_frame">
                        <legend>{$lang_register.recover_acc_password}</legend>
                        <form method="post" action="index.php?page=register&action=do_pass_recovery" name="form">
                            <table class="flat">
                                <tr>
                                    <td valign="top">{$lang_register.username} :</td>
                                    <td>
                                        <input type="text" name="username" size="45" maxlength="14" /><br />
                                        {$lang_register.user_pass_rec_desc}<br />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">{$lang_register.email} :</td>
                                    <td>
                                        <input type="text" name="email" size="45" maxlength="225" /><br />
                                        {$lang_register.mail_pass_rec_desc}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {include file='button.tpl' btext=$lang_register.recover_pass blink='javascript:do_submit()' bwidth=150}
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()' bwidth=328}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <br /><br />
                </center>
{elseif $action eq 'verify'}
                <div class=\"top\">
                <center>
                    <b><u>{$lang_verify.verify_success}</u></b><br /><br />
                    <table class=\"hidden\">
                        <tr>
                            <td>
                                {include file='button.tpl' btext=$lang_global.home blink='index.php?page=login' bwidth=130}
                            </td>
                        </tr>
                    </table>
                </center>
{/if}