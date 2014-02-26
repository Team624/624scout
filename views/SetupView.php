<?php

class SetupView extends PageView {
  public function renderBody() {   
    $template = new SetupTemplate();
    $template->render();  
  }
}