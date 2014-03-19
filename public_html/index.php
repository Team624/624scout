<?php
$PROFILE = false;

if($PROFILE) xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

ini_set('default_charset', 'utf-8');


$startTime = microtime(true);


$fileRoot = $_SERVER['DOCUMENT_ROOT'] . '/../';

function autoload($class) {
  $fileRoot = $GLOBALS['fileRoot'];
  
  if (strstr($class, 'Template') === 'Template') {
    $includeFolder = '/templates/';
  } else if (strstr($class, 'View') === 'View') {
    $includeFolder = '/views/';
  } else if (strstr($class, 'Model') === 'Model') {
    $includeFolder = '/models/';
  } else if (strstr($class, 'Controller') === 'Controller') {
    $includeFolder = '/controllers/';
  } else {
    $includeFolder = '/classes/';
  }
  
  if(file_exists($fileRoot . $includeFolder . $class . '.php')) {
    include ($fileRoot . $includeFolder . $class . '.php'); 
  }
}

spl_autoload_register('autoload');



$config = new Configuration($fileRoot . 'config.ini');

//Session::setup();
session_start();  
//assignControlers();

$controller = isset ($_GET['controller']) ? $_GET['controller'] : 'page';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$specialKey = "";
$specialKey = isset($_GET['uid']) ? $_GET['uid'] = "excelPro" : "";
$isSpecial = $controller == "page" && $action == 'rawData' && $specialKey == "excelPro";
if(isset($_SESSION['valid']) || $controller == "loginer" || $isSpecial){
  
}
else{
  if(isset($_COOKIE["youReal"])){
    switch($_COOKIE["youReal"]){
      case Session::$scoutCookieCode:
        $_SESSION['valid'] = TRUE;
        $_SESSION['entry'] = FALSE;
        $_SESSION['setup'] = FALSE;
        break;
      case Session::$entererCookieCode:
        $_SESSION['valid'] = TRUE;
        $_SESSION['entry'] = TRUE;
        $_SESSION['setup'] = TRUE;
        break;
    }
  }
  else{
    $controller = "page";
    $action = "testMe";
  }
}

function h($s) {
  return htmlspecialchars($s);
}

switch ($controller) {
  case 'page':
   (new StaticPageController($action))->executeAction();
    break;
  case 'submit':
    (new SubmitController($action))->executeAction();
    break;
  case 'setup':
    (new SetupController($action))->executeAction();
    break;
  case 'teamInfo':
    (new TeamInfoController($action))->executeAction();
    break;
  case 'matchInfo':
    (new MatchInfoController($action))->executeAction();
    break;
  case 'loginer':
    (new LoginerController($action))->executeAction();
    break;
  case 'notes':
    (new NotesController($action))->executeAction();
    break;
  case 'rankings':
    (new RankingsController($action))->executeAction();
    break;
  default: 
    header('HTTP/1.1 404 Not Found');
    echo '404';
}

$length = microtime(true) - $startTime;
//echo '<!-- ' . $length * 1000 . ' ms -->';


if($PROFILE) {
  $xhprof_data = xhprof_disable();

  $XHPROF_ROOT = "/opt";
  include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
  include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

  $xhprof_runs = new XHProfRuns_Default();
  $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");

 echo "<!-- http://old.team624.org/index.php?run={$run_id}&source=xhprof_testing -->\n";
}


