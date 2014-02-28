<?php

class IndexTemplate extends Template {

  public function __construct() {
    $this->keys[]='';
  }
  public function render() { ?>
   <a href="http://www2.usfirst.org/2014comp/Events/TXSA/rankings.html"> Alamo Regional Standings </a>

  <?php }
}