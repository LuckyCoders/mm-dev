<?php
require_once("libs/mailer/class.phpmailer.php");

//#####################################################################################################
// DO EMAIL VERIFICATION
//#####################################################################################################
function do_verify_email($user_name, $pass, $to_mail, $authkey) {
    global $from_mail, $title, $mailer_type, $smtp_cfg;
    
    $mail2 = new PHPMailer();
    $mail2->Mailer = $mailer_type;
    
    if ($mailer_type == "smtp")
    {
        $mail2->Host = $smtp_cfg['host'];
        $mail2->Port = $smtp_cfg['port'];
        $mail2->SMTP_sec = $smtp_cfg['sec'];
        
        if($smtp_cfg['user'] != '') {
            $mail2->SMTPAuth  = true;
            $mail2->Username  = $smtp_cfg['user'];
            $mail2->Password  =  $smtp_cfg['pass'];
        }
    }

    $file_name = "templates/_mail/mail_verify.tpl";
    $fh = fopen($file_name, 'r');
    $subject = fgets($fh, 4096);
    $body = fread($fh, filesize($file_name));
    fclose($fh);

    $subject = str_replace("<title>", $title, $subject);
    $body = str_replace("\n", "<br />", $body);
    $body = str_replace("\r", " ", $body);
    $body = str_replace("<username>", $user_name, $body);
    $body = str_replace("<password>", $pass, $body);
    $body = str_replace("<base_url>", $_SERVER['SERVER_NAME'], $body);
    $body = str_replace("<verifyurl>", "http://".$_SERVER['HTTP_HOST'].str_replace("index.php","index.php?page=register&action=verify", $_SERVER['SCRIPT_NAME'])."&username=".$user_name."&authkey=".$authkey, $body);
            
    $mail2->WordWrap = 50;
    $mail2->From = $from_mail;
    $mail2->FromName = $title." Admin";
    $mail2->Subject = $subject;
    $mail2->IsHTML(true);
    $mail2->Body = $body;
    $mail2->AddAddress($to_mail);

    if(!$mail2->Send()) 
    {
        $mail2->ClearAddresses();
        redirect("index.php?page=register&err=11&usr=".$mail2->ErrorInfo);
    } 
    else
        return "Excellent job!";
}
//#####################################################################################################
// DO REGISTER
//#####################################################################################################
function doregister() {
    global $lang_global, $realm_id, $disable_acc_creation, $limit_acc_per_ip, $valid_ip_mask, $expansion_select, $send_mail_on_creation, $create_acc_locked, 
           $from_mail, $mailer_type, $smtp_cfg, $title, $defaultoption, $require_account_verify, $sqla, $sqlm;

    if (($_POST['security_code']) != ($_SESSION['security_code']))
        redirect("index.php?page=register&err=13");

    if (empty($_POST['pass']) || empty($_POST['email']) || empty($_POST['username']))
        redirect("index.php?page=register&err=1");

    if ($disable_acc_creation) 
        redirect("index.php?page=register&err=4");

    $last_ip = (getenv('HTTP_X_FORWARDED_FOR')) ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR');

    if (sizeof($valid_ip_mask))
    {
        $qFlag = 0;
        $user_ip_mask = explode('.', $last_ip);

        foreach($valid_ip_mask as $mask)
        {
            $vmask = explode('.', $mask);
            $v_count = 4;
            $i = 0;
            
            foreach($vmask as $range)
            {
                $vmask_h = explode('-', $range);
                
                if (isset($vmask_h[1]))
                {
                    if (($vmask_h[0]>=$user_ip_mask[$i]) && ($vmask_h[1]<=$user_ip_mask[$i])) 
                        $v_count--;
                }
                else
                {
                    if ($vmask_h[0] == $user_ip_mask[$i]) 
                        $v_count--;
                }
                $i++;
            }
            
            if (!$v_count)
            {
                $qFlag++;
                break;
            }
        }
        if (!$qFlag) 
            redirect("index.php?page=register&err=9&usr=$last_ip");
    }

    $user_name = sanitize_paranoid_string(trim($_POST['username']));
    $pass = sanitize_paranoid_string($_POST['pass']);
    $pass1 = sanitize_paranoid_string($_POST['pass1']);

    //make sure username/pass at least 4 chars long and less than max
    if ((strlen($user_name) < 4) || (strlen($user_name) > 15))
        redirect("index.php?page=register&err=5");

    //make sure it doesnt contain non english chars.
    if (!valid_alphabetic($user_name)) 
        redirect("index.php?page=register&err=6");

    //make sure the mail is valid mail format
    $mail = sanitize_sql_string(trim($_POST['email']));
    if ((!valid_email($mail))||(strlen($mail) > 224)) 
        redirect("index.php?page=register&err=7");

    $per_ip = ($limit_acc_per_ip) ? sprintf("OR last_ip='%s'", $last_ip) : "";

    $result = $sqla->fetch("SELECT ip FROM ip_banned WHERE ip = '%s'", $last_ip);
    //IP is in ban list
    if ($sqla->num_rows($result))
        redirect("index.php?page=register&err=8&usr=".$last_ip);

    //Email check
    $result = $sqla->fetch("SELECT email FROM account WHERE email='%s' %s", $mail, $per_ip);
    if ($sqla->num_rows($result))
        redirect("index.php?page=register&err=14");
  
    //Username check
    $result = $sqla->fetch("SELECT username FROM account WHERE username='%s' %s", $user_name, $per_ip);

    //there is already someone with same account name
    if ($sqla->num_rows($result))
        redirect("index.php?page=register&err=3&usr=$user_name");
    else 
    {
        if ($expansion_select)
            $expansion = (isset($_POST['expansion'])) ? sanitize_int($_POST['expansion']) : 0;
        else 
            $expansion = $defaultoption;

        if ($require_account_verify) 
        {
            $query2_result = $sqlm->fetch("SELECT * FROM mm_account WHERE username = '%s' OR email = '%s'", $user_name, $mail);
            
            if ($sqlm->num_rows($query2_result) > 0) 
                redirect("index.php?page=register&err=15");
            else 
            {
                $client_ip = $_SERVER['REMOTE_ADDR'];
                $authkey = sha1($client_ip . time());
                
                $result = $sqlm->action("INSERT INTO mm_account (username,sha_pass_hash,email, joindate,last_ip,failed_logins,locked,last_login,expansion,authkey)
                                        VALUES (UPPER('%s'),'%s','%s',now(),'%s','0','%s',NULL,'%d','%s')", $user_name, $pass, $mail, $last_ip, $create_acc_locked, $expansion, $authkey);
                do_verify_email($user_name, $pass1, $mail, $authkey);
                redirect("index.php?page=login&error=7");
            }
        }
        else 
            $result = $sqla->action("INSERT INTO account (username,sha_pass_hash,email, joindate,last_ip,failed_logins,locked,last_login,expansion)
                                   VALUES (UPPER('%s'),'%s','%s',now(),'%s',0,%s,NULL,%d)", $user_name, $pass, $mail, $last_ip, $create_acc_locked, $expansion);

        setcookie ("terms", "", time() - 3600);

        if ($send_mail_on_creation && !$require_account_verify) //account detail's already sent with verification mail
        {
            $mailer = new PHPMailer();
            $mailer->Mailer = $mailer_type;
            
            if ($mailer_type == "smtp")
            {
                $mailer->Host = $smtp_cfg['host'];
                $mailer->Port = $smtp_cfg['port'];
                $mailer->SMTP_sec = $smtp_cfg['sec'];
                
                if($smtp_cfg['user'] != '') 
                {
                    $mailer->SMTPAuth  = true;
                    $mailer->Username  = $smtp_cfg['user'];
                    $mailer->Password  =  $smtp_cfg['pass'];
                }
            }

            $file_name = "templates/_mail/mail_welcome.tpl";
            $fh = fopen($file_name, 'r');
            $subject = fgets($fh, 4096);
            $body = fread($fh, filesize($file_name));
            fclose($fh);

            $subject = str_replace("<title>", $title, $subject);
            $body = str_replace("\n", "<br />", $body);
            $body = str_replace("\r", " ", $body);
            $body = str_replace("<username>", $user_name, $body);
            $body = str_replace("<password>", $pass1, $body);
            $body = str_replace("<base_url>", $_SERVER['SERVER_NAME'], $body);

            $mailer->WordWrap = 50;
            $mailer->From = $from_mail;
            $mailer->FromName = $title." Admin";
            $mailer->Subject = $subject;
            $mailer->IsHTML(true);
            $mailer->Body = $body;
            $mailer->AddAddress($mail);
            $mailer->Send();
            $mailer->ClearAddresses();
        }

        if ($result) 
            redirect("index.php?page=login&error=6");
    }
}

//#####################################################################################################
// PRINT FORM
//#####################################################################################################
function register(){
    global $lang_register, $lang_global, $expansion_select, $lang_captcha ,$lang_command, $enable_captcha, $smarty;

    $smarty->assign('action', 'register');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_register', $lang_register);
    $smarty->assign('lang_captcha', $lang_captcha);
    $smarty->assign('lang_command', $lang_command);
    $smarty->assign('enable_captcha', $enable_captcha);
    $smarty->assign('expansion_select', $expansion_select);
    
    $terms = file_get_contents('templates/_mail/terms.tpl');
    $smarty->assign('textarea_data', $terms);
    
    $smarty->display('register.tpl');
    $smarty->clear_all_assign();
}


//#####################################################################################################
// PRINT PASSWORD RECOVERY FORM
//#####################################################################################################
function pass_recovery(){
    global $lang_register, $lang_global, $smarty;
    
    $smarty->assign('action', 'recovery');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_register', $lang_register);
                          
    $smarty->display('register.tpl');
    $smarty->clear_all_assign();
}

//#####################################################################################################
// DO RECOVER PASSWORD
//#####################################################################################################
function do_pass_recovery(){
    global $lang_global, $from_mail, $mailer_type, $smtp_cfg, $title, $sqla;

    if (empty($_POST['username']) || empty($_POST['email'])) 
        redirect("index.php?page=register&action=pass_recovery&err=1");

    $user_name = sanitize_paranoid_string(trim($_POST['username']));
    $email_addr = sanitize_sql_string($_POST['email']);

    $result = $sqla->fetch("SELECT sha_pass_hash FROM account WHERE username = '%s' AND email = '%s'", $user_name, $email_addr);

    if ($sqla->num_rows($result) == 1)
    {
        $mail = new PHPMailer();
        $mail->Mailer = $mailer_type;
        
        if ($mailer_type == "smtp")
        {
            $mail->Host = $smtp_cfg['host'];
            $mail->Port = $smtp_cfg['port'];
            $mail->SMTP_sec = $smtp_cfg['sec'];
            
            if($smtp_cfg['user'] != '') 
            {
                $mail->SMTPAuth  = true;
                $mail->Username  = $smtp_cfg['user'];
                $mail->Password  =  $smtp_cfg['pass'];
            }
        }

        $file_name = "templates/_mail/recover_password.tpl";
        $fh = fopen($file_name, 'r');
        $subject = fgets($fh, 4096);
        $body = fread($fh, filesize($file_name));
        fclose($fh);

        $body = str_replace("\n", "<br />", $body);
        $body = str_replace("\r", " ", $body);
        $body = str_replace("<username>", $user_name, $body);
        $body = str_replace("<password>", substr(sha1(strtoupper($user_name)),0,7), $body);
        $body = str_replace("<activate_link>",
        $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=register&action=do_pass_activate&amp;h=".$result[0]->sha_pass_hash."&amp;p=".substr(sha1(strtoupper($user_name)),0,7), $body);
        $body = str_replace("<base_url>", $_SERVER['HTTP_HOST'], $body);

        $mail->WordWrap = 50;
        $mail->From = $from_mail;
        $mail->FromName = "$title Admin";
        $mail->Subject = $subject;
        $mail->IsHTML(true);
        $mail->Body = $body;
        $mail->AddAddress($email_addr);

        if(!$mail->Send()) 
        {
            $mail->ClearAddresses();
            redirect("index.php?page=register&action=pass_recovery&err=11&usr=".$mail->ErrorInfo);
        } 
        else 
        {
            $mail->ClearAddresses();
            redirect("index.php?page=register&action=pass_recovery&err=12");
        }
    } 
    else 
        redirect("index.php?page=register&action=pass_recovery&err=10");
}


//#####################################################################################################
// DO ACTIVATE RECOVERED PASSWORD
//#####################################################################################################
function do_pass_activate(){
    global $lang_global, $sqla;

    if (empty($_GET['h']) || empty($_GET['p'])) 
        redirect("index.php?page=register&action=pass_recovery&err=1");

    $pass = sanitize_paranoid_string(trim($_GET['p']));
    $hash = sanitize_paranoid_string($_GET['h']);

    $result = $sqla->fetch("SELECT id,username FROM account WHERE sha_pass_hash = '%s'", $hash);

    if ($sqla->num_rows($result) == 1)
    {
        $username = $result[0]->username;
        $id = $result[0]->id;
        
        if (substr(sha1(strtoupper($username)),0,7) == $pass)
        {
            $sqla->action("UPDATE account SET sha_pass_hash=SHA1(CONCAT(UPPER('%s'),':',UPPER('%s'))), v=0, s=0 WHERE id = '%d'", $username, $pass, $id);
            redirect("index.php?page=login");
        }

    } 
    else 
        redirect("index.php?page=register&action=pass_recovery&err=1");

    redirect("index.php?page=register&action=pass_recovery&err=1");
}

//#####################################################################################################
// DO VERIFY ACCOUNT
//#####################################################################################################
function do_verify() {
    global $lang_verify, $lang_global, $sqlm, $sqla, $smarty;
    
    $username = (isset($_GET['username'])) ? strtoupper(sanitize_paranoid_string($_GET['username'])) : NULL;
    $authkey = (isset($_GET['authkey'])) ? sanitize_paranoid_string($_GET['authkey']) : NULL;
    
    $query = $sqlm->fetch("SELECT `id`, `username`, `sha_pass_hash`, `email`, `joindate`, `last_ip`, `failed_logins`, `locked`, `last_login`, `expansion` FROM mm_account WHERE username = '%s' AND authkey = '%s'", $username, $authkey);
    
    if (!$sqlm->num_rows($query))
        redirect("index.php?page=register&err=16");
    else 
    {
        $sqla->action("INSERT INTO account (`username`,`sha_pass_hash`,`email`,`joindate`,`last_ip`,`failed_logins`,`locked`,`last_login`,`expansion`) VALUES ('%s','%s','%s',now(),'%s','0','%s',NULL,%d)", $query[0]->username, $query[0]->sha_pass_hash, $query[0]->email, $query[0]->last_ip, $query[0]->locked, $query[0]->expansion);
        $result = $sqla->fetch("SELECT id FROM account WHERE username='%s'", $query[0]->username);
        $sqla->action("INSERT INTO account_access (`id`,`gmlevel`) VALUES (%d,0)", $result[0]->id);
        $sqlm->action("DELETE FROM mm_account WHERE username='%s'", $query[0]->username);
    }
    
    $smarty->assign('action', 'verify');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_verify', $lang_verify);
    $smarty->display("register.tpl");
    $smarty->clear_all_assign();
    
}


//#####################################################################################################
// MAIN
//#####################################################################################################
$err = (isset($_GET['err'])) ? sanitize_int($_GET['err']) : NULL;

if (isset($_GET['usr'])) 
    $usr = sanitize_paranoid_string($_GET['usr']);
else
    $usr = NULL;

$lang_verify = lang_verify();
$lang_captcha = lang_captcha();

// defines the title header in error cases
switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
    case 2:
        $smarty->assign('error', $lang_register['diff_pass_entered']);
        break;
    case 3:
        $smarty->assign('error', $lang_register['username']." ".$usr." ".$lang_register['already_exist']);
        break;
    case 4:
        $smarty->assign('error', $lang_register['acc_reg_closed']);
        break;
    case 5:
        $smarty->assign('error', $lang_register['wrong_pass_username_size']);
        break;
    case 6:
        $smarty->assign('error', $lang_register['bad_chars_used']);
        break;
    case 7:
        $smarty->assign('error', $lang_register['invalid_email']);
        break;
    case 8:
        $smarty->assign('error', $lang_register['banned_ip']." ".$usr."<br />".$lang_register['contact_serv_admin']);
        break;
    case 9:
        $smarty->assign('error', $lang_register['users_ip_range'].": ".$usr." ".$lang_register['cannot_create_acc']);
        break;
    case 10:
        $smarty->assign('error', $lang_register['user_mail_not_found']);
        break;
    case 11:
        $smarty->assign('error', "Mailer Error: ".$usr);
        break;
    case 12:
        $smarty->assign('error', $lang_register['recovery_mail_sent']);
        break;
    case 13:
        $smarty->assign('error', $lang_captcha['invalid_code']);
        break;
    case 14:
        $smarty->assign('error', $lang_register['email_address_used']);
        break;
    case 15:
        $smarty->assign('error', $lang_register['account_needs_verified']);
        break;
    case 16:
        $smarty->assign('error', $lang_verify['verify_failed']);
        break;
    default: //no error
        $err = -1;
}

$smarty->assign('headline', $lang_register['fill_all_fields']);

if ($err != -1)
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();

$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action){
    case "doregister":
        doregister();
        break;
    case "pass_recovery":
        pass_recovery();
        break;
    case "do_pass_recovery":
        do_pass_recovery();
        break;
    case "do_pass_activate":
        do_pass_activate();
        break;
    case "verify":
        do_verify();
        break;
    default:
        register();
}

unset($lang_captcha);
?>
