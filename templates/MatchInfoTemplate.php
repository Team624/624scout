<?php

class MatchInfoTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'match';
    $this->keys[] = 'data';
  }
  public function render() {
  $d = $this->data['data'];
  ?>
  <div class="team-title">
    Match <?=$this->data['match']?>
  </div>
  <?php }
}