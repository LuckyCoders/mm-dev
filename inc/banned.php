<?php
//########################################################################################################################
// SHOW BANNED LIST
//########################################################################################################################
function show_list()
{
    global $lang_global, $lang_banned, $realm_db, $itemperpage, $user_lvl, $sqla, $smarty;
    
    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
        
    $smarty->assign('lang_global',$lang_global);
    $smarty->assign('lang_banned',$lang_banned);

    $ban_type = (isset($_GET['ban_type'])) ? sanitize_paranoid_string($_GET['ban_type']) : "accountbanned";
    switch ($ban_type) //need sanitize function like paranoid_string + _ (once)
    {
        case "accountbanned":
            $ban_type = "account_banned"; //db-table
            break;
        case "ipbanned":
            $ban_type = "ip_banned"; //db-table
            break;
            
        default:
            //TODO: error
    }
    $key_field = ($ban_type == 'account_banned') ? 'id' :'ip';

    //==========================$_GET and SECURE=================================
    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if (is_numeric($start)); 
    else $start=0;

    $order_by = (isset($_GET['order_by'])) ? sanitize_paranoid_string($_GET['order_by']) : $key_field;
    if (!preg_match("/^[_[:lower:]]{1,12}$/", $order_by)) 
        $order_by = $key_field;

    $dir = (isset($_GET['dir'])) ? sanitize_int($_GET['dir']) : 1;
    if (!preg_match("/^[01]{1}$/", $dir)) 
        $dir=1;

    $order_dir = ($dir) ? "ASC" : "DESC";
    $dir = ($dir) ? 0 : 1;
    //==========================$_GET and SECURE end=============================

    $fromwhere = ($ban_type == 'account_banned') ? $ban_type . " WHERE active = 1" : $ban_type;
    $query_1 = $sqla->fetch("SELECT count(*) as `count` FROM %s", $fromwhere);
    $all_record = $query_1[0]->count;
    $smarty->assign('ban_count', $all_record);

    $result = $sqla->fetch("SELECT %s, bandate, unbandate, bannedby, SUBSTRING_INDEX(banreason,' ',3) as reason FROM %s ORDER BY %s %s LIMIT %d, %d", $key_field, $fromwhere, $order_by, $order_dir, $start, $itemperpage);
    $this_page = $sqla->num_rows();
    
    $banseltext = ($ban_type == "account_banned") ? $lang_banned['banned_ips'] : $lang_banned['banned_accounts'];
    $banseltype = ($ban_type == "account_banned") ? "ip_banned" : "account_banned";
    
    if(getPermission('insert'))
        $smarty->assign('hasInsertPermission', true);

    $smarty->assign('ban_selection_text', $banseltext);
    $smarty->assign('ban_selection_link', 'index.php?page=banned&ban_type='.$banseltype);
    $smarty->assign('ban_pagination', generate_pagination("index.php?page=banned&action=show_list&amp;order_by=".$order_by."&amp;ban_type=".$ban_type."&amp;dir=".!$dir, $all_record, $itemperpage, $start));
    $smarty->assign('ban_js_delbanned', 'index.php?page=banned&action=do_delete_entry&amp;ban_type='.$ban_type.'&amp;'.$key_field.'=');
    
    $ban_th_array = array();
    $tmp_link_prefix = "index.php?page=banned&order_by=";
    $tmp_link_suffix = "&amp;ban_type=".$ban_type."&amp;dir=".$dir;
    $tmp_link_class = ' class="'.$order_dir.'"';
    
    $ban_th_array[] = array("width" => "19%", "link" => $tmp_link_prefix.$key_field.$tmp_link_suffix, "class" => ($order_by==$key_field ? $tmp_link_class : ""), "text" => $lang_banned['ip_acc']);
    $ban_th_array[] = array("width" => "18%", "link" => $tmp_link_prefix."bandate".$tmp_link_suffix, "class" => ($order_by=='bandate' ? $tmp_link_class : ""), "text" => $lang_banned['bandate']);
    $ban_th_array[] = array("width" => "18%", "link" => $tmp_link_prefix."unbandate".$tmp_link_suffix, "class" => ($order_by=='unbandate' ? $tmp_link_class : ""), "text" => $lang_banned['unbandate']);
    $ban_th_array[] = array("width" => "15%", "link" => $tmp_link_prefix."bannedby".$tmp_link_suffix, "class" => ($order_by=='bannedby' ? $tmp_link_class : ""), "text" => $lang_banned['bannedby']);
    $ban_th_array[] = array("width" => "25%", "link" => $tmp_link_prefix."banreason".$tmp_link_suffix, "class" => ($order_by=='banreason' ? $tmp_link_class : ""), "text" => $lang_banned['banreason']);

    $smarty->assign('ban_thcolumn_array', $ban_th_array);

    if(getPermission('delete'))
        $smarty->assign('hasDeletePermission', true);
    
    $ban_array = array();
    foreach ($result as $ban)
    {
        if ($ban_type == "account_banned") //key_field = id
        {
            $result1 = $sqla->fetch("SELECT username FROM account WHERE id ='%d'", $ban->id);
            $owner_acc_name = $result1[0]->username;
            $name_out = "<a href=\"index.php?page=user&action=edit_user&amp;error=11&amp;id=".$ban->id."\">".$owner_acc_name."</a>";
            $idtmp = $ban->id;
        }
        else
        {
            $name_out = $ban->ip;
            $owner_acc_name = $ban->ip;
            $idtmp = $ban->ip;
        }
        
        $ban_array[] = array("id" => $idtmp, "accname" => $owner_acc_name, "accnameout" => $name_out, "accnameout_specialchars" => htmlspecialchars($name_out), "bandate" => date('d-m-Y G:i', $ban->bandate), "unbandate" => date('d-m-Y G:i', $ban->unbandate), "bannedby" => $ban->bannedby, "banreason" => $ban->reason);
    }
    $smarty->assign('ban_array', $ban_array);
    $smarty->display('banned.tpl');
    $smarty->clear_all_assign();
}


