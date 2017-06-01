<?php
header("Content-type: text/css; charset: UTF-8");

// Load the settings to use within the CSS.
require_once('../inc/settings.php');
?>

/**
 * CSS start
 */
body {
  margin: 0;
  padding: 0;
  margin-top: 5.2em;
  margin-bottom: 2.2em;
}

header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 5em;
  background: #666;
  color: #eee;
  border-bottom: 0.2em solid #000;
}

header > h1 {
  margin-left: 1em;
}

header > .right {
  margin-right: 1em;
  position: fixed;
  top: 1em;
  right: 1em;
  text-align: right;
}

footer {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 2em;
  text-align: center;
  background: #666;
  color: #eee;
  line-height: 2em;
  border-top: 0.2em solid #000;
}

footer a {
  color: #eee;
}

footer a:hover {
  text-decoration: none;
}

/**
 * Thumbnail CSS
 */
.thumb {
  max-width: <?php echo THUMB_MAX_WIDTH; ?>px;
  max-height: <?php echo THUMB_MAX_HEIGHT; ?>px;
}

.item {
  float: left;
  text-align: center
}

.item > span {
  display: block;

}

.icon {
  background-size: cover;
  background-repeat: no-repeat;
  background-positon: center center;
  width: <?php echo THUMB_MAX_WIDTH; ?>px;
  height: <?php echo THUMB_MAX_HEIGHT; ?>px;
}

.upDir {
  background-image: url(../inc/images/upDir.png);
}
