                <script type="text/javascript" src="libs/js/check.js"></script>
                <center>
                    <table class="top_hidden">
                        <tr>
                            <td>
{if $hasInsertPermission}
                                {include file='button.tpl' btext=$lang_spelld.add_spell blink='index.php?page=spelldisabled&action=add_new" type="wrn' bwidth=130}
{/if}
                                {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()' bwidth=130}
{if $isSearch}
                                {include file='button.tpl' btext=$lang_spelld.spell_list blink='index.php?page=spelldisabled' bwidth=130}
{/if}
                            </td>
                            <td align="right" width="25%">
                                {$pagination}
                            </td>
                        </tr>
                        <tr align="left">
                            <td rowspan="2">
                                <table class="hidden">
                                    <tr>
                                        <td>
                                            <form action="index.php" method="get" name="form">
                                                <input type="hidden" name="error" value="3" />
                                                <input type="hidden" name="page" value="spelldisabled" />
                                                <input type="text" size="24\" maxlength="64" name="search_value" value="{$search_value}" />
                                                {html_options name=search_by options=$search_by_select_arr selected=$search_by}
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
                    <input type="hidden" name="action" value="del_spell" />
                    <input type="hidden" name="page" value="spelldisabled" />
                    <input type="hidden" name="start" value="{$start}" />
                    <table class="lined">
                        <tr>
{if $hasDeletePermission}
                            <th width="1%"><input name="allbox" type="checkbox" value="Check All" onclick="CheckAll(document.form1);" /></th>
{else}
                            <th width="1%"></th>
{/if}
{foreach item=th_column from=$th_entries}
                            <th width="{$th_column.width}"><a href="{$th_column.link}" {$th_column.class}>{$th_column.text}</a></th>
{/foreach}
                        </tr>
{foreach item=spelld from=$spelld_array}
                        <tr>
{if $hasDeletePermission}
                            <td><input type="checkbox" name="check[]" value="{$spelld.entry}" onclick="CheckCheckAll(document.form1);" /></td>
{else}
                            <td></td>
{/if}
                            <td>{$spelld.entry}</td>
                            <td>{$spelld.flags}</td>
                            <td>{$spelld.comment}</td>
                        </tr>
{/foreach}
                            <td colspan="4" class="hidden" align="right" width="25%">
                                {$pagination2}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="hidden" align="left">
{if $hasDeletePermission}
                                {include file='button.tpl' btext=$lang_spelld.del_selected_spells blink='javascript:do_submit(\'form1\',0)" type="wrn' bwidth=180}
{/if}
                            </td>
                            <td colspan="2" class="hidden" align="right">{$lang_spelld.tot_spell} : {$all_record}</td>
                        </tr>
                    </table>
                </form>
                <br />
            </center>