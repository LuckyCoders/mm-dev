<?php
error_reporting(E_ALL);

//#############################################################################
//get map name by its id

function get_map_name($id)
{
    global $sqlm;
    
    $map_name = $sqlm->fetch("SELECT name01 FROM dbc_map WHERE id=%d LIMIT 1", $id);
    return $map_name[0]->name01;
}


//#############################################################################
//get zone name by its id

function get_zone_name($id)
{
    global $sqlm;
    
    $zone_name = $sqlm->fetch("SELECT name01 FROM dbc_areatable WHERE id=%d LIMIT 1", $id);
    return $zone_name[0]->name01;
}


?>