                <center>
                    <script type="text/javascript" src="libs/js/sha1.js"></script>
{literal}
                    <script type="text/javascript">
                        // <![CDATA[
                          function do_submit_data ()
                          {
                            if ((document.form.username.value != "{$char_data.username}") && (document.form.new_pass.value == "******"))
                            {
                              alert("If you are changing Username, The password must be changed too.");
                              return;
                            }
                            else
                            {
                              document.form.pass.value = hex_sha1(document.form.username.value.toUpperCase()+":"+document.form.new_pass.value.toUpperCase());
                              document.form.new_pass.value = "0";
                              do_submit();
                            }
                          }
                        // ]]>
                    </script>
{/literal}
                        <fieldset style="width: 550px;">
                        <legend>{$lang_user.edit_acc}</legend>
                            <form method="post" action="index.php?page=user&action=doedit_user" name="form">
                                <input type="hidden" name="pass" value="" maxlength="256" />
                                <input type="hidden" name="id" value="{$id}" />
                                <table class="flat">
                                    <tr>
                                        <td>{$lang_user.id}</td>
                                        <td>{$char_data.id}</td>
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.username}</td>
{if $hasUpdatePermission}
                                        <td><input type="text" name="username" size="42" maxlength="15" value="{$char_data.username}" /></td>
{else}
                                        <td>{$char_data.username}</td>
{/if}
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.password}</td>
{if $hasUpdatePermission}
                                        <td><input type="text" name="new_pass" size="42" maxlength="40" value="******" /></td>
{else}
                                        <td>********</td>
{/if}
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.email}</td>
{if $hasUpdatePermission}
                                        <td><input type="text" name="mail" size="42" maxlength="225" value="{$char_data.email}" /></td>
{else}
                                        <td>***@***.***</td>
{/if}
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.invited_by}:</td>
                                        <td>
{if $hasUpdatePermission && $referred_by}
                                            <input type="text" name="referredby" size="42" maxlength="12" value="{$referred_by}" />
{else}
                                            {$referred_by}
{/if}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.gm_level_long}</td>
{if $hasUpdatePermission}
                                        <td>
                                            {html_options name=gmlevel options=$gmlevel_options selected=$char_data.gmlevel}
                                        </td>
{else}
                                        <td>{$gmlevelname} ({$char_data.gmlevel})</td>
{/if}
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.join_date}</td>
                                        <td>{$char_data.joindate}</td>
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.last_ip}</td>
{if $hasUpdatePermission}
                                        <td>{$char_data.last_ip}<a href="index.php?page=banned&amp;action=do_add_entry&amp;entry={$char_data.last_ip}&amp;bantime=3600&amp;ban_type=ip_banned"> &lt;- {$lang_user.ban_this_ip}</a></td>
{else}
                                        <td>***.***.***.***</td>
{/if}
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.banned}</td>
{if $hasUpdatePermission}
                                        <td><input type="checkbox" name="banned" value="1"{if $ban_checked} checked="checked"{/if}/>{$ban_info}</td>
{else}
                                        <td>{$ban_info}</td>
{/if}
                                    </tr>
                                    <tr>
                                        <td>{$lang_user.banned_reason}</td>
{if $hasUpdatePermission}
                                        <td><input type="text" name="banreason" size="42" maxlength="255" value="{$banreason}" /></td>
{else}
                                        <td>{$banreason}</td>
{/if}
{if $expansion_select}
                                    </tr>
                                    <tr>
    {if $hasUpdatePermission}
                                        <td>{$lang_user.client_type}</td>
                                        <td>
                                            {html_options name=expansion options=$expansion_options selected=$char_data.expansion}
                                        </td>
    {else}
                                            <td>{$lang_user.classic}</td>
    {/if}
{/if}
                                        </tr>
                                        <tr>
                                            <td>{$lang_user.failed_logins_long}</td>
{if $hasUpdatePermission}
                                            <td><input type="text" name="failed" size="42" maxlength="3" value="{$char_data.failed_logins}" /></td>
{else}
                                            <td>{$char_data.failed_logins}</td>
{/if}
                                        </tr>
                                        <tr>
                                            <td>{$lang_user.locked}</td>
{if $hasUpdatePermission}
                                            <td><input type="checkbox" name="locked" value="1"{if $lock_checked}  checked="checked"{/if}/></td>
{else}
                                            <td></td>
{/if}
                                        </tr>
                                        <tr>
                                            <td>{$lang_user.last_login}</td>
                                            <td>{$char_data.last_login}</td>
                                        </tr>
                                        <tr>
                                            <td>{$lang_user.online}</td>
                                            <td>{if $char_data.online}{$lang_global.yes}{else}{$lang_global.no}{/if}</td>
                                        </tr>
                                        <tr>
                                            <td>{$lang_user.tot_chars}</td>
                                            <td>{$tot_chars}</td>
                                        </tr>
{foreach from=$realm_data_array item=data}
                                        <tr>
                                            <td>{$lang_user.chars_on_realm} {$char_data.realmname}</td>
                                            <td>{$data.chars_on_realm}</td>
                                        </tr>
    {if $data.chars_on_realm}
        {foreach from=$data.char_array item=cdata}
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'---></td>
                                            <td>
                                                <a href="index.php?page=char&id={$cdata.guid}&amp;realm={$char_data.id}">{$cdata.name}  - <img src='img/c_icons/{$cdata.race}-{$cdata.gender}.gif' onmousemove="toolTip('{$cdata.racename}','item_tooltip')" onmouseout="toolTip()" alt="" />
                                                <img src="img/c_icons/{$cdata.class}.gif" onmousemove="toolTip('{$cdata.classname}','item_tooltip')" onmouseout="toolTip()" alt=""/> - lvl {$cdata.levelcolor}</a>
                                            </td>
                                        </tr>
        {/foreach}
    {/if}
{/foreach}
                                        <tr>
                                            <td>
{if $hasDeletePermission}
                                                {include file='button.tpl' btext=$lang_user.del_acc blink=$deluser_link bwidth=130}
{/if}
                                            </td>
                                            <td>
{if $hasUpdatePermission}
                                                {include file='button.tpl' btext=$lang_user.update_data blink='javascript:do_submit_data()' bwidth=130}
{/if}
                                                {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </fieldset>
                        <br /><br />
                    </center>