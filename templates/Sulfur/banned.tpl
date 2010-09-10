{if $action eq 'show_list'}
        <center>
            <table class="top_hidden">
                <tr>
                    <td>
    {if $hasInsertPermission}
                        {include file='button.tpl' btext=$lang_banned.add_to_banned blink='index.php?page=banned&action=add_entry" type="wrn' bwidth=180}
    {/if}
                        {include file='button.tpl' btext=$ban_selection_text blink=$ban_selection_link bwidth=130}
                        {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                    </td>
                    <td align="right">{$ban_pagination}</td>
                </tr>
            </table>
            <script type="text/javascript">
                answerbox.btn_ok='{$lang_global.yes_low}';
                answerbox.btn_cancel='{$lang_global.no}';
                var del_banned = '{$ban_js_delbanned}';
            </script>
            <table class="lined">
                <tr>
                    <th width="5%">{$lang_global.delete_short}</th>
    {foreach item=th_column from=$ban_thcolumn_array}
                    <th width="{$th_column.width}"><a href="{$th_column.link}" {$th_column.class}>{$th_column.text}</a></th>
    {/foreach}
                </tr>
    {foreach item=ban from=$ban_array}
                <tr>
                    <td>
                        <img src="img/aff_cross.png" onclick="answerBox('{$lang_global.delete}: <font color=white>{$ban.accnameout_specialchars}</font><br />{$lang_global.are_you_sure}', del_banned + '{$ban.id}');" style="cursor:pointer;" alt="" />
                    </td>
                    <td>{$ban.accnameout}</td>
                    <td>{$ban.bandate}</td>
                    <td>{$ban.unbandate}</td>
                    <td>{$ban.bannedby}</td>
                    <td>{$ban.banreason}</td>
                </tr>
    {/foreach}
                <tr>
                    <td colspan="6" align="right" class="hidden">{$lang_banned.tot_banned} : {$ban_count}</td>
                </tr>
            </table>
            <br/>
        </center>
{elseif $action eq 'add_entry'}
        <center>
            <fieldset class="half_frame">
                <legend>{$lang_banned.ban_entry}</legend>
                <form method="get" action="index.php" name="form">
                    <input type="hidden" name="action" value="do_add_entry" />
                    <input type="hidden" name="page" value="banned" />
                    <table class="flat">
                        <tr>
                            <td>{$lang_banned.ban_type}</td>
                            <td>
                                <select name="ban_type">
                                    <option value="ip_banned" >{$lang_banned.ip}</option>
                                    <option value="account_banned" >{$lang_banned.account}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>{$lang_banned.entry}</td>
                            <td>
                                <input type="text" name="entry" size="24" maxlength="20" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>{$lang_banned.ban_time}</td>
                            <td>
                                <input type="text" name="bantime" size="24" maxlength="40" value="1" />
                            </td>
                        </tr>
                        <tr>
                            <td>{$lang_banned.banreason}</td>
                            <td>
                                <input type="text" name="banreason" size="24" maxlength="255" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {include file='button.tpl' btext=$lang_banned.ban_entry blink='javascript:do_submit()" type="wrn' bwidth=180}
                            </td>
                            <td>
                                {include file='button.tpl' btext=$lang_global.back blink='index.php?page=banned" type="def' bwidth=130}
                            </td>
                        </tr>
                    </table>
                </form>
            </fieldset>
            <br/><br/>
        </center>
{/if}