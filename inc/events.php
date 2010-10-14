<?php
//#############################################################################
// EVENTS
//#############################################################################
function events()
{
    global $lang_events, $itemperpage, $sqlw, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
        
    //-------------------SQL Injection Prevention--------------------------------
    // this page has multipage support and field ordering, so we need these
    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;

    $order_by = (isset($_GET['order_by'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['order_by']) : 'description';

    $dir = (isset($_GET['dir'])) ? sanitize_int($_GET['dir']) : 1;
    if (preg_match('/^[01]{1}$/', $dir)); 
    else 
        $dir=1;

    $order_dir = ($dir) ? 'ASC' : 'DESC';
    $dir = ($dir) ? 0 : 1;

    // for multipage support
    $all_record = $sqlw->fetch("SELECT count(*) AS `count` FROM game_event WHERE start_time <> end_time");
    $all_record = $all_record[0]->count;

    // main data that we need for this page, game events
    $result = $sqlw->fetch("SELECT description, start_time, occurence, length
                            FROM game_event WHERE start_time <> end_time ORDER BY %s %s LIMIT %d, %d", $order_by, $order_dir, $start, $itemperpage);

    $smarty->assign('lang_events', $lang_events);
    $smarty->assign('all_record', $all_record);
    $smarty->assign('start', $start);
    $smarty->assign('dir', $dir);
    $smarty->assign('order_by', $order_by);
    $smarty->assign('order_dir', $order_dir);
    $smarty->assign('pagination', generate_pagination('index.php?page=events&order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1), $all_record, $itemperpage, $start));

    $event_data = array();
    foreach ($result as $events)
    {
        $days  = floor(round($events->occurence / 60) / 24);
        $hours = round($events->occurence / 60) - ($days * 24);
        $event_occurance = '';
        
        if ($days)
            $event_occurance .= $days.' days ';
        if ($hours)
            $event_occurance .= $hours.' hours';
            
        $days  = floor(round($events->length / 60) / 24);
        $hours = round($events->length / 60) - ($days * 24);
        $event_duration = '';
        if ($days)
            $event_duration .= $days.' days ';
        if ($hours)
            $event_duration .= $hours.' hours';
            
        $event_data[] = array("description" => $events->description, "start_time" => $events->start_time, "occurance" => $event_occurance, "duration" => $event_duration);
    }
    $smarty->assign('event_data', $event_data);

    $smarty->display('events.tpl');
    $smarty->clear_all_assign();
}
//#############################################################################
// MAIN
//#############################################################################
// error variable reserved for future use
//$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

//unset($err);

$lang_events = lang_events();

$smarty->assign('headline', $lang_events['events']);

$smarty->display("headline.tpl");
$smarty->clear_all_assign();

// action variable reserved for future use
//$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

events();

?>
