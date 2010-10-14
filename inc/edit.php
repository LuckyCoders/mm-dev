<?php
require_once 'libs/char.lib.php';

//##############################################################################################################
// EDIT USER
//##############################################################################################################
function edit_user()
{
    global $lang_edit, $realm_id, $lang_global, $user_name, $user_id, $characters_db, $expansion_select, $server, $developer_test_mode, $multi_realm_mode, $sqlm, $sqlc, $sqla, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');


    $refguid = $sqlm->fetch("SELECT InvitedBy FROM mm_point_system_invites WHERE PlayersAccount = %d", $user_id);
    if ($refguid && !empty($refguid[0]->InvitedBy))
    {
        $referred_by = $sqlc->fetch("SELECT name FROM characters WHERE guid = %d", $refguid[0]->InvitedBy);
        $referred_by = $referred_by[0]->name;
    }
    else
        $referred_by = "";
    
    if ($acc = $sqla->fetch("SELECT email, gmlevel, joindate, expansion, last_ip FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE username = '%s'", $user_name))
    {
        $acc = get_object_vars($acc[0]);
        if ($acc['gmlevel'] == null)
            $acc['gmlevel'] = 0;
    
        $numchars = $sqla->fetch("SELECT SUM(numchars) AS `count` FROM realmcharacters WHERE acctid = %d", $user_id);
        $numchars = $numchars[0]->count;
        
        $realms = $sqla->fetch("SELECT id, name FROM realmlist");
    
        $smarty->assign('lang_global', $lang_global);
        $smarty->assign('lang_edit', $lang_edit);
        $smarty->assign('user_name', $user_name);
        $smarty->assign('user_id', $user_id);
        $smarty->assign('acc', $acc);
        $smarty->assign('referred_by', $referred_by);
        $smarty->assign('gmlevelname', id_get_gm_level($acc['gmlevel']));
        $smarty->assign('numchars', $numchars);
        
        if ($expansion_select)
            $smarty->assign('expansion_select', $expansion_select);

        if ($developer_test_mode && $multi_realm_mode && (1<$sqla->num_rows($realms) && 1<count($server) && 1<count($characters_db)))
        {
            $realmdata = array();
            foreach ($realms as $realm)
            {
                $sqlc_temp = new MySQL($characters_db[$realm->id]);
                $result = $sqlc_temp->fetch("SELECT guid, name, race, class, level, gender FROM characters WHERE account = %d", $user_id);

                $chardata = array();
                foreach ($result as $char)
                    $chardata[] = array_merge(get_object_vars($char), array("realmid" => $realm->id, "racename" => char_get_race_name($char->race), "classname" => char_get_class_name($char->class), "lvlcolor" => char_get_level_color($char->level)));

                $realmdata[] = array("realmname" => $realm->name, "count" => $sqlc_temp->num_rows($result), "cdata" => $chardata);
            } 
        }
        else
        {
            $result = $sqlc->fetch("SELECT guid, name, race, class, level, gender FROM characters WHERE account = %d", $user_id);

            $chardata = array();
            foreach ($result as $char)
                $chardata[] = array_merge(get_object_vars($char), array("realmid" => $realm_id, "racename" => char_get_race_name($char->race), "classname" => char_get_class_name($char->class), "lvlcolor" => char_get_level_color($char->level)));

            $realmdata = array(array("realmname" => "", "count" => $sqlc->num_rows($result), "cdata" => $chardata)); //make it similiar to multirealm code so we can use same template code to display it
        }
        $smarty->assign('realmdata', $realmdata);

        if (is_dir('./lang'))
            if ($dh = opendir('./lang'))
            {
                while (($file = readdir($dh)) == true)
                {
                    $lang = explode('.', $file);
                    if(isset($lang[1]) && $lang[1] == 'php')
                    {
                        $tmp = '
                                                    <option value="'.$lang[0].'"';
                        if (isset($_COOKIE['lang']) && ($_COOKIE['lang'] == $lang[0]))
                            $tmp .= ' selected="selected" ';
                        $tmp .= '>'.$lang[0].'</option>';
                    }
                }
                closedir($dh);
            }
        $smarty->assign('language_optgrp', $tmp);
        unset($tmp);

        if (is_dir('./themes'))
            if ($dh = opendir('./themes'))
            {
                while (($file = readdir($dh)) == true)
                {
                    if (($file == '.') || ($file == '..') || ($file == '.htaccess') || ($file == 'index.html') || ($file == '.svn'));
                    else
                    {
                        $tmp = '
                                                    <option value="'.$file.'"';
                        if (isset($_COOKIE['theme']) && ($_COOKIE['theme'] == $file))
                            $tmp .= ' selected="selected" ';
                        $tmp .= '>'.$file.'</option>';
                    }
                }
                closedir($dh);
            }
        $smarty->assign('theme_optgrp', $tmp);
        unset($tmp);

        $smarty->display('edit.tpl');
        $smarty->clear_all_assign();
    }
    else
        redirect('index.php?page=edit&error=6');
}


