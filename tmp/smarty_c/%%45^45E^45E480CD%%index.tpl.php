<?php /* Smarty version 2.6.26, created on 2010-08-03 13:08:36
         compiled from index.tpl */ ?>
                <div class="top">
<?php if ($this->_tpl_vars['online']): ?>
                    <div id="uptime">
                        <h1>
                            <font color="#55aa55"><?php echo $this->_tpl_vars['staticUptime']; ?>
<br /><?php echo $this->_tpl_vars['lang_index']['maxplayers']; ?>
: <?php echo $this->_tpl_vars['maxplayers']; ?>
</font>
                        </h1>
                    </div>
<?php else: ?>
                    <h1>
                        <font class="error"><?php echo $this->_tpl_vars['lang_index']['realm']; ?>
 <em><?php echo $this->_tpl_vars['realmname']; ?>
</em> <?php echo $this->_tpl_vars['lang_index']['offline_or_let_high']; ?>
</font>
                    </h1>
<?php endif; ?>
                    <?php echo $this->_tpl_vars['lang_index']['trinity_rev']; ?>
 <?php echo $this->_tpl_vars['version']['core_revision']; ?>
 <?php echo $this->_tpl_vars['lang_index']['using_db']; ?>
 <?php echo $this->_tpl_vars['version']['db_version']; ?>

                </div>
<?php if ($this->_tpl_vars['hasDeletePermission']): ?>
                <script type="text/javascript">
                    // <![CDATA[
                        answerbox.btn_ok="<?php echo $this->_tpl_vars['lang_global']['yes_low']; ?>
";
                        answerbox.btn_cancel="<?php echo $this->_tpl_vars['lang_global']['no']; ?>
";
                        var del_motd = "index.php?page=motd&amp;action=delete_motd&amp;id=";
                    // ]]>
                </script>
<?php endif; ?>
                <center>
                    <table class="lined">
                        <tr>
                            <th align="right">
<?php if ($this->_tpl_vars['hasInsertPermission']): ?>
                                <a href="motd.php?action=add_motd"><?php echo $this->_tpl_vars['lang_index']['add_motd']; ?>
</a>
<?php endif; ?>
                            </th>
                        </tr>
<?php if ($this->_tpl_vars['motdnum'] > 0): ?>
    <?php $_from = $this->_tpl_vars['motds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <tr>
                            <td align="left" class="large">
                                <blockquote><?php echo $this->_tpl_vars['item']['content']; ?>
</blockquote>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <?php echo $this->_tpl_vars['item']['type']; ?>

        <?php if ($this->_tpl_vars['hasDeletePermission']): ?>
                                <img src="img/cross.png" width="12" height="12" onclick="answerBox(\'<?php echo $this->_tpl_vars['lang_global']['delete']; ?>
: &lt;font color=white&gt;<?php echo $this->_tpl_vars['item']['id']; ?>
&lt;/font&gt;&lt;br /&gt;<?php echo $this->_tpl_vars['lang_global']['are_you_sure']; ?>
\', del_motd + <?php echo $this->_tpl_vars['item']['id']; ?>
);" style="cursor:pointer;" alt="" />
        <?php endif; ?>
        <?php if ($this->_tpl_vars['hasUpdatePermission']): ?>
                                <a href="index.php?page=motd&amp;action=edit_motd&amp;error=3&amp;id=<?php echo $this->_tpl_vars['item']['id']; ?>
">
                                    <img src="img/edit.png" width="14" height="14" alt="" />
                                </a>
        <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="hidden"></td>
                        </tr>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['online']): ?>
                        <tr>
                            <td align="right" class="hidden"><?php echo $this->_tpl_vars['pagination_motd_on']; ?>
</td>
                        </tr>
<?php else: ?>
                        <tr>
                            <td align="right" class="hidden"><?php echo $this->_tpl_vars['pagination_motd_off']; ?>
</td>
                        </tr>
<?php endif; ?>
                    </table>
                    <font class="bold"><?php echo $this->_tpl_vars['lang_index']['tot_users_online']; ?>
: <?php echo $this->_tpl_vars['total_online']; ?>
</font>
                    <table class="lined">
                        <tr>
                            <td colspan="<?php echo $this->_tpl_vars['countryflag_colspan']; ?>
" align="right" class="hidden" width="25%">
                                <?php echo $this->_tpl_vars['pagination_char1']; ?>

                            </td>
                        </tr>
                        <tr>
                            <th width="15%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=name&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === 'name'): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['name']; ?>
</a></th>
                            <th width="1%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=race&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === 'race'): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['race']; ?>
</a></th>
                            <th width="1%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=class&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === 'class'): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['class']; ?>
