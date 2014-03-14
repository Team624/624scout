<?php

class DataEntryTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'teams';
    $this->keys[] = 'schedule';
    $this->keys[] = 'scouts';
  }
  public function render() {
  ?>
  <div>
   Data Entry Form
   <script>
   window.teams = JSON.parse('<?=json_encode($this->data['teams'], JSON_HEX_APOS)?>');
   window.schedule = JSON.parse('<?=json_encode($this->data['schedule'], JSON_HEX_APOS)?>');
   window.scouts = JSON.parse('<?=json_encode($this->data['scouts'], JSON_HEX_APOS)?>');
   </script>
  </div>
   <form id="entry-form">
    <div class="form-row">
      <label>Match<input type="text" class="num" id="match"></label>
      <label>Team<input type="text" class="num" id="team"></label>
      <label>Scout ID<input type="text" class="num" id="scout"></label>
            <div id="scout-display">
      </div>
      <table class="schedule-preview">
        <tr>
          <th class="r">Red 1</th>
          <th class="r">Red 2</th>
          <th class="r">Red 3</th>
          <th class="b">Blue 1</th>
          <th class="b">Blue 2</th>
          <th class="b">Blue 3</th>
        </tr>
        <tr>
          <td id="r1p"></td>
          <td id="r2p"></td>
          <td id="r3p"></td>
          <td id="b1p"></td>
          <td id="b2p"></td>
          <td id="b3p"></td>
        </tr>
      </table>
    </div>

    <div class="form-row">
      <label><input type="radio" name="start" id="normal-auton">Normal Auton</label>
      <label><input type="radio" name="start" id="goalie">Goalie</label>
      <label><input type="radio" name="start" id="no-show">No Show</label>
      <div class="goalie-auton form-row" style="display:none;">
        <label>Shots Blocked<input type="text" class="num" id="auton-shots-blocked"></label>
        <label>Shots Not Blocked<input type="text" class="num" id="auton-shots-not-blocked"></label>
          <label>Start Location (just the #)<input type="text" class="num" id="auton-goalie-start"></label>
     </div>
      <div class="normal-auton form-row">
        <label>Start Location (just the #)<input type="text" class="num" id="auton-normal-start"></label>
         <label>Mobility Score<input type="checkbox" id="auton-mobility"></label>
        <label>High Hot<input type="text" class="num" id="auton-high-hot"></label>
        <label>High Cold<input type="text" class="num" id="auton-high-cold"></label>
        <label>High Miss<input type="text" class="num" id="auton-high-miss"></label>
        <label>Low Hot<input type="text" class="num" id="auton-low-hot"></label>
        <label>Low Cold<input type="text" class="num" id="auton-low-cold"></label>
        <label>Low Miss<input type="text" class="num" id="auton-low-miss"></label>
      </div>
    </div>
    <div class="scoring form-row">
      <label>High Score<input type="text" class="num" id="high-score"></label>
      <label>High Miss<input type="text" class="num" id="high-miss"></label>
      <label>Low Score<input type="text" class="num" id="low-score"></label>
      <label>Low Miss<input type="text" class="num" id="low-miss"></label>
    </div>
    <div class="truss form-row">
      <label>Truss<input type="text" class="num" id="truss"></label>
      <label>Truss Miss<input type="text" class="num" id="truss-miss"></label>
      <label>Catch<input type="text" class="num" id="catch"></label>
      <label>Catch Miss<input type="text" class="num" id="catch-miss"></label>
    </div>
    <div class="pass form-row">
      <label>Human Pass<input type="text" class="num" id="human-pass"></label>
      <label>Human Pass Miss<input type="text" class="num" id="human-pass-miss"></label>
      <label>Robot Pass<input type="text" class="num" id="robot-pass"></label>
      <label>Robot Pass Miss<input type="text" class="num" id="robot-pass-miss"></label>
    </div>
    <div class="possess form-row">
      <label>Other Poss.<input type="text" class="num" id="other-possessions"></label>
      <label>Dropped Ball<input type="text" class="num" id="dropped-ball"></label>
    </div>  
    <div class="load form-row">
      <label>Human Load<input type="text" class="num" id="human-load"></label>
      <label>Human Load Miss<input type="text" class="num" id="human-load-miss"></label>
      <label>Floor Load<input type="text" class="num" id="floor-load"></label>
      <label>Floor Load Miss<input type="text" class="num" id="floor-load-miss"></label>
    </div>
    <div class="defense form-row">
      <span class="checkbox-container">
        <label><input type="radio" name="defense" id="defense-none">None</label>
        <label><input type="radio" name="defense" id="defense-25">&lt;25%</label>
        <label><input type="radio" name="defense" id="defense-50">~50%</label>
        <label><input type="radio" name="defense" id="defense-75">&gt;75%</label>
      </span>
      <label>Balls Blocked<input type="text" class="num" id="balls-blocked"></label>
    </div>
    <div class="bad-things form-row">
      <label>Tipped<input type="checkbox" id="tipped"></label>
      <label>Lost Comms<input type="checkbox" id="lost-comms"></label>
      <label>Broke Down<input type="checkbox" id="broke-down"></label>
      <label>Fouls<input type="text" class="num" id="fouls"></label>
      <label>Tech Fouls<input type="text" class="num" id="tech-fouls"></label>
    </div>
    <div class="ratings form-row">
      <label>Driving/Maneuverability<input type="text" class="num" id="driving"></label>
      <label>Pushing<input type="text" class="num" id="pushing"></label>
      <label>Defense<input type="text" class="num" id="defense"></label>
    </div>
    Notes:<textarea id="entry-notes"></textarea>
   </form>
   <div>
    <button class="big button" id="submit">Submit</div>
    <br />
    <button class="red button" id="update">Update</div>
   </div>
  <?php }
}