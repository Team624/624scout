<?php

class MatchInfoDisplayTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'match';
  }
  public function render() {
  ?>
  <div>
   <label> Match: <input id="searchMatch" class="num" type="text" <?php if(isset($this->data['match'])) { ?> value="<?=$this->data['match']?>" <?php } ?>></label>
   <div id="searchMatchBut" class="button" tabindex="0">Search</div>
   <div id="matchDisplay">
   
   </div>
   </div>
  <?php }
}