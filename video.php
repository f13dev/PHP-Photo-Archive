<?php
require_once('inc/class/fileUtility.class.php');
$fileUtility = new FileUtility;

$file = $_GET['file'];

$ext = $fileUtility->getExtension($file);

if ($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg')
{
  echo '
  <div style="padding:1em">
    <video autoplay>
      <source src="' . $file . '" type="video/' . $ext . '">
      Your browser does not support the video tag.
    </video>
  </div>
  ';
}
else
{
  echo 'The supplied video file is not currently supported!';
}
