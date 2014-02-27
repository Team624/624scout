<?php

class DataCoverageView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new DataCoverageTemplate();
    $template->set('schedule', $db->getSchedule());
    $template->render();  
  }
}