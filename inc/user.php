<?php
require_once 'libs/char.lib.php';

//########################################################################################################################
// BROWSE USERS
//########################################################################################################################
function browse_users()
{
    global $lang_global, $lang_user, $user_lvl, $user_name, $action_permission, $itemperpage, $showcountryflag, $expansion_select, $gm_level_arr, $sqlm, $sqla, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
    
    $online_pq = "online";

    //-------------------SQL Injection Prevention--------------------------------
    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if ($start<0); 
    else 
        $start=0;

    $order_by = (isset($_GET['order_by'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['order_by']) : 'id';
    if (preg_match('/^[_[:lower:]]{1,15}$/', $order_by)); 
    else 
        $order_by='id';

    $dir = (isset($_GET['dir'])) ? sanitize_int($_GET['dir']) : 1;
    if (preg_match('/^[01]{1}$/', $dir)); 
    else 
        $dir=1;

    $order_dir = ($dir) ? 'ASC' : 'DESC';
    $dir = ($dir) ? 0 : 1;

    //-------------------Search--------------------------------------------------
    $search_by = '';
    $search_value = '';

    $smarty->assign('action', 'browse_users');
   
    // if we have a search request, if not we just return everything
    if(isset($_GET['search_value']) && isset($_GET['search_by']))
    {

        $search_value = sanitize_paranoid_string($_GET['search_value']);
        $search_by = sanitize_paranoid_string($_GET['search_by']);
        $search_menu = array('username', 'id', 'gmlevel', 'greater_gmlevel', 'email', 'joindate', 'last_ip', 'failed_logins', 'last_login', 'online', 'banned', 'locked', 'expansion');
        if (!in_array($search_by, $search_menu))
            $search_by = 'username';
        unset($search_menu);

        if ($search_by === 'greater_gmlevel')
        {
            $query = $sqla->fetch("SELECT `account_access`.`gmlevel`, `account`.`username`, `account`.`id`, `account`.`expansion`, `account`.`email`, `account`.`joindate`, `account`.`failed_logins`, `account`.`locked`, `account`.`last_login`, `account`.`online`, `account`.`last_ip` FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE account_access.gmlevel < %d ORDER BY %s %s LIMIT %d, %d", $search_value, $order_by, $order_dir, $start, $itemperpage);
            $query_1 = $sqla->fetch("SELECT count(*) AS `count` FROM account_access WHERE gmlevel < %d", $search_value);
        }
        elseif ($search_by === 'gmlevel')
        {
            $query = $sqla->fetch("SELECT `account_access`.`gmlevel`, `account`.`username`, `account`.`id`, `account`.`expansion`, `account`.`email`, `account`.`joindate`, `account`.`failed_logins`, `account`.`locked`, `account`.`last_login`, `account`.`online`, `account`.`last_ip` FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE account_access.gmlevel = %d ORDER BY %s %s LIMIT %d, %d", $search_value, $order_by, $order_dir, $start, $itemperpage);
            $query_1 = $sqla->fetch("SELECT count(*) AS `count` FROM account_access WHERE gmlevel = %d", $search_value);
        }
        elseif ($search_by === 'banned')
        {
            $query = $sqla->fetch("SELECT `account_access`.`gmlevel`, `account`.`username`, `account`.`id`, `account`.`expansion`, `account`.`email`, `account`.`joindate`, `account`.`failed_logins`, `account`.`locked`, `account`.`last_login`, `account`.`online`, `account`.`last_ip` FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE account.id = 0 OR `id` IN (SELECT `id` FROM account_banned) ORDER BY %s %s LIMIT %d, %d", $order_by, $order_dir, $start, $itemperpage);
            $query_1 = $sqla->fetch("SELECT count(*) AS `count` FROM account WHERE `id` = 0 OR `id` IN (SELECT `id` FROM account_banned)");
        }
        elseif ($search_by === 'failed_logins')
        {
            $query = $sqla->fetch("SELECT `account_access`.`gmlevel`, `account`.`username`, `account`.`id`, `account`.`expansion`, `account`.`email`, `account`.`joindate`, `account`.`failed_logins`, `account`.`locked`, `account`.`last_login`, `account`.`online`, `account`.`last_ip` FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE failed_logins > %d ORDER BY %s %s LIMIT %d, %d", $search_value, $order_by, $order_dir, $start, $itemperpage);
            $query_1 = $sqla->fetch("SELECT count(*) AS `count` FROM account WHERE failed_logins > %d", $search_value);
        }
        else
        {
            // default search case
            $query = $sqla->fetch("SELECT `account_access`.`gmlevel`, `account`.`username`, `account`.`id`, `account`.`expansion`, `account`.`email`, `account`.`joindate`, `account`.`failed_logins`, `account`.`locked`, `account`.`last_login`, `account`.`online`, `account`.`last_ip` FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE `account`.%s LIKE '\%%s\%' ORDER BY %s %s LIMIT %d, %d", $search_by, $search_value, $order_by, $order_dir, $start, $itemperpage);
            $query_1 = $sqla->fetch("SELECT count(*) AS `count` FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE `account`.`%s` LIKE '\%%s\%'", $search_by, $search_value);
        }
    }
    else
    {
        // get total number of items
        $query_1 = $sqla->fetch("SELECT count(*) AS `count` FROM account");
        $query = $sqla->fetch("SELECT `account_access`.`gmlevel`, `account`.* FROM account LEFT JOIN account_access ON account.id=account_access.id ORDER BY %s %s LIMIT %d, %d", $order_by, $order_dir, $start, $itemperpage);
    }
    $all_record = $query_1[0]->count;
    unset($query_1);

    //==========================top tage navigaion starts here========================
    // we start with a lead of 10 spaces,
    //  because last line of header is an opening tag with 8 spaces
    //  keep html indent in sync, so debuging from browser source would be easy to read
    $smarty->assign('lang_user', $lang_user);
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('search_by', $search_by);
    $smarty->assign('search_value', $search_value);
    $smarty->assign('all_record', $all_record);
    $smarty->assign('start', $start);
    $smarty->assign('dir', $dir);
    $smarty->assign('expansion_select', $expansion_select);
    $smarty->assign('user_name', $user_name);
    $smarty->assign('pagination', generate_pagination('index.php?page=user&order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1).( $search_value && $search_by ? '&amp;search_by='.$search_by.'&amp;search_value='.$search_value.'' : '' ).'', $all_record, $itemperpage, $start));
    
    if (getPermission('insert'))
        $smarty->assign('hasInsertPermission', true);
        
    if (getPermission('update'))
        $smarty->assign('hasUpdatePermission', true);
        
    if (getPermission('delete'))
        $smarty->assign('hasDeletePermission', true);

    //==========================top tage navigaion ENDS here ========================
    
    // unknown working condition
    //if(getPermission('delete'))
    //              makebutton($lang_user['cleanup'], 'cleanup.php', 130);


    if ($search_value && $search_by)
        $smarty->assign('search_link', '&amp;search_by='.$search_by.'&amp;search_value='.$search_value);

    if ($showcountryflag)
    {
        require_once 'libs/misc.lib.php'; //used later
        $smarty->assign('showcountryflag', true);
    }

    //---------------Page Specific Data Starts Here--------------------------
    $data_array = array();
    if ($sqla->num_rows($query))
    foreach ($query as $data)
    {
        $data->gmlevel = (!is_null($data->gmlevel)) ? $data->gmlevel : 0; //normally, gmlvl0 accs dont have entry in account_access, so set default gmlevel
        if (($user_lvl >= $data->gmlevel)||($user_name == $data->username))
        {
            $smarty->assign('hasEditPermission', true);

            $exp_lvl_arr = id_get_exp_lvl();
            
            $data_additional = array("gm_level_name" => $gm_level_arr[$data->gmlevel][2], "exp_lvl" => $exp_lvl_arr[$data->expansion][2], "email_short" => substr($data->email,0,15));


            if ($showcountryflag)
            {
                $country = misc_get_country_by_ip($data->last_ip);
                $data_additional['country_code'] = $country['code'];
                $data_additional['country'] = $country['country'];
            }
            
            $data_array[] = array_merge(get_object_vars($data), $data_additional);
        }
    }
    $smarty->assign('data_array', $data_array);

    if ($expansion_select || $showcountryflag)
    {
        if ($expansion_select && $showcountryflag)
            $colspan = '13';
        else
        $colspan = '12';
    }
    else
        $colspan = '11';
        
    $smarty->assign('colspan_special', $colspan);
        
    // backup is broken
    //if(getPermission('insert'))
    //    makebutton($lang_user['backup_selected_users'], 'javascript:do_submit(\'form1\',1)',230);

    if ($expansion_select || $showcountryflag)
    {
        if ($expansion_select && $showcountryflag)
            $colspan = '5';
        else
            $colspan = '4';
    }
    else
        $colspan = '3';
    
    $smarty->assign('colspan_special2', $colspan);
    
    $smarty->display('user.tpl');
    $smarty->clear_all_assign();
}


//#######################################################################################################
//  DELETE USER
//#######################################################################################################
function del_user()
{
    global $lang_global, $lang_user, $smarty, $sqla;
    
    if (!getPermission('delete'))
        redirect('index.php?page=login&error=5');
    
    if(isset($_GET['check'])) 
        $check = $_GET['check']; //array, sanitize later
    else 
        redirect("index.php?page=user&error=1");
        
    $smarty->assign('action', 'del_user');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_user', $lang_user);
    
    $pass_array = "";
    
    $n_check=count($check);

    if ($n_check > 0 && is_array($check))
        foreach ($check as $tmp)
            $tmp = sanitize_int($tmp);

    $user_del_array = array();
    
    for ($i=0; $i<$n_check; ++$i)
        if ($check[$i] == '' || !is_numeric($check[$i]));
        else
        {
            $result = $sqla->fetch("SELECT username FROM `account` WHERE id = %d", $check[$i]);
            $user_del_array[] = array("id" => $check[$i], "username" => $result[0]->username);
            $pass_array .= "&check%5B%5D=$check[$i]";
        }

    //skip to backup
    if (isset($_GET['backup_op'])&&($_GET['backup_op'] == 1))
        redirect("index.php?page=user&action=backup_user".$pass_array);

    $smarty->assign('user_del_array', $user_del_array);
    $smarty->assign('do_del_link', "index.php?page=user&action=dodel_user".$pass_array."\" type=\"wrn");
    
    $smarty->display('user.tpl');
    $smarty->clear_all_assign();
}


//#####################################################################################################
//  DO DELETE USER
//#####################################################################################################
function dodel_user()
{
    global $lang_global, $lang_user, $output, $realm_db, $characters_db, $realm_id, $user_lvl,
           $tab_del_user_characters, $tab_del_user_realmd, $sqla, $smarty;
    
    if (!getPermission('delete'))
        redirect('index.php?page=login&error=5');
    
    require_once("libs/del.lib.php");

    if(isset($_GET['check']))
        $check = $_GET['check'];
    else
        redirect("index.php?page=user&error=1");

    $deleted_accs = 0;
    $deleted_chars = 0;
    
    for ($i=0; $i<count($check); $i++)
    {
        $check[$i] = sanitize_int($check[$i]);
        if ($check[$i]>0)
        {
            list($flag,$del_char) = del_acc($check[$i]);
            if ($flag)
            {
                $deleted_accs++;
                $deleted_chars += $del_char;
            }
        }
    }
    
    $smarty->assign('action', 'do_deluser');
    $smarty->assign('deleted_accs', $deleted_accs);
    $smarty->assign('deleted_chars', $deleted_chars);
    
    $smarty->display('user.tpl');
    $smarty->clear_all_assign();
}


//#####################################################################################################
//  DO BACKUP USER
//#####################################################################################################

function backup_user() //needs to be redone
{
    if (!getPermission('update'))
        redirect('index.php?page=login&error=5');

/*
    global $lang_global, $lang_user, $output, $realm_db, $characters_db, $realm_id, $user_lvl, $backup_dir;

    $sql = new SQL;
    $sql->connect($realm_db['addr'], $realm_db['user'], $realm_db['pass'], $realm_db['name']);

    if(isset($_GET['check'])) 
        $check = $sql->quote_smart($_GET['check']);
    else 
        redirect("user.php?error=1");

    require_once("libs/tab_lib.php");

    $subdir = "$backup_dir/accounts/".date("m_d_y_H_i_s")."_partial";
    mkdir($subdir, 0750);

    for ($t=0; $t<count($check); $t++)
    {
        if ($check[$t] != "" )
        {
            $sql->connect($realm_db['addr'], $realm_db['user'], $realm_db['pass'], $realm_db['name']);
            $query = $sql->query("SELECT id FROM account WHERE id = $check[$t]");
            $acc = $sql->fetch_array($query);
            $file_name_new = $acc[0]."_{$realm_db['name']}.sql";
            $fp = fopen("$subdir/$file_name_new", 'w') or die (error($lang_backup['file_write_err']));
            fwrite($fp, "CREATE DATABASE /"."*!32312 IF NOT EXISTS*"."/ {$realm_db['name']};\n")or die (error($lang_backup['file_write_err']));
            fwrite($fp, "USE {$realm_db['name']};\n\n")or die (error($lang_backup['file_write_err']));
            
            foreach ($tab_backup_user_realmd as $value) 
            {
                $acc_query = $sql->query("SELECT * FROM $value[0] WHERE $value[1] = $acc[0]");
                $num_fields = $sql->num_fields($acc_query);
                $numrow = $sql->num_rows($acc_query);
                $result = "-- Dumping data for $value[0] ".date("m.d.y_H.i.s")."\n";
                $result .= "LOCK TABLES $value[0] WRITE;\n";
                $result .= "DELETE FROM $value[0] WHERE $value[1] = $acc[0];\n";

                if ($numrow)
                {
                    $result .= "INSERT INTO $value[0] (";
                    for($count = 0; $count < $num_fields; $count++)
                    {
                        $result .= "`".$sql->field_name($acc_query,$count)."`";
                        if ($count < ($num_fields-1)) 
                            $result .= ",";
                    }
                    $result .= ") VALUES \n";
                    
                    for ($i =0; $i<$numrow; $i++)
                    {
                        $result .= "\t(";
                        $row = $sql->fetch_row($acc_query);
                        
                        for($j=0; $j<$num_fields; $j++)
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                            
                            if (isset($row[$j]))
                            {
                                if ($sql->field_type($acc_query,$j) == "int")
                                    $result .= "$row[$j]";
                                else
                                    $result .= "'$row[$j]'" ;
                            }
                            else
                                $result .= "''";
                                
                            if ($j<($num_fields-1))
                                $result .= ",";
                        }
                        if ($i < ($numrow-1))
                            $result .= "),\n";
                    }
                    $result .= ");\n";
                }
                $result .= "UNLOCK TABLES;\n";
                $result .= "\n";
                fwrite($fp, $result)or die (error($lang_backup['file_write_err']));
            }
            fclose($fp);

            foreach ($characters_db as $db)
            {
                $file_name_new = $acc[0]."_{$db['name']}.sql";
                $fp = fopen("$subdir/$file_name_new", 'w') or die (error($lang_backup['file_write_err']));
                fwrite($fp, "CREATE DATABASE /"."*!32312 IF NOT EXISTS*"."/ {$db['name']};\n")or die (error($lang_backup['file_write_err']));
                fwrite($fp, "USE {$db['name']};\n\n")or die (error($lang_backup['file_write_err']));

                $sql->connect($db['addr'], $db['user'], $db['pass'], $db['name']);
                $all_char_query = $sql->query("SELECT guid,name FROM `characters` WHERE account = $acc[0]");

                while ($char = $sql->fetch_array($all_char_query))
                {
                    fwrite($fp, "-- Dumping data for character $char[1]\n")or die (error($lang_backup['file_write_err']));
                    foreach ($tab_backup_user_characters as $value)
                    {
                        $char_query = $sql->query("SELECT * FROM $value[0] WHERE $value[1] = $char[0]");
                        $num_fields = $sql->num_fields($char_query);
                        $numrow = $sql->num_rows($char_query);
                        $result = "LOCK TABLES $value[0] WRITE;\n";
                        $result .= "DELETE FROM $value[0] WHERE $value[1] = $char[0];\n";
                        
                        if ($numrow)
                        {
                            $result .= "INSERT INTO $value[0] (";
                            
                            for($count = 0; $count < $num_fields; $count++)
                            {
                                $result .= "`".$sql->field_name($char_query,$count)."`";
                                if ($count < ($num_fields-1)) 
                                    $result .= ",";
                            }
                            $result .= ") VALUES \n";
                            for ($i =0; $i<$numrow; $i++)
                            {
                                $result .= "\t(";
                                $row = $sql->fetch_row($char_query);
                                for($j=0; $j<$num_fields; $j++)
                                {
                                    $row[$j] = addslashes($row[$j]);
                                    $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                                    
                                    if (isset($row[$j]))
                                    {
                                        if ($sql->field_type($char_query,$j) == "int")
                                            $result .= "$row[$j]";
                                        else
                                            $result .= "'$row[$j]'" ;
                                    }
                                    else
                                        $result .= "''";
                                    if ($j<($num_fields-1))
                                        $result .= ",";
                                }
                                if ($i < ($numrow-1))
                                    $result .= "),\n";
                            }
                            $result .= ");\n";
                        }
                        $result .= "UNLOCK TABLES;\n";
                        $result .= "\n";
                        fwrite($fp, $result)or die (error($lang_backup['file_write_err']));
                    }
                }
                fclose($fp);
            }
        }
    }
    redirect("user.php?error=15"); */
}


//#######################################################################################################
//  ADD NEW USER
//#######################################################################################################
function add_new()
{
    global $lang_global, $lang_user, $expansion_select, $smarty;

    if (!getPermission('insert'))
        redirect('index.php?page=login&error=5');
    
    $smarty->assign('action', 'add_new');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_user', $lang_user);
    $smarty->assign('expansion_select', $expansion_select);
    
    $smarty->display('user.tpl');
    $smarty->clear_all_assign();
}


//#########################################################################################################
// DO ADD NEW USER
//#########################################################################################################
function doadd_new()
{
    global $lang_global, $sqla;

    if (!getPermission('insert'))
        redirect('index.php?page=login&error=5');
    
    if (empty($_GET['new_user']) || empty($_GET['pass']))
        redirect("index.php?page=user&action=add_new&error=4");

    $new_user = sanitize_paranoid_string(trim($_GET['new_user']));
    $pass = sanitize_paranoid_string($_GET['pass']);
    
    if (!preg_match('/^[0-9a-f]{40}$/i', $pass)) //pass not sha1-hash!
        redirect("index.php?page=user&action=add_new&error=4");

    //make sure username at least 4 chars long and less than max
    if ((strlen($new_user) < 4) || (strlen($new_user) > 15))
        redirect("index.php?page=user&action=add_new&error=8");
    
    //make sure it doesnt contain non english chars.
    if (!preg_match('/^[0-9a-zA-Z]+$/i', trim($_GET['new_user']))) //are filtered by sanitize functions, but we want to generate an error
        redirect("index.php?page=user&action=add_new&error=9");
        
    $result = $sqla->fetch("SELECT username FROM account WHERE username = '%s'", $new_user);
    //there is already someone with same username
    if ($sqla->num_rows())
        redirect("index.php?page=user&action=add_new&error=7");
    else
        $last_ip = "0.0.0.0";
        
    $new_mail = (isset($_GET['new_mail'])) ? sanitize_system_string(trim($_GET['new_mail'])) : NULL;
    $locked = (isset($_GET['new_locked'])) ? sanitize_int($_GET['new_locked']) : 0;
    $expansion = (isset($_GET['new_expansion'])) ? sanitize_int($_GET['new_expansion']) : 0;
    
    $res = $sqla->action("INSERT INTO account (username,sha_pass_hash,email, joindate,last_ip,failed_logins,locked,last_login,expansion)
                            VALUES ('%s', '%s', '%s', now(), '%s', 0, %d, NULL, %d)", $new_user, $pass, $new_mail, $last_ip, $locked, $expansion);
    if ($res)
        redirect("index.php?page=user&error=5");
}


//###########################################################################################################
//  EDIT USER
//###########################################################################################################
function edit_user()
{
    global $lang_global, $lang_user, $user_lvl, $user_name, $gm_level_arr, $expansion_select, 
    $developer_test_mode, $multi_realm_mode, $characters_db, $realm_id, $server, $sqla, $sqlm, $sqlc, $smarty;

    if (!getPermission('update'))
        redirect('index.php?page=login&error=5');
    
    $online_pq = "online";

    if (empty($_GET['id'])) 
        redirect("index.php?page=user&error=10");

    $id = sanitize_int($_GET['id']);

    $result = $sqla->fetch("SELECT IFNULL(`account_access`.`gmlevel`,0) as `gmlevel`, `account`.* FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE account.id = %d", $id);
    $data = get_object_vars($result[0]);

    $refguid = $sqlm->fetch("SELECT InvitedBy FROM mm_point_system_invites WHERE PlayersAccount = %d", $data['id']);
    $refguid = $refguid[0]->InvitedBy;
    
    $referred_by = $sqlc->fetch("SELECT name FROM characters WHERE guid = %d", $refguid);
    $referred_by = $referred_by[0]->name;
    
    $smarty->assign('action', 'edit_user');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_user', $lang_user);
    $smarty->assign('char_data', $data);
    $smarty->assign('expansion_select', $expansion_select);
    $smarty->assign('id', $id);
    
    if(getPermission('update'))
        $smarty->assign('hasUpdatePermission', true);
        
    if(getPermission('delete'))
        $smarty->assign('hasDeletePermission', true);
        
    if ($sqla->num_rows())
    {
        if ($referred_by)
            $smarty->assign('referred_by', $referred_by);

        $gmlevel_options = array();
        foreach ($gm_level_arr as $level)
            if (($level[0] > -1) && ($level[0] < $user_lvl))
                $gmlevel_options[$level[0]] = $level[1];
                
        $smarty->assign('gmlevel_options', $gmlevel_options);
        $smarty->assign('gmlevelname', id_get_gm_level($data.gmlevel));
        
        $que = $sqla->fetch("SELECT bandate, unbandate, bannedby, banreason FROM account_banned WHERE id = %d ORDER BY unbandate DESC",$id);
        if ($sqla->num_rows())
        {
            $ban_info = " From:".date('d-m-Y G:i', $que[0]->bandate)." till:".date('d-m-Y G:i', $que[0]->unbandate)."<br />by ".$que[0]->bannedby;
            $smarty->assign('ban_checked', true);
        }
        else
            $ban_info    = "";
        $smarty->assign('ban_info', $ban_info);
        $smarty->assign('banreason', $que[0]->banreason);

        if ($expansion_select)
        {
            $expansion_options = array("0" => $lang_user['classic'], "1" => $lang_user['tbc'], "2" => $lang_user['wotlk']);
            $smarty->assign('expansion_options', $expansion_options);
        }
        
        $smarty->assign('lock_checked', $lock_checked);

        $query = $sqla->fetch("SELECT SUM(numchars) AS `sum` FROM realmcharacters WHERE acctid = %d", $id);
        $tot_chars = $query[0]->sum;
        
        $smarty->assign("tot_chars", $tot_chars);
        
        $query = $sqlc->fetch("SELECT count(*) AS `count` FROM `characters` WHERE account = %d", $id);
        $chars_on_realm = $query[0]->count;
        
        $realms = $sqla->fetch("SELECT id, name FROM realmlist");
        if ($developer_test_mode && $multi_realm_mode && ($sqla->num_rows() > 1 && (count($server) > 1) && (count($characters_db) > 1)))
        {
            require_once("scripts/get.lib.php");
            
            $realm_data_array = array();
            while ($realm = $sqlr->fetch_array($realms))
            {
                $sqlc_temp = new MySQL($characters_db[$realm->id]);
                $query = $sqlc_temp->fetch("SELECT count(*) AS `count` FROM `characters` WHERE account = %d", $id);
                $chars_on_realm = $query[0]->count;

                $char_data_array = array();
                if ($chars_on_realm)
                {
                    $char_array = $sqlc_temp->fetch("SELECT guid, name, race, class, level, gender FROM `characters` WHERE account = %d", $id);
                    
                    foreach ($char_array as $char)
                        $char_data_array[] = array_merge(get_object_vars($char), array("racename" => char_get_race_name($char->race), "classname" => char_get_class_name($char->class), "levelcolor" => char_get_level_color($char->level)));
                }
                
                $realm_data_array[] = array("realmname" => get_realm_name($realm->id), "chars_on_realm" => $chars_on_realm, "id" => $realm->id, "char_array" => $char_data_array);
            }
        }
        else
        {
            if ($chars_on_realm)
            {
                $char_array = $sqlc->fetch("SELECT guid, name, race, class, level, gender FROM `characters` WHERE account = %d", $id);
                
                foreach ($char_array as $char)
                    $char_data_array[] = array_merge(get_object_vars($char), array("racename" => char_get_race_name($char->race), "classname" => char_get_class_name($char->class), "levelcolor" => char_get_level_color($char->level)));
            }
            $realm_data_array[] = array("realmname" => get_realm_name($realm_id), "chars_on_realm" => $chars_on_realm, "id" => $realm_id, "char_array" => $char_data_array);
        }
        $smarty->assign('realm_data_array', $realm_data_array);
        $smarty->assign('deluser_link', "index.php?page=user&action=del_user&amp;check%5B%5D=".$id."\" type=\"wrn");
    }
    else 
        redirect("index.php?page=user&error=17");
        
    $smarty->display('user.tpl');
    $smarty->clear_all_assign();
}


//############################################################################################################
//  DO   EDIT   USER
//############################################################################################################
function doedit_user()
{
    global $lang_global, $user_lvl, $user_name, $sqla, $sqlm;
    
    if (!getPermission('update'))
        redirect('index.php?page=login&error=5');
    
    if ( (!isset($_POST['pass'])||($_POST['pass'] === ''))
            && (!isset($_POST['mail'])||($_POST['mail'] === ''))
            && (!isset($_POST['expansion'])||($_POST['expansion'] === ''))
            && (!isset($_POST['referredby'])||($_POST['referredby'] === '')) )
        redirect("index.php?page=user&action=edit_user&id=".sanitize_int($_POST['id'])."&error=1");

    $id = sanitize_int($_POST['id']);
    $username = sanitize_paranoid_string($_POST['username']);
    $banreason = sanitize_sql_string($_POST['banreason']);
    $pass = sanitize_paranoid_string($_GET['pass']);
    
    if (!preg_match('/^[0-9a-f]{40}$/i', $pass)) //pass not sha1-hash!
        redirect("index.php?page=user&action=edit_user&error=4");
        
    $user_pass_change = ($pass != sha1(strtoupper($username).":******")) ? "username='$username',sha_pass_hash='$pass',v=0,s=0," : "";

    $mail = (isset($_POST['mail']) && $_POST['mail'] != '') ? sanitize_system_string($_POST['mail']) : "";
    $failed = (isset($_POST['failed'])) ? sanitize_int($_POST['failed']) : 0;
    $gmlevel = (isset($_POST['gmlevel'])) ? sanitize_int($_POST['gmlevel']) : 0;
    $expansion = (isset($_POST['expansion'])) ? sanitize_int($_POST['expansion']) : 1;
    $banned = (isset($_POST['banned'])) ? sanitize_int($_POST['banned']) : 0;
    $locked = (isset($_POST['locked'])) ? sanitize_int($_POST['locked']) : 0;
    $referredby = sanitize_system_string(trim($_POST['referredby']));

    //make sure username/pass at least 4 chars long and less than max
    if ((strlen($username) < 4) || (strlen($username) > 15))
        redirect("index.php?page=user&action=edit_user&id=$id&error=8");

    if ($gmlevel >= $user_lvl)
        redirect("index.php?page=user&action=edit_user&id=".$id."&error=16");
    if (!valid_alphabetic($username))
        redirect("index.php?page=user&action=edit_user&error=9&id=".$id);
        
    //restricting accsess to lower gmlvl
    $result = $sqla->fetch("SELECT account.username, IFNULL(account_access.gmlevel,0) as gmlevel FROM account LEFT JOIN account_access ON account.id=account_access.id WHERE account.id = %d", $id);
    if (($user_lvl <= $result[0]->gmlevel) && ($user_name != $result[0]->username))
        redirect("index.php?page=user&error=14");
        
    $accgmlevel = $result[0]->gmlevel;
    $accname_tmp = $result[0]->username;
    
    if (!$banned)
    {
        $result = $sqla->fetch("SELECT count(*) AS `count` FROM account_banned WHERE id = %d", $id);
        if ($result[0]->count) 
            if ($soapTC) //need to implement error if tcsoap isnt present
                $res = $soapTC->fetch("unban account %s", $accname_tmp);
    }
    else
        if ($soapTC) //need to implement error if tcsoap isnt present
            $res = $soapTC->fetch("ban account %s -1 %s", $accname_tmp, $banreason);

    $error = false; 
    
    $sqla->action("UPDATE account SET email='%s', %s, failed_logins=%d, locked=%d, expansion=%d WHERE id = %d", $mail, $user_pass_change, $failed, $locked, $expansion, $id);
    if (!$sqla->affected_rows())
        $error = true;
        
    if ($gmlevel != $accgmlevel) //gmlevel changed..
    {
        if ($gmlevel == 0 && $accgmlevel > 0)
            $sqlr->query("DELETE FROM account_access WHERE id='$id'"); //0 has no entry in account_access
        elseif ($gmlevel > 0 && $accgmlevel == 0) //0 has no entry in account_access, add one; sometimes there's a bug so there's indeed a gmlevel 0 entry in the table -> replace
            $sqlr->query("REPLACE INTO account_access (`id`,`gmlevel`,`RealmID`) VALUES ('$id','$gmlevel','-1')"); //RealmID needs to be fixed!!
        else
            $sqlr->query("UPDATE account_access SET gmlevel='$gmlevel' WHERE id='$id'");
            
        $result = $sqla->fetch("SELECT IFNULL((SELECT gmlevel FROM account_access WHERE id = %d),0) AS `gmlevel`", $id);
        if (!$sqla->affected_rows() || $result[0]->gmlevel != $accgmlevel) //temporary errorhandling
            $error = true;
    }
    
    if (doupdate_referral($referredby, $id) || $error)
        redirect("index.php?page=user&action=edit_user&error=13&id=$id");
    else
        redirect("index.php?page=user&action=edit_user&error=12&id=$id");
}

function doupdate_referral($referredby, $user_id)
{
    global $sqlc, $sqla, $sqlm;

    $result = $sqlm->fetch("SELECT InvitedBy FROM mm_point_system_invites WHERE PlayersAccount = %d", $user_id);
    
    if ($sqlm->num_rows())
    {
        $result = $result[0]->InvitedBy;
        
        $referred_by = $sqlc->fetch("SELECT guid FROM characters WHERE name = '%s'", $referredby);
        $referred_by = $referred_by[0];

        if ($sqlc->num_rows())
        {
            $referred_by = $referred_by[0]->guid;
            
            $char = $sqlc->fetch("SELECT account FROM characters WHERE guid = %d", $referred_by);
            $result = $sqla->fetch("SELECT id FROM account WHERE id = %d", $char);
            $result = $result[0]->id;
            if ($result != $user_id)
            {
                $sqlm->action("INSERT INTO mm_point_system_invites (PlayersAccount, InvitedBy, InviterAccount) VALUES (%d, %s, %d)", $user_id, $referredby, $result);
                return true;
            }
            else
                return false;
        }
    }
}


//########################################################################################################################
// MAIN
//########################################################################################################################
$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

// load language
$lang_user = lang_user();

// defines the title header in error cases
switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
    case 2:
        $smarty->assign('error', $lang_global['err_no_search_passed']);
        break;
    case 3:
        $smarty->assign('error', $lang_user['search_results']);
        break;
    case 4:
        $smarty->assign('error', $lang_user['acc_creation_failed']);
        break;
    case 5:
        $smarty->assign('error', $lang_user['acc_created']);
        break;
    case 6:
        $smarty->assign('error', $lang_user['nonidentical_passes']);
        break;
    case 7:
        $smarty->assign('error', $lang_user['user_already_exist']);
        break;
    case 8:
        $smarty->assign('error', $lang_user['username_pass_too_long']);
        break;
    case 9:
        $smarty->assign('error', $lang_user['use_only_eng_charset']);
        break;
    case 10:
        $smarty->assign('error', $lang_user['no_value_passed']);
        break;
    case 11:
        $smarty->assign('error', $lang_user['edit_acc']);
        break;
    case 12:
        $smarty->assign('error', $lang_user['update_failed']);
        break;
    case 13:
        $smarty->assign('error', $lang_user['data_updated']);
        break;
    case 14:
        $smarty->assign('error', $lang_user['you_have_no_permission']);
        break;
    case 15:
        $smarty->assign('error', $lang_user['acc_backedup']);
        break;
    case 16:
        $smarty->assign('error', $lang_user['you_have_no_permission_to_set_gmlvl']);
        break;
    case 17:
        $smarty->assign('error', $lang_global['err_no_user']);
        break;
    default: //no error
        $err = -1;
}

if ($err == 5)
    $smarty->assign('headline', $lang_user['acc_created']);
elseif ($err = 11)
    $smarty->assign('headline', $lang_user['edit_acc']);
else
    $smarty->assign('headline', $lang_user['browse_acc']);

if ($err != -1 && $err != 5 && $err != 11) //5 & 11 = special case; shown as headline
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();


$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action)
{
    case "add_new":
        add_new();
        break;
    case "doadd_new":
        doadd_new();
        break;
    case "edit_user":
        edit_user();
        break;
    case "doedit_user":
        doedit_user();
        break;
    case "del_user":
        del_user();
        break;
    case "dodel_user":
        dodel_user();
        break;
    case "backup_user":
        backup_user();
        break;
    default:
        browse_users();
}

?>
