<?php

class SetupTemplate extends Template {

  public function __construct() {
  }
  public function render() {
  ?>
  Setup Page (Don't touch)
  <div>
    Event Code: 
    <input id="event-code" type="text" value="TXSA"></input>
  </div>
  </br />
  <div>
    <div class="button" id="load-schedule">Load Schedule from FMS</div>
  </div>
  <?php }
}