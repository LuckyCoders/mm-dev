{if $action eq 'browse_users'}
                <script type="text/javascript" src="libs/js/check.js"></script>
                <center>
                    <table class="top_hidden">
                        <tr>
                            <td>
    {if $hasInsertPermission}
                                {include file='button.tpl' btext=$lang_user.add_acc blink='index.php?page=user&action=add_new' bwidth=130}
    {/if}
                                {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()' bwidth=130}
    {if $search_by && $search_value}
                                {include file='button.tpl' btext=$lang_user.user_list blink='index.php?page=user' bwidth=130}
    {/if}
                            </td>
                            <td align="right" width="25%" rowspan="2">
                                {$lang_user.tot_acc}&nbsp;:&nbsp;{$all_record}<br /><br />
                            </td>
                        </tr>
                        <tr align="left">
                            <td>
                                <table class="hidden">
                                    <tr>
                                        <td>
                                            <form action="index.php" method="get" name="form">
                                                <input type="hidden" name="error" value="3" />
                                                <input type="hidden" name="page" value="user" />
                                                <input type="text" size="24" maxlength="50" name="search_value" value="{$search_value}" />
                                                <select name="search_by">
                                                    <option value="username" {if $search_by eq 'username'}selected="selected"{/if}>{$lang_user.by_name}</option>
                                                    <option value="id" {if $search_by eq 'id'}selected="selected"{/if}>{$lang_user.by_id}</option>
                                                    <option value="gmlevel" {if $search_by eq 'gmlevel'}selected="selected"{/if}>{$lang_user.by_gm_level}</option>
                                                    <option value="greater_gmlevel" {if $search_by eq 'greater_gmlevel'}selected="selected"{/if}>{$lang_user.greater_gm_level}</option>
                                                    <option value="expansion" {if $search_by eq 'expansion'}selected="selected"{/if}>{$lang_user.by_expansion}</option>
                                                    <option value="email" {if $search_by eq 'email'}selected="selected"{/if}>{$lang_user.by_email}</option>
                                                    <option value="joindate" {if $search_by eq 'joindate'}selected="selected"{/if}>{$lang_user.by_join_date}</option>
                                                    <option value="last_ip" {if $search_by eq 'last_ip'}selected="selected"{/if}>{$lang_user.by_ip}</option>
                                                    <option value="failed_logins" {if $search_by eq 'failed_logins'}selected="selected"{/if}>{$lang_user.by_failed_loggins}</option>
                                                    <option value="last_login" {if $search_by eq 'last_login'}selected="selected"{/if}>{$lang_user.by_last_login}</option>
                                                    <option value="online" {if $search_by eq 'online'}selected="selected"{/if}>{$lang_user.by_online}</option>
                                                    <option value="locked" {if $search_by eq 'locked'}selected="selected"{/if}>{$lang_user.by_locked}</option>
                                                    <option value="banned" {if $search_by eq 'banned'}selected="selected"{/if}>{$lang_user.by_banned}</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            {include file='button.tpl' btext=$lang_global.search blink='javascript:do_submit()' bwidth=80}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <form method="get" action="index.php" name="form1">
                        <input type="hidden" name="action" value="del_user" />
                        <input type="hidden" name="page" value="user" />
                        <input type="hidden" name="start" value="{$start}" />
                        <input type="hidden" name="backup_op" value="0"/>
                        <table class="lined">
                            <tr>
    {if $hasInsertPermission}
                                <th width="1%">
                                    <input name="allbox" type="checkbox" value="Check All" onclick="CheckAll(document.form1);" />
                                </th>
    {else}
                                <th width="1%"></th>
    {/if}
                                <th width="1%"><a href="index.php?page=user&order_by=id&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'id'}class="{$order_dir}"{/if}>{$lang_user.id}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=username&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'username'}class="{$order_dir}"{/if}>{$lang_user.username}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=gmlevel&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'gmlevel'}class="{$order_dir}"{/if}>{$lang_user.gm_level}</a></th>
    {if $expansion_select}
                                <th width="1%"><a href="index.php?page=user&order_by=expansion&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'expansion'}class="{$order_dir}{/if}>EXP</a></th>
    {/if}
                                <th width="1%"><a href="index.php?page=user&order_by=email&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'email'}class="{$order_dir}"{/if}>{$lang_user.email}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=joindate&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'joindate'}class="{$order_dir}"{/if}>{$lang_user.join_date}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=last_ip&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'last_ip'}class="{$order_dir}"{/if}>{$lang_user.ip}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=failed_logins&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'failed_logins'}class="{$order_dir}"{/if}>{$lang_user.failed_logins}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=locked&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'locked'}class="{$order_dir}"{/if}>{$lang_user.locked}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=last_login&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'last_login'}class="{$order_dir}"{/if}>{$lang_user.last_login}</a></th>
                                <th width="1%"><a href="index.php?page=user&order_by=online&amp;start={$start}{$search_link}&amp;dir={$dir}" {if $order_by eq 'online'}class="{$order_dir}"{/if}>{$lang_user.online}</a></th>
    {if $showcountryflag}
                                <th width="1%">{$lang_global.country}</th>
    {/if}
                            </tr>
    {foreach from=$data_array item=data}
        {if $hasEditPermission}
                            <tr>
            {if $hasInsertPermission}
                                <td><input type="checkbox" name="check[]" value="'.$data['id'].'" onclick="CheckCheckAll(document.form1);" /></td>
            {else}
                                <td></td>
            {/if}
                                    <td>{$data.id}</td>
                                <td>
                                    <a href="index.php?page=user&amp;action=edit_user&amp;error=11&amp;id={$data.id}">{$data.username}</a>
                                </td>
                                <td>{$data.gm_level_name}</td>
            {if $expansion_select}
                                <td>{$data.exp_lvl}</td>
            {/if}
            {if $hasUpdatePermission && $user_name eq $data.username}
                                <td><a href="mailto:{$data.email}">{$data.email_short}</a></td>
                                <td class="small">{$data.joindate}</td>
                                <td>{$data.last_ip}</td>
            {else}
                                <td>***@***.***</td>
                                <td class="small">{$data.joindate}</td>
                                <td>*******</td>
            {/if}
                                <td>{if $data.failed_logins}$data.failed_logins{else}-{/if}</td>
                                <td>{if $data.locked}{$lang_global.yes_low}{else}-{/if}</td>
                                <td class="small">{$data.last_login}</td>
                                <td>{if $data.online}<img src="img/up.gif" alt="" />{else}-{/if}</td>'
            {if $showcountryflag}
                                <td>{if $data.country_code}<img src="img/flags/{$data.country_code}.png" onmousemove="toolTip('{$data.country}', 'item_tooltip')" onmouseout="toolTip()" alt="" />{else}-{/if}</td>
            {/if}
                            </tr>
        {else}
                            <tr>
                                <td>*</td><td>***</td><td>You</td><td>Have</td><td>No</td>
                                <td class=\"small\">Permission</td><td>to</td><td>View</td><td>this</td><td>Data</td><td>***</td>
            {if $expansion_select}
                                <td>*</td>
            {/if}
            {if $showcountryflag}
                                <td>*</td>
            {/if}
                            </tr>
        {/if}
    {/foreach}
                            <tr>
                                <td colspan="{$colspan_special}" class="hidden" align="right" width="25%">
                                    {$pagination}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" align="left" class="hidden">
    {if $hasDeletePermission}
                                    {include file='button.tpl' btext=$lang_user.del_selected_users blink='javascript:do_submit(\'form1\',0)" type="wrn' bwidth=230}
    {/if}
                                </td>
                                <td colspan="{$colspan_special2}" align="right" class="hidden">{$lang_user.tot_acc} : {$all_record}</td>
                            </tr>
                        </table>
                    </form>
                    <br />
                </center>
{elseif $action eq 'do_deluser'}
                <center>
    {if $deleted_accs > 0}
                    <h1><font class="error">{$lang_user.total} <font color="blue">{$deleted_accs}</font> {$lang_user.acc_deleted}</font><br /></h1>
                    <h1><font class="error">{$lang_user.total} <font color="blue">{$deleted_chars}</font> {$lang_user.char_deleted}</font></h1>
    {else}
                    <h1><font class="error">{$lang_user.no_acc_deleted}</font></h1>
    {/if}
                    <br /><br />
                    <table class="hidden">
                        <tr>
                            <td>
                                {include file='button.tpl' btext=$lang_user.back_browsing blink='index.php?page=user' bwidth=230}
                            </td>
                        </tr>
                    </table>
                    <br />
                </center>
{elseif $action eq 'del_user'}
                <center>
                    <img src="img/warn_red.gif" width="48" height="48" alt="" />
                    <h1><font class="error">{$lang_global.are_you_sure}</font></h1>
                    <br />
                    <font class="bold">{$lang_user.acc_ids}: 
    {foreach from=$user_del_array item=user}
                        <a href="user.php?action=edit_user&amp;id={$user.id}" target="_blank">{$user.username}, </a>
    {/foreach}
                        <br />{$lang_global.will_be_erased}</font>
                        <br /><br />
                        <table width="300" class="hidden">
                            <tr>
                                <td>
                                    {include file='button.tpl' btext=$lang_global.yes blink=$do_del_link bwidth=130}
                                    {include file='button.tpl' btext=$lang_global.no blink='index.php?page=user" type="def' bwidth=130}
                                </td>
                            </tr>
                        </table>
                        <br />
                    </font>
                </center>
{elseif $action eq 'add_new'}
                <center>
                    <script type="text/javascript" src="libs/js/sha1.js"></script>
    {literal}
                    <script type="text/javascript">
                        // <![CDATA[
                          function do_submit_data ()
                          {
                            if (document.form.new_pass1.value != document.form.new_pass2.value)
                            {
                              alert('{$lang_user.nonidentical_passes}');
                              return;
                            }
                            else
                            {
                              document.form.pass.value = hex_sha1(document.form.new_user.value.toUpperCase()+':'+document.form.new_pass1.value.toUpperCase());
                              document.form.new_pass1.value = '0';
                              document.form.new_pass2.value = '0';
                              do_submit();
                            }
                          }
                        // ]]>
                    </script>
    {/literal}
                    <fieldset style="width: 550px;">
                        <legend>{$lang_user.create_new_acc}</legend>
                        <form method="get" action="index.php" name="form">
                            <input type="hidden" name="page" value="user" maxlength="256" />
                            <input type="hidden" name="pass" value="" maxlength="256" />
                            <input type="hidden" name="action" value="doadd_new" />
                            <table class="flat">
                                <tr>
                                    <td>{$lang_user.username}</td>
                                    <td><input type="text" name="new_user" size="24" maxlength="15" value="New_Account" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.password}</td>
                                    <td><input type="text" name="new_pass1" size="24" maxlength="25" value="123456" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.confirm}</td>
                                    <td><input type="text" name="new_pass2" size="24" maxlength="25" value="123456" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.email}</td>
                                    <td><input type="text" name="new_mail" size="24" maxlength="225" value="none@mail.com" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_user.locked}</td>
                                    <td><input type="checkbox" name="new_locked" value="1" /></td>
                                </tr>
    {if $expansion_select}
                                <tr>
                                    <td>{$lang_user.expansion_account}</td>
                                    <td>
                                        <select name="new_expansion">
                                            <option value="2">{$lang_user.wotlk}</option>
                                            <option value="1">{$lang_user.tbc}</option>
                                            <option value="0">{$lang_user.classic}</option>
                                        </select>
                                    </td>
                                </tr>
    {/if}
                                <tr>
                                    <td>
                                        {include file='button.tpl' btext=$lang_user.create_acc blink='javascript:do_submit_data()" type="wrn' bwidth=130}
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <br /><br />
                </center>
{elseif $action eq 'edit_user'}
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
{/if}