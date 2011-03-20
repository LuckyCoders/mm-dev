<?php
error_reporting(E_ALL);

//#############################################################################
//get item set name by its id

function get_itemset_name($id, &$sqlm=0)
{
    if (empty($sqlm))
    {
        global $sqlm;
    }
    $itemset = $sqlm->fetch("SELECT `field_1` FROM `dbc_itemset` WHERE `id`=%d LIMIT 1", $id);
    return $itemset[0]->field_1;
}


//#############################################################################
//generate item border from item_template.entry

function get_item_border($item_id, &$sqlw=0)
{
    global $world_db;
    if (empty($sqlw))
        global $sqlw;
        
    if($item_id)
    {
        $result = $sqlw->fetch("SELECT Quality FROM item_template WHERE entry = '%d'", $item_id);
        $iborder = (1 == $sqlw->num_rows()) ? $result[0]->Quality : 'Quality: '.$iborder.' Not Found';

        return 'icon_border_'.$iborder.'';
    }
    else
        return 'icon_border_0';
}


//#############################################################################
//get item name from item_template.entry

function get_item_name($item_id, &$sqlw=0)
{
    global $world_db, $realm_id;

    if($item_id)
    {
        if (empty($sqlw))
            global $sqlw;

        $deplang = get_lang_id();
        $result = $sqlw->fetch("SELECT IFNULL(%s, name) as name FROM item_template LEFT JOIN locales_item ON item_template.entry = locales_item.entry WHERE item_template.entry = '%d'", ($deplang<>0 ? 'name_loc'.$deplang.'' : 'NULL'), $item_id);
        $item_name = (1 == $sqlw->num_rows()) ? $result[0]->name : 'ItemID: '.$item_id.' Not Found' ;

        return $item_name;
    }
    else
        return NULL;
}


//#############################################################################
//get item icon - if icon not exists in item_icons folder D/L it from web.

