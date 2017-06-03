<?php
class Dir
{

  private $dir; // String containing the dir
  private $subDir = array(); // List of sub directories
  private $files = array(); // List of supported image and video files
  private $notes = array(); // List of txt files

  function Dir($theDir) {
    if (is_dir(ARCHIVE_MAIN . $theDir))
    {
      $this->dir = ltrim($theDir, '/');
      $this->setSubDir();
      $this->setFiles();
      $this->setNotes();
    }
    else
    {
      throw new Exception('Directory not found');
    }
  }

  private function setSubDir()
  {
    foreach (glob(ARCHIVE_MAIN . $this->dir . '/*', GLOB_ONLYDIR) as $eachDir)
    {
      $path = ltrim($this->dir . '/' . basename($eachDir), '/');
      $this->subDir[basename($eachDir)] = $path;
    }
  }

  private function setFiles()
  {
    // Image formats without case sensitivity
    $jpg = '[jJ][pP][gG]';
    $jpeg = '[jJ][pP][eE][gG]';
    $png = '[pP][nN][gG]';
    $gif = '[gG][iI][fF]';
    $tiff = '[tT][iI][fF][fF]';
    $mp4 = '[mM][pP]4';
    $webm = '[wW][eE][bB][mM]';
    $ogg = '[oO][gG][gG]';
    // Video formats without case sensitivity

    foreach (glob(ARCHIVE_MAIN . $this->dir . '/*.{' . $jpg . ',' . $jpeg . ',' . $png . ',' . $gif . ',' .
      $tiff . ',' . $mp4 . ',' . $webm . ',' . $ogg . '}', GLOB_BRACE) as $eachFile)
    {
      $this->files[basename($eachFile)] = ARCHIVE_MAIN . $this->dir . '/' . str_replace(' ', '%20', basename($eachFile));
    }
  }

  private function setNotes()
  {
    // Case insensitive txt String
    $txt = '[tT][xX][tT]';

    foreach (glob(ARCHIVE_MAIN . $this->dir . '/*.[tT][xX][tT]', GLOB_BRACE) as $eachFile)
    {
      $this->notes[basename($eachFile)] = ARCHIVE_MAIN . $this->dir . '/' . str_replace(' ', '%20', basename($eachFile));
    }
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
    return $this->files;
  }

  /**
   * Returns the notes Array
   * @return Array[name,path] Array of notes name/path pairs
   */
  function getNotes()
  {
    return $this->notes;
  }

  /**
   * Returns the number of files within the dir
   * @return int
   */
  function getFileCount()
  {
    return count($this->files);
  }

}
