<?php 

class LoginerController extends Controller {
  public function login() {
    $pw = file_get_contents('php://input');

    if($pw=="crscout624"){
      $_SESSION['valid'] = TRUE;
      $_SESSION['entry'] = FALSE;
      $_SESSION['setup'] = FALSE;
      
      setcookie("youReal", Session::$scoutCookieCode, time()+259200);
      (new ErrorView(200, 'OK', 'Login'))->render();
    }
    else if($pw=="pro624scout"){
      $_SESSION['valid'] = TRUE;
      $_SESSION['entry'] = TRUE;
      $_SESSION['setup'] = TRUE;
	  
      setcookie("youReal", Session::$entererCookieCode, time()+259200);
      (new ErrorView(200, 'OK', 'Login'))->render();
    }
    else{
      (new ErrorView(500, 'Error', "Incorrect Password"))->render();
    }
  }
  
}?>