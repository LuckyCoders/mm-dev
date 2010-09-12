<?php


/**
 * calculate creature health, mana and armor
 * 
 * kinda crappy way, but works
 * 
 * if $type is used:
 * 1 -> returns health
 * 2 -> returns mana
 * 3 -> returns armor
 * 0 -> returns array(health,mana,armor)      
 **/  
function get_additional_data($entryid, $type = 0)
{
    global $world_db, $realm_id;
    
    if (!is_numeric($entryid))
        return array(0,0,0);

    $sql = new SQL;
    $sql->connect($world_db[$realm_id]['addr'], $world_db[$realm_id]['user'], $world_db[$realm_id]['pass'], $world_db[$realm_id]['name']);

    $q = $sql->query("SELECT (SELECT unit_class FROM creature_template WHERE entry = ".$entryid.") AS class, (SELECT FLOOR(minlevel + (RAND() * (maxlevel - minlevel + 1))) FROM creature_template WHERE entry = ".$entryid.") AS level, (SELECT exp FROM creature_template WHERE entry = ".$entryid.") AS exp;");
    $data = $sql->fetch_assoc($q);
    
    if ($sql->num_rows($q) == 0)
      return array(0,0,0);
      
    $q = "SELECT ((SELECT Health_Mod FROM creature_template WHERE entry = ".$entryid.")*(SELECT basehp".$data['exp']." FROM creature_classlevelstats WHERE level = ".$data['level']." AND class = ".$data['class'].")+0.5), ((SELECT Mana_Mod FROM creature_template WHERE entry = ".$entryid.")*(SELECT basemana FROM creature_classlevelstats WHERE level = ".$data['level']." AND class = ".$data['class'].")+0.5),((SELECT Armor_Mod FROM creature_template WHERE entry = ".$entryid.")*(SELECT basearmor FROM creature_classlevelstats WHERE level = ".$data['level']." AND class = ".$data['class'].")+0.5);";          
    if ($type == 1)
        $q = "SELECT ((SELECT Health_Mod FROM creature_template WHERE entry = ".$entryid.")*(SELECT basehp".$data['exp']." FROM creature_classlevelstats WHERE level = ".$data['level']." AND class = ".$data['class'].")+0.5);";
    if ($type == 2)
        $q = "SELECT ((SELECT Mana_Mod FROM creature_template WHERE entry = ".$entryid.")*(SELECT basemana FROM creature_classlevelstats WHERE level = ".$data['level']." AND class = ".$data['class'].")+0.5);";
    if ($type == 3)
        $q = "SELECT ((SELECT Armor_Mod FROM creature_template WHERE entry = ".$entryid.")*(SELECT basearmor FROM creature_classlevelstats WHERE level = ".$data['level']." AND class = ".$data['class'].")+0.5);";
    
    $query = $sql->query($q);         
    $result = $sql->fetch_row($query);
    $sql->close();
    unset($sql);
    
    if ($type == 2 && $result[0] == 0.5)
        return 0;
    
    if ($type == 0 && $result[1] == 0.5)
        return array($result[0],0,$result[2]);
        
    
    return (($type > 0) ? $result[0] : $result);
}


//#############################################################################
//get name from realmlist.name

function get_realm_name($realm_id)
{
    global $realm_db, $sqla;

    $result = $sqla->fetch("SELECT name FROM `realmlist` WHERE id = '%d'", $realm_id);
    $realm_name = $result[0]->name;

    return $realm_name;
}


//#############################################################################
//get WOW Expansion by id

function id_get_exp_lvl()
{
    $exp_lvl_arr =
    array
    (
        0 => array(0, "Classic",                ""     ),
        1 => array(1, "The Burning Crusade",    "TBC"  ),
        2 => array(2, "Wrath of the Lich King", "WotLK")
    );
    return $exp_lvl_arr;
}


//#############################################################################
//get GM level by ID

function id_get_gm_level($id)
{
    global $lang_id_tab, $gm_level_arr;
    if(isset($gm_level_arr[$id]))
        return $gm_level_arr[$id][1];
    else
        return($lang_id_tab['unknown']);
}


//#############################################################################
//set color per Level range

function get_days_with_color($how_long)
{
    $days = count_days($how_long, time());

    if($days < 1)
        $lastlogin = '<font color="#009900">'.$days.'</font>';
    else if($days < 8)
        $lastlogin = '<font color="#0000CC">'.$days.'</font>';
    else if($days < 15)
        $lastlogin = '<font color="#FFFF00">'.$days.'</font>';
    else if($days < 22)
        $lastlogin = '<font color="#FF8000">'.$days.'</font>';
    else if($days < 29)
        $lastlogin = '<font color="#FF0000">'.$days.'</font>';
    else if($days < 61)
        $lastlogin = '<font color="#FF00FF">'.$days.'</font>';
    else
        $lastlogin = '<font color="#FF0000">'.$days.'</font>';

    return $lastlogin;
}


