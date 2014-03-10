<?php
//SuperCSSLoader

// To reduce our large amount of stylesheets (like 8) stylesheets are now combined
//into one file that has all our css. Unlike the script loader, site styling is dependent on 
//the order that stylesheets are applied, so we can't automagically load them from a folder the way scripts
//are. Instead, we'll use php includes. This should make the site load noticeably faster on slow
// mobile connections.
header('Content-Type: text/css');
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + 604800)); //Tell the browser to cache this for 1 week
include ('./stylesheets/skins/polaris/polaris.css');
include ('./stylesheets/alertify.core.css');
include ('./stylesheets/alertify.default.css');
//Main stylesheets
//note that the order of the files in the list can be significant.

$mainFiles = [
'style-Main.css'
];
//include ('./stylesheets/style-Main.css');
foreach($mainFiles as $file) {
  require_once('./stylesheets/style/' . $file);
}
?> @media(max-width: 1279px) { <?php
  include ('./stylesheets/style-midrange.css');
?> } @media(max-width: 849px) { <?php
  include ('./stylesheets/style-tablet.css');
?> } @media(max-width: 549px) { <?php
  include ('./stylesheets/style-mobile.css');
?>
