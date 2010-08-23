<?php
//#############################################################################
//
// configuration note.
//
// Do not edit, move or delete this file.
//
// Option 1 (recommended)
//  Copy config.user.php as config.php.
//  Copy only the settings you want to change into config.php
//  Make changes there.
//
// Option 2
//  Copy this file as config.php,
//  Make changes there.


//#############################################################################
//---- Version Information ----

$show_version['show']        =  '2';    // 0 - Don't Show, 1 - Show Version, 2 - Show Version and SVN Revision
$show_version['version']     =  '0.2 - Development';
$show_version['version_lvl'] = '-1';    // Minimum account level to show Version to, -1 is guest account
$show_version['svnrev']      =  '0';    // SVN Revision will be read from .svn folder, values here hold no meaning or effect
$show_version['svnrev_lvl']  =  '5';    // Minimum account level to show SVN Revision to.

// only Creature, Item and Game Object uses this setting, the rest uses $itemperpage.
// $itemperpage setting is lower down at Layout configuration.
$sql_search_limit =  100;                         // limit number of maximum search results

$mmfpm_db['dbHost']     = '127.0.0.1:3306';         // SQL server IP:port this DB located on
$mmfpm_db['dbUser']     = 'root';                   // SQL server login this DB located on
$mmfpm_db['dbPass']     = '';                      // SQL server pass this DB located on
$mmfpm_db['dbName']     = 'mmftc';                  // MiniManager DB name

$auth_db['dbHost']     = '127.0.0.1:3306';         // SQL server IP:port this auth located on
$auth_db['dbUser']     = 'root';                   // SQL server login this auth located on
$auth_db['dbPass']     = '';                      // SQL server pass this auth located on
$auth_db['dbName']     = 'auth';                 // auth DB name

          // position in array must represent realmd ID
$world_db[1]['dbHost']          = '127.0.0.1:3306'; // SQL server IP:port this DB located on
$world_db[1]['dbUser']          = 'root';           // SQL server login this DB located on
$world_db[1]['dbPass']          = '';              // SQL server pass this DB located on
$world_db[1]['dbName']          = 'world';         // World Database name, by default "world"

               // position in array must represent realmd ID
$characters_db[1]['dbHost']     = '127.0.0.1:3306'; // SQL server IP:port this DB located on
$characters_db[1]['dbUser']     = 'root';           // SQL server login this DB located on
$characters_db[1]['dbPass']     = '';              // SQL server pass this DB located on
$characters_db[1]['dbName']     = 'characters';     // Character Database name


/* Sample Second Realm config
          // position in array must represent realmd ID
$world_db[2]['dbHost']          = '127.0.0.1:3306'; // SQL server IP:port this DB located on
$world_db[2]['dbUser']          = 'root';           // SQL server login this DB located on
$world_db[2]['dbPass']          = '';              // SQL server pass this DB located on
$world_db[2]['dbName']          = 'world';         // World Database name, by default "world"
               // position in array must represent realmd ID
$characters_db[2]['dbHost']     = '127.0.0.1:3306'; // SQL server IP:port this DB located on
$characters_db[2]['dbUser']     = 'root';           // SQL server login this DB located on
$characters_db[2]['dbPass']     = '';              // SQL server pass this DB located on
$characters_db[2]['dbName']     = 'characters';     // Character Database name
*/


//#############################################################################
//---- Game Server Configuration ----

        // position in array must represent realmd ID, same as in $world_db
$server[1]['addr']          = '127.0.0.1'; // Game Server IP, as seen by MiniManager, from your webhost
$server[1]['addr_wan']      = '127.0.0.1'; // Game Server IP, as seen by clients - Must be external address
$server[1]['game_port']     =  8085;       // Game Server port
$server[1]['soap_port']     =  7878;          // SOAP port - SOAP settins are needed for sending InGame Mail, etc.
$server[1]['soap_user']     = '';             // SOAP username
$server[1]['soap_pass']     = '';             // SOAP password
$server[1]['both_factions'] =  true;       // Allow to see opponent faction characters. Affects only players.
$server[1]['talent_rate']   =  1;          // Talent rate set for this server, needed for talent point calculation

/* Sample Second Realm config
        // position in array must represent realmd ID, same as in $world_db
$server[2]['addr']          = '127.0.0.1'; // Game Server IP, as seen by MiniManager, from your webhost
$server[2]['addr_wan']      = '127.0.0.1'; // Game Server IP, as seen by clients - Must be external address
$server[2]['game_port']     =  8085;       // Game Server port
$server[2]['soap_port']     =  7878;          // SOAP port - SOAP settins are needed for sending InGame Mail, etc.
$server[2]['soap_user']     = '';             // SOAP username
$server[2]['soap_pass']     = '';             // SOAP password
$server[2]['both_factions'] =  true;       // Allow to see opponent faction characters. Affects only players.
$server[2]['talent_rate']   =  1;          // Talent rate set for this server, needed for talent point calculation
*/


