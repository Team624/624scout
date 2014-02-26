<?php
class Session {
  protected static $user;
  protected static $isLoggedIn;
  public static function setup() {
    session_start();    
    if(isset($_SESSION['user'])) {
      $model = new UserDatabaseModel();
      self::$user = $model->getFromId($_SESSION['user']);
      self::$isLoggedIn = true;
    } else {
      self::$isLoggedIn = false;
    }
  }
  
  public static function getLoggedInUser () {
    if(self::isLoggedIn()) {
      return self::$user;
    } else return false;
  }
  
  public static function isLoggedIn() {
    return self::$isLoggedIn;
  }
  
  public static function logOut() {
    self::$user = null;
    self::$isLoggedIn = false;
    unset ($_SESSION['user']);
  }
  
  public static function logIn($user) {
    if($GLOBALS['config']->get('login_log')) {
      $filename = $GLOBALS['config']->get('login_logfile');
      file_put_contents($filename, "\r\n[" . date("D M j G:i:s T Y") . '] LOGIN -- ' . $user->username . ' from [' . $_SERVER['REMOTE_ADDR'] . "]", FILE_APPEND);
    }
    self::$user = $user;
    self::$isLoggedIn = true;
    $_SESSION['user'] = $user->id;
  }
}