                <div class="top">
{if $online}
                    <div id="uptime">
                        <h1>
                            <font color="#55aa55">{$staticUptime}<br />{$lang_index.maxplayers}: {$maxplayers}</font>
                        </h1>
                    </div>
{else}
                    <h1>
                        <font class="error">{$lang_index.realm} <em>{$realmname}</em> {$lang_index.offline_or_let_high}</font>
                    </h1>
{/if}
                    {$lang_index.trinity_rev} {$version.core_revision} {$lang_index.using_db} {$version.db_version}
                </div>
{if $hasDeletePermission}
                <script type="text/javascript">
                    // <![CDATA[
                        answerbox.btn_ok="{$lang_global.yes_low}";
                        answerbox.btn_cancel="{$lang_global.no}";
                        var del_motd = "index.php?page=motd&amp;action=delete_motd&amp;id=";
                    // ]]>
                </script>
{/if}
                <center>
                    <table class="lined">
                        <tr>
                            <th align="right">
{if $hasInsertPermission}
                                <a href="motd.php?action=add_motd">{$lang_index.add_motd}</a>
{/if}
                            </th>
                        </tr>
{if $motdnum > 0}
    {foreach item=item from=$motds}
                    <tr>
                            <td align="left" class="large">
                                <blockquote>{$item.content}</blockquote>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                {$item.type}
        {if $hasDeletePermission}
                                <img src="img/cross.png" width="12" height="12" onclick="answerBox(\'{$lang_global.delete}: &lt;font color=white&gt;{$item.id}&lt;/font&gt;&lt;br /&gt;{$lang_global.are_you_sure}\', del_motd + {$item.id});" style="cursor:pointer;" alt="" />
        {/if}
        {if $hasUpdatePermission}
                                <a href="index.php?page=motd&amp;action=edit_motd&amp;error=3&amp;id={$item.id}">
                                    <img src="img/edit.png" width="14" height="14" alt="" />
                                </a>
        {/if}
                            </td>
                        </tr>
                        <tr>
                            <td class="hidden"></td>
                        </tr>
    {/foreach}
{/if}
{if $online}
                        <tr>
                            <td align="right" class="hidden">{$pagination_motd_on}</td>
                        </tr>
{else}
                        <tr>
                            <td align="right" class="hidden">{$pagination_motd_off}</td>
                        </tr>
{/if}
                    </table>
                    <font class="bold">{$lang_index.tot_users_online}: {$total_online}</font>
                    <table class="lined">
                        <tr>
                            <td colspan="{$countryflag_colspan}" align="right" class="hidden" width="25%">
                                {$pagination_char1}
                            </td>
                        </tr>
                        <tr>
                            <th width="15%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=name&amp;dir={$dir}" {if $order_by==="name"} class="{$order_dir}"{/if}>{$lang_index.name}</a></th>
                            <th width="1%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=race&amp;dir={$dir}" {if $order_by==="race"} class="{$order_dir}"{/if}>{$lang_index.race}</a></th>
                            <th width="1%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=class&amp;dir={$dir}" {if $order_by==="class"} class="{$order_dir}"{/if}>{$lang_index.class}</a></th>
                            <th width="5%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=level&amp;dir={$dir}" {if $order_by==="level"} class="{$order_dir}"{/if}>{$lang_index.level}</a></th>
                            <th width="1%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=totalHonorPoints&amp;dir={$dir}" {if $order_by==="totalHonorPoints"} class="{$order_dir}"{/if}>{$lang_index.rank}</a></th>
                            <th width="15%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=guildid&amp;dir={$dir}" {if $order_by==="guildid"} class="{$order_dir}"{/if}>{$lang_index.guild}</a></th>
                            <th width="20%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=map&amp;dir={$dir}" {if $order_by===$order_dir_mapzone} class="{$order_dir}"{/if}>{$lang_index.map}</a></th>
                            <th width="25%"><a href="index.php?start={$start}&amp;start_m={$start_m}&amp;order_by=zone&amp;dir={$dir}" {if $order_by===$order_dir_zonemap} class="{$order_dir}"{/if}>{$lang_index.zone}</a></th>
{if $showCountry}
                            <th width="1%">{$lang_global.country}</th>
{/if}
                        </tr>
{if $charsnum > 0}
    {foreach item=char from=$chars}
                            <tr>
                                <td>
        {if $isGameMaster}
                                    <a href="index.php?page=char&amp;id={$char.guid}">
                                        <span onmousemove="toolTip(\'{$char.gmlevel_name}\', \'item_tooltip\')" onmouseout="toolTip()">{$char.charname}</span>
                                    </a>
        {else}
                                    <span onmousemove="toolTip(\'{$char.gmlevel_name}\', \'item_tooltip\')" onmouseout="toolTip()">{$char.charname}</span>
        {/if}
                                </td>
                                <td>
                                    <img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip(\'{$char.racename}\', \'item_tooltip\')" onmouseout="toolTip()" alt="" />
                                </td>
                                <td>
                                    <img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip(\'{$char.classname}\', \'item_tooltip\')" onmouseout="toolTip()" alt="" />
                                </td>
                                <td>{$char.levelcolor}</td>
                                <td>
                                    <span onmouseover="toolTip(\'{$char.pvprankname}\', \'item_tooltip\')" onmouseout="toolTip()" style="color: white;"><img src="img/ranks/rank{$char.pvprank}.gif" alt="" /></span>
                                </td>
                                <td>
                                    <a href="guild.php?action=view_guild&amp;error=3&amp;id={$char.guildid}">{$char.guildname}</a>
                                </td>
                                <td><span onmousemove="toolTip(\'MapID:{$char.map}\', \'item_tooltip\')" onmouseout="toolTip()">{$char.mapname}</span></td>
                                <td><span onmousemove="toolTip(\'ZoneID:{$char.zone}\', \'item_tooltip\')" onmouseout="toolTip()">{$char.zonename}</span></td>
    {if $showCountry}
                                <td>{$char.country}</td>
    {/if}
                            </tr>
    {/foreach}
{/if}
                        <tr>
                            <td colspan="{$countryflag_colspan}" align="right" class="hidden" width="25%">
                                {$paginaton_char2}
                            </td>
                        </tr>
                    </table>
                    <br />
                </center>