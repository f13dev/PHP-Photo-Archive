<?php
class Dir
{

  private $dir; // String containing the dir
  private $subDir = array(); // List of sub directories
  private $files = array(); // List of supported image and video files

  function Dir($theDir) {
    if (is_dir(ARCHIVE_MAIN . $theDir))
    {
      $this->dir = $theDir;
      $this->setSubDir();
      $this->setFiles();
    }
    else
    {
      throw new Exception('Directory not found');
    }
  }

  private function setSubDir()
  {
    echo $this->dir . '<br />';
    foreach (glob(ARCHIVE_MAIN . $this->dir . '/*', GLOB_ONLYDIR) as $eachDir)
    {
      $eachDir = str_replace('//','/',$eachDir);
      $eachDir = str_replace(ARCHIVE_MAIN,'',$eachDir);
      array_push($this->subDir, $eachDir);
    }
  }

  private function setFiles()
  {

  }

  function getParentDir()
  {

  }
  
  function getSubDir()
  {
    return $this->subDir;
  }

  function getFiles()
  {

  }
}
