<?php

class TeamInfoTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'team';
  }
  public function render() {
  $d = $this->data;
  ?>
  <div>
    Team <?=$d['team']?>
   </div>
  <?php }
}