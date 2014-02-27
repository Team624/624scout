<?php

class ScoutListView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new ScoutListTemplate();
    $template->set('scouts', $db->getScouts());
    $template->render();  
  }
}