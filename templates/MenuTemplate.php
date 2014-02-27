<?php
class MenuTemplate extends Template {
  public function __construct() {
    
  }
  function render() {?>
<div class="menubar">
      <a href="/"><img class="logo" src="/624trans-menu.png"></img></a>
      <ul class="menu">
        <li><a href="/?controller=page&amp;action=dataEntry">Data Entry</a></li>
        <li><a href="/?controller=page&amp;action=schedule">Match Schedule</a></li>
        <li><a href="/?controller=page&amp;action=dataCoverage">Data Coverage</a></li>
        <li><a href="/?controller=teamInfo&amp;action=display">Team Info</a></li>
        <li><a href="/?controller=page&amp;action=rawData">Raw Data</a></li>
        <li><a href="/?controller=setup&amp;action=display">Setup</a></li>
        
      </ul>
    </div>
    <div class="page">
  <?php
  }
}