function get_item_icon($itemid, &$sqlm=0, &$sqlw=0)
{
    global $mmfpm_db, $world_db, $realm_id, $proxy_cfg, $get_icons_from_web, $item_icons;

    // not all functions that call this function will pass reference to existing SQL links
    // so we need to check and overload when needed
    if (empty($sqlm))
    {
        global $sqlm;
    }
    if (empty($sqlw))
    {
        global $sqlw;
    }

    $result = $sqlw->fetch("SELECT `displayid` FROM `item_template` WHERE `entry` = %d LIMIT 1", $itemid);

    if ($result)
        $displayid = $result[0]->displayid;
    else
    {
        $result = $sqlm->fetch("SELECT `field_5` FROM `dbc_item` WHERE `id` = %d LIMIT 1", $itemid);
        if ($result)
            $displayid = $result[0]->field_5;
        else
            $displayid = 0;
    }

    if ($displayid)
    {
        $result = $sqlm->fetch("SELECT `field_5` FROM `dbc_itemdisplayinfo` WHERE `id`=%d LIMIT 1", $displayid);

        if($result)
        {
            $item_uppercase = $result[0]->field_5;
            $item = strtolower($item_uppercase);

            if ($item)
            {
                if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
                {
                    if (filesize(''.$item_icons.'/'.$item.'.jpg') > 349)
                    {
                        return ''.$item_icons.'/'.$item.'.jpg';
                    }
                    else
                    {
                        $sqlm->action("DELETE FROM dbc_itemdisplayinfo WHERE id = %d", $displayid);
                        if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
                            unlink(''.$item_icons.'/'.$item.'.jpg');
                        $item = '';
                    }
                }
                else
                    $item = '';
            }
            else
                $item = '';
        }
        else
            $item = '';
    }
    else
       $item = '';

    if($get_icons_from_web)
    {
        $xmlfilepath="http://www.wowhead.com/item=";
        $proxy = $proxy_cfg['addr'];
        $port = $proxy_cfg['port'];

        if (empty($proxy_cfg['addr']))
        {
            $proxy = "www.wowhead.com";
            $xmlfilepath = "item=";
            $port = 80;
        }

        if ($item == '')
        {
            //get the icon name
            $fp = @fsockopen($proxy, $port, $errno, $errstr, 0.5);
            if (!$fp)
                return "img/INV/INV_blank_32.gif";
            $out = "GET /$xmlfilepath$itemid HTTP/1.0\r\nHost: www.wowhead.com\r\n";
            if (!empty($proxy_cfg['user']))
                $out .= "Proxy-Authorization: Basic ". base64_encode ("{$proxy_cfg['user']}:{$proxy_cfg['pass']}")."\r\n";
            $out .="Connection: Close\r\n\r\n";

            $temp = "";
            fwrite($fp, $out);
            while ($fp && !feof($fp))
                $temp .= fgets($fp, 4096);
            fclose($fp);

            $wowhead_string = $temp;
            $temp_string1 = strstr($wowhead_string, "Icon.create(");
            $temp_string2 = substr($temp_string1, 12, 50);
            $temp_string3 = strtok($temp_string2, ',');
            $temp_string4 = substr($temp_string3, 1, strlen($temp_string3) - 2);
            $icon_name = $temp_string4;

            $item_uppercase = $icon_name;
            $item = strtolower($item_uppercase);
        }

        if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
        {
            if (filesize(''.$item_icons.'/'.$item.'.jpg') > 349)
            {
                $sqlm->action("REPLACE INTO dbc_itemdisplayinfo (id, field_5) VALUES ('%d', '%s')", $displayid, $item);
                return ''.$item_icons.'/'.$item.'.jpg';
            }
            else
            {
                $sqlm->action("DELETE FROM dbc_itemdisplayinfo WHERE id = %d", $displayid);
                if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
                    unlink(''.$item_icons.'/'.$item.'.jpg');
            }
        }

        //get the icon itself
        if (empty($proxy_cfg['addr']))
        {
            $proxy = "static.wowhead.com";
            $port = 80;
        }
        $fp = @fsockopen($proxy, $port, $errno, $errstr, 0.5);
        if (!$fp)
            return "img/INV/INV_blank_32.gif";
        $iconfilename = strtolower($item);
        $file = "http://static.wowhead.com/images/icons/medium/$iconfilename.jpg";
        $out = "GET $file HTTP/1.0\r\nHost: static.wowhead.com\r\n";
        if (!empty($proxy_cfg['user']))
            $out .= "Proxy-Authorization: Basic ". base64_encode ("{$proxy_cfg['user']}:{$proxy_cfg['pass']}")."\r\n";
        $out .="Connection: Close\r\n\r\n";
        fwrite($fp, $out);

        //remove header
        while ($fp && !feof($fp))
        {
            $headerbuffer = fgets($fp, 4096);
            if (urlencode($headerbuffer) == "%0D%0A")
                break;
        }

        if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
        {
            if (filesize(''.$item_icons.'/'.$item.'.jpg') > 349)
            {
                $sqlm->action("REPLACE INTO dbc_itemdisplayinfo (id, field_5) VALUES ('%d', '%s')", $displayid, $item);
                return ''.$item_icons.'/'.$item.'.jpg';
            }
            else
            {
                $sqlm->action("DELETE FROM dbc_itemdisplayinfo WHERE id = %d", $displayid);
                if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
                    unlink(''.$item_icons.'/'.$item.'.jpg');
            }
        }

        $img_file = fopen("$item_icons/$item.jpg", 'wb');
        while (!feof($fp))
            fwrite($img_file,fgets($fp, 4096));
        fclose($fp);
        fclose($img_file);

        if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
        {
            if (filesize(''.$item_icons.'/'.$item.'.jpg') > 349)
            {
                $sqlm->action("REPLACE INTO dbc_itemdisplayinfo (id, field_5) VALUES ('%d', '%s')", $displayid, $item);
                return ''.$item_icons.'/'.$item.'.jpg';
            }
            else
            {
                $sqlm->action("DELETE FROM dbc_itemdisplayinfo WHERE id = %d", $displayid);
                if (file_exists(''.$item_icons.'/'.$item.'.jpg'))
                    unlink(''.$item_icons.'/'.$item.'.jpg');
            }
        }
        else
            return "img/INV/INV_blank_32.gif";
    }
    else
        return "img/INV/INV_blank_32.gif";
}