//#############################################################################################################
//  DO EDIT USER
//#############################################################################################################
function doedit_user()
{
    global $user_name, $sqla, $defaultoption;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
    
    if ((empty($_POST['pass'])||($_POST['pass'] === ''))
        && (empty($_POST['mail'])||($_POST['mail'] === '')))
        redirect('index.php?page=edit&error=1');

    $new_pass = (sanitize_paranoid_string($_POST['pass']) == sha1(strtoupper($user_name).':******')) ? '' : "sha_pass_hash = '".sanitize_paranoid_string($_POST['pass'])."',";
    $new_mail = sanitize_sql_string($_POST['mail']);
    $new_expansion = (empty($_POST['expansion'])) ? $defaultoption : sanitize_int(trim($_POST['expansion']));
    $referredby = (empty($_POST['referredby'])) ? "" : sanitize_paranoid_string(trim($_POST['referredby']));

    if (strlen($new_mail) < 225);
    else
        redirect('index.php?page=edit&error=2');

    $sqla->action("UPDATE account SET email = '%s', %s v=0, s=0, expansion = %d WHERE username = '%s'", $new_mail, $new_pass, $new_expansion, $user_name);

    if (doupdate_referral($referredby) || $sqla->affected_rows())
        redirect('index.php?page=edit&error=3');
    else
        redirect('index.php?page=edit&error=4');

}

function doupdate_referral($referredby)
{
    global $user_id, $sqlc, $sqla, $sqlm;

    $result = $sqlm->fetch("SELECT InvitedBy FROM mm_point_system_invites WHERE PlayersAccount = %d", $user_id);
    
    if (!$sqlm->num_rows())
    {
        $referred_by = $sqlc->fetch("SELECT guid FROM characters WHERE name = '%s'", sanitize_sql_string($referredby));
        
        if ($sqlc->num_rows($referred_by))
        {
            $char = $sqlc->fetch("SELECT account FROM characters WHERE guid = %d", $referred_by[0]->guid);
            $result = $sqla->fetch("SELECT id FROM account WHERE id = %d", $char[0]->account);
            
            if ($result[0]->id != $user_id)
            {
                $sqlm->fetch("INSERT INTO mm_point_system_invites (PlayersAccount, InvitedBy, InviterAccount) VALUES ('%d', '%d', '%d')", $user_id, $referred_by[0]->guid, $result[0]->id);
                return true;
            }
        }
    }
    return false;
}


//###############################################################################################################
// SET DEFAULT INTERFACE LANGUAGE
//###############################################################################################################
function lang_set()
{
    if (empty($_GET['lang']))
        redirect('index.php?page=edit&error=1');
    else
        $lang = sanitize_paranoid_string($_GET['lang']);

    if ($lang)
    {
        setcookie('lang', $lang, time()+60*60*24*30*6); //six month
        redirect('index.php?page=edit');
    }
    else
        redirect('index.php?page=edit&error=1');
}


//###############################################################################################################
// SET DEFAULT INTERFACE THEME
//###############################################################################################################
function theme_set()
{
    if (empty($_GET['theme']))
        redirect('edit.php?error=1');
    else
        $tmpl = sanitize_paranoid_string($_GET['theme']);

    if ($tmpl)
    {
        setcookie('theme', $tmpl, time()+3600*24*30*6); //six month
        redirect('index.php?page=edit');
    }
    else
        redirect('index.php?page=edit&error=1');
}


//###############################################################################################################
// MAIN
//###############################################################################################################
$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

$lang_edit = lang_edit();

switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
    case 2:
        $smarty->assign('error', $lang_edit['use_valid_email']);
        break;
    case 3:
        $smarty->assign('error', $lang_edit['data_updated']);
        break;
    case 4:
        $smarty->assign('error', $lang_edit['error_updating']);
        break;
    case 5:
        $smarty->assign('error', $lang_edit['del_error']);
        break;
    case 6:
        $smarty->assign('error', $lang_global['err_no_records_found']);
        break;
    default: //no error
        $err = -1;
}

$smarty->assign('headline', $lang_edit['edit_your_acc']);

if ($err != -1)
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();
unset($err);


$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action)
{
    case "doedit_user":
        doedit_user();
        break;
    case "lang_set":
        lang_set();
        break;
    case "theme_set":
        theme_set();
        break;
    default:
        edit_user();
}

unset($lang_edit);
?>
