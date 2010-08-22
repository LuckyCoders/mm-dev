<?php
    if (!isset($debug))
        error_reporting('E_NONE'); // fuck this, we need a real fix

    if ($debug > 2) //unset sql instances for debug output
    {
        unset($sql);
        unset($sqla);
        unset($sqlc);
        unset($sqlm);
        unset($sqlw);
    }

    // show login and register button at bottom of every page if guest mode is activated
    if ($allow_anony && empty($_SESSION['logged_in']))
    {
        $smarty->assign('isGuest',true);
        unset($lang_login);
        unset($allow_anony);
    }
    
    $lang_footer = lang_footer();
    
    $smarty->assign('lang_footer',$lang_footer);
    $smarty->assign('admin_mail',$admin_mail);
    $smarty->assign('execution_time',round(((microtime(true) - $time_start)/1000),5).'ms');
    $smarty->assign('debug',$debug);
    
    // if any debug mode is activated, show memory usage
    $memory = ((function_exists('memory_get_usage')) ? sprintf('<br />Mem. Usage: %.0f/%.0fK Peek: %.0f/%.0fK Global: %.0fK Limit: %s',memory_get_usage()/1024, memory_get_usage(true)/1024,memory_get_peak_usage()/1024,memory_get_peak_usage(true)/1024,sizeof($GLOBALS),ini_get('memory_limit')) : '');
    $smarty->assign('memory',$memory);

    unset($lang_footer);
    unset($admin_mail);
    unset($time_start);

    if(2 < $debug)
    {
        $smarty->assign('debug_defined_vars',print_r(get_defined_vars(),true));

        // debug mode 3 lists all global vars and their values, but not for arrays
        // debug mode 4 branches all arrays and their content,
        if(3 < $debug)
            $smarty->assign('debug_globals',print_r($GLOBALS,true));
    }

    $smarty->display('footer.tpl');
    $smarty->clear_all_assign();
?>
