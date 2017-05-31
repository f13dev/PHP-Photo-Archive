<?php
class Dir
{

  private $dir; // String containing the dir
  private $subDir = array(); // List of sub directories
  private $files = array(); // List of supported image and video files

  function Dir($theDir) {
    if (is_dir(ARCHIVE_MAIN . $theDir))
    {
      $this->dir = ltrim($theDir, '/');
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
      $path = ltrim($this->dir . '/' . basename($eachDir), '/');
      $this->subDir[basename($eachDir)] = $path;
    }
  }

  private function setFiles()
  {

  }

  function getDir()
  {
    return $this->dir;
  }

  function getParentDir()
  {
    if ($this->dir == '')
    {
      // This is the root directory
      return null;
    }
    else
    {
      $last = end(explode('/',$this->dir));
      $parent = rtrim(str_replace($last,'',$this->dir), '/');
      return $parent;
    }
  }

  function getSubDir()
  {
    return $this->subDir;
  }

  function getFiles()
  {

  }
}
