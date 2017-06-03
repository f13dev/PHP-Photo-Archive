<?php
// Load the settings file
require_once('inc/settings.php');
require_once('inc/class/dir.class.php');
require_once('inc/class/fileUtility.class.php');

// Get the dir to view
if (isset($_GET['dir'])) { $dir = $_GET['dir']; } else { $dir = ''; }

try
{
  $theDir = new Dir($dir);
}
catch (Exception $e)
{
  echo 'The requested directory could not be found!';
  exit();
}

$fileUtility = new FileUtility();

// Check if the dir exists
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Load stylesheets -->
  <link rel="stylesheet" href="skin/<?php echo CSS_MAIN; ?>">
  <link rel="stylesheet" href="skin/<?php echo CSS_MOBILE; ?>">
  <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.6/release/featherlight.min.css" type="text/css" rel="stylesheet" />
  <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.6/release/featherlight.gallery.min.css" type="text/css" rel="stylesheet" />
  <script src="//code.jquery.com/jquery-latest.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/detect_swipe/2.1.1/jquery.detect_swipe.min.js"></script>
</head>
<body>
  <header>
    <h1>Photo archive</h1>
    <div class="right">
      Viewing: /<?php echo $dir ?><br />
      files: <?php echo $theDir->getFileCount(); ?>
    </div>
  </header>
  <main>
    <section id="fileManager">
      <?php
      if ($theDir->getDir() != null)
      {
        echo '
        <a href="?dir=' . $theDir->getParentDir() . '">
          <div class="item">
            <div class="icon upDir">
            </div>
            <span>Parent</span>
          </div>
        </a>';
      }

      foreach ($theDir->getSubDir() as $key => $value)
      {
        echo '
        <a href="?dir=' . $value . '">
          <div class="item">
            <div class="icon subDir">
            </div>
            <span>' . $key . '</span>
          </div>
        </a>';
      }
      ?>
    </section>
    <section id="imageBrowser">
      <?php
      // Check if thumbs are to be created on load
      if (CREATE_THUMBS_ON_LOAD) {
        if ($fileUtility->createThumbDir($theDir->getDir()))
        {
          $thumbsDirExists = true;
        }
        else
        {
          $thumbsDirExists = false;
        }
      }

      foreach ($theDir->getFiles() as $key => $value)
      {
        $ext = $fileUtility->getExtension($value);
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'tiff')
        {

          // Process images
            if (CREATE_THUMBS_ON_LOAD && $thumbsDirExists)
            {
              $fileUtility->createThumb($value);
            }

            $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $value);

            // If thumb doesnt exist, use full image
            if (!file_exists($thumb)) {
              $thumb = $value;
            }
            echo '
            <a href="' . $value . '" data-featherlight class="gallery">
              <div class="item" caption="' . $key . '">
                <div class="icon" style="background-image: url(' . $thumb . ')">
                </div>
                <span>' . $key . '</span>
              </div>
            </a>';
        }
        elseif ($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg')
        {
            // deal with mp4
            echo '
            <a href="video.php?file=' . $value . '" data-featherlight class="gallery">
              <div class="item" caption="' . $key . '">
                <div class="icon video">
                </div>
                <span>' . $key . '</span>
              </div>
            </a>
            ';
        }
      }
      ?>
    </section>
  </main>
  <footer>
    <div class="center">
      Copyright &copy; <?php echo COPYRIGHT_HOLDER; ?> (<?php echo date("Y"); ?>) - Powered by: <a href="http://f13dev.com">PHP Photo Archive</a>
    </div>
  </footer>
  <!-- Load featherlight js -->
  <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.6/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.6/release/featherlight.gallery.min.js" type="text/javascript" charset="utf-8"></script>
  <script>
      $('.gallery').featherlightGallery({
        gallery: {
          fadeIn: 300,
          fadeOut: 300
        },
        openSpeed:    300,
        closeSpeed:   300
      });

      // Add caption via > div caption attribute
      $.featherlightGallery.prototype.afterContent = function() {
        var caption = this.$currentTarget.find('div').attr('caption');
        this.$instance.find('.caption').remove();
        $('<div class="caption">').text(caption).appendTo(this.$instance.find('.featherlight-content'));
      };
  </script>
</body>
</html>
