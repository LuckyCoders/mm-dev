<?php error_reporting(E_ALL & ~E_NOTICE);
    if (ini_get('max_execution_time') < 1800)
    {
        if (ini_set('max_execution_time',0));
        else
            error('Error - max_execution_time not set.<br /> Please set it manually to 0, in php.ini for full functionality.');
    }
    
    /**
     * Redirect to another page
     *
     * @param: url (string) URL to which browser gets redirected to
     * @param: errorpage (optionable boolean) If true, $url gets appended to actual url         
     */
    function redirect($url, $errorpage = false)
    {
        if ($errorpage)
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$url;
            
        if (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') === false)
        {
            header('Location: '.$url);
            exit();
        }
        else 
            die('<meta http-equiv="refresh" content="0;URL='.$url.'" />');
    }
    
    /**
     * Output wowhead script
     */
    function wowhead_tt()
    {
        global $smarty, $tt_script;
        $smarty->assign('tt_script', $tt_script);
        $smarty->display('wowhead.tpl');
        $smarty->clear_all_assign();
    }
    
    /**
     * Test if a port on a specific host is open/connectable
     * 
     * @param: server (string) Hostname/IP-Adress
     * @param: port (int) Port which should be checked
     * @return: testresult (boolean) true -> connectable
     */
    function test_port($server,$port)
    {
        $sock = @fsockopen($server, $port, $ERROR_NO, $ERROR_STR, (float)0.5);
        if($sock)
        {
            @fclose($sock);
            return true;
        }
        else
            return false;
    }
    
    /**
     * Convert seconds to "%d day/s %d hour/s %d minute/s %d second/s"
     *
     * @param: seconds (integer) -
     * @result: formatted time (string)
     */
    function format_uptime($seconds)
    {
        $secs  = intval($seconds % 60);
        $mins  = intval($seconds / 60 % 60);
        $hours = intval($seconds / 3600 % 24);
        $days  = intval($seconds / 86400);

        $uptimeString='';

        if ($days)
        {
            $uptimeString .= $days;
            $uptimeString .= ((1 === $days) ? ' day' : ' days');
        }
        if ($hours)
        {
            $uptimeString .= ((0 < $days) ? ', ' : '').$hours;
            $uptimeString .= ((1 === $hours) ? ' hour' : ' hours');
        }
        if ($mins)
        {
            $uptimeString .= ((0 < $days || 0 < $hours) ? ', ' : '').$mins;
            $uptimeString .= ((1 === $mins) ? ' minute' : ' minutes');
        }
        if ($secs)
        {
            $uptimeString .= ((0 < $days || 0 < $hours || 0 < $mins) ? ', ' : '').$secs;
            $uptimeString .= ((1 === $secs) ? ' second' : ' seconds');
        }
        return $uptimeString;
    }
    
    //#############################################################################
    // Generate paging navigation.
    // Original from PHPBB with some modifications to make them more simple
    function generate_pagination($base_url, $num_items, $per_page, $start_item, $start_tag = 'start', $add_prevnext_text = TRUE)
    {
        if ($num_items);
        else 
            return '';
            
        $total_pages = ceil(intval($num_items)/$per_page);
        if (1 == $total_pages)
            return '';

        $on_page = floor($start_item / $per_page)+1;
        $page_string = '';
        if (10 < $total_pages)
        {
            $init_page_max = (3 < $total_pages) ? 3 : $total_pages;
            $count = $init_page_max+1;
            for($i=1; $i<$count; ++$i)
            {
                $page_string .= ($i == $on_page) ? '<b>'.$i.'</b>' : '<a href="'.$base_url.'&amp;'.$start_tag.'='.(($i-1)*$per_page).'">'.$i.'</a>';
                if ($i < $init_page_max)
                    $page_string .= ', ';
            }
            if (3 < $total_pages)
            {
                if (1 < $on_page && $on_page < $total_pages)
                {
                    $page_string  .= (5 < $on_page) ? ' ... ' : ', ';
                    $init_page_min = (4 < $on_page) ? $on_page : 5;
                    $init_page_max = ($on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

                    $count = $init_page_max+2;
                    for($i=$init_page_min-1; $i<$count; ++$i)
                    {
                        $page_string .= ($i === $on_page) ? '<b>'.$i.'</b>' : '<a href="'.$base_url.'&amp;'.$start_tag.'='.(($i-1)*$per_page).'">'.$i.'</a>';
                        if ($i <  $init_page_max+1)
                            $page_string .= ', ';
                    }
                    $page_string .= ($on_page < $total_pages-4) ? ' ... ' : ', ';
                }
                else
                    $page_string .= ' ... ';
                $count = $total_pages+1;
                for($i=$total_pages-2; $i<$count; ++$i)
                {
                    $page_string .= ($i == $on_page) ? '<b>'.$i.'</b>'  : '<a href="'.$base_url.'&amp;'.$start_tag.'='.(($i-1)*$per_page).'">'.$i.'</a>';
                    if($i < $total_pages)
                        $page_string .= ', ';
                }
            }
        }
        else
        {
            $count = $total_pages+1;
            for($i=1; $i<$count; ++$i)
            {
                $page_string .= ($i == $on_page) ? '<b>'.$i.'</b>' : '<a href="'.$base_url.'&amp;'.$start_tag.'='.(($i-1)*$per_page).'">'.$i.'</a>';
                if ($i <  $total_pages)
                    $page_string .= ', ';
            }
        }
        if ($add_prevnext_text)
        {
            if (1 < $on_page)
                $page_string = '<a href="'.$base_url.'&amp;'.$start_tag.'='.(($on_page-2)*$per_page).'">Prev</a>&nbsp;&nbsp;'.$page_string;
                
            if ($on_page < $total_pages)
                $page_string .= '&nbsp;&nbsp;<a href="'.$base_url.'&amp;'.$start_tag.'='.($on_page*$per_page).'">Next</a>';
        }
        
        $page_string = 'Page: '.$page_string;

        return $page_string;
    }
    
    //#############################################################################
    //get country code and country name by IP
    // given IP, returns array('code','country')
    // 'code' is country code, 'country' is country name.

    function misc_get_country_by_ip($ip)
    {
        global $sqlm;
        
        $country = $sqlm->fetch("SELECT c.code, c.country FROM ip2nationCountries c, ip2nation i WHERE i.ip < INET_ATON(\"%s\") AND c.code = i.country ORDER BY i.ip DESC LIMIT 0,1;", $ip);

        return array("code" => $country[0]->code, "country" => $country[0]->country);
    }


    //#############################################################################
    //get country code and country name by IP
    // given account ID, returns array('code','country')
    // 'code' is country code, 'country' is country name.

    function misc_get_country_by_account($account)
    {
        global $sqla;
        
        $ip = $sqla->fetch("SELECT last_ip FROM account WHERE id='%s';", $account);

        return misc_get_country_by_ip($ip[0]->last_ip);
    }
?>