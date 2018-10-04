<?php
// Load the settings file
require_once('inc/settings.php');
// Load utility classes
require_once('inc/class/dir.class.php');
require_once('inc/class/fileUtility.class.php');
require_once('inc/class/exif.class.php');
// Load the language file
require_once('inc/lang/' . SITE_LANG . '.lang.php');

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
  echo LANG_DIR_NOT_FOUND;
  exit();
}

// Create instances of utility classes
$fileUtility = new FileUtility();
$exif = new Exif();

$fileCount = $theDir->getFileCount(); // Get the number of files
$numPages = ceil($fileCount / FILES_PER_PAGE); // Get the number of pages
$start = $page * FILES_PER_PAGE - FILES_PER_PAGE; // Set the start file
$end = $page * FILES_PER_PAGE; // Set the end file
if ($end > $fileCount) { $end = $fileCount; } // Check end file is not more than number of files
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $_GET['dir']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Load stylesheets -->
  <link rel="stylesheet" href="skin/<?php echo CSS_MAIN; ?>">
  <link rel="stylesheet" href="skin/<?php echo CSS_MOBILE; ?>">
  <!-- Load colorbox -->
  <link rel="stylesheet" href="inc/colorbox/colorbox.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="inc/colorbox/jquery.colorbox.js"></script>
  <script>
    function editpopup(url) {
      newwindow=window.open(url,'Edit','height=500,width=500');
      if (window.focus) {newwindow.focus()}
      return false;
    }
    $(document).ready(function(){
      //Set up colorbox
      $(".gallery").colorbox({rel:'gallery',maxWidth:'95%',maxHeight:'95%',title: function(){
        var url = $(this).attr('orig-file');
        var title = $(this).attr('title');
        <?php if (ENABLE_EDIT) { ?>
        var edit = '<a href="edit.php?file=' + url + '" onclick="return editpopup(\'edit.php?file=' + url + '\')" title="<?php echo LANG_EDIT; ?>">' +
          '<img src="inc/images/edit.png">' +
          '</a>';
        <?php } else { ?>
        var edit = '';
        <?php } ?>
        return '<a download href="' + url + '" target="_blank" title="<?php echo LANG_DOWNLOAD; ?>">' +
          '<img src="inc/images/download.png">' +
        '</a> ' +
        edit +

        title
        ;
      }});
      $(".iframe").colorbox({rel:'gallery',iframe:true, width:"95%", height:"95%", title: function(){
        var url = $(this).attr('orig-file');
        var title = $(this).attr('title');
        return '<a download href="' + url + '" target="_blank">' +
          '<img src="inc/images/download.png" title="<?php echo LANG_DOWNLOAD; ?>">' +
        '</a> ' +
        title;
      }});
      $(".ajax").colorbox({width:'90%', height:'90%'});
    });
  </script>
</head>
<body>
  <header>
    <h1><a href="?dir="><?php echo SITE_TITLE; ?></a></h1>
    <div class="right">
      <?php echo LANG_VIEWING; ?>: /<?php echo $dir ?><br />
      <?php echo LANG_FILES; ?>:
      <?php
      if ($fileCount > FILES_PER_PAGE)
      {
        echo ($start + 1) . ' ' . LANG_TO . ' ' . $end . ' ' . LANG_OF . ' ';
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
            <div class="icon upDir fixed">
            </div>
            <span>' . LANG_PARENT . '</span>
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
              <div class="icon prevPage fixed">
              </div>
              <span>' . LANG_PREV . '</span>
            </div>
          </a>';
        }

        if ($page < $numPages)
        {
          echo '
          <a href="?dir=' . $theDir->getDir() . '&page=' . ($page + 1) . '">
            <div class="item">
              <div class="icon nextPage fixed">
              </div>
              <span>' . LANG_NEXT . '</span>
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
            <div class="icon subDir fixed">
            </div>
            <span>' . $key . '</span>
          </div>
        </a>';
      }

      // Show text file links
      foreach ($theDir->getNotes() as $key => $value)
      {
        $value = str_replace(" ","+",$value);
        echo '
        <a href="inc/notes.php?file=' . $value . '" class="ajax">
          <div class="item" caption="' . $key . '">
            <div class="icon notes fixed">
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
          if ($fileUtility->createThumbDir($theDir->getDir(), 'thumb'))
          {
            $thumbsDirExists = true;
          }
          else
          {
            $thumbsDirExists = false;
          }

          // Check if mid files are to be created
          if (CREATE_THUMBS_ON_LOAD && ENABLE_MID_IMAGES) {
            if ($fileUtility->createThumbDir($theDir->getDir(), 'mid')) {
              $midDirExists = true;
            }
            else
            {
              $midDirExists = false;
            }
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
                $fileUtility->createThumb($value, 'thumb');
              }

              if (CREATE_THUMBS_ON_LOAD && ENABLE_MID_IMAGES && ($midDirExists || $midDirExists == null)) {
                $fileUtility->createThumb($value, 'mid');
              }

              $thumb = str_replace(ARCHIVE_MAIN, ARCHIVE_THUMBS, $value);
              $mid = str_replace(ARCHIVE_MAIN, ARCHIVE_MID, $value);

              // If thumb doesn't exist, use full image
              if (!file_exists($thumb)) {
                $thumb = $value;
              }
              // If mid doesn't exists, use full image
              if (!file_exists($mid) && ENABLE_MID_IMAGES) {
                $mid = $value;
              }

              // Set the exif data
              $exif->setFile($value);

                echo '
                <a href="' . $mid . '" class="gallery" orig-file="' . $value . '" title=" ' . $exif->toString() . '">
                  <div class="item" caption="' . $key . '">
                    <div class="icon" style="background-image: url(' . str_replace(' ','\ ',$thumb) . ')">
                    </div>
                    <span>' . $key . '</span>
                  </div>
                </a>';
          }
          elseif ($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg')
          {
              $value = str_replace(" ","+",$value);
                echo '
                <a href="inc/video.php?file=' . $value . '&ext=' . $ext . '" class="iframe" orig-file="' . $value . '" title="' . $key . '" >
                  <div class="item" caption="' . $key . '">
                    <div class="icon video fixed"';
                      if ($fileUtility->thumbExistsVideo($value))
                      {
                        echo ' style="background-image: url(' . str_replace(' ','\ ',$fileUtility->getVideoThumbName($value)) . ')" ';
                      }
                    echo '>
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
      <?php echo LANG_COPYRIGHT; ?> &copy; <?php echo COPYRIGHT_HOLDER; ?> (<?php echo date("Y"); ?>) - <?php echo LANG_POWERED_BY; ?>: <a href="http://f13dev.com">PHP Photo Archive</a>
    </div>
  </footer>
</body>
</html>
