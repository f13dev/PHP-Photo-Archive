<?php
// Requre settings
require_once('inc/settings.php');
if (!ENABLE_EDIT) {
  echo LANG_EDIT_DISABLED;
  exit();
}
// Check file has been set
if (isset($_GET['file'])) {
  $file = $_GET['file'];
} else {
  echo LANG_NO_FILE;
  exit();
}
if (isset($_GET['comment'])) {
  $comment = $_GET['comment'];
} else {
  $comment = '';
}
// Check file exists
if (!file_exists($file)) {
  echo LANG_FILE_NOT_FOUND;
  exit();
}
if (file_exists(str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $file))) {
  $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $file);
} else {
  $thumb = $file;
}

// Require lang file
require_once('inc/lang/' . SITE_LANG . '.lang.php');
// Require exif class
require_once('inc/class/exif.class.php');
// Set up exif object
$exif = new Exif();

?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo LANG_EDIT . ': ' . $file; ?></title>
  <style type="text/css">
    body {
      background-color: black;
      color: white;
    }
    img {
      display: block;
      margin: auto;
      padding: 1em;
    }
    input[type="text"] {
      width: 100%;
      padding: 0.5em;
      font-size: 1.2em;
      box-sizing: border-box;
      border-radius: 0.4em;
    }
    button {
      font-size: 1.2em;
      margin-top:0.4em;
      margin-right: 0.4em;
    }
    span {
      display: block;
      font-size: 1.2em;
      margin-bottom: 0,4em;
    }
  </style>
</head>
<body>
  <?php

   ?>
<img src="<?php echo $thumb; ?>" style="max-width:<?php echo THUMB_MAX_WIDTH *2; ?>px; max-height:<?php echo THUMB_MAX_HEIGHT *2; ?>px;">
<?php
if (isset($_GET['comment'])) {
  $exif->setFile($file);
  $shellFile = str_replace(' ', '\ ', $file);
  shell_exec('convert ' . $shellFile . ' -set comment "' . $comment . '" ' . $shellFile);
  $exif->setFile($file);
  if ($exif->getComment() == $comment) {
    echo '<span>' . LANG_UPDATE_SUCCESS . '</span>';
  }
  else {
    echo '<span>' . LANG_UPDATE_FAIL . '</span>';
  }
}
$exif->setFile($file);
?>
<form action="edit.php">
  <input type="hidden" name="file" value="<?php echo $file; ?>">
  <input type="text" name="comment" value="<?php echo $exif->getComment(); ?>">
  <button type="submit" value="Submit"><?php echo LANG_SUBMIT; ?></button><button type="button" onclick="window.close();"><?php echo LANG_CLOSE; ?></button>
</form>

</body>
</html>
