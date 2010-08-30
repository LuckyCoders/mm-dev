{if $action eq 'do_delete'}
                <center>
    {if $deleted_accs > 0}
                    <h1><font class="error">{$lang_user.total} <font color="blue">{$deleted_accs}</font> {$lang_user.acc_deleted}</font><br /></h1>
                    <h1><font class="error">{$lang_user.total} <font color="blue">{$deleted_chars}</font> {$lang_user.char_deleted}</font></h1>
    {else}
                    <h1><font class="error">{$lang_user.no_acc_deleted}</font></h1>
    {/if}
                    <br /><br />
                    <table class="hidden">
                        <tr>
                            <td>
                                {include file='button.tpl' btext=$lang_user.back_browsing blink='index.php?page=user' bwidth=230}
                            </td>
                        </tr>
                    </table>
                    <br />
                </center>
{else}
                <center>
                    <img src="img/warn_red.gif" width="48" height="48" alt="" />
                    <h1><font class="error">{$lang_global.are_you_sure}</font></h1>
                    <br />
                    <font class="bold">{$lang_user.acc_ids}: 
    {foreach from=$user_del_array item=user}
                        <a href="user.php?action=edit_user&amp;id={$user.id}" target="_blank">{$user.username}, </a>
    {/foreach}
                        <br />{$lang_global.will_be_erased}</font>
                        <br /><br />
                        <table width="300" class="hidden">
                            <tr>
                                <td>
                                    {include file='button.tpl' btext=$lang_global.yes blink=$do_del_link bwidth=130}
                                    {include file='button.tpl' btext=$lang_global.no blink='index.php?page=user" type="def' bwidth=130}
                                </td>
                            </tr>
                        </table>
                        <br />
                    </font>
                </center>
{/if}