<?php

class RankingsTemplate extends Template {

  public function __construct() {
    $this->keys[] = 'rankings';
    $this->keys[] = '624assist';
    $this->keys[] = 'lastPlayed';
  }
  public function render() { ?>
    Rankings
    <div><?=$this->data['lastPlayed']?></div>
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
          <td class="<?=$rank['lessThanMax']?'ltm':''?>">
            <?=$rank['played']?>
            <?php if($rank['lessThanMax']) { ?>
              <span class="icon-arrow-up rank-icon"></span>
            <?php } ?>
          </td>
          <td><?=$rank['QS']?></td>
          <td><?=$rank['assist']?>
            <?php if($rank['assist'] > $this->data['624assist']) { ?>
              <span class="icon-notification rank-icon"></span>
            <?php } ?>
          </td>
          <td><?=$rank['auto']?></td>
          <td><?=$rank['trussCatch']?></td>
          <td><?=$rank['teleop']?></td>
          <td><?=$rank['record']?></td>
          <td><?=$rank['DQ']?></td>
        </tr>
      <?php } ?>
    </table>
  <?php }
}