<?php
// Load the settings file
require_once('inc/settings.php');
require_once('inc/class/dir.class.php');
require_once('inc/class/fileUtility.class.php');

// Get the dir to view
if (isset($_GET['dir'])) { $dir = $_GET['dir']; } else { $dir = ''; }
// Get the page to view
if (isset($_GET['page']) && ctype_digit($_GET['page'])) { $page = $_GET['page']; } else { $page = 1; }

// Check that the directory exists
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

$fileCount = $theDir->getFileCount(); // Get the number of files
$numPages = ceil($fileCount / FILES_PER_PAGE); // Get the number of pages
$start = $page * FILES_PER_PAGE - FILES_PER_PAGE; // Set the start file
$end = $page * FILES_PER_PAGE; // Set the end file
if ($end > $fileCount) { $end = $fileCount; } // Check end file is not more than number of files
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Load stylesheets -->
  <link rel="stylesheet" href="skin/<?php echo CSS_MAIN; ?>">
  <link rel="stylesheet" href="skin/<?php echo CSS_MOBILE; ?>">
  <link  href="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" rel="stylesheet">

  <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>


</head>
<body>
  <header>
    <h1>Photo archive</h1>
    <div class="right">
      Viewing: /<?php echo $dir ?><br />
      files:
      <?php
      if ($fileCount > FILES_PER_PAGE)
      {
        echo ($start + 1) . ' to ' . $end . ' of ';
      }
      echo $fileCount;
      ?>
    </div>
  </header>
  <main>
    <section id="fileManager">
      <?php
      // Show the parent dir button if needed
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

      if ($fileCount > FILES_PER_PAGE)
      {
        if ($page > 1)
        {
          echo '
          <a href="?dir=' . $theDir->getDir() . '&page=' . ($page - 1) . '">
            <div class="item">
              <div class="icon prevPage">
              </div>
              <span>Previous Page</span>
            </div>
          </a>';
        }

        if ($page < $numPages)
        {
          echo '
          <a href="?dir=' . $theDir->getDir() . '&page=' . ($page + 1) . '">
            <div class="item">
              <div class="icon nextPage">
              </div>
              <span>Next Page</span>
            </div>
          </a>';
        }
      }

      // Show sub dir buttons
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

      // Show text file links
      foreach ($theDir->getNotes() as $key => $value)
      {
        echo '
        <a href="inc/notes.php?file=' . $value . '" data-fancybox data-type="ajax">
          <div class="item" caption="' . $key . '">
            <div class="icon notes">
            </div>
            <span>' . $key . '</span>
          </div>
        </a>
        ';

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


      foreach (array_slice($theDir->getFiles(), $start, FILES_PER_PAGE) as $key => $value)
      {
        $ext = $fileUtility->getExtension($value);
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'tiff')
        {

          // Process images
            if (CREATE_THUMBS_ON_LOAD && ($thumbsDirExists || $thumbsDirExists == null))
            {
              $fileUtility->createThumb($value);
            }

            $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $value);

            // If thumb doesnt exist, use full image
            if (!file_exists($thumb)) {
              $thumb = $value;
            }
            echo '
            <a href="' . $value . '" data-fancybox="gallery" data-caption="' . $key . '">
              <div class="item" caption="' . $key . '">
                <div class="icon" style="background-image: url(' . str_replace(' ','\ ',$thumb) . ')">
                </div>
                <span>' . $key . '</span>
              </div>
            </a>';
        }
        elseif ($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg')
        {
            // deal with mp4
            echo '
            <a href="inc/video.php?file=' . $value . '" data-fancybox="gallery" data-type="iframe" data-caption="' . $key . '">
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
  <script>
  $( '[data-fancybox]' ).fancybox({
  	onInit : function( instance ) {
  		instance.$refs.downloadButton = $('<a class="fancybox-button fancybox-download" title="Download" download></a>')
  			.appendTo( instance.$refs.buttons );
  	},
  	beforeMove: function( instance, current ) {
  		instance.$refs.downloadButton.attr('href', current.src);
  	}
  });

  $("[data-fancybox]").fancybox({
      iframe : {
          css : {
              width  : '90%',
              height : '90%'
          }
      }
  });

  </script>
  <footer>
    <div class="center">
      Copyright &copy; <?php echo COPYRIGHT_HOLDER; ?> (<?php echo date("Y"); ?>) - Powered by: <a href="http://f13dev.com">PHP Photo Archive</a>
    </div>
  </footer>
</body>
</html>
