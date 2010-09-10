<?php
require_once 'libs/char.lib.php';

function top100()
{
    global $lang_top, $server, $realm_id, $itemperpage, $sqlc, $sqla, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
    
    //==========================$_GET and SECURE========================
    $type = (isset($_GET['type'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['type']) : 'level';

    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if ($start < 1) 
        $start=0;

    $order_by = (isset($_GET['order_by'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['order_by']) : 'level';

    $dir = (isset($_GET['dir'])) ? sanitize_int($_GET['dir']) : 1;
    if (!preg_match('/^[01]{1}$/', $dir))
        $dir=1;

    $order_dir = ($dir) ? 'DESC' : 'DESC';
    $dir = ($dir) ? 0 : 1;
    //==========================$_GET and SECURE end========================

    $type_list = array('level', 'stat', 'defense', 'attack', 'resist', 'crit_hit', 'pvp');
    if (in_array($type, $type_list));
    else 
        $type = 'level';

    $result = $sqlc->fetch("SELECT count(*) as `count` FROM characters");
    $all_record = $result[0]->count;
    $all_record = (($all_record < 100) ? $all_record : 100);

    $result = $sqlc->fetch("SELECT characters.guid, characters.name, characters.race, characters.class, characters.gender, characters.level, characters.totaltime, characters.online, characters.money, COALESCE(guild_member.guildid,0) as gname, character_stats.maxhealth as health, characters.power1 AS mana, character_stats.strength AS str, character_stats.agility AS agi, character_stats.stamina AS sta,
                            character_stats.intellect AS intel, character_stats.spirit AS spi, character_stats.armor, character_stats.blockPct AS block, character_stats.dodgePct AS dodge, character_stats.parryPct AS parry, character_stats.attackPower AS ap, character_stats.rangedAttackPower AS ranged_ap, character_stats.resHoly AS holy, character_stats.resFire AS fire, 
                            character_stats.resNature AS nature, character_stats.resFrost AS frost, character_stats.resShadow AS shadow, character_stats.resArcane AS arcane, character_stats.critPct AS melee_crit, character_stats.rangedCritPct AS range_crit, characters.totalHonorPoints AS honor, characters.totalKills AS kills, characters.arenaPoints AS arena
                            FROM characters LEFT JOIN character_stats ON character_stats.guid = characters.guid LEFT JOIN guild_member ON guild_member.guid = characters.guid ORDER BY %s %s LIMIT %d, %d", $order_by, $order_dir, $start, $itemperpage);
    //mindmg,maxdmg,minrangeddmg,maxrangeddmg,expertise,off_expertise,meleehit,rangehit,spellhit missing

    //==========================top tage navigaion starts here========================
    $smarty->assign('lang_top', $lang_top);
    $smarty->assign('type', $type);
    $smarty->assign('start', $start);
    $smarty->assign('order_by', $order_by);
    $smarty->assign('dir', $dir);
    $smarty->assign('all_record', $all_record);
    $smarty->assign('realm_id', $realm_id);
    $smarty->assign('pagination', generate_pagination('index.php?page=top100&type='.$type.'&amp;order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1).'', $all_record, $itemperpage, $start));

    //==========================top tage navigaion ENDS here ========================

    $i=0;
    $char_array = array();
    if ($sqlc->num_rows())
        foreach($result as $char)
        {
            $i++;

            $chartype_additional = array();
            if ($type === 'level')
            {
                $guild_name = $sqlc->fetch("SELECT name FROM guild WHERE guildid = %d", $char->gname);
                $guild_name = $guild_name[0]->name;
                $days  = floor(round($char->totaltime / 3600)/24);
                $hours = round($char->totaltime / 3600) - ($days * 24);
                $time = '';
                
                if ($days)
                    $time .= $days.' days ';
                    
                if ($hours)
                    $time .= $hours.' hours';
            
                $top_money = $char->money;
                $money_gold = (int)($top_money/10000);
                $total_money = $top_money - ($money_gold*10000);
                $money_silver = (int)($total_money/100);
                $money_copper = $total_money - ($money_silver*100);

                $chartype_additional = array("guild_name" => $guild_name, "money_gold" => $money_gold, "money_silver" => $money_silver, "money_copper" => $money_copper, "time" => $time);
            }
            elseif ($type === 'defense')
            {
                $block = unpack('f', pack('L', $char->block));
                $block = round($block[1],2);
                $dodge = unpack('f', pack('L', $char->dodge));
                $dodge = round($dodge[1],2);
                $parry = unpack('f', pack('L', $char->parry));
                $parry = round($parry[1],2);

                $chartype_additional = array("block_p" => $block, "dodge_p" => $dodge, "parry_p" => $parry);
            }
            elseif ($type === 'pvp')
                $chartype_additional = array("pvprankname" => char_get_pvp_rank_name($char->honor, char_get_side_id($char->race)), "pvprankid" => char_get_pvp_rank_id($char->honor, char_get_side_id($char->race)));

            $char_tmp = array("num" => $i+$start, "classname" => char_get_class_name($char->class), "racename" => char_get_race_name($char->race), "levelcolor" => char_get_level_color($char->level),);
            $char_tmp = array_merge($char_tmp, $chartype_additional);
            $char_array[] = array_merge(get_object_vars($char), $char_tmp);
        }
    $smarty->assign('char_array', $char_array);
    
    $smarty->display('top100.tpl');
    $smarty->clear_all_assign();
}

$lang_top = lang_top();

$action = (isset($_POST['action'])) ? $_POST['action'] : NULL;

$smarty->assign('headline', $lang_top['top100']);

$smarty->display("headline.tpl");
$smarty->clear_all_assign();

top100();

?>
