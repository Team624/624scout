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
    <br>
    <a href="<?='/team_pics/' . $d['team_number'] . '.jpg' ?>" target="_blank">Robot Image Pic</a>
    <br>
  <?php } ?>
  <br>
  <div class="info-bar-holder">
	<div class="bar-group">
		<div class="info-bar" id="auto-bar">
		  <div class="left section">
        <div class="left info-content">
          <div class="info-title">Autonomous</div>
          <div class="row">
            High Goal: (<b><?=$d['auto_high_hot']?></b> Hot, <b><?=$d['auto_high_cold']?></b> Cold, <b><?=$d['auto_high_miss']?></b> Misses)
          </div>
          <div class="row">
            Low Goal: (<b><?=$d['auto_low_hot']?></b>  Hot,  <b><?=$d['auto_low_cold']?></b> Cold, <b><?=$d['auto_low_miss']?></b> Misses)
          </div>
          <div class="row">
            Mobility: <b><?=$d['auto_mobility']?></b>/ <b><?=$d['auto_normal']?></b> Matches
          </div>
          <br>
          Goalie (<?=$d['auto_goalie']?>/<?=$d['matches_played']?>)
          <div class="row">
            Shot Blocks: <?=$d['auto_block']?> of <?=$d['auto_block_total']?>
          </div>
        </div>
        <div class="grippy-circles" id="auto-gippies">
          <p>                              </p>
        </div>
		  </div>
		  <div class="right section">
			<div class="right info-content">
			  <div class="table-holder">
				<table class="matchByMatch">
				  <thead>
					<th>Matches</th>
					<?php foreach($d['matches'] as $m) { ?>
					  <th><?=$m['match_number']?></th>
					<?php } ?>
				  </thead>
				  <tr>
					<th class="vertical" >Start Pos.</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['no_show']>0){ ?>
						<td class = "bad-cell">Nshow</td>
					  <?php }
					  else if($m['auto_normal'] > 0){ ?>
						<td class = "<?=($m['auto_location']==2)?"minor-caution-cell":"normal-cell" ?>" ><?=$m['auto_location']?></td>
					  <?php } 
					  else { ?>
						<td>Goal<?=$m['auto_location']?></td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				  <tr>
					<th class="vertical" >High (Hot-Cold-Miss)</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['auto_high_hot']+$m['auto_high_cold']+$m['auto_high_miss']>0){ ?>
            <?php
              //make the colors for the auto high scoring cell
              $newCellClass = "normal-cell";
              if($m['auto_high_hot']+$m['auto_high_cold']>0)
                if($m['auto_high_miss']==0){
                  if($m['auto_high_hot']+$m['auto_high_cold']>=2)
                    if($m['auto_high_hot']+$m['auto_high_cold']>=3)
                      $newCellClass = "purple-cell";
                    else
                      $newCellClass = "blue-cell";
                  else
                    $newCellClass = "good-cell";
                  if($m['auto_high_cold'] == 0){
                    $newCellClass .= " hotGoal-cell";
                  }
                }
                else
                  $newCellClass = "caution-cell";
              else
                if($m['auto_high_miss']>0)
                  $newCellClass = "bad-cell";
              ///
            ?>
						<td class = "<?=$newCellClass ?>" ><?=$m['auto_high_hot']?>-<?=$m['auto_high_cold']?>-<?=$m['auto_high_miss']?></td>
					  <?php }
					  else{ ?>
						<td class="didNotDo">x</td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				  <tr>
					<th class="vertical" >Low (Hot-Cold-Miss)</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['auto_low_hot']+$m['auto_low_cold']+$m['auto_low_miss']>0){ ?>
              <?php
                //make the colors for the auto low scoring cell
                $newCellClass = "normal-cell";
                if($m['auto_low_hot']+$m['auto_low_cold']>0){
                  $newCellClass = "good-cell";
                }
                else
                  $newCellClass = "bad-cell";
                ///
              ?>
              <td class = "<?=$newCellClass ?>"><?=$m['auto_low_hot']?>-<?=$m['auto_low_cold']?>-<?=$m['auto_low_miss']?></td>
					  <?php }
					  else{ ?>
						<td class="didNotDo">x</td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				  <tr>
					<th class="vertical" >Mobility</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['auto_mobility']>0 && $m['auto_normal'] >0){ ?>
						<td><div class="icon-checkmark-2"></div></td>
					  <?php }
					  else if($m['auto_normal'] < 1){ ?>
						<td class="didNotDo"></td>
					  <?php } 
					  else { ?>
						<td class="didNotDo">X</td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				</table>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	<div class="bar-group">
    <?php if($d['shots_high']+$d['shots_low'] > 0) { ?>
      <div class="info-bar">
        <div class="left section">
          <div class="left info-content">
            <div class="info-title">Shooting</div>
            <div class="row">
            High Goal: <b><?=$d['tele_high_score']?></b> of <b><?=$d['shots_high']?></b> shots (<?=$d['high_accuracy']*100?>%)
            </div>
            <div class="row">
            Low Goal: <b><?=$d['tele_low_score']?></b> of <b><?=$d['shots_low']?></b> shots (<?=$d['low_accuracy']*100?>%)
            </div>
          </div>
          <div class="grippy-circles">
            <p>                              </p>
          </div>
        </div>
        <div class="right section">
        <div class="right info-content">
          <div class="table-holder">
          <table class="matchByMatch">
            <thead>
            <th>Matches</th>
            <?php foreach($d['matches'] as $m) { ?>
              <th><?=$m['match_number']?></th>
            <?php } ?>
            </thead>
            <tr>
            <th class="vertical" >High (makes/attmpts)</td>
            <?php foreach($d['matches'] as $m) { 
              if($m['tele_high_score']+$m['tele_high_miss']>0){ ?>
              <td><?=$m['tele_high_score']?>/<?=$m['tele_high_score']+$m['tele_high_miss']?></td>
              <?php }
              else{ ?>
              <td class="didNotDo">x</td>
              <?php } ?>
            <?php } ?>
            </tr>
            <tr>
            <th class="vertical" >Low (makes/attmpts)</td>
            <?php foreach($d['matches'] as $m) { 
              if($m['tele_low_score']+$m['tele_low_miss']>0){ ?>
              <td><?=$m['tele_low_score']?>/<?=$m['tele_low_score']+$m['tele_low_miss']?></td>
              <?php }
              else{ ?>
              <td class="didNotDo">x</td>
              <?php } ?>
            <?php } ?>
            </tr>
          </table>
          </div>
        </div>
        </div>
      </div>
    <?php }
    else { ?>
    <div class="no-stuff info-bar">
      <div class="info-title">No Shooting</div>
    </div>
    <?php } ?>
    
    <?php if($d['truss']+$d['truss_miss']+$d['catch']+$d['catch_miss'] > 0) { ?>
		<div class="info-bar">
		  <div class="left section">
        <div class="left info-content">
          <div class="info-title">Truss Ability</div>
          <div class="row">
          Get's over truss <b><?=$d['truss']?></b> of <b><?=$d['truss']+$d['truss_miss']?></b> attempts
          </div>
          <div class="row">
          To Human: Out of field or caught <b><?=$d['human_pass']?></b> of <b><?=$d['human_pass_attempts']?></b> attempts (<?=$d['human_pass_accuracy']*100?>%)
          </div>
          <div class="row">
          Catching: <b><?=$d['catch']?></b> of <b><?=$d['catch']+$d['catch_miss']?></b> attempts
          </div>
        </div>
        <div class="grippy-circles" id="auto-gippies">
          <p>                              </p>
        </div>
		  </div>

		  <div class="right section">
			<div class="right info-content">
			  <div class="table-holder">
				<table class="matchByMatch">
				  <thead>
					<th>Matches</th>
					<?php foreach($d['matches'] as $m) { ?>
					  <th><?=$m['match_number']?></th>
					<?php } ?>
				  </thead>
				  <tr>
					<th class="vertical" >Truss Throw</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['truss']+$m['truss_miss']>0){ ?>
						<td><?=$m['truss']?>/<?=$m['truss']+$m['truss_miss']?></td>
					  <?php }
					  else{ ?>
						<td class="didNotDo">x</td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				  <tr>
          <tr>
            <th class="vertical" >Human Success</td>
            <?php foreach($d['matches'] as $m) { 
              if($m['human_pass']+$m['human_pass_miss']>0){ ?>
              <td><?=$m['human_pass']?>/<?=$m['human_pass']+$m['human_pass_miss']?></td>
              <?php }
              else{ ?>
              <td class="didNotDo">x</td>
              <?php } ?>
            <?php } ?>
            </tr>
					<th class="vertical" >Catch</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['catch']+$m['catch_miss']>0){ ?>
						<td><?=$m['catch']?>/<?=$m['catch']+$m['catch_miss']?></td>
					  <?php }
					  else{ ?>
						<td class="didNotDo">x</td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				</table>
			  </div>
			</div>
		  </div>
		</div>
    <?php }
    else { ?>
    <div class="no-stuff info-bar">
      <div class="info-title">No Trussing</div>
    </div>
    <?php } ?>
	</div>
  
	<div class="bar-group">
    <?php if($d['robot_pass_attempts'] > 0) { ?>
		<div class="info-bar">
		  <div class="left section">
        <div class="left info-content">
          <div class="info-title">Passing</div>
          <div class="row">
            To Robot: <b><?=$d['robot_pass']?></b> of <b><?=$d['robot_pass_attempts']?></b> shots (<?=$d['robot_pass_accuracy']*100?>%)
          </div>
        </div>
        <div class="grippy-circles" id="auto-gippies">
          <p>                              </p>
        </div>
		  </div>
		  <div class="right section">
			<div class="right info-content">
			  <div class="table-holder">
          <table class="matchByMatch">
            <thead>
            <th>Matches</th>
            <?php foreach($d['matches'] as $m) { ?>
              <th><?=$m['match_number']?></th>
            <?php } ?>
            </thead>
            <tr>
            <th class="vertical" >To Robot</td>
            <?php foreach($d['matches'] as $m) { 
              if($m['robot_pass']+$m['robot_pass_miss'] > 0){ ?>
              <td><?=$m['robot_pass']?>/<?=$m['robot_pass']+$m['robot_pass_miss']?></td>
              <?php }
              else{ ?>
              <td class="didNotDo">x</td>
              <?php } ?>
            <?php } ?>
            </tr>
          </table>
			  </div>
			</div>
		  </div>
		</div>
    <?php }
    else { ?>
    <div class="no-stuff info-bar">
      <div class="info-title">Never Tried Passing to Bot</div>
    </div>
    <?php } 
    if($d['human_load_attempts'] + $d['floor_load_attempts'] > 0) { ?>
		<div class="info-bar">
		  <div class="left section">
        <div class="left info-content">
          <div class="info-title">Loading</div>
          <div class="row">
          Direct Human Load: <b><?=$d['human_load']?></b> of <b><?=$d['human_load_attempts']?></b> attempts (<?=$d['human_load_accuracy']*100?>%)
          </div>
          <div class="row">
          Floor Load: <b><?=$d['floor_load']?></b> of <b><?=$d['floor_load_attempts']?></b> attempts (<?=$d['floor_load_accuracy']*100?>%)
          </div>
        </div>
        <div class="grippy-circles" id="auto-gippies">
          <p>                              </p>
        </div>
		  </div>
		  <div class="right section">
			<div class="right info-content">
			  <div class="table-holder">
				<table class="matchByMatch">
				  <thead>
					<th>Matches</th>
					<?php foreach($d['matches'] as $m) { ?>
					  <th><?=$m['match_number']?></th>
					<?php } ?>
				  </thead>
				  <tr>
					<th class="vertical" >Direct Human</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['human_load']+$m['human_load_miss']>0){ ?>
						<td><?=$m['human_load']?>/<?=$m['human_load']+$m['human_load_miss']?></td>
					  <?php }
					  else{ ?>
						<td class="didNotDo">x</td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				  <tr>
					<th class="vertical" >Floor Pickup</td>
					<?php foreach($d['matches'] as $m) { 
					  if($m['floor_load']+$m['floor_load_miss']>0){ ?>
						<td><?=$m['floor_load']?>/<?=$m['floor_load']+$m['floor_load_miss']?></td>
					  <?php }
					  else{ ?>
						<td class="didNotDo">x</td>
					  <?php } ?>
					<?php } ?>
				  </tr>
				</table>
			  </div>
			</div>
		  </div>
		</div>
    <?php }
    else { ?>
    <div class="no-stuff info-bar">
      <div class="info-title">Never Tried Loading</div>
    </div>
    <?php } ?>
		<div class="info-bar">
		  <div class="left section">
        <div class="left info-content">
          <div class="info-title">Possession</div>
          <div class="row">
          Other Possessions: <b><?=$d['other_possess']?></b>
          </div>
          <div class="row">
          Dropped Balls: <b><?=$d['dropped_balls']?></b>
          </div>
        </div>
        <div class="grippy-circles" id="auto-gippies">
          <p>                              </p>
        </div>
		  </div>
		  <div class="right section">
			<div class="right info-content">
			  <div class="table-holder">
				<table class="matchByMatch">
				  <thead>
					<th>Matches</th>
					<?php foreach($d['matches'] as $m) { ?>
					  <th><?=$m['match_number']?></th>
					<?php } ?>
				  </thead>
				  <tr>
					<th class="vertical" >Other Possessions</td>
					<?php foreach($d['matches'] as $m) { ?> 
						<td><?=$m['other_possess']?></td>
					<?php } ?>
				  </tr>
				  <tr>
            <th class="vertical" >Dropped Balls</td>
            <?php foreach($d['matches'] as $m) { ?> 
              <td><?=$m['dropped_balls']?></td>
             <?php } ?>
				  </tr>
				</table>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	<div class="bar-group">
		<div class="info-bar">
		  <div class="left section">
        <div class="left info-content">
          <div class="info-title">Defense and Ratings</div>
          <div class="row">
          Defense Rating: <b><?=$d['defense_rating']?></b>
          </div>
          <div class="row">
          Balls Blocked: <b><?=$d['tele_block']?></b>
          </div>
          <div class="row">
          Driving Rating: <b><?=$d['driving_rating']?></b>
          </div>
          <div class="row">
          Pushing Rainting: <b><?=$d['pushing_rating']?></b>
          </div>
        </div>
        <div class="grippy-circles" id="auto-gippies">
          <p>                              </p>
        </div>
		  </div>
		  <div class="right section">
        <div class="right info-content">
          <div class="table-holder">
          <table class="matchByMatch">
            <thead>
            <th>Matches</th>
            <?php foreach($d['matches'] as $m) { ?>
              <th><?=$m['match_number']?></th>
            <?php } ?>
            </thead>
            <tr>
              <th class="vertical" >Time Defending</td>
              <?php foreach($d['matches'] as $m) { ?>
                <td>
                   <?php switch($m['tele_defense_time']){ 
                    case 0: ?>
                      0%
                      <?php break;
                    case 1: ?>
                      <25%
                      <?php break;
                    case 2: ?>
                      ~50%
                      <?php break;
                    case 3: ?>
                      >75%
                    <?php break; ?>
                <?php } ?>
                </td>
              <?php } ?>
            </tr>
            <tr>
              <th class="vertical" >Defense Rating</td>
                <?php foreach($d['matches'] as $m) { 
                   if($m['defense_rating']>0){ ?>
                    <td><?=$m['defense_rating']?></td>
                    <?php }
                    else{ ?>
                    <td class="">N/A</td>
                    <?php } ?>
                  <?php } ?>
              </tr>
            <tr>
            <tr>
              <th class="vertical" >Balls Blocked</td>
                <?php foreach($d['matches'] as $m) { ?> 
                  <td><?=$m['tele_block']?></td>
                <?php } ?>
              </tr>
            <tr>
            <tr>
              <th class="vertical" >Driving</td>
                <?php foreach($d['matches'] as $m) { 
                   if($m['driving_rating']>0){ ?>
                    <td><?=$m['driving_rating']?></td>
                    <?php }
                    else{ ?>
                    <td class="">N/A</td>
                    <?php } ?>
                  <?php } ?>
              </tr>
            <tr>
            <tr>
              <th class="vertical" >Pushing</td>
                <?php foreach($d['matches'] as $m) { 
                   if($m['pushing_rating']>0){ ?>
                    <td><?=$m['pushing_rating']?></td>
                    <?php }
                    else{ ?>
                    <td class="">N/A</td>
                    <?php } ?>
                  <?php } ?>
              </tr>
            <tr>
          </table>
          </div>
        </div>
		  </div>
		</div>
	</div>
	<div class="bar-group">
    <?php if($d['tipped'] + $d['broke_down'] + $d['tipped'] + $d['lost_comms'] + $d['fouls'] + $d['tech_fouls'] > 0) { ?>
		<div class="info-bar">
		  <div class="left section">
        <div class="left info-content">
          <div class="info-title">Bad Things</div>
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
        <div class="grippy-circles" id="auto-gippies">
          <p>                              </p>
        </div>
		  </div>
		  <div class="right section">
			<div class="right info-content">
			  <div class="table-holder">
				<table class="matchByMatch">
				  <thead>
					<th>Matches</th>
					<?php foreach($d['matches'] as $m) { ?>
					  <th><?=$m['match_number']?></th>
					<?php } ?>
				  </thead>
				  <tr>
            <th class="vertical" >Tipped</td>
            <?php foreach($d['matches'] as $m) { ?> 
              <td><?=$m['tipped']?></td>
             <?php } ?>
				  </tr>
          <tr>
            <th class="vertical" >Mech. Failure</td>
            <?php foreach($d['matches'] as $m) { ?> 
              <td><?=$m['broke_down']?></td>
             <?php } ?>
				  </tr>
          <tr>
            <th class="vertical" >Lost Com</td>
            <?php foreach($d['matches'] as $m) { ?> 
              <td><?=$m['lost_comms']?></td>
             <?php } ?>
				  </tr>
          <tr>
            <th class="vertical" >Fouls(normal/tech)</td>
            <?php foreach($d['matches'] as $m) { ?> 
              <td><?=$m['fouls']?> / <?=$m['tech_fouls']?></td>
             <?php } ?>
				  </tr>
				</table>
			  </div>
			</div>
		  </div>
		</div>
    <?php }
    else { ?>
    <div class="good-info no-stuff info-bar">
      <div class="info-title">No Bad Things</div>
    </div>
    <?php } ?>
	  </div>
	</div>
  <!--<div class="sec-title">Autonomous</div>
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
  <div class="sec-title">Teleop</div>
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
 <div class="sec-title"> Notes </div>
 <hr>
   <div class="box">
    <?php foreach($d['notes'] as $note) { ?>
        <?php if (isset($note['match_number'])) { ?>
          <?= $note['match_number']?>:
        <?php } ?>
        <div class="note box"><?= $note['text'] ?></div>
    <?php } ?>
   </div>
 <br>
<br>
   <div class="sec-title"> Raw Data </div>
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