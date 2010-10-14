{if $action eq 'browse'}
                <script type="text/javascript" src="libs/js/check.js"></script>
                <center>
                    <table class="top_hidden">
                        <tr>
                            <td width="25%" align="right">
                                {$pagination}
                            </td>
                        </tr>
                    </table>
                <form method="get" action="index.php" name="form">
                    <input type="hidden" name="page" value="ticket" />
                    <input type="hidden" name="action" value="delete_tickets" />
                    <input type="hidden" name="start" value="{$start}" />
                    <table class="lined">
                        <tr>
    {if $hasDeletePermission}
                            <th width="5%"><input name="allbox" type="checkbox" value="Check All" onclick="CheckAll(document.form);" /></th>
    {/if}
    {if $hasUpdatePermission}
                            <th width="6%">{$lang_global.edit}</th>
    {/if}
                            <th width="7%"><a href="index.php?page=ticket&order_by=guid&amp;start={$start}&amp;dir={$dir}">{if $order_by eq 'guid'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_ticket.id}</a></th>
                            <th width="10%"><a href="index.php?page=ticket&order_by=online&amp;start={$start}&amp;dir={$dir}">{if $order_by eq 'online'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}Online?</a></th>
                            <th width="12%"><a href="index.php?page=ticket&order_by=playerGuid&amp;start={$start}&amp;dir={$dir}">{if $order_by eq 'playerGuid'}<img src="img/arr_{if $dir}up{else}dw{/if}.gif" alt="" />{/if}{$lang_ticket.sender}</a></th>
                            <th width="20%">Timestamp</th>
                            <th width="30%">{$lang_ticket.ticket_text}</th>
                        </tr>
    {foreach item=ticket from=$ticket_array}
                            <tr>
        {if $hasDeletePermission}
                                <td><input type="checkbox" name="check[]" value="{$ticket.guid}" onclick="CheckCheckAll(document.form);" /></td>
        {/if}
        {if $hasUpdatePermission}
                                <td><a href="index.php?page=ticket&action=edit_ticket&amp;error=4&amp;id={$ticket.guid}">{$lang_global.edit}</a></td>
        {/if}
                                <td>{$ticket.guid}</td>
                                <td>{if $ticket.online}<img src="img/up.gif" alt="online">{else}<img src="img/down.gif" alt="offline">{/if}</td>
                                <td><a href="index.php?page=char&id={$ticket.playerGuid}">{$ticket.name|escape:'html'}</a></td>
                                <td>{$ticket.timestamp|date_format:"%d.%m.%Y %H:%M:%S"}</td>
                                <td>{$ticket.message|escape:'html'} ...</td>
                            </tr>
    {/foreach}
                        <tr>
                            <td colspan="5" align="right" class="hidden" width="25%">
                                {$pagination}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="left" class="hidden">
    {if $hasDeletePermission}
                                {include file='button.tpl' btext=$lang_ticket.del_selected_tickets blink='javascript:do_submit()" type="wrn' bwidth=230}
    {/if}
                            </td>
                            <td colspan="2" align="right" class="hidden">{$lang_ticket.tot_tickets}: {$all_record}</td>
                        </tr>
                    </table>
                </form>
                <br />
            </center>
{elseif $action eq 'edit'}
    {if $ticket}
                <center>
                    <fieldset style="width: 550px;">
                        <legend>{$lang_ticket.edit_reply}</legend>
                        <form method="post" action="index.php?page=ticket&action=do_edit_ticket" name="form">
                            <input type="hidden" name="id" value="{$id}" />
                            <table class="flat">
                                <tr>
                                    <td>{$lang_ticket.ticket_id}</td>
                                    <td>{$id}</td>
                                </tr>
                                <tr>
                                    <td>{$lang_ticket.submitted_by}:</td>
                                    <td><a href="index.php?page=char&id={$ticket.playerGuid}">{$ticket.name|escape:'html'}</a></td>
                                </tr>
                                <tr>
                                    <td valign="top">{$lang_ticket.ticket_text}</td>
                                    <td><textarea name="new_text" rows="5" cols="40">{$ticket.message|escape:'html'}</textarea></td>
                                </tr>
                                <tr>
                                    <td>
                                        {include file='button.tpl' btext=$lang_ticket.update blink='javascript:do_submit()" type="wrn' bwidth=130}
                                    </td>
                                    <td>
                                    <table class="hidden">
                                        <tr>
                                            <td>
                                                {include file='button.tpl' btext=$lang_ticket.send_ingame_mail blink='index.php?page=mail&type=ingame_mail&amp;to=$ticket.playerGuid' bwidth=130}
                                            </td>
                                            <td>
                                                {include file='button.tpl' btext=$lang_global.back blink='index.php?page=ticket" type="def' bwidth=130}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <br /><br />
                </center>
    {/if}

{/if}