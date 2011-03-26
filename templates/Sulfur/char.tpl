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
                    </div>
                    <br />
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
                                -lvl {$char.level}
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
                                -lvl {$char.level}
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
                                -lvl {$char.level}
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
{elseif $action eq 'char_talent'}
                        <center>
                            <div id="tab_content">
                                <h1>{$lang_char.talents}</h1>
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
                                -lvl {$char.level}
                            </font>
    {* end char header! *}
                                <br /><br />
                                <table class="lined" style="width: 550px;">
                                    <tr valign="top" align="center">
    {foreach from=$tab_data item=tab}
                                        <td>
                                            <table class="hidden" style="width: 0px;">
                                                <tr>
                                                    <td colspan="6" style="border-bottom-width: 0px;">
                                                    </td>
                                                </tr>
                                                <tr>
        {foreach from=$tab.data item=for1}
            {foreach from=$for1.data item=for2}
                {if $for2.link}
                                                    <td valign="bottom" align="center" style="border-top-width: 0px;border-bottom-width: 0px;">
                                                        <a href="{$for2.link}" target="_blank">
                                                            <img src="{$for2.icon}" width="36" height="36" class="icon_border_{$for2.border}" alt="" />
                                                        </a>
                                                        <div style="width:0px;margin:-14px 0px 0px 30px;font-size:14px;color:black">{$for2.tn}</div>
                                                        <div style="width:0px;margin:-14px 0px 0px 29px;font-size:14px;color:white">{$for2.tn}</div>
                                                    </td>
                {else}
                                                    <td valign="bottom" align="center" style="border-top-width: 0px;border-bottom-width: 0px;">
                                                        <img src="img/blank.gif" width="44" height="44" alt="" />
                                                    </td>
                {/if}
            {/foreach}
                                                </tr>
                                                <tr>
        {/foreach}
                                                    <td colspan="6" style="border-top-width: 0px;border-bottom-width: 0px;">
                                                        </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" valign="bottom" align="left">
                                                    {$tab.field1}: {$tab.points}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
    {/foreach}
                                    </tr>
                                </table>
                                <br />
                                <table>
                                    <tr>
                                        <td align="left">
                                            {$lang_char.talent_rate}: <br />
                                            {$lang_char.talent_points}: <br />
                                            {$lang_char.talent_points_used}: <br />
                                            {$lang_char.talent_points_shown}: <br />
                                            {$lang_char.talent_points_left}:
                                        </td>
                                        <td align="left">
                                            {$talent_rate}<br />
                                            {$talent_points}<br />
                                            {$talent_points_used}<br />
                                            {$l}<br />
                                            {$talent_points_left}
                                        </td>
                                        <td width="64">
                                        </td>
                                        <td align="right">
    {foreach from=$glyph_data item=glyph}
                                            <a href="{$glyph.link}" target="_blank">
                                                <img src="{$glyph.icon}" width="36" height="36" class="icon_border_0" alt="" />
                                            </a>
    {/foreach}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <br />
{elseif $action eq 'char_extra'}
            <center>
                <div id="tab_content">
                    <h1>{$lang_char.extra}</h1>
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
                                -lvl {$char.level}
                            </font>
    {* end char header! *}
                    <br /><br />
                    <table class="lined" style="width: 450px;">
                        <tr>
                            <th width="15%">{$lang_char.icon}</th>
                            <th width="15%">{$lang_char.quantity}</th>
                            <th width="70%">{$lang_char.name}</th>
                        </tr>
    {foreach from=$items item=item}
                        <tr valign="center">
                            <td>
                                <a style="padding:2px;" href="{$item.link}" target="_blank">
                                    <img src="{$item.icon}" alt="{$item.alt}" class="icon_border_0" />
                                </a>
                            </td>
                            <td>
                                {$item.count}
                            </td>
                            <td>
                                <span onmousemove="toolTip('{$item.bag_desc}', 'item_tooltip')" onmouseout="toolTip()">{$item.name}</span>
                            </td>
                        </tr>
    {/foreach}
                    </table>
                </div>
            </div>
            <br />
{elseif $action eq 'char_friends'}
            <center>
                <div id="tab_content">
                    <h1>{$lang_char.friends}</h1>
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
                                -lvl {$char.level}
                            </font>
    {* end char header! *}
                        <br /><br />
                        <table class="hidden"  style="width: 1%;">
                            <tr valign="top">
                                <td>
                                    <table class="lined" style="width: 1%;">
    {if $hasFriends}
                                        <tr>
                                            <th colspan="7" align="left">{$lang_char.friends}</th>
                                        </tr>
                                        <tr>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=name&amp;dir={$dir}"{if $order_by eq 'name'} class="{$order_dir}"{/if}>{$lang_char.name}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=race&amp;dir={$dir}"{if $order_by eq 'race'} class="{$order_dir}"{/if}>{$lang_char.race}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=class&amp;dir={$dir}"{if $order_by eq 'class'} class="{$order_dir}"{/if}>{$lang_char.class}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=level&amp;dir={$dir}"{if $order_by eq 'level'} class="{$order_dir}"{/if}>{$lang_char.level}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=map&amp;dir={$dir}"{if $order_by eq 'map'} class="{$order_dir}"{/if}>{$lang_char.map}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=zone&amp;dir={$dir}"{if $order_by eq 'zone'} class="{$order_dir}"{/if}>{$lang_char.zone}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=online&amp;dir={$dir}"{if $order_by eq 'online'} class="{$order_dir}"{/if}>{$lang_char.online}</a></th>
                                        </tr>
        {foreach from=$friends item=friend}
                                        <tr>
                                            <td>
                                                <a href="index.php?page=char&id={$friend.guid}">{$friend.name}</a>
                                            </td>
                                            <td><img src="img/c_icons/{$friend.race}-{$friend.gender}.gif" onmousemove="toolTip('{$friend.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td><img src="img/c_icons/{$friend.class}.gif" onmousemove="toolTip('{$friend.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td>{$friend.lvlcolor}</td>
                                            <td class="small"><span onmousemove="toolTip('MapID:{$friend.map}', 'item_tooltip')" onmouseout="toolTip()">{$friend.mapname}</span></td>
                                            <td class="small"><span onmousemove="toolTip('ZoneID:{$friend.zone}', 'item_tooltip')" onmouseout="toolTip()">{$friend.zonename}</span></td>
                                            <td>{if $friend.online}<img src="img/up.gif" alt="" />{else}-{/if}</td>
                                        </tr>
        {/foreach}
    {/if}
    {if $hasMe}
                                        <tr>
                                            <th colspan="7" align="left">{$lang_char.friendof}</th>
                                        </tr>
                                        <tr>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=name&amp;dir={$dir}"{if $order_by eq 'name'} class="{$order_dir}"{/if}>{$lang_char.name}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=race&amp;dir={$dir}"{if $order_by eq 'race'} class="{$order_dir}"{/if}>{$lang_char.race}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=class&amp;dir={$dir}"{if $order_by eq 'class'} class="{$order_dir}"{/if}>{$lang_char.class}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=level&amp;dir={$dir}"{if $order_by eq 'level'} class="{$order_dir}"{/if}>{$lang_char.level}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=map&amp;dir={$dir}"{if $order_by eq 'map'} class="{$order_dir}"{/if}>{$lang_char.map}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=zone&amp;dir={$dir}"{if $order_by eq 'zone'} class="{$order_dir}"{/if}>{$lang_char.zone}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=online&amp;dir={$dir}"{if $order_by eq 'online'} class="{$order_dir}"{/if}>{$lang_char.online}</a></th>
                                        </tr>
        {foreach from=$rfriends item=rfriend}
                                        <tr>
                                            <td>
                                                <a href="index.php?page=char&id={$rfriend.guid}">{$rfriend.name}</a>
                                            </td>
                                            <td><img src="img/c_icons/{$rfriend.race}-{$rfriend.gender}.gif" onmousemove="toolTip('{$rfriend.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td><img src="img/c_icons/{$rfriend.class}.gif" onmousemove="toolTip('{$rfriend.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td>{$rfriend.lvlcolor}</td>
                                            <td class="small"><span onmousemove="toolTip('MapID:{$rfriend.map}', 'item_tooltip')" onmouseout="toolTip()">{$rfriend.mapname}</span></td>
                                            <td class="small"><span onmousemove="toolTip('ZoneID:{$rfriend.zone}', 'item_tooltip')" onmouseout="toolTip()">{$rfriend.zonename}</span></td>
                                            <td>{if $rfriend.online}<img src="img/up.gif" alt="" />{else}-{/if}</td>
                                        </tr>
        {/foreach}
    {/if}
                                        <script type="text/javascript">
                                        // <![CDATA[
                                          wrap();
                                        // ]]>
                                        </script>
    {if $hasIgnored}
                                        <tr>
                                            <th colspan="7" align="left">{$lang_char.ignored}</th>
                                        </tr>
                                        <tr>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=name&amp;dir={$dir}"{if $order_by eq 'name'} class="{$order_dir}"{/if}>{$lang_char.name}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=race&amp;dir={$dir}"{if $order_by eq 'race'} class="{$order_dir}"{/if}>{$lang_char.race}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=class&amp;dir={$dir}"{if $order_by eq 'class'} class="{$order_dir}"{/if}>{$lang_char.class}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=level&amp;dir={$dir}"{if $order_by eq 'level'} class="{$order_dir}"{/if}>{$lang_char.level}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=map&amp;dir={$dir}"{if $order_by eq 'map'} class="{$order_dir}"{/if}>{$lang_char.map}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=zone&amp;dir={$dir}"{if $order_by eq 'zone'} class="{$order_dir}"{/if}>{$lang_char.zone}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=online&amp;dir={$dir}"{if $order_by eq 'online'} class="{$order_dir}"{/if}>{$lang_char.online}</a></th>
                                        </tr>
        {foreach from=$ignored item=igno}
                                        <tr>
                                            <td>
                                                <a href="index.php?page=char&id={$igno.guid}">{$igno.name}</a>
                                            </td>
                                            <td><img src="img/c_icons/{$igno.race}-{$igno.gender}.gif" onmousemove="toolTip('{$igno.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td><img src="img/c_icons/{$igno.class}.gif" onmousemove="toolTip('{$igno.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td>{$igno.lvlcolor}</td>
                                            <td class="small"><span onmousemove="toolTip('MapID:{$igno.map}', 'item_tooltip')" onmouseout="toolTip()">{$igno.mapname}</span></td>
                                            <td class="small"><span onmousemove="toolTip('ZoneID:{$igno.zone}', 'item_tooltip')" onmouseout="toolTip()">{$igno.zonename}</span></td>
                                            <td>{if $igno.online}<img src="img/up.gif" alt="" />{else}-{/if}</td>
                                        </tr>
        {/foreach}
    {/if}
    {if $hasIgnoredMe}
                                        <tr>
                                            <th colspan="7" align="left">{$lang_char.ignoredby}</th>
                                        </tr>
                                        <tr>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=name&amp;dir={$dir}"{if $order_by eq 'name'} class="{$order_dir}"{/if}>{$lang_char.name}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=race&amp;dir={$dir}"{if $order_by eq 'race'} class="{$order_dir}"{/if}>{$lang_char.race}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=class&amp;dir={$dir}"{if $order_by eq 'class'} class="{$order_dir}"{/if}>{$lang_char.class}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=level&amp;dir={$dir}"{if $order_by eq 'level'} class="{$order_dir}"{/if}>{$lang_char.level}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=map&amp;dir={$dir}"{if $order_by eq 'map'} class="{$order_dir}"{/if}>{$lang_char.map}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=zone&amp;dir={$dir}"{if $order_by eq 'zone'} class="{$order_dir}"{/if}>{$lang_char.zone}</a></th>
                                            <th width="1%"><a href="index.php?page=char&action=friends&id={$id}&amp;realm={$realmid}&amp;order_by=online&amp;dir={$dir}"{if $order_by eq 'online'} class="{$order_dir}"{/if}>{$lang_char.online}</a></th>
                                        </tr>
        {foreach from=$rignored item=rigno}
                                        <tr>
                                            <td>
                                                <a href="index.php?page=char&id={$rigno.guid}">{$rigno.name}</a>
                                            </td>
                                            <td><img src="img/c_icons/{$rigno.race}-{$rigno.gender}.gif" onmousemove="toolTip('{$rigno.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td><img src="img/c_icons/{$rigno.class}.gif" onmousemove="toolTip('{$rigno.classname}', 'item_tooltip')" onmouseout="toolTip()" alt="" /></td>
                                            <td>{$rigno.lvlcolor}</td>
                                            <td class="small"><span onmousemove="toolTip('MapID:{$rigno.map}', 'item_tooltip')" onmouseout="toolTip()">{$rigno.mapname}</span></td>
                                            <td class="small"><span onmousemove="toolTip('ZoneID:{$rigno.zone}', 'item_tooltip')" onmouseout="toolTip()">{$rigno.zonename}</span></td>
                                            <td>{if $rigno.online}<img src="img/up.gif" alt="" />{else}-{/if}</td>
                                        </tr>
        {/foreach}
    {/if}
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br />
{elseif $action eq 'char_inv'}
            <center>
                <div id="tab_content">
                    <h1>{$lang_char.inventory}</h1>
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
                                - lvl {$char.level}
                            </font>
    {* end char header! *}
                            <br /><br />
                            <table class="lined" style="width: 700px;">
                                <tr>
    {foreach from=$bags item=bag}
                                    <th>
        {if $bag.isEquipped}
                                        <a style="padding:2px;" href="{$itemdatasite}{$bag.id}" target="_blank">
                                            <img class="bag_icon" src="{$bag.icon}" alt="" />
                                        </a>
                                        {$lang_item.bag} {$bag.i}<br />
                                        <font class="small">{$bag.slots} {$lang_item.slots}</font>
        {/if}
                                    </th>
    {/foreach}
                                </tr>
                                <tr>
    {foreach from=$bagslots item=bagslot}
                                    <td class="bag" valign="bottom" align="center">
                                        <div style="width:172px;height:{$bagslot.height}px;">
        {if $bagslot.dsp}
                                            <div class="no_slot"></div>
        {/if}
        {foreach from=$bagslot.bagposis item=posi}
                                            <div style="left:{$posi.left}px;top:{$posi.top}px;">
                                                <a style="padding:2px;" href="{$itemdatasite}{$posi.itemid}" target="_blank">
                                                    <img src="{$posi.itemicon}" alt="" />
                                                </a>
                                                <div style="width:25px;margin:-20px 0px 0px 18px;color: black; font-size:14px">{if $posi.item eq 1}{else}{$posi.item}{/if}</div>
                                                <div style="width:25px;margin:-21px 0px 0px 17px;font-size:14px">{if $posi.item eq 1}{else}{$posi.item}{/if}</div>
                                            </div>
        {/foreach}
                                        </div>
                                    </td>
    {/foreach}
                                </tr>
                                <tr>
                                    <th colspan="2" align="left">
                                        <img class="bag_icon" src="{$emptysloticon}" alt="" align="middle" style="margin-left:100px;" />
                                        <font style="margin-left:30px;">{$lang_char.backpack}</font>
                                    </th>
                                    <th colspan="2">
                                        {$lang_char.bank_items}
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bag" align="center" height="220px">
                                        <div style="width:172px;height:164px;">
    {foreach from=$items item=item}
                                            <div style="left:{$item.left}px;top:{$item.top}px;">
                                                <a style="padding:2px;" href="{$itemdatasite}{$item.itemid}" target="_blank">
                                                    <img src="{$item.itemicon}" alt="" />
                                                </a>
                                                <div style="width:25px;margin:-20px 0px 0px 18px;color: black; font-size:14px">{if $item.item eq 1}{else}{$item.item}{/if}</div>
                                                <div style="width:25px;margin:-21px 0px 0px 17px;font-size:14px">{if $item.item eq 1}{else}{$item.item}{/if}</div>
                                            </div>
    {/foreach}
                                        </div>
                                        <div style="text-align:right;width:168px;background-image:none;background-color:#393936;padding:2px;">
                                            <b>
                                                {$money.g}<img src="img/gold.gif" alt="" align="middle" />
                                                {$money.s}<img src="img/silver.gif" alt="" align="middle" />
                                                {$money.c}<img src="img/copper.gif" alt="" align="middle" />
                                            </b>
                                        </div>
                                    </td>
                                    <td colspan="2" class="bank" align="center">
                                        <div style="width:301px;height:164px;">
    {foreach from=$bankitems item=item}
                                            <div style="left:{$item.left}px;top:{$item.top}px;">
                                                <a style="padding:2px;" href="{$itemdatasite}{$item.itemid}" target="_blank">
                                                    <img src="{$item.itemicon}" alt="" />
                                                </a>
                                                <div style="width:25px;margin:-20px 0px 0px 18px;color: black; font-size:14px">{if $item.item eq 1}{else}{$item.item}{/if}</div>
                                                <div style="width:25px;margin:-21px 0px 0px 17px;font-size:14px">{if $item.item eq 1}{else}{$item.item}{/if}</div>
                                            </div>
    {/foreach}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
    {foreach from=$bankbags item=bag}
                                    <th>
        {if $bag.isEquipped}
                                        <a style="padding:2px;" href="{$item_datasite}{$bag.itemid}" target="_blank">
                                            <img class="bag_icon" src="{$bag.itemicon}" alt="" />
                                        </a>
                                        {$lang_item.bag} {$bag.i}<br />
                                        <font class="small">{$bag.slots} {$lang_item.slots}</font>
        {/if}
                                    </th>
    {/foreach}
                                </tr>
                                <tr>
    {foreach from=$bankslots item=bankslot}
        {if $bankslot.i eq 5}
                                </tr>
            {foreach from=$bankslot.bankbags item=bankbag}
                                        <th>
                {if $bankbag.isEquipped}
                                            <a style="padding:2px;" href="{$item_datasite}{$id}" target="_blank">
                                                <img class="bag_icon" src="{$bankbag.icon}" alt="" />
                                            </a>
                                            {$lang_item.bag} {$bankbag.i}<br />
                                            <font class="small">{$bankbag.slots} {$lang_item.slots}</font>
                {/if}
                                        </th>
            {/foreach}
                                        <th>
                                        </th>
                                    </tr>
                                    <tr>
        {/if}
                                        <td class="bank" align="center">
                                            <div style="width:172px;height:{$bankslot.height}px;">
        {if $bankslot.dsp}
                                                <div class="no_slot"></div>
        {/if}
        {foreach from=$bankslot.bankitems item=item}
                                                <div style="left:{$item.left}px;top:{$item.top}px;">
                                                    <a style="padding:2px;" href="{$itemdatasite}{$item.itemid}" target="_blank">
                                                        <img src="{$item.itemicon}" alt="" />
                                                    </a>
                                                    <div style="width:25px;margin:-20px 0px 0px 18px;color: black; font-size:14px">{if $item.item eq 1}{else}{$item.item}{/if}</div>
                                                    <div style="width:25px;margin:-21px 0px 0px 17px;font-size:14px">{if $item.item eq 1}{else}{$item.item}{/if}</div>
                                                </div>
        {/foreach}
                                            </div>
                                        </td>
    {/foreach}
                                        <td class="bank"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br />
{elseif $action eq 'char_skill'}
            <center>
                <div id="tab_content">
                    <h1>{$lang_char.skills}</h1>
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
                                - lvl {$char.level}
                            </font>
    {* end char header! *}
                                        <br /><br />
                                        <table class="lined" style="width: 550px;">
                                            <tr>
                                                <th class="title" colspan="{$title_colspan}" align="left">{$lang_char.skills}</th>
                                            </tr>
                                            <tr>
    {if $user_lvl}
                                                <th><a href="index.php?page=char&action=skill&id={$id}&amp;realm={$realmid}&amp;order_by=0&amp;dir={$dir}"{if $order_by eq 0} class="{$order_dir}"{/if}>{$lang_char.skill_id}</a></th>
    {/if}
                                                <th align="right"><a href="index.php?page=char&action=skill&id={$id}&amp;realm={$realmid}&amp;order_by=1&amp;dir={$dir}"{if $order_by eq 1} class="{$order_dir}"{/if}>{$lang_char.skill_name}</a></th>
                                                <th><a href="index.php?page=char&action=skill&id={$id}&amp;realm={$realmid}&amp;order_by=2&amp;dir={$dir}"{if $order_by eq 2} class="{$order_dir}"{/if}>{$lang_char.skill_value}</a></th>
                                            </tr>
    {foreach from=$skill_array item=skill}
                                                <tr>
                                                    {if $user_lvl}<td>{$skill[0]}</td>{/if}
                                                    <td align="right">{$skill[1]}</td>
                                                    <td valign="center" class="bar skill_bar" style="background-position: {$skill[4]}px;">
                                                        <span>{$skill[2]}/{$skill[3]}</span>
                                                    </td>
                                                </tr>
    {/foreach}
    
    {if $class_array|@count gt 0}
                                                <tr>
                                                    <th class="title" colspan="{$title_colspan}" align="left">{$lang_char.classskills}</th>
                                                </tr>
    {/if}
                                                
    {foreach from=$class_array item=class}
                                                <tr>
                                                    {if $user_lvl}<td>{$class[0]}</td>{/if}
                                                    <td align="right"><a href="{$skill_datasite}7.{$char.class}.{$class[0]}" target="_blank">{$class[1]}</td>
                                                    <td valign="center" class="bar skill_bar" style="background-position: 0px;">
                                                    </td>
                                                </tr>
    {/foreach}


    {if $prof_1_array|@count gt 0}
                                                <tr>
                                                    <th class="title" colspan="{$title_colspan}" align="left">{$lang_char.professions}</th>
                                                </tr>
    {/if}
                                                
    {foreach from=$prof_1_array item=prof_1}
    {assign var=temp value=$prof_1[3]} 
                                                <tr>
                                                    {if $user_lvl}<td>{$class[0]}</td>{/if}
                                                    <td align="right"><a href="{$skill_datasite}11.{$prof_1[0]}" target="_blank">{$prof_1[1]}</a></td>
                                                    <td valign="center" class="bar skill_bar" style="background-position: {$prof_1[4]}px;">
                                                        <span>{$prof_1[2]}/{$prof_1[3]} ({$skill_rank_array[$temp]})</span>
                                                    </td>
                                                </tr>
    {/foreach}

    {if $prof_2_array|@count gt 0}
                                                <tr>
                                                    <th class="title" colspan="{$title_colspan}" align="left">{$lang_char.secondaryskills}</th>
                                                </tr>
    {/if}

    {foreach from=$prof_2_array item=prof_2}
    {assign var=temp value=$prof_2[3]} 
                                                <tr>
                                                    {if $user_lvl}<td>{$prof_2[0]}</td>{/if}
                                                    <td align="right"><a href="{$skill_datasite}9.{$prof_2[0]}" target="_blank">{$prof_2[1]}</a></td>
                                                    <td valign="center" class="bar skill_bar" style="background-position: {$prof_2[4]}px;">
                                                        <span>{$prof_2[2]}/{$prof_2[3]} ({$skill_rank_array[$temp]})</span>
                                                    </td>
                                                </tr>
    {/foreach}

    {if $weapon_array|@count gt 0}
                                                <tr>
                                                    <th class="title" colspan="{$title_colspan}" align="left">{$lang_char.weaponskills}</th>
                                                </tr>
    {/if}
                                                
    {foreach from=$weapon_array item=weapon}
                                                <tr>
                                                    {if $user_lvl}<td>{$weapon[0]}</td>{/if}
                                                    <td align="right">{$weapon[1]}</td>
                                                    <td valign="center" class="bar skill_bar" style="background-position: {$weapon[4]}px;">
                                                        <span>{$weapon[2]}/{$weapon[3]}</span>
                                                    </td>
                                                </tr>
    {/foreach}

    {if $armor_array|@count gt 0}
                                                <tr>
                                                    <th class="title" colspan="{$title_colspan}" align="left">{$lang_char.armorproficiencies}</th>
                                                </tr>
    {/if}

    {foreach from=$armor_array item=armor}
                                                <tr>
                                                    {if $user_lvl}<td>{$armor[0]}</td>{/if}
                                                    <td align="right">{$armor[1]}</td>
                                                    <td valign="center" class="bar skill_bar" style="background-position: 0px;">
                                                    </td>
                                                </tr>
    {/foreach}

    {if $language_array|@count gt 0}
                                                <tr>
                                                    <th class="title" colspan="{$title_colspan}" align="left">{$lang_char.languages}</th>
                                                </tr>
    {/if}
                                                
    {foreach from=$language_array item=language}
                                                <tr>
                                                    {if $user_lvl}<td>{$language[0]}</td>{/if}
                                                    <td align="right">{$language[1]}</td>
                                                    <td valign="center" class="bar skill_bar" style="background-position: {$language[4]}px;">
                                                        <span>{$language[2]}/{$language[3]}</span>
                                                    </td>
                                                </tr>
    {/foreach}
                                            </table>
                                            <br />
                                        </div>
                                        <br />
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