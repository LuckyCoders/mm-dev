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
        </center