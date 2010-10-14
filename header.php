<?php
    //---------------------Headers' header-----------------------------------------
    // sets encoding defined in config for language support
    header('Content-Type: text/html; charset='.$site_encoding);
    header('Expires: Tue, 01 Jan 2000 00:00:00 GMT');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    
    $smarty->assign('title',$title);
    $smarty->assign('site_encoding',$site_encoding);
    $smarty->assign('theme',$theme);
    
    if ($tt_lang)
        $smarty->assign('show_wowhead', true);
    
    $smarty->display('header.tpl');
    $smarty->clear_all_assign();
?>
