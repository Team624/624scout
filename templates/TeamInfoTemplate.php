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
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/team_pics/' . $d['team_number'] . '.jpg')) { ?>
    <a href="<?='/team_pics/' . $d['team_number'] . '.jpg' ?>">Image</a>
  <?php } ?>
  <br>
  <div class = "info-bar-holder">
	<div class = "info-bar">
		<div class = "left section">
			<div class = "info-title">Autonomous</div>
			<div class="row">
			  High Goal: (<b><?=$d['auto_high_hot']?></b> Hot, <b><?=$d['auto_high_cold']?></b> Cold, <b><?=$d['auto_high_miss']?></b> Misses)
			</div>
			<div class="row">
			  Low Goal: (<b><?=$d['auto_low_hot']?></b>  Hot,  <b><?=$d['auto_low_cold']?></b> Cold, <b><?=$d['auto_low_miss']?></b> Misses)
			</div>
			<div class="row">
			  Mobility: <b><?=$d['auto_mobility']?></b>/ <b><?=$d['auto_normal']?></b> Matches
			</div>
		</div>
		<div class = "right section">
			<div class="table-holder">
				<table>
					<thead>
						<th>Matches</th>
						<?php foreach($d['matches'] as $m) { ?>
							<th><?=$m['match_number']?></th>
						<?php } ?>
					</thead>
					<tr>
						<td>High Goals</td>
						<td>2</td>
						<td>1</td>
						<td>2</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
  </div>
  <!--<div class = "sec-title">Autonomous</div>
  <hr>
  <div class="box">
    Start in White Zone: <b><?=$d['auto_normal']?></b> / <b><?=$d['matches_played']?></b> matches
    <div class="row" style="float:right;">
    </div>
    <div class="row">
      High Goal: (<b><?=$d['auto_high_hot']?></b> Hot, <b><?=$d['auto_high_cold']?></b> Cold, <b><?=$d['auto_high_miss']?></b> Misses)
    </div>
    <div class="row">
      Low Goal: (<b><?=$d['auto_low_hot']?></b>  Hot,  <b><?=$d['auto_low_cold']?></b> Cold, <b><?=$d['auto_low_miss']?></b> Misses)
    </div>
    <div class="row">
      Mobility: <b><?=$d['auto_mobility']?></b>/ <b><?=$d['auto_normal']?></b> Matches
    </div>
  </div>
  <div class="box">
    Goalie (<?=$d['auto_goalie']?>/<?=$d['matches_played']?>)
    <div class="row">
      Shot Blocks: <?=$d['auto_block']?> of <?=$d['auto_block_total']?>
    </div>
  </div>
  <br>
  <br>
  <div class = "sec-title">Teleop</div>
  <hr>
  <div class="box">
    Shooting
    <div class="row">
    High Goal: <b><?=$d['tele_high_score']?></b> of <b><?=$d['shots_high']?></b> shots (<?=$d['high_accuracy']*100?>%)
    </div>
   </div>
   
   <div> Raw Data </div>
    <div class="row">
    Low Goal: <b><?=$d['tele_low_score']?></b> of <b><?=$d['shots_low']?></b> shots (<?=$d['low_accuracy']*100?>%)
    </div> 
  </div>
   <div class="box">
    Truss Ability
    <div class="row">
    Truss Throw: <b><?=$d['truss']?></b> of <b><?=$d['truss']+$d['truss_miss']?></b> attempts
    </div>
    <div class="row">
    Catching: <b><?=$d['catch']?></b> of <b><?=$d['catch']+$d['catch_miss']?></b> attempts
    </div>
  </div>
  <hr>
  <div class="box">
    Passing
    <div class="row">
    To Human: <b><?=$d['human_pass']?></b> of <b><?=$d['human_pass_attempts']?></b> attempts (<?=$d['human_pass_accuracy']*100?>%)
    </div>
    <div class="row">
    To Robot: <b><?=$d['robot_pass']?></b> of <b><?=$d['robot_pass_attempts']?></b> shots (<?=$d['robot_pass_accuracy']*100?>%)
    </div>
  </div>
  <div class="box">
    Loading
    <div class="row">
    Direct Human Load: <b><?=$d['human_load']?></b> of <b><?=$d['human_load_attempts']?></b> attempts (<?=$d['human_load_accuracy']*100?>%)
    </div>
    <div class="row">
    Floor Load: <b><?=$d['floor_load']?></b> of <b><?=$d['floor_load_attempts']?></b> attempts (<?=$d['floor_load_accuracy']*100?>%)
    </div>
  </div>
  <div class="box">
    Possesion
    <div class="row">
    Other Possessions: <b><?=$d['other_possess']?></b>
    </div>
    <div class="row">
    Dropped Balls: <b><?=$d['dropped_balls']?></b>
    </div>
  </div>
  <hr>
  <div class="box">
    Ratings
    <div class="row">
    Driving: <b><?=$d['driving_rating']?></b>
    </div>
    <div class="row">
    Pushing: <b><?=$d['pushing_rating']?></b>
    </div>
    <div class="row">
    Defense: <b><?=$d['defense_rating']?></b>
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
 </div>-->
 <div class = "sec-title"> Notes </div>
 <hr>
   <div class="box">
    <?php foreach($d['notes'] as $note) { ?>
        <?php if (isset($note['match_number'])) { ?>
          Q<?= $note['match_number']?>:
        <?php } ?>
        <div class="note box"><?= $note['text'] ?></div>
    <?php } ?>
   </div>

 <br>
<br>
   <div class = "sec-title"> Raw Data </div>
    <hr>
   <div class="table-holder">
    <table class="raw-table">
      <tr>
        <?php foreach ($d as $key => $val) { 
          if($key !== 'matches' && $key !== 'name' && $key !=='notes') {
        ?>
          <th><p><?= $key?></p></th>
        <?php }} ?>
      </tr>
      <tr>
        <?php foreach ($d as $key=>$val) {
          if($key !== 'matches' && $key !== 'name' && $key !=='notes') {
         ?>
          <td><div><?= $val===null?'--':$val ?></div></td>
        <?php }} ?>
      </tr>
    </table>
   </div>
   <div> Match Breakdown </div>
   <div class="table-holder">
    <?php foreach($d['matches'] as $m) { ?>
      <div> Match <?=$m['match_number']?></div>
      <table class="raw-table">
        <tr>
          <?php foreach ($m as $key => $val) { 
            if($key !== 'matches') {
          ?>
            <th><p><?= $key?></p></th>
          <?php }} ?>
        </tr>
        <tr>
          <?php foreach ($m as $key=>$val) {
            if($key !== 'matches') {
           ?>
            <td><div <?=$key==='scout_name'?'class="name"':'a'?>><?= $val===null?'--':$val ?></div></td>
          <?php }} ?>
        </tr>
      </table>
    <?php } ?>
   </div>
  </div>
  <?php }
}