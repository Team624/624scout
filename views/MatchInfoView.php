<?php

class MatchInfoView implements View {
  public $match;
  public function __construct($match) {
    $this->match = $match;
  }
  public function render() { 
    
    $db = new DatabaseModel();
    $template = new MatchInfoTemplate();
    $template->set('match', $this->match);
    try {
      $template->set('data', $db->getMatchData($this->match));
    } catch ($ex) {
      die ($ex->getMessage());
    }
    $template->render();
   //echo var_dump($db->getTeamData($this->team));
  }
}