<?php
require_once 'libs/bbcode_lib.php';
require_once 'libs/char.lib.php';
require_once 'libs/map_zone.lib.php';

//#############################################################################
// MINIMANAGER FRONT PAGE
//#############################################################################
function front()
{
    global  $lang_global, $lang_index, $realm_id, $server, $user_lvl, $user_id, 
            $showcountryflag, $motd_display_poster, $gm_online_count, $gm_online, $itemperpage, 
            $sqla, $sqlc, $sqlm, $sqlw, $smarty;

    if (!getPermission('read'))
        redirect('index.php?page=login&error=5');
            
    $smarty->assign('lang_index', $lang_index);
    $smarty->assign('lang_global', $lang_global);
    
    if (test_port($server[$realm_id]['addr'],$server[$realm_id]['game_port']))
    {
        $stats = $sqla->fetch("SELECT starttime, maxplayers FROM uptime WHERE realmid = '%d' ORDER BY starttime DESC LIMIT 1", $realm_id);
        $uptimetime = time() - $stats[0]->starttime;

        $staticUptime = $lang_index['realm'].' <em>'.htmlentities(get_realm_name($realm_id)).'</em> '.$lang_index['online'].' for '.format_uptime($uptimetime);
        unset($uptimetime);
        
        $smarty->assign('online', true);
        $smarty->assign('staticUptime', $staticUptime);
        $smarty->assign('maxplayers', $stats[0]->maxplayers);

        unset($staticUptime);
        unset($stats);
        $online = true;
    }
    else
    {
        $smarty->assign('realmname',htmlentities(get_realm_name($realm_id)));
        $online = false;
    }

    //  This retrieves the actual database version from the database itself, instead of hardcoding it into a string
    $version = $sqlw->fetch("SELECT core_revision, db_version FROM version");
    $smarty->assign('version', array("core_revision" => $version[0]->core_revision, "db_version" => $version[0]->db_version));
    unset($version);

    //MOTD part
    $start_m = (isset($_GET['start_m'])) ? sanitize_int($_GET['start_m']) : 0;
    if (is_numeric($start_m)); 
    else 
        $start_m = 0;

    $all_record_m = $sqlm->fetch("SELECT count(*) as `count` FROM mm_motd");
    $all_record_m = sanitize_int($all_record_m[0]->count);

    if (getPermission('delete'))
        $smarty->assign('hasDeletePermission', true);

    if (getPermission('insert'))
        $smarty->assign('hasInsertPermission', true);

    if (getPermission('update'))
        $smarty->assign('hasUpdatePermission', true);
        
    if($all_record_m)
    {
        $result = $sqlm->fetch("SELECT id, realmid, type, content FROM mm_motd WHERE realmid = %d ORDER BY id DESC LIMIT %d, 3", $realm_id, $start_m);
        $motds = array();
        if ($sqlm->num_rows())
            foreach ($result as $post)
                $motds[] = array("id" => $post->id, "content" => bbcode_bbc2html($post->content), "type" => ($motd_display_poster) ? $post->type : '');

        $smarty->assign('motds', $motds);
        $smarty->assign('motdnum', $sqlm->num_rows());
        if (!$online)
            $smarty->assign('pagination_motd_off', generate_pagination('index.php?start=0', $all_record_m, 3, $start_m, 'start_m'));
    }


    //print online chars
    if ($online)
    {
        //==========================$_GET and SECURE=================================
        $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
        if (is_numeric($start)); 
        else 
            $start = 0;

        $order_by = (isset($_GET['order_by'])) ? sanitize_paranoid_string($_GET['order_by']) : 'level';
        if (preg_match('/^[_[:lower:]]{1,12}$/', $order_by)); 
        else 
            $order_by = 'level';

        $dir = (isset($_GET['dir'])) ? sanitize_int($_GET['dir']) : 1;
        if (preg_match('/^[01]{1}$/', $dir)); 
        else 
            $dir = 1;

        $order_dir = ($dir) ? 'DESC' : 'ASC';
        $dir = ($dir) ? 0 : 1;
        //==========================$_GET and SECURE end=============================

        if ($order_by === 'map')
            $order_by = 'map '.$order_dir.', zone';
        elseif ($order_by === 'zone')
            $order_by = 'zone '.$order_dir.', map';

        $smarty->assign('pagination_motd_on', generate_pagination('index.php?start='.$start.'&amp;order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1).'', $all_record_m, 3, $start_m, 'start_m'));
        unset($all_record_m);

        $order_side = '';
        if( $user_lvl || $server[$realm_id]['both_factions']);
        else
        {
            $result = $sqlc->fetch("SELECT race FROM characters WHERE account = '%d'
                                    AND totaltime = (SELECT MAX(totaltime) FROM characters WHERE account = '%d') LIMIT 1", $user_id, $user_id);
            if ($sqlc->num_rows())
                $order_side = (in_array($result->race,array(2,5,6,8,10))) ? ' AND race IN (2,5,6,8,10) ' : ' AND race IN (1,3,4,7,11) ';
        }
        $total_online = $sqlc->fetch("SELECT count(*) as `count` FROM characters WHERE online= 1 %s", (($gm_online_count == '0') ? ' AND extra_flags &1 = 0' : ''));
        $total_online = $total_online[0]->count;

        $smarty->assign('total_online', $total_online);
        $smarty->assign('countryflag_colspan', (10-$showcountryflag));
        $smarty->assign('pagination_char1', generate_pagination('index.php?start_m='.$start_m.'&amp;order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1), $total_online, $itemperpage, $start));
        $smarty->assign('start', $start);
        $smarty->assign('start_m', $start_m);
        $smarty->assign('dir', $dir);
        $smarty->assign('order_by', $order_by);
        $smarty->assign('order_dir', $order_dir);
        $smarty->assign('order_dir_mapzone', 'map '.$order_dir.', zone');
        $smarty->assign('order_dir_zonemap', 'zone '.$order_dir.', map');

        if ($showcountryflag)
            $smarty->assign('showCountry', true);
            
        if($order_by == 'ip')
        {
            $res = $sqla->fetch("SELECT id, last_ip FROM account WHERE online = 1 ORDER BY last_ip %s LIMIT %d, %d", $order_dir, $start, $itemperpage);
            $num = $sqlc->num_rows();
        }
        else
        {
            $res = $sqlc->fetch("SELECT characters.guid,  characters.name,  characters.race,  characters.class,  characters.zone,  characters.map,  characters.level,  characters.account,  characters.gender,  characters.totalHonorPoints, COALESCE(guild_member.guildid,0) AS guildid FROM characters LEFT JOIN guild_member ON guild_member.guid = characters.guid WHERE characters.online = 1 %s ORDER BY %s %s LIMIT %d, %d", ($gm_online == '0' ? 'AND characters.extra_flags &1 = 0 ' : '').$order_side, $order_by, $order_dir, $start, $itemperpage);
            $num = $sqlc->num_rows();
        }

        $chars = array();
        if ($num > 0)
            foreach ($res as $char)
            {
                if($order_by == 'ip')
                {
                    $temp = $sqlc->fetch("SELECT characters.guid,  characters.name,  characters.race,  characters.class,  characters.zone,  characters.map,  characters.level,  characters.account,  characters.gender,  characters.totalHonorPoints, COALESCE(guild_member.guildid,0) AS guildid FROM characters LEFT JOIN guild_member ON guild_member.guid = characters.guid WHERE characters.online= 1 %s and account = %d", ($gm_online == '0' ? 'AND characters.extra_flags &1 = 0 ' : '').$order_side, $char->id);
                    if(isset($temp->guid))
                        $char = $temp;
                    else
                        continue;
                }

                $gm = $sqla->fetch("SELECT gmlevel FROM account_access WHERE id=%d", $char->account);
                $gm = $gm[0]->gmlevel;
                $guild_name = $sqlc->fetch("SELECT name FROM guild WHERE guildid=%d", $char->guildid);
                $guild_name = $guild_name[0]->name;

                if (($user_lvl >= $gm))
                    $smarty->assign('isGameMaster', true);

                if ($showcountryflag)
                {
                    $country = misc_get_country_by_account($char->account, $sqla, $sqlm);
                }
                
                $chars[] = array(   "guid" => $char->guid, "race" => $char->race, "gender" => $char->gender, "class" => $char->class, "map" => $char->map, "mapname" => get_map_name($char->map, $sqlm), "zone" => $char->zone,
                                    "gmlevel_name" => id_get_gm_level($gm), "charname" => htmlentities($char->name), "racename" => char_get_race_name($char->race), "zonename" => get_zone_name($char->zone, $sqlm),
                                    "classname" => char_get_class_name($char->class), "levelcolor" => char_get_level_color($char->level), "pvprankname" => char_get_pvp_rank_name($char->totalHonorPoints, char_get_side_id($char->race)),
                                    "pvprank" => char_get_pvp_rank_id($char->totalHonorPoints, char_get_side_id($char->race)), "guildid" => $char->guildid, "guildname" => htmlentities($guild_name),
                                    "country" => (($country['code']) ? '<img src="img/flags/'.$country['code'].'.png" onmousemove="toolTip(\''.($country['country']).'\',\'item_tooltip\')" onmouseout="toolTip()" alt="" />' : '-')
                );
            }
            
        $smarty->assign('charsnum', $num);
        $smarty->assign('chars', $chars);
        $smarty->assign('pagination_char2', generate_pagination('index.php?start_m='.$start_m.'&amp;order_by='.$order_by.'&amp;dir='.(($dir) ? 0 : 1), $total_online, $itemperpage, $start));

        unset($total_online);
        unset($num);
        
        $smarty->display('index.tpl');
        $smarty->clear_all_assign();
    }
}


//#############################################################################
// MAIN
//#############################################################################

//$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

$lang_index = lang_index();

front();
?>
