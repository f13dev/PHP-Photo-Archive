<?php
require_once('../inc/class/fileUtility.class.php');
$fileUtility = new FileUtility;

$file = $_GET['file'];

$ext = $fileUtility->getExtension($file);

if ($ext == 'txt')
{
  echo '
  <div style="padding:1em">
    ' . nl2br(file_get_contents('../' . $file)) . '
  </div>
  ';
}
else
{
  echo 'The supplied notes file is not currently supported';
}
