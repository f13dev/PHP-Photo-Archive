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

  /**
   * Returns the string representation of the dir
   * @return String dir
   */
  function getDir()
  {
    return $this->dir;
  }

  /**
   * Returns the string representation of the parent dir,
   * if no parent dir exists, returns null
   * @return String parent dir
   * @return null
   */
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

  /**
   * Returns the subDir Array
   * @return Array[name,path] Array of subDir name/path pairs
   */
  function getSubDir()
  {
    return $this->subDir;
  }

  /**
   * Retunrs the file Array
   * @return Array[name,path] Array of file name/path pairs
   */
  function getFiles()
  {

  }
}
