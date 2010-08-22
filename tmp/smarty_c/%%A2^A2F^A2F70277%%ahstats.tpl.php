<?php /* Smarty version 2.6.26, created on 2010-08-05 20:09:28
         compiled from ahstats.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'ahstats.tpl', 14, false),)), $this); ?>
        <center>
            <table class="top_hidden">
                <tr>
                    <td width="80%">
                        <form action="index.php?page=ahstats" method="get" name="form">
                        <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>
" />
                        <input type="hidden" name="error" value="2" />
                            <table class="hidden">
                                <tr>
                                    <td>
                                        <input type="text" size="24" name="search_value" value="<?php echo $this->_tpl_vars['search_value']; ?>
" />
                                    </td>
                                    <td>
<?php echo smarty_function_html_options(array('name' => 'search_by','options' => $this->_tpl_vars['search_by_select'],'selected' => $this->_tpl_vars['search_by_selected']), $this);?>

                                    </td>
                                    <td>
<?php echo smarty_function_html_options(array('name' => 'search_class','options' => $this->_tpl_vars['search_class_select'],'selected' => $this->_tpl_vars['search_class_selected']), $this);?>

                                    </td>
                                    <td>
<?php echo smarty_function_html_options(array('name' => 'search_quality','options' => $this->_tpl_vars['search_quality_select'],'selected' => $this->_tpl_vars['search_quality_selected']), $this);?>

                                    </td>
                                    <td>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['search'],'blink' => 'javascript:do_submit()','bwidth' => 80)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                    </td>
                                    <td>
<?php if ($this->_tpl_vars['showBackBtn']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'button.tpl', 'smarty_include_vars' => array('btext' => $this->_tpl_vars['lang_global']['back'],'blink' => 'javascript:window.history.back()','bwidth' => 80)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                    <td width="25%" align="right">
                        <?php echo $this->_tpl_vars['pagination1']; ?>

                    </td>
                </tr>
            </table>
            <table class="lined">
                <tr>
<?php $_from = $this->_tpl_vars['ahstats_search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['foo']):
?>
                    <th width="<?php echo $this->_tpl_vars['foo']['width']; ?>
"><a href="<?php echo $this->_tpl_vars['foo']['link']; ?>
"><?php echo $this->_tpl_vars['foo']['arrow']; ?>
<?php echo $this->_tpl_vars['foo']['name']; ?>
</a></th>
<?php endforeach; endif; unset($_from); ?>
                </tr>
<?php $_from = $this->_tpl_vars['dataset']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                <tr>
    <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value']):
?>
                    <td>
                        <center><?php echo $this->_tpl_vars['value']; ?>
</center>
                    </td>
    <?php endforeach; endif; unset($_from); ?>
                </tr>
<?php endforeach; endif; unset($_from); ?>
                <tr>
                    <td  colspan=\"7\" class=\"hidden\" align=\"right\" width=\"25%\">
                        <?php echo $this->_tpl_vars['pagination2']; ?>

                    </td>
                </tr>
                <tr>
                    <td colspan=\"7\" class=\"hidden\" align=\"right\"><?php echo $this->_tpl_vars['lang_total_auctions']; ?>
 : <?php echo $this->_tpl_vars['all_record']; ?>

                    </td>
                </tr>
            </table>
        </center>