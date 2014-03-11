<?php

class RawDataView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new RawDataTemplate();
    $template->set('match_data', $db->getRawMatchData());
    //$template->set('cycles', $db->getRawCycleData());
    $template->render();
  }
}