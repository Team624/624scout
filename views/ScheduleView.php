<?php

class ScheduleView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new ScheduleTemplate();
    $template->set('schedule', $db->getSchedule());
    $template->render();  
  }
}