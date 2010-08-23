                <script type="text/javascript">
                    answerbox.btn_ok='{$lang_global.yes_low}';
                    answerbox.btn_cancel='{$lang_global.no}';
                </script>
                <center>
                    <fieldset style="width: 776px;">
                        <legend><img src="img/alliance.gif" alt="" /></legend>
                        <table class="lined" style="width: 705px;">
                            <tr class="bold">
                                <td colspan="11">{$lang_honor.allied} {$lang_honor.browse_honor}</td>
                            </tr>
                            <tr>
                                <th width="30%">{$lang_honor.guid}</th>
                                <th width="7%">{$lang_honor.race}</th>
                                <th width="7%">{$lang_honor.class}</th>
                                <th width="7%">{$lang_honor.level}</th>
                                <th width="5%"><a href="index.php?page=honor&order_by=honor"{if $order_by eq 'honor'} class=DESC{/if}>{$lang_honor.honor}</a></th>
                                <th width="5%"><a href="index.php?page=honor&order_by=honor"{if $order_by eq 'honor'} class=DESC{/if}>{$lang_honor.honor_points}</a></th>
                                <th width="5%"><a href="index.php?page=honor&order_by=kills"{if $order_by eq 'kills'} class=DESC{/if}>Kills</a></th>
                                <th width="5%"><a href="index.php?page=honor&order_by=arena"{if $order_by eq 'arena'} class=DESC{/if}>AP</a></th>
                                <th width="30%">{$lang_honor.guild}</th>
                            </tr>
{foreach from=$char_array_alliance item=char}
                            <tr>
                                <td><a href="char.php?id={$char.id}">{$char.name|escape:'html'}</a></td>
                                <td><img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char.racename}','item_tooltip')" onmouseout="toolTip()"></td>
                                <td><img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char.classname}','item_tooltip')" onmouseout="toolTip()"></td>
                                <td>{$char.levelcolor}</td>
                                <td><span onmouseover="toolTip('{$char.pvprankname}','item_tooltip')" onmouseout="toolTip()" style="color: white;"><img src="img/ranks/rank{$char.pvprankid}.gif"></span></td>
                                <td>{$char.honor}</td>
                                <td>{$char.kills}</td>
                                <td>{$char.arena}</td>
                                <td><a href="guild.php?action=view_guild&amp;error=3&amp;id=$char.guild">{$char.guildname|escape:'html'}</a></td>
                            </tr>
{/foreach}
                        </table>
                        <br />
                    </fieldset>
                    <script type="text/javascript">
                        answerbox.btn_ok='{$lang_global.yes_low}';
                        answerbox.btn_cancel='{$lang_global.no}';
                    </script>
                    <fieldset style="width: 776px;">
                        <legend><img src="img/horde.gif" alt="" /></legend>
                        <table class="lined" style="width: 705px;">
                            <tr class="bold">
                                <td colspan="11">{$lang_honor.horde} {$lang_honor.browse_honor}</td>
                            </tr>
                            <tr>
                                <th width="30%">{$lang_honor.guid}</th>
                                <th width="7%">{$lang_honor.race}</th>
                                <th width="7%">{$lang_honor.class}</th>
                                <th width="7%">{$lang_honor.level}</th>
                                <th width="5%"><a href="index.php?page=honor&order_by=honor"{if $order_by eq 'honor'} class=DESC{/if}>{$lang_honor.honor}</a></th>
                                <th width="5%"><a href="index.php?page=honor&order_by=honor"{if $order_by eq 'honor'} class=DESC{/if}>{$lang_honor.honor_points}</a></th>
                                <th width="5%"><a href="index.php?page=honor&order_by=kills"{if $order_by eq 'kills'} class=DESC{/if}>Kills</a></th>
                                <th width="5%"><a href="index.php?page=honor&order_by=arena"{if $order_by eq 'arena'} class=DESC{/if}>AP</a></th>
                                <th width="30%">{$lang_honor.guild}</th>
                            </tr>
{foreach from=$char_array_horde item=char}
                            <tr>
                                <td><a href="char.php?id={$char.id}">{$char.name|escape:'html'}</a></td>
                                <td><img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char.racename}','item_tooltip')" onmouseout="toolTip()"></td>
                                <td><img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char.classname}','item_tooltip')" onmouseout="toolTip()"></td>
                                <td>{$char.levelcolor}</td>
                                <td><span onmouseover="toolTip('{$char.pvprankname}','item_tooltip')" onmouseout="toolTip()" style="color: white;"><img src="img/ranks/rank{$char.pvprankid}.gif"></span></td>
                                <td>{$char.honor}</td>
                                <td>{$char.kills}</td>
                                <td>{$char.arena}</td>
                                <td><a href="guild.php?action=view_guild&amp;error=3&amp;id=$char.guild">{$char.guildname|escape:'html'}</a></td>
                            </tr>
{/foreach}
                        </table>
                        <br />
                    </fieldset>