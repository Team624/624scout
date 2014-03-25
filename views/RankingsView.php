<?php

class RankingsView extends PageView {
 /* public function renderBody() {   
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
      if($correct < $lastCorrect) { 
        $predictor->unmutate();
      } else {
            $lastCorrect = $correct;
      }
      echo '<br />';

    }
    
    $template = new RankingsTemplate();
    $template->render();
  }*/
  public function renderBody() {
    $fms = new FmsModel();
    $rankings = $fms->getRankings();
    $lastQS = 0;
    $odd = false;
    foreach($rankings as &$rank) {
      if($rank['QS'] !== $lastQS) {
       $odd = !$odd;
      }
      $lastQS = $rank['QS'];
      $rank['oddQS'] = $odd;
    }
    $maxPlayed = 0;
    foreach($rankings as &$rank) {
      if($rank['played'] > $maxPlayed) {
        $maxPlayed = $rank['played'];
      }
    }
    foreach($rankings as &$rank) {
      if($rank['played'] < $maxPlayed) {
        $rank['lessThanMax'] = true;
      } else {
        $rank['lessThanMax'] = false;
      }
    }
    $template = new RankingsTemplate();
    $template->set('rankings', $rankings);
    $template->render();
  }
}