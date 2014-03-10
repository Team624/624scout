<?php

class TeamInfoView implements View {
  public $team;
  public function __construct($team) {
    $this->team = $team;
  }
  public function render() { 
    
    $db = new DatabaseModel();
    $template = new TeamInfoTemplate();
    $template->set('team', $this->team);
    $template->set('data', $db->getTeamData($this->team));
    $template->render();
   // echo var_dump($db->getTeamData($this->team));
  }
}