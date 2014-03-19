<?php

class RankingsView extends PageView {
  public function renderBody() {   
    $fms = new FmsModel();
    $results = $fms->getResults();
    
    $template = new RankingsTemplate();
    $template->render();
  }
}