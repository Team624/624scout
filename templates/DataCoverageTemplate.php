<?php

class DataCoverageTemplate extends Template {

  public function __construct() {
    $this->keys[]='schedule';
  }
  public function render() {
  $s = $this->data['schedule'];
  ?>
   SCEDHULE!
   <div class="schedule-holder">
     <table class="schedule nohi">
    <tr>
      <th>Match</th>
      <th>Red 1</th>
      <th>Red 2</th>
      <th>Red 3</th>
      <th>Blue 1</th>
      <th>Blue 2</th>
      <th>Blue 3</th>
    </tr>
    <?php foreach($s as $row) { ?>
      <tr>
      <td class="match_number"><?=$row['match_number']?></td>
      <td class="<?=$row['has_red_1']?'found':'not-found'?>"><?=$row['red_1']?></td>
      <td class="<?=$row['has_red_2']?'found':'not-found'?>"><?=$row['red_2']?></td>
      <td class="<?=$row['has_red_3']?'found':'not-found'?>"><?=$row['red_3']?></td>
      <td class="<?=$row['has_blue_1']?'found':'not-found'?>"><?=$row['blue_1']?></td>
      <td class="<?=$row['has_blue_2']?'found':'not-found'?>"><?=$row['blue_2']?></td>
      <td class="<?=$row['has_blue_3']?'found':'not-found'?>"><?=$row['blue_3']?></td>
    <?php } ?>
    </table>
  </div>
  <?php }
}