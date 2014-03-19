<?php 

class RankingsController extends Controller {
  public function display() {
    (new RankingsView())->render();
  }
  
  public function getInfo() {

  }
}?>