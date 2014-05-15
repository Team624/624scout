<?php

class ScheduleTemplate extends Template {

  public function __construct() {
    $this->keys[]='schedule';
    $this->keys[]='lastPlayed';
  }
  public function render() {
  $s = $this->data['schedule'];
  ?>
   Match Schedule
   <div><?=$this->data['lastPlayed']?></div>
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
      <td class="match-number"><a class="invisilink" href="/?controller=matchInfo&action=display&match=<?=$row['match_number']?>"><?=$row['match_number']?></a></td>
      <td class="match-time"><?=$row['time']?></td>
      <td class="red"><a href="/?controller=teamInfo&action=display&team=<?=$row['red_1']?>" class="invisilink"><?=$row['red_1']?></a></td>
      <td class="red"><a href="/?controller=teamInfo&action=display&team=<?=$row['red_2']?>" class="invisilink"><?=$row['red_2']?></a></td>
      <td class="red"><a href="/?controller=teamInfo&action=display&team=<?=$row['red_3']?>" class="invisilink"><?=$row['red_3']?></a></td>
      <td class="blue"><a href="/?controller=teamInfo&action=display&team=<?=$row['blue_1']?>" class="invisilink"><?=$row['blue_1']?></a></td>
      <td class="blue"><a href="/?controller=teamInfo&action=display&team=<?=$row['blue_2']?>" class="invisilink"><?=$row['blue_2']?></a></td>
      <td class="blue"><a href="/?controller=teamInfo&action=display&team=<?=$row['blue_3']?>" class="invisilink"><?=$row['blue_3']?></a></td>
    <?php } ?>
    </table>
  </div>
  <?php }
}