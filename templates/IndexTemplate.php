<?php

class IndexTemplate extends Template {

  public function __construct() {
    $this->keys[]='';
  }
  public function render() { ?>
   <p>CRyptonite Scouting - Orlando Edition</p>
   <a href="http://www2.usfirst.org/2014comp/Events/FLOR/rankings.html"> Orlando Standings </a>
  <?php }
}