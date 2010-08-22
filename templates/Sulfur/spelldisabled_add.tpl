                <center>
                    <fieldset style="width: 550px;">
                        <legend>{$lang_spelld.add_new_spell}</legend>
                        <form method="get" action="index.php" name="form">
                            <input type="hidden" name="action" value="doadd_new" />
                            <input type="hidden" name="page" value="spelldisabled" />
                            <table class="flat">
                                <tr>
                                    <td>{$lang_spelld.entry2}</td>
                                    <td><input type="text" name="entry" size="24" maxlength="11" value="" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_spelld.flags2}</td>
                                    <td><input type="text" name="flags" size="24" maxlength="8" value="" /></td>
                                </tr>
                                <tr>
                                    <td>{$lang_spelld.comment2}</td>
                                    <td><input type="text" name="comment" size="24" maxlength="64" value="" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        {include file='button.tpl' btext=$lang_spelld.add_spell blink='javascript:do_submit()" type="wrn' bwidth=130}
                                    </td>
                                    <td>
                                        {include file='button.tpl' btext=$lang_global.back blink='javascript:window.history.back()" type="def' bwidth=130}
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                    <fieldset style="width: 440px;">
                        <table class="hidden">
                            <tr>
                                <td>
                                    {$lang_spelld.dm_exp}
                                </td>
                            </tr>
                        </table>
                        <br />
                        <table class="flat" border="2" cellpadding="4" cellspacing="2">
                            <tr>
                                <th>{$lang_spelld.value}</th>
                                <th>{$lang_spelld.type}</th>
                            </tr>
                            <tr>
                                <td align="center">0</td>
                                <td>{$lang_spelld.enabled}</td>
                            </tr>
                            <tr>
                                <td align="center">1</td>
                                <td>{$lang_spelld.disabled_p}</td>
                            </tr>
                            <tr>
                                <td align="center">2</td>
                                <td>{$lang_spelld.disabled_crea_npc}</td>
                            </tr>
                            <tr>
                                <td align="center">4</td>
                                <td>{$lang_spelld.disabled_pets}</td>
                            </tr>
                        </table>
                        <table class="hidden">
                            <tr>
                                <td>
                                <br />
                                    {$lang_spelld.combinations_hint}
                                </td>
                            </tr>
                        </table>
                        <table class="flat" border="2" cellpadding="4" cellspacing="2">
                            <tr>
                                <th>{$lang_spelld.value}</th>
                                <th>{$lang_spelld.type}</th>
                            </tr>
                            <tr>
                                <td align="center">3</td>
                                <td>{$lang_spelld.disabled_p_crea_npc}</td>
                            </tr>
                            <tr>
                                <td align="center">5</td>
                                <td>{$lang_spelld.disabled_p_pets}</td>
                            </tr>
                            <tr>
                                <td align="center">6</td>
                                <td>{$lang_spelld.disabled_crea_npc_pets}</td>
                            </tr>
                            <tr>
                                <td align="center">7</td>
                                <td>{$lang_spelld.disabled_p_crea_npc_pets}</td>
                            </tr>
                        </table>
                    </fieldset>
                    <br />
                </center>