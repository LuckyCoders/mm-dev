{if $action eq 'char_main'}
    {if $hasHigherGMLevel}
                <center>
                    <div id="tab_content">
                        <h1>{$lang_char.char_sheet}</h1><br />
                        <div id="tab">
                            <ul>
                                <li><a href="index.php?page=char&id={$id}&amp;realm={$realmid}">{$lang_char.char_sheet}</a></li>
                                <li><a href="index.php?page=char&action=inv&id={$id}&amp;realm={$realmid}">{$lang_char.inventory}</a></li>
                                <li><a href="index.php?page=char&action=extra&id={$id}&amp;realm={$realmid}">{$lang_char.extra}</a></li>
                                {if $char.level >= 10}<li><a href="index.php?page=char&action=talent&id={$id}&amp;realm={$realmid}">{$lang_char.talents}</a></li>{/if}
                                <li><a href="index.php?page=char&action=achieve&id={$id}&amp;realm={$realmid}">{$lang_char.achievements}</a></li>
                                <li><a href="index.php?page=char&action=rep&id={$id}&amp;realm={$realmid}">{$lang_char.reputation}</a></li>
                                <li><a href="index.php?page=char&action=skill&id={$id}&amp;realm={$realmid}">{$lang_char.skills}</a></li>
                                <li><a href="index.php?page=char&action=quest&id={$id}&amp;realm={$realmid}">{$lang_char.quests}</a></li>
        {if $char.class eq 3}
                                <li><a href="index.php?page=char&action=pets&id={$id}&amp;realm={$realmid}">{$lang_char.pets}</a></li>
        {/if}
                                <li><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}">{$lang_char.friends}</a></li>
                                <li><a href="index.php?page=char&action=spell&id={$id}&amp;realm={$realmid}">{$lang_char.spells}</a></li>
                                <li><a href="index.php?page=char&action=mail&id={$id}&amp;realm={$realmid}">{$lang_char.mail}</a></li>
    {else}
                <center>
                    <div id="tab_content">
                        <h1>{$lang_char.char_sheet}</h1><br />
                        <div id="tab">
                            <ul>
                                <li><a href="index.php?page=char&id={$id}&amp;realm={$realmid}">{$lang_char.char_sheet}</a></li>
    {/if}
                            </ul>
                        </div>
                        <div id="tab_content2">
                            <table class="lined" style="width: 580px;">
                                <tr>
                                    <td colspan="2">
                                        <div>
                                            <img src="{$char_avatar_img}" alt="avatar" />
                                        </div>
                                        <div>
    {foreach from=$char_auras item=char_aura}
                                            <a style="padding:2px;" href="{$char_aura.link}" target="_blank">
                                                <img src="{$char_aura.icon}" alt="{$char_aura.spell}" width="24" height="24" />
                                            </a>
    {/foreach}
                                        </div>
                                    </td>
                                    <td colspan="4">
                                        <font class="bold">
                                            {$char.name|escape:'html'} -
                                            <img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char_additional.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                            <img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char_additional.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                            - lvl {$char_additional.lvlcolor}
                                        </font>
                                        <br />{$char_additional.mapname} - {$char_additional.zonename}
                                        <br />{$lang_char.honor_points}: {$char.totalHonorPoints} / {$char.arenaPoints} - {$lang_char.honor_kills}: {$char.totalKills}
                                        <br />{$lang_char.guild}: {$guild_name} | {$lang_char.rank}: {$guild_rank|escape:'html'}
                                        <br />{if $char.online}<img src="img/up.gif" onmousemove="toolTip('Online', 'item_tooltip')" onmouseout="toolTip()" alt="online" />{else}<img src="img/down.gif" onmousemove="toolTip('Offline', 'item_tooltip')" onmouseout="toolTip()" alt="offline" />{/if}
    {if $showcountryflag}                                    
                                        - {if $country.code}<img src="img/flags/{$country.code}.png" onmousemove="toolTip('{$country.country}', 'item_tooltip')" onmouseout="toolTip()" alt="" />{else}-{/if}
    {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="6%">
    {foreach from=$items_array item=item}
        {if $item.type eq 'item'}
                                        <a style="padding:2px;" href="{$item.link}" target="_blank">
                                            <img src="{$item.image}" class="{$item.class}" alt="{$item.alt}" />
                                        </a>
        {elseif $item.type eq 'empty'}
                                        <img src="img/INV/INV_empty_{$item.img}.png" class="icon_border_0" alt="empty" />
        {elseif $item.type eq 'class'}
                                    </td>
                                    <td class="half_line" colspan="2" align="center" width="50%">
                                        <div class="gradient_p">{$lang_item.health}:</div>
                                        <div class="gradient_pp">{$char.maxhealth}</div>
            {if $char.class eq 11} {*//druid*}
                                        </br>
                                        <div class="gradient_p">{$lang_item.energy}:</div>
                                        <div class="gradient_pp">{$char.power4}/{$char.maxpower4}</div>
            {/if}
                                    </td>
                                    <td class="half_line" colspan="2" align="center" width="50%">
            {if $char.class eq 1} {*// warrior*}
                                        <div class="gradient_p">{$lang_item.rage}:</div>
                                        <div class="gradient_pp">{$charstats.rage}/{$charstats.maxrage}</div>
            {/if}
            {if $char.class eq 4} {*// rogue*}
                                        <div class="gradient_p">{$lang_item.energy}:</div>
                                        <div class="gradient_pp">{$char.power4}/{$char.maxpower4}</div>
            {/if}
            {if $char.class eq 6} {*// death knight // Don't know if FOCUS is the right one need to verify with Death Knight player.*}
                                        <div class="gradient_p">{$lang_item.runic}:</div>
                                        <div class="gradient_pp">{$char.power3}/{$char.maxpower3}</div>
            {/if}
            {if $char.class eq 11} {*// druid*}
                                        <div class="gradient_p">{$lang_item.mana}:</div>
                                        <div class="gradient_pp">{$char.maxpower1}</div>
                                        </br>
                                        <div class="gradient_p">{$lang_item.rage}:</div>
                                        <div class="gradient_pp">{$charstats.rage}/{$charstats.maxrage}</div>
            {/if}
            {if $char.class eq 2 ||
                $char.class eq 3 ||
                $char.class eq 5 ||
                $char.class eq 7 ||
                $char.class eq 8 ||
                $char.class eq 9 } {*//paladin (2), hunter (3), priest (5), shaman (7), mage (8), warlock (9)*}
                                        <div class="gradient_p">{$lang_item.mana}:</div>
                                        <div class="gradient_pp">{$char.maxpower1}</div>
            {/if}
                                    </td>
                                    <td width="6%">
        {elseif $item.type eq 'newrow'}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="{$item.width}%">
        {elseif $item.type eq 'newrow2'}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="{$item.width}%">
        {elseif $item.type eq 'end'}
                                    </td>
                                    <td width="{$item.width}%"></td>
                                    <td></td>
                                </tr>
        {elseif $item.type eq 'newfield'}
                                    </td>
                                    <td width="{$item.width}%">
        {elseif $item.type eq 'stats'}
                                    </td>
                                    <td class="half_line" colspan="2" rowspan="3" align="center" width="50%">
                                        <div class="gradient_p">
                                            {$lang_item.strength}:<br />
                                            {$lang_item.agility}:<br />
                                            {$lang_item.stamina}:<br />
                                            {$lang_item.intellect}:<br />
                                            {$lang_item.spirit}:<br />
                                            {$lang_item.armor}:
                                        </div>
                                        <div class="gradient_pp">
                                            {$char.strength}<br />
                                            {$char.agility}<br />
                                            {$char.stamina}<br />
                                            {$char.intellect}<br />
                                            {$char.spirit}<br />
                                            {$char.armor}
                                        </div>
                                    </td>
                                    <td class="half_line" colspan="2" rowspan="3" align="center" width="50%">
                                        <div class="gradient_p">
                                            {$lang_item.res_holy}:<br />
                                            {$lang_item.res_arcane}:<br />
                                            {$lang_item.res_fire}:<br />
                                            {$lang_item.res_nature}:<br />
                                            {$lang_item.res_frost}:<br />
                                            {$lang_item.res_shadow}:
                                        </div>
                                        <div class="gradient_pp">
                                            {$char.resHoly}<br />
                                            {$char.resArcane}<br />
                                            {$char.resFire}<br />
                                            {$char.resNature}<br />
                                            {$char.resFrost}<br />
                                            {$char.resShadow}
                                        </div>
                                    </td>
                                    <td width="1%">
        {elseif $item.type eq 'stats2'}
                                    </td>
                                    <td class="half_line" colspan="2" rowspan="2" align="center" width="50%">
                                        <div class="gradient_p">
                                            {$lang_char.melee_d}:<br />
                                            {$lang_char.melee_ap}:<br />
                                            {$lang_char.melee_hit}:<br />
                                            {$lang_char.melee_crit}:<br />
                                            {$lang_char.expertise}:<br />
                                        </div>
                                        <div class="gradient_pp">
                                            {$charstats.mindamage}-{$charstats.maxdamage}<br />
                                            {$char.attackPower}<br />
                                            {$char_data.CHAR_DATA_OFFSET_MELEE_HIT}<br />
                                            {$charstats.crit}%<br />
                                            {$charstats.expertise}<br />
                                        </div>
                                    </td>
                                    <td class="half_line" colspan="2" rowspan="2" align="center" width="50%">
                                        <div class="gradient_p">
                                            {$lang_char.spell_d}:<br />
                                            {$lang_char.spell_heal}:<br />
                                            {$lang_char.spell_hit}:<br />
                                            {$lang_char.spell_crit}:<br />
                                            {$lang_char.spell_haste}
                                        </div>
                                        <div class="gradient_pp">
                                            {$charstats.spell_damage}<br />
                                            {$char_data.CHAR_DATA_OFFSET_SPELL_HEAL}<br />
                                            {$char_data.CHAR_DATA_OFFSET_SPELL_HIT}<br />
                                            {$charstats.spell_crit}%<br />
                                            {$char_data.CHAR_DATA_OFFSET_SPELL_HASTE_RATING}
                                        </div>
                                    </td>
                                    <td width="1%">
        {elseif $item.type eq 'stats3'}
                                    </td>
                                    <td class="half_line" colspan="2" rowspan="2" align="center" width="50%">
                                        <div class="gradient_p">
                                            {$lang_char.dodge}:<br />
                                            {$lang_char.parry}:<br />
                                            {$lang_char.block}:<br />
                                            {$lang_char.resilience}:<br />
                                        </div>
                                        <div class="gradient_pp">
                                            {$charstats.dodge}%<br />
                                            {$charstats.parry}%<br />
                                            {$charstats.block}%<br />
                                            {$char_data.CHAR_DATA_OFFSET_RESILIENCE}<br />
                                        </div>
                                    </td>
                                    <td class="half_line" colspan="2" rowspan="2" align="center" width="50%">
                                        <div class="gradient_p">
                                            {$lang_char.ranged_d}:<br />
                                            {$lang_char.ranged_ap}:<br />
                                            {$lang_char.ranged_hit}:<br />
                                            {$lang_char.ranged_crit}:<br />
                                        </div>
                                        <div class="gradient_pp">
                                            {$charstats.minrangeddamage}-{$charstats.maxrangeddamage}<br />
                                            {$char.rangedAttackPower}<br />
                                            {$char_data.CHAR_DATA_OFFSET_RANGE_HIT}<br />
                                            {$charstats.ranged_crit}%<br />
                                        </div>
                                    </td>
                                    <td width="1%">
        {/if}
    {/foreach}
    {if $hasHigherGMLevel}
                                <tr>
                                    <td colspan="6">
                                        {$lang_char.tot_paly_time}: {$char_tot_days} {$lang_char.days} {$char_total_hours} {$lang_char.hours} {$char_total_min} {$lang_char.min}
                                    </td>
                                </tr>
    {/if}
                            </table>
                        </div>
                        <br />
                    </div>
                    <br />
                    <br />
                </center>
{elseif $action eq 'char_spell'}
                        <center>
                            <div id="tab_content">
                                <h1>{$lang_char.spells}</h1>
                                <br />
    {* char header! *}
                        <div id="tab">
                            <ul>
                                <li><a href="index.php?page=char&id={$id}&amp;realm={$realmid}">{$lang_char.char_sheet}</a></li>
                                <li><a href="index.php?page=char&action=inv&id={$id}&amp;realm={$realmid}">{$lang_char.inventory}</a></li>
                                <li><a href="index.php?page=char&action=extra&id={$id}&amp;realm={$realmid}">{$lang_char.extra}</a></li>
                                {if $char.level >= 10}<li><a href="index.php?page=char&action=talent&id={$id}&amp;realm={$realmid}">{$lang_char.talents}</a></li>{/if}
                                <li><a href="index.php?page=char&action=achieve&id={$id}&amp;realm={$realmid}">{$lang_char.achievements}</a></li>
                                <li><a href="index.php?page=char&action=rep&id={$id}&amp;realm={$realmid}">{$lang_char.reputation}</a></li>
                                <li><a href="index.php?page=char&action=skill&id={$id}&amp;realm={$realmid}">{$lang_char.skills}</a></li>
                                <li><a href="index.php?page=char&action=quest&id={$id}&amp;realm={$realmid}">{$lang_char.quests}</a></li>
        {if $char.class eq 3}
                                <li><a href="index.php?page=char&action=pets&id={$id}&amp;realm={$realmid}">{$lang_char.pets}</a></li>
        {/if}
                                <li><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}">{$lang_char.friends}</a></li>
                                <li><a href="index.php?page=char&action=spell&id={$id}&amp;realm={$realmid}">{$lang_char.spells}</a></li>
                                <li><a href="index.php?page=char&action=mail&id={$id}&amp;realm={$realmid}">{$lang_char.mail}</a></li>
                            </ul>
                        </div>
                        <div id="tab_content2">
                            <font class="bold">
                                {$char.name|escape:'html'} -
                                <img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char_additional.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                <img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char_additional.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                - lvl {$char_additional.lvlcolor}
                            </font>
    {* end char header! *}
                                <br /><br />
    {if $hasData}
                                <table class="lined" style="width: 550px;">
                                    <tr align="right">
                                        <td colspan="4">
                                            {$pagination}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{$lang_char.icon}</th>
                                        <th>{$lang_char.name}</th>
                                        <th>{$lang_char.icon}</th>
                                        <th>{$lang_char.name}</th>
                                    </tr>
        {foreach from=$spell_array item=spell}
            {if $spell.i is odd}
                                    <tr>
                                        <td><a href="{$spell.link}"><img src="{$spell.icon}" class="icon_border_0" /></a></td>
                                        <td align="left"><a href="{$spell.link}">{$spell.spellname}</a></td>
            {else}
                                        <td><a href="{$spell.link}"><img src="{$spell.icon}" class="icon_border_0" /></a></td>
                                        <td align="left"><a href="{$spell.link}">{$spell.spellname}</a></td>
                                    </tr>
            {/if}
        {/foreach}
                                    <tr align="right">
                                        <td colspan="4">
                                            {$pagination}
                                        </td>
                                    </tr>
                                </table>
    {/if}
                            </div>
                        </div>
                        <br />
{elseif $action eq 'char_pets'}
                    <center>
                        <div id="tab_content">
                        <h1>{$lang_char.pets}</h1>
                        <br />
    {* char header! *}
                        <div id="tab">
                            <ul>
                                <li><a href="index.php?page=char&id={$id}&amp;realm={$realmid}">{$lang_char.char_sheet}</a></li>
                                <li><a href="index.php?page=char&action=inv&id={$id}&amp;realm={$realmid}">{$lang_char.inventory}</a></li>
                                <li><a href="index.php?page=char&action=extra&id={$id}&amp;realm={$realmid}">{$lang_char.extra}</a></li>
                                {if $char.level >= 10}<li><a href="index.php?page=char&action=talent&id={$id}&amp;realm={$realmid}">{$lang_char.talents}</a></li>{/if}
                                <li><a href="index.php?page=char&action=achieve&id={$id}&amp;realm={$realmid}">{$lang_char.achievements}</a></li>
                                <li><a href="index.php?page=char&action=rep&id={$id}&amp;realm={$realmid}">{$lang_char.reputation}</a></li>
                                <li><a href="index.php?page=char&action=skill&id={$id}&amp;realm={$realmid}">{$lang_char.skills}</a></li>
                                <li><a href="index.php?page=char&action=quest&id={$id}&amp;realm={$realmid}">{$lang_char.quests}</a></li>
        {if $char.class eq 3}
                                <li><a href="index.php?page=char&action=pets&id={$id}&amp;realm={$realmid}">{$lang_char.pets}</a></li>
        {/if}
                                <li><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}">{$lang_char.friends}</a></li>
                                <li><a href="index.php?page=char&action=spell&id={$id}&amp;realm={$realmid}">{$lang_char.spells}</a></li>
                                <li><a href="index.php?page=char&action=mail&id={$id}&amp;realm={$realmid}">{$lang_char.mail}</a></li>
                            </ul>
                        </div>
                        <div id="tab_content2">
                            <font class="bold">
                                {$char.name|escape:'html'} -
                                <img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char_additional.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                <img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char_additional.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                - lvl {$char_additional.lvlcolor}
                            </font>
    {* end char header! *}
                        <br /><br />
    {foreach item=pet from=$pet_array}
                        <font class="bold">{$pet.name} - lvl {$pet.lvlcolor}
                            <a style="padding:2px;" onmouseover="toolTip('{$pet.hap_text}', \'item_tooltip\')" onmouseout="toolTip()"><img src="img/pet/happiness_{$pet.hap_val}.jpg" alt="" /></a>
                            <br /><br />
                        </font>
                        <table class="lined" style="width: 550px;">
                            <tr>
                                <td align="right">Exp:</td>
                                <td valign="top" class="bar skill_bar" style="background-position: {$pet.bpos}px;">
                                    <span>{$pet.exp}/{$pet.next_lvl_xp}</span>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Pet Abilities:</td>
                                <td align="left">
        {foreach from=$pet.abilities item=ability}
                                    <a style="padding:2px;" href="{$ability.link}" target="_blank">
                                        <img src="{$ability.img}" alt="{$ability.alt}" class="icon_border_0" />
                                    </a>
        {/foreach}
                                </td>
                            </tr>
                        </table>
                        <br /><br />
    {/foreach}
                    </div>
                    </div>
                    <br />
{elseif $action eq 'char_mail'}
                    <center>
                        <div id="tab_content">
                            <h1>{$lang_char.mail}</h1>
                            <br />
    {* char header! *}
                        <div id="tab">
                            <ul>
                                <li><a href="index.php?page=char&id={$id}&amp;realm={$realmid}">{$lang_char.char_sheet}</a></li>
                                <li><a href="index.php?page=char&action=inv&id={$id}&amp;realm={$realmid}">{$lang_char.inventory}</a></li>
                                <li><a href="index.php?page=char&action=extra&id={$id}&amp;realm={$realmid}">{$lang_char.extra}</a></li>
                                {if $char.level >= 10}<li><a href="index.php?page=char&action=talent&id={$id}&amp;realm={$realmid}">{$lang_char.talents}</a></li>{/if}
                                <li><a href="index.php?page=char&action=achieve&id={$id}&amp;realm={$realmid}">{$lang_char.achievements}</a></li>
                                <li><a href="index.php?page=char&action=rep&id={$id}&amp;realm={$realmid}">{$lang_char.reputation}</a></li>
                                <li><a href="index.php?page=char&action=skill&id={$id}&amp;realm={$realmid}">{$lang_char.skills}</a></li>
                                <li><a href="index.php?page=char&action=quest&id={$id}&amp;realm={$realmid}">{$lang_char.quests}</a></li>
        {if $char.class eq 3}
                                <li><a href="index.php?page=char&action=pets&id={$id}&amp;realm={$realmid}">{$lang_char.pets}</a></li>
        {/if}
                                <li><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}">{$lang_char.friends}</a></li>
                                <li><a href="index.php?page=char&action=spell&id={$id}&amp;realm={$realmid}">{$lang_char.spells}</a></li>
                                <li><a href="index.php?page=char&action=mail&id={$id}&amp;realm={$realmid}">{$lang_char.mail}</a></li>
                            </ul>
                        </div>
                        <div id="tab_content2">
                            <font class="bold">
                                {$char.name|escape:'html'} -
                                <img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char_additional.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                <img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char_additional.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                - lvl {$char_additional.lvlcolor}
                            </font>
    {* end char header! *}
                            <br /><br />
                            <table class="lined" style="width: 100%">
                                <tr>
                                    <td align="left">
                                        Total Mails: {$total_mail}
                                    </td>
                                    <td align="right" width="45%">
                                        {$pagination}
                                    </td>
                                </tr>
                            </table>
                            <table class="lined" style="width: 100%">
                                <tr>
                                    <th width="5%">{$lang_mail.mail_type}</th>
                                    <th width="10%">{$lang_mail.sender}</th>
                                    <th width="15%">{$lang_mail.subject}</th>
                                    <th width="5%">{$lang_mail.has_items}</th>
                                    <th width="25%">{$lang_mail.text}</th>
                                    <th width="20%">{$lang_mail.money}</th>
                                    <th width="5%">{$lang_mail.checked}</th>
                                </tr>
    {foreach from=$mail_array item=mail}
                                <tr valign=top>
                                    <td>{$mail.msource}</td>
                                    <td><a href="char.php?id={$mail.sender}">{$mail.charname}</a></td>
                                    <td>{$mail.subject}</td>
                                    <td>
                                        <a style="padding:2px;" href="{$mail.link}" target="_blank">
                                            <img class="bag_icon" src="{$mail.icon}" alt="" />
                                        </a>
                                    </td>
                                    <td>{$mail.body}</td>
                                    <td>
                                        {$mail.money|substr:0:-4}<img src="img/gold.gif" alt="" align="middle" />
                                        {$mail.money|substr:-4:2}<img src="img/silver.gif" alt="" align="middle" />
                                        {$mail.money|substr:-2}<img src="img/copper.gif" alt="" align="middle" />
                                    </td>
                                    <td>{$mail.checkstate}</td>
                                </tr>
    {/foreach}
                            </table>
                        </div>
                        <br />
{elseif $action eq ''}
{/if}

{* char footer *}
    <center>
        <table class="hidden">
        <tr>
            <td>
{if $higherLevelGM && $hasUpdatePermission}
                {include file='button.tpl' btext=$lang_char.chars_acc blink='index.php?page=user&action=edit_user&amp;id=`$owner_acc_id` ' bwidth=130}
            </td>
            <td>
{else}
                {include file='button.tpl' btext=$lang_char.chars_acc blink='index.php?page=edit' bwidth=130}
            </td>
            <td>
{/if}
{if $higherLevelGM && $hasDeletePermission}
                {include file='button.tpl' btext=$lang_char.edit_button blink='index.php?page=char&action=edit&id=`$id`&amp;realm=`$realmid` ' bwidth=130}
            </td>
            <td>
{/if}
{if $hasHigherGMLevel && $hasDeletePermission} {*$hasHigherGMLevel is also true if you edit yourself!*}
                {include file='button.tpl' btext=$lang_char.del_char blink='index.php?page=char&action=del_char_form&check%5B%5D=`$id`" type="wrn' bwidth=130}
            </td>
            <td>
{/if}
{if $hasUpdatePermission}
                {include file='button.tpl' btext=$lang_char.send_mail blink='index.php?page=mail&type=ingame_mail&amp;to=`$char.name` ' bwidth=130}
            </td>
            <td>
{/if}
                {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
            </td>
        </tr>
    </table>
</center>
<br />
</center>