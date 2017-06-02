<?php
require_once('inc/class/fileUtility.class.php');
$fileUtility = new FileUtility;

$file = $_GET['file'];
$mode = $_GET['mode'];

$ext = $fileUtility->getExtension($file);

if ($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg')
{
  echo '
  <video controls>
    <source src="' . $file . '" type="video/' . $ext . '">
    Your browser does not support the video tag.
  </video>
  ';
}
else
{
  echo 'The supplied video file is not currently supported';
}
