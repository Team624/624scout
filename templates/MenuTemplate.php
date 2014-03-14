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
          <?php if(isset($_SESSION['entry']) && $_SESSION['entry']==TRUE){ ?>
          <li><a href="/?controller=page&amp;action=dataEntry">Data Entry</a></li>
          <?php } ?>
          <li><a href="/?controller=page&amp;action=schedule">Match Schedule</a></li>
          <li><a href="/?controller=teamInfo&amp;action=display">Team Info</a></li>
          <li><a href="/?controller=matchInfo&amp;action=display">Match Info</a></li>
          <li><a href="/?controller=page&amp;action=dataCoverage">Data Coverage</a></li>
          <li><a href="/?controller=page&amp;action=teamList">Team List</a></li>
          <li><a href="/?controller=page&amp;action=scoutList">Scout List</a></li>
          <?php if(isset($_SESSION['setup']) && $_SESSION['setup']==TRUE){ ?>
            <li><a href="/?controller=setup&amp;action=display">Setup</a></li>
            <li><a href="/?controller=page&amp;action=rawData">Raw Data</a></li>
          <?php } ?>
          <li><a href="/?controller=setup&amp;action=display">Setup</a></li>
          <li><a href="/?controller=page&amp;action=rawData">Raw Data</a></li>
          <?php if(isset($_SESSION['entry']) && $_SESSION['entry']==TRUE){ ?>
            <li><a href="/?controller=page&amp;action=noteEntry">Note Entry</a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <!-- mobile pannel -->
    <div id="sidr">
      <ul>
        <?php if(isset($_SESSION['entry']) && $_SESSION['entry']==TRUE){ ?>
          <li><a href="/?controller=page&amp;action=dataEntry" class = "panLink"><span class = "icon-pencil pannelIcon-tr"></span> Data Entry</a></li>
        <?php } ?>
        <li><a href="/?controller=page&amp;action=schedule"><span class = "icon-clock pannelIcon-tr"></span> Match Schedule</a></li>
        <li><a href="/?controller=teamInfo&amp;action=display"><span class = "icon-stats pannelIcon-tr"></span> Team Info</a></li>
        <li><a href="/?controller=matchInfo&amp;action=display"><span class = "icon-bars pannelIcon-tr"></span> Match Info</a></li>
        <li><a href="/?controller=page&amp;action=teamList"><span class = "icon-numbered-list pannelIcon-tr"></span>Team List</a></li>
        <li><a href="/?controller=page&amp;action=dataCoverage">Data Coverage</a></li>
        <li><a href="/?controller=page&amp;action=scoutList"> Scout List</a></li>
        <?php if(isset($_SESSION['setup']) && $_SESSION['setup']==TRUE){ ?>
          <li><a href="/?controller=page&amp;action=rawData">Raw Data</a></li>
          <li><a href="/?controller=setup&amp;action=display">Setup</a></li>
        <?php } ?>

        <li><a href="/?controller=page&amp;action=rawData">Raw Data</a></li>
        <li><a href="/?controller=setup&amp;action=display">Setup</a></li>
        <?php if(isset($_SESSION['entry']) && $_SESSION['entry']==TRUE){ ?>
            <li><a href="/?controller=page&amp;action=noteEntry">Note Entry</a></li>
          <?php } ?>
      </ul>
    </div>
    <div class="page">
  <?php
  }
}