<?php 

class MatchInfoController extends Controller {
  public function display() {
    (new MatchInfoDisplayView())->render();
  }
  
  public function getInfo() {
    (new MatchInfoView($_GET['match']))->render();
  }
}?>