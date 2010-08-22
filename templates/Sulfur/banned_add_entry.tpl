        <center>
            <fieldset class="half_frame">
                <legend>{$lang_banned.ban_entry}</legend>
                <form method="get" action="index.php" name="form">
                    <input type="hidden" name="action" value="do_add_entry" />
                    <input type="hidden" name="page" value="banned" />
                    <table class="flat">
                        <tr>
                            <td>{$lang_banned.ban_type}</td>
                            <td>
                                <select name="ban_type">
                                    <option value="ip_banned" >{$lang_banned.ip}</option>
                                    <option value="account_banned" >{$lang_banned.account}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>{$lang_banned.entry}</td>
                            <td>
                                <input type="text" name="entry" size="24" maxlength="20" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>{$lang_banned.ban_time}</td>
                            <td>
                                <input type="text" name="bantime" size="24" maxlength="40" value="1" />
                            </td>
                        </tr>
                        <tr>
                            <td>{$lang_banned.banreason}</td>
                            <td>
                                <input type="text" name="banreason" size="24" maxlength="255" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {include file='button.tpl' btext=$lang_banned.ban_entry blink='javascript:do_submit()" type="wrn' bwidth=180}
                            </td>
                            <td>
                                {include file='button.tpl' btext=$lang_global.back blink='index.php?page=banned" type="def' bwidth=130}
                            </td>
                        </tr>
                    </table>
                </form>
            </fieldset>
            <br/><br/>
        </center>