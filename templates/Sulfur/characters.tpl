{if $action eq 'browse_chars'}
 <script type="text/javascript" src="libs/js/check.js"></script>
                    <center>
                        <table class="top_hidden">
                            <tr>
                                <td>
                                    {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()' bwidth=130}
    {if $search_by && $search_value}
                                    {include file='button.tpl' btext=$lang_char_list.characters blink='index.php?page=characters" type="def' bwidth=130}
    {/if}
                                </td>
                                <td align="right" width="25%" rowspan="2">
                                    {$pagination}
                                </td>
                            </tr>
                            <tr align="left">
                                <td>
                                    <table class="hidden">
                                        <tr>
                                            <td>
                                                <form action="index.php" method="get" name="form">
                                                    <input type="hidden" name="error" value="3" />
                                                    <input type="hidden" name="page" value="characters" />
                                                    <input type="text" size="24" maxlength="50" name="search_value" value="{$search_value}" />
                                                    {html_options name=search_by options=$search_options selected=$search_by}
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
                    <form method="get" action="index.php?page=characters" name="form1">
                        <input type="hidden" name="action" value="del_char_form" />
                        <input type="hidden" name="start" value="$start" />
                        <table class="lined">
                            <tr>
                                <th width="1%"><input name="allbox" type="checkbox" value="Check All" onclick="CheckAll(document.form1);" /></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=guid&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'guid'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.id}</a></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=name&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'name'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.char_name}</a></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=account&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'account'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.account}</a></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=race&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'race'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.race}</a></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=class&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'class'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.class}</a></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=level&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'level'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.level}</a></th>
                                <th width="10%"><a href="index.php?page=characters&order_by=map&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'map'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.map}</a></th>
                                <th width="10%"><a href="index.php?page=characters&order_by=zone&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'zone'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.zone}</a></th>
                                <th width="10%"><a href="index.php?page=characters&order_by=totalKills&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'totalKills'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}Kills</a></th>
                                <th width="10%"><a href="index.php?page=characters&order_by=gname&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'gname'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.guild}</a></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=logout_time&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'logout_time'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.lastseen}</a></th>
                                <th width="1%"><a href="index.php?page=characters&order_by=online&amp;start={$start}{$linkadd}&amp;dir={$dir}">{if $order_by eq 'online'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_char_list.online}</a></th>
    {if $showcountryflag}
                                <th width="1%">{$lang_global.country}</th>
    {/if}
                            </tr>
    {foreach from=$chars item=char}
        {if $user_lvl >= $char.owner_gmlvl || $char.owner_acc_name == $user_name}
                            <tr>
                                <td>
            {if $hasDeletePermission || $char.owner_acc_name == $user_name}
                                    <input type="checkbox" name="check[]" value="{$char.data.guid}" onclick="CheckCheckAll(document.form1);" />
            {/if}
                                </td>
                                <td>{$char.data.guid}</td>
                                <td><a href="index.php?page=char&id={$char.data.guid}">{$char.data.name|escape:'htmlall'}</a></td>
                                <td><a href="index.php?page=user&action=edit_user&amp;error=11&amp;id={$char.data.account}">{$char.owner_acc_name|escape:'htmlall'}</a></td>
                                <td><img src='img/c_icons/{$char.data.race}-{$char.data.class}.gif' onmousemove='toolTip("{$char.race}","item_tooltip")' onmouseout='toolTip()' alt="" /></td>
                                <td><img src='img/c_icons/{$char.data.class}.gif' onmousemove='toolTip("{$char.class}","item_tooltip")' onmouseout='toolTip()' alt="" /></td>
                                <td>{$char.lvlcolor}</td>
                                <td class="small"><span onmousemove='toolTip("MapID:{$char.data.map}","item_tooltip")' onmouseout='toolTip()'>{$char.map}</span></td>
                                <td class="small"><span onmousemove='toolTip("ZoneID:{$char.data.zone}","item_tooltip")' onmouseout='toolTip()'>{$char.zone}</span></td>
                                <td>{$char.data.totalKills}</td>
                                <td class="small"><a href="index.php?page=guild&action=view_guild&amp;error=3&amp;id={$char.data.gname}">{$char.guild|escape:'htmlall'}</a></td>
                                <td class="small">{$char.lastseen}</td>
                                <td>{if $char.data.online}<img src="img/up.gif" alt="" />{else}<img src="img/down.gif" alt="" />{/if}</td>
            {if $showcountryflag}
                                <td>{if $char.countrycode}<img src="img/flags/{$char.countrycode}.png" onmousemove="toolTip("{$char.country}","item_tooltip")" onmouseout="toolTip()" alt="" />{/if}</td>
            {/if}
                            </tr>
        {else}
                            <tr>
                                <td>*</td>
                                <td>***</td>
                                <td>***</td>
                                <td>You</td>
                                <td>Have</td>
                                <td>No</td>
                                <td class="small">Permission</td>
                                <td>to</td>
                                <td>View</td>
                                <td>this</td>
                                <td>Data</td>
                                <td>***</td>
                                <td>*</td>
            {if $showcountryflag}
                                <td>*</td>
            {/if}
                            </tr>
        {/if}
    {/foreach}
                            <tr>
                                <td colspan="13" align="right" class="hidden" width="25%">
                                    {$pagination}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" align="left" class="hidden">
    {if $hasDeletePermission || $char.owner_acc_name == $user_name}
                                    {include file='button.tpl' btext=$lang_char_list.del_selected_chars blink='javascript:do_submit(\'form1\',0)" type="wrn' bwidth=220}
    {/if}
                                </td>
                                <td colspan="7" align="right" class="hidden">{$lang_char_list.tot_chars} : {$all_record}</td>
                            </tr>
                        </table>
                    </form>
                </center>
{elseif $action eq 'del_char_form'}
                <center>
                    <img src="img/warn_red.gif" width="48" height="48" alt="" />
                    <h1>
                        <font class="error">{$lang_global.are_you_sure}</font>
                    </h1>
                    <br />
                    <font class="bold">{$lang_char_list.char_ids}: 
    {foreach from=$chars item=char}
                        <a href="{$char.link}" target="_blank">{$char.name}, </a>
    {/foreach}
                        <br />{$lang_global.will_be_erased}
                    </font>
                    <br /><br />
                    <table width="300" class="hidden">
                        <tr>
                            <td>
                                {include file='button.tpl' btext=$lang_global.yes blink=$continue_link bwidth=130}
                                {include file='button.tpl' btext=$lang_global.no blink='index.php?page=characters" type="def' bwidth=130}
                            </td>
                        </tr>
                    </table>
                </center>
{elseif $action eq 'dodel_char'}
                <center>
    {if $deleted_chars}
                    <h1>
                        <font class="error">{$lang_char_list.total} <font color=blue>{$deleted_chars}</font> {$lang_char_list.chars_deleted}</font>
                    </h1>
    {else}
                    <h1>
                        <font class="error">{$lang_char_list.no_chars_del}</font>
                    </h1>
    {/if}
                    <br /><br />
                    <table class="hidden">
                        <tr>
                            <td>
                                {include file='button.tpl' btext=$lang_char_list.back_browse_chars blink='index.php?page=characters' bwidth=220}
                            </td>
                        </tr>
                    </table>
                    <br />
                </center>
{elseif $action eq ''}
{elseif $action eq ''}
{/if}