<?php
class Configuration {
  protected $data;
  
  public function __construct($filename) {
    $this->data = parse_ini_file($filename);
  }
  
  public function get($key) {
    return $this->data[$key];
  }
}