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
  <div> <b><?=$d['matches_played']?></b> matches actually played, <b><?=$d['no_show']?></b> no-shows </div>
  <div class="auton box">
      <div>Autonomous</div>
      <div class="box">
        Normal (<?=$d['auto_normal']?>/<?=$d['matches_played']?>)
        <div class="row" style="float:right;">
          Hot/Cold/Miss
        </div>
        <div class="row">
          High Goal: (<b><?=$d['auto_high_hot']?></b>/<b><?=$d['auto_high_cold']?></b>/<b><?=$d['auto_high_miss']?></b>)
        </div>
        <div class="row">
          Low Goal: (<b><?=$d['auto_low_hot']?></b>/<b><?=$d['auto_low_cold']?></b>/<b><?=$d['auto_low_miss']?></b>)
        </div>
        <div class="row">
          Mobility: <b><?=$d['auto_mobility']?></b>/<b><?=$d['auto_normal']?></b>
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
    High Goal: <b><?=$d['tele_high_score']?></b> of <b><?=$d['shots_high']?></b> shots
    </div>
    <div class="row">
    Low Goal: <b><?=$d['tele_low_score']?></b> of <b><?=$d['shots_low']?></b> shots
    </div>
    <div class="row">
    Truss Throw: <b><?=$d['truss']?></b>/match
    </div>
    <div class="row">
    Catching: <b><?=$d['catch']?></b> of <b><?=$d['matchAvg_catch_miss']?></b> attempts
    </div>
   </div>
  </div>
  <?php }
}