//########################################################################################################################
// DO DELETE ENTRY FROM LIST
//########################################################################################################################
function do_delete_entry()
{
    global $sqla, $user_lvl;

    if (!getPermission('delete'))
        redirect('index.php?page=login&error=5');
        
    $ban_type = (isset($_GET['ban_type'])) ? sanitize_paranoid_string($_GET['ban_type']) : "error";
    switch ($ban_type) //need sanitize function like paranoid_string + _ (once)
    {
        case "accountbanned":
            $ban_type = "account_banned"; //db-table
            break;
        case "ipbanned":
            $ban_type = "ip_banned"; //db-table
            break;
            
        default:
            redirect("index.php?page=banned&ban_type=".$ban_type."&error=1");
    }

    $key_field = ($ban_type == "account_banned") ? "id" : "ip";

    if(isset($_GET[$key_field])) 
        $entry = sanitize($_GET[$key_field],10);
    else 
        redirect("&error=1", true);

    if ($ban_type == 'account_banned')
        $sqla->action("UPDATE account_banned SET active = '0' WHERE %s = '%s'", $key_field, $entry);
    else
        $sqla->action("DELETE FROM %s WHERE %s = '%s'", $ban_type, $key_field, $entry);

    if ($sqla->affected_rows())
        redirect("index.php?page=banned&ban_type=".$ban_type."&error=3");
    else
        redirect("index.php?page=banned&ban_type=".$ban_type."&error=2");
}


//########################################################################################################################
//  BAN NEW IP
//########################################################################################################################
function add_entry()
{
    global $lang_global, $lang_banned, $smarty;
    
    if (!getPermission('insert'))
        redirect('index.php?page=login&error=5');

    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_banned', $lang_banned);
    
    $smarty->display('banned_add_entry.tpl');
    $smarty->clear_all_assign();
}


//########################################################################################################################
//DO BAN NEW IP/ACC
//########################################################################################################################
function do_add_entry()
{
    global $user_name, $user_lvl, $sqla;

    if (!getPermission('insert'))
        redirect('index.php?page=login&error=5');
    
    if((empty($_GET['ban_type']))||(empty($_GET['entry'])) ||(empty($_GET['bantime'])))
        redirect("&error=1&action=add_entry", true);

    $ban_type = (isset($_GET['ban_type'])) ? sanitize_paranoid_string($_GET['ban_type']) : "accountbanned";
    switch ($ban_type) //need sanitize function like paranoid_string + _ (once)
    {
        case "accountbanned":
            $ban_type = "account_banned"; //db-table
            break;
        case "ipbanned":
            $ban_type = "ip_banned"; //db-table
            break;
            
        default:
            //TODO: error
    }

    $entry = sanitize_sql_string($_GET['entry']);
    
    if ($ban_type == "account_banned")
    {
        $result1 = $sqla->fetch("SELECT id FROM account WHERE username ='%s'", $entry);
        if (!$sqla->num_rows())
            redirect("&error=4&action=add_entry", true);
        else
            $entry = $result1[0]->id;
    }

    $bantime = time() + (3600 * sanitize_int($_GET['bantime']));
    $banreason = (isset($_GET['banreason']) && ($_GET['banreason'] != '')) ? sanitize_html_string($_GET['banreason']) : "none";

    if ($ban_type === "account_banned")
    {
        $result = $sqla->fetch("SELECT count(*) FROM account_banned WHERE id = '%s'", $entry);
        if(!$result[0])
            $sqla->action("INSERT INTO account_banned (id, bandate, unbandate, bannedby, banreason, active)
                            VALUES ('%d',".time().",%d,'%s','%s', 1)", $entry, $bantime, $user_name, $banreason);
    }
    else
        $sqla->action("INSERT INTO ip_banned (ip, bandate, unbandate, bannedby, banreason)
                        VALUES ('%s',".time().",%d,'%s','%s')", $entry, $bantime, $user_name, $banreason);

    if ($sqla->affected_rows())
        redirect("index.php?page=banned&ban_type=".$ban_type."&error=3", false);
    else
        redirect("index.php?page=banned&ban_type=".$ban_type."&error=2", false);
}


//########################################################################################################################
// MAIN
//########################################################################################################################
$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

$lang_banned = lang_banned();

switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
        
    case 2:
        $smarty->assign('error', $lang_banned['err_del_entry']);
        break;
        
    case 3:
        $smarty->assign('error', $lang_banned['updated']);
        break;
        
    case 4:
        $smarty->assign('error', $lang_banned['acc_not_found']);
        break;
        
    default: //no error
        $err = -1;
}

$smarty->assign('headline', $lang_banned['banned_list']);

if ($err != -1)
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();
unset($err);

$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action)
{
    case "do_delete_entry":
        do_delete_entry();
        break;
        
    case "add_entry":
        add_entry();
        break;
    
    case "do_add_entry":
        do_add_entry();
        break;
    
    default:
        show_list();
}

unset($action);
unset($lang_banned);
?>
