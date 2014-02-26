<?php 
class SetupController extends Controller {
  public function display() {
    (new SetupView())->render();
  }
  
  public function loadSchedule() {
    $eventCode = $_POST['eventCode'];
    
    $html = @file_get_contents("http://www2.usfirst.org/2013comp/Events/$eventCode/matchresults.html");
    if ($html === false) {
      (new ErrorView(422, 'Unprocessable Entity', 'Match Data page loaded not goodly'))->render();
    } else {
      $doc = new DOMDocument();
      @$doc->loadHTML($html);
     $rows = $doc->getElementsByTagName('table')->item(2)->getElementsByTagName('tr');
     $rowNum = 0;
     $schedule = [];
     foreach($rows as $row) {
      if($rowNum >= 3) {
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
        $msg = 'Key violation. Is the team list set? Is the match data cleared?';
      (new ErrorView(500, 'Internal Server Error', $msg))->render();
     }
    }  
  }
}
//Third table


?>