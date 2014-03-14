<?php

class NoteEntryTemplate extends Template {

  public function __construct() {
  
  }
  public function render() {
  ?>
  <div>
	<div><label>Team:<input type="text" class="num" id="note-team"></label></div>
	<div><textarea id="note-area"> </textarea></div>
	<div><div class="big button" id="submit-note">Submit</div></div>
  </div>
  <?php }
}