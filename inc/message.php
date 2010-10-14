<?php

function main()
{
    global $lang_global, $lang_message, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
    
    $smarty->assign('action', 'show_form');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_message', $lang_message);
    
    $smarty->display('message.tpl');
    $smarty->clear_all_assign();
}

function check()
{
    global $soapTC;

    if ($soapTC)
        redirect('index.php?page=message&action=main');
    else
        redirect('index.php?page=message&action=result&mess=You%20need%20to%20enable%20SOAP!');
}

function send()
{
    global $lang_telnet, $lang_message, $soapTC;

    if (!getPermission('insert'))
        redirect('index.php?page=login&error=5');
    
    if (empty($_POST['msg'])) 
        redirect('index.php?page=message&action=result&mess='.$lang_message['empty_fields']);

    $type = (isset($_POST['type'])) ? sanitize_int($_POST['type']) : 3;
    if ($type<4 || $type>0); 
    else 
        $type = 3;

    $msg = sanitize_html_string($_POST['msg']);
    if (4096 < strlen($msg))
        redirect('index.php?page=message&action=result&mess='.$lang_message['message_too_long'].'');

    if ($soapTC)
    {
        $mess_str = '';
        if ($type == 1 || $type == 3)
        {
            print $soapTC->fetch("announce %s",$msg);
            $mess_str .= $lang_message['system_message'].': "'.$msg.'" '.$lang_message['sent'];
        }
        
        if ($type == 3)
            $mess_str .= '<br /><br />';
            
        if ($type == 2 || $type == 3)
        {
            $soapTC->fetch("notify %s",$msg);
            $mess_str .= $lang_message['global_notify'].': "'.$msg.'" '.$lang_message['sent'];
        }
    }
    else
        redirect('index.php?page=message&action=result&mess=You%20need%20to%20enable%20SOAP!');
    redirect('index.php?page=message&action=result&mess='.urlencode($mess_str));
}

function result()
{
    global $lang_global, $lang_message, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
        
    $mess = (isset($_GET['mess'])) ? sanitize_html_string($_GET['mess']) : "";

    $smarty->assign('action', 'show_result');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_message', $lang_message);
    $smarty->assign('mess', $mess);
    
    $smarty->display('message.tpl');
    $smarty->clear_all_assign();
}

$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

$lang_message = lang_message();
$lang_telnet = lang_telnet();

switch ($action)
{
    case "send":
        send();
        break;
        
    case "result":
        result();
        break;
        
    case "main":
        main();
        break;
        
    default:
        check();
}

unset($lang_telnet);
unset($lang_message);

?>
