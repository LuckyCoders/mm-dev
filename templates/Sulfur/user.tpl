                <script type="text/javascript" src="libs/js/check.js"></script>
                <center>
                    <table class="top_hidden">
                        <tr>
                            <td>
{if $hasInsertPermission}
                                {include file='button.tpl' btext=$lang_user.add_acc blink='index.php?page=user&action=add_new' bwidth=130}
{/if}
                                {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()' bwidth=130}
{if $search_by && $search_value}
                                {include file='button.tpl' btext=$lang_user.user_list blink='index.php?page=user' bwidth=130}
{/if}
                            </td>
                            <td align="right" width="25%" rowspan="2">
                                {$lang_user.tot_acc}&nbsp;:&nbsp;{$all_record}<br /><br />
                            </td>
                        </tr>
                        <tr align="left">
                            <td>
                                <table class="hidden">
                                    <tr>
                                        <td>
                                            <form action="index.php" method="get" name="form">
                                                <input type="hidden" name="error" value="3" />
                                                <input type="hidden" name="page" value="user" />
                                                <input type="text" size="24" maxlength="50" name="search_value" value="{$search_value}" />
                                                <select name="search_by">
                                                    <option value="username" {if $search_by eq 'username'}selected="selected"{/if}>{$lang_user.by_name}</option>
                                                    <option value="id" {if $search_by eq 'id'}selected="selected"{/if}>{$lang_user.by_id}</option>
                                                    <option value="gmlevel" {if $search_by eq 'gmlevel'}selected="selected"{/if}>{$lang_user.by_gm_level}</option>
                                                    <option value="greater_gmlevel" {if $search_by eq 'greater_gmlevel'}selected="selected"{/if}>{$lang_user.greater_gm_level}</option>
                                                    <option value="expansion" {if $search_by eq 'expansion'}selected="selected"{/if}>{$lang_user.by_expansion}</option>
                                                    <option value="email" {if $search_by eq 'email'}selected="selected"{/if}>{$lang_user.by_email}</option>
                                                    <option value="joindate" {if $search_by eq 'joindate'}selected="selected"{/if}>{$lang_user.by_join_date}</option>
                                                    <option value="last_ip" {if $search_by eq 'last_ip'}selected="selected"{/if}>{$lang_user.by_ip}</option>
                                                    <option value="failed_logins" {if $search_by eq 'failed_logins'}selected="selected"{/if}>{$lang_user.by_failed_loggins}</option>
                                                    <option value="last_login" {if $search_by eq 'last_login'}selected="selected"{/if}>{$lang_user.by_last_login}</option>
                                                    <option value="online" {if $search_by eq 'online'}selected="selected"{/if}>{$lang_user.by_online}</option>
                                                    <option value="locked" {if $search_by eq 'locked'}selected="selected"{/if}>{$lang_user.by_locked}</option>
                                                    <option value="banned" {if $search_by eq 'banned'}selected="selected"{/if}>{$lang_user.by_banned}</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            {include file='button.tpl' btext=$lang_global.search blink='javascript:do_submit()' bwidth=80}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <form method="get" action="index.php" name="form1">
                        <input type="hidden" name="action" value="del_user" />
                        <input type="hidden" name="page" value="user" />
                        <input type="hidden" name="start" value="{$start}" />
                        <input type="hidden" name="backup_op" value="0"/>
                        <table class="lined">
                            <tr>
{if $hasInsertPermission}
                                <th width="1%">
                                    <input name="allbox" type="checkbox" value="Check All" onclick="CheckAll(document.form1);" />
                                </th>
{else}
                                <th width="1%"></th>
{/if}
                                <th width="1%"><a href="index.php?page=user&order_by=id&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'id'}class="{$order_dir}"{/if}>{$lang_user.id}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=username&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'username'}class="{$order_dir}"{/if}>{$lang_user.username}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=gmlevel&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'gmlevel'}class="{$order_dir}"{/if}>{$lang_user.gm_level}</a></th>
{if $expansion_select}
                                <th width="1%"><a href="index.php?page=user&order_by=expansion&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'expansion'}class="{$order_dir}{/if}>EXP</a></th>
{/if}
                                <th width="1%"><a href="index.php?page=user&order_by=email&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'email'}class="{$order_dir}"{/if}>{$lang_user.email}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=joindate&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'joindate'}class="{$order_dir}"{/if}>{$lang_user.join_date}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=last_ip&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'last_ip'}class="{$order_dir}"{/if}>{$lang_user.ip}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=failed_logins&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'failed_logins'}class="{$order_dir}"{/if}>{$lang_user.failed_logins}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=locked&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'locked'}class="{$order_dir}"{/if}>{$lang_user.locked}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=last_login&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'last_login'}class="{$order_dir}"{/if}>{$lang_user.last_login}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=online&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'online'}class="{$order_dir}"{/if}>{$lang_user.online}</a></th>
{if $showcountryflag}
                                <th width="1%">{$lang_global.country}</th>
{/if}
                            </tr>
{foreach from=$data_array item=data}
    {if $hasEditPermission}
                            <tr>
        {if $hasInsertPermission}
                                <td><input type="checkbox" name="check[]" value="'.$data['id'].'" onclick="CheckCheckAll(document.form1);" /></td>
        {else}
                                <td></td>
        {/if}
                                    <td>{$data.id}</td>
                                <td>
                                    <a href="index.php?page=user&amp;action=edit_user&amp;error=11&amp;id={$data.id}">{$data.username}</a>
                                </td>
                                <td>{$data.gm_level_name}</td>
        {if $expansion_select}
                                <td>{$data.exp_lvl}</td>
        {/if}
        {if $hasUpdatePermission && $user_name eq $data.username}
                                <td><a href="mailto:{$data.email}">{$data.email_short}</a></td>
                                <td class="small">{$data.joindate}</td>
                                <td>{$data.last_ip}</td>
        {else}
                                <td>***@***.***</td>
                                <td class="small">{$data.joindate}</td>
                                <td>*******</td>
        {/if}
                                <td>{if $data.failed_logins}$data.failed_logins{else}-{/if}</td>
                                <td>{if $data.locked}{$lang_global.yes_low}{else}-{/if}</td>
                                <td class="small">{$data.last_login}</td>
                                <td>{if $data.online}<img src="img/up.gif" alt="" />{else}-{/if}</td>'
        {if $showcountryflag}
                                <td>{if $data.country_code}<img src="img/flags/{$data.country_code}.png" onmousemove="toolTip('{$data.country}', 'item_tooltip')" onmouseout="toolTip()" alt="" />{else}-{/if}</td>
        {/if}
                            </tr>
    {else}
                            <tr>
                                <td>*</td><td>***</td><td>You</td><td>Have</td><td>No</td>
                                <td class=\"small\">Permission</td><td>to</td><td>View</td><td>this</td><td>Data</td><td>***</td>
        {if $expansion_select}
                                <td>*</td>
        {/if}
        {if $showcountryflag}
                                <td>*</td>
        {/if}
                            </tr>
    {/if}
{/foreach}
                            <tr>
                                <td colspan="{$colspan_special}" class="hidden" align="right" width="25%">
                                    {$pagination}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" align="left" class="hidden">
{if $hasDeletePermission}
                                    {include file='button.tpl' btext=$lang_user.del_selected_users blink='javascript:do_submit(\'form1\',0)" type="wrn' bwidth=230}
{/if}
                                </td>
                                <td colspan="{$colspan_special2}" align="right" class="hidden">{$lang_user.tot_acc} : {$all_record}</td>
                            </tr>
                        </table>
                    </form>
                    <br />
                </center>
                            