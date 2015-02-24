<?php

class MobEnterView extends PageView {
  function render() {
    ?><!--<div data-role="none" data-enhance="false">--><?php
    $this->renderHead();
    //$this->renderMenus();
    $this->renderBody();
    //$this->renderFooter();
    ?><!--</div>--><?php
  }
  function renderHead() {
    $template = new HeadTemplate();
    $template->set('title', "Mob Enter Like a Boss");
    $template->render();
  }
  public function renderBody() {   
    $db = new DatabaseModel();
    $teams = $db->getTeams();
    $schedule = $db->getSchedule();
    $scouts = $db->getScouts();
    $template = new DataEntryTemplate();
    $template->set('teams', $teams);
    $template->set('schedule', $schedule);
    $template->set('scouts', $scouts);
    $template->render();  
  }
}