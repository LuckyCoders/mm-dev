<?php
require_once 'libs/bbcode_lib.php';

//#############################################################################
// ADD MOTD
//#############################################################################
function add_motd()
{
    global $lang_motd, $lang_global, $smarty;

    $smarty->assign('editor', bbcode_add_editor());
    $smarty->assign('lang_motd', $lang_motd);
    $smarty->assign('lang_global', $lang_global);
    
    $smarty->display('motd.tpl');
    $smarty->clear_all_assign();
}
//#############################################################################
// EDIT MOTD
//#############################################################################
function edit_motd()
{
    global $lang_motd, $lang_global, $sqlm, $smarty;

    if(!empty($_GET['id']) && sanitize_int($_GET['id'])>0)
        $id = sanitize_int($_GET['id']);
    else
        redirect('index.php?page=motd&error=1');

    $result = $sqlm->fetch("SELECT content FROM mm_motd WHERE id = %d", $id);
    $msg = $result[0]->content;

    $smarty->assign('id', $id);
    $smarty->assign('editor', bbcode_add_editor());
    $smarty->assign('lang_motd', $lang_motd);
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('msg', $msg);

    $smarty->display('motd.tpl');
    $smarty->clear_all_assign();
}
//#####################################################################################################
// DO ADD MOTD
//#####################################################################################################
function do_add_motd()
{
    global $user_name, $realm_id, $sqlm;

    if (empty($_POST['msg']))
        redirect('index.php?page=motd&error=1');
    else
        $msg = sanitize_sql_string($_POST['msg']);
        
    if (4096 < strlen($msg))
        redirect('index.php?page=motd&error=2');

    $by = date('m/d/y H:i:s').' Posted by: '.$user_name;

    $sqlm->action("INSERT INTO mm_motd (realmid, type, content) VALUES (%d, '%s', '%s')", $realm_id, $by, $msg);

    redirect('index.php');
}
//#####################################################################################################
// DO EDIT MOTD
//#####################################################################################################
function do_edit_motd()
{
    global $user_name, $realm_id, $sqlm;

    if(!empty($_POST['id']) && sanitize_int($_POST['id'])>0 && !empty($_POST['msg']))
    {
        $id = sanitize_int($_POST['id']);
        $msg = sanitize_sql_string($_POST['msg']);
    }
    else
        redirect('index.php?page=motd&error=1');

    if (4096 < strlen($msg))
        redirect('index.php?page=motd&error=2');

    $result = $sqlm->fetch("SELECT type FROM mm_motd WHERE id = %d", $id);
    $by = $result[0]->type;
    $by = explode('<br />', $by, 2);
    $by = $by[0].'<br />'.date('m/d/y H:i:s').' Edited by: '.$user_name;

    $sqlm->action("UPDATE mm_motd SET realmid = %d, type = '%s', content = '%s' WHERE id = %d", $realm_id, $by, $msg, $id);

    redirect('index.php');
}
//#####################################################################################################
// DELETE MOTD
//#####################################################################################################
function delete_motd()
{
    global $realm_id, $sqlm;

    if(!empty($_GET['id']) && sanitize_int($_GET['id'])>0)
        $id = sanitize_int($_GET['id']);
    else
        redirect('index.php?page=motd&error=1');

    $sqlm->action("DELETE FROM mm_motd WHERE id = %d", $id);

    redirect('index.php');
}
//########################################################################################################################
// MAIN
//########################################################################################################################
$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

$lang_motd = lang_motd();

switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
        
    case 2:
        $smarty->assign('error', $lang_motd['err_max_len']);
        break;
        
    case 3:
        $smarty->assign('error', $lang_motd['edit_motd']);
        break;
       
    default: //no error
        $err = -1;
}

$smarty->assign('headline', $lang_motd['add_motd']);

if ($err != -1)
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();
unset($err);


$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action)
{
    case 'delete_motd':
        delete_motd();
        break;
        
    case 'add_motd':
        add_motd();
        break;
        
    case 'do_add_motd':
        do_add_motd();
        break;
        
    case 'edit_motd':
        edit_motd();
        break;
        
    case 'do_edit_motd':
        do_edit_motd();
        break;
        
    default:
        add_motd();
}

unset($lang_motd);

?>
