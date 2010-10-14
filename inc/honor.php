<?php
require_once("libs/char.lib.php");

if (!getPermission('read'))
    redirect('index.php?page=login&error=5');

//global $lang_honor, $lang_global, $output, $characters_db, $realm_id, $itemperpage, $realm_db;

$order_by = (isset($_GET['order_by'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['order_by']) : "honor";
if (!preg_match("/^[_[:lower:]]{1,15}$/", $order_by)) 
    $order_by="honor";
    
$query = $sqlc->fetch("SELECT C.guid, C.name, C.race, C.class, C.todayHonorPoints AS honor , C.totalKills AS kills, C.level, C.arenaPoints AS arena, COALESCE(guild_member.guildid,0) as guild, C.gender FROM characters C LEFT JOIN guild_member ON C.guid = guild_member.guid WHERE race in (1,3,4,7,11) ORDER BY %s DESC LIMIT 25;", $order_by);

$smarty->assign('lang_global', $lang_global);
$smarty->assign('lang_honor', $lang_honor);
$smarty->assign('order_by', $order_by);

$char_array = array();
foreach ($query as $char)
{
    $guild_name = $sqlc->fetch("SELECT `name` FROM `guild` WHERE `guildid`=%d;", $char->guild);
    $guild_name = ($guild_name[0]) ? $guild_name[0]->name : "";
    
    $char_tmp = array("guildname" => $guild_name, "classname" => char_get_class_name($char->class), "racename" => char_get_race_name($char->race), "levelcolor" => char_get_level_color($char->level),
                    "pvprankname" => char_get_pvp_rank_name($char->honor, char_get_side_id($char->race)), "pvprankid" => char_get_pvp_rank_id($char->honor, char_get_side_id($char->race)));
    $char_array[] = array_merge(get_object_vars($char), $char_tmp);
}
$smarty->assign('char_array_alliance', $char_array);

$query = $sqlc->fetch("SELECT C.guid, C.name, C.race, C.class, C.todayHonorPoints AS honor , C.totalKills AS kills, C.level, C.arenaPoints AS arena, COALESCE(guild_member.guildid,0) as guild, C.gender FROM characters C LEFT JOIN guild_member ON C.guid = guild_member.guid WHERE race not in (1,3,4,7,11) ORDER BY %s DESC LIMIT 25;", $order_by);
$char_array = array();
foreach ($query as $char)
{
    $guild_name = $sqlc->fetch("SELECT `name` FROM `guild` WHERE `guildid`=%d;", $char->guild);
    $guild_name = ($guild_name[0]) ? $guild_name[0]->name : "";
    
    $char_tmp = array("guildname" => $guild_name, "classname" => char_get_class_name($char->class), "racename" => char_get_race_name($char->race), "levelcolor" => char_get_level_color($char->level),
                    "pvprankname" => char_get_pvp_rank_name($char->honor, char_get_side_id($char->race)), "pvprankid" => char_get_pvp_rank_id($char->honor, char_get_side_id($char->race)));
    $char_array[] = array_merge(get_object_vars($char), $char_tmp);
}
$smarty->assign('char_array_horde', $char_array);

$smarty->display('honor.tpl');
$smarty->clear_all_assign();
?>
