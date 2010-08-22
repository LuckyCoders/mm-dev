<?php

//#############################################################################
// BROWSE SPELLS
//#############################################################################
function browse_spells()
{
    global $lang_spelld, $lang_global, $realm_id, $user_lvl, $itemperpage, $sqlw, $smarty;

    //==========================$_GET and SECURE=================================
    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if (is_numeric($start)); 
    else 
        $start=0;
        
    $order_by = (isset($_GET['order_by'])) ? sanitize_paranoid_string($_GET['order_by']) : 'entry';
    if (preg_match('/^[_[:lower:]]{1,12}$/', $order_by)); 
    else 
        $order_by = 'entry';

    $dir = (isset($_GET['dir'])) ? sanitize_int($_GET['dir']) : 1;
    if (preg_match('/^[01]{1}$/', $dir)); 
    else 
        $dir = 1;

    $order_dir = ($dir) ? 'ASC' : 'DESC';
    $dir = ($dir) ? 0 : 1;
    //==========================$_GET and SECURE end=============================

    //==========================Browse/Search CHECK==============================
    $search_by = '';
    $search_value = '';
    
    if(isset($_GET['search_value']) && isset($_GET['search_by']))
    {
        $search_value = sanitize_sql_string($_GET['search_value']);
        $search_by = sanitize_sql_string($_GET['search_by']);
        $search_menu = array('entry', 'flags', 'comment');
        
        if (in_array($search_by, $search_menu)); 
        else 
            $search_by = 'entry';

        $query_1 = $sqlw->fetch("SELECT count(*) AS `count` FROM disables WHERE `sourceType` = 0 AND $search_by LIKE '\%%s\%'", $search_value);
        $result = $sqlw->fetch("SELECT entry, flags, comment FROM disables WHERE `sourceType` = 0 AND %s LIKE '\%%s\%' ORDER BY %s %s LIMIT %d, %d", $search_by, $search_value, $order_by, $order_dir, $start, $itemperpage);
    }
    else
    {
        $query_1 = $sqlw->fetch("SELECT count(*) AS `count` FROM disables WHERE `sourceType` = 0");
        $result = $sqlw->fetch("SELECT entry, flags, comment FROM disables WHERE `sourceType` = 0 ORDER BY %s %s LIMIT %d, %d", $order_by, $order_dir, $start, $itemperpage);
    }
    //get total number of items
    $all_record = $query_1[0]->count;
    unset($query_1);

    $smarty->assign('all_record', $all_record);
    $smarty->assign('lang_spelld', $lang_spelld);
    $smarty->assign('lang_global', $lang_global);
    //==========================top tage navigation starts here========================
    if ($user_lvl >= $action_permission['insert'])
        $smarty->assign('hasInsertPermission', true);

    if ($search_by && $search_value)
        $smarty->assign('isSearch', true);

    $smarty->assign('pagination', generate_pagination('index.php?page=spelldisabled&order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1).( $search_value && $search_by ? '&amp;search_by='.$search_by.'&amp;search_value='.$search_value.'' : '' ), $all_record, $itemperpage, $start));
    $smarty->assign('search_by_select_arr', array(
                                                    "entry" => $lang_spelld['by_id'],
                                                    "flags" => $lang_spelld['by_disable'],
                                                    "comment" => $lang_spelld['by_comment']
                                                ));
    $smarty->assign('search_by', $search_by);
    $smarty->assign('search_value', $search_value);
    
    //==========================top tage navigation ENDS here ========================
    $smarty->assign('start', $start);

    if($user_lvl >= $action_permission['delete'])
        $smarty->assign('hasDeletePermission', true);

    $tmp_svsb = $search_value && $search_by ? '&amp;error=3&amp;search_by='.$search_by.'&amp;search_value='.$search_value.'' : '';
    $th_entries = array(
                        "entry" => array("width" => "10%", "link" => "index.php?page=spelldisabled&order_by=entry&amp;start=".$start.$tmp_svsb."&amp;dir=".$dir, "class" => ($order_by==='entry' ? ' class="'.$order_dir.'"' : ''), "text" => $lang_spelld['entry']),
                        "flags" => array("width" => "10%", "link" => "index.php?page=spelldisabled&order_by=flags&amp;start=".$start.$tmp_svsb."&amp;dir=".$dir, "class" => ($order_by==='flags' ? ' class="'.$order_dir.'"' : ''), "text" => $lang_spelld['flags']),
                        "comment" => array("width" => "70%", "link" => "index.php?page=spelldisabled&order_by=comment&amp;start=".$start.$tmp_svsb."&amp;dir=".$dir, "class" => ($order_by==='comment' ? ' class="'.$order_dir.'"' : ''), "text" => $lang_spelld['comment']),
                    );
    $smarty->assign('th_entries', $th_entries);

    $spelld_array = array();
    if ($sqlw->num_rows($result)>0)
        foreach ($result as $spelld)
            $spelld_array[] = get_object_vars($spelld);
    
    $smarty->assign('spelld_array', $spelld_array);
    $smarty->assign('pagination2', generate_pagination('index.php?page=spelldisabled&order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1).( $search_value && $search_by ? '&amp;search_by='.$search_by.'&amp;search_value='.$search_value.'' : '' ), $all_record, $itemperpage, $start));

    $smarty->display('spelldisabled.tpl');
    $smarty->clear_all_assign();
}


//#####################################################################################################
//  ADD NEW SPELL
//#######################################################################################################
function add_new()
{
    global $lang_global, $lang_spelld, $smarty;

    $smarty->assign('lang_spelld', $lang_spelld);
    $smarty->assign('lang_global', $lang_global);
    
    $smarty->display('spelldisabled_add.tpl');
    $smarty->clear_all_assign();
}

//#########################################################################################################
// DO ADD NEW SPELL
//#########################################################################################################
function doadd_new()
{
    global $sqlw;

    if (empty($_GET['entry']) && empty($_GET['flags']) && empty($_GET['comment']))
        redirect('index.php?page=spelldisabled&error=1');


    $entry = sanitize_int($_GET['entry']);
    $flags = sanitize_int($_GET['flags']);
    if ($entry>0 && $flags>0);
    else
        redirect('index.php?page=spelldisabled&error=6');
        
    $comment = sanitize_sql_string($_GET['comment']);

    $sqlw->action("INSERT INTO disables (sourceType, entry, flags, comment) VALUES (0, '%d', '%d', '%s')", $entry, $flags, $comment);
    
    if ($sqlw->affected_rows())
        redirect('index.php?page=spelldisabled&error=8');
    else
        redirect('index.php?page=spelldisabled&error=7');
}


//#####################################################################################################
//  DELETE SPELL
//#####################################################################################################
function del_spell()
{
    global $sqlw;

    if(isset($_GET['check']))
        $check = $_GET['check'];
    else 
        redirect("index.php?page=spelldisabled&error=1");

    $n_check=count($check);

    if ($n_check > 0 && is_array($check))
        foreach ($check as $tmp)
            $tmp = sanitize_int($tmp);
            
    for ($i=0; $i<$n_check; ++$i)
        if ($check[$i] == '' || !is_numeric($check[$i]));
        else
            $sqlw->action("DELETE FROM disables WHERE `entry` = %d AND `sourceType` = 0", $check[$i]);

    unset($n_check);
    unset($check);

    if ($sqlw->affected_rows())
        redirect('index.php?page=spelldisabled&error=4');
    else
        redirect('sindex.php?page=spelldisabled&error=5');
}


//#############################################################################
// MAIN
//#############################################################################
$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

$lang_spelld = lang_spelld();

switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
        
    case 2:
        $smarty->assign('error', $lang_global['err_no_search_passed']);
        break;
        
    case 4:
        $smarty->assign('error', $lang_spelld['spell_deleted']);
        break;
        
    case 5:
        $smarty->assign('error', $lang_spelld['spell_not_deleted']);
        break;
        
    case 6:
        $smarty->assign('error', $lang_spelld['wrong_fields']);
        break;
        
    case 7:
        $smarty->assign('error', $lang_spelld['err_add_entry']);
        break;
        
    case 8:
        $smarty->assign('error', $lang_spelld['spell_added']);
        break;
        
    default: //no error
        $err = -1;
}

if ($err == 3)
    $smarty->assign('headline', $lang_spelld['search_results']);
else
    $smarty->assign('headline', $lang_spelld['spells']);

if ($err != -1 && $err != 3) //3 is a special case; shown as headline
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();
unset($err);

$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action)
{
    case "add_new":
        add_new();
        break;
        
    case "doadd_new":
        doadd_new();
        break;
    
    case "del_spell":
        del_spell();
        break;
    
    default:
        browse_spells();
}

unset($action);
unset($lang_spelld);
?>
