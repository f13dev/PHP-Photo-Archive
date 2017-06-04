<?php
class FileUtility
{

  /**
   * Creates a thumbnail from an image
   * @param  String $anImage The path of an image
   * @return Bool   Created successfully
   */
  function createThumb($anImage)
  {
    $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $anImage);
    if (!file_exists($thumb))
    {
      // Attempt to create the thumb
      shell_exec('convert ' . $anImage . ' -resize ' . THUMB_MAX_WIDTH * 1.5 . 'x' . THUMB_MAX_HEIGHT * 1.5 . ' ' . $thumb);
      // Check if the thumb exists and return as appropriate
      if (file_exists($thumb))
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return null;
    }
  }

  /**
   * [createThumbDirectory description]
   * @param  [type] $aDirectory [description]
   * @return [type]             [description]
   */
  function createThumbDir($aDirectory)
  {
    $thumbDir = ARCHIVE_THUMBS . $aDirectory;
    // Check if the thumbs dir exists
    if (!file_exists($thumbDir)) {
      mkdir($thumbDir, 0777, true);
      // Check if the thumb dir exists and return appropriate
      if (file_exists($thumbDir))
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return null;
    }

  }

  function getExtension($aFile)
  {
    $ext = explode('.', $aFile);
    return strtolower(end($ext));
  }
}
