<?php 

class ImageController extends Controller {
  public function display() {
    (new ImageSetupView())->render();
  }
  
  public function getInfo() {

  }
}?>