//#############################################################################
//get DBC Language from config

function get_lang_id()
{
    /* # DBC Language Settings
       #  0 = English
       #  1 = Korean
       #  2 = French
       #  3 = German
       #  4 = Chinese
       #  5 = Taiwanese
       #  6 = Spanish
       #  7 = Spanish Mexico
       #  8 = Russian
       #  9 = Unknown
       # 10 = Unknown
       # 11 = Unknown
       # 12 = Unknown
       # 13 = Unknown
       # 14 = Unknown
       # 15 = Unknown */

    global $language;
    if (isset($_COOKIE["lang"]))
        $language=$_COOKIE["lang"];

    // 0 = English/Default; 1 = Korean; 2 = French; 4 = German; 8 = Chinese; 16 = Taiwanese; 32 = Spanish; 64 = Russian
    switch ($language)
    {
        case 'korean':
            return 1;
            break;
        case 'french':
            return 2;
            break;
        case 'german':
            return 3;
            break;
        case 'chinese':
            return 4;
            break;
        case 'taiwanese':
            return 5;
            break;
        case 'spanish':
            return 6;
            break;
        case 'mexican':
            return 7;
            break;
        case 'russian':
            return 8;
            break;
        default:
            return 0;
            break;
    }
}

// get theme
function get_theme()
{
    global $themefolder;
    $tmp_theme = $themefolder;
    
    if (isset($_COOKIE['theme']))
        $tmp_theme = sanitize_paranoid_string($_COOKIE['theme']);
    
    if (is_dir('themes/'.$tmp_theme))
        if (is_file('themes/'.$tmp_theme.'/'.$tmp_theme.'_1024.css'))
            $theme = $tmp_theme;
    
    return $theme;
}

//get appropriate language
function get_language()
{
    global $language;
    
    if (isset($_COOKIE['lang']))
    {
        $lang = sanitize_paranoid_string($_COOKIE['lang']);
        if (file_exists('lang/'.$lang.'.php')); //if selected language does not exist...
        else
            $lang = $language; //use language from config
    }
    else
        $lang = $language; //no cookie -> use language from config
    
    return $lang;
}

//##########################################################################################
//get player name
function get_char_name($id)
{
    global $sqlc;

    if($id)
    {
        $result = $sqlc->fetch("SELECT `name` FROM `characters` WHERE `guid` = %d", $id);
        $player_name = $result[0]->name;

        return $player_name;
    }
    else
        return NULL;
}

// Mail Source
$mail_source = Array
(
    "0" => "Normal",
    "2" => "Auction",
    "3" => "Creature",
    "4" => "GameObject",
    "5" => "Item",
);

function get_mail_source($id)
{
    global $mail_source;
    return $mail_source[$id] ;
}

// Check State
$check_state = Array
(
    //"0" => "Not Read",
    "1" => "Read",
    "2" => "Ret", //"Returned"
    "4" => "Co", //"Copied Checked"
    "8" => "COD", //"COD Pay Checked"
    "16" => "B" //"Mail has body"
);

function bitMask($mask = 0) 
{
    if(!is_numeric($mask))
        return array();

    $return = array();
    while ($mask > 0) 
    {
        for($i = 0, $n = 0; $i <= $mask; $i = 1 * pow(2, $n), $n++)
            $end = $i;

        $return[] = $end;
        $mask = $mask - $end;
    }
    sort($return);
    return $return;
}

function get_check_state($id)
{
    global $check_state;
    $result = "";
    
    if ($id == 0)
        return "Not Read";
    
    foreach (bitMask($id) as $k => $v)
        $result .= $check_state[$v].", ";

    return $result;
}

