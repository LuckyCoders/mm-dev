<?php
//to do
    require_once("libs/get.lib.php");
    // resuming login session if available, or start new one
    if (ini_get('session.auto_start'));
    else 
        session_start();

    //---------------------Guest login Predefines----------------------------------
    if ($allow_anony && empty($_SESSION['logged_in']))
    {
        $_SESSION['user_lvl'] = -1;
        $_SESSION['uname'] = $anony_uname;
        $_SESSION['user_id'] = -1;
        $_SESSION['realm_id'] = $anony_realm_id;
        $_SESSION['client_ip'] = ( isset($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : getenv('REMOTE_ADDR');
    }
    
    if (isset($_SESSION['user_lvl']) && isset($_SESSION['uname']) && isset($_SESSION['realm_id']) && empty($_GET['err']))
    {
        // check for host php script max memory allowed,
        // setting it higher if it is not enough for MiniManager to run
        if (ini_get('memory_limit') < 16)
            @ini_set('memory_limit', '16M');

        // resuming logged in user settings
        session_regenerate_id();
        $user_lvl = sanitize_int($_SESSION['user_lvl']);
        $user_name = sanitize_paranoid_string($_SESSION['uname']);
        $user_id = sanitize_int($_SESSION['user_id']);
        $realm_id = ( isset($_GET['r_id']) ) ? sanitize_int($_GET['r_id']) : sanitize_int($_SESSION['realm_id']);
        // for MiniManager security system, getting the users' account group name
        $user_lvl_name = id_get_gm_level($user_lvl);

        // get the file name that called this header
        $array = explode ( '/', $_SERVER['PHP_SELF']);
        $lookup_file = $array[sizeof($array)-1];
        unset($array);
        
        //set the momentarily relative scriptname with args
        $current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
?>