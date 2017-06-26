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
      if (GD_THUMBS) {
        $this->createThumbGD($anImage, $thumb);
      }
      else {
        $this->createThumbMagik($anImage, $thumb);
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

  private function createThumbMagik($anImage, $thumb)
  {
    // Add slashes to spaces in filename
    $anImage = str_replace(' ', '\ ', $anImage);
    $thumb = str_replace(' ', '\ ', $thumb);
    // Attempt to create the thumb
    shell_exec('convert ' . $anImage . ' -resize ' . THUMB_MAX_WIDTH * 1.5 . 'x' . THUMB_MAX_HEIGHT * 1.5 . ' ' . $thumb . ' && chmod 0777 ' . $thumb);
  }

  private function createThumbGD($anImage, $thumb)
  {
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
    $thumbnail_aspect_ratio = THUMB_MAX_WIDTH / THUMB_MAX_HEIGHT;
    if ($source_image_width <= THUMB_MAX_WIDTH && $source_image_height <= THUMB_MAX_HEIGHT) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) (THUMB_MAX_HEIGHT * $source_aspect_ratio);
        $thumbnail_image_height = THUMB_MAX_HEIGHT;
    } else {
        $thumbnail_image_width = THUMB_MAX_WIDTH;
        $thumbnail_image_height = (int) (THUMB_MAX_WIDTH / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
    imagejpeg($thumbnail_gd_image, $thumb, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
  }

  /**
   * [createThumbDirectory description]
   * @param  [type] $aDirectory [description]
   * @return [type]             [description]
   */
  function createThumbDir($aDirectory)
  {
    // Enclosed in quotes to allow unix to recognise spaces
    $thumbDir = '"' . ARCHIVE_THUMBS . $aDirectory . '"';
    // Check if the thumbs dir exists
    if (!file_exists($thumbDir)) {
      shell_exec('mkdir -m 777 ' . $thumbDir);
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
