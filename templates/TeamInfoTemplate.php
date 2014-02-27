<?php

class TeamInfoTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'team';
    $this->keys[] = 'data';
  }
  public function render() {
  $d = $this->data['data'];
  ?>
  <div class="team-title">
    Team <?=$this->data['team']?> - <?=$d['name']?>
   </div>
   <div> <?=$d['matches_played']?> matches actually played, <?=$d['no_show']?> no-shows </div>
   <div class="auton box">
    <div>Autonomous</div>
    <div class="box">
      Normal (<?=$d['auto_normal']?>/<?=$d['matches_played']?>)
      <div clas="row">
        Hot/Cold/Miss
      </div>
      <div class="row">
        High Goal: (<?=$d['auto_high_hot']?>/<?=$d['auto_high_cold']?>/<?=$d['auto_high_miss']?>)
      </div>
      <div class="row">
        Low Goal: (<?=$d['auto_low_hot']?>/<?=$d['auto_low_cold']?>/<?=$d['auto_low_miss']?>)
      </div>
      <div class="row">
        Mobility: <?=$d['auto_mobility']?>/<?=$d['auto_normal']?>
      </div>
    </div>
    <div class="box">
      Goalie (<?=$d['auto_goalie']?>/<?=$d['matches_played']?>)
      <div class="row">
        Shot Blocks: <?=$d['auto_block']?> of <?=$d['auto_block_total']?>
      </div>
    </div>
   </div>
   <div class="teleop box">
    Teleop Offense
    <div class="row">
      
    </div>
   </div>
   <div class="defense box">
      Teleop Defense
      <div class="row">
        Defense Time: <?=$d['tele_defense_time']?>/3.0
      </div>
      <div class="row">
        Shots Blocked: <?=$d['tele_block']?>
      </div>
   </div>
  <?php }
}