//#############################################################################
//---- Mail configuration ----

$admin_mail  = 'mail@mail.com';      // mail used for bug reports and other user contact
$mailer_type = 'smtp';               // type of mailer to be used("mail", "sendmail", "smtp")
$from_mail   = 'mail@mail.com';      // all emails will be sent from this email

//smtp server config
$smtp_cfg['host'] = 'smtp.mail.com'; // smtp server
$smtp_cfg['port'] = 25;              // port
$smtp_cfg['sec']  = "";				 // SMTP Security, "tls", "ssl" or "" possible
$smtp_cfg['user'] = '';              // username - use only if auth. required
$smtp_cfg['pass'] = '';              // pass


//#############################################################################
//---- IRC Options ------

$irc_cfg['server']  = 'foo.bar'; // irc server
$irc_cfg['port']    =  6667;            // port
$irc_cfg['channel'] = 'foo.bar';    // channel


//#############################################################################
//---- External Links ----

$tt_lang                    = 'www';// wowhead tooltip language. choices are 'fr', 'de', 'es', 'ru' (for 'en' use www)
$item_datasite              = 'http://'.$tt_lang.'.wowhead.com/?item=';
$quest_datasite             = 'http://'.$tt_lang.'.wowhead.com/?quest=';
$creature_datasite          = 'http://'.$tt_lang.'.wowhead.com/?npc=';
$spell_datasite             = 'http://'.$tt_lang.'.wowhead.com/?spell=';
$skill_datasite             = 'http://'.$tt_lang.'.wowhead.com/?spells=';
$go_datasite                = 'http://'.$tt_lang.'.wowhead.com/?object=';
$achievement_datasite       = 'http://'.$tt_lang.'.wowhead.com/?achievement=';
$talent_calculator_datasite = 'http://www.wowarmory.com/talent-calc.xml?cid=';

$get_icons_from_web         =  true;      // wherever to get icons from the web.
$item_icons                 = 'img/icons'; // and this is where it will save to and get from.


//#############################################################################
//---- New account creation Options ----

$disable_acc_creation  = false;     // true = Do not allow new accounts to be created
$expansion_select      = true;      // true = Shows option to select expansion or classic. (false = no option, WOTLK enabled by default)
$defaultoption         = 2;         // if the above is false then set what the default option will be (2 = WOTLK, 1 = TBC, 0 = Classic)
$enable_captcha        = false;     // false = no security image check (enable for protection against 'bot' registrations)
                                    // captcha needs php GD & FreeType Library support
$send_mail_on_creation = false;     // true = send mail at account creation.
$create_acc_locked     = 0;         // if set to '1' newly created accounts will be made locked to registered IP, disallowing user to login from other IPs.
$validate_mail_host    = false;     // actualy make sure the mail host provided in email is valid/accessible host.
$require_account_verify = false;    // If set to true, an email will be sent to registered email address requiring verification before account creation
$limit_acc_per_ip      = false;     // true = limit to one account per IP
$simple_register       = false;     // Sets the registration to a simple form. Name, Password, Expansion and Email.

// this option will limit account creation to users from selected net range(s).
// allow all => empty array
// e.g: "120-122.55.255-0.255-0"

$valid_ip_mask = array();
/* Sample config, you may have more then 1
$valid_ip_mask[0] = '255-0.255-0.255-0.255-0';
$valid_ip_mask[1] = '120-122.55.255-0.255-0';
$valid_ip_mask[2] = '190.50.33-16.255-0';
*/


//#############################################################################
//---- Login Options ----

$remember_me_checked  = false;      // "Remember Me" cookie check box default, false = unchecked

$allow_anony         =  true;       // allow anonymouse login, aka guest account
$anony_uname         = 'Guest';     // guest account name, this is purely cosmetic
$anony_realm_id      =  1;          // guest account default realm

// permission level for guest access is -1
// set it like how you set any page permission level in menu config below, using the value -1
// the "Guest" account exists only in MiniManager, not in your realms or server or database


//#############################################################################
//---- Layout configuration ----

$title               = 'MiniManager for TrinityCore';
$itemperpage         =  25;
$showcountryflag     =  true;

