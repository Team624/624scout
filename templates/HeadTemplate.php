<?php

class HeadTemplate extends Template {
  public function __construct() {
    $this->keys[] = 'title';
  }
  public function render() { ?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=0.5">
    <title>624 Scouting</title>
    <link rel="stylesheet" type="text/css" href="/SuperCSSLoader.php"></link>
    <link href='http://fonts.googleapis.com/css?family=Alef:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
    <!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />-->
    <script src="/jquery-1.11.0.min.js"></script>
    <!--<script>
    $(document).one("mobileinit", function () {
    $.mobile.ignoreContentEnabled=true;
    $.mobile.defaultPageTransition = 'none';
    });
    </script>
    <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>-->
    <script src="/icheck.min.js"></script>
    <script src="/alertify.min.js"></script>
    <script src="/jquery.sidr.min.js"></script>
    <script src="/scripts.php"></script>
  </head>
  <body>
  <?php }
}