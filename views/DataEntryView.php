<?php

class DataEntryView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $teams = $db->getTeams();
    $schedule = $db->getSchedule();
    $scouts = $db->getScouts();
    $template = new DataEntryTemplate();
    $template->set('teams', $teams);
    $template->set('schedule', $schedule);
    $template->set('scouts', $scouts);
    $template->render();  
  }
}