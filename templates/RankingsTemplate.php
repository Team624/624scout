<?php

class RankingsTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'rankings';
  }
  public function render() { ?>
    Rankings
    <table class="rankings">
      <tr>
        <th>Seed</th>
        <th>Team</th>
        <th>Played</th>
        <th>QS</th>
        <th>Assist</th>
        <th>Auto</th>
        <th>Truss</th>
        <th>Teleop</th>
        <th>Record</th>
        <th>DQ</th>
      </tr>
      <?php foreach($this->data['rankings'] as $rank) { ?>
        <tr class="<?=$rank['oddQS']?'odd-qs':''?>">
          <td><?=$rank['seed']?></td>
          <td class="<?=$rank['team']==624?'us':''?>">
            <a class="invisilink" href="/?controller=teamInfo&amp;action=display&amp;team=<?=$rank['team']?>">
              <?=$rank['team']?>
            </a>
          </td>
          <td <?=$rank['oddQS']?'ltm':''?>><?=$rank['played']?></td>
          <td><?=$rank['QS']?></td>
          <td><?=$rank['assist']?></td>
          <td><?=$rank['auto']?></td>
          <td><?=$rank['trussCatch']?></td>
          <td><?=$rank['teleop']?></td>
          <td><?=$rank['record']?></td>
          <td><?=$rank['DQ']?></td>
        </tr>
      <?php } ?>
    </table>
    <?= var_dump($this->data['rankings']) ?>
  <?php }
}