/*
//#############################################################################
//get achievement name by its id

function achieve_get_name($id, &$sqlm)
{
  $achievement_name = $sqlm->fetch_assoc($sqlm->query('SELECT name01 FROM dbc_achievement WHERE id= '.$id.' LIMIT 1'));
  return $achievement_name['name01'];
}


//#############################################################################
//get achievement reward name by its id

function achieve_get_reward($id, &$sqlm)
{
  $achievement_reward = $sqlm->fetch_assoc($sqlm->query('SELECT rewarddesc01 FROM dbc_achievement WHERE id ='.$id.' LIMIT 1'));
  return $achievement_reward['rewarddesc01'];
}


//#############################################################################
//get achievement points name by its id

function achieve_get_points($id, &$sqlm)
{
  $achievement_points = $sqlm->fetch_assoc($sqlm->query('SELECT rewpoints FROM dbc_achievement WHERE id = '.$id.' LIMIT 1'));
  return $achievement_points['rewpoints'];
}


//#############################################################################
//get achievement category name by its id

function achieve_get_category($id, &$sqlm)
{
  $category_id= $sqlm->fetch_assoc($sqlm->query('SELECT categoryid FROM dbc_achievement WHERE id = '.$id.' LIMIT 1'));
  $category_name = $sqlm->fetch_assoc($sqlm->query('SELECT name01 FROM dbc_achievement_category WHERE id = '.$category_id['categoryid'].' LIMIT 1'));
  return $category_name['name01'];
}
*/


//#############################################################################
//get achievements by category id

function achieve_get_id_category($id)
{
    global $sqlm;
    
    $achieve_cat = array();
    $result = $sqlm->fetch("SELECT id, name01, description01, rewarddesc01, rewpoints FROM dbc_achievement WHERE categoryid = %d ORDER BY `order` DESC", $id);
    foreach ($result as $ach)
        $achieve_cat[] = get_object_vars($ach);
    return $achieve_cat;
}


//#############################################################################
//get achievement main category

function achieve_get_main_category()
{
    global $sqlm;
    
    $main_cat = array();
    $result = $sqlm->fetch("SELECT id, name01 FROM dbc_achievement_category WHERE parentid = -1 and id != 1 ORDER BY `order` ASC");
    foreach ($result as $ach)
        $main_cat[] = get_object_vars($ach);
    return $main_cat;
}


//#############################################################################
//get achievement sub category

function achieve_get_sub_category()
{
    global $sqlm;
    
    $sub_cat = array();
    $result = $sqlm->query('SELECT id, parentid, name01 FROM dbc_achievement_category WHERE parentid != -1 ORDER BY `order` ASC');
    
    foreach ($result as $data)
        $sub_cat[$data->parentid][$data->id] = $data->name01;

    return $sub_cat;
}


//#############################################################################
//get achievement details by its id

function achieve_get_details($id)
{
    global $sqlm;
    
    $result = $sqlm->fetch("SELECT id, name01, description01, rewarddesc01, rewpoints FROM dbc_achievement WHERE id = %d LIMIT 1", $id);
    return get_object_vars($result);
}


//#############################################################################
//get achievement icon - if icon not exists in item_icons folder D/L it from web.

