<?php
// Load the settings file
require_once('inc/settings.php');

// Load the FileUtil class
require_once('inc/class/fileUtility.class.php');
$fileUtil = new FileUtility();

// Create null indexes at root levelif they don't exist
if (!file_exists(ARCHIVE_MAIN . '/index.php')) {
  touch(ARCHIVE_MAIN . '/index.php');
  echo 'Created NUL: ' . realpath(ARCHIVE_MAIN . '/index.php') . '<br />';
}
if (!file_exists(ARCHIVE_THUMBS . '/index.php')) {
  touch(ARCHIVE_THUMBS . '/index.php');
  echo 'Created NUL: ' . realpath(ARCHIVE_THUMBS . '/index.php') . '<br />';
}

// Main iterator, searching images dir
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ARCHIVE_MAIN), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
  // Search and create directories and thumbs
  if (substr($name, -1) != '.') {
    // Get the thumb alternative
    $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $name);

    if (is_dir($name)) {
      if ($fileUtil->createThumbDir(str_replace(ARCHIVE_MAIN, '', $name))) {
        echo 'Created DIR: ' . realpath($thumb) . '<br />';
      }
      // Create null indexes if they don't exist
      if (!file_exists($name . '/index.php')) {
        touch($name . '/index.php');
        echo 'Created NUL: ' . realpath($name . '/index.php') . '<br />';
      }
      if (!file_exists($thumb . '/index.php')) {
        touch ($thumb . '/index.php');
        echo 'Created NUL: ' . realpath($thumb . '/index.php') . '<br />';
      }
    }
    elseif (preg_match('/(jpg|jpeg|gif|tiff|png)/i',$name)) {
      if ($fileUtil->createThumb($name)) {
        echo 'Created IMG: ' . realpath($thumb) . '<br />';
      }
    }
  }
}

// Secondary iterator, searching thumbs dir for file to remove
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ARCHIVE_THUMBS), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $thumb => $object){
  $main = str_replace(ARCHIVE_THUMBS, ARCHIVE_MAIN, $thumb);
  if (substr($thumb, -1) != '.' && !is_dir($thumb) && !file_exists($main))
  {
    echo 'Removing FIL: ' . realpath($thumb) . '<br />';
    shell_exec('rm -rf ' . str_replace(' ', '\ ', $thumb));
  }
}

// Third iterator, searching thumbs dir for empty dir to remove
$toRemove = [];
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ARCHIVE_THUMBS), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $thumb => $object){
  $main = str_replace(ARCHIVE_THUMBS, ARCHIVE_MAIN, $thumb);
  if (substr($thumb, -1) != '.' && is_dir($thumb) && !file_exists($main))
  {
    array_push($toRemove, $thumb);
  }
}
// Remove all directories in the toRemove array
foreach ($toRemove as $directory) {
  echo 'Removing DIR: ' . realpath($directory) . '<br />';
  shell_exec('rm -rf ' . str_replace(' ', '\ ', $directory));
}

?>
