<?php
    //----Check if a user has login, if Guest mode is enabled, code above will login as Guest
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
    {
        $smarty->assign('isLoggedIn', true);

        $lang_header = lang_header(); //defined in language php
        $menu = array();
        foreach ($menu_array as $trunk)
        {
                $link = $trunk[0];
                $name = (isset($lang_header[$trunk[1]]) ? $lang_header[$trunk[1]] : $trunk[1]);
                $items = array();
                
                foreach ($trunk[2] as $branch)
                    if ($user_lvl >= $branch[2])
                        $items[] = array('filename' => $branch[0], 'name' => (isset($lang_header[$branch[1]]) ? $lang_header[$branch[1]] : $branch[1]));
                
                if ($name != 'invisible')
                    $menu[] = array('name' => $name, 'link' => $link, 'items' => $items);
        }
        
        $items = array();
        $result = $sqla->fetch("SELECT id, name FROM `realmlist` LIMIT 10");

        // we check how many realms are configured, this does not check if config is valid
        if ((1 < $sqla->num_rows()) && (1 < count($server)) && (1 < count($characters_db)))
        {
            $items[] = array('filename' => '#', 'name' => $lang_header['realms']);

            foreach ($result as $realm)
            {
                if(isset($server[$realm->id]))
                {
                    $set = ($realm_id === $realm->id) ? '>' : '';
                    $items[] = array('filename' => 'index.php?page=realm&action=set_def_realm&amp;id='.$realm->id.'&amp;url='.$_SERVER['PHP_SELF'], 'name' => htmlentities($set.' '.$realm->name));
                }
            }
            unset($set);
            unset($realm);
        }

        // we have a different menu for guest account
        if($allow_anony && empty($_SESSION['logged_in']))
        {
            $lang_login = lang_login(); //defined in language php
            $items[] = array('filename' => '#', 'name' => $lang_header['account']);
            $items[] = array('filename' => 'index.php?page=register', 'name' => $lang_login['not_registrated']);
            $items[] = array('filename' => 'index.php?page=login', 'name' => $lang_login['login']);
            unset($lang_login);
        }
        else
        {
            $result = $sqlc->fetch("SELECT guid, name, race, class, level, gender
                                FROM characters 
                                WHERE account = '%d'", $user_id);

            // this puts links to user characters of active realm in "My Account" menu
            if($sqlc->num_rows())
            {
                $items[] = array('filename' => '#', 'name' => $lang_header['my_characters']);
                
                foreach ($result as $char)
                    $items[] = array('filename' => 'char.php?id='.$char->guid, 'name' => '<img src="img/c_icons/'.$char->race.'-'.$char->gender.'.gif" alt="" /><img src="img/c_icons/'.$char->class.'.gif" alt="" />'.$char->name);

                unset($char);
            }
            $items[] = array('filename' => '#', 'name' => $lang_header['account']);
            $items[] = array('filename' => 'index.php?page=edit', 'name' => $lang_header['edit_my_acc']);
            $items[] = array('filename' => 'index.php?page=logout', 'name' => $lang_header['logout']);
        }
        $menu[] = array('link' => 'index.php?page=edit', 'name' => $lang_header['my_acc'], 'items' => $items);        
        $smarty->assign('topmenu',$menu);
        $smarty->assign('user_name',$user_name);
        $smarty->assign('user_lvl_name',$user_lvl_name);
        $smarty->assign('lang_header_menu',$lang_header['menu']);


        //---------------------Version Information-------------------------------------
        if ( $show_version['show'] && $user_lvl >= $show_version['version_lvl'] )
        {
            $smarty->assign('showVersion',true);
            
            if ((1 < $show_version['show']) && $user_lvl >= $show_version['svnrev_lvl'])
            {
                $show_version['svnrev'] = '';
                // if file exists and readable
                if (is_readable('.svn/entries'))
                {
                    $file_obj = new SplFileObject('.svn/entries');
                    // line 4 is where svn revision is stored
                    $file_obj->seek(3);
                    $show_version['svnrev'] = $file_obj->current();
                    unset($file_obj);
                }
                $smarty->assign('version',$show_version['version'].' r'.$show_version['svnrev']);
            }
            else
                $smarty->assign('version',$show_version['version']);
        }
    }
    $smarty->display('mainbody.tpl');
    $smarty->clear_all_assign();
?>