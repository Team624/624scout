<?php
abstract class PageView implements View {
  protected $title = 'CRyptonite Robotics - FIRST Team 624';
  function renderHead() {
    $template = new HeadTemplate();
    $template->set('title', $this->title);
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
  
  abstract protected function renderBody();
  
  function renderFooter() {
    $template = new FooterTemplate();
    $template->render();
  }
  
  function render() {
    $this->renderHead();
    $this->renderMenus();
    $this->renderBody();
    $this->renderFooter();
  }
  
  
}