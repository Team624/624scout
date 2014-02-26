<?php 

class TeamInfoController extends Controller {
  public function display() {
    (new TeamInfoDisplayView())->render();
  }
  
  public function getInfo() {
    (new TeamInfoView($_GET['team']))->render();
  }
}?>