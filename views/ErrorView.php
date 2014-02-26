<?php
class ErrorView implements View {
  public $errorCode;
  public $errorText;
  public $responseText;
  public function __construct($errorCode, $errorText, $responseText = null) {
    if(!isset($responseText)) $responseText = $errorText;
    $this->errorCode = $errorCode;
    $this->errorText = $errorText;
    $this->responseText = $responseText;
  }
  public function render() {
    header('HTTP/1.1 ' . $this->errorCode . ' ' . $this->errorText);
    echo $this->responseText;
  }
}