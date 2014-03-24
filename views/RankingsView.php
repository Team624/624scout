<?php

class RankingsView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $fms = new FmsModel();
    $schedule = $db->getSchedule();
    $teams = $db->getAllTeamData();
    $results = $fms->getResults();
  //  echo var_dump($results);
    //echo var_dump($schedule);
    $predictor = new Predictor();
    $lastCorrect = 0;
    for($i=0; $i<1000; $i++) {
      $predictor->mutate();
      $predSched = $predictor->predictSchedule($schedule, $teams);
      echo '<br />';
       $correct = $predictor->checkAccuracy($predSched, $results);
      echo 'correct: ' . $correct;
      if($correct <= $lastCorrect) $predictor->unmutate();
      echo '<br />';
      $lastCorrect = $correct;
    }
    
    $template = new RankingsTemplate();
    $template->render();
  }
}