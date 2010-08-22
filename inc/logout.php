<?php error_reporting(E_ALL);
    session_destroy();
    unset($_SESSION['user_id']);
    unset($_SESSION['uname']);
    unset($_SESSION['user_lvl']);
    unset($_SESSION['realm_id']);
    unset($_SESSION['client_ip']);
    unset($_SESSION['logged_in']);

    setcookie ('uname',    '', time() - 3600);
    setcookie ('realm_id', '', time() - 3600);
    setcookie ('p_hash',   '', time() - 3600);

    redirect('index.php?page=login');
?>
