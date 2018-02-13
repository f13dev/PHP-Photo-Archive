<?php
// Load the settings file
require_once('inc/settings.php');

// Load the FileUtil class
require_once('inc/class/fileUtility.class.php');
$fileUtil = new FileUtility();

// Open the log file
$logFile = file_get_contents(CRON_LOG);

// Method
if (GD_THUMBS) {
  $method = 'GD Library';
}
else {
  $method = 'ImageMagick';
}

// Add a header to show that the cron has been run, even if no work is required
$logFile .= date("Y-m-d, h:i:s") . " Cron started\n";

// Create null indexes at root levelif they don't exist
if (!file_exists(ARCHIVE_MAIN . '/index.php')) {
  touch(ARCHIVE_MAIN . '/index.php');
  $string = date("Y-m-d, h:i:s") . ' Created NUL: ' . realpath(ARCHIVE_MAIN . '/index.php');
  echo $string . '<br />';
  $logFile .= $string . "\n";
}
if (!file_exists(ARCHIVE_THUMBS . '/index.php')) {
  touch(ARCHIVE_THUMBS . '/index.php');
  $string = date("Y-m-d, h:i:s") . ' Created NUL: ' . realpath(ARCHIVE_THUMBS . '/index.php');
  echo $string . '<br />';
  $logFile .= $string . "\n";
}

// Main iterator, searching images dir
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ARCHIVE_MAIN), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
  // Search and create directories and thumbs
  if (substr($name, -1) != '.') {
    $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $name);
    $mid = str_replace(ARCHIVE_MAIN, ARCHIVE_MID, $name);
    // Get the thumb alternative
    if (is_dir($name)) {
      // Create directories and null indexes
      if (!file_exists($thumb)) {
        if ($fileUtil->createThumbDir(str_replace(ARCHIVE_MAIN, '', $name), 'thumb')) {
          $string = date("Y-m-d, h:i:s") . ' Created DIR: ' . realpath($thumb);
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
        else {
          $string = date("Y-m-d, h:i:s") . ' Failed to create DIR: ' . realpath($thumb);
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
      }
      if (ENABLE_MID_IMAGES) {
        if (!file_exists($mid)) {
          if ($fileUtil->createThumbDir(str_replace(ARCHIVE_MAIN, '', $name), 'mid')) {
            $string = date("Y-m-d, h:i:s") . ' Created DIR: ' . realpath($mid);
            echo $string . "<br>\n";
            $logFile .= $string . "\n";
          }
          else {
            $string = date("Y-m-d, h:i:s") . ' Failed to create DIR: ' . realpath($mid);
            echo $string . "<br />\n";
            $logFile .= $string . "\n";
          }
        }
      }
      // Create null indexes if they don't exist
      if (!file_exists($name . '/index.php')) {
        touch($name . '/index.php');
        $string = date("Y-m-d, h:i:s") . ' Created NUL: ' . realpath($name . '/index.php');
        echo $string . "<br />\n";
        $logFile .= $string . "\n";
      }
      if (!file_exists($thumb . '/index.php')) {
        touch ($thumb . '/index.php');
        $string = date("Y-m-d, h:i:s") . ' Created NUL: ' . realpath($thumb . '/index.php');
        echo $string . "<br />\n";
        $logFile .= $string . "\n";
      }
      if (!file_exists($mid . '/index.php') && ENABLE_MID_IMAGES) {
        touch ($mid . '/index.php');
        $string = date("Y-m-d, h:i:s") . ' Created NUL: ' . realpath($mid . '/index.php');
        echo $string . "<br />\n";
        $logFile .= $string . "\n";
      }
    }
    // Create thumbs for images
    elseif (preg_match('/(jpg|jpeg|gif|tiff|png)/i',$name)) {
      // Check if the thumb already exists
      $fileName = explode('/', $name);
      $fileName = end($fileName);
      if (!$fileUtil->thumbExists($name, 'thumb') && $fileName[0] != '.')
      {
        if ($fileUtil->createThumb($name, 'thumb')) {
          $string = date("Y-m-d, h:i:s") . ' Created IMG: ' . realpath($thumb) . ' using: ' . $method;
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
        else {
          $string = date("Y-m-d, h:i:s") . ' Failed to create IMG: ' . realpath($thumb) . ' using: ' . $method;
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
      }
      if (!$fileUtil->thumbExists($name, 'mid') && $fileName[0] != '.')
      {
        if ($fileUtil->createThumb($name, 'mid')) {
          $string = date("Y-m-d, h:i:s") . ' Created IMG: ' . realpath($mid) . ' using: ' . $method;
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
        else {
          $string = date("Y-m-d, h:i:s") . ' Failed to create IMG: ' . realpath($mid) . ' using: ' . $method;
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
      }
    }
    // Create thumbs for videos
    elseif (preg_match('/(mp4|ogg|webm)/i',$name)) {
      $fileName = explode('/', $name);
      $fileName = end($fileName);
      // if the video doesn't have a thumb
      if (!$fileUtil->thumbExistsVideo($name))
      {
        if ($fileUtil->createThumbVideo($name)) {
          $string = date("Y-m-d, h:i:s") . ' Created VID: ' . realpath($fileUtil->getVideoThumbName($name)) . ' using: ' . $method;
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
        else {
          $string = date("Y-m-d, h:i:s") . ' Failed to create IMG: ' . realpath($fileUtil->getVideoThumbName($name)) . ' using: ' . $method;
          echo $string . "<br />\n";
          $logFile .= $string . "\n";
        }
      }
    }
  }
}

// Secondary iterator, searching thumbs dir for file to remove
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ARCHIVE_THUMBS), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $thumb => $object){
  $main = str_replace(ARCHIVE_THUMBS, ARCHIVE_MAIN, $thumb);
  $video = $fileUtil->getVideoFromThumb($thumb);
  if (substr($thumb, -1) != '.' && !is_dir($thumb) && !file_exists($main) && !file_exists($video))
  {
    $string = date("Y-m-d, h:i:s") . ' Removing FIL: ' . realpath($thumb);
    echo $string . "<br />\n";
    $logFile .= $string . "\n";
    shell_exec('rm -rf ' . str_replace(' ', '\ ', $thumb));
  }
}

// Third iterator, searching thumbs dir for empty dir to remove
$toRemove = array();
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
  $string = date("Y-m-d, h:i:s") . ' Removed DIR: ' . realpath($directory);
  echo $string . "<br />\n";
  $logFile .= $string . "\n";
  shell_exec('rm -rf ' . str_replace(' ', '\ ', $directory));
}

// Write to the log file
file_put_contents(CRON_LOG, $logFile);

?>
