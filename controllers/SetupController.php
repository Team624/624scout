<?php 
class SetupController extends Controller {
  public function display() {
    (new SetupView())->render();
  }
  public function loadTeams() {
    $eventCode = strtolower($_POST['eventCode']); 
    $opts = [
      'http'=>[
      'method'=>"GET",
      'header'=>'X-TBA-App-Id: frc624:scouting-system:v2014lonestar'
      ]
    ];
    $context = stream_context_create($opts);
    $html = @file_get_contents("http://www.thebluealliance.com/api/v2/event/2014$eventCode/teams", false, $context);
    if ($html === false) {
      (new ErrorView(422, 'Unprocessable Entity', 'Error connecting to TBA API'))->render();
      return;
    }
    $teamList = json_decode($html, true);
    $teams = [];
    foreach($teamList as $teamData) {
      $teams[$teamData['team_number']] = $teamData['nickname'];
    }
    try {
       $db = new DatabaseModel();
       $db->setTeamList($teams);
       (new ErrorView(200, 'OK'))->render();
     } catch (Exception $ex) {
    (new ErrorView(500, 'Internal Server Error', 'Database refuses to accept our perfectly good team list with ' . count($teams) . ' teams.'))->render();
    }
  }
  public function loadSchedule() {
    $eventCode = $_POST['eventCode'];
    
    $html = @file_get_contents("http://www2.usfirst.org/2014comp/Events/$eventCode/schedulequal.html");
    if ($html === false) {
      (new ErrorView(422, 'Unprocessable Entity', 'Match Data page loaded not goodly'))->render();
      return;
    } else {
      $doc = new DOMDocument();
      @$doc->loadHTML($html);
     $rows = $doc->getElementsByTagName('table')->item(2)->getElementsByTagName('tr');
     $rowNum = 0;
     $schedule = [];
     foreach($rows as $row) {
      if($rowNum >= 2) {
        $schedRow = [];
        $cols = $row->getElementsByTagName('td');
        $schedRow['time'] = $cols->item(0)->nodeValue;
        $schedRow['match_number'] = $cols->item(1)->nodeValue;
        $schedRow['red_1'] = $cols->item(2)->nodeValue;
        $schedRow['red_2'] = $cols->item(3)->nodeValue;
        $schedRow['red_3'] = $cols->item(4)->nodeValue;
        $schedRow['blue_1'] = $cols->item(5)->nodeValue;
        $schedRow['blue_2'] = $cols->item(6)->nodeValue;
        $schedRow['blue_3'] = $cols->item(7)->nodeValue;
        $schedule[] = $schedRow;
      }
      $rowNum++;
     }
     try {
       $db = new DatabaseModel();
       $db->setSchedule($schedule);
       (new ErrorView(200, 'OK'))->render();
     } catch (Exception $ex) {
      $msg = $ex->getMessage();
      if (startsWith($msg, 'SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails'))
        $msg = 'Key violation. Is the match data cleared?';
      if(startsWith($msg, 'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails'))
        $msg = 'Unable to update child db rows. Is the team list set??';
      (new ErrorView(500, 'Internal Server Error', $msg))->render();
     }
    }  
  }
  
  public function obliterate() {
    $pass = $_POST['password'];
    try {
      $db = new DatabaseModel();
      if($db->obliterate($pass)) {
        (new ErrorView(200, 'OK'))->render();
      } else {
        (new ErrorView(422, 'Unprocessable Entity', 'Incorrect password'))->render();
      }
    } catch (Exception $ex) {
      $msg = $ex->getMessage();
      (new ErrorView(500, 'Internal Server Error', $msg))->render();
    }
  }
 
}
//Third table


?>