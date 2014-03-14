<?php

class TestMeView implements View {
  function renderHead() {
    $template = new HeadTemplate();
    $template->set('title', "624 Validate");
    $template->render();
  }
  
  function renderMenus() {
    
    $template = new MenuTemplate();
    if(Session::isLoggedIn()) {
      $user = Session::getLoggedInUser();
      $template->set('user', $user->username);
      $template->set('is_approved', $user->is_approved);
      $template->set('is_student', $user->is_student);
      $template->set('is_editor', $user->is_editor);
      $template->set('is_sponsor', $user->is_sponsor);
      $template->set('is_admin', $user->is_admin);
      $template->set('fname', $user->fname);
      $template->set('lname', $user->lname);
    }
    $template->render();
  }
  
  function renderBody(){
    $template = new TestMeTemplate();
    $template->render();  
  }
  
  function renderFooter() {
    $template = new FooterTemplate();
    $template->render();
  }
  
  function render() {
    ?><!--<div data-role="none" data-enhance="false">--><?php
    $this->renderHead();
    //$this->renderMenus();
    $this->renderBody();
    //$this->renderFooter();
    ?><!--</div>--><?php
  }
}