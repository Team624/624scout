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
    $template->render();
  }
}