<?php
/**
 * File: $Id: db.lib.php, v0.7 2010/08/01 22:30 click Exp $
 * DB-Layer: Main class abstracts and handlers
 *
 * @copyright (C) 2006-2010 VCon Systems Norway
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://www.vcon.no
 * @author Phillip Johnsen <phillip.johnsen@vcon.no>
 * @author Per Andre Wilhelmsen <per.wilhelmsen@vcon.no>
 *
 */
 
/*
 * Abstract parent for database classes
 */

abstract class DB {
  protected $link = null;
  protected $lastResult = null;
  protected static $connections; // how many db connections do we have?
  private $tablePrefix = '';
  private $tableSuffix = '';
  private $queryArgs = null; // stores replacment args for queries

  // Disconnect from DB when destroying object
  public function __destruct() {
    $this->disconnect();
  }

  //
  // CONNECTION INFO
  //
  // Have we connected to a database?
 
  public function connected() {
    return is_resource($this->link);
  }
  // How many connections are active?
  public function connectionsCount() {
    return ($this->connections > 0) ? $this->connections : 0;
  }

  //
  // TABLE PREFIX / SUFFIX
  //
 
  public function setTablePrefix($prefix) {
    $this->tablePrefix = $prefix;
  }
  public function getTablePrefix() {
    return $this->tablePrefix;
  }

  public function setTableSuffix($suffix) {
    $this->tableSuffix = $suffix;
  }
  public function getTableSuffix() {
    return $this->tableSuffix;
  }

  /*
   * Format query, modifying table names
   *
   * @param: (string) query
   * @param: (array of strings) values to insert into query in printf form
   * @param: (string) formatted query
   */
 
  protected function formatQuery($query, $args = NULL) {
    // table prefix/suffix first
    $prefix = $this->getTablePrefix();
    $suffix = $this->getTableSuffix();
    $query = preg_replace('/({)(.*)(})/', $prefix ."$2". $suffix, $query);

    // then to the printf values replacement
    if (is_array($args)) {
      $this->queryArgs = $args;
      $query = preg_replace_callback('(%s|%d|%f|%b)', array($this, '_db_preg_callback'), $query);
    }

    return $query;
  }

  /*
   * Callback function for replacement of query values
   */

  private function _db_preg_callback($match) {
    // no more args to replace with?
    if (!is_array($this->queryArgs) || !count($this->queryArgs)) {
      return '';
    }

    // replace this value then..
    switch ($match[0]) {
      case '%d':
        return (int)array_shift($this->queryArgs);
        break;
      case '%f':
        return (float)array_shift($this->queryArgs);
        break;
      case '%s':
        return $this->escapeString(array_shift($this->queryArgs));
        break;
      case '%b':
        return $this->escapeBinary(array_shift($this->queryArgs));
        break;
    }
  }

  //
  // FUNCTIONS USUABLE FOR OUR CHILDREN ONLY
  //
  // Set link resource to our db connection

  protected function setLinkResource(&$inLink) {
    if (is_resource($inLink)) {
      $this->link = $inLink;
      return true;
    }

    return false;
  }
  protected function &getLinkResource() {
    return $this->link;
  }

  // Result resource to the last result generated
  protected function setLastResult(&$inResult) {
    if (is_resource($inResult)) {
      $this->lastResult = $inResult;
      return true;
    }

    return false;
  }

  protected function &getLastResult() {
    return $this->lastResult;
  }

  // Abstract functions that we require our children to create
  abstract protected function connect($dbUser, $dbPass, $dbName, $dbHost);
  abstract protected function disconnect();

  abstract protected function fetch($query);
  abstract protected function action($query);
  abstract protected function escapeString($string);
  abstract protected function escapeBinary($bin);
}

?>