        <center>
            <table class="top_hidden">
                <tr>
                    <td width="80%">
                        <form action="index.php?page=ahstats" method="get" name="form">
                        <input type="hidden" name="page" value="{$smarty.get.page}" />
                        <input type="hidden" name="error" value="2" />
                            <table class="hidden">
                                <tr>
                                    <td>
                                        <input type="text" size="24" name="search_value" value="{$search_value}" />
                                    </td>
                                    <td>
{html_options name=search_by options=$search_by_select selected=$search_by_selected}
                                    </td>
                                    <td>
{html_options name=search_class options=$search_class_select selected=$search_class_selected}
                                    </td>
                                    <td>
{html_options name=search_quality options=$search_quality_select selected=$search_quality_selected}
                                    </td>
                                    <td>
{include file='button.tpl' btext=$lang_global.search blink='javascript:do_submit()' bwidth=80}
                                    </td>
                                    <td>
{if $showBackBtn}
    {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()' bwidth=80}
{/if}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                    <td width="25%" align="right">
                        {$pagination1}
                    </td>
                </tr>
            </table>
            <table class="lined">
                <tr>
{foreach from=$ahstats_search item=foo}
                    <th width="{$foo.width}"><a href="{$foo.link}">{$foo.arrow}{$foo.name}</a></th>
{/foreach}
                </tr>
{foreach from=$dataset item=data}
                <tr>
    {foreach from=$data item=value}
                    <td>
                        <center>{$value}</center>
                    </td>
    {/foreach}
                </tr>
{/foreach}
                <tr>
                    <td  colspan=\"7\" class=\"hidden\" align=\"right\" width=\"25%\">
                        {$pagination2}
                    </td>
                </tr>
                <tr>
                    <td colspan=\"7\" class=\"hidden\" align=\"right\">{$lang_total_auctions} : {$all_record}
                    </td>
                </tr>
            </table>
        </center>