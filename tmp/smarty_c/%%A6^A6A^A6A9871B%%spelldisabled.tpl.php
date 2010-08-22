<?php /* Smarty version 2.6.26, created on 2010-08-21 18:21:24
         compiled from spelldisabled.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'spelldisabled.tpl', 27, false),)), $this); ?>
                <script type="text/javascript" src="libs/js/check.js"></script>
                <center>
                    <table class="top_hidden">
                        <tr>
                            <td>
<?php if ($this->_tpl_vars['hasInsertPermission']): ?>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_spelld']['add_spell'],'blink' => 'index.php?page=spelldisabled&action=add_new" type="wrn','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['back'],'blink' => 'javascript:window.history.back()','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['isSearch']): ?>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_spelld']['spell_list'],'blink' => 'index.php?page=spelldisabled','bwidth' => 130)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
                            </td>
                            <td align="right" width="25%">
                                <?php echo $this->_tpl_vars['pagination']; ?>

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
                                                <input type="text" size="24\" maxlength="64" name="search_value" value="<?php echo $this->_tpl_vars['search_value']; ?>
" />
                                                <?php echo smarty_function_html_options(array('name' => 'search_by','options' => $this->_tpl_vars['search_by_select_arr'],'selected' => $this->_tpl_vars['search_by']), $this);?>

                                            </form>
                                        </td>
                                    <td>
                                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['search'],'blink' => 'javascript:do_submit()','bwidth' => 80)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <form method="get" action="index.php" name="form1">
                    <input type="hidden" name="action" value="del_spell" />
                    <input type="hidden" name="page" value="spelldisabled" />
                    <input type="hidden" name="start" value="<?php echo $this->_tpl_vars['start']; ?>
" />
                    <table class="lined">
                        <tr>
<?php if ($this->_tpl_vars['hasDeletePermission']): ?>
                            <th width="1%"><input name="allbox" type="checkbox" value="Check All" onclick="CheckAll(document.form1);" /></th>
<?php else: ?>
                            <th width="1%"></th>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['th_entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['th_column']):
?>
                            <th width="<?php echo $this->_tpl_vars['th_column']['width']; ?>
"><a href="<?php echo $this->_tpl_vars['th_column']['link']; ?>
" <?php echo $this->_tpl_vars['th_column']['class']; ?>
><?php echo $this->_tpl_vars['th_column']['text']; ?>
</a></th>
<?php endforeach; endif; unset($_from); ?>
                        </tr>
<?php $_from = $this->_tpl_vars['spelld_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['spelld']):
?>
                        <tr>
<?php if ($this->_tpl_vars['hasDeletePermission']): ?>
                            <td><input type="checkbox" name="check[]" value="<?php echo $this->_tpl_vars['spelld']['entry']; ?>
" onclick="CheckCheckAll(document.form1);" /></td>
<?php else: ?>
                            <td></td>
<?php endif; ?>
                            <td><?php echo $this->_tpl_vars['spelld']['entry']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['spelld']['flags']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['spelld']['comment']; ?>
</td>
                        </tr>
<?php endforeach; endif; unset($_from); ?>
                            <td colspan="4" class="hidden" align="right" width="25%">
                                <?php echo $this->_tpl_vars['pagination2']; ?>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="hidden" align="left">
<?php if ($this->_tpl_vars['hasDeletePermission']): ?>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_spelld']['del_selected_spells'],'blink' => 'javascript:do_submit(\'form1\',0)" type="wrn','bwidth' => 180)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
                            </td>
                            <td colspan="2" class="hidden" align="right"><?php echo $this->_tpl_vars['lang_spelld']['tot_spell']; ?>
 : <?php echo $this->_tpl_vars['all_record']; ?>
</td>
                        </tr>
                    </table>
                </form>
                <br />
            </center>