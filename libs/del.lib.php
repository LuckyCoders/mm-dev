<?php

require_once 'tab.lib.php';

//##########################################################################################
//Delete character
function del_char($guid, $realm)
{
    global  $characters_db, $user_lvl, $user_id, $tab_del_user_characters, $tab_del_pet;


    $sqlc_temp = new MySQL($characters_db[$realm]); //multirealm support

    $query = $sqlc_temp->fetch("SELECT account, online FROM characters WHERE guid = %d LIMIT 1", $guid);
    $owner_acc_id = $query[0]->account;

    $owner_gmlvl = $sqlr->query("SELECT gmlevel FROM account_access WHERE id = %d", $owner_acc_id);

    if (($user_lvl > $owner_gmlvl) || ($owner_acc_id == $user_id))
    {
        if ($query[0]->online);
        else
        {
            //Delete pet aura ,spells and cooldowns
            foreach ($tab_del_pet as $value)
                $sqlc_temp->action("DELETE FROM %s WHERE %s IN (SELECT id FROM character_pet WHERE owner IN (SELECT guid FROM characters WHERE guid = %d))", $value[0], $value[1], $guid);
                
            foreach ($tab_del_user_characters as $value)
                $sqlc_temp->action("DELETE FROM %s WHERE %s = %d", $value[0], $value[1], $guid);

            $chars_in_acc = $sqla->fetch("SELECT numchars FROM realmcharacters WHERE acctid = %d AND realmid = %d", $owner_acc_id, $realm);
            $chars_in_acc = $chars_in_acc[0]->numchars;
            
            if ($chars_in_acc)
                $chars_in_acc--;
            else
                $chars_in_acc = 0;
                
            $sqlr->query('UPDATE realmcharacters SET numchars='.$chars_in_acc.' WHERE acctid ='.$owner_acc_id.' AND realmid = '.$realm.'');
            unset($sqlc_temp);
            return true;
        }
    }
    unset($sqlc_temp);
    return false;
}


//##########################################################################################
//Delete Account - return array(deletion_flag , number_of_chars_deleted)
function del_acc($acc_id)
{
    global 	$characters_db, $user_lvl, $user_id,
            $tab_del_user_realmd, $tab_del_user_char, $tab_del_user_characters, $tab_del_pet, $sqla;

    $del_char = 0;

    $query = $sqla->fetch("SELECT `account`.`online`, `account_access`.`gmlevel` FROM `account` LEFT JOIN `account_access` ON `account`.`id`=`account_access`.`id` WHERE `account`.`id` = %d", $acc_id);


    $gmlevel = $query[0]->gmlevel;

    if (($user_lvl > $gmlevel)||($acc_id == $user_id))
    {
        if ($query[0]->online && !$sqla->num_rows());
        else
        {
            foreach ($characters_db as $db)
            {
                $sqlc_temp = new MySQL($db);

                $result = $sqlc_temp->fetch("SELECT guid FROM characters WHERE account = %d", $acc_id);
                foreach ($result as $row)
                {
                    if (!$tab_del_pet || !$tab_del_user_characters)
                        continue;
                    //Delete pet aura ,spells and cooldowns
                    foreach ($tab_del_pet as $value)
                        $sqlc_temp->action("DELETE FROM %s WHERE %s IN (SELECT id FROM character_pet WHERE owner IN (SELECT guid FROM characters WHERE guid = %d))", $value[0], $value[1], $row->guid);
                    foreach ($tab_del_user_characters as $value)
                        $sqlc_temp->action("DELETE FROM %s WHERE %s = %d", $value[0], $value[1], $row->guid);
                    $del_char++;
                }
                $sqlc_temp->action("DELETE FROM account_data WHERE account = %d", $acc_id);
                unset($sqlc_temp);
            }
            foreach ($tab_del_user_realmd as $value)
                $sqla->fetch("DELETE FROM %s WHERE %s = %d",$value[0], $value[1], $acc_id);
                
            if ($sqla->affected_rows())
                return array(true, $del_char);
        }
    }
    return array(false, $del_char);
}


//##########################################################################################
//Delete Guild
function del_guild($guid, $realm)
{
    global $characters_db, $tab_del_guild, $sqla;


    $sqlc_temp = new MySQL($characters_db[$realm]); //multirealm support
    
    $sqlc_temp->action("DELETE FROM item_instance WHERE guid IN (SELECT item_guid FROM guild_bank_item WHERE guildid = %d)", $guid);

    foreach ($tab_del_guild as $value)
        $sqla->action("DELETE FROM %s WHERE %s = %d", $value[0], $value[1], $guid);

    if ($sqlc_temp->affected_rows())
    {
        unset($sqlc_temp);
        return true;
    }
    unset($sqlc_temp);
    return false;
}

//##########################################################################################
//Delete Arena Team
function del_arenateam($guid, $realm)
{
    global $characters_db, $tab_del_arena, $sqla;

    $sqlc_temp = new MySQL($characters_db[$realm]); //multirealm support
    
    foreach ($tab_del_arena as $value)
        $sqlc_temp->action("DELETE FROM %s WHERE %s = %d", $value[0], $value[1], $guid);

    if ($sqlc_temp->affected_rows())
    {
        unset($sqlc_temp);
        return true;
    }
    unset($sqlc_temp);
    return false;
}


?>
