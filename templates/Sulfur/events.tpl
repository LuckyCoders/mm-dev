                <center>
                    <table class="top_hidden">
                        <tr>
                            <td width="25%" align="right">
                                {$lang_events.total} : {$all_record}
                                <br /><br />
                                {$pagination}
                            </td>
                        </tr>
                    </table>
                    <table class="lined">
                        <tr>
                            <th width="35%"><a href="index.php?page=events&order_by=description&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'description'}class="{$order_dir}"{/if}>{$lang_events.descr}</a></th>
                            <th width="25%"><a href="index.php?page=events&order_by=start_time&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'start_time'}class="{$order_dir}"{/if}>{$lang_events.start}</a></th>
                            <th width="20%"><a href="index.php?page=events&order_by=occurence&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'occurence'}class="{$order_dir}"{/if}>{$lang_events.occur}</a></th>
                            <th width="20%"><a href="index.php?page=events&order_by=length&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'length'}class="{$order_dir}"{/if}>{$lang_events.length}</a></th>
                        </tr>
{foreach from=$event_data item=event}
                        <tr valign="top">
                            <td align="left">{$event.description}</td>
                            <td>{$event.start_time}</td>
                            <td>{$event.occurance}</td>
                            <td>{$event.duration}</td>
                        </tr>
{/foreach}
                        <tr>
                            <td colspan="4" class="hidden" align="right" width="25%">
                                {$pagination}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="hidden" align="right">{$lang_events.total} : {$all_record}</td>
                        </tr>
                    </table>
                </center>