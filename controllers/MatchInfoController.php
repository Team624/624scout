<?php 

class MatchInfoController extends Controller {
  public function display() {
    $match = null;
    if(isset($_GET['match'])) $match = $_GET['match'];
    (new MatchInfoDisplayView($match))->render();
  }
  
  public function getInfo() {
    $match = null;
    if(isset($_GET['match'])) $match = $_GET['match'];
    (new MatchInfoView($match))->render();
  }
}?>