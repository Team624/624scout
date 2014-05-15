<?php

class IndexTemplate extends Template {

  public function __construct() {
    $this->keys[]='';
  }
  public function render() { ?>
   <p>CRyptonite Scouting - <span class = "championSwag">Championship Edition</span></p>
   <!--<a href="http://www2.usfirst.org/2014comp/Events/FLOR/rankings.html"> Orlando Standings </a>-->
  <?php }
}