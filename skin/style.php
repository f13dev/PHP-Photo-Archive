<?php
header("Content-type: text/css; charset: UTF-8");

// Load the settings to use within the CSS.
require_once('../inc/settings.php');
?>

/**
 * CSS start
 */

html {
  padding-bottom: 3em;
}

body {
  margin: 0;
  padding: 0;
  margin-top: 5.2em;
  margin-bottom: -2.2em;
}

main {
  padding-bottom: 10em;
  clear:both;
}

#imageBrowser {
  margin-bottom: 5em;
}

#imageBrowser:after {
  clear: both;
}

header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 5em;
  background: #676767;
  color: #eee;
  border-bottom: 0.2em solid #000;
  z-index:99;
}

header > h1 {
  margin-left: 1em;
}

header > h1 > a {
  color: #fff;
  text-decoration: none;
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
  background: #676767;
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

#fileManager, #imageBrowser {
  clear: both;
}

/**
 * Thumbnail CSS
 */
.thumb {
  max-width: <?php echo THUMB_MAX_WIDTH; ?>px;
  max-height: <?php echo THUMB_MAX_HEIGHT; ?>px;
}
.info {
  display: none;
  position: fixed;
  bottom: 2.2em;
  right: 0;
  left: 0;
  background-color: white;
  border-top: 0.2em solid #000;
  padding: 1em;
}

.info > span {
  display: inline-block;
  width: 15em;
  line-height: 1.7em;
  color: #000;
}

.gallery:hover .info {
  display: block;
}

.item {
  float: left;
  text-align: center;
  border: 1px solid #ddd;
  margin: 0.3em;
  overflow: hidden;
  width: 10em;
  height: 12.5em;
}

.item:hover {
  border: 1px solid #333;
}

.item:hover > .icon {
  opacity: .4;
}

.item > span {
  display: block;
  color: #676767;
}

.icon {
  border: 1px solid #ddd;
  background-color: #f8f8f8;
  background-size: cover;
  background-repeat: no-repeat;
  background-positon: center;
  width: <?php echo THUMB_MAX_WIDTH; ?>px;
  height: <?php echo THUMB_MAX_HEIGHT; ?>px;
  margin: 0.3em;
}

.upDir {
  background-image: url(../inc/images/upDir.png);
}

.subDir {
  background-image: url(../inc/images/subDir.png);
}

.video {
  background-image: url(../inc/images/video.png);
}

.notes {
  background-image: url(../inc/images/document.png);
}

.prevPage {
  background-image: url(../inc/images/prev.png);
}

.nextPage {
  background-image: url(../inc/images/next.png);

/**
 * FancyBox download button
 */

 .fancybox-download:before {
  top: 14px;
  left: 22px;
  border-left: 2px solid #fff;
  height: 12px;
}

.fancybox-download:after {
  bottom: 18px;
  left: 23px;
  height: 8px;
  border-bottom: 2px solid #fff;
  border-right: 2px solid #fff;
  width: 8px;
  background: transparent;
  transform: rotate(45deg);
  transform-origin: 0 0;
}

.fancybox-content {
  min-height: 600px;
}
