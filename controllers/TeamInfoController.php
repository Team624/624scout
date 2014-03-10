<?php 

class TeamInfoController extends Controller {
  public function display() {
    $theTeam = "";
    if(isset($_GET['team'])){$theTeam = $_GET['team'];}
    (new TeamInfoDisplayView($theTeam))->render();
  }
  
  public function getInfo() {
    (new TeamInfoView($_GET['team']))->render();
  }
}?>