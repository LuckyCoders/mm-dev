                <center>
                    <div id="tab">
                        <ul>
                            <li {if $type eq 'level'}id="selected"{/if}>
                                <a href="index.php?page=top100&start={$start}">{$lang_top.general}</a>
                            </li>
                            <li {if $type eq 'stat'}id="selected"{/if}>
                                <a href="index.php?page=top100&start={$start}&amp;type=stat&amp;order_by=health">{$lang_top.stats}</a>
                            </li>
                            <li {if $type eq 'defense'}id="selected"{/if}>
                                <a href="index.php?page=top100&start={$start}&amp;type=defense&amp;order_by=armor">{$lang_top.defense}</a>
                            </li>
                            <li {if $type eq 'resist'}id="selected"{/if}>
                                <a href="index.php?page=top100&start={$start}&amp;type=resist&amp;order_by=holy">{$lang_top.resist}</a>
                            </li>
                            <li {if $type eq 'pvp'}id="selected"{/if}>
                                <a href="index.php?page=top100&start={$start}&amp;type=pvp&amp;order_by=honor">{$lang_top.pvp}</a>
                            </li>
                        </ul>
                    </div>
                    <div id="tab_content">
                        <table class="top_hidden" style="width: 720px">
                            <tr>
                                <td align="right">Total: {$all_record}</td>
                                <td align="right" width="25%">
                                    {$pagination}
                                </td>
                            </tr>
                        </table>
                        <table class="lined" style="width: 720px">
                            <tr>
                                <th width="5%">#</th>
                                <th width="14%">{$lang_top.name}</th>
                                <th width="11%">{$lang_top.race}&nbsp;{$lang_top.class}</th>
                                <th width="8%"><a href="index.php?page=top100&type={$type}&amp;order_by=level&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'level'}class="{$order_dir}"{/if}>{$lang_top.level}</a></th>
{if $type eq 'level'} 
                                <th width="22%">{$lang_top.guild}</th>
                                <th width="20%"><a href="index.php?page=top100&type={$type}&amp;order_by=money&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'money'}class="{$order_dir}"{/if}>{$lang_top.money}</a></th>
                                <th width="20%"><a href="index.php?page=top100&type={$type}&amp;order_by=totaltime&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'totaltime'}class="{$order_dir}"{/if}>{$lang_top.time_played}</a></th>
{elseif $type eq 'stat'}
                                <th width="11%"><a href="index.php?page=top100&type={$type}&amp;order_by=health&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'health'}class="{$order_dir}"{/if}>{$lang_top.health}</a></th>
                                <th width="10%"><a href="index.php?page=top100&type={$type}&amp;order_by=mana&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'mana'}class="{$order_dir}"{/if}>{$lang_top.mana}</a></th>
                                <th width="9%"><a href="index.php?page=top100&type={$type}&amp;order_by=str&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'str'}class="{$order_dir}"{/if}>{$lang_top.str}</a></th>
                                <th width="8%"><a href="index.php?page=top100&type={$type}&amp;order_by=agi&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'agi'}class="{$order_dir}"{/if}>{$lang_top.agi}</a></th>
                                <th width="8%"><a href="index.php?page=top100&type={$type}&amp;order_by=sta&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'sta'}class="{$order_dir}"{/if}>{$lang_top.sta}</a></th>
                                <th width="8%"><a href="index.php?page=top100&type={$type}&amp;order_by=intel&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'intel'}class="{$order_dir}"{/if}>{$lang_top.intel}</a></th>
                                <th width="8%"><a href="index.php?page=top100&type={$type}&amp;order_by=spi&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'spi'}class="{$order_dir}"{/if}>{$lang_top.spi}</a></th>
{elseif $type eq 'defense'}
                                <th width="16%"><a href="index.php?page=top100&type={$type}&amp;order_by=armor&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'armor'}class="{$order_dir}"{/if}>{$lang_top.armor}</a></th>
                                <th width="16%"><a href="index.php?page=top100&type={$type}&amp;order_by=block&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'block'}class="{$order_dir}"{/if}>{$lang_top.block}</a></th>
                                <th width="15%"><a href="index.php?page=top100&type={$type}&amp;order_by=dodge&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'dodge'}class="{$order_dir}"{/if}>{$lang_top.dodge}</a></th>
                                <th width="15%"><a href="index.php?page=top100&type={$type}&amp;order_by=parry&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'parry'}class="{$order_dir}"{/if}>{$lang_top.parry}</a></th>
{elseif $type eq 'resist'}
                                <th width="10%"><a href="index.php?page=top100&type={$type}&amp;order_by=holy&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'holy'}class="{$order_dir}"{/if}>{$lang_top.holy}</a></th>
                                <th width="10%"><a href="index.php?page=top100&type={$type}&amp;order_by=fire&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'fire'}class="{$order_dir}"{/if}>{$lang_top.fire}</a></th>
                                <th width="10%"><a href="index.php?page=top100&type={$type}&amp;order_by=nature&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'nature'}class="{$order_dir}"{/if}>{$lang_top.nature}</a></th>
                                <th width="10%"><a href="index.php?page=top100&type={$type}&amp;order_by=frost&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'frost'}class="{$order_dir}"{/if}>{$lang_top.frost}</a></th>
                                <th width="11%"><a href="index.php?page=top100&type={$type}&amp;order_by=shadow&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'shadow'}class="{$order_dir}"{/if}>{$lang_top.shadow}</a></th>
                                <th width="11%"><a href="index.php?page=top100&type={$type}&amp;order_by=arcane&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'arcane'}class="{$order_dir}"{/if}>{$lang_top.arcane}</a></th>
{elseif $type eq 'pvp'}
                                <th width="20%"><a href="index.php?page=top100&type={$type}&amp;order_by=honor&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'honor'}class="{$order_dir}"{/if}>{$lang_top.rank}</a></th>
                                <th width="14%">{$lang_top.honor_points}</th>
                                <th width="14%"><a href="index.php?page=top100&type={$type}&amp;order_by=kills&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'kills'}class="{$order_dir}"{/if}>{$lang_top.kills}</a></th>
                                <th width="14%"><a href="index.php?page=top100&type={$type}&amp;order_by=arena&amp;start={$start}&amp;dir={$dir}" {if $order_by eq 'arena'}class="{$order_dir}"{/if}>{$lang_top.arena_points}</a></th>
{/if}
                            </tr>
{foreach from=$char_array item=char}
                            <tr valign="top">
                                <td>{$char.num}</td>
                                <td><a href="index.php?page=char&id={$char.guid}&amp;realm={$realm_id}">{$char.name|escape:'html'}</a></td>
                                <td>
                                    <img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char.racename}','item_tooltip')" onmouseout="toolTip()">
                                    <img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char.classname}','item_tooltip')" onmouseout="toolTip()">
                                </td>
                                <td>{$char.levelcolor}</td>
    {if $type eq 'level'}
                                <td><a href="index.php?page=guild&action=view_guild&amp;realm={$realm_id}&amp;error=3&amp;id={$char.gname}">{$char.guild_name|escape:'html'}</a></td>
                                <td align="right">
                                    {$char.money_gold}<img src="img/gold.gif" alt="" align="middle" />
                                    {$char.money_silver}<img src="img/silver.gif" alt="" align="middle" />
                                    {$char.money_copper}<img src="img/copper.gif" alt="" align="middle" />
                                </td>
                                <td align="right">{$char.time}</td>
    {elseif $type eq 'stat'}
                                <td>{$char.health}</td>
                                <td>{$char.mana}</td>
                                <td>{$char.str}</td>
                                <td>{$char.agi}</td>
                                <td>{$char.sta}</td>
                                <td>{$char.intel}</td>
                                <td>{$char.spi}</td>
    {elseif $type eq 'defense'}
                                <td>{$char.armor}</td>
                                <td>{$char.block_p}%</td>
                                <td>{$char.dodge_p}%</td>
                                <td>{$char.parry_p}%</td>
    {elseif $type eq 'resist'}
                                <td>{$char.holy}</td>
                                <td>{$char.fire}</td>
                                <td>{$char.nature}</td>
                                <td>{$char.frost}</td>
                                <td>{$char.shadow}</td>
                                <td>{$char.arcane}</td>
    {elseif $type eq 'pvp'}
                                <td align="left"><img src="img/ranks/rank{$char.pvprankid}.gif" alt=""></img> {$char.pvprankname}</td>
                                <td>{$char.honor}</td>
                                <td>{$char.kills}</td>
                                <td>{$char.arena}</td>
    {/if}
                            </tr>
{/foreach}
                        </table>
                        <table class="top_hidden" style="width: 720px">
                            <tr>
                                <td align="right">Total: {$all_record}</td>
                                <td align="right" width="25%">
                                    {$pagination}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br />
                </center>