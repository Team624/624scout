<?php

class MatchInfoDisplayView extends PageView {
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new MatchInfoDisplayTemplate();
    $template->render();
  }
}