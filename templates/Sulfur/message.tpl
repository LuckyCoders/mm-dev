{if $action eq 'show_form'}
                <div class="top"><h1>{$lang_message.main}</h1></div>
                <center>
                    <form action="index.php?page=message&action=send" method="post" name="form">
                        <table class="top_hidden">
                            <tr>
                                <td align="center">
                                    Send :
                                    <select name="type">
                                        <option value="1" selected="selected">{$lang_message.announcement}</option>
                                        <option value="2">{$lang_message.notification}</option>
                                        <option value="3">{$lang_message.both}</option>
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
                                                {include file='button.tpl' btext=$lang_message.send blink='javascript:do_submit()" type="wrn' bwidth=130}
                                            </td>
                                            <td>
                                                {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </form>
                </center>
{elseif $action eq 'show_result'}
                <div class="top"><h1>{$lang_message.message_result}</h1></div>
                <center>
                    <table class="top_hidden" width="400">
                        <tr>
                            <td align="center">
                                <br />{$mess}<br /><br />
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <table align="center" class="hidden">
                                    <tr>
                                        <td>
                                            {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()' bwidth=130}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </center>
{/if}