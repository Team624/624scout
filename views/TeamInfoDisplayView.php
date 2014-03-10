<?php

class TeamInfoDisplayView extends PageView {
  public $team;
  public function __construct($team) {
    $this->team = $team;
  }
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new TeamInfoDisplayTemplate();
    $template->set('team', $this->team);
    $template->render();
  }
}