</a></th>
                            <th width="5%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=level&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === 'level'): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['level']; ?>
</a></th>
                            <th width="1%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=totalHonorPoints&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === 'totalHonorPoints'): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['rank']; ?>
</a></th>
                            <th width="15%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=guildid&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === 'guildid'): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['guild']; ?>
</a></th>
                            <th width="20%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=map&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === $this->_tpl_vars['order_dir_mapzone']): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['map']; ?>
</a></th>
                            <th width="25%"><a href="index.php?start=<?php echo $this->_tpl_vars['start']; ?>
&amp;start_m=<?php echo $this->_tpl_vars['start_m']; ?>
&amp;order_by=zone&amp;dir=<?php echo $this->_tpl_vars['dir']; ?>
" <?php if ($this->_tpl_vars['order_by'] === $this->_tpl_vars['order_dir_zonemap']): ?> class="<?php echo $this->_tpl_vars['order_dir']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang_index']['zone']; ?>
</a></th>
<?php if ($this->_tpl_vars['showCountry']): ?>
                            <th width="1%"><?php echo $this->_tpl_vars['lang_global']['country']; ?>
</th>
<?php endif; ?>
                        </tr>
<?php if ($this->_tpl_vars['charsnum'] > 0): ?>
    <?php $_from = $this->_tpl_vars['chars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['char']):
?>
                            <tr>
                                <td>
        <?php if ($this->_tpl_vars['isGameMaster']): ?>
                                    <a href="index.php?page=char&amp;id=<?php echo $this->_tpl_vars['char']['guid']; ?>
">
                                        <span onmousemove="toolTip(\'<?php echo $this->_tpl_vars['char']['gmlevel_name']; ?>
\', \'item_tooltip\')" onmouseout="toolTip()"><?php echo $this->_tpl_vars['char']['charname']; ?>
</span>
                                    </a>
        <?php else: ?>
                                    <span onmousemove="toolTip(\'<?php echo $this->_tpl_vars['char']['gmlevel_name']; ?>
\', \'item_tooltip\')" onmouseout="toolTip()"><?php echo $this->_tpl_vars['char']['charname']; ?>
</span>
        <?php endif; ?>
                                </td>
                                <td>
                                    <img src="img/c_icons/<?php echo $this->_tpl_vars['char']['race']; ?>
-<?php echo $this->_tpl_vars['char']['gender']; ?>
.gif" onmousemove="toolTip(\'<?php echo $this->_tpl_vars['char']['racename']; ?>
\', \'item_tooltip\')" onmouseout="toolTip()" alt="" />
                                </td>
                                <td>
                                    <img src="img/c_icons/<?php echo $this->_tpl_vars['char']['class']; ?>
.gif" onmousemove="toolTip(\'<?php echo $this->_tpl_vars['char']['classname']; ?>
\', \'item_tooltip\')" onmouseout="toolTip()" alt="" />
                                </td>
                                <td><?php echo $this->_tpl_vars['char']['levelcolor']; ?>
</td>
                                <td>
                                    <span onmouseover="toolTip(\'<?php echo $this->_tpl_vars['char']['pvprankname']; ?>
\', \'item_tooltip\')" onmouseout="toolTip()" style="color: white;"><img src="img/ranks/rank<?php echo $this->_tpl_vars['char']['pvprank']; ?>
.gif" alt="" /></span>
                                </td>
                                <td>
                                    <a href="guild.php?action=view_guild&amp;error=3&amp;id=<?php echo $this->_tpl_vars['char']['guildid']; ?>
"><?php echo $this->_tpl_vars['char']['guildname']; ?>
</a>
                                </td>
                                <td><span onmousemove="toolTip(\'MapID:<?php echo $this->_tpl_vars['char']['map']; ?>
\', \'item_tooltip\')" onmouseout="toolTip()"><?php echo $this->_tpl_vars['char']['mapname']; ?>
</span></td>
                                <td><span onmousemove="toolTip(\'ZoneID:<?php echo $this->_tpl_vars['char']['zone']; ?>
\', \'item_tooltip\')" onmouseout="toolTip()"><?php echo $this->_tpl_vars['char']['zonename']; ?>
</span></td>
    <?php if ($this->_tpl_vars['showCountry']): ?>
                                <td><?php echo $this->_tpl_vars['char']['country']; ?>
</td>
    <?php endif; ?>
                            </tr>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
                        <tr>
                            <td colspan="<?php echo $this->_tpl_vars['countryflag_colspan']; ?>
" align="right" class="hidden" width="25%">
                                <?php echo $this->_tpl_vars['paginaton_char2']; ?>

                            </td>
                        </tr>
                    </table>
                    <br />
                </center>