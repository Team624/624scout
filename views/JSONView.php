<?php
abstract class JSONView implements View {

function render() {
  header('Content-Type: application/json');
  $data = $this->getData();
  echo json_encode($data);
}

protected abstract function getData();

}