function achieve_get_icon($achieveid)
{
    global $proxy_cfg, $get_icons_from_web, $item_icons, $sqlm;

    $result = $sqlm->fetch("SELECT field_42 FROM dbc_achievement WHERE id = %d LIMIT 1", $achieveid);

    if ($result)
        $displayid = $result[0]->field_42;
    else
        $displayid = 0;

    if ($displayid)
    {
        $result = $sqlm->fetch("SELECT field_1 FROM dbc_spellicon WHERE id = %d LIMIT 1", $displayid);

        if($result)
        {
            $achieve_uppercase = $result[0]->field_1;
            $achieve = strtolower($achieve_uppercase);

            if ($achieve)
            {
                if (file_exists($item_icons.'/'.$achieve.'.jpg'))
                {
                    if (filesize($item_icons.'/'.$achieve.'.jpg') > 349)
                    {
                        return $item_icons.'/'.$achieve.'.jpg';
                    }
                    else
                    {
                        $sqlm->action("DELETE FROM dbc_spellicon WHERE id = %d", $displayid);
                        
                        if (file_exists($item_icons.'/'.$achieve.'.jpg'))
                            unlink($item_icons.'/'.$achieve.'.jpg');
                        $achieve = '';
                    }
                }
                else
                    $achieve = '';
            }
            else
                $achieve = '';
        }
        else
            $achieve = '';
    }
    else
        $achieve = '';

    if($get_icons_from_web)
    {
        $xmlfilepath='http://www.wowhead.com/achievement=';
        $proxy = $proxy_cfg['addr'];
        $port = $proxy_cfg['port'];

        if (empty($proxy_cfg['addr']))
        {
            $proxy = 'www.wowhead.com';
            $xmlfilepath = 'achievement=';
            $port = 80;
        }

        if ($achieve == '')
        {
            //get the icon name
            $fp = @fsockopen($proxy, $port, $errno, $errstr, 0.5);
            if ($fp);
            else
                return 'img/INV/INV_blank_32.gif';
                
            $out = "GET /$xmlfilepath$achieveid HTTP/1.0\r\nHost: www.wowhead.com\r\n";
            if (isset($proxy_cfg['user']))
                $out .= "Proxy-Authorization: Basic ". base64_encode ("{$proxy_cfg['user']}:{$proxy_cfg['pass']}")."\r\n";
            $out .="Connection: Close\r\n\r\n";

            $temp = '';
            fwrite($fp, $out);
            while ($fp && !feof($fp))
                $temp .= fgets($fp, 4096);
                
            fclose($fp);

            $wowhead_string = $temp;
            $temp_string1 = strstr($wowhead_string, 'Icon.create(');
            $temp_string2 = substr($temp_string1, 12, 50);
            $temp_string3 = strtok($temp_string2, ',');
            $temp_string4 = substr($temp_string3, 1, strlen($temp_string3) - 2);
            $achieve_icon_name = $temp_string4;

            $achieve_uppercase = $achieve_icon_name;
            $achieve = strtolower($achieve_uppercase);
        }

        if (file_exists(''.$item_icons.'/'.$achieve.'.jpg'))
        {
            if (filesize(''.$item_icons.'/'.$achieve.'.jpg') > 349)
            {
                $sqlm->action("REPLACE INTO dbc_spellicon (id, field_1) VALUES (%d, '%s')", $displayid, $achieve);
                return $item_icons.'/'.$achieve.'.jpg';
            }
            else
            {
                $sqlm->action("DELETE FROM dbc_spellicon WHERE id = %d", $displayid);
                if (file_exists($item_icons.'/'.$achieve.'.jpg'))
                    unlink($item_icons.'/'.$achieve.'.jpg');
            }
        }

        //get the icon itself
        if (empty($proxy_cfg['addr']))
        {
            $proxy = 'static.wowhead.com';
            $port = 80;
        }
        $fp = @fsockopen($proxy, $port, $errno, $errstr, 0.5);
        if ($fp);
        else
            return 'img/INV/INV_blank_32.gif';
        $iconfilename = strtolower($achieve);
        $file = 'http://static.wowhead.com/images/icons/medium/'.$iconfilename.'.jpg';
        $out = "GET $file HTTP/1.0\r\nHost: static.wowhead.com\r\n";
        if (isset($proxy_cfg['user']))
            $out .= "Proxy-Authorization: Basic ". base64_encode ("{$proxy_cfg['user']}:{$proxy_cfg['pass']}")."\r\n";
        $out .="Connection: Close\r\n\r\n";
        fwrite($fp, $out);

        //remove header
        while ($fp && !feof($fp))
        {
            $headerbuffer = fgets($fp, 4096);
            if (urlencode($headerbuffer) == '%0D%0A')
                break;
        }

        if (file_exists($item_icons.'/'.$achieve.'.jpg'))
        {
            if (filesize($item_icons.'/'.$achieve.'.jpg') > 349)
            {
                $sqlm->action("REPLACE INTO dbc_spellicon (id, field_1) VALUES (%d, '%s')", $displayid, $achieve);
                return ''.$item_icons.'/'.$achieve.'.jpg';
            }
            else
            {
                $sqlm->action("DELETE FROM dbc_spellicon WHERE id = %d", $displayid);
                if (file_exists($item_icons.'/'.$achieve.'.jpg'))
                    unlink($item_icons.'/'.$achieve.'.jpg');
            }
        }

        $img_file = fopen(''.$item_icons.'/'.$achieve.'.jpg', 'wb');
        while (!feof($fp))
            fwrite($img_file,fgets($fp, 4096));
        fclose($fp);
        fclose($img_file);

        if (file_exists($item_icons.'/'.$achieve.'.jpg'))
        {
            if (filesize($item_icons.'/'.$achieve.'.jpg') > 349)
            {
                $sqlm->action("REPLACE INTO dbc_spellicon (id, field_1) VALUES (%d, '%s')", $displayid, $achieve);
                return $item_icons.'/'.$achieve.'.jpg';
            }
            else
            {
                $sqlm->action("DELETE FROM dbc_spellicon WHERE id = %d", $displayid);
                if (file_exists($item_icons.'/'.$achieve.'.jpg'))
                    unlink($item_icons.'/'.$achieve.'.jpg');
            }
        }
        else
            return 'img/INV/INV_blank_32.gif';
    }
    else
        return 'img/INV/INV_blank_32.gif';
}

?>
