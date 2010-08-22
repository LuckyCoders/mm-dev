<?php
/**
 * File: $Id: mysql.lib.php, v0.7 2010/08/01 22:30 click Exp $
 * DB-Layer: MySQL extension - class abstracts and handlers
 *
 * @copyright (C) 2006-2010 VCon Systems Norway
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://www.vcon.no   
 * @author Phillip Johnsen <phillip.johnsen@vcon.no>
 * @author Per Andre Wilhelmsen <per.wilhelmsen@vcon.no> 
 *
 */

  require_once('db.lib.php');

/*
 * MySQL toolkit with the most common used MySQL functions
 */

class MySQL extends DB {

  /*
   * Constructor
   *
   * Calls the connect function
   */

  public function __construct($dbArr) {
      $this->connect($dbArr['dbUser'], $dbArr['dbPass'], $dbArr['dbName'], $dbArr['dbHost']);
  }

  // Connect to our db!
  public function connect($dbUser, $dbPass, $dbName, $dbHost) {
    if ($res = mysql_connect($dbHost, $dbUser, $dbPass, true)) {
      mysql_select_db($dbName, $res);
      
      // connection check
      if (mysql_errno($res) > 0)
          throw new Exception(mysql_error($res));
                
      $this->setLinkResource($res);
      parent::$connections++;
      return TRUE;
    }
    return FALSE;
  }

  // Disconnect from the db!
  public function disconnect() {
    if ($this->connected()) {
      mysql_close($this->getLinkResource());
      parent::$connections--;
      return TRUE;
    }
    return FALSE;
  }

  /*
   * Send query to DB server
   *
   * @param: (string) query
   * @return: (array of objects) result set
   */
  public function fetch($query) {
    // not connected or no parameters given?!
    if (!$this->connected()) {
      return FALSE;
    }

    // optional printf arguments to insert into query?
    $args = func_get_args();
    array_shift($args); // remove query from these arguments..

    // format our query
    $query = $this->formatQuery($query, $args);

    // send this damn query away!
    $link =& $this->getLinkResource();
    $result = mysql_query($query, $link);
    $this->setLastResult($result);

    // everything ok so far?
    if (mysql_errno($link) > 0)
        throw new Exception(mysql_error($link));
        
    // add all fetched rows into this array of ours
    $resultSet = array();
    if (is_resource($result)) {
        while ($row = mysql_fetch_object($result)) {
          $resultSet[] = $row;
        }
    }
    return (count($resultSet)) ? $resultSet : NULL;
  }

  /*
   * Send an action query to DB server (UPDATE, DELETE ..)
   *
   * @param: (string) query
   * @return: (int) number of rows affected by this action
   */

  public function action($query) {
    // not connected or no parameters given?!
    if (!$this->connected()) {
      return FALSE;
    }

    // optional printf arguments to insert into query?
    $args = func_get_args();
    array_shift($args); // remove query from these arguments..

    // format our query
    $query = $this->formatQuery($query, $args);

    // send this damn query away!
    $link =& $this->getLinkResource();
    $result = mysql_query($query, $link);
    $this->setLastResult($result);

    return $this->affected_rows();
  }

  /*
   * Returns the number of rows from a query
   *
   * @param: (optional result resource) result, if not sent the last result resource found is used
   */
  public function num_rows($result = NULL) {
    if (is_resource($result)) {
      return (int)mysql_num_rows($result);
    } else {
      return (int)mysql_num_rows($this->getLastResult());
    }
  }

  /*
   * Returns the number of fields fetched from a query
   *
   * @param: (optional result resource) result, if not sent the last result resource found is used
   */
  public function num_fields($result = NULL) {
    // not connected ffs!
    if (!$this->connected()) {
      return FALSE;
    }

    // what result to use?
    if (!is_resource($result)) {
      $result =& $this->getLastResult();
    }

    return (int)mysql_num_fields($result);
  }

  /*
   * Get the number of affected rows by the last INSERT, UPDATE, REPLACE or DELETE
   *
   * @param: void
   */
  public function affected_rows() {
    $link =& $this->getLinkResource(); // fetch link res

    return ($this->connected()) ? mysql_affected_rows($link) : FALSE;
  }

  /*
   * Get the ID designated to the last row inserted
   *
   * @param: void
   */
  public function insert_id() {
    $link =& $this->getLinkResource(); // fetch link res

    return ($this->connected()) ? mysql_insert_id($link) : FALSE;
  }

  /*
   * Escape given string to make it db friendly
   *
   * @param: (string) string to escape
   */
  protected function escapeString($string) {
    return (get_magic_quotes_gpc()) ? $string : mysql_escape_string($string);
  }

  /*
   * Escape given binary data to make it db friendly
   *
   * @param: (binary) binary to escape
   */
  protected function escapeBinary($bin) {
    $link =& $this->getLinkResource();
    return (get_magic_quotes_gpc()) ? mysql_real_escape_string(stripslashes($bin), $link) : mysql_real_escape_string($bin, $link);
  }
}

?>