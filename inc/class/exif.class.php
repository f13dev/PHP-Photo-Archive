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
    return $this->getExposureTime . 'sec ' . $this->getAperture . ' ISO' . $this->getISOSpeed;
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

  function getWidth() {
    if (@array_key_exists('Width', $this->ifd0['COMPUTED'])) {
      return $this->ifd0['COMPUTED']['ApertureFNumber'];
    }
  }

  function toString() {
    $string = '';
    if (trim($this->getCamera() != '')) {
      $string .= $this->getCamera() . ' ';
    }
    if (trim($this->getCameraSettings != '')) {
      $string .= '(' . $this->getCameraSettings() . ') ';
    }
    if (trim($this->getDate() != '')) {
      $string .= $this->getDate() . ' ';
    }
    return $string;
  }
}
