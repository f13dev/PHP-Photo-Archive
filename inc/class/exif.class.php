<?php
class Exif
{
  private $file;
  private $ifd0;
  private $exif;

  function setFile($aFile) {
    $this->file = $aFile;
    $this->ifd0 = exif_read_data($aFile, 'IFD0');
    $this->exif = exif_read_data($aFile, 'EXIF');
  }

  function getMake() {
    if (@array_key_exists('Make', $this->ifd0)) {
      return $this->ifd0['Make'];
    }
  }

  function getModel() {
    if (@array_key_exists('Model', $this->ifd0)) {
      return $this->ifd0['Model'];
    }
  }

  function getCamera() {
    return $this->getmake() . ' ' . $this->getModel();
  }

  function getExposureTime() {
    if (@array_key_exists('ExposureTime', $this->ifd0)) {
      return $this->ifd0['ExposureTime'];
    }
  }

  function getAperture() {
    if (@array_key_exists('ApertureFNumber', $this->ifd0['COMPUTED'])) {
      return $this->ifd0['COMPUTED']['ApertureFNumber'];
    }
  }

  function getISOSpeed() {
    if (@array_key_exists('ISOSpeedRatings', $this->exif)) {
      return $this->exif['ISOSpeedRatings'];
    }
  }

  function getCameraSettings() {
    $settings = '';
    if ($this->getExposureTime() != '') {
      $settings .= $this->getExposureTime() . 'sec ';
    }
    if ($this->getAperture() != '') {
      $settings .= $this->getAperture() . ' ';
    }
    if ($this->getISOSpeed() != '') {
      $settings .= 'ISO' . $this->getISOSpeed();
    }
    return $settings;
  }

  function getDate() {
    if (@array_key_exists('DateTime', $this->ifd0)) {
      return $this->ifd0['DateTime'];
    }
  }

  function getComment() {
    if (@array_key_exists('0', $this->exif['COMMENT'])) {
      return $this->exif['COMMENT'][0];
    }
  }

  function get() {
    if (@array_key_exists('Width', $this->ifd0['COMPUTED'])) {
      return $this->ifd0['COMPUTED']['ApertureFNumber'];
    }
  }

  function getDimensions() {
    list($width, $height, $type, $attr) = getimagesize($this->file);
    $mp = round(($width * $height) / 1000000, 1);
    $dimensions = array(
      "width" => $width,
      "height" => $height,
      "mp" => $mp
    );
    return $dimensions;
  }

  function getFileName() {
    $file = explode('/', $this->file);
    return end($file);
  }

  function toString() {
    // Create an empty string
    $string .= '';
    // Add the comment if it exists
    if (trim($this->getComment() != '')) {
      $string .= $this->getComment() . ' - ';
    }
    // Add the file name
    $string .= $this->getFileName() . ' ';
    $string .= '<br>';
    // Add the camera info if it exists
    if (trim($this->getCamera() != '')) {
      $string .= $this->getCamera() . ' - ';
    }
    // Add the camera settings if it exists
    if (trim($this->getCameraSettings() != '')) {
      $string .= $this->getCameraSettings() . ' - ';
    }
    // Add the image pixel count
    $string .= $this->getDimensions()['mp'] . 'megapixels - ';
    // Add the date and time if it exists
    if (trim($this->getDate() != '')) {
      $string .= $this->getDate() . ' ';
    }
    return $string;
  }
}
