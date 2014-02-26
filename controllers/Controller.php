<?php
function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}
abstract class Controller {
  protected $action;
  
  public function __construct($action) {
    $this->action = $action;
  }
  
  public function executeAction() {
    $this->{$this->action}();
  }
}