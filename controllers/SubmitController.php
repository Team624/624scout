<?php 

class SubmitController extends Controller {
  public function submit() {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
   // echo var_dump($obj);
    $db = new DatabaseModel();
    try {
      $db->submitMatch($obj);
      (new ErrorView(200, 'OK', 'match submitted :)'))->render();
    } catch (Exception $ex) {
       if(startsWith($ex->getMessage(), "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry ")) {
        $msg = 'Match already entered!';
       } else {
        $msg = $ex->getMessage();
      }
      (new ErrorView(500, 'Internal Server Error', $msg))->render();
    }
  }
  
  public function update() {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
   // echo var_dump($obj);
    $db = new DatabaseModel();
    try {
      $db->updateMatch($obj);
      (new ErrorView(200, 'OK', 'match updated :)'))->render();
    } catch (Exception $ex) {
       if(startsWith($ex->getMessage(), "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry ")) {
        $msg = 'Match already entered!';
       } else {
        $msg = $ex->getMessage();
      }
      (new ErrorView(500, 'Internal Server Error', $msg))->render();
    }
  }
}?>