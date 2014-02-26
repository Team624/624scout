<?php

class IndexView extends PageView {
  public function renderBody() {   
    $template = new IndexTemplate();
    $template->render();  
  }
}