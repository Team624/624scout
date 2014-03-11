<?php

class TeamListTemplate extends Template {

  public function __construct() {
    $this->keys[]='teams';
  }
  public function render() {
  $t = $this->data['teams'];
  ?>
   Teams
   <div class="schedule-holder">
     <table>
    <tr>
      <th>Num</th>
      <th>Name</th>
    </tr>
    <?php foreach($t as $k => $v) { ?>
      <tr>
      <td class=""><a href = <?=("/?controller=teamInfo&action=display&team=" . $k)?>><?=$k?></a></td>
      <td class=""><?=$v?></td>
      </tr>
    <?php } ?>
    </table>
  </div>
  <?php }
}