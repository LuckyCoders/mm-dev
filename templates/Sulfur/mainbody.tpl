    <body onload="dynamicLayout();">
        <center>
            <table class="table_top">
                <tr>
                    <td class="table_top_left" valign="top">
{* check if user is logged in *}
{if $isLoggedIn}
    {* top menu *}
                        <div id="menuwrapper">
                            <ul id="menubar">
    {foreach item=branch from=$topmenu}
                                <li><a href="{$branch.link}">{$branch.name}</a>
                                    <ul>
        {foreach item=item from=$branch.items}
                                        <li><a href="{$item.filename}">{$item.name}</a></li>
        {/foreach}
                                    </ul>
                                </li>
    {/foreach}
                            </ul>
                            <br class="clearit" />
                        </div>
                    </td>
                    <td class="table_top_middle">
                        <div id="username">{$user_name}&nbsp;.:{$user_lvl_name}&#039;s {$lang_header_menu}:.</div>
                    </td>
                    <td class="table_top_right"></td>
                </tr>
            </table>
    {if $showVersion}
        <div id="version">{$version}</div>
    {/if}
{else}
                    </td>
                    <td class="table_top_middle"></td>
                    <td class="table_top_right"></td>
                </tr>
            </table>
{/if}
{* start of body *}
        <div id="body_main">
            <div class="bubble">
