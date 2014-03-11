<?php

class TeamInfoDisplayTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'team';
  }
  public function render() {
  ?>
  <div>
   
   <label> Team: <input id="searchTeam" class="num" type="text" value="<?=($this->data['team'] == 0) ? "" : $this->data['team']?>"></input></label>
   <div id="searchTeamBut" class="button" tabindex="0">Search</div>
   <div id="teamDisplay">
   
   </div>
   </div>
  <?php }
}