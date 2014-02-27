<?php

class TeamListView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new TeamListTemplate();
    $template->set('teams', $db->getTeams());
    $template->render();  
  }
}