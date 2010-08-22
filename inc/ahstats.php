<?php error_reporting(E_ALL);
require_once("libs/item.lib.php");

//#############################################################################
// BROWSE AUCTIONS
//#############################################################################
function browse_auctions()
{
    global $lang_auctionhouse, $lang_global, $lang_item, $itemperpage, $item_datasite, $realm_id, $characters_db, $world_db, $server, $user_lvl, $user_id, $sqlm, $sqlc, $sqlw, $smarty;
    wowhead_tt();

    $red = "\"#DD5047\"";
    $blue = "\"#0097CD\"";
    $sidecolor = array(1 => $blue,2 => $red,3 => $blue,4 => $blue,5 => $red,6 => $red,7 => $blue,8 => $red,10 => $red);
    $hiddencols = array("itemid","count","seller_race","buyer_race");

    //==========================$_GET and SECURE=================================
    $start = (isset($_GET['start'])) ? sanitize_int($_GET['start']) : 0;
    if (is_numeric($start));
    else $start=0;

    $order_by = (isset($_GET['order_by'])) ? preg_replace("/[^a-zA-Z0-9_]/", "", $_GET['order_by']) : "time";
    if (!preg_match("/^[_[:lower:]]{1,15}$/", $order_by)) 
        $order_by="time";

    $dir = (isset($_GET['dir'])) ? sanitize_paranoid_string($_GET['dir']) : 1;
    if (!preg_match("/^[01]{1}$/", $dir)) 
        $dir=1;

    $order_dir = ($dir) ? "ASC" : "DESC";
    $dir = ($dir) ? 0 : 1;
    //==========================$_GET and SECURE end=============================

    if( !$user_lvl && !$server[$realm_id]['both_factions'])
    {
        $result = $sqlc->fetch("SELECT `race` FROM `characters` WHERE `account` = %d AND `totaltime` = (SELECT MAX(totaltime) FROM `characters` WHERE `account` = %d) LIMIT 1", $user_id, $user_id);
    
        if ($sqlc->num_rows())
            $order_side = (in_array($result[0]->race,array(2,5,6,8,10))) ? " AND `characters`.`race` IN (2,5,6,8,10) " : " AND `characters`.`race` IN (1,3,4,7,11) ";
        else
            $order_side = "";
    }
    else 
        $order_side = "";

    //==========================Browse/Search CHECK==============================
    $search_by = '';
    $search_value = '';
    $search_filter = '';
    $search_class = -1;
    $search_quality = -1;

    if((isset($_GET['search_value']) && isset($_GET['search_by'])) || (isset($_GET['search_class'])) || (isset($_GET['search_quality'])) )
    {
        $search_value = sanitize_paranoid_string($_GET['search_value']);
        $search_by = sanitize_paranoid_string($_GET['search_by']);
        $search_class = sanitize_int($_GET['search_class']);
        $search_quality = sanitize_int($_GET['search_quality']);
        $smarty->assign('search_value', $search_value);
        
        switch ($search_by)
        {
            case "item_name":
                if(( ($search_class >= 0) || ($search_quality >= 0)) && (!isset($search_value) ))
                {
                    if ($search_class >= 0) 
                        $search_filter = "AND item_template.class = '$search_class'";
                    if ($search_quality >= 0) 
                        $search_filter = "AND item_template.Quality = '$search_quality'";
                }
                else
                {
                    $item_prefix = "";
                    if ($search_class >= 0) 
                        $item_prefix .= "AND item_template.class = '$search_class' ";
                    if ($search_quality >= 0) 
                        $item_prefix .= "AND item_template.Quality = '$search_quality' ";
                        
                    $result = $sqlc->fetch("SELECT `entry` FROM `item_template` WHERE `name` LIKE '\%%s\%' %s", $search_value, $item_prefix);
                    $search_filter = "AND auctionhouse.item_template IN(0";
                    
                    foreach ($result as $item)
                        $search_filter .= ", ".$item->entry;
                        
                    $search_filter .= ")";
                }
                break;
            
            case "item_id":
                $search_filter = "AND auctionhouse.item_template = '$search_value'";
                break;
            
            case "seller_name":
                if(( ($search_class >= 0) || ($search_quality >= 0)) && (!isset($search_value) ))
                {
                    if ($search_class >= 0) 
                        $search_filter = "AND item_template.class = '$search_class'";
                    if ($search_quality >= 0) 
                        $search_filter = "AND item_template.Quality = '$search_quality'";
                }
                else
                {
                    $item_prefix = "";
                    if ($search_class >= 0) 
                        $item_prefix .= "AND item_template.class = '$search_class' ";
                    if ($search_quality >= 0) 
                        $item_prefix .= "AND item_template.Quality = '$search_quality' ";
                        
                    $result = $sqlc->fetch("SELECT `guid` FROM `characters` WHERE `name` LIKE '\%%s\%'", $search_value);
                    $search_filter = $item_prefix;
                    $search_filter .= "AND auctionhouse.itemowner IN(0";
                    
                    foreach ($result as $char)
                        $search_filter .= "," .$char->guid;
                    
                    $search_filter .= ")";
                    $search_filter .= $item_prefix;
                }
                break;
            
            case "buyer_name":
                if(( ($search_class >= 0) || ($search_quality >= 0)) && (!isset($search_value) ))
                {
                    if ($search_class >= 0) $search_filter = "AND item_template.class = '$search_class'";
                    if ($search_quality >= 0) $search_filter = "AND item_template.Quality = '$search_quality'";
                }
                else
                {
                    $item_prefix = "";
                    if ($search_class >= 0) 
                        $item_prefix .= "AND item_template.class = '$search_class' ";
                    if ($search_quality >= 0) 
                        $item_prefix .= "AND item_template.Quality = '$search_quality' ";
                    
                    $result = $sqlc->fetch("SELECT `guid` FROM `characters` WHERE `name` LIKE '\%%s\%'", $search_value);
                    $search_filter = $item_prefix;
                    $search_filter .= "AND auctionhouse.buyguid IN(-1";
                    
                    foreach ($result as $char)
                        $search_filter .= ", ".$char->guid;
                        
                    $search_filter .= ")";
                }
                break;
            
            default:
                redirect("index.php?page=ahstats&error=1", false);
        }
        $query_1 = $sqlc->fetch("SELECT count(*) as count FROM `%s`.`characters` , `%s`.`item_instance` , `%s`.`item_template` , `%s`.`auctionhouse` LEFT JOIN `%s`.`characters` c2 ON `c2`.`guid`=`auctionhouse`.`buyguid` WHERE `auctionhouse`.`itemowner`=`characters`.`guid` AND `auctionhouse`.`item_template`=`item_template`.`entry` AND `auctionhouse`.`itemguid`=`item_instance`.`guid` %s %s", $characters_db[$realm_id]['name'], $characters_db[$realm_id]['name'], $world_db[$realm_id]['name'], $characters_db[$realm_id]['name'], $characters_db[$realm_id]['name'], $search_filter, $order_side);
    }
    else
    {
        $query_1 = $sqlc->fetch("SELECT count(*) as count FROM auctionhouse");
    }
    
    $all_record = $query_1[0]->count;
    $smarty->assign('all_record', $all_record);

    $search_by_select = array("item_name" => $lang_auctionhouse['item_name'], "item_id" => $lang_auctionhouse['item_id'], "seller_name" => $lang_auctionhouse['seller_name'], "buyer_name" => $lang_auctionhouse['buyer_name']);
    $smarty->assign('search_by_select', $search_by_select);
    $smarty->assign('search_by_selected', $search_by);
    
    $search_class_select = array("-1" => $lang_auctionhouse['all'], "0" => $lang_item['consumable'], "1" => $lang_item['bag'], "2" => $lang_item['weapon'],
                                 "4" => $lang_item['armor'], "5" => $lang_item['reagent'], "7" => $lang_item['trade_goods'], "9" => $lang_item['recipe'],
                                 "11" => $lang_item['quiver'], "14" => $lang_item['permanent'], "15" => $lang_item['misc_short']);
    $smarty->assign('search_class_select', $search_class_select);
    $smarty->assign('search_class_selected', $search_class);
    
    $search_quality_select = array("-1" => $lang_auctionhouse['all'], "0" => $lang_item['poor'], "1" => $lang_item['common'], "2" => $lang_item['uncommon'],
                                   "3" => $lang_item['rare'], "4" => $lang_item['epic'], "5" => $lang_item['legendary'], "6" => $lang_item['artifact']);
    $smarty->assign('search_quality_select', $search_quality_select);
    $smarty->assign('search_quality_selected', $search_quality);
    //=====================top tage navigaion starts here========================
    
    $smarty->assign('lang_global', $lang_global);
    
    (($search_by && $search_value) || ($search_class != -1) || ($search_quality != -1)) ? $smarty->assign('showBackBtn', true) : NULL;
    
    $smarty->assign('pagination1', generate_pagination("index.php?page=ahstats&order_by=$order_by".( (($search_by && $search_value) || ($search_class != -1) || ($search_quality != -1)) ? "&amp;search_by=$search_by&amp;search_value=$search_value&amp;search_quality=$search_quality&amp;search_class=$search_class&amp;error=2" : "" )."&amp;dir=".(($dir) ? 0 : 1), $all_record, $itemperpage, $start));
    
    $ahstats_search = array();
    $cond = (($search_by && $search_value) || ($search_class != -1) || ($search_quality != -1));
    $cond_value = "&amp;search_by=".$search_by."&amp;search_value=".$search_value."&amp;search_quality=".$search_quality."&amp;search_class=".$search_class."&amp;error=2&amp;dir=".$dir;
    $ahstats_search[] = array("width" => "10%", "link" => "index.php?page=ahstats&order_by=itemowner&amp;start=".$start.($cond ? $cond_value : "&amp;dir=".$dir), "arrow" => ($order_by=='itemowner' ? "<img src=\"img/arr_".($dir ? "up" : "dw").".gif\" alt=\"\" /> " : ""), "name" => $lang_auctionhouse['seller']);
    $ahstats_search[] = array("width" => "20%", "link" => "index.php?page=ahstats&order_by=item_template&amp;start=".$start.($cond ? $cond_value : "&amp;dir=".$dir), "arrow" => ($order_by=='item_template' ? "<img src=\"img/arr_".($dir ? "up" : "dw").".gif\" alt=\"\" /> " : ""), "name" => $lang_auctionhouse['item']);
    $ahstats_search[] = array("width" => "15%", "link" => "index.php?page=ahstats&order_by=buyoutprice&amp;start=".$start.($cond ? $cond_value : "&amp;dir=".$dir), "arrow" => ($order_by=='buyoutprice' ? "<img src=\"img/arr_".($dir ? "up" : "dw").".gif\" alt=\"\" /> " : ""), "name" => $lang_auctionhouse['buyoutprice']);
    $ahstats_search[] = array("width" => "15%", "link" => "index.php?page=ahstats&order_by=time&amp;start=".$start.($cond ? $cond_value : "&amp;dir=".$dir), "arrow" => ($order_by=='time' ? "<img src=\"img/arr_".($dir ? "up" : "dw").".gif\" alt=\"\" /> " : ""), "name" => $lang_auctionhouse['timeleft']);
    $ahstats_search[] = array("width" => "10%", "link" => "index.php?page=ahstats&order_by=buyguid&amp;start=".$start.($cond ? $cond_value : "&amp;dir=".$dir), "arrow" => ($order_by=='buyguid' ? "<img src=\"img/arr_".($dir ? "up" : "dw").".gif\" alt=\"\" /> " : ""), "name" => $lang_auctionhouse['buyer']);
    $ahstats_search[] = array("width" => "15%", "link" => "index.php?page=ahstats&order_by=lastbid&amp;start=".$start.($cond ? $cond_value : "&amp;dir=".$dir), "arrow" => ($order_by=='lastbid' ? "<img src=\"img/arr_".($dir ? "up" : "dw").".gif\" alt=\"\" /> " : ""), "name" => $lang_auctionhouse['lastbid']);
    $ahstats_search[] = array("width" => "15%", "link" => "index.php?page=ahstats&order_by=startbid&amp;start=".$start.($cond ? $cond_value : "&amp;dir=".$dir), "arrow" => ($order_by=='startbid' ? "<img src=\"img/arr_".($dir ? "up" : "dw").".gif\" alt=\"\" /> " : ""), "name" => $lang_auctionhouse['firstbid']);
    unset($cond);

    $smarty->assign('ahstats_search', $ahstats_search);
    
    $result = $sqlc->fetch("SELECT `characters`.`name` AS `seller`, `auctionhouse`.`item_template` AS `itemid`, `item_template`.`name` AS `itemname`, `auctionhouse`.`buyoutprice` AS `buyout`, `auctionhouse`.`time`-unix_timestamp() AS `timeleft`, `c2`.`name` AS `encherisseur`, `auctionhouse`.`lastbid` AS `lastbid`, `auctionhouse`.`startbid` AS `startbid`, `item_instance`.`count` AS `count`, `characters`.`race` AS seller_race, `c2`.`race` AS buyer_race FROM `%s`.`characters` , `%s`.`item_instance` , `%s`.`item_template` , `%s`.`auctionhouse` LEFT JOIN `%s`.`characters` c2 ON `c2`.`guid`=`auctionhouse`.`buyguid` WHERE `auctionhouse`.`itemowner`=`characters`.`guid` AND `auctionhouse`.`item_template`=`item_template`.`entry` AND `auctionhouse`.`itemguid`=`item_instance`.`guid` %s %s ORDER BY `auctionhouse`.`%s` %s LIMIT %d, %d", $characters_db[$realm_id]['dbName'], $characters_db[$realm_id]['dbName'], $world_db[$realm_id]['dbName'], $characters_db[$realm_id]['dbName'], $characters_db[$realm_id]['dbName'], $search_filter, $order_side, $order_by, $order_dir, $start, $itemperpage);

    $dataset = array();
    if ($sqlc->num_rows())
        foreach ($result as $row)
        { //0 seller, 1 itemid, 2 itemname, 3 buyout, 4 timeleft, 5 encherisseur (buyername), 6 lastbid, 7 startbid, 8 count, 9 seller_race, 10 buyer_race
            $rows = get_object_vars($row);
            $data = array();
            foreach($rows as $row => $value)
            {
                switch ($row)
                {
                    case "timeleft":
                        $value = ($value >= 0)? (floor($value / 86400).$lang_auctionhouse['dayshortcut']." ". floor(($value % 86400)/3600).$lang_auctionhouse['hourshortcut']." ".floor((($value % 86400)%3600)/60).$lang_auctionhouse['mnshortcut']) : $lang_auctionhouse['auction_over'];
                        break;
                    case "buyername":
                        $value = "<b>".((!empty($rows['buyer_race'])) ? "<font color=".$sidecolor[$rows['buyer_race']].">".htmlentities($value)."</font>" : "N/A")."</b>";
                        break;
                    case "startbid":
                    case "lastbid":
                    case "buyout":
                        $g = floor($value/10000);
                        $value -= $g*10000;
                        $s = floor($value/100);
                        $value -= $s*100;
                        $c = $value;
                        $value = $g."<img src=\"./img/gold.gif\" alt=\"\" /> ".$s."<img src=\"./img/silver.gif\" alt=\"\" /> ".$c."<img src=\"./img/copper.gif\" alt=\"\" /> ";
                        break;
                    case "itemname":
                        $value = "<a href=\"".$item_datasite.$rows['itemid']."\" target=\"_blank\" onmouseover=\"toolTip,'item_tooltip'\"><img src=\"".get_item_icon($rows['itemid'])."\" class=\"".get_item_border($rows['itemid'])."\" alt=\"".$value."\" /><br/>".$value.(($rows['count']>1) ? " (x".$rows['count'].")" : "")."</a>";
                        break;
                    case "seller":
                        $value = "<b>".((!empty($rows['seller_race'])) ? "<font color=".$sidecolor[$rows['seller_race']].">".htmlentities($value)."</font>" : "N/A")."</b>";
                        break;
                }
                if (!in_array($row,$hiddencols))
                    $data[] = $value;
            }
            $dataset[] = $data;
        }
    $smarty->assign('dataset', $dataset);
    unset($data);
    unset($dataset);
    
    $smarty->assign('lang_total_auctions', $lang_auctionhouse['total_auctions']);
    $smarty->assign('pagination2', generate_pagination("index.php?page=ahstats&order_by=$order_by".( (($search_by && $search_value) || ($search_class != -1) || ($search_quality != -1)) ? "&amp;search_by=$search_by&amp;search_value=$search_value&amp;search_quality=$search_quality&amp;search_class=$search_class&amp;error=2" : "" )."&amp;dir=".(($dir) ? 0 : 1), $all_record, $itemperpage, $start));
    $smarty->display('ahstats.tpl');
    $smarty->clear_all_assign();
}
//#############################################################################
// MAIN
//#############################################################################
$err = (isset($_GET['error'])) ? $_GET['error'] : NULL;

$lang_auctionhouse = lang_auctionhouse();

switch ($err)
{
    case 1:
        $smarty->assign('error', $lang_global['empty_fields']);
        break;
    case 2:
        $smarty->assign('error', $lang_auctionhouse['search_results']);
        break;
    default:
        $err = -1;
}


$smarty->assign('headline', $lang_auctionhouse['auctionhouse']);

if ($err != -1)
    $smarty->display("error-small.tpl");
else
    $smarty->display("headline.tpl");
    
$smarty->clear_all_assign();
unset($err);

$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

switch ($action)
{
    case "unknown":
        break;
    default:
        browse_auctions();
}

unset($action);
unset($lang_auctionhouse);
?>
