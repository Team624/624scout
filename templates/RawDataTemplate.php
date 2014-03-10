<?php

class RawDataTemplate extends Template {

  public function __construct() {
    $this->keys[]='match_data';
    $this->keys[]='cycles';
  }
  public function render() {
  $matchData = $this->data['match_data'];
  ?>
   Match Data
   <?php if(isset($matchData[0])) { ?>
     <table id="matchData" class="raw-table">
    <tr>
      <?php foreach($matchData[0] as $key => $val) { ?>
        <th><p><?= $key ?><p></th>
      <?php } ?>
    </tr>
    <?php foreach($matchData as $row) { ?>
      <tr>
        <?php foreach($row as $key => $val) { 
        if($val === NULL) $val = '--';
        ?>
          <td><div><?= $val ?></div></td>
        <?php } ?>
      </tr>
    <?php } ?>
    </table>
  <?php } ?>
  

  <?php }
}