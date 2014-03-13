<?php 

class NotesController extends Controller {
  public function submit() {
    $obj = [];
    $obj['team'] = $_POST['team'];
    $obj['text'] = $_POST['text'];
    /*error_log(var_dump($obj),3,"c:/wamp/logs/php_error.log");*/
   // echo var_dump($obj);
    $db = new DatabaseModel();
    try {
      $db->submitNote($obj);
      (new ErrorView(200, 'OK', 'match submitted :)'))->render();
    } catch (Exception $ex) {
        $msg = $ex->getMessage();
      (new ErrorView(500, 'Internal Server Error', $msg))->render();
    }
  }
}?>