$themefolder         = 'Sulfur';    // file/folder name of theme to use from themes directory by default
$language            = 'english';   // default site language
$timezone            = 'UTC';       // default timezone (use your local timezone code) http://www.php.net/manual/en/timezones.php
$gm_online           = '1';         // display GM Characters in the Online Character List and Player Map (1 = enable, 0 = disable)
$gm_online_count     = '1';         // include GM Characters in the Online User Count and Player Map (1 = enable, 0 = disable)
$motd_display_poster = '1';         // display the poserter info in the MOTD (1 = enable, 0 = disable)


//#############################################################################
//---- Player Map configuration ----

// GM online options
$map_gm_show_online_only_gmoff     = 0; // show GM point only if in '.gm off' [1/0]
$map_gm_show_online_only_gmvisible = 0; // show GM point only if in '.gm visible on' [1/0]
$map_gm_add_suffix                 = 1; // add '{GM}' to name [1/0]
$map_status_gm_include_all         = 1; // include 'all GMs in game'/'who on map' [1/0]

// status window options:
$map_show_status =  1;                  // show server status window [1/0]
$map_show_time   =  1;                  // Show autoupdate timer 1 - on, 0 - off
$map_time        = 24;                  // Map autoupdate time (seconds), 0 - not update.

// all times set in msec (do not set time < 1500 for show), 0 to disable.
$map_time_to_show_uptime    = 3000;     // time to show uptime string
$map_time_to_show_maxonline = 3000;     // time to show max online
$map_time_to_show_gmonline  = 3000;     // time to show GM online


//#############################################################################
//---- Active Translations
// 0 = English/Default; 1 = Korean; 2 = French; 4 = German; 8 = Chinese; 16 = Taiwanese; 32 = Spanish; 64 = Mexican; 128 = Russian
// Prototype for search options
// Show only on language search option active translations entries (locales_XXX)
// Example (use flag values by adding the values) : Korean (1) + German (4) + Russian (64) = 69
// NOTE : Righ now only for Creature.php

$locales_search_option =  0;         // No search option, don't use locales_XXX for search
$site_encoding         = 'utf-8';    // used charset


//#############################################################################
//---- Backup configuration ----

$backup_dir = 'backup';    // make sure webserver have the permission to write/read it!


//#############################################################################
//---- Account Levels ----

$gm_level_arr = array
(
 -1 => array(-1,      'Guest',      '',''),
  0 => array( 0,     'Player',      '',''),
  1 => array( 1,  'Moderator',   'Mod',''),
  2 => array( 2, 'Gamemaster',    'GM',''), // change the name and alias as required
  3 => array( 3, 'BugTracker',    'BT',''),
  4 => array( 4,      'Admin', 'Admin',''),
  5 => array( 5,      'SysOp', 'SysOp',''),
  6 => array( 6,    'Unknown',   'UnK',''), // Add additional levels as required
);


//#############################################################################
// ---- Module and Security settings ----
// --   Meaning of the columns : TARGET, LANG_TEXT, ( READ/VIEW , INSERT , UPDATE , DELETE ) min Permission GM LEVEL
// --   Files excluded for this : Login.php, Pomm.php
// --   - Both files don't use header.php, so we can't include this method.. but its not a big deal
//
// --   - Updates will follow
// --
// --   Example: array("item.php", 'items',0,1,2,3),
// --    level 0 can only view and search,
// --    level 1 can add new items but cannot edit,
// --    level 2 can add and edit but cannot delete,
// --    level 3 has full access
//
// --   Example: array("item.php", 'items',1,0,3,2),
// --    this is tricky,
// --    level 0 would have no access
// --    level 1 can only search and browse
// --    level 2 can delete items, but cannot add or edit
// --    level 3 can add and edit, but cannot delete

