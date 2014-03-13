<?php

class NoteEntryView extends PageView {
  public function renderBody() { 
    $template = new NoteEntryTemplate();
    $template->render();
   //echo var_dump($db->getTeamData($this->team));
  }
}