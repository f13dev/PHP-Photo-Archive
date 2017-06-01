<?php
// Load the settings file
require_once('inc/settings.php');
require_once('inc/class/dir.class.php');

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
  <script src="//cdnjs.cloudflare.com/ajax/libs/detect_swipe/2.1.1/jquery.detect_swipe.min.js"></script>
</head>
<body>
  <header>
    <h1>Photo archive</h1>
    <div class="right">
      Viewing: /<?php echo $dir ?><br />
      <?php // get number of files ?> files
    </div>
  </header>
  <section id="fileManager">
    <?php
    if ($theDir->getDir() != null)
    {
      echo '<a href="?dir=' . $theDir->getParentDir() . '">Parent</a>';
    }

    foreach ($theDir->getSubDir() as $key => $value)
    {
      echo '<a href="?dir=' . $value . '">' . $key . '</a>';
    }

    print_r($theDir->getSubDir());

    echo '<br /><br />';

    foreach ($theDir->getFiles() as $key => $value)
    {
      echo '<a href="' . $value . '" data-featherlight class="gallery">
        <img src="' . $value . '" class="thumb" />' . $key . '
      </a>';
    }

    print_r($theDir->getFiles());
    ?>
  </section>
  <section id="imageBrowser">

  </section>
  <footer>
    <div class="center">
      Copyright &copy; <?php // get copyright holder ?> (<?php echo date("Y"); ?>) - Powered by: <a href="http://f13dev.com">PHP Photo Archive</a>
    </div>
  </footer>
  <!-- Load featherlight js -->
  <script src="//code.jquery.com/jquery-latest.js"></script>
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
  </script>
</body>
</html>