$menu_array = array
(
  array
  (              'index.php',        'main', array
    (
      array(   'index.php?page=ahstats','auctionhouse', 0,5,5,5),
      array( 'index.php?page=arenateam', 'arena_teams', 0,5,5,5), // has own level security, but has yet to honor the new security system.
      array(     'index.php?page=guild',      'guilds', 1,5,5,5),
      array(     'index.php?page=honor',       'honor', 0,5,5,5),
      array(    'index.php?page=top100',      'top100', 0,5,5,5),
      array(     'index.php?page=forum',      'forums', 6,5,5,5), // has own level security, but has yet to honor the new security system.
      array(      'index.php?page=stat',  'statistics', 1,5,5,5),
      array('javascript:void(0);" onclick="window.open
              (\'./map/\', \'./map/\', \'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=no, resizable=no, copyhistory=1, width=966, height=732\')',
                               'player_map', 1,5,5,5), // this page has yet to honor the new security system, but it is a read only page
    ),
  ),
  array
  (                       '#',      'tools', array
    (
      array(       'index.php?page=user',   'accounts', 2,2,2,5),
      array(  'index.php?page=char_list', 'characters', 2,5,5,5),
      array(	  'index.php?page=cheat',       'cheat',2,0,0,0),
      array( 'index.php?page=ehrefarmer',  'ehrefarmer',2,0,0,0),
      array(    'index.php?page=command',    'command', 0,5,5,5),
      array(       'index.php?page=mail',       'mail', 3,5,5,5),
      array(    'index.php?page=mail_on',    'mail_on', 3,5,5,5),
      array(     'index.php?page=ticket',    'tickets', 2,2,2,2),
      array(     'index.php?page=banned','banned_list', 2,2,2,2),
      array(    'index.php?page=cleanup',    'cleanup', 5,5,5,5),
      array(        'index.php?page=irc',        'irc', 5,5,5,5),
      array(  'index.php?page=bugreport',  'bugreport', 6,5,5,5),
    ),
  ),
  array
  (                       '#',         'db', array
    (
      array(     'index.php?page=events',     'events', 0,5,5,5),
      array(  'index.php?page=instances',  'instances', 0,5,5,5),
      array(       'index.php?page=item',      'items', 2,3,3,5),
      array(   'index.php?page=creature',  'creatures', 2,3,3,5), // this page has yet to honor the new security system, please use with caution.
      array('index.php?page=game_object','game_object', 2,3,3,5), // this page has yet to honor the new security system, please use with caution.
      array(       'index.php?page=tele',  'teleports', 2,5,5,5),
      array(     'index.php?page=backup',     'backup', 5,5,5,5), // this page has yet to honor the new security system, please use with caution.
      array(  'index.php?page=run_patch',  'run_patch', 5,5,5,5),
      array(     'index.php?page=repair',     'repair', 3,5,5,5),
    ),
  ),
  array
  (                       '#',     'system', array
    (
      array(      'index.php?page=realm',      'realm', 2,5,5,5),
      array(       'index.php?page=motd',   'add_motd', 2,5,5,5),
      array(     'index.php?page=spelldisabled',     'spelld', 2,3,3,3),
      array(    'index.php?page=message',    'message', 3,5,5,5),
      array(        'index.php?page=ssh',   'ssh_line', 6,5,5,5),
    ),
  ),
  array
  (                        '#',  'invisible', array
    (
      array('javascript:void(0);" onclick="window.open(\'./forum.html\', \'forum\')', 'forums',6,0,0,0),
      array(        'index.php?page=char', 'character', 2,3,3,5),
      array(    'index.php?page=char_inv', 'character', 2,5,5,5),
      array(  'index.php?page=char_quest', 'character', 2,5,5,5),
      array('index.php?page=char_achieve', 'character', 2,5,5,5),
      array(  'index.php?page=char_skill', 'character', 2,5,5,5),
      array( 'index.php?page=char_talent', 'character', 2,5,5,5),
      array(    'index.php?page=char_rep', 'character', 2,5,5,5),
      array(   'index.php?page=char_pets', 'character', 2,5,5,5),
      array('index.php?page=char_friends', 'character', 2,5,5,5),
      array(  'index.php?page=char_extra', 'character', 2,5,5,5),
      array(  'index.php?page=char_spell', 'character', 2,5,5,5),
      array(  'index.php?page=char_mail', 'character', 2,5,5,5),
      array(   'index.php?page=char_edit', 'char_edit', 2,5,5,5),
      array(        'index.php?page=edit', 'myaccount', 0,5,5,5),
      array(       'index.php?page=index', 'startpage', -1,5,5,5),
      array(   'index.php?page=guildbank', 'guildbank', 0,5,5,5), // under development
      array(       'index.php?page=realm',     'realm', 0,5,5,5), // this last one is special, if this is not here, users are unable to switch realms
    ),                                                 // if READ is set to level 3, only level 3 and above can switch realms.
  ),                                                   // INSERT, UPDATE and DELETE should have no effect, but best to keep it at 5.
);


$debug = 0; // 0 - no debug, only fatal errors.
            // 1 - show total queries, mem usage, and only fatal errors.
            // 2 - show total queries, mem usage, and all errors.
            // 3 - show total queries, mem usage, all errors, and list of all global vars.
            // 4 - show total queries, mem usage, all errors, list of all global vars, and values of all global vars.


//#############################################################################
//---- Under Development ----
//
// These are either place holders for future stuff
// or stuff that are currently under development
// do not set or change any of these in here or in config.php
// unless you know what you are doing or were being told to do so
// no support are given to these 'features'

$developer_test_mode =  true;

$multi_realm_mode    =  true;

//---------------------Error reports for Debugging-----------------------------
if ($debug) 
    $tot_queries = 0;
if (1 < $debug)
    error_reporting (E_ALL);
else
    error_reporting (E_COMPILE_ERROR);
?>
