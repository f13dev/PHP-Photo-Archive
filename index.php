<?php
// Load the settings file
require_once('inc/settings.php');
require_once('inc/class/dir.class.php');

// Get the dir to view
if (isset($_GET['dir']))
{
  $dir = $_GET['dir'];
}
else
{
  $dir = '';
}

$theDir = New Dir($dir);

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
</head>
<body>
  <header>
    <h1>Photo archive</h1>
    <div class="right">
      Viewing: /<?php // Get image path ?><br />
      <?php // get number of files ?> files
    </div>
  </header>
  <section id="fileManager">

  </section>
  <section id="imageBrowser">

  </section>
  <footer>
    <div class="center">
      Copyright &copy; <?php // get copyright holder ?> (<?php echo date("Y"); ?>) - Powered by: <a href="http://f13dev.com">PHP Photo Archive</a>
    </div>
  </footer>
</body>
</html>
