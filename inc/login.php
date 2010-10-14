<?php error_reporting(E_ALL);
/**
 * Do the actual login
 *
 * @param: void
 */
function dologin()
{
    global $mmfpm_db, $require_account_verify, $sqlm, $sqla;

    if (empty($_POST['user']) || empty($_POST['pass']))
        redirect('&error=2', true);
    
    $user_name  = sanitize_paranoid_string($_POST['user']);
    $user_pass  = sanitize_paranoid_string($_POST['pass']);

    if (255 < strlen($user_name) || 255 < strlen($user_pass))
        redirect('&error=1', true);

    $result = $sqla->fetch("SELECT account.id, username, gmlevel FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE username = '%s' AND sha_pass_hash = '%s'",$user_name,$user_pass);
    if ($require_account_verify) 
    {
        $mm_result = $sqlm->fetch("SELECT * FROM mm_account WHERE username = '%s'",$user_name);
        if ($sqlm->num_rows() >= 1) 
            redirect('&error=7', true);
        unset($mm_result);
    }
    
    unset($user_name);

    if (1 == $sqla->num_rows())
    {
        $id = $result[0]->id;
        $banned_count = $sqla->fetch("SELECT id FROM account_banned WHERE id = '%d' AND active = '1'",$id);
        if ($sqla->num_rows())
            redirect('&error=3', true);
        else
        {
            $_SESSION['user_id'] = $id;
            $_SESSION['uname'] = $result[0]->username;
            if ($result[0]->gmlevel == null)
                $_SESSION['user_lvl'] = 0;
            else
                $_SESSION['user_lvl'] = $result[0]->gmlevel;
            $_SESSION['realm_id'] = sanitize_int($_POST['realm']);
            $_SESSION['client_ip'] = (isset($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : getenv('REMOTE_ADDR');
            $_SESSION['logged_in'] = true;
            if (isset($_POST['remember']) && $_POST['remember'] != '')
            {
                setcookie('uname', $_SESSION['uname'], time()+60*60*24*7);
                setcookie('realm_id', $_SESSION['realm_id'], time()+60*60*24*7);
                setcookie('p_hash', $user_pass, time()+60*60*24*7);
            }
            redirect('index.php?page=index');
        }
    }
    else
        redirect('&error=1', true);
}

/**
 * Print the login form.
 *
 * @param: void
 */
function login()
{
    global $lang_login, $characters_db, $server, $remember_me_checked, $smarty, $sqla;

    $smarty->assign('lang_login', $lang_login);
    $result = $sqla->fetch("SELECT id, name FROM realmlist LIMIT 10");

    if ($sqla->num_rows() > 1 && (count($server) > 1) && (count($characters_db) > 1))
    {
        $realms = array();
        foreach ($result as $realm)
            if (isset($server[$realm->id]))
                $realms[$realm->id] = sanitize_html_string($realm->name);
        
        $smarty->assign('multirealm', true);
        $smarty->assign('realms',$realms);
        $smarty->assign('selectedrealm', 1);
        
        unset($realms);
    }
    else
        $smarty->assign('selectedrealm',$result[0]->id);

    if ($remember_me_checked)
        $smarty->assign('remember_me_checked', true);

    $smarty->display('login_form.tpl');
    $smarty->clear_all_assign();
}

/**
 * Login via cookie
 *
 * @param: void
 */
function do_cookie_login()
{
    global $sqla;
    
    if (empty($_COOKIE['uname']) || empty($_COOKIE['p_hash']) || empty($_COOKIE['realm_id']))
        redirect('&error=2', true);

    $user_name = sanitize_paranoid_string($_COOKIE['uname']);
    $user_pass = sanitize_paranoid_string($_COOKIE['p_hash']);

    $result = $sqla->fetch("SELECT account.id, account.username, account_access.gmlevel FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE username = '%s' AND sha_pass_hash = '%s'",$user_name,$user_pass);

    unset($user_name);
    unset($user_pass);

    if ($sqla->num_rows())
    {
        $id = $result->id;
        $banned_count = $sqla->fetch("SELECT id FROM account_banned WHERE id = '%d' AND active = '1'",$id);
        if ($sqla->num_rows())
            redirect('index.php?page=login&error=3');
        else
        {
            $_SESSION['user_id']   = $id;
            $_SESSION['uname']     = $result->username;
            
            if ($result->gmlevel == null)
                $_SESSION['user_lvl']  = 0;
            else
                $_SESSION['user_lvl']  = $result->gmlevel;
                
            $_SESSION['realm_id']  = sanitize_int($_COOKIE['realm_id']);
            $_SESSION['client_ip'] = (isset($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : getenv('REMOTE_ADDR');
            $_SESSION['logged_in'] = true;
            redirect('index.php?page=index');
        }
    }
    else
    {
        setcookie (   'uname', '', time() - 3600);
        setcookie ('realm_id', '', time() - 3600);
        setcookie (  'p_hash', '', time() - 3600);
        redirect('&error=1', true);
    }
}

/**
 * Select which part of the code is to be executed
 *
 */
if (isset($_COOKIE["uname"]) && isset($_COOKIE["p_hash"]) && isset($_COOKIE["realm_id"]) && empty($_GET['error']))
    do_cookie_login();

$err = (isset($_GET['error'])) ? sanitize_int($_GET['error']) : NULL;
$lang_login = lang_login();

$errormsgs = array( 1 => $lang_login['bad_pass_user'],      2 => $lang_login['missing_pass_user'],
                    3 => $lang_login['banned_acc'],         5 => $lang_login['no_permision'],
                    6 => $lang_login['after_registration'], 7 => $lang_login['verify_required']);

if ($err)
{
    if (array_key_exists($err, $errormsgs))
        $smarty->assign('error',$errormsgs[$err]);
    else
        $smarty->assign('error',$lang_login['enter_valid_logon']);
        
    $smarty->display('error-small.tpl');
    $smarty->clear_all_assign();
}

$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

unset($err);

if ('dologin' === $action)
    dologin();
else
    login();

unset($lang_login);
?>
