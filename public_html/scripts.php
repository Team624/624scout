<?php
  header('Content-Type: text/javascript');
  header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + 604800)); //Tell the browser to cache this for 1 weeks

  $script_directory = './scripts/';
  
  $dir = opendir($script_directory);
  

  
  while (($entry = readdir($dir)) !== false) {
    if(substr_compare($entry, '.js', -3) === 0) { 
      echo file_get_contents($script_directory . $entry) . "\n";
    }
  }
?>