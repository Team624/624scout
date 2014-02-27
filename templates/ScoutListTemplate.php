<?php

class ScoutListTemplate extends Template {

  public function __construct() {
    $this->keys[]='scouts';
  }
  public function render() {
  $t = $this->data['scouts'];
  ?>
   Scouts
   <div class="schedule-holder">
     <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
    </tr>
    <?php foreach($t as $i => $n) { ?>
      <tr>
      <td class=""><?=$i?></td>
      <td class=""><?=$n?></td>
      </tr>
    <?php } ?>
    </table>
  </div>
  <?php }
}