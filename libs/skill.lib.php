<?php


//#############################################################################
//get skill type by its id

function skill_get_type($id)
{
    global $sqlm;
    $skill_type = $sqlm->fetch("SELECT field_1 FROM dbc_skillline WHERE id = %d LIMIT 1", $id);
    return $skill_type[0]->field_1;
}


//#############################################################################
//get skill name by its id

function skill_get_name($id)
{
    global $sqlm;
    $skill_type = $sqlm->fetch("SELECT field_3 FROM dbc_skillline WHERE id = %d LIMIT 1", $id);
    return $skill_type[0]->field_3;
}


?>