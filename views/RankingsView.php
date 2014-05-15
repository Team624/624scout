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
    $ourAssist = 0;
    foreach($rankings['rankings'] as &$rank) { //break up alternating QS values and find 624's assist
      if($rank['QS'] !== $lastQS) {
       $odd = !$odd;
      }
      $lastQS = $rank['QS'];
      $rank['oddQS'] = $odd;
      
      if($rank['team'] == 624) $ourAssist = $rank['assist'];
    }
    $maxPlayed = 0;
    foreach($rankings['rankings'] as &$rank) { //find the highest num of matches played
      if($rank['played'] > $maxPlayed) {
        $maxPlayed = $rank['played'];
      }
    }
    foreach($rankings['rankings'] as &$rank) { //find teams that have played fewer than max matches
      if($rank['played'] < $maxPlayed) {
        $rank['lessThanMax'] = true;
      } else {
        $rank['lessThanMax'] = false;
      }
    }
    $template = new RankingsTemplate();
    $template->set('rankings', $rankings['rankings']);
    $template->set('lastPlayed', $rankings['lastPlayed']);
    $template->set('624assist', $ourAssist);
    $template->render();
  }
}