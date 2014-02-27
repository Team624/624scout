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
    Possessions: <b><?=$d['possessions']?></b> of <b><?=$d['cycles']?></b> cycles
    </div>
    <div class="row">
    High Goal: <b><?=$d['score_high']?></b> of <b><?=$d['shots_high']?></b> shots
    </div>
    <div class="row">
    Low Goal: <b><?=$d['score_low']?></b> of <b><?=$d['shots_low']?></b> shots
    </div>
    <div class="row">
    Truss Throw: <b><?=$d['truss']?></b>/match (<b><?=$d['truss_percent']?></b>% of cycles)
    </div>
    <div class="row">
    Catching: <b><?=$d['catch']?></b> of <b><?=$d['catch_total']?></b> attempts
    </div>
   </div>
   <div class="defense box">
      Teleop Defense
      <div class="row">
        Defense Time: <b><?=$d['tele_defense_time']?></b>/3.0
      </div>
      <div class="row">
        Shots Blocked: <b><?=$d['tele_block']?></b>
      </div>
   </div>
   <div class="bad box">
    Bad Things
      <div clas="row">
        Tipped: <b><?=$d['tipped']?></b> of <?=$d['matches_played']?> matches
      </div>
      <div clas="row">
        Mech. Failure: <b><?=$d['broke_down']?></b> of <?=$d['matches_played']?> matches
      </div>
      <div clas="row">
        Lost Comms: <b><?=$d['lost_comms']?></b> of <?=$d['matches_played']?> matches
      </div>
      <div class="row">
        <b><?=$d['fouls']?></b> fouls &amp; <b><?=$d['tech_fouls']?></b> tech fouls (<b><?=$d['foul_points']?></b> pts)
      </div>
   </div>
   <div class="subjective box">
    Subjective Ratings
      <div clas="row">
        Driving/Maneuverability: <b><?=$d['driving_rating']?></b>
      </div>
      <div clas="row">
        Pushing: <b><?=$d['pushing_rating']?></b>
      </div>
      <div clas="row">
        Defense: <b><?=$d['defense_rating']?></b>
      </div>
      <div clas="row">
        Goalie/Blocking: <b><?=$d['blocking_rating']?></b>
      </div>
      <div clas="row">
        Ball Control/Passing: <b><?=$d['control_rating']?></b>
      </div>
      <div clas="row">
        Floor Pickup: <b><?=$d['pickup_rating']?></b>
      </div>
      <div clas="row">
        Truss Throwing: <b><?=$d['truss_rating']?></b>
      </div>
      <div clas="row">
        Truss Catching: <b><?=$d['catch_rating']?></b>
      </div>
      <div clas="row">
        Badness: <b><?=$d['badness_rating']?></b>
      </div>
   </div>
  <?php }
}