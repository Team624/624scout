<?php

class RankingsView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $fms = new FmsModel();
    $schedule = $db->getSchedule();
    $teams = $db->getTeams();
    $results = $fms->getResults();
    
    
    $predictor = new Predictor();
    for($i=0; $i<1000; $i++) {
      echo $predictor->calcPS($team);
      $predictor->mutate();
      echo '<br />';
    }
    
    $template = new RankingsTemplate();
    $template->render();
  }
}