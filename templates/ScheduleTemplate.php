<?php

class ScheduleTemplate extends Template {

  public function __construct() {
    $this->keys[]='schedule';
  }
  public function render() {
  $s = $this->data['schedule'];
  ?>
   SCEDHULE!
   <div class="schedule-holder">
     <table class="schedule">
    <tr>
      <th>Match</th>
      <th>Time</th>
      <th>Red 1</th>
      <th>Red 2</th>
      <th>Red 3</th>
      <th>Blue 1</th>
      <th>Blue 2</th>
      <th>Blue 3</th>
    </tr>
    <?php foreach($s as $row) { ?>
      <tr>
      <td class="match-number"><?=$row['match_number']?></td>
      <td class="match-time"><?=$row['time']?></td>
      <td class="red"><?=$row['red_1']?></td>
      <td class="red"><?=$row['red_2']?></td>
      <td class="red"><?=$row['red_3']?></td>
      <td class="blue"><?=$row['blue_1']?></td>
      <td class="blue"><?=$row['blue_2']?></td>
      <td class="blue"><?=$row['blue_3']?></td>
    <?php } ?>
    </table>
  </div>
  <?php }
}