//#############################################################################
//generate item tooltip from item_template.entry

function get_item_tooltip($item_id)
{
  global $lang_item, $lang_id_tab, $world_db, $realm_id, $language, $sqlw;
  if($item_id)
  {
    $deplang = get_lang_id();
    $item = $sqlw->fetch("SELECT stat_type1,stat_value1,stat_type2,
      stat_value2,stat_type3,stat_value3,stat_type4,stat_value4,stat_type5,
      stat_value5,stat_type6,stat_value6,stat_type7,stat_value7,stat_type8,
      stat_value8,stat_type9,stat_value9,stat_type10,stat_value10,armor,
      holy_res,fire_res,nature_res,frost_res,arcane_res,shadow_res,spellid_1,
      spellid_2,spellid_3,spellid_4,spellid_5,
      IFNULL(%s,name) as name,class,subclass,
      Quality,RequiredLevel,dmg_min1,dmg_max1,dmg_type1,dmg_min2,dmg_max2,
      dmg_type2,delay,bonding,description,itemset,item_template.entry,
      InventoryType,ItemLevel,displayid,maxcount,spelltrigger_1,spelltrigger_2,
      spelltrigger_3,spelltrigger_4,spelltrigger_5,ContainerSlots,
      spellcharges_1,spellcharges_2,spellcharges_3,spellcharges_4,
      spellcharges_5,AllowableClass,socketColor_1,socketColor_2,socketColor_3,
      RandomProperty,RandomSuffix
      FROM item_template LEFT JOIN locales_item ON item_template.entry = locales_item.entry
      WHERE item_template.entry = '%d' LIMIT 1", ($deplang<>0 ? "name_loc".$deplang : "NULL"), $item_id);
      
    if ($sqlw->num_rows())
    {
        $tooltip = "";

        $itemname = htmlspecialchars($item[0]->name);
        switch ($item[0]->Quality)
        {
            case 0: //Grey Poor
                $tooltip .= "<font color='#b2c2b9' class='large'>$itemname</font><br />";
                break;
            case 1: //White Common
                $tooltip .= "<font color='white' class='large'>$itemname</font><br />";
                break;
            case 2: //Green Uncommon
                $tooltip .= "<font color='#1eff00' class='large'>$itemname</font><br />";
                break;
            case 3: //Blue Rare
                $tooltip .= "<font color='#0070dd' class='large'>$itemname</font><br />";
                break;
            case 4: //Purple Epic
                $tooltip .= "<font color='#a335ee' class='large'>$itemname</font><br />";
                break;
            case 5: //Orange Legendary
                $tooltip .= "<font color='orange' class='large'>$itemname</font><br />";
                break;
            case 6: //Red Artifact
                $tooltip .= "<font color='red' class='large'>$itemname</font><br />";
                break;
            default:
        }

        $tooltip .= "<font color='white'>";

        switch ($item[0]->bonding)
        {
            case 1: //Binds when Picked Up
                $tooltip .= "{$lang_item['bop']}<br />";
                break;
            case 2: //Binds when Equipped
                $tooltip .= "{$lang_item['boe']}<br />";
                break;
            case 3: //Binds when Used
                $tooltip .= "{$lang_item['bou']}<br />";
                break;
            case 4: //Quest Item
                $tooltip .= "{$lang_item['quest_item']}<br />";
                break;
            default:
        }

      //if ($item[60]) $tooltip .= "{$lang_item['unique']}<br />";

      $tooltip .= "<br />";

      switch ($item[0]->InventoryType)
      {
        case 1:
          $tooltip .= "{$lang_item['head']} - ";
          break;
        case 2:
          $tooltip .= "{$lang_item['neck']} - ";
          break;
        case 3:
          $tooltip .= "{$lang_item['shoulder']} - ";
          break;
        case 4:
          $tooltip .= "{$lang_item['shirt']} - ";
          break;
        case 5:
          $tooltip .= "{$lang_item['chest']} - ";
          break;
        case 6:
          $tooltip .= "{$lang_item['belt']} - ";
          break;
        case 7:
          $tooltip .= "{$lang_item['legs']} - ";
          break;
        case 8:
          $tooltip .= "{$lang_item['feet']} - ";
          break;
        case 9:
          $tooltip .= "{$lang_item['wrist']} - ";
          break;
        case 10:
          $tooltip .= "{$lang_item['gloves']} - ";
          break;
        case 11:
          $tooltip .= "{$lang_item['finger']} - ";
          break;
        case 12:
          $tooltip .= "{$lang_item['trinket']} - ";
          break;
        case 13:
          $tooltip .= "{$lang_item['one_hand']} - ";
          break;
        case 14:
          $tooltip .= "{$lang_item['off_hand']} - ";
          break;
        case 16:
          $tooltip .= "{$lang_item['back']} - ";
          break;
        case 18:
          $tooltip .= "{$lang_item['bag']}";
          break;
        case 19:
          $tooltip .= "{$lang_item['tabard']} - ";
          break;
        case 20:
          $tooltip .= "{$lang_item['robe']} - ";
          break;
        case 21:
          $tooltip .= "{$lang_item['main_hand']} - ";
          break;
        case 23:
          $tooltip .= "{$lang_item['tome']} - ";
          break;
        default:
      }
      switch ($item[0]->class)
      {
        case 0: //Consumable
          $tooltip .= "{$lang_item['consumable']}<br />";
          break;
        case 2: //Weapon
          switch ($item[0]->subclass)
          {
            case 0:
              $tooltip .= "{$lang_item['axe_1h']}<br />";
              break;
            case 1:
              $tooltip .= "{$lang_item['axe_2h']}<br />";
              break;
            case 2:
              $tooltip .= "{$lang_item['bow']}<br />";
              break;
            case 3:
              $tooltip .= "{$lang_item['rifle']}<br />";
              break;
            case 4:
              $tooltip .= "{$lang_item['mace_1h']}<br />";
              break;
            case 5:
              $tooltip .= "{$lang_item['mace_2h']}<br />";
              break;
            case 6:
              $tooltip .= "{$lang_item['polearm']}<br />";
              break;
            case 7:
              $tooltip .= "{$lang_item['sword_1h']}<br />";
              break;
            case 8:
              $tooltip .= "{$lang_item['sword_2h']}<br />";
              break;
            case 10:
              $tooltip .= "{$lang_item['staff']}<br />";
              break;
            case 11:
              $tooltip .= "{$lang_item['exotic_1h']}<br />";
              break;
            case 12:
              $tooltip .= "{$lang_item['exotic_2h']}<br />";
              break;
            case 13:
              $tooltip .= "{$lang_item['fist_weapon']}<br />";
              break;
            case 14:
              $tooltip .= "{$lang_item['misc_weapon']}<br />";
              break;
            case 15:
              $tooltip .= "{$lang_item['dagger']}<br />";
              break;
            case 16:
              $tooltip .= "{$lang_item['thrown']}<br />";
              break;
            case 17:
              $tooltip .= "{$lang_item['spear']}<br />";
              break;
            case 18:
              $tooltip .= "{$lang_item['crossbow']}<br />";
              break;
            case 19:
              $tooltip .= "{$lang_item['wand']}<br />";
              break;
            case 20:
              $tooltip .= "{$lang_item['fishing_pole']}<br />";
              break;
            default:
          }
          break;
        case 4: //Armor
          switch ($item[0]->subclass)
          {
            case 0:
              $tooltip .= "{$lang_item['misc']}<br />";
              break;
            case 1:
              $tooltip .= "{$lang_item['cloth']}<br />";
              break;
            case 2:
              $tooltip .= "{$lang_item['leather']}<br />";
              break;
            case 3:
              $tooltip .= "{$lang_item['mail']}<br />";
              break;
            case 4:
              $tooltip .= "{$lang_item['plate']}<br />";
              break;
            case 6:
              $tooltip .= "{$lang_item['shield']}<br />";
              break;
            default:
          }
          break;
        case 6: //Projectile
          switch ($item[0]->subclass)
          {
            case 2:
              $tooltip .= "{$lang_item['arrows']}<br />";
              break;
            case 3:
              $tooltip .= "{$lang_item['bullets']}<br />";
              break;
            default:
          }
          break;
        case 7: //Trade Goods
          switch ($item[0]->subclass)
          {
            case 0:
              $tooltip .= "{$lang_item['trade_goods']}<br />";
              break;
            case 1:
              $tooltip .= "{$lang_item['parts']}<br />";
              break;
            case 2:
              $tooltip .= "{$lang_item['explosives']}<br />";
              break;
            case 3:
              $tooltip .= "{$lang_item['devices']}<br />";
              break;
            default:
          }
          break;
        case 9: //Recipe
          switch ($item[0]->subclass)
          {
            case 0:
              $tooltip .= "{$lang_item['book']}<br />";
              break;
            case 1:
              $tooltip .= "{$lang_item['LW_pattern']}<br />";
              break;
            case 2:
              $tooltip .= "{$lang_item['tailoring_pattern']}<br />";
              break;
            case 3:
              $tooltip .= "{$lang_item['ENG_Schematic']}<br />";
              break;
            case 4:
              $tooltip .= "{$lang_item['BS_plans']}<br />";
              break;
            case 5:
              $tooltip .= "{$lang_item['cooking_recipe']}<br />";
              break;
            case 6:
              $tooltip .= "{$lang_item['alchemy_recipe']}<br />";
              break;
            case 7:
              $tooltip .= "{$lang_item['FA_manual']}<br />";
              break;
            case 8:
              $tooltip .= "{$lang_item['ench_formula']}<br />";
              break;
            case 9:
              $tooltip .= "{$lang_item['JC_formula']}<br />";
              break;
            default:
          }
          break;
        case 11: //Quiver
          switch ($item[0]->subclass)
          {
            case 2:
              $tooltip .= " {$lang_item['quiver']}<br />";
              break;
            case 3:
              $tooltip .= " {$lang_item['ammo_pouch']}<br />";
              break;
            default:
          }
          break;
        case 12: //Quest
          if ($item[0]->bonding != 4)
            $tooltip .= "{$lang_item['quest_item']}<br />";
          break;
        case 13: //key
          switch ($item[0]->subclass)
          {
            case 0:
              $tooltip .= "{$lang_item['key']}<br />";
              break;
            case 1:
              $tooltip .= "{$lang_item['lockpick']}<br />";
              break;
            default:
          }
          break;
        default:
      }
      $tooltip .= $item[0]->armor." {$lang_item['armor']}<br />";

      /*for($f=37;$f<=51;$f+=3)
      {
        $dmg_type = $item[$f+2];
        $min_dmg_value = $item[$f];
        $max_dmg_value = $item[$f+1];

        if ($min_dmg_value && $max_dmg_value)
        {
          switch ($dmg_type)
          {
            case 0: // Physical
              $tooltip .= "$min_dmg_value - $max_dmg_value {$lang_item['damage']}<br />(".($item[52] ? round(((($min_dmg_value+$max_dmg_value)/2)/($item[52]/1000)),2): $min_dmg_value)." DPS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$lang_item['speed']} : ".(($item[52])/1000)."<br />";
              break;
            case 1: // Holy
              $tooltip .= "$min_dmg_value - $max_dmg_value {$lang_item['holy_dmg']}<br />";
              break;
            case 2: // Fire
              $tooltip .= "$min_dmg_value - $max_dmg_value {$lang_item['fire_dmg']}<br />";
              break;
            case 3: // Nature
              $tooltip .= "$min_dmg_value - $max_dmg_value {$lang_item['nature_dmg']}<br />";
              break;
            case 4: // Frost
              $tooltip .= "$min_dmg_value - $max_dmg_value {$lang_item['frost_dmg']}<br />";
              break;
            case 5: // Shadow
              $tooltip .= "$min_dmg_value - $max_dmg_value {$lang_item['shadow_dmg']}<br />";
              break;
            case 6: // Arcane
              $tooltip .= "$min_dmg_value - $max_dmg_value {$lang_item['arcane_dmg']}<br />";
              break;
            default:
          }
        }
      }*/

      /*//basic status
      for($s=0;$s<=18;$s+=2)
      {
        $stat_value = $item[$s+1];
        if ($item[$s] && $stat_value)
        {
          switch ($item[$s])
          {
            case 1:
              $tooltip .= "+$stat_value {$lang_item['health']}<br />";
              break;
            case 2:
              $tooltip .= "+$stat_value {$lang_item['mana']}<br />";
              break;
            case 3:
              $tooltip .= "+$stat_value {$lang_item['agility']}<br />";
              break;
            case 4:
              $tooltip .= "+$stat_value {$lang_item['strength']}<br />";
              break;
            case 5:
              $tooltip .= "+$stat_value {$lang_item['intellect']}<br />";
              break;
            case 6:
              $tooltip .= "+$stat_value {$lang_item['spirit']}<br />";
              break;
            case 7:
              $tooltip .= "+$stat_value {$lang_item['stamina']}<br />";
              break;
            default:
              $flag_rating = 1;
          }
        }
      }*/

      if ($item[0]->holy_res) $tooltip .= $item[0]->holy_res." {$lang_item['res_holy']}<br />";
      if ($item[0]->arcane_res) $tooltip .= $item[0]->arcane_res." {$lang_item['res_arcane']}<br />";
      if ($item[0]->fire_res) $tooltip .= $item[0]->fire_res." {$lang_item['res_fire']}<br />";
      if ($item[0]->nature_res) $tooltip .= $item[0]->nature_res." {$lang_item['res_nature']}<br />";
      if ($item[0]->frost_res) $tooltip .= $item[0]->frost_res." {$lang_item['res_frost']}<br />";
      if ($item[0]->shadow_res) $tooltip .= $item[0]->shadow_res." {$lang_item['res_shadow']}<br />";

      /*//sockets
      for($p=72;$p<=74;$p++)
      {
        if($item[$p])
        {
          switch ($item[$p])
          {
            case 1:
              $tooltip .= "<img src='img/socket_meta.gif' alt='' /><font color='gray'> {$lang_item['socket_meta']}</font><br />";
              break;
            case 2:
              $tooltip .= "<img src='img/socket_red.gif' alt='' /><font color='red'> {$lang_item['socket_red']}</font><br />";
              break;
            case 4:
              $tooltip .= "<img src='img/socket_yellow.gif' alt='' /><font color='yellow'> {$lang_item['socket_yellow']}</font><br />";
              break;
            case 8:
              $tooltip .= "<img src='img/socket_blue.gif' alt='' /><font color='blue'> {$lang_item['socket_blue']}</font><br />";
              break;
            default:
          }
        }
      }*/

      //level requierment
      if($item[0]->RequiredLevel)
        $tooltip .= $lang_item['lvl_req']." ".$item[0]->RequiredLevel."<br />";

      //allowable classes
      if (($item[0]->AllowableClass)&&($item[0]->AllowableClass != -1)&&($item[0]->AllowableClass != 1503))
      {
        $tooltip .= "{$lang_item['class']}:";
        if ($item[0]->AllowableClass & 1) $tooltip .= " {$lang_id_tab['warrior']} ";
        if ($item[0]->AllowableClass & 2) $tooltip .= " {$lang_id_tab['paladin']} ";
        if ($item[0]->AllowableClass & 4) $tooltip .= " {$lang_id_tab['hunter']} ";
        if ($item[0]->AllowableClass & 8) $tooltip .= " {$lang_id_tab['rogue']} ";
        if ($item[0]->AllowableClass & 16) $tooltip .= " {$lang_id_tab['priest']} ";
        if ($item[0]->AllowableClass & 64) $tooltip .= " {$lang_id_tab['shaman']} ";
        if ($item[0]->AllowableClass & 128) $tooltip .= " {$lang_id_tab['mage']} ";
        if ($item[0]->AllowableClass & 256) $tooltip .= " {$lang_id_tab['warlock']} ";
        if ($item[0]->AllowableClass & 1024) $tooltip .= " {$lang_id_tab['druid']} ";
        $tooltip .= "<br />";
      }

      //number of bag slots
      if ($item[0]->ContainerSlots)
        $tooltip .= $item[0]->ContainerSlots. " {$lang_item['slots']}<br />";

      $tooltip .= "</font><br /><font color='#1eff00'>";
      //random enchantments
      if ($item[0]->RandomProperty || $item[0]->RandomSuffix)
        $tooltip .= "&lt; Random enchantment &gt;<br />";

      /*//Ratings additions.
      if (isset($flag_rating))
      {
        for($s=0;$s<=18;$s+=2)
        {
          $stat_type = $item[$s];
          $stat_value = $item[$s+1];
          if ($stat_type && $stat_value)
          {
            switch ($stat_type)
            {
              case 12:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['DEFENCE_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 13:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['DODGE_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 14:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['PARRY_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 15:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['SHIELD_BLOCK_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 16:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['MELEE_HIT_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 17:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['RANGED_HIT_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 18:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['SPELL_HIT_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 19:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['MELEE_CS_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 20:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['RANGED_CS_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 21:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['SPELL_CS_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 22:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['MELEE_HA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 23:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['RANGED_HA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 24:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['SPELL_HA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 25:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['MELEE_CA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 26:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['RANGED_CA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 27:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['SPELL_CA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 28:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['MELEE_HASTE_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 29:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['RANGED_HASTE_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 30:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['SPELL_HASTE_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 31:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['HIT_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 32:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['CS_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 33:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['HA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 34:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['CA_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 35:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['RESILIENCE_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              case 36:
                $tooltip .= "{$lang_item['spell_equip']}: {$lang_item['improves']} {$lang_item['HASTE_RATING']} {$lang_item['rating_by']} $stat_value.<br />";
                break;
              default:
            }
          }
        }
      }*/
      /*
      //add equip spellid to status
      for($s1=27;$s1<=31;$s1++)
      {
        if ($item[$s1])
        {
          switch ($item[$s1+34])
          {
            case 0:
              $tooltip .= "{$lang_item['spell_use']}: ";
              break;
            case 1:
              $tooltip .= "{$lang_item['spell_equip']}: ";
              break;
            case 2:
              $tooltip .= "{$lang_item['spell_coh']}: ";
              break;
            default:
          }
          $tooltip .= " $item[$s1]<br />";
          if ($item[$s1])
          {
            if ($item[$s1+40])
              $tooltip.= abs($item[$s1+40])." {$lang_item['charges']}.<br />";
          }
        }
      }*/

      $tooltip .= "</font>";

      if ($item[0]->itemset)
        $tooltip .= "<br /><font color='orange'>{$lang_item['item_set']} : ".get_itemset_name($item[0]->itemset)." (".$item[0]->itemset.")</font>";

      if ($item[0]->description)
        $tooltip .= "<br /><font color='orange'>''".str_replace("\"", " '", $item[0]->description)."'</font>";

    }
    else
      $tooltip = "Item ID: ".$item_id." Not Found" ;

    return $tooltip;
  }
  else
    return(NULL);
}


?>
