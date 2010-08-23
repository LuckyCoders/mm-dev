<?php
    /**
     * Load config files  
     **/
    require('conf/config.dist.php');
    require('conf/config.php'); //If File not Found -> Error; config loading should be handled better later

    /**
     * Load libraries
     */
    require("libs/smarty/Smarty.class.php");
    require("libs/security/sanitize.lib.php");

    require_once("libs/get.lib.php");
    require("libs/session/session.lib.php"); //old mm session system. needs to be replaced
    require("libs/misc.lib.php");

    /**
     * Set some variables
     */
    $time_start = microtime(true); //page generation time
    $theme = get_theme(); //get.lib
    $lang = get_language(); //get.lib
    if (!$realm_id) //set in session.lib if user is logged in
        $realm_id = 1;
        
    /**
     * Prepare SQL stuff
     */
    require("libs/database/mysql.lib.php");
    
    $sqlm = new MySQL($mmfpm_db);
    $sqla = new MySQL($auth_db);
    $sqlw = new MySQL($world_db[$realm_id]);
    $sqlc = new MySQL($characters_db[$realm_id]);
    
    /**
     * Prepare SOAP
     */
    if (!empty($server[$realm_id]['soap_user']) && !empty($server[$realm_id]['soap_pass']))
    {
        require("libs/soap/tcsoap.lib.php");
    
        $soapTC = new TCSoap($server[$realm_id]);
    }
     
    /**
     * Load language
     */
    require('lang/'.$lang.'.php');

    /**
     * Initialize libraries
     */
    $smarty = new Smarty;
    $smarty->template_dir = 'templates/'.$theme;
    $smarty->compile_dir = 'tmp/smarty_c';
    $smarty->cache_dir = 'tmp/cache';
    $smarty->error_reporting = E_ALL  & ~E_NOTICE;
    
    /**
     * Display header & menu
     */
    ob_start();
    include("header.php");
    include("menu.php");
    
    /**
     * Display content
     * 
     * Get page from $_GET and include it
     */
    $page = 'index'; //default page
    if (isset($_GET['page']))
        if (file_exists('inc/'.sanitize_paranoid_string($_GET['page']).'.php'))
            $page = sanitize_paranoid_string($_GET['page']);
        
    include('inc/'.$page.'.php');
        
    /**
     * Display footer
     */
    include("footer.php");
    ob_end_flush();
?>