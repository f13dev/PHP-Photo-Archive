<?php
class FileUtility
{

  /**
   * Checks if a thumnail exists for an image
   * @param String $anImage The path of an image
   * @return Bool Thumb exists
   */
  function thumbExists($anImage, $size)
  {
    if ($size != 'thumb' && $size != 'mid') return false;
    if ($size == 'thumb') $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $anImage);
    if ($size == 'mid') $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_MID, $anImage);
    if (file_exists($thumb)) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Creates a thumbnail from an image
   * @param  String $anImage The path of an image
   * @return Bool   Created successfully
   */
  function createThumb($anImage, $size)
  {
    if ($size != 'thumb' && $size != 'mid') return false;
    if (!$this->thumbExists($anImage, $size))
    {
      // Set thumb dir
      if ($size == 'thumb') {
        $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $anImage);
      }
      else {
        $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_MID, $anImage);
      }
      if (GD_THUMBS) {
        $this->createThumbGD($anImage, $thumb, $size);
      }
      else {
        $this->createThumbMagik($anImage, $thumb, $size);
      }
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

  private function createThumbMagik($anImage, $thumb, $size)
  {
    if ($size != 'thumb' && $size != 'mid') return false;
    if ($size == 'thumb') {
      $max_width = THUMB_MAX_WIDTH;
      $max_height = THUMB_MAX_HEIGHT;
    }
    else {
      $max_width = IMG_MAX_WIDTH;
      $max_height = IMG_MAX_HEIGHT;
    }
    // Add slashes to spaces in filename
    $anImage = str_replace(' ', '\ ', $anImage);
    $thumb = str_replace(' ', '\ ', $thumb);
    // Attempt to create the thumb
    shell_exec('convert -quality 70 ' . $anImage . ' -resize ' . $max_width . 'x' . $max_height . ' ' . $thumb . ' && chmod 0777 ' . $thumb);
  }

  private function createThumbGD($anImage, $thumb, $size)
  {
    if ($size != 'thumb' && $size != 'mid') return false;
    if ($size == 'thumb') {
      $max_width = THUMB_MAX_WIDTH;
      $max_height = THUMB_MAX_HEIGHT;
    }
    else {
      $max_width = IMG_MAX_WIDTH;
      $max_height = IMG_MAX_HEIGHT;
    }
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($anImage);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($anImage);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($anImage);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($anImage);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $max_width / $max_height;
    if ($source_image_width <= $max_width && $source_image_height <= $max_height) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) ($max_height * $source_aspect_ratio);
        $thumbnail_image_height = $max_height;
    } else {
        $thumbnail_image_width = $max_width;
        $thumbnail_image_height = (int) ($max_width / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
    imagejpeg($thumbnail_gd_image, $thumb, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
  }

  /**
   * Checks to see if a thumb dir exists for the given gallery dir
   * @param String $aDirectory
   * @return Bool The directory exitst
   */
  function thumbDirExists($aDirectory, $size)
  {
    if ($size == 'thumb') $size = ARCHIVE_THUMBS;
    if ($size == 'mid') $size = ARCHIVE_MID;
    if ($size == '') return false;
    $thumbDir = $size . $aDirectory;
    if (file_exists("'$thumbDir'")) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * [createThumbDirectory description]
   * @param  [type] $aDirectory [description]
   * @return [type]             [description]
   */
  function createThumbDir($aDirectory, $size)
  {
    // Exit returning false if $size isn't a valid option
    if ($size != 'thumb' && $size != 'mid') return false;
    // Set $size to the appropriate folder
    if ($size == 'thumb') $size = ARCHIVE_THUMBS;
    if ($size == 'mid') $size = ARCHIVE_MID;
    // Enclosed in quotes to allow unix to recognise spaces
    // Check if the thumbs dir exists
    if (!$this->thumbDirExists($aDirectory, $size)) {
      $thumbDir = $size . $aDirectory;
      shell_exec("mkdir -m 777 '$thumbDir'");
      //mkdir($thumbDir, 0777, true);
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
