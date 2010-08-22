                <center>
{if $msg} {* If $msg is set, we are editing an motd *}
                    <form action="index.php?page=motd&action=do_edit_motd" method="post" name="form">
                        <input type="hidden" name="id" value="{$id}" />
{else}
                    <form action="index.php?page=motd&action=do_add_motd" method="post" name="form">
{/if}
                        <table class="top_hidden">
                            <tr>
                                <td colspan="3">
                                    {$editor}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
{if $msg}
                                    <textarea id="msg" name="msg" rows="26" cols="97">{$msg}</textarea>
{else}
                                    <textarea id="msg" name="msg" rows="26" cols="97"></textarea>
{/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{$lang_motd.post_rules}</td>
                                <td>
                                    {include file='button.tpl' btext=$lang_motd.post_motd blink='javascript:do_submit()" type="wrn' bwidth=230}
                                </td>
                                <td>
                                    {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                                </td>
                            </tr>
                        </table>
                    </form>
                <br />
                </center>