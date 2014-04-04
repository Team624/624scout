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
    Match <?=$this->data['match']?> - <span class="matchTime"><?=$d['time']?></span>
  </div>
  <br>
  <!--<?php
      $i = 0;
      foreach($d['teamDatas'] as $t => $td){
      $i++;
      $trClass = ($i<=3) ?  "redAlliance" : "blueAlliance";
      ?>
      <?= $i=4 ? '<br>' : '' ?>
        <div class="box">
          <div class="row"><a href = <?=("/?controller=teamInfo&action=display&team=" . $t)?>><?=$t?></a></div>
          <div class="row"><?=$td['name']?></div>
        </div>
      <?php } ?>-->
  
  <div class="table-holder">
    <table class="match-info-table">
      <thead>
        <tr>
          <th rowspan = "2">Team #</th>
          <th rowspan = "2">Name</th>
          <th rowspan = "2">Matches</th>
          <th rowspan = "1" colspan = "3">Auto</th>
          <th rowspan = "1" colspan = "2">TeleShooting</th>
          <th rowspan = "2" colspan = "1">Truss</th>
          <th rowspan = "2" colspan = "1">Foul /Tech</th>
          <th rowspan = "2" colspan = "1">Defense Rating</th>
          <th rowspan = "2" colspan = "1">Rbt Passes</th>
          <th rowspan = "1" colspan = "2">Loading</th>
        </tr>
        <tr>
          <th>Mob</th>
          <th>High</th>
          <th>Low</th>
          <th>High</th>
          <th>Low</th>
          <th>Direct HP</th>
          <th>Floor</th>
        </tr>
      </thead>
      <?php
      $i = 0;
      foreach($d['teamDatas'] as $t => $td){
      $i++;
      $trClass = ($i<=3) ?  "redAlliance" : "blueAlliance";
      ?>
        <tr class = <?=$trClass?>>
          <td class="teamCell"><a href = <?=("/?controller=teamInfo&action=display&team=" . $t)?>><?=$t?></a></td>
          <td><?=$td['name']?></td>
          <td><?=$td['matches_played']?></td>
          <td><?=$td['auto_mobility']?></td>
          <td><?=($td['auto_high_hot']+$td['auto_high_cold'])?></td>
          <td><?=($td['auto_low_hot']+$td['auto_low_cold'])?></td>
          <td><?=$td['tele_high_score']?>/<?=$td['shots_high']?></td>
          <td><?=$td['tele_low_score']?>/<?=$td['shots_low']?></td>
          <td><?=$td['truss']?> / <?=($td['truss']+$td['truss_miss'])?></td>
          <td><?=$td['fouls']?> / <?=($td['tech_fouls'])?></td>
          <td><?=$td['defense_rating']?></td>
          <td><?=$td['robot_pass']?> / <?=($td['robot_pass_attempts'])?></td>
          <td><?=$td['human_load']?> / <?=($td['human_load_attempts'])?></td>
          <td><?=$td['floor_load']?> / <?=($td['floor_load']+$td['floor_load_miss'])?></td>
        </tr>
      <?php } ?>
    </table>
    
   </div>
  </div>
  <?php }
}