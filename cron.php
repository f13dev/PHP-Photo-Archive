<?php
// Load the settings file
require_once('inc/settings.php');

// Load the FileUtil class
require_once('inc/class/fileUtility.class.php');
$fileUtil = new FileUtility();

// Main iterator, searching images dir
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ARCHIVE_MAIN), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
  // Search and create directories and thumbs
  if (substr($name, -1) != '.')
  {
    // Get the thumb alternative
    $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $name);

    if (is_dir($name))
    {
      if ($fileUtil->createThumbDir(str_replace(ARCHIVE_MAIN, '', $name)))
      {
        echo 'Created DIR: ' . realpath($thumb) . '<br />';
      }

    }
    elseif (preg_match('/(jpg|jpeg|gif|tiff|png)/i',$name))
    {
      if ($fileUtil->createThumb($name))
      {
        echo 'Created IMG: ' . realpath($thumb) . '<br />';
      }
    }
  }
}

/*
// Search and create null indexes
if (!file_exists($name . '/index.php'))
{
  touch($name . '/index.php');
  echo 'Created NUL: ' . realpath($name . '/index.php');
}
if (!file_exists($thumb . '/index.php'))
{
  touch ($name . '/index.php');
  echo 'Created NUL: ' . realpath($name . '/index.php');
}
 */
?>
