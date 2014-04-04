<?php

class SetupTemplate extends Template {

  public function __construct() {
  }
  public function render() {
  ?>
  Setup Page (Don't touch)
  <div>
    Event Code: 
    <input id="event-code" type="text" value="TXHO"></input>
  </div>
  <br />
    <div>
   <div class="button" id="load-teams">Load Team List from TBA</div>
  </div>
    <br />
  <div>
    <div class="button" id="load-schedule">Load Schedule from FMS</div>
  </div>
    <br />
    <br />
    
  <div>
    <div class="red button" id="obliterate-dialog-show">Obliterate all data</div>
  </div>
  
  <div id="obliterate-dialog">
    <div><label>Obliteration Password:<input id="oblit-pass" class="long num" type="password"></label></div>
    <div><div class="red button" id="obliterate">OBLITERATE</div></div>
  </div>
  <?php }
}