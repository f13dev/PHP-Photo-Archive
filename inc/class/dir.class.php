<?php
class Dir
{

  private $dir; // String containing the dir
  private $subDir; // List of sub directories
  private $files; // List of supported image and video files

  function Dir($theDir) {
    $this->dir = ARCHIVE_MAIN . $theDir; // Set the dir
    $this->validateDir(); // Validate dir
    $this->setSubDir(); // Populate
    $this->setFiles();
  }

  private function validateDir()
  {
    if (is_dir($this->dir))
    {
      echo 'Good';
    }
    else
    {
      echo 'Bad';
      $this->dir = ARCHIVE_MAIN;
    }
  }

  private function setSubDir()
  {
    foreach (glob($this->dir . '/*', GLOB_ONLYDIR) as $eachDir)
    {
      echo 'SubDir ' . $eachDir . '<br />';
    }
  }

  private function setFiles()
  {

  }

  function getSubDir()
  {

  }

  function getFiles()
  {

  }
}
