<?php
error_reporting(E_ALL);
require_once 'libs/char.lib.php';
require_once 'libs/item.lib.php';
require_once 'libs/spell.lib.php';
require_once 'libs/map_zone.lib.php';

//########################################################################################################################
// SHOW GENERAL CHARACTERS INFO
//########################################################################################################################
function char_main()
{
    global $lang_global, $lang_char, $lang_item,
            $realm_id, $realm_db, $characters_db, $world_db, $server, $user_lvl, $user_name, $user_id,
            $item_datasite, $spell_datasite , $showcountryflag, $sqla, $sqlm, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
            
    // this page uses wowhead tooltops
    wowhead_tt();

    if (empty($_GET['id']))
        redirect('index.php?page=char&error=1&id=NULL');
    $id = sanitize_int($_GET['id']);
    
    if (empty($_GET['realm']))
    {
        $realmid = $realm_id;
        global $sqlc, $sqlw;
    }
    else
    {
        $realmid = sanitize_int($_GET['realm']);
        if (is_numeric($realmid))
        {
            $sqlc = new MySQL($characters_db[$realmid]);
            $sqlw = new MySQL($world_db[$realmid]);
        }
        else
        {
            global $sqlc, $sqlw;
            
            $realmid = $realm_id;
        }
    }
    
    $smarty->assign('action', 'char_main');
    $smarty->assign('lang_char', $lang_char);
    $smarty->assign('lang_item', $lang_item);
    $smarty->assign('lang_global', $lang_global);
    $smarty->assign('id', $id);
    $smarty->assign('realmid', $realmid);

    $result = $sqlc->fetch("SELECT account, race FROM characters WHERE guid = %d LIMIT 1", $id);

    if ($sqlc->num_rows($result))
    {
        //restrict by owner's gmlvl
        $owner_acc_id = $result[0]->account;
        $query = $sqla->fetch("SELECT `username`, `gmlevel` FROM `account` LEFT JOIN `account_access` ON `account`.`id`=`account_access`.`id` WHERE `account`.`id` = %d ORDER BY `gmlevel` DESC LIMIT 1", $owner_acc_id);
        $owner_name = $query[0]->username;
        $owner_gmlvl = $query[0]->gmlevel;
        
        if (empty($owner_gmlvl))
            $owner_gmlvl = 0;
        
        $smarty->assign('higherLevelGM', $user_lvl > $owner_gmlvl);
        
        if($user_lvl || $server[$realmid]['both_factions'])
        {
            $side_v = 0;
            $side_p = 0;
        }
        else
        {
            $side_p = (in_array($result[0]->race,array(2,5,6,8,10))) ? 1 : 2;
            $result_1 = $sqlc->fetch("SELECT race FROM characters WHERE account = %d LIMIT 1", $user_id);
            
            if ($sqlc->num_rows($result))
                $side_v = (in_array($result_1[0]->race, array(2,5,6,8,10))) ? 1 : 2;
            else
                $side_v = 0;
                
            unset($result_1);
        }

        if ($user_lvl >= $owner_gmlvl && (($side_v === $side_p) || !$side_v))
        {
            $result = $sqlc->fetch("SELECT characters.equipmentCache, characters.name, characters.race, characters.class, characters.level, characters.zone, characters.map, characters.online, characters.totaltime, characters.gender, characters.account, character_stats.blockPct,
                                    character_stats.dodgePct, character_stats.parryPct, character_stats.critPct, character_stats.rangedCritPct, character_stats.spellCritPct, COALESCE(guild_member.guildid,0) AS guildid, COALESCE(guild_member.rank,0) AS rank, 
                                    characters.totalHonorPoints, characters.arenaPoints, characters.totalKills, character_stats.maxhealth, character_stats.maxpower1, character_stats.strength, character_stats.agility, character_stats.stamina, character_stats.intellect,
                                    character_stats.spirit, character_stats.armor, character_stats.resHoly, character_stats.resFire, character_stats.resNature, character_stats.resFrost, character_stats.resShadow, character_stats.resArcane, character_stats.attackPower,
                                    character_stats.rangedAttackPower, character_stats.spellPower, characters.power2, character_stats.maxpower2, characters.power4, character_stats.maxpower4, characters.power3, character_stats.maxpower3   
                                    FROM characters LEFT JOIN character_stats ON characters.guid = character_stats.guid LEFT JOIN guild_member ON characters.guid = guild_member.guid WHERE characters.guid = %d", $id);
                                    
            $char = get_object_vars($result[0]);
            $eq_data = explode(' ',$char['equipmentCache']);
            
            $smarty->assign('char', $char);
            $smarty->assign('owner_acc_id', $owner_acc_id);
            
            $online = ($char['online']) ? $lang_char['online'] : $lang_char['offline'];

            if($char['guildid'] && $char['guildid'] != 0)
            {
                $guild_name = $sqlc->fetch("SELECT name FROM guild WHERE guildid = %d", $char['guildid']);
                $guild_name = '<a href="index.php?page=guild&action=view_guild&amp;realm='.$realmid.'&amp;error=3&amp;id='.$char['guildid'].'" >'.$guild_name[0]->name.'</a>';
                $mrank = $char['rank'];
                $guild_rank = $sqlc->fetch("SELECT rname FROM guild_rank WHERE guildid = %d AND rid = %d", $char['guildid'], $mrank);
                $guild_rank = $guild_rank[0]->rname;
            }
            else
            {
                $guild_name = $lang_global['none'];
                $guild_rank = $lang_global['none'];
            }

            $smarty->assign('guild_name', $guild_name);
            $smarty->assign('guild_rank', $guild_rank);
            
            $block       = round($char['blockPct'],2);
            $dodge       = round($char['dodgePct'],2);
            $parry       = round($char['parryPct'],2);
            $crit        = round($char['critPct'],2);
            $ranged_crit = round($char['rangedCritPct'],2);
            $spell_crit = round($char['spellCritPct'],2);
            $spell_damage = $char['spellPower'];
            $rage       = round($char['power2'] / 10);
            $maxrage    = round($char['maxpower2'] / 10);
      
            //preventing undefined variables, didnt want to remove all this stuff so just filling the missing variables with 0
            /*define('CHAR_DATA_OFFSET_MELEE_HIT',0);
            define('CHAR_DATA_OFFSET_SPELL_HEAL',1);
            define('CHAR_DATA_OFFSET_SPELL_HIT',2);
            define('CHAR_DATA_OFFSET_SPELL_HASTE_RATING',3);
            define('CHAR_DATA_OFFSET_RESILIENCE',4);
            define('CHAR_DATA_OFFSET_RANGE_HIT',5);*/
            $char_data = array("CHAR_DATA_OFFSET_MELEE_HIT" => 0, "CHAR_DATA_OFFSET_SPELL_HEAL" => 0, "CHAR_DATA_OFFSET_SPELL_HIT" => 0, "CHAR_DATA_OFFSET_SPELL_HASTE_RATING" => 0, "CHAR_DATA_OFFSET_RESILIENCE" => 0, "CHAR_DATA_OFFSET_RANGE_HIT" => 0);
            //$char_data = array(0,0,0,0,0,0);
            $maxdamage = 0;
            $mindamage = 0;
            $maxrangeddamage = 0;
            $minrangeddamage = 0;
            $expertise = 0;
            
            $cstats = array("block" => $block, "dodge" => $dodge, "parry" => $parry, "crit" => $crit, "ranged_crit" => $ranged_crit, "spell_crit" => $spell_crit, "spell_damage" => $spell_damage, "rage" => $rage, "maxrage" => $maxrage, "maxdamage" => 0, "mindamage" => 0, "maxrangeddamage" => 0, "minrangeddamage" => 0, "expertise" => 0);
            $smarty->assign('charstats', $cstats);
            $smarty->assign('char_data', $char_data);

            $EQU_HEAD      = $eq_data[EQ_DATA_OFFSET_EQU_HEAD];
            $EQU_NECK      = $eq_data[EQ_DATA_OFFSET_EQU_NECK];
            $EQU_SHOULDER  = $eq_data[EQ_DATA_OFFSET_EQU_SHOULDER];
            $EQU_SHIRT     = $eq_data[EQ_DATA_OFFSET_EQU_SHIRT];
            $EQU_CHEST     = $eq_data[EQ_DATA_OFFSET_EQU_CHEST];
            $EQU_BELT      = $eq_data[EQ_DATA_OFFSET_EQU_BELT];
            $EQU_LEGS      = $eq_data[EQ_DATA_OFFSET_EQU_LEGS];
            $EQU_FEET      = $eq_data[EQ_DATA_OFFSET_EQU_FEET];
            $EQU_WRIST     = $eq_data[EQ_DATA_OFFSET_EQU_WRIST];
            $EQU_GLOVES    = $eq_data[EQ_DATA_OFFSET_EQU_GLOVES];
            $EQU_FINGER1   = $eq_data[EQ_DATA_OFFSET_EQU_FINGER1];
            $EQU_FINGER2   = $eq_data[EQ_DATA_OFFSET_EQU_FINGER2];
            $EQU_TRINKET1  = $eq_data[EQ_DATA_OFFSET_EQU_TRINKET1];
            $EQU_TRINKET2  = $eq_data[EQ_DATA_OFFSET_EQU_TRINKET2];
            $EQU_BACK      = $eq_data[EQ_DATA_OFFSET_EQU_BACK];
            $EQU_MAIN_HAND = $eq_data[EQ_DATA_OFFSET_EQU_MAIN_HAND];
            $EQU_OFF_HAND  = $eq_data[EQ_DATA_OFFSET_EQU_OFF_HAND];
            $EQU_RANGED    = $eq_data[EQ_DATA_OFFSET_EQU_RANGED];
            $EQU_TABARD    = $eq_data[EQ_DATA_OFFSET_EQU_TABARD];
            /*
            // reserved incase we want to use back minimanagers' built in tooltip, instead of wowheads'
            // minimanagers' item tooltip needs updating, but it can show enchantments and sockets.

                  $equiped_items = array
                  (
                     1 => array(($EQU_HEAD      ? get_item_tooltip($EQU_HEAD)      : 0),($EQU_HEAD      ? get_item_icon($EQU_HEAD)      : 0),($EQU_HEAD      ? get_item_border($EQU_HEAD)      : 0)),
                     2 => array(($EQU_NECK      ? get_item_tooltip($EQU_NECK)      : 0),($EQU_NECK      ? get_item_icon($EQU_NECK)      : 0),($EQU_NECK      ? get_item_border($EQU_NECK)      : 0)),
                     3 => array(($EQU_SHOULDER  ? get_item_tooltip($EQU_SHOULDER)  : 0),($EQU_SHOULDER  ? get_item_icon($EQU_SHOULDER)  : 0),($EQU_SHOULDER  ? get_item_border($EQU_SHOULDER)  : 0)),
                     4 => array(($EQU_SHIRT     ? get_item_tooltip($EQU_SHIRT)     : 0),($EQU_SHIRT     ? get_item_icon($EQU_SHIRT)     : 0),($EQU_SHIRT     ? get_item_border($EQU_SHIRT)     : 0)),
                     5 => array(($EQU_CHEST     ? get_item_tooltip($EQU_CHEST)     : 0),($EQU_CHEST     ? get_item_icon($EQU_CHEST)     : 0),($EQU_CHEST     ? get_item_border($EQU_CHEST)     : 0)),
                     6 => array(($EQU_BELT      ? get_item_tooltip($EQU_BELT)      : 0),($EQU_BELT      ? get_item_icon($EQU_BELT)      : 0),($EQU_BELT      ? get_item_border($EQU_BELT)      : 0)),
                     7 => array(($EQU_LEGS      ? get_item_tooltip($EQU_LEGS)      : 0),($EQU_LEGS      ? get_item_icon($EQU_LEGS)      : 0),($EQU_LEGS      ? get_item_border($EQU_LEGS)      : 0)),
                     8 => array(($EQU_FEET      ? get_item_tooltip($EQU_FEET)      : 0),($EQU_FEET      ? get_item_icon($EQU_FEET)      : 0),($EQU_FEET      ? get_item_border($EQU_FEET)      : 0)),
                     9 => array(($EQU_WRIST     ? get_item_tooltip($EQU_WRIST)     : 0),($EQU_WRIST     ? get_item_icon($EQU_WRIST)     : 0),($EQU_WRIST     ? get_item_border($EQU_WRIST)     : 0)),
                    10 => array(($EQU_GLOVES    ? get_item_tooltip($EQU_GLOVES)    : 0),($EQU_GLOVES    ? get_item_icon($EQU_GLOVES)    : 0),($EQU_GLOVES    ? get_item_border($EQU_GLOVES)    : 0)),
                    11 => array(($EQU_FINGER1   ? get_item_tooltip($EQU_FINGER1)   : 0),($EQU_FINGER1   ? get_item_icon($EQU_FINGER1)   : 0),($EQU_FINGER1   ? get_item_border($EQU_FINGER1)   : 0)),
                    12 => array(($EQU_FINGER2   ? get_item_tooltip($EQU_FINGER2)   : 0),($EQU_FINGER2   ? get_item_icon($EQU_FINGER2)   : 0),($EQU_FINGER2   ? get_item_border($EQU_FINGER2)   : 0)),
                    13 => array(($EQU_TRINKET1  ? get_item_tooltip($EQU_TRINKET1)  : 0),($EQU_TRINKET1  ? get_item_icon($EQU_TRINKET1)  : 0),($EQU_TRINKET1  ? get_item_border($EQU_TRINKET1)  : 0)),
                    14 => array(($EQU_TRINKET2  ? get_item_tooltip($EQU_TRINKET2)  : 0),($EQU_TRINKET2  ? get_item_icon($EQU_TRINKET2)  : 0),($EQU_TRINKET2  ? get_item_border($EQU_TRINKET2)  : 0)),
                    15 => array(($EQU_BACK      ? get_item_tooltip($EQU_BACK)      : 0),($EQU_BACK      ? get_item_icon($EQU_BACK)      : 0),($EQU_BACK      ? get_item_border($EQU_BACK)      : 0)),
                    16 => array(($EQU_MAIN_HAND ? get_item_tooltip($EQU_MAIN_HAND) : 0),($EQU_MAIN_HAND ? get_item_icon($EQU_MAIN_HAND) : 0),($EQU_MAIN_HAND ? get_item_border($EQU_MAIN_HAND) : 0)),
                    17 => array(($EQU_OFF_HAND  ? get_item_tooltip($EQU_OFF_HAND)  : 0),($EQU_OFF_HAND  ? get_item_icon($EQU_OFF_HAND)  : 0),($EQU_OFF_HAND  ? get_item_border($EQU_OFF_HAND)  : 0)),
                    18 => array(($EQU_RANGED    ? get_item_tooltip($EQU_RANGED)    : 0),($EQU_RANGED    ? get_item_icon($EQU_RANGED)    : 0),($EQU_RANGED    ? get_item_border($EQU_RANGED)    : 0)),
                    19 => array(($EQU_TABARD    ? get_item_tooltip($EQU_TABARD)    : 0),($EQU_TABARD    ? get_item_icon($EQU_TABARD)    : 0),($EQU_TABARD    ? get_item_border($EQU_TABARD)    : 0))
                  );
            */

            $equiped_items = array
            (
                1 => array('',($EQU_HEAD        ? get_item_icon($EQU_HEAD, $sqlm, $sqlw)      : 0),($EQU_HEAD      ? get_item_border($EQU_HEAD, $sqlw)      : 0)),
                2 => array('',($EQU_NECK        ? get_item_icon($EQU_NECK, $sqlm, $sqlw)      : 0),($EQU_NECK      ? get_item_border($EQU_NECK, $sqlw)      : 0)),
                3 => array('',($EQU_SHOULDER    ? get_item_icon($EQU_SHOULDER, $sqlm, $sqlw)  : 0),($EQU_SHOULDER  ? get_item_border($EQU_SHOULDER, $sqlw)  : 0)),
                4 => array('',($EQU_SHIRT       ? get_item_icon($EQU_SHIRT, $sqlm, $sqlw)     : 0),($EQU_SHIRT     ? get_item_border($EQU_SHIRT, $sqlw)     : 0)),
                5 => array('',($EQU_CHEST       ? get_item_icon($EQU_CHEST, $sqlm, $sqlw)     : 0),($EQU_CHEST     ? get_item_border($EQU_CHEST, $sqlw)     : 0)),
                6 => array('',($EQU_BELT        ? get_item_icon($EQU_BELT, $sqlm, $sqlw)      : 0),($EQU_BELT      ? get_item_border($EQU_BELT, $sqlw)      : 0)),
                7 => array('',($EQU_LEGS        ? get_item_icon($EQU_LEGS, $sqlm, $sqlw)      : 0),($EQU_LEGS      ? get_item_border($EQU_LEGS, $sqlw)      : 0)),
                8 => array('',($EQU_FEET        ? get_item_icon($EQU_FEET, $sqlm, $sqlw)      : 0),($EQU_FEET      ? get_item_border($EQU_FEET, $sqlw)      : 0)),
                9 => array('',($EQU_WRIST       ? get_item_icon($EQU_WRIST, $sqlm, $sqlw)     : 0),($EQU_WRIST     ? get_item_border($EQU_WRIST, $sqlw)     : 0)),
                10 => array('',($EQU_GLOVES     ? get_item_icon($EQU_GLOVES, $sqlm, $sqlw)    : 0),($EQU_GLOVES    ? get_item_border($EQU_GLOVES, $sqlw)    : 0)),
                11 => array('',($EQU_FINGER1    ? get_item_icon($EQU_FINGER1, $sqlm, $sqlw)   : 0),($EQU_FINGER1   ? get_item_border($EQU_FINGER1, $sqlw)   : 0)),
                12 => array('',($EQU_FINGER2    ? get_item_icon($EQU_FINGER2, $sqlm, $sqlw)   : 0),($EQU_FINGER2   ? get_item_border($EQU_FINGER2, $sqlw)   : 0)),
                13 => array('',($EQU_TRINKET1   ? get_item_icon($EQU_TRINKET1, $sqlm, $sqlw)  : 0),($EQU_TRINKET1  ? get_item_border($EQU_TRINKET1, $sqlw)  : 0)),
                14 => array('',($EQU_TRINKET2   ? get_item_icon($EQU_TRINKET2, $sqlm, $sqlw)  : 0),($EQU_TRINKET2  ? get_item_border($EQU_TRINKET2, $sqlw)  : 0)),
                15 => array('',($EQU_BACK       ? get_item_icon($EQU_BACK, $sqlm, $sqlw)      : 0),($EQU_BACK      ? get_item_border($EQU_BACK, $sqlw)      : 0)),
                16 => array('',($EQU_MAIN_HAND  ? get_item_icon($EQU_MAIN_HAND, $sqlm, $sqlw) : 0),($EQU_MAIN_HAND ? get_item_border($EQU_MAIN_HAND, $sqlw) : 0)),
                17 => array('',($EQU_OFF_HAND   ? get_item_icon($EQU_OFF_HAND, $sqlm, $sqlw)  : 0),($EQU_OFF_HAND  ? get_item_border($EQU_OFF_HAND, $sqlw)  : 0)),
                18 => array('',($EQU_RANGED     ? get_item_icon($EQU_RANGED, $sqlm, $sqlw)    : 0),($EQU_RANGED    ? get_item_border($EQU_RANGED, $sqlw)    : 0)),
                19 => array('',($EQU_TABARD     ? get_item_icon($EQU_TABARD, $sqlm, $sqlw)    : 0),($EQU_TABARD    ? get_item_border($EQU_TABARD, $sqlw)    : 0))
            );

            if (($user_lvl > $owner_gmlvl)||($owner_name === $user_name))
            {
                $smarty->assign('hasHigherGMLevel', true);
                if (char_get_class_name($char['class']) === 'Hunter' )
                    $smarty->assign('showPets', true);
            }

            $smarty->assign('char_avatar_img', char_get_avatar_img($char['level'], $char['gender'], $char['race'], $char['class'], 0));
                                        
            $a_results = $sqlc->fetch("SELECT DISTINCT spell FROM character_aura WHERE guid = %d", $id);
            $char_auras = array();
            if ($sqlc->num_rows($a_results)) 
                foreach ($a_results as $aura)
                    $char_auras[] = array("link" => $spell_datasite.$aura->spell, "icon" => spell_get_icon($aura->spell), "spell" => $aura->spell);

            $smarty->assign('char_auras', $char_auras);
            unset($char_auras);
            
            $char_additional = array("zonename" => get_zone_name($char['zone']), "mapname" => get_map_name($char['map']), "racename" => char_get_race_name($char['race']), "classname" => char_get_class_name($char['class']), "lvlcolor" => char_get_level_color($char['level']));;
            $smarty->assign('char_additional', $char_additional);

            if ($showcountryflag)
            {
                require_once 'libs/misc.lib.php';
                $country = misc_get_country_by_account($char['account']);
                $smarty->assign('showcountryflag', $showcountryflag);
                $smarty->assign('country', $country);
            }

            $items_array = array();
            
            if (($equiped_items[1][1]))
                $items_array[] = array("type" => "item", "alt" => "Head", "link" => $item_datasite.$EQU_HEAD, "image" => $equiped_items[1][1], "class" => $equiped_items[1][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "head");

            $items_array[] = array("type" => "class");
                                    
            if (($equiped_items[10][1]))
                $items_array[] = array("type" => "item", "alt" => "Gloves", "link" => $item_datasite.$EQU_GLOVES, "image" => $equiped_items[10][1], "class" => $equiped_items[10][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "gloves");

            $items_array[] = array("type" => "newrow", "width" => 1);

            if (($equiped_items[2][1]))
                $items_array[] = array("type" => "item", "alt" => "Neck", "link" => $item_datasite.$EQU_NECK, "image" => $equiped_items[2][1], "class" => $equiped_items[2][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "neck");
                
            $items_array[] = array("type" => "stats");

            if (($equiped_items[6][1]))
                $items_array[] = array("type" => "item", "alt" => "Belt", "link" => $item_datasite.$EQU_BELT, "image" => $equiped_items[6][1], "class" => $equiped_items[6][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "waist");

            $items_array[] = array("type" => "newrow", "width" => 1);
            
            if (($equiped_items[3][1]))
                $items_array[] = array("type" => "item", "alt" => "Shoulder", "link" => $item_datasite.$EQU_SHOULDER, "image" => $equiped_items[3][1], "class" => $equiped_items[3][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "shoulder");

            $items_array[] = array("type" => "newfield", "width" => 1);
            
            if (($equiped_items[7][1]))
                $items_array[] = array("type" => "item", "alt" => "Legs", "link" => $item_datasite.$EQU_LEGS, "image" => $equiped_items[7][1], "class" => $equiped_items[7][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "legs");

            $items_array[] = array("type" => "newrow", "width" => 1);
            
            if (($equiped_items[15][1]))
                $items_array[] = array("type" => "item", "alt" => "Back", "link" => $item_datasite.$EQU_BACK, "image" => $equiped_items[15][1], "class" => $equiped_items[15][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "chest_back");

            $items_array[] = array("type" => "newfield", "width" => 1);
            
            if (($equiped_items[8][1]))
                $items_array[] = array("type" => "item", "alt" => "Feet", "link" => $item_datasite.$EQU_FEET, "image" => $equiped_items[8][1], "class" => $equiped_items[8][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "feet");

            $items_array[] = array("type" => "newrow", "width" => 1);
            
            if (($equiped_items[5][1]))
                $items_array[] = array("type" => "item", "alt" => "Chest", "link" => $item_datasite.$EQU_CHEST, "image" => $equiped_items[5][1], "class" => $equiped_items[5][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "chest_back");

            $items_array[] = array("type" => "stats2");
            
            if (($equiped_items[11][1]))
                $items_array[] = array("type" => "item", "alt" => "Finger1", "link" => $item_datasite.$EQU_FINGER1, "image" => $equiped_items[11][1], "class" => $equiped_items[11][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "finger");

            $items_array[] = array("type" => "newrow", "width" => 1);
            
            if (($equiped_items[4][1]))
                $items_array[] = array("type" => "item", "alt" => "Shirt", "link" => $item_datasite.$EQU_SHIRT, "image" => $equiped_items[4][1], "class" => $equiped_items[4][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "shirt");

            $items_array[] = array("type" => "newfield", "width" => 1);
            
            if (($equiped_items[12][1]))
                $items_array[] = array("type" => "item", "alt" => "Finger2", "link" => $item_datasite.$EQU_FINGER2, "image" => $equiped_items[12][1], "class" => $equiped_items[12][2]);
            else 
                $items_array[] = array("type" => "empty", "img" => "finger");

            $items_array[] = array("type" => "newrow", "width" => 1);
            
            if (($equiped_items[19][1]))
                $items_array[] = array("type" => "item", "alt" => "Tabard", "link" => $item_datasite.$EQU_TABARD, "image" => $equiped_items[19][1], "class" => $equiped_items[19][2]);
            else 
                $items_array[] = array("type" => "empty", "img" => "tabard");

            $items_array[] = array("type" => "stats3");
            
            if (($equiped_items[13][1]))
                $items_array[] = array("type" => "item", "alt" => "Trinket1", "link" => $item_datasite.$EQU_TRINKET1, "image" => $equiped_items[13][1], "class" => $equiped_items[13][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "trinket");

            $items_array[] = array("type" => "newrow", "width" => 1);
            
            if (($equiped_items[9][1]))
                $items_array[] = array("type" => "item", "alt" => "Wrist", "link" => $item_datasite.$EQU_WRIST, "image" => $equiped_items[9][1], "class" => $equiped_items[9][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "wrist");

            $items_array[] = array("type" => "newfield", "width" => 1);
            
            if (($equiped_items[14][1]))
                $items_array[] = array("type" => "item", "alt" => "Trinket2", "link" => $item_datasite.$EQU_TRINKET2, "image" => $equiped_items[14][1], "class" => $equiped_items[14][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "trinket");

            $items_array[] = array("type" => "newrow2", "width" => 15);
            
            if (($equiped_items[16][1]))
                $items_array[] = array("type" => "item", "alt" => "MainHand", "link" => $item_datasite.$EQU_MAIN_HAND, "image" => $equiped_items[16][1], "class" => $equiped_items[16][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "main_hand");

            $items_array[] = array("type" => "newfield", "width" => 15);
            
            if (($equiped_items[17][1]))
                $items_array[] = array("type" => "item", "alt" => "OffHand", "link" => $item_datasite.$EQU_OFF_HAND, "image" => $equiped_items[17][1], "class" => $equiped_items[17][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "off_hand");

            $items_array[] = array("type" => "newfield", "width" => 15);
            
            if (($equiped_items[18][1]))
                $items_array[] = array("type" => "item", "alt" => "Ranged", "link" => $item_datasite.$EQU_RANGED, "image" => $equiped_items[18][1], "class" => $equiped_items[18][2]);
            else
                $items_array[] = array("type" => "empty", "img" => "ranged");

            $items_array[] = array("type" => "end", "width" => 15);
            
            if (($user_lvl > $owner_gmlvl)||($owner_name == $user_name))
            {
                //total time played
                $tot_time = $char['totaltime'];
                $tot_days = (int)($tot_time/86400);
                $tot_time = $tot_time - ($tot_days*86400);
                $total_hours = (int)($tot_time/3600);
                $tot_time = $tot_time - ($total_hours*3600);
                $total_min = (int)($tot_time/60);

                $smarty->assign("char_tot_days", $tot_days);
                $smarty->assign("char_total_hours", $total_hours);
                $smarty->assign("char_total_min", $total_min);
            }
            
            $smarty->assign('items_array', $items_array);

        }
        else
            ;//redirect("index.php?page=char&error=2");
    }
    else
        ;//redirect("index.php?page=char&error=3");
    
    if (getPermission('update'))
        $smarty->assign('hasUpdatePermission', true);
    if (getPermission('delete'))
        $smarty->assign('hasDeletePermission', true);
        
    $smarty->display('char.tpl');
    $smarty->clear_all_assign();
}

//########################################################################################################################
// SHOW CHARACTERS SPELL
//########################################################################################################################
function char_spell()
{
    global $lang_global, $lang_char, $realm_id, $characters_db, $user_lvl, $user_name,
            $spell_datasite, $itemperpage, $world_db, $smarty, $sqlm, $sqla;
    wowhead_tt();

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');

    //former char_security.php
    if (empty($_GET['id']))
        redirect('index.php?page=char&error=1&id=NULL');
    $id = sanitize_int($_GET['id']);
    
    if (empty($_GET['realm']))
    {
        $realmid = $realm_id;
        global $sqlc, $sqlw;
    }
    else
    {
        $realmid = sanitize_int($_GET['realm']);
        if (is_numeric($realmid))
        {
            $sqlc = new MySQL($characters_db[$realmid]);
            $sqlw = new MySQL($world_db[$realmid]);
        }
        else
        {
            global $sqlc, $sqlw;
            
            $realmid = $realm_id;
        }
    }
    //end former char_security.php

    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if (is_numeric($start)); else $start=0;

    $result = $sqlc->fetch("SELECT account, name, race, class, level, gender FROM characters WHERE guid = %d LIMIT 1", $id);

    if ($sqlc->num_rows($result))
    {
        $char = get_object_vars($result[0]);
        
        $smarty->assign('action', 'char_spell');
        $smarty->assign('lang_char', $lang_char);
        $smarty->assign('lang_global', $lang_global);
        $smarty->assign('id', $id);
        $smarty->assign('realmid', $realmid);
        $smarty->assign('char', $char);

        $owner_acc_id = $result[0]->account;
        $result = $sqla->fetch("SELECT `username`, `gmlevel` FROM `account` LEFT JOIN `account_access` ON `account`.`id`=`account_access`.`id` WHERE `account`.`id` = %d ORDER BY `gmlevel` DESC LIMIT 1", $owner_acc_id);
        $owner_name = $result[0]->username;
        $owner_gmlvl = $result[0]->gmlevel;
        if (empty($owner_gmlvl))
            $owner_gmlvl = 0;

        if (($user_lvl > $owner_gmlvl)||($owner_name === $user_name))
        {
            $all_record = $sqlc->fetch("SELECT count(spell) AS `count` FROM character_spell WHERE guid = %d and active = 1", $id);
            $all_record = $all_record[0]->count;
            $result = $sqlc->fetch("SELECT spell FROM character_spell WHERE guid = %d and active = 1 order by spell ASC LIMIT %d, %d", $id, $start, $itemperpage);

            if ($sqlc->num_rows($result))
            {
                $smarty->assign('hasData', true);

                $smarty->assign('pagination', generate_pagination('index.php?page=char&action=spell&id='.$id.'&amp;realm='.$realmid.'&amp;start='.$start.'', $all_record, $itemperpage, $start));

                $spell_array = array();
                $i = 0;
                foreach ($result as $spell)
                {
                    $i++;
                    $spell_array[] = array("i" => $i, "link" => $spell_datasite.$spell->spell, "icon" => spell_get_icon($spell->spell), "spellname" => spell_get_name($spell->spell));
                }
                $smarty->assign('spell_array', $spell_array);
            }
        }
        else
          ;//error($lang_char['no_permission']);
    }
    else
        ;//error($lang_char['no_char_found']);
        
    $smarty->display('char.tpl');
    $smarty->clear_all_assign();
}

//########################################################################################################################
// SHOW CHARACTER PETS
//########################################################################################################################
function char_pets()
{
    global $lang_global, $lang_char, $world_db, $realm_id, $characters_db, $user_lvl, $user_name, $spell_datasite, $pet_ability, $smarty, $sqla, $sqlm;
    wowhead_tt();

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');

    //former char_security.php
    if (empty($_GET['id']))
        redirect('index.php?page=char&error=1&id=NULL');
    $id = sanitize_int($_GET['id']);
    
    if (empty($_GET['realm']))
    {
        $realmid = $realm_id;
        global $sqlc, $sqlw;
    }
    else
    {
        $realmid = sanitize_int($_GET['realm']);
        if (is_numeric($realmid))
        {
            $sqlc = new MySQL($characters_db[$realmid]);
            $sqlw = new MySQL($world_db[$realmid]);
        }
        else
        {
            global $sqlc, $sqlw;
            
            $realmid = $realm_id;
        }
    }
    //end former char_security.php

    $result = $sqlc->fetch("SELECT account, name, race, class, level, gender FROM characters WHERE guid = %d LIMIT 1", $id);

    if ($sqlc->num_rows($result))
    {
        $char = get_object_vars($result[0]);

        $smarty->assign('action', 'char_pets');
        $smarty->assign('lang_char', $lang_char);
        $smarty->assign('lang_global', $lang_global);
        $smarty->assign('id', $id);
        $smarty->assign('realmid', $realmid);
        $smarty->assign('char', $char);
        
        $owner_acc_id = $result[0]->account;
        $result = $sqla->fetch("SELECT `username`, `gmlevel` FROM `account` LEFT JOIN `account_access` ON `account`.`id`=`account_access`.`id` WHERE `account`.`id` = %d ORDER BY `gmlevel` DESC LIMIT 1", $owner_acc_id);
        $owner_name = $result[0]->username;
        $owner_gmlvl = $result[0]->gmlevel;
        if (empty($owner_gmlvl))
            $owner_gmlvl = 0;
      
        if (($user_lvl > $owner_gmlvl)||($owner_name === $user_name))
        {
            $result = $sqlc->fetch("SELECT id, level, exp, name, curhappiness FROM character_pet WHERE owner = %d", $id);
            
            if ($sqlc->num_rows($result))
            {
                $pet_array = array();
                foreach ($result as $pet)
                {
                    $happiness = floor($pet->curhappiness/333000);
                    if (1 == $happiness)
                    {
                        $hap_text = 'Content';
                        $hap_val = 1;
                    }
                    elseif (2 == $happiness)
                    {
                        $hap_text = 'Happy';
                        $hap_val = 2;
                    }
                    else
                    {
                        $hap_text = 'Unhappy';
                        $hap_val = 0;
                    }
                    $pet_next_lvl_xp = floor(char_get_xp_to_level($pet->level)/4);

                    $ability_results = $sqlc->fetch("SELECT spell FROM pet_spell WHERE guid = %d and active > 1", $pet->id);
                    $abilities = array();
                    if ($sqlc->num_rows($ability_results))
                        foreach ($ability_results as $ability)
                            $abilities[] = array("link" => $spell_datasite.$ability->spell, "img" => spell_get_icon($ability->spell), "alt" => $ability->spell);

                    $pet_array[] = array_merge(get_object_vars($pet), array("abilities" => $abilities, "hap_text" => $hap_text, "hap_val" => $hap_val, "lvlcolor" => char_get_level_color($pet->level), "next_lvl_xp" => $pet_next_lvl_xp, "bpos" => (round(385*$pet->exp/$pet_next_lvl_xp)-385)));
                }
                unset($ability_results);
                unset($pet_next_lvl_xp);
                unset($happiness);
            }
        }
        else
            ;//error($lang_char['no_permission']);
    }
    else
        ;//error($lang_char['no_char_found']);
        
    $smarty->display('char.tpl');
    $smarty->clear_all_assign();
}

//########################################################################################################################
// MAIN
//########################################################################################################################

// action variable reserved for future use
$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

// load language
$lang_char = lang_char();

$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
    case 2:
        $smarty->assign('error', $lang_char['no_permission']);
        break;
    case 3:
        $smarty->assign('error', $lang_char['no_char_found']);
        break;
    default: //no error
        $err = -1;
}

$smarty->assign('headline', $lang_char['character']);

if ($err != -1)
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();
unset($err);


switch ($action)
{
    case "spell":
        char_spell();
        break;
    case "pets":
        char_pets();
        break;
    default:
        char_main();
}

unset($lang_char);

?>
