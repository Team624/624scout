<?php
abstract class Template {
  protected $data = array();
  protected $keys = array();
  public function set($key, $val) {
    if(in_array($key, $this->keys)) {
      $this->data[$key] = $val;
    } else {
      throw new Exception('Unsupported key.');
    }
  }
  public abstract function render();
}