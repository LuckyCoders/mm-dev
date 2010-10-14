<?php

//#############################################################################
//  BROWSE  TICKETS
//#############################################################################
function browse_tickets()
{
    global $lang_global, $lang_ticket, $user_lvl, $itemperpage, $sqlc, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
    
    //==========================$_GET and SECURE=================================
    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if (is_numeric($start)); 
    else 
        $start=0;

    $order_by = (isset($_GET['order_by'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['order_by']) : 'guid';
    if (preg_match('/^[_[:lower:]]{1,10}$/', $order_by)); 
    else 
        $order_by = 'guid';

    $dir = (isset($_GET['dir'])) ? sanitize_int($_GET['dir']) : 1;
    if (preg_match('/^[01]{1}$/', $dir)); 
    else 
        $dir=1;

    $order_dir = ($dir) ? 'ASC' : 'DESC';
    $dir = ($dir) ? 0 : 1;
    //==========================$_GET and SECURE end=============================

    //get total number of items
    $query_1 = $sqlc->fetch("SELECT count(*) AS `count` FROM gm_tickets");
    $all_record = $query_1[0]->count;

    $smarty->assign('action', 'browse');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_ticket', $lang_ticket);
    $smarty->assign('start', $start);
    $smarty->assign('order_by', $order_by);
    $smarty->assign('dir', $dir);
    $smarty->assign('all_record', $all_record);
    $smarty->assign('pagination', generate_pagination("index.php?page=ticket&action=browse_tickets&amp;order_by=$order_by&amp;dir=".!$dir, $all_record, $itemperpage, $start));

    if(getPermission('delete'))
        $smarty->assign('hasDeletePermission', true);
    if(getPermission('update'))
        $smarty->assign('hasUpdatePermission', true);
        
    $query = $sqlc->fetch("SELECT gm_tickets.guid, gm_tickets.timestamp, gm_tickets.playerGuid, SUBSTRING_INDEX(gm_tickets.message,' ',6) AS `message`, characters.name, characters.online
                            FROM gm_tickets,characters WHERE gm_tickets.playerGuid = characters.guid ORDER BY %s %s LIMIT %d, %d", $order_by, $order_dir, $start, $itemperpage);

    $ticket_array = array();
    
    if (count($query))
        foreach ($query as $ticket)
            $ticket_array[] = get_object_vars($ticket);
            
    $smarty->assign('ticket_array', $ticket_array);
    $smarty->display('ticket.tpl');
    $smarty->clear_all_assign();
}


//########################################################################################################################
//  DELETE TICKETS
//########################################################################################################################
function delete_tickets()
{
    global $lang_global, $sqlc;

    if (!getPermission('delete'))
        redirect('index.php?page=login&error=5');
    
    if(isset($_GET['check'])) 
        $check = $_GET['check']; //array, sanitize later
    else 
        redirect("index.php?page=user&error=1");

    $n_check=count($check);

    if ($n_check > 0 && is_array($check))
        foreach ($check as $tmp)
            $tmp = sanitize_int($tmp);
        
    $deleted_tickets = 0;
    for ($i=0; $i<$n_check; $i++)
        if ($check[$i] != "")
        {
            //if ($soapTC) //need to implement error if tcsoap isnt present
            //    $res = $soapTC->fetch("ticket delete %d", $check[$i]); //integer
            $query = $sqlc->action("DELETE FROM gm_tickets WHERE guid = %d", $check[$i]);
            if ($res)
                $deleted_tickets++;
        }

    if (0 == $deleted_tickets)
        redirect('index.php?page=ticket&error=3');
    else
        redirect('index.php?page=ticket&error=2');
}

//########################################################################################################################
//  EDIT TICKET
//########################################################################################################################
function edit_ticket()
{
    global  $lang_global, $lang_ticket, $sqlc, $smarty;

    if (!getPermission('update'))
        redirect('index.php?page=login&error=5');
    
    if(!isset($_GET['id'])) 
        redirect("index.php?page=user&error=1");

    $id = sanitize_int($_GET['id']);
    if(is_numeric($id)); 
    else 
        redirect("ticket.php?error=1");

    $smarty->assign('action', 'edit');
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('lang_ticket', $lang_ticket);
    $smarty->assign('id', $id);
    
    $query = $sqlc->fetch("SELECT gm_tickets.playerGuid, gm_tickets.message, `characters`.name FROM gm_tickets,`characters` LEFT JOIN gm_tickets k1 ON k1.`playerGuid`=`characters`.`guid` WHERE gm_tickets.playerGuid = `characters`.`guid` AND gm_tickets.guid = %d", $id);
    
    if ($sqlc->num_rows())
        $smarty->assign('ticket', get_object_vars($query[0]));
    else
        redirect('index.php?page=ticket&error=7');
        
    $smarty->display('ticket.tpl');
    $smarty->clear_all_assign();
}


//########################################################################################################################
//  DO EDIT  TICKET
//########################################################################################################################
function do_edit_ticket()
{
    global $sqlc;

    if (!getPermission('update'))
        redirect('index.php?page=login&error=5');
    
    if(empty($_POST['new_text']) || empty($_POST['id']) )
        redirect('index.php?page=ticket&error=1');

    $new_text = sanitize_html_string($_POST['new_text']);
    
    $id = sanitize_int($_POST['id']);
    if(is_numeric($id)); 
    else 
        redirect('index.php?page=ticket&error=1');

    $query = $sqlc->action("UPDATE gm_tickets SET message=%s WHERE guid = %d", $new_text, $id);

    if ($sqlc->affected_rows())
        redirect("index.php?page=ticket&error=5");
    else
        redirect("index.php?page=ticket&error=6");
}


//########################################################################################################################
// MAIN
//########################################################################################################################
$err = (isset($_GET['error'])) ? sanitize_int($_GET['error']) : NULL;

$lang_ticket = lang_ticket();

switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
    case 2:
        $smarty->assign('error', $lang_ticket['ticked_deleted']);
        break;
    case 3:
        $smarty->assign('error', $lang_ticket['ticket_not_deleted']);
        break;
    case 4:
        $smarty->assign('error', $lang_ticket['edit_ticked']);
        break;
    case 5:
        $smarty->assign('error', $lang_ticket['ticket_updated']);
        break;
    case 6:
        $smarty->assign('error', $lang_ticket['ticket_update_err']);
        break;
    case 7:
        $smarty->assign('error', $lang_global['err_no_records_found']);
    default: //no error
        $err = -1;
}

$smarty->assign('headline', $lang_ticket['browse_tickets']);

if ($err != -1)
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();


$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action)
{
    case "browse_tickets":
        browse_tickets();
        break;
    case "delete_tickets":
        delete_tickets();
        break;
    case "edit_ticket":
        edit_ticket();
        break;
    case "do_edit_ticket":
        do_edit_ticket();
        break;
    default:
        browse_tickets();
}

?>
