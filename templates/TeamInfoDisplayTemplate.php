<?php

class TeamInfoDisplayTemplate extends Template {

  public function __construct() {
  }
  public function render() {
  ?>
  <div>
   <label> Team: <input id="searchTeam" class="num" type="text"></label>
   <div id="searchTeamBut" class="button" tabindex="0">Stalk</div>
   <div id="teamDisplay">
   
   </div>
   </div>
  <?php }
}