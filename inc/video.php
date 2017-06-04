<?php
require_once('../inc/class/fileUtility.class.php');
$fileUtility = new FileUtility;

$file = $_GET['file'];

$ext = $fileUtility->getExtension($file);
?>
<!DOCTYPE html>
<html>
<body style="background: #000; text-align: center;">
  <?php
  if ($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg')
  {
    echo '
    <div style="padding:1em">
      <video style="max-width:100%; max-height: 100%; position: absolute; top: 50%; transform: translateY(-50%) translateX(-50%);" controls autoplay>
        <source src="../' . $file . '" type="video/' . $ext . '">
        Your browser does not support the video tag.
      </video>
    </div>
    ';
  }
  else
  {
    echo 'The supplied video file is not currently supported';
  }
?>
</body>
</html>
