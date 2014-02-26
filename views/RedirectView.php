<?php
class RedirectView implements View  {
  protected $url;
  public function __construct($url) {
    $this->url = $url;
  }
  
  public function render() {
    header('Location: ' . $this->url);
  }
}