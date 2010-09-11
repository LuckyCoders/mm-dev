            <center>
                <script type="text/javascript" src="libs/js/sha1.js"></script>
{literal}
                <script type="text/javascript">
                // <![CDATA[
                    function do_submit_data ()
                    {{/literal}
                        document.form.pass.value = hex_sha1("{$user_name|upper}:"+document.form.user_pass.value.toUpperCase());
                        document.form.user_pass.value = "0";
                        do_submit();
           {literal}}
                // ]]>
{/literal}
                </script>
                <fieldset style="width: 550px;">
                    <legend>{$lang_edit.edit_acc}</legend>
                    <form method="post" action="index.php?page=edit&action=doedit_user" name="form">
                        <input type="hidden" name="pass" value="" maxlength="256" />
                            <table class="flat">
                                <tr>
                                    <td>{$lang_edit.id}</td>
                                    <td>{$user_id}</td>
                                </tr>
                                <tr>
                                    <td>{$lang_edit.username}</td>
                                    <td>{$user_name}</td>
                                </tr>
                                <tr>
                                    <td>{$lang_edit.password}</td>
                                    <td><input type="text" name="user_pass" size="42" maxlength="40" value="******" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_edit.mail}</td>
                                    <td><input type="text" name="mail" size="42" maxlength="225" value="{$acc.email}" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_edit.invited_by}:</td>
                                    <td>
{if !empty($referred_by)}
                                        <input type="text" name="referredby" size="42" maxlength="12" value="" />
{else}
                                        {$referred_by}
{/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{$lang_edit.gm_level}</td>
                                    <td>{$gmlevelname} ( {$acc.gmlevel} )</td>
                                </tr>
                                <tr>
                                    <td>{$lang_edit.join_date}</td>
                                    <td>{$acc.joindate}</td>
                                </tr>
                                <tr>
                                    <td>{$lang_edit.last_ip}</td>
                                    <td>{$acc.last_ip}</td>
                                </tr>
{if $expansion_select}
                                <tr>
                                    <td >{$lang_edit.client_type}:</td>
                                    <td>
                                        <select name="expansion">
                                            <option value="2" {if $acc.expansion eq 2}selected="selected"{/if}>{$lang_edit.wotlk}</option>
                                            <option value="1" {if $acc.expansion eq 1}selected="selected"{/if}>{$lang_edit.tbc}</option>
                                            <option value="0" {if $acc.expansion eq 0}selected="selected"{/if}>{$lang_edit.classic}</option>
                                        </select>
                                    </td>
                                </tr>
{/if}
                                <tr>
                                    <td>{$lang_edit.tot_chars}</td>
                                    <td>{$numchars}</td>
                                </tr>
{foreach from=$realmdata item=realm}
                                <tr>
                                    <td>{$lang_edit.characters} {$realm.realmname}</td>
                                    <td>{$realm.count}</td>
                                </tr>
    {foreach from=$realm.cdata item=char}
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'---></td>
                                    <td>
                                        <a href="index.php?page=char&id={$char.guid}&amp;realm={$char.realmid}">{$char.name} -
                                            <img src="img/c_icons/{$char.race}-{$char.gender}.gif" onmousemove="toolTip('{$char.racename}', 'item_tooltip')" onmouseout="toolTip()" alt="" />
                                            <img src="img/c_icons/{$char.class}.gif" onmousemove="toolTip('{$char.classname}', 'item_tooltip')" onmouseout="toolTip()" alt=""/> - lvl {$char.lvlcolor}
                                        </a>
                                    </td>
                                </tr>
    {/foreach}
{/foreach}
                                <tr>
                                    <td>
                                        {include file='button.tpl' btext=$lang_edit.update blink='javascript:do_submit_data()" type="wrn' bwidth=130}
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <br />
                    <fieldset style="width: 550px;">
                        <legend>{$lang_edit.theme_options}</legend>
                            <table class="hidden" style="width: 450px;">
                                <tr>
                                    <td align="left">{$lang_edit.select_layout_lang} :</td>
                                    <td align="right">
                                        <form action="index.php" method="get" name="form1">
                                            <input type="hidden" name="page" value="edit" />
                                            <input type="hidden" name="action" value="lang_set" />
                                            <select name="lang">
                                                <optgroup label="{$lang_edit.language}">
                                                    {$language_optgrp}
                                                </optgroup>
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </form>
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_edit.save blink='javascript:do_submit(\'form1\',0)' bwidth=130}
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">{$lang_edit.select_theme} :</td>
                                    <td align="right">
                                        <form action="index.php" method="get" name="form2">
                                            <input type="hidden" name="page" value="edit" />
                                            <input type="hidden" name="action" value="theme_set" />
                                            <select name="theme">
                                                <optgroup label="{$lang_edit.theme}">
                                                    {$theme_optgrp}
                                                </optgroup>
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </form>
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_edit.save blink='javascript:do_submit(\'form2\',0)' bwidth=130}
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <br />
                    </center>