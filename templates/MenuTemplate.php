<?php
class MenuTemplate extends Template {
  public function __construct() {
    
  }
  function render() {?>
<div class="menubar">
<!--class="mobile-menu-button icon-menu-2"-->
      <a class="mobile-menu-button icon-menu-2" id="simple-menu" href="#sidr"></a>
      <a href="/"><img class="logo" src="/624trans-menu.png"></img></a>
      <div id = "menuContent"> 
        <ul class="menu">
          <li><a href="/?controller=page&amp;action=dataEntry">Data Entry</a></li>
          <li><a href="/?controller=page&amp;action=schedule">Match Schedule</a></li>
          <li><a href="/?controller=page&amp;action=dataCoverage">Data Coverage</a></li>
          <li><a href="/?controller=teamInfo&amp;action=display">Team Info</a></li>
          <li><a href="/?controller=matchInfo&amp;action=display">Match Info</a></li>
          <li><a href="/?controller=page&amp;action=teamList">Team List</a></li>
          <li><a href="/?controller=page&amp;action=scoutList">Scout List</a></li>
          <li><a href="/?controller=setup&amp;action=display">Setup</a></li>
          <li><a href="/?controller=page&amp;action=rawData">Raw Data</a></li>
        </ul>
      </div>
    </div>
    <!-- mobile pannel -->
    <div id="sidr">
      <ul>
        <li><a href="/?controller=page&amp;action=dataEntry" class = "panLink"><span class = "icon-pencil pannelIcon-tr"></span> Data Entry</a></li>
        <li><a href="/?controller=page&amp;action=schedule"><span class = "icon-clock pannelIcon-tr"></span> Match Schedule</a></li>
        <li><a href="/?controller=page&amp;action=dataCoverage">Data Coverage</a></li>
        <li><a href="/?controller=teamInfo&amp;action=display"><span class = "icon-stats pannelIcon-tr"></span> Team Info</a></li>
        <li><a href="/?controller=matchInfo&amp;action=display"><span class = "icon-bars pannelIcon-tr"></span> Match Info</a></li>
        <li><a href="/?controller=page&amp;action=teamList">Team List</a></li>
        <li><a href="/?controller=page&amp;action=scoutList"><span class = "icon-users-2 pannelIcon-tr"></span> Scout List</a></li>
        <li><a href="/?controller=page&amp;action=rawData">Raw Data</a></li>
        <li><a href="/?controller=setup&amp;action=display">Setup</a></li>
      </ul>
    </div>
    <div class="page">
  <?php
  }
}