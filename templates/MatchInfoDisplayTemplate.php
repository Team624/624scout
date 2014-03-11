<?php

class MatchInfoDisplayTemplate extends Template {

  public function __construct() {
  }
  public function render() {
  ?>
  <div>
   <label> Match: <input id="searchMatch" class="num" type="text"></label>
   <div id="searchMatchBut" class="button" tabindex="0">Search</div>
   <div id="matchDisplay">
   
   </div>
   </div>
  <?php }
}