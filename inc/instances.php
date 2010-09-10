<?php
require_once 'libs/map_zone.lib.php';

//#############################################################################
// INSTANCES
//#############################################################################
function instances()
{
    global $lang_instances, $sqlw, $sqlm, $itemperpage, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
    
    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if ($start>1); 
    else 
        $start=0;

    $order_by = (isset($_GET['order_by'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['order_by']) : 'level_min';
    if (preg_match('/^[_[:lower:]]{1,11}$/', $order_by)); 
    else 
        $order_by='level_min';

    $dir = (isset($_GET['dir'])) ? $_GET['dir'] : 1;
    if (preg_match('/^[01]{1}$/', $dir)); 
    else 
        $dir=1;

    $order_dir = ($dir) ? 'ASC' : 'DESC';
    $dir = ($dir) ? 0 : 1;

    // for multipage support
    $all_record = $sqlw->fetch("SELECT count(*) AS `count` FROM instance_template WHERE map IN (SELECT DISTINCT target_map FROM access_requirement LEFT JOIN areatrigger_teleport ON areatrigger_teleport.id = access_requirement.mapId WHERE target_map IN (SELECT map FROM instance_template))");
    $all_record = $all_record[0]->count;

    // needs to be corrected, there are only 5 instances that have an entry with their mapid in access_requirement, areatrigger_teleport is used mostly
    $result = $sqlw->fetch("SELECT DISTINCT target_map AS map, level_min,level_max
                            FROM access_requirement LEFT JOIN areatrigger_teleport ON areatrigger_teleport.id = access_requirement.mapId WHERE target_map IN (SELECT map FROM instance_template) ORDER BY %s %s LIMIT %d, %d;", $order_by, $order_dir, $start, $itemperpage);

    $smarty->assign('lang_instances', $lang_instances);
    $smarty->assign('pagination', generate_pagination('index.php?page=instances&order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1), $all_record, $itemperpage, $start));
    $smarty->assign('all_record', $all_record);
    $smarty->assign('start', $start);
    $smarty->assign('dir', $dir);
    $smarty->assign('order_by', $order_by);

    $instance_data = array();
    foreach ($result as $instances)
    {
        /*
            $days  = floor(round($instances['reset_delay'] / 3600) / 24);
            $hours = round($instances['reset_delay'] / 3600) - ($days * 24);
            $reset = "";
            if ($days)
                $reset .= $days.' days';
            if ($hours)
                $reset .= $hours.' hours';*/
        $instance_data[] = array("mapname" => get_map_name($instances->map), "map" => $instances->map, "level_min" => $instances->level_min, "level_max" => $instances->level_max);
    }
    $smarty->assign('instance_data', $instance_data);
            
    $smarty->display('instances.tpl');
    $smarty->clear_all_assign();
}


//#############################################################################
// MAIN
//#############################################################################

$lang_instances = lang_instances();

$smarty->assign('headline', $lang_instances['instances']);

$smarty->display("headline.tpl");
$smarty->clear_all_assign();

// action variable reserved for future use
//$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

instances();

?>
