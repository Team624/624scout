<?php

class TestMeTemplate extends Template {

  public function __construct() {
    $this->keys[]='';
  }
  public function render() { ?>
   
  <div class = "validatorHolder">
   <p class = "dbWelcome">CRyptonite Robotics - Team 624</p>
   <p>Scouting Database</p>
   <hr>
   <label>Password: <input type="password" class="text" id="password"></label>
   <span><button class="entry button" id="submitPW">Submit</div></span>
  </div>
  
  <?php }
}