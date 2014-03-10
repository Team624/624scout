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
    //$template->set('data', $db->getTeamData($this->match));
    $template->render();
   // echo var_dump($db->getTeamData($this->team));
  }
}