<?

//
// Very raw sessionmanagement - will require some more thought
//

function session_defaults() {
  $_SESSION['uid'] = 0;
  $_SESSION['logged'] = false;
  $_SESSION['cookie'] = 0;
  $_SESSION['username'] = '';
  $_SESSION['remember'] = false;
}

class usersession {
  var $failed = false;     // failed login attempt
  var $date;        // current date GMT
  var $id = 0;        // the current user's id

  function user() {
    $this->date = $GLOBALS['date'];
    if ($_SESSION['logged']) {
      $this->_checkSession();
    elseif (isset($_COOKIE['tcwebLogin']))
      $this->_checkRemembered($_COOKIE['tcwebLogin']);
    }
  } 

  function _checkLogin($username, $password, $remember) {
    $
    $result = $rdb->fetch("SELECT username FROM member WHERE username = %s AND password = %s", $username, $password);
    if (is_object($result)) {
      $this->_setSession($result, $remember);
      return true;
    } else {
      $this->failed = true;
      $this->_logout();
      return false;
    }
  } 

  function _setSession(&$values, $remember, $init = true) {
    $this->id = $values->id;
    $_SESSION['uid'] = $this->id;
    $_SESSION['username'] = htmlspecialchars($values->username);
    $_SESSION['cookie'] = $values->cookie;
    $_SESSION['logged'] = true;
    if ($remember)
      $this->updateCookie($values->cookie, true);
    if ($init) {
      $session = session_id();
      $ip = $_SERVER['REMOTE_ADDR'];
      # $mdb->action("UPDATE member SET session = %s, ip = %s WHERE id = %s", $session, $ip, $this->id);
    }
  } 

  function updateCookie($cookie, $save) {
    $_SESSION['cookie'] = $cookie;
    if ($save) {
      $cookie = serialize(array($_SESSION['username'], $cookie) );
      set_cookie('tcwebLogin', $cookie, time() + 2419200, '/');
    }
  }

  function _checkRemembered($cookie) {
    list($username, $cookie) = @unserialize($cookie);
    if (!$username or !$cookie)
      return;
    # $result = $mdb->fetch("SELECT username FROM member WHERE username = %s AND cookie = %s", $username, $cookie);
    if (is_object($result) ) {
      $this->_setSession($result, true);
    }
  } 

  function _checkSession() {
    $username = $_SESSION['username'];
    $cookie = $_SESSION['cookie'];
    $session = session_id();
    $ip = $_SERVER['REMOTE_ADDR'];

    $result = $mdb->fetch("SELECT username FROM member WHERE username = %s AND cookie = %s AND session = %s AND ip = %s", $username, $cookie, $session, $ip);
    if (is_object($result) ) {
      $this->_setSession($result, false, false);
    } else {
      $this->_logout();
    }
  } 
}

?>