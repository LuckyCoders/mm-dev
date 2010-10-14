                <center>
                    <table class="top_hidden">
                        <tr>
                            <td width="25%" align="right">
                                {$lang_instances.total} : {$all_record}
                                <br /><br />
                                {$pagination}
                            </td>
                        </tr>
                    </table>
                    <table class="lined">
                        <tr>
                            <th width="40%"><a href="index.php?page=instances&order_by=map&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'map'}class="{$order_dir}"{/if}>{$lang_instances.map}</a></th>
                            <th width="30%"><a href="index.php?page=instances&order_by=level_min&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'level_min'}class="{$order_dir}"{/if}>{$lang_instances.level_min}</a></th>
                            <th width="30%"><a href="index.php?page=instances&order_by=level_max&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'level_max'}class="{$order_dir}"{/if}>{$lang_instances.level_max}</a></th>
                        </tr>
{foreach from=$instance_data item=instance}
                        <tr valign="top">
                            <td>{$instance.mapname}&nbsp;{$instance.map}</td>
                            <td>{$instance.level_min}</td>
                            <td>{$instance.level_max}</td>
                        </tr>
{/foreach}
                        <tr>
                            <td colspan="3" class="hidden" align="right" width="25%">
                                {$pagination}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="hidden" align="right">{$lang_instances.total} : {$all_record}</td>
                        </tr>
                    </table>
                </center>