<?php

class ScheduleView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new ScheduleTemplate();
    $fms = new FmsModel();
    $lastPlayed = $fms->getRankings()['lastPlayed'];
    $template->set('schedule', $db->getSchedule());
    $template->set('lastPlayed', $lastPlayed);
    $template->render();  
  }
}