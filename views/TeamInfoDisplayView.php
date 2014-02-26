<?php

class TeamInfoDisplayView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new TeamInfoDisplayTemplate();
    $template->render();
  }
}