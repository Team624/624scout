<?php

class MatchInfoDisplayView extends PageView {
  protected $match;
  public function __construct($match) {
    $this->match = $match;
  }
  public function renderBody() {   
    $db = new DatabaseModel();
    $template = new MatchInfoDisplayTemplate();
    if ($this->match !== null) {
      $template->set('match', $this->match);
    }
    $template->render();
  }
}