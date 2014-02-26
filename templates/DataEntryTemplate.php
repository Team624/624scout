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
        <label>Start Location<input type="text" class="num" id="auton-goalie-start"></label>
      </div>
      <div class="normal-auton form-row">
        <label>Start Location<input type="text" class="num" id="auton-normal-start"></label>
        <label>High Hot<input type="text" class="num" id="auton-high-hot"></label>
        <label>High Cold<input type="text" class="num" id="auton-high-cold"></label>
        <label>High Miss<input type="text" class="num" id="auton-high-miss"></label>
        <label>Low Hot<input type="text" class="num" id="auton-low-hot"></label>
        <label>Low Cold<input type="text" class="num" id="auton-low-cold"></label>
        <label>Low Miss<input type="text" class="num" id="auton-low-miss"></label>
        <label>Mobility Score<input type="checkbox" id="auton-mobility"></label>
      </div>
    </div>
    <script type="text/template" id="cycleTemplate">
      <div class="cycle-holder" data-cycle="{0}">
        <div class="cycle-num">{0}</div>
        <div class="cycle form-row">
          Get Ball
          <label>B<input type="checkbox" class="get-b"></label>
          <label>W<input type="checkbox" class="get-w"></label>
          <label>R<input type="checkbox" class="get-r"></label>
          Move
          <label>B<input type="checkbox" class="move-b"></label>
          <label>W<input type="checkbox" class="move-w"></label>
          <label>R<input type="checkbox" class="move-r"></label>
          
          <label>Truss<input type="checkbox" class="truss"></label>
          <label>Catch<input type="checkbox" class="catch"></label>
          <label>Miss Catch<input type="checkbox" class="catch-miss"></label>
          <label>HP Pass<input type="checkbox" class="human-pass"></label>
          <label>Score Low<input type="checkbox" class="score-low"></label>
          <label>Miss Low<input type="text" class="num miss-low"></label>
          <label>Score High<input type="checkbox" class="score-high"></label>
          <label>Miss High<input type="text" class="num miss-high"></label>
          <label>Possess Time<input type="text" class="num possess-time"></label>
        </div>
      </div>
    </script>
    <div class="red cycle-remove button" tabindex="0">-</div>
    <div class="cycle-add button" tabindex="0">+</div>
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
      <label>Goalie/Blocking<input type="text" class="num" id="blocking"></label>
      <label>Posessing/Assisting<input type="text" class="num" id="posessing"></label>
      <label>Truss Throwing<input type="text" class="num" id="trussing"></label>
      <label>Catching<input type="text" class="num" id="catching"></label>
      <label>Bad Things<input type="text" class="num" id="bad-things"></label>
    </div>
   </form>
   <div>
    <button class="big button" id="submit">Submit</div>
    <br />
    <button class="red button" id="update">Update</div>
   </div>
  <?php }
}