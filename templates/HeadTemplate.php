<?php

class HeadTemplate extends Template {
  public function __construct() {
    $this->keys[] = 'title';
  }
  public function render() { ?>

<!DOCTYPE html>
<html>
  <head>
    <title>624 Scouting</title>
    <link rel="stylesheet" type="text/css" href="/SuperCSSLoader.php"></link>
    <link href='http://fonts.googleapis.com/css?family=Alef:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
    <script src="/jquery-1.11.0.min.js"></script>
    <script src="/icheck.min.js"></script>
    <script src="/alertify.min.js"></script>
    <script src="/scripts.php"></script>
  </head>
  <body>
  <?php }
}