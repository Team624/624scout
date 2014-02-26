<?php

class RawDataTemplate extends Template {

  public function __construct() {
    $this->keys[]='match_data';
    $this->keys[]='cycles';
  }
  public function render() {
  $matchData = $this->data['match_data'];
  $cycles = $this->data['cycles'];
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
  Cycles
  <?php if(isset($cycles[0])) { ?>
     <table id="cycles" class="raw-table">
    <tr>
      <?php foreach($cycles[0] as $key => $val) { 
         if($val === NULL) $val = '--';
      ?>
        <th><p><?= $key ?></p></th>
      <?php } ?>
    </tr>
    <?php foreach($cycles as $row) { ?>
      <tr>
        <?php foreach($row as $key => $val) { ?>
          <td><?= $val ?></td>
        <?php } ?>
      </tr>
    <?php } ?>
    </table>
  <?php } ?>
  </div>
  <?php }
}