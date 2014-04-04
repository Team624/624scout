<?php

class ImageSetupView extends PageView {
  public function renderBody() {
   $template = new ImageSetupTemplate();
   $template